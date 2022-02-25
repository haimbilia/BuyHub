var keyName = 'EasyEcom';

$(document).ready(function () {
    landingPage();
});

(function () {
    var dv = '#landingpage-js';
    landingPage = function () {
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(keyName, 'landingPage'), '', function (res) {
            fcom.removeLoader();
            $(dv).html(res);
        });
    };

    register = function () {
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(keyName, 'register'), '', function (res) {
            fcom.removeLoader();
            res = $.parseJSON(res);
            if (1 > res.status) {
                fcom.displayErrorMessage(res.msg);
            } else {
                fcom.displaySuccessMessage(res.msg);
            }
            landingPage();
        });
    }

    syncStatusToggle = function (obj, status) {
        $(obj).attr('onclick', 'syncStatusToggle(this, ' + (status ? 0 : 1) + ')');
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(keyName, 'syncStatus', [status]), '', function (res) {
            res = $.parseJSON(res);
            if (1 > res.status) {
                var value = (value == 0 ? 1 : 0);
                $(obj).prop('checked', (status == 0));
                fcom.displayErrorMessage(res.msg);
                return;
            }
            fcom.displaySuccessMessage(res.msg);
        });
    }
})();
