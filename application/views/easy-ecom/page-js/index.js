var keyName = 'EasyEcom';

$(document).ready(function () {
    landingPage();
});

(function () {
    var dv = '#landingpage-js';
    landingPage = function () {
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(keyName, 'landingPage'), '', function (res) {
            $(dv).html(res);
        });
    };

    register = function () {
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(keyName, 'register'), '', function (res) {
            res = $.parseJSON(res);
            if (1 > res.status) {
                $.systemMessage(res.msg, 'alert--danger', false);
            } else {
                $.systemMessage(res.msg, 'alert--success', false);
            }
            landingPage();
        });
    }
    
    goToDashboard = function () {
        window.open('https://api.marketplace.4qcteam.com/', '_blank');
    }

    syncStatusToggle = function (e, obj) {
        e.preventDefault();
        fcom.ajax(fcom.makeUrl(keyName, 'syncStatus', [$(obj).val()]), '', function (res) {
            res = $.parseJSON(res);
            if (1 > res.status) {
                $.systemMessage(res.msg, 'alert--danger', true);
            } else {
                $.systemMessage(res.msg, 'alert--success', true);
                var value = $(obj).is(":checked") ? 1 : 0;
                $(obj).prop('checked', !($(obj).is(":checked"))).val(value);
            }
        });
    }
})();
