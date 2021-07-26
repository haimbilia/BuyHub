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

    syncStatusToggle = function (obj, status) {
        $(obj).attr('onclick', 'syncStatusToggle(this, ' + (status ? 0 : 1) + ')');
        $.systemMessage(langLbl.processing, "alert--process", false);
        fcom.ajax(fcom.makeUrl(keyName, 'syncStatus', [status]), '', function (res) {
            res = $.parseJSON(res);
            if (1 > res.status) {
                var value = (value == 0 ? 1 : 0);
                $(obj).prop('checked', (status == 0));
                $.systemMessage(res.msg, 'alert--danger', true);
                return;
            }
            $.systemMessage(res.msg, 'alert--success', true);
        });
    }
})();
