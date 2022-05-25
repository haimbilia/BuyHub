(function () {
    forgot = function (frm, v) {
        v.validate();
        if (!v.isValid()) return;
        fcom.updateWithAjax(fcom.makeUrl('GuestUser', 'forgotPassword'), fcom.frmData(frm), function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            if (t.status == 1) {
                location.href = fcom.makeUrl('GuestUser', 'loginForm');
            } else {
                fcom.displayErrorMessage(t.msg);
            }
            return;
        });
    };
    forgotPwdForm = function (withPhone = 0) {
        $('.forgotPwForm').prepend(fcom.getLoader())
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('GuestUser', 'forgotPasswordForm', [withPhone, 0]), '', function (t) {
            fcom.removeLoader();
            fcom.closeProcessing();
            $('.forgotPwForm').replaceWith(t);
        });
    };

    getOtpForm = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.displayProcessing();
        fcom.ajax(frm.action, data, function (t) {
                if (1 > t.status) {
                    fcom.displayErrorMessage(t.msg);
                    googleCaptcha();
                    return false;
                }
                $.ykmsg.close();
                $('#otpFom').html(t.html);
                startOtpInterval();
            }, { fOutMode: 'json' }
        );
        return false;
    };

    validateOtp = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('GuestUser', 'validateOtp', [1, 1]), data, function (t) {
            t = $.parseJSON(t);
            if (1 == t.status) {
                window.location.href = t.redirectUrl;
            } else {
                fcom.displayErrorMessage(t.msg);
                invalidOtpField();
            }
        });
        return false;
    };

    resendOtp = function (userId, getOtpOnly = 0) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('GuestUser', 'resendOtp', [userId, getOtpOnly]), '', function (t) {
            t = $.parseJSON(t);
            if (typeof t.status != 'undefined' && 1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                return false;
            }
            fcom.displaySuccessMessage(t.msg);
            startOtpInterval();
        });
        return false;
    };
})();