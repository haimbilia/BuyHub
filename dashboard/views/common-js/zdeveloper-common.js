$(document).ready(function () {
    setTimeout(function () {
        $("body").addClass("loaded");
        if (0 < $("#scrollElement-js").length && 0 < $(".menu__item.is-active").length) {
            var el = new SimpleBar(document.getElementById("scrollElement-js"));
            let scrollElement = el.getScrollElement();
            scrollElement.scrollTop = $(".menu__item.is-active").position().top - ($(window).height() / 2 - 100)
        }
        stylePhoneNumberFld(".phone-js");
    }, 1000);
    $(document).on("click", ".selectItem--js", function () {
        if ($(this).prop("checked") == false) {
            $(".selectAll-js").prop("checked", false);
            $(this).closest("tr").removeClass("selected-row")
        } else {
            $(this).closest("tr").addClass("selected-row")
        }
        if ($(".selectItem--js").length == $(".selectItem--js:checked").length) {
            $(".selectAll-js").prop("checked", true)
        }
        showFormActionsBtns()
    });
    if (0 < $(".js-widget-scroll").length) {
        slickWidgetScroll()
    }
    $(document).on("click", ".accordianheader", function () {
        $(this).next(".accordianbody").slideToggle();
        $(this).parent().parent().siblings().children().children().next().slideUp();
        return false
    });
    if ("rtl" == langLbl.layoutDirection && 0 < $("[data-simplebar]").length && 1 > $("[data-simplebar-direction='rtl']").length) {
        $("[data-simplebar]").attr("data-simplebar-direction", "rtl")
    }
    $(document).on("keyup", "input.otpVal-js", function (e) {
        if ("" != $(this).val()) {
            $(this).removeClass("is-invalid")
        }
        var element = "";
        if (8 != e.which && "" != $(this).val()) {
            element = $(this).parents(".otpCol-js").nextAll()[0]
        } else {
            element = $(this).parents(".otpCol-js").prevAll()[0]
        }
        element = $(element).find("input.otpVal-js");
        if ("undefined" != typeof element) {
            element.focus()
        }
    })
});
installJsColor = function () {
    if (0 < $(".jscolor").length) {
        $(".jscolor").each(function () {
            $(this).attr("data-jscolor", "{}")
        });
        jscolor.install()
    }
};
installJsColor();
unlinkSlick = function () {
    $(".js-widget-scroll").slick("unslick")
};
slickWidgetScroll = function () {
    var slides = $(".widget-stats").length > 2 ? 3 : 2;
    $(".js-widget-scroll").slick(getSlickSliderSettings(slides, 1, langLbl.layoutDirection, false, {
        1199: 3,
        1023: 2,
        767: 1,
        480: 1,
    }))
};
invalidOtpField = function () {
    $("input.otpVal-js").val("").addClass("is-invalid").attr("onkeyup", "checkEmpty($(this))")
};
checkEmpty = function (element) {
    if ("" == element.val()) {
        element.addClass("is-invalid")
    }
};
var otpIntervalObj;
startOtpInterval = function (parent = "", callback = "", params = []) {
    if ("undefined" != typeof otpIntervalObj) {
        clearInterval(otpIntervalObj)
    }
    var parent = "" != parent ? parent + " " : "";
    var element = $(parent + ".intervalTimer-js");
    var counter = langLbl.otpInterval;
    element.parent().parent().show();
    element.text(counter);
    $(parent + ".getOtpBtnBlock--js").addClass("d-none");
    var resendOtpEle = $(parent + ".resendOtp-js");
    var onClickFn = resendOtpEle.attr("onclick");
    resendOtpEle.removeAttr("onclick");
    otpIntervalObj = setInterval(function () {
        counter--;
        if (counter === 0) {
            clearInterval(otpIntervalObj);
            resendOtpEle.attr("onclick", onClickFn).removeClass("disabled");
            element.parent().parent().hide();
            if ("" != callback && eval("typeof " + callback) == "function") {
                window[callback](params)
            }
        }
        element.text(counter)
    }, 1000)
};

function setCurrDateFordatePicker() {
    $(".start_date_js").datepicker("option", {
        minDate: new Date(),
    });
    $(".end_date_js").datepicker("option", {
        minDate: new Date(),
    })
}

function showFormActionsBtns() {
    if (typeof $(".selectItem--js:checked").val() === "undefined") {
        $(".formActionBtn-js").addClass("formActions-css")
    } else {
        $(".formActionBtn-js").removeClass("formActions-css")
    }
    var validateActionButtons = setInterval(function () {
        if (1 > $(".selectItem--js:checked").length) {
            $(".formActionBtn-js").addClass("formActions-css");
            clearInterval(validateActionButtons)
        }
        if ($(".formActionBtn-js").hasClass("formActions-css")) {
            clearInterval(validateActionButtons)
        }
    }, 1000)
}

function selectAll(obj) {
    $(".selectItem--js").each(function () {
        if (obj.prop("checked") == false) {
            $(this).prop("checked", false).closest("tr").removeClass("selected-row")
        } else {
            $(this).prop("checked", true).closest("tr").addClass("selected-row")
        }
    });
    showFormActionsBtns()
}

function formAction(frm, callback) {
    if (typeof $(".selectItem--js:checked").val() === "undefined") {
        $.mbsmessage(langLbl.atleastOneRecord, true, "alert--danger");
        return false
    }
    $.mbsmessage(langLbl.processing, true, "alert--process alert");
    data = fcom.frmData(frm);
    fcom.updateWithAjax(frm.action, data, function (resp) {
        callback()
    })
}

function initialize() {
    if (typeof google == "undefined") {
        return
    }
    geocoder = new google.maps.Geocoder()
}

function getCountryStates(countryId, stateId, dv) {
    fcom.ajax(fcom.makeUrl("GuestUser", "getStates", [countryId, stateId], siteConstants.webrootfront), "", function (res) {
        $(dv).empty();
        $(dv).append(res)
    })
}

function getStatesByCountryCode(countryCode, stateCode, dv, idCol = "state_id") {
    fcom.ajax(fcom.makeUrl("GuestUser", "getStatesByCountryCode", [countryCode, stateCode, idCol], siteConstants.webrootfront), "", function (res) {
        $(dv).empty();
        $(dv).append(res).change()
    })
}
viewWishList = function (selprod_id, dv, event, excludeWishList = 0) {
    event.stopPropagation();
    if ($(dv).next().hasClass("is-item-active")) {
        $(dv).next().toggleClass("open-menu");
        $(dv).parent().toggleClass("list-is-active");
        return
    }
    $(".collection-toggle").next().removeClass("is-item-active");
    if (isUserLogged() == 0) {
        loginPopUpBox();
        return false
    }
    $.facebox(function () {
        fcom.ajax(fcom.makeUrl("Account", "viewWishList", [selprod_id, excludeWishList]), "", function (ans) {
            fcom.updateFaceboxContent(ans);
            $("input[name=uwlist_title]").bind("focus", function (e) {
                e.stopPropagation()
            });
            activeFavList = selprod_id
        })
    });
    return false
};
toggleShopFavorite = function (shop_id) {
    if (isUserLogged() == 0) {
        loginPopUpBox();
        return false
    }
    var data = "shop_id=" + shop_id;
    fcom.updateWithAjax(fcom.makeUrl("Account", "toggleShopFavorite"), data, function (ans) {
        if (ans.status) {
            if (ans.action == "A") {
                $("#shop_" + shop_id).addClass("is-active");
                $("#shop_" + shop_id).prop("title", "Unfavorite Shop")
            } else if (ans.action == "R") {
                $("#shop_" + shop_id).removeClass("is-active");
                $("#shop_" + shop_id).prop("title", "Favorite Shop")
            }
        }
    })
};
setupWishList = function (frm, event) {
    if (!$(frm).validate()) return false;
    var data = fcom.frmData(frm);
    var selprod_id = $(frm).find('input[name="selprod_id"]').val();
    fcom.updateWithAjax(fcom.makeUrl("Account", "setupWishList"), data, function (ans) {
        if (ans.status) {
            fcom.ajax(fcom.makeUrl("Account", "viewWishList", [selprod_id]), "", function (ans) {
                $(".collection-ui-popup").html(ans);
                $("input[name=uwlist_title]").bind("focus", function (e) {
                    e.stopPropagation()
                })
            });
            if (ans.productIsInAnyList) {
                $("[data-id=" + selprod_id + "]").addClass("is-active")
            } else {
                $("[data-id=" + selprod_id + "]").removeClass("is-active")
            }
        }
    })
};
addRemoveWishListProduct = function (selprod_id, wish_list_id, event) {
    event.stopPropagation();
    if (isUserLogged() == 0) {
        loginPopUpBox();
        return false
    }
    wish_list_id = typeof wish_list_id != "undefined" ? parseInt(wish_list_id) : 0;
    var dv = ".collection-ui-popup";
    var action = "addRemoveWishListProduct";
    var alternateData = "";
    if (0 >= selprod_id) {
        var oldWishListId = $("input[name='uwlist_id']").val();
        if (typeof oldWishListId !== "undefined" && wish_list_id != oldWishListId) {
            action = "updateRemoveWishListProduct";
            alternateData = $("#wishlistForm").serialize()
        }
    }
    fcom.updateWithAjax(fcom.makeUrl("Account", action, [selprod_id, wish_list_id], siteConstants.webroot_dashboard), alternateData, function (ans) {
        if (ans.status == 1) {
            $(document).trigger("close.facebox");
            $(dv + " .is-active").removeClass("is-active");
            if (ans.productIsInAnyList) {
                $("[data-id=" + selprod_id + "]").addClass("is-active")
            } else {
                $("[data-id=" + selprod_id + "]").removeClass("is-active")
            }
            if (ans.action == "A") {
                events.addToWishList();
                $(dv).find(".wishListCheckBox_" + ans.wish_list_id).addClass("is-active")
            } else if (ans.action == "R") {
                $(dv).find(".wishListCheckBox_" + ans.wish_list_id).removeClass("is-active")
            }
            if ("updateRemoveWishListProduct" == action) {
                viewWishListItems(oldWishListId)
            }
        }
    })
};
var screenResolutionForSlider = {
    1199: 4,
    1023: 3,
    767: 2,
    480: 2,
    375: 1,
};

function getSlickSliderSettings(slidesToShow, slidesToScroll, layoutDirection, autoInfinitePlay, slidesToShowForDiffResolution, adaptiveHeight) {
    slidesToShow = typeof slidesToShow != "undefined" ? parseInt(slidesToShow) : 4;
    slidesToScroll = typeof slidesToScroll != "undefined" ? parseInt(slidesToScroll) : 1;
    layoutDirection = typeof layoutDirection != "undefined" ? layoutDirection : "ltr";
    autoInfinitePlay = typeof autoInfinitePlay != "undefined" ? autoInfinitePlay : true;
    adaptiveHeight = typeof adaptiveHeight != "undefined" ? adaptiveHeight : true;
    if (typeof slidesToShowForDiffResolution != "undefined") {
        slidesToShowForDiffResolution = $.extend(screenResolutionForSlider, slidesToShowForDiffResolution)
    } else {
        slidesToShowForDiffResolution = screenResolutionForSlider
    }
    var sliderSettings = {
        dots: false,
        slidesToShow: slidesToShow,
        slidesToScroll: slidesToScroll,
        infinite: autoInfinitePlay,
        autoplay: autoInfinitePlay,
        adaptiveHeight: adaptiveHeight,
        arrows: true,
        responsive: [{
            breakpoint: 1199,
            settings: {
                slidesToShow: slidesToShowForDiffResolution[1199],
            },
        }, {
            breakpoint: 1023,
            settings: {
                slidesToShow: slidesToShowForDiffResolution[1023],
            },
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: slidesToShowForDiffResolution[767],
            },
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: slidesToShowForDiffResolution[480],
                arrows: false,
                dots: true,
            },
        }, {
            breakpoint: 375,
            settings: {
                slidesToShow: slidesToShowForDiffResolution[375],
                arrows: false,
                dots: true,
            },
        },],
    };
    if (layoutDirection == "rtl") {
        sliderSettings["rtl"] = true
    }
    return sliderSettings
}

function codeLatLng(lat, lng, callback) {
    initialize();
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({
        latLng: latlng,
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                var lat = results[0]["geometry"]["location"].lat();
                var lng = results[0]["geometry"]["location"].lng();
                for (var i = 0; i < results[0].address_components.length; i++) {
                    if (results[0].address_components[i].types[0] == "country") {
                        var country = results[0].address_components[i].long_name
                    }
                    if (results[0].address_components[i].types[0] == "country") {
                        var country_code = results[0].address_components[i].short_name
                    }
                    if (results[0].address_components[i].types[0] == "administrative_area_level_1") {
                        var state_code = results[0].address_components[i].short_name;
                        var state = results[0].address_components[i].long_name
                    }
                    if (results[0].address_components[i].types[0] == "administrative_area_level_2") {
                        var city = results[0].address_components[i].long_name
                    }
                    if (results[0].address_components[i].types[0] == "postal_code") {
                        var postal_code = results[0].address_components[i].long_name
                    }
                }
                var data = {
                    country: country,
                    country_code: country_code,
                    state: state,
                    state_code: state_code,
                    city: city,
                    lat: lat,
                    lng: lng,
                    postal_code: postal_code,
                };
                callback(data)
            } else {
                console.log("Geocoder No results found")
            }
        } else {
            console.log("Geocoder failed due to: " + status)
        }
    })
}

function defaultSetUpLogin(frm, v) {
    var formClass = "";
    if ($(frm).hasClass("loginpopup--js")) {
        formClass = "form.loginpopup--js "
    }
    if (0 < $(formClass + ".loginWithOtp--js").length && 0 < $(formClass + ".loginWithOtp--js").val()) {
        $(formClass + "input.otpVal-js").each(function () {
            if ("undefined" == typeof $(this).val() || "" == $(this).val()) {
                $(formClass + '.pwdField--js input[name="password"]').attr("data-fatreq", '{"required":false}');
                invalidOtpField();
                $.mbsmessage(langLbl.requiredFields, false, "alert--danger");
                return false
            }
        })
    }
    v.validate();
    if (!v.isValid()) {
        return false
    }
    fcom.ajax(fcom.makeUrl("GuestUser", "login"), fcom.frmData(frm), function (t) {
        var ans = JSON.parse(t);
        if (ans.notVerified == 1) {
            var autoClose = false
        } else {
            var autoClose = true
        }
        if (ans.status == 1) {
            $.mbsmessage(ans.msg, autoClose, "alert--success");
            location.href = ans.redirectUrl;
            return
        }
        $.mbsmessage(ans.msg, autoClose, "alert--danger")
    });
    return false
} (function ($) {
    var screenHeight = $(window).height() - 100;
    window.onresize = function (event) {
        var screenHeight = $(window).height() - 100
    };
    $.extend(fcom, {
        getLoader: function () {
            return '<div class="loader-yk"><div class="loader-yk-inner"></div></div>'
        },
        scrollToTop: function (obj) {
            if (typeof obj == undefined || obj == null) {
                $("html, body").animate({
                    scrollTop: $("html, body").offset().top - 100,
                }, "slow")
            } else {
                $("html, body").animate({
                    scrollTop: $(obj).offset().top - 100,
                }, "slow")
            }
        },
        resetEditorInstance: function () {
            if (extendEditorJs == true) {
                var editors = oUtil.arrEditor;
                for (x in editors) {
                    eval("delete window." + editors[x])
                }
                oUtil.arrEditor = []
            }
        },
        resetEditorWidth: function (width = "100%") {
            if (typeof oUtil != "undefined") {
                oUtil.arrEditor.forEach(function (input) {
                    var oEdit1 = eval(input);
                    $("#idArea" + oEdit1.oName).attr("width", width)
                })
            }
        },
        setEditorLayout: function (lang_id) {
            if (extendEditorJs == true) {
                var editors = oUtil.arrEditor;
                layout = langLbl["language" + lang_id];
                for (x in editors) {
                    $("#idContent" + editors[x]).contents().find("body").css("direction", layout)
                }
            }
        },
        resetFaceboxHeight: function () {
            facebocxHeight = screenHeight;
            var fbContentHeight = parseInt($("#facebox .content").height()) + parseInt(150);
            setTimeout(function () {
                $("#facebox .content").css("max-height", parseInt(facebocxHeight) - parseInt(facebocxHeight) / 4 + "px")
            }, 700);
            $("#facebox .content").css("overflow-y", "auto");
            if (fbContentHeight > screenHeight - parseInt(100)) {
                $("#facebox .content").css("display", "block")
            } else {
                $("#facebox .content").css("max-height", "")
            }
        },
        updateFaceboxContent: function (t, cls) {
            if (typeof cls == "undefined" || cls == "undefined") {
                cls = ""
            }
            $.facebox(t, cls);
            $.systemMessage.close()
        },
        displayProcessing: function (msg, cls, autoclose) {
            if (typeof msg == "undefined" || msg == "undefined") {
                msg = langLbl.processing
            }
            $.systemMessage(msg, "alert--process", autoclose)
        },
        displaySuccessMessage: function (msg, cls, autoclose) {
            if (typeof cls == "undefined" || cls == "undefined") {
                cls = "alert--success"
            }
            $.systemMessage(msg, cls, autoclose)
        },
        displayErrorMessage: function (msg, cls, autoclose) {
            if (typeof cls == "undefined" || cls == "undefined") {
                cls = "alert--danger"
            }
            $.systemMessage(msg, cls, autoclose)
        },
        closeAlertMessage: function (msg, cls, autoclose) {
            $.systemMessage.close()
        },
    });
    $(document).bind("reveal.facebox", function () {
        fcom.resetFaceboxHeight()
    });
    $(window).on("orientationchange", function () {
        fcom.resetFaceboxHeight()
    });
    $(document).bind("loading.facebox", function () {
        $("#facebox .content").addClass("fbminwidth")
    });
    $(document).bind("afterClose.facebox", function () {
        $("html").css("overflow", "")
    });
    $(document).bind("beforeReveal.facebox", function () {
        $("#facebox .content").addClass("fbminwidth");
        $("html").css("overflow", "")
    });
    $(document).bind("reveal.facebox", function () {
        $("#facebox .content").addClass("fbminwidth")
    });
    $.systemMessage = function (data, cls, autoClose = true) {
        $.mbsmessage(data, autoClose, cls)
    };
    $.extend($.systemMessage, {
        settings: {
            closeimage: siteConstants.webroot + "images/facebox/close.gif",
        },
        loading: function () {
            $(".system_message").show()
        },
        fillSysMessage: function (data, cls, autoClose) {
            if (cls) {
                $(".system_message").removeClass("alert--process");
                $(".system_message").removeClass("alert--danger");
                $(".system_message").removeClass("alert--success");
                $(".system_message").removeClass("alert--info");
                $(".system_message").addClass(cls)
            }
            $(".system_message .content").html(data);
            $(".system_message").fadeIn();
            if (true == autoClose && CONF_AUTO_CLOSE_SYSTEM_MESSAGES == 1) {
                var time = CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES * 1000;
                setTimeout(function () {
                    $.systemMessage.close()
                }, time)
            }
        },
        close: function () {
            $.mbsmessage.close()
        },
    });
    $(document).bind("close.systemMessage", function () {
        $.mbsmessage.close()
    });

    function initialize() {
        $(".system_message .close").click($.systemMessage.close)
    }
    $.fn.serialize_without_blank = function () {
        var $form = this,
            result, $disabled = $([]);
        $form.find(":input").each(function () {
            var $this = $(this);
            if ($.trim($this.val()) === "" && !$this.is(":disabled")) {
                $disabled.add($this);
                $this.attr("disabled", true)
            }
        });
        result = $form.serialize();
        $disabled.removeAttr("disabled");
        return result
    }
})(jQuery);
$(document).ready(function () {
    if ($(".system_message").find(".div_error").length > 0 || $(".system_message").find(".div_msg").length > 0 || $(".system_message").find(".div_info").length > 0 || $(".system_message").find(".div_msg_dialog").length > 0) {
        $(".system_message").show()
    }
    $(".close").click(function () {
        $(".system_message").hide()
    });
    addCatalogPopup = function () {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl("Seller", "addCatalogPopup"), "", function (t) {
                fcom.updateFaceboxContent(t)
            })
        })
    };
    markAsFavorite = function (selProdId) {
        if (isUserLogged() == 0) {
            loginPopUpBox();
            return false
        }
        $.mbsmessage.close();
        fcom.updateWithAjax(fcom.makeUrl("Account", "markAsFavorite", [selProdId]), "", function (ans) {
            if (ans.status) {
                $("[data-id=" + selProdId + "]").addClass("is-active");
                $("[data-id=" + selProdId + "]").attr("onclick", "removeFromFavorite(" + selProdId + ")");
                $("[data-id=" + selProdId + "] span").attr("title", langLbl.RemoveProductFromFavourite)
            }
        })
    };
    removeFromFavorite = function (selProdId, callbackFunction = false) {
        if (isUserLogged() == 0) {
            loginPopUpBox();
            return false
        }
        $.mbsmessage.close();
        fcom.updateWithAjax(fcom.makeUrl("Account", "removeFromFavorite", [selProdId]), "", function (ans) {
            if (ans.status) {
                $("[data-id=" + selProdId + "]").removeClass("is-active");
                $("[data-id=" + selProdId + "]").attr("onclick", "markAsFavorite(" + selProdId + ")");
                $("[data-id=" + selProdId + "] span").attr("title", langLbl.AddProductToFavourite)
            }
        });
        if (callbackFunction !== false) {
            window[callbackFunction]()
        }
    };
    openSignInForm = function (includeGuestLogin) {
        if (typeof includeGuestLogin == "undefined") {
            includeGuestLogin = false
        }
        data = "includeGuestLogin=" + includeGuestLogin;
        fcom.ajax(fcom.makeUrl("GuestUser", "LogInFormPopUp"), data, function (t) {
            try {
                var ans = JSON.parse(t);
                if (ans.status == 1) {
                    $.mbsmessage(ans.msg, true, "alert--success");
                    if ("undefined" != typeof ans.redirectUrl) {
                        location.href = ans.redirectUrl
                    }
                    return
                }
                $.mbsmessage(ans.msg, true, "alert--danger")
            } catch (err) {
                fcom.updateFaceboxContent(t)
            }
        })
    };
    autofillLangData = function (autoFillBtn, frm) {
        var actionUrl = autoFillBtn.data("action");
        var defaultLangField = $("input.defaultLang", frm);
        if (1 > defaultLangField.length) {
            $.systemMessage(langLbl.unknownPrimaryLanguageField, "alert--danger");
            return false
        }
        var proceed = true;
        var stringToTranslate = "";
        defaultLangField.each(function (index) {
            if ("" != $(this).val()) {
                if (0 < index) {
                    stringToTranslate += "&"
                }
                stringToTranslate += $(this).attr("name") + "=" + $(this).val()
            } else {
                $(this).focus();
                $.systemMessage(langLbl.primaryLanguageField, "alert--danger");
                proceed = false;
                return false
            }
        });
        if (true == proceed) {
            $.mbsmessage(langLbl.processing, true, "alert--process alert");
            fcom.ajax(actionUrl, stringToTranslate, function (t) {
                var res = $.parseJSON(t);
                $.each(res, function (langId, values) {
                    $.each(values, function (selector, value) {
                        $("input.langField_" + langId + "[name='" + selector + "']").val(value)
                    })
                });
                $(document).trigger("close.mbsmessage")
            })
        }
    };
    redirectfunc = function (url, orderStatus) {
        var input = '<input type="hidden" name="status" value="' + orderStatus + '">';
        $('<form action="' + url + '" method="POST">' + input + "</form>").appendTo($(document.body)).submit()
    };
    $(document).on("click", ".sign-in-popup-js", function () {
        openSignInForm()
    });
    $(".cc-cookie-accept-js").click(function () {
        var data = {
            statistical_cookies: 1,
            personalise_cookies: 1
        };
        updateUserCookies(data)
    });
    $(".cookie-preferences-js").click(function () {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl("Custom", "cookiePreferencesData", [], siteConstants.webrootfront), "", function (t) {
                fcom.updateFaceboxContent(t)
            })
        })
    });
    setUserCookiePreferences = function () {
        var statisticalCookies = 0;
        if ($("input[name='statistical_cookies']").prop("checked") == true) {
            statisticalCookies = 1
        }
        var personaliseCookies = 0;
        if ($("input[name='personalise_cookies']").prop("checked") == true) {
            personaliseCookies = 1
        }
        var data = {
            statistical_cookies: statisticalCookies,
            personalise_cookies: personaliseCookies,
        };
        updateUserCookies(data)
    };
    updateUserCookies = function (data) {
        fcom.ajax(fcom.makeUrl("Custom", "updateUserCookies", [], siteConstants.webrootfront), data, function (rsp) {
            var ans = $.parseJSON(rsp);
            console.log(ans);
            if (ans.status == 0) {
                $.mbsmessage(ans.msg, true, "alert--danger")
            } else {
                $(".cookie-alert").hide("slow");
                $(".cookie-alert").remove();
                $(document).trigger("close.facebox")
            }
        })
    };
    $(document).on("click", ".setactive-js li", function () {
        $(this).closest(".setactive-js").find("li").removeClass("is-active");
        $(this).addClass("is-active")
    });
    $(document).on("keydown", "input[name=user_username]", function (e) {
        if (e.which === 32) {
            return false
        }
        this.value = this.value.replace(/\s/g, "")
    });
    $(document).on("change", "input[name=user_username]", function (e) {
        this.value = this.value.replace(/\s/g, "")
    });
    $(document).on("submit", "form", function () {
        moveErrorAfterIti()
    });
    $(document).on("keyup", "form .iti input[data-intl-tel-input-id]", function () {
        moveErrorAfterIti()
    })
});

function moveErrorAfterIti() {
    if (0 < $(".iti .errorlist").length) {
        $(".iti .errorlist").detach().insertAfter(".iti")
    }
}

function isUserLogged() {
    var isUserLogged = 0;
    $.ajax({
        url: fcom.makeUrl("GuestUser", "checkAjaxUserLoggedIn", [], siteConstants.webrootfront),
        async: false,
        dataType: "json",
    }).done(function (ans) {
        isUserLogged = parseInt(ans.isUserLogged)
    });
    return isUserLogged
}

function loginPopUpBox(includeGuestLogin) {
    openSignInForm(includeGuestLogin)
}

function setSiteDefaultLang(langId) {
    var url = window.location.pathname;
    var srchString = window.location.search;
    var data = "pathname=" + url;
    fcom.ajax(fcom.makeUrl("Home", "setLanguage", [langId], siteConstants.webrootfront), data, function (res) {
        var ans = $.parseJSON(res);
        if (ans.status == 1) {
            window.location.href = ans.redirectUrl + srchString
        }
    })
}

function setSiteDefaultCurrency(currencyId) {
    var currUrl = window.location.href;
    fcom.ajax(fcom.makeUrl("Home", "setCurrency", [currencyId], siteConstants.webrootfront), "", function (res) {
        document.location.reload()
    })
}

function quickDetail(selprod_id) {
    $.facebox(function () {
        fcom.ajax(fcom.makeUrl("Products", "productQuickDetail", [selprod_id], siteConstants.webrootfront), "", function (t) {
            fcom.updateFaceboxContent(t)
        })
    })
}

function stylePhoneNumberFld(element = "input[name='user_phone']", destroy = false) {
    var inputList = document.querySelectorAll(element);
    var country = "" == langLbl.defaultCountryCode || "undefined" == typeof langLbl.defaultCountryCode ? "in" : langLbl.defaultCountryCode;
    inputList.forEach(function (input) {
        var form = input.closest('form');
        if (true == destroy) {
            $(input, form).removeAttr("style");
            var clone = input.cloneNode(true);
            $(".iti").replaceWith(clone)
        } else {
            if ($(input, form).hasClass("hasFlag-js")) {
                return
            }

            $(input, form).addClass("hasFlag-js");
            var hasOnlyFlag = $(element, form).hasClass("onlyFlag--js");
            var elementName = $(input, form).attr("name") + "_dcode";
            var dialCodeElement = $('input[name="' + elementName + '"]', form);

            if (false === hasOnlyFlag) {
                if (0 < dialCodeElement.length && "" != dialCodeElement.val() && "undefined" != typeof dialCodeElement.val()) {
                    var elementVal = dialCodeElement.val();
                    var countryCodePos = elementVal.indexOf("-");
                    if (0 < countryCodePos) {
                        country = elementVal.substring(countryCodePos + 1, elementVal.length)
                    } else {
                        country = getCountryIso2CodeFromDialCode(parseInt(elementVal))
                    }
                }
            }
            var iti = window.intlTelInput(input, {
                separateDialCode: !hasOnlyFlag,
                initialCountry: country,
            });
            var dialCode = "+" + iti.getSelectedCountryData().dialCode;
            var dialCodeWithPhone = dialCode + "-" + iti.getSelectedCountryData().iso2;
            $(input, form).attr("data-before", dialCode);
            if (1 == dialCodeElement.length && false === hasOnlyFlag) {
                dialCodeElement.insertAfter(input);
                if ("" == dialCodeElement.val()) {
                    dialCodeElement.val(dialCodeWithPhone)
                }
            } else if (1 > dialCodeElement.length && false === hasOnlyFlag) {
                $("<input>").attr({
                    type: "hidden",
                    name: elementName,
                    value: dialCodeWithPhone,
                }).insertAfter(input, form)
            } else if (true === hasOnlyFlag) {
                var phoneNumber = $(input, form).val();
                if ("undefined" == typeof phoneNumber || "" == phoneNumber) {
                    phoneNumber = dialCode
                } else if (-1 == phoneNumber.indexOf("+")) {
                    phoneNumber = dialCode + phoneNumber
                }
                $(input, form).val(phoneNumber)
            }

            input.addEventListener("countrychange", function (e) {
                if (typeof iti.getSelectedCountryData().dialCode !== "undefined") {
                    var dialCode = "+" + iti.getSelectedCountryData().dialCode;
                    var dialCodeWithPhone = dialCode + "-" + iti.getSelectedCountryData().iso2;
                    if (false === hasOnlyFlag) {
                        if ($('input[name="' + elementName + '"]', form).length < 1) {
                            $.systemMessage($(input, form).attr("name") + " " + langLbl.dialCodeFieldNotFound, "alert-danger");
                            return
                        }
                        $('input[name="' + elementName + '"]', form).val(dialCodeWithPhone)
                    } else {
                        var phoneNumber = $(input).val();
                        if ("undefined" == typeof phoneNumber || "" == phoneNumber) {
                            phoneNumber = dialCode
                        } else if (-1 == phoneNumber.indexOf("+")) {
                            phoneNumber = dialCode + phoneNumber
                        } else if ($(input, form).data("before") != dialCode) {
                            phoneNumber = phoneNumber.replace($(input, form).data("before"), dialCode)
                        }
                        $(input, form).val(phoneNumber)
                    }
                    $(input, form).attr("data-before", dialCode)
                }
            });
            input.addEventListener("keyup", function (e) {
                if (true === hasOnlyFlag && "+" != input.value.charAt(0)) {
                    input.value = "+" + input.value
                }
            })
        }
    })
}


function getCountryIso2CodeFromDialCode(dialCode) {
    var countriesData = window.intlTelInputGlobals.getCountryData();
    var countryData = countriesData.filter(function (country) {
        return country.dialCode == dialCode
    });
    return countryData[0].iso2
}
$(document).on("click", ".readMore", function () {
    var $this = $(this);
    var $moreText = $this.siblings(".moreText");
    var $lessText = $this.siblings(".lessText");
    if ($this.hasClass("expanded")) {
        $moreText.hide();
        $lessText.fadeIn();
        $this.text($linkMoreText)
    } else {
        $lessText.hide();
        $moreText.fadeIn();
        $this.text($linkLessText)
    }
    $this.toggleClass("expanded")
});
$(document).on("click", "#btn-demo", function () {
    $.facebox(function () {
        fcom.ajax(fcom.makeUrl("Custom", "requestDemo", [], siteConstants.webrootfront), "", function (t) {
            fcom.updateFaceboxContent(t)
        })
    })
});
$(document).ready(function () {
    if ($(window).width() < 1025) {
        $("html").removeClass("sticky-demo-header");
        $("div.demo-header").hide()
    }
});
$(document).ready(function () {
    new ScrollHint(".js-scrollable", {
        i18n: {
            scrollable: langLbl.scrollable,
        },
    })
});
$(document).ajaxComplete(function () {
    stylePhoneNumberFld(".phone-js");
    new ScrollHint(".js-scrollable:not(.scroll-hint)", {
        i18n: {
            scrollable: langLbl.scrollable,
        },
    });
    if (0 < $("div.block--empty").length && 0 < $("div.scroll-hint-icon-wrap").length) {
        $("div.block--empty").siblings(".js-scrollable.scroll-hint").children("div.scroll-hint-icon-wrap").remove()
    }
    if (0 < $("#facebox").length) {
        if ($("#facebox").is(":visible")) {
            $("html").addClass("pop-on")
        } else {
            $("html").removeClass("pop-on")
        }
        $("#facebox .close.close--white").on("click", function () {
            $("html").removeClass("pop-on")
        })
    }
    $("body").click(function () {
        if ($("html").hasClass("pop-on")) {
            $("html").removeClass("pop-on")
        }
    });
    installJsColor()
});
$(document).ready(function () {
    $("body").find("*[data-trigger]").click(function () {
        var targetElmId = $(this).data("trigger");
        var elmToggleClass = targetElmId + "--on";
        if ($("body").hasClass(elmToggleClass)) {
            $("body").removeClass(elmToggleClass)
        } else {
            $("body").addClass(elmToggleClass)
        }
    });
    $("body").find("*[data-target-close]").click(function () {
        var targetElmId = $(this).data("target-close");
        $("body").toggleClass(targetElmId + "--on")
    });
    $("body").mouseup(function (event) {
        if ($(event.target).data("trigger") != "" && typeof $(event.target).data("trigger") !== typeof undefined) {
            event.preventDefault();
            return
        }
        $("body").find("*[data-close-on-click-outside]").each(function (idx, elm) {
            var slctr = $(elm);
            if (!slctr.is(event.target) && !$.contains(slctr[0], event.target)) {
                $("body").removeClass(slctr.data("close-on-click-outside") + "--on")
            }
        })
    });
    $("body").tooltip({
        selector: "[data-toggle=tooltip]"
    })
});
$(document).on("change", "input[type='file']", fileSizeValidation);

function fileSizeValidation() {
    const fsize = this.files[0].size;
    if (fsize > langLbl.allowedFileSize) {
        var msg = langLbl.fileSizeExceeded;
        var msg = msg.replace("{size-limit}", bytesToSize(langLbl.allowedFileSize));
        $.mbsmessage(msg, true, "alert--danger");
        $(this).val("");
        return false
    }
}

function bytesToSize(bytes) {
    var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
    if (bytes == 0) return "0 Byte";
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i]
}
$(".form-floating").find("input, textarea, select").each(function () {
    if ($(this).val() != "") {
        $(this).addClass("filled")
    } else {
        $(this).removeClass("filled")
    }
});
$(".dropdown-menu").on("click", function (e) {
    e.stopPropagation()
});
$(document).on("click", ".v-tabs--js ul li", function (e) {
    e.preventDefault();
    $(".v-tabs--js .is-active").removeClass("is-active");
    var target = $("a.v-tab--js", this).attr("href");
    $(this).addClass("is-active");
    $(target).addClass("is-active")
});
var imagesPreview = function (input, placeToInsertImagePreview) {
    if (input.files) {
        if (1 > $(placeToInsertImagePreview + " ul").length) {
            $(placeToInsertImagePreview).html('<ul class="review-media-list"></ul>')
        }
        var fileFldName = $(input).attr("name");
        var filesAmount = input.files.length;
        for (i = 0; i < filesAmount; i++) {
            let selectedFile = input.files[i];
            var reader = new FileReader();
            reader.onload = function (event) {
                var htm = '<li><div class="uploaded-file"><span class="uploaded-file__thumb"></span><a href="javascript:void(0);" class="file-remove fileRemove--js" data-filefld="' + fileFldName + '"></a></div></li>';
                $(placeToInsertImagePreview + " ul").append(htm);
                $($.parseHTML('<img class="imgToUpload--js" title="' + selectedFile.name + '">')).attr("src", event.target.result).appendTo(placeToInsertImagePreview + " ul li:last-child .uploaded-file__thumb")
            };
            reader.readAsDataURL(input.files[i])
        }
    }
};

function DataURIToBlob(dataURI) {
    const splitDataURI = dataURI.split(",");
    const byteString = splitDataURI[0].indexOf("base64") >= 0 ? atob(splitDataURI[1]) : decodeURI(splitDataURI[1]);
    const mimeString = splitDataURI[0].split(":")[1].split(";")[0];
    const ia = new Uint8Array(byteString.length);
    for (let i = 0; i < byteString.length; i++) ia[i] = byteString.charCodeAt(i);
    return new Blob([ia], {
        type: mimeString
    })
}
$(document).on("change", ".multipleImgs--js", function () {
    if ($(this)[0].files.length > 8) {
        $.mbsmessage(langLbl.uploadImageLimit, true, "alert--danger");
        $(this).val("");
        if (0 < $(".fileRemove--js").length) {
            $(".fileRemove--js").click()
        }
        return false
    }
    var galleryElement = ".multipleImgsGallery--js";
    $(galleryElement).html("");
    imagesPreview(this, galleryElement)
});
$(document).on("click", ".fileRemove--js", function () {
    $(this).closest("li").remove()
});

function previewImage(obj) {
    var imgUrl = $("img", obj).data("altimg");
    if ("" == imgUrl || "undefined" == typeof imgUrl) {
        imgUrl = $("img", obj).attr("src")
    }
    var img = $($.parseHTML("<img>")).attr("src", imgUrl);
    fcom.updateFaceboxContent(img, "text-center")
}

function loadMoreImages(obj) {
    $("a", obj).removeAttr("data-count").attr("onclick", "previewImage(this)");
    $(obj).removeClass("more-media").removeAttr("onclick");
    $(obj).nextAll().removeClass("d-none")
}