$(document).ready(function () {
    select2('searchFrmUserIdJs', fcom.makeUrl(controllerName, 'autoComplete'));
    //redirect user to login page
    $(document).on('click', 'a#redirectJs', function (event) {
        event.stopPropagation();
    });

});

(function () {
    addBankInfoForm = function (id) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'bankInfoForm', [id]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });

    };

    setupBankInfo = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setupBankInfo'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
        });
    };

    changeUserPassword = function (id) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'changePasswordForm', [id]), '', function (t) {
            fcom.displaySuccessMessage(t.msg);
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };

    updatePassword = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        $.ykmodal(fcom.getLoader(), true);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updatePassword'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
            $.ykmodal.close();
        });
    };

    sendMailToUser = function (id) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'sendMailForm', [id]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };

    sendMail = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        $.ykmodal(fcom.getLoader(), true);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'sendMail'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
            $.ykmodal.close();
        });
    };

    displayCookiesPerferences = function (id) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'cookiesPreferencesForm', [id]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    markSellerAsBuyer = function (userId) {
        if (!confirm(langLbl.confirmAsBuyer)) {
            return;
        }
        var userId = parseInt(userId);
        if (1 > userId) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'markSellerAsBuyer'), { userId: userId }, function (t) {
            fcom.displaySuccessMessage(t.msg);
            reloadList();
            fcom.removeLoader();
        });
    }

    sendSetPasswordEmail = function (userId) {
        fcom.displayProcessing();
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'resendSetPasswordEmail'), { userId: userId }, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
        });
    };
    markVerified = function (userId) {
        if (!confirm(langLbl.areYouSure)) {
            return;
        }
        fcom.displayProcessing();
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'markVerified'), { userId: userId }, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
            reloadList();
        });
    };
})();
