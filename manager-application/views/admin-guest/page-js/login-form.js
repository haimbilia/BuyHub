(function () {
    login = function (frm, v) {
        if (!$(frm).validate()){
            return;
        }            
        if (!v.isValid()){
           return; 
        }            
        var data = fcom.frmData(frm);
        fcom.displayProcessing();
        fcom.updateWithAjax(fcom.makeUrl('AdminGuest', 'login'), data, function (t) {
            $.ykmsg.close();
            $.ykmsg.success(t.msg);
            location.href = t.redirectUrl;
        });
    }

    sendResetPasswordLink = function (user) {
        if (user == '') {
            return false;
        }
        fcom.displayProcessing();
        fcom.updateWithAjax(fcom.makeUrl("adminGuest", "sendResetPasswordLink", [user]), '', function (t) {
            if (t.status) {
                $.ykmsg.success(t.msg);
            } else {
                $.ykmsg.error(t.errorMsg);
            }
        });
        return false;
    }

})();
