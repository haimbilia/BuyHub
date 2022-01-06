function setSiteDefaultLang(langId) {
    fcom.updateWithAjax(
        fcom.makeUrl("Home", "setLanguage", [langId]),
        "",
        function (res) {
            document.location.reload();
        }
    );
}

function getNotifications(type, obj) {

    $("#notificationList").prepend(fcom.getLoader());
    let url = fcom.makeUrl("Notifications", "notificationList");
    let viewAllUrl = fcom.makeUrl("Notifications");
    if (type == 1) {
        url = fcom.makeUrl("SystemLog", "notificationList");
        viewAllUrl = fcom.makeUrl("SystemLog");
    }
    if (typeof obj != undefined) {
        $(obj).siblings().removeClass('is-current');
        $(obj).addClass('is-current');
    }

    fcom.updateWithAjax(
        url,
        "",
        function (res) {
            $.ykmsg.close();
            fcom.removeLoader();
            $("#notificationList").html(res.html);
            $('#notifiLinkViewAll').attr('href', viewAllUrl);
            $('#notifiLinkCount').addClass('hide');
            if (type == 0) {
                $('#notifiLinkCount').removeClass('hide').text(res.notifyCount + " " + langLbl.unread);
            }
        }
    );
}

/* function getHelpCenterContent(controller, action = "") {
  fcom.ajax(
    fcom.makeUrl("HelpCenter", "getContent", [controller, action]),
    "",
    function (t) {
      var res = JSON.parse(t);
      if (0 == res.status) {
        return;
      }

            if (1 > $("#helpCenterJs").length) {
                $(".mainJs").after('<div id="helpCenterJs"></div>');
            }

      if ("undefined" != typeof res.html) {
        $("#helpCenterJs").html(res.html);
      }
    }
  );
} */




copyText = function (obj, applyToolTipInfo = true) {
    var title = $(obj).data("title");
    /*
      document.addEventListener('copy', function(e) {
          e.clipboardData.setData('text/plain', copyText);
          e.preventDefault();
      }, true);
      */

    if (!navigator.clipboard) {
        console.warn('clipboard API only works on localhost and https');
        // Clipboard API  only works on localhost anf https as per doc
        return;
    }
    try {
        navigator.clipboard.writeText(copyText);
        if (applyToolTipInfo) {
            tooltipCopyHelper(obj, title);
        }
    } catch (err) {
        console.error("Failed to copy!", err);
    }
};

tooltipCopyHelper = function (obj, title) {
    $(obj)
        .tooltip("hide")
        .attr("data-original-title", langLbl.copied + ": " + title)
        .tooltip("update")
        .tooltip("show");

    $(obj).mouseout(function () {
        $(obj)
            .tooltip("hide")
            .attr("data-original-title", langLbl.clickToCopy)
            .tooltip("update");
        $(obj).unbind("mouseout");
    });
};

redirectFn = function (href) {
    window.location = href;
};

var gCaptcha = false;
function googleCaptcha() {
    $("body").addClass("captcha");
    var inputObj = $("form input[name='g-recaptcha-response']");
    var submitBtn = inputObj.closest("form").find('input[type="submit"]');
    submitBtn.attr("disabled", "disabled");
    var checkToken = setInterval(function () {
        if (true === gCaptcha) {
            submitBtn.removeAttr("disabled");
            clearInterval(checkToken);
        }
    }, 500);

    /*Google reCaptcha V3  */
    setTimeout(function () {
        if (0 < inputObj.length && "undefined" !== typeof grecaptcha) {
            grecaptcha.ready(function () {
                grecaptcha
                    .execute(langLbl.captchaSiteKey, { action: inputObj.data("action") })
                    .then(function (token) {
                        inputObj.val(token);
                        gCaptcha = true;
                    });
            });
        } else if ("undefined" === typeof grecaptcha) {
            $.mbsmessage(langLbl.invalidGRecaptchaKeys, true, "alert--danger");
        }
    }, 200);
}

getSlugUrl = function (obj, str, extra, pos) {
    if (pos == undefined) pos = "pre";
    var str = str
        .toString()
        .toLowerCase()
        .replace(/\s+/g, "-") /* Replace spaces with - */
        .replace(/[^\w\-\/]+/g, "") /* Remove all non-word chars */
        .replace(/\-\-+/g, "-") /* Replace multiple - with single - */
        .replace(/^-+/, "") /* Trim - from start of text */
        .replace(/-+$/, "");
    if (extra && pos == "pre") {
        str = extra + "/" + str;
    }
    if (extra && pos == "post") {
        str = str + "/" + extra;
    }

    $(obj)
        .next()
        .html('<a target="_blank" href="' + SITE_ROOT_URL + str + '">' + SITE_ROOT_URL + str + '</a>');
};

Slugify = function (str, str_val_id, is_slugify) {
    var str = str
        .toString()
        .toLowerCase()
        .replace(/\s+/g, "-") /* Replace spaces with - */
        .replace(/[^\w\-]+/g, "") /* Remove all non-word chars */
        .replace(/\-\-+/g, "-") /* Replace multiple - with single - */
        .replace(/^-+/, "") /*  Trim - from start of text */
        .replace(/-+$/, "");
    if ($("#" + is_slugify).val() == 0) {
        $("#" + str_val_id).val(str);
    }
};

/*
expected response
{
  "results": [
    {
      "id": 1,
      "text": "Option 1"
    },
    {
      "id": 2,
      "text": "Option 2"
    }
  ],
  "pageCount" : 3 
}

postdata object| callback function like {record:1}
*/
select2 = function (
    elmId,
    url,
    postdata = {},
    callbackOnSelect = "",
    callbackOnUnSelect = "",
    processResultsCallback = "",
    data = [],
) {
    let ele = $("#" + elmId);
    if (1 > ele.length) {
        return false;
    }

    var obj = ele.closest('.modal').length ? ele.closest('.modal') : null;
    if (null === obj) {
        obj = ele.closest('.dropdown-menu').length ? ele.closest('.dropdown-menu') : null;
    }

    ele.select2({
        dropdownParent: obj,
        closeOnSelect: ele.data("closeOnSelect") || true,
        data: data,
        dir: layoutDirection,
        allowClear: ele.data("allowClear") || true,
        placeholder: ele.attr("placeholder") || "",
        ajax: {
            url: url,
            dataType: "json",
            delay: 250,
            method: "post",
            data: function (params) {
                return $.extend(
                    {
                        keyword: params.term, // search term
                        page: params.page,
                        fIsAjax: 1,
                    },
                    ("function" == typeof postdata ? postdata(ele) : postdata)
                );
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                data.pageCount = data.pageCount || 1;
                if ("function" == typeof processResultsCallback) {
                    return processResultsCallback(data, params, ele);
                }
                return {
                    results: data.results,
                    pagination: {
                        more: params.page < data.pageCount,
                    },
                };
            },
            cache: true,
        },
        minimumInputLength: 0,
        dropdownPosition: "below",
    })
        .on("select2:selecting", function (e) {
            if ("function" == typeof callbackOnSelect) {
                callbackOnSelect(e);
            }
        })
        .on("select2:unselecting", function (e) {
            if ("function" == typeof callbackOnUnSelect) {
                callbackOnUnSelect(e);
            }
        });

    var select2Selector = ele.data("select2");
    var elementName = ele.attr('name').replace('[]', '');
    if ('undefined' != typeof (select2Selector.dropdown)) {
        $(select2Selector.dropdown.$search).attr('name', elementName + '-select2');
    }

    if ('undefined' != typeof (select2Selector.selection)) {
        $(select2Selector.selection.$search).attr('name', elementName + '-select2');
    }
    if (0 < ele.closest(".advancedSearchJs").length) {
        select2Selector.$container.addClass("w-100");
    }

    if (0 < ele.closest(".form-group").length) {
        select2Selector.$container.addClass("w-100");
    }
    select2Selector.$container.addClass("custom-select2");
    $("." + $.ykmodal.element).removeAttr("tabindex");
};
/**
 * hiddenfields object = { fieldname : fieldValue}
 */
redirectUser = function (id, extraData = {}) {
    if (0 < id) {
        extraData['user_id'] = id;
    }
    redirectfunc(fcom.makeUrl('Users'), extraData, 0, true);
};

redirectToShop = function (id, extraData = {}) {
    if (0 < id) {
        extraData['shop_id'] = id;
    }
    redirectfunc(fcom.makeUrl('Shops'), extraData, 0, true);
};

redirectToProduct = function (id, extraData = {}) {
    if (0 < id) {
        extraData['product_id'] = id;
    }
    redirectfunc(fcom.makeUrl('Products'), extraData, 0, true);
};

redirectToSellerProduct = function (id, extraData = {}) {
    if (0 < id) {
        extraData['selprod_id'] = id;
    }
    redirectfunc(fcom.makeUrl('SellerProducts'), extraData, 0, true);
};

redirectToShopReport = function (id, extraData = {}) {
    if (0 < id) {
        extraData['shop_id'] = id;
    }
    redirectfunc(fcom.makeUrl('ShopsReport'), extraData, 0, true);
};

redirectToProductReviews = function (id, extraData = {}) {
    if (0 < id) {
        extraData['reviewed_for_id'] = id;
    }
    redirectfunc(fcom.makeUrl('ProductReviews'), extraData, 0, true);
};

redirectfunc = function (url, hiddenfields = {}, nid, newTab) {
    newTab = typeof newTab != "undefined" ? newTab : true;
    if (nid > 0) {
        fcom.displayProcessing();
        markRead(nid, url, id);
    } else {
        var target = newTab ? ' target="_blank" ' : " ";
        let inputs = "";
        $.each(hiddenfields, function (index, value) {
            inputs += '<input type="hidden" name="' + index + '" value="' + value + '">';
        });
        $("<form" + target + 'action="' + url + '" method="POST">' + inputs + "</form>").appendTo($(document.body)).submit();
    }
};

markRead = function (nid, url, id) {
    if (nid.length < 1) {
        return false;
    }
    var data = "record_ids=" + nid + "&status=" + 1 + "&markread=1";
    fcom.updateWithAjax(
        fcom.makeUrl("Notifications", "changeStatus"),
        data,
        function (t) {
            var form = '<input type="hidden" name="id" value="' + id + '">';
            $('<form action="' + url + '" method="POST">' + form + "</form>")
                .appendTo($(document.body))
                .submit();
        }
    );
};

markNavActive = function (ele) {
    ele.addClass("active");
    var menuLink = ele.parents("li:not(.hasNestedChildJs)").find(".menuLinkJs");
    menuLink.addClass("active");
    var target = menuLink.data('bsTarget');
    $(target).addClass('show');
    ele.parents("li.hasNestedChildJs").find(".collapseJs").addClass("show");
};

$(document).ready(function () {
    /* Active Sidebar Link. */
    var uri = window.location.pathname.replace(/^\/|\/$/g, "");

    $(".sidebarMenuJs .navLinkJs").each(function () {
        var attr = $(this).attr("href");
        var href = '';
        if (typeof attr !== 'undefined' && attr !== false) {
            var href = attr.replace(/^\/|\/$/g, "");
        }

        if (uri == href) {
            markNavActive($(this));
        } else {
            var selectors = $(this).data("selector");
            if ('undefined' != typeof selectors && -1 != jQuery.inArray(controllerName, selectors)) {
                markNavActive($(this));
            }
        }
    });
    /* Active Sidebar Link. */

    /* alert-text close */
    $(".closeAlertJs").on("click", function () {
        $.cookie($(this).attr("data-name"), true);
    });
    /* alert-text close */

    $(".openAlertJs").on("click", function () {
        if ($(".mainHeaderJs").find(".closeAlertJs").length == 0) {
            $.removeCookie($(this).attr("data-name"));
            data = "id=" + $(this).attr("data-pageid");
            fcom.updateWithAjax(
                fcom.makeUrl("PageLanguageData", "displayAlert"),
                data,
                function (t) {
                    $(".mainHeaderJs").append(t.html);
                }
            );
        } else {
            $(".alertWarningJs").remove();
        }
    });

    $('.dropdown-menu').on('click', function (e) {
        e.stopPropagation();
    });

    /* Sidebar menu open on hover. */
    /* $(".dropdownJs").on({
          mouseenter: function () {
              $(this).addClass("show");
              $(this).find('.sidebar-dropdown-menu').addClass('show');
          },
          mouseleave: function () {
              $(this).removeClass("show");
              $(this).find('.sidebar-dropdown-menu').removeClass('show');
          }
      });*/
});
