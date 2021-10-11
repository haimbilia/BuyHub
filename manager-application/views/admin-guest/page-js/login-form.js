(function () {
    login = function (frm, v) {
        if (!$(frm).validate()){
            return;
        }            
        if (!v.isValid()){
           return; 
        }            
        var data = fcom.frmData(frm);       
        fcom.updateWithAjax(fcom.makeUrl('AdminGuest', 'login'), data, function (t) {
            $.ykmsg.close();           
            location.href = t.redirectUrl;
        });
    }

    sendResetPasswordLink = function (user) {
        if (user == '') {
            return false;
        }
        
        fcom.updateWithAjax(fcom.makeUrl("adminGuest", "sendResetPasswordLink", [user]), '', function (t) {
            if (0 == t.status) {
                $.ykmsg.error(t.errorMsg);
                return false;
            }
            $.ykmsg.success(t.msg);
        });
    }

})();
