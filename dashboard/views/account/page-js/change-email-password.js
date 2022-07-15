(function () {
    var runningAjaxReq = false;
    var passdv = '#changePassFrmBlock';
    var emaildv = '#changeEmailFrmBlock';
    var phoneNumberdv = '#changePhoneNumberFrmBlock';

    checkRunningAjax = function () {
        if (runningAjaxReq == true) {
            console.log(runningAjaxMsg);
            return;
        }
        runningAjaxReq = true;
    };

    changePasswordForm = function () {
        $(passdv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Account', 'changePasswordForm'), '', function (t) {
            fcom.removeLoader();
            $(passdv).html(t);
        });
    };

    changeEmailForm = function () {
        $(emaildv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Account', 'changeEmailForm'), '', function (t) {
            fcom.removeLoader();
            $(emaildv).html(t);
        });
    };
    changeEmailUsingPhoneForm1 = function () {        
        $(emaildv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Account', 'changeEmailUsingPhoneForm1'), '', function (t) {
            fcom.removeLoader();
            t = $.parseJSON(t);
            $(emaildv).html(t.html);
            stylePhoneNumberFld();
        });
    };

    updatePassword = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Account', 'updatePassword'), data, function (t) {
            changePasswordForm();
        });
    };

    updateEmail = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Account', 'updateEmail'), data, function (t) {
            changeEmailForm();
        });
    };
    updateEmailPasswordUsingPhone = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Account', 'updateEmailPasswordUsingPhone'), data, function (t) {
            changeEmailUsingPhoneForm1();
        });
    };

    changePhoneNumberForm = function () {
        $(phoneNumberdv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Account', 'changePhoneForm'), '', function (t) {
            fcom.removeLoader();
            t = $.parseJSON(t);
            $(phoneNumberdv).html(t.html);
            stylePhoneNumberFld();
        });
    };

    /*getOtp = function (frm, updateToDbFrm = 0) { */
    getOtp = function (frm) {       
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        $(frm.btn_submit).attr('disabled', 'disabled');
        fcom.displayProcessing();
        
        fcom.ajax(fcom.makeUrl('Account', 'getOtp'), data, function (t) {
            $.ykmsg.close();
            t = $.parseJSON(t);
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                $(frm.btn_submit).removeAttr('disabled');
                return false;
            }
         
            var lastFormElement = "#" + frm.id;
            $(lastFormElement).after(t.html);         

            var resendOtpElement = "#"+ $(t.html).attr('id');          
           
            $(lastFormElement + ' [name="btn_submit"]').closest("div.row").remove();
            if (OTP_FOR_NEW_PHONE_NO == frm.use_for.value) {
                $(lastFormElement + " input[name='user_phone']").attr('readonly', 'readonly');
            }
          
            $(".otpForm-js .form-side").removeClass('form-side');
            $('.formTitle-js').remove();     
          
            $(resendOtpElement + " .countdownFld--js, " + resendOtpElement + " .resendOtp-js").parent().removeClass("d-none");
            $(resendOtpElement + ".otpFieldBlock--js," + resendOtpElement + " .countdownFld--js").removeClass("d-none");
            startOtpInterval();
        });
        return false;
    };

    resendOtp = function (phone = '', dialCode = '') {
        clearInterval(otpIntervalObj);
        var postparam = (1 == phone) ? '' : "user_phone=" + phone + "&user_phone_dcode=" + dialCode;
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('Account', 'resendOtp'), postparam, function (t) {
            t = $.parseJSON(t);
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                return false;
            }
            fcom.displaySuccessMessage(t.msg);
            startOtpInterval();
        });
        return false;
    };

    validateOtp = function (frm, updateToDbFrmType = 0) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        $(frm.btn_submit).attr('disabled', 'disabled');
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('Account', 'validateOtp', [updateToDbFrmType]), data, function (t) {
            t = $.parseJSON(t);
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                invalidOtpField();
                $(frm.btn_submit).removeAttr('disabled');
                return false;
            } else if ('undefined' != typeof t.html) {
                $.ykmsg.close();               
                if(updateToDbFrmType == OTP_FOR_EMAIL){                 
                    $(emaildv).html(t.html);
                }else{
                    $(phoneNumberdv + " .otpForm-js").remove();
                    var lastFormElement = phoneNumberdv + ' form:last';
                    $(lastFormElement).after(t.html);                    
                } 
                stylePhoneNumberFld();
            } else {
                fcom.displaySuccessMessage(t.msg);
                changePhoneNumberForm();
            }
        });
        return false;
    };

})();
