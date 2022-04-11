(function () {
    signUpWithPhone = function () {
        $('#sign-up').prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('GuestUser', 'signUpWithPhone'), '', function (t) {
            fcom.removeLoader();
            $('#sign-up').html(t);
        });
    };

    signUpWithEmail = function () {
        $('#sign-up').prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('GuestUser', 'signUpWithEmail'), '', function (t) {
            fcom.removeLoader();
            $('#sign-up').html(t);
        });
    };

    registerWithPhone = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        $('#sign-up').prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('GuestUser', 'register'), data, function (t) {
            if (1 > t.status) {
                
                fcom.displayErrorMessage(t.msg);
                fcom.removeLoader();
            }
            if (1 == t.status) {
                fcom.ajax(fcom.makeUrl('GuestUser', 'otpForm'), '', function (t) {
                    fcom.removeLoader();
                    t = $.parseJSON(t);
                    if (1 > t.status) {                       
                        fcom.displayErrorMessage(t.msg);
                        return false;
                    }
                    $('#sign-up').html(t.html);
                    $('.countdownFld--js, .resendOtp-js').parent().removeClass('d-none');
                    startOtpInterval('.otpForm-js');
                    fcom
                });
            }
        },{ fOutMode: 'json' });
        return false;
    };

    validateOtp = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        $('#sign-up').prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('GuestUser', 'validateOtp'), data, function (t) {
            fcom.removeLoader();
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
        $('#sign-up').prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('GuestUser', 'resendOtp', [userId, getOtpOnly]), '', function (t) {
            fcom.removeLoader();
            t = $.parseJSON(t);
            if (typeof t.status != 'undefined' && 1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                return false
            }
            fcom.displaySuccessMessage(t.msg);
            var parent = 0 < $('#facebox .loginpopup').length ? '.loginpopup' : '';
            $('#sign-up').html(t.html);
            startOtpInterval(parent);
        });
        return false;
    };
})();