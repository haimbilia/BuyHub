function setSiteDefaultLang(langId) {
    fcom.updateWithAjax(fcom.makeUrl('Home', 'setLanguage', [langId]), '', function (res) {
        document.location.reload();
    });
}

function getNotifications() {
    $("#notificationList").prepend(fcom.getLoader());

    fcom.ajax(fcom.makeUrl('Notifications', 'notificationList'), '', function (res) {
        $("#notificationList").html(res);
    });
}

function getHelpCenterContent(controller, action = "") {
    fcom.ajax(fcom.makeUrl('HelpCenter', 'getContent', [controller, action]), '', function (t) {
        var res = JSON.parse(t);
        if (0 == res.status) {
            return;
        }

        if (1 > $('#helpCenterJs').length) {
            $(".mainJs").after('<div id="helpCenterJs"></div>');
        }

        if ('undefined' != typeof res.html) {
            $("#helpCenterJs").html(res.html);
        }
    });
}

copyText = function(obj){
    var copyText = $(obj).data('title');
    /*
    document.addEventListener('copy', function(e) {
        e.clipboardData.setData('text/plain', copyText);
        e.preventDefault();
    }, true);
    */
    navigator.clipboard.writeText(copyText)
    
}

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
        if (0 < inputObj.length && 'undefined' !== typeof grecaptcha) {
            grecaptcha.ready(function () {
                grecaptcha.execute(langLbl.captchaSiteKey, { action: inputObj.data('action') }).then(function (token) {
                    inputObj.val(token);
                    gCaptcha = true;
                });
            });
        } else if ('undefined' === typeof grecaptcha) {
            $.mbsmessage(langLbl.invalidGRecaptchaKeys, true, 'alert--danger');
        }
    }, 200);
}

getSlugUrl = function (obj, str, extra, pos) {
    if (pos == undefined)
        pos = 'pre';
    var str = str.toString().toLowerCase()
        .replace(/\s+/g, '-') /* Replace spaces with - */
        .replace(/[^\w\-\/]+/g, '') /* Remove all non-word chars */
        .replace(/\-\-+/g, '-') /* Replace multiple - with single - */
        .replace(/^-+/, '') /* Trim - from start of text */
        .replace(/-+$/, '');
    if (extra && pos == 'pre') {
        str = extra + '/' + str;
    }
    if (extra && pos == 'post') {
        str = str + '/' + extra;
    }

    $(obj).next().html(SITE_ROOT_URL + str);

};

Slugify = function (str, str_val_id, is_slugify) {
    var str = str.toString().toLowerCase()
        .replace(/\s+/g, '-') /* Replace spaces with - */
        .replace(/[^\w\-]+/g, '') /* Remove all non-word chars */
        .replace(/\-\-+/g, '-') /* Replace multiple - with single - */
        .replace(/^-+/, '') /*  Trim - from start of text */
        .replace(/-+$/, '');        
    if ($("#" + is_slugify).val() == 0){
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

postdata object like {record:1}
*/
select2 = function (elmId, url, postdata = {}, callbackOnSelect) {    
    let ele = $("#" + elmId);
    ele.select2({
        closeOnSelect: true,
        dir: layoutDirection,
        //allowClear: true,
        // placeholder: ele.attr('placeholder') || '',
        ajax: {
            url: url,
            dataType: 'json',
            delay: 250,
            method: 'post',
            data: function (params) {
                return $.extend({
                    keyword: params.term, // search term
                    page: params.page, 
                    fIsAjax:1          
                }, postdata);                
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                data.pageCount = data.pageCount || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: params.page < data.pageCount
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        dropdownPosition: 'below'
    }).on('select2:selecting', function (e) {
        if(typeof(callbackOnSelect) == 'function'){
            callbackOnSelect(e);
        }
    });

    $("."+$.ykmodal.element).removeAttr('tabindex');
};

