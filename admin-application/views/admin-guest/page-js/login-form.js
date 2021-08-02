(function () {
    login = function (frm, v) {
        if (!$(frm).validate()) return;
        if (!v.isValid()) return;
        var data = fcom.frmData(frm);
        $.mbsmessage(langLbl.processing, false, 'alert--process');
        fcom.ajax(fcom.makeUrl('AdminGuest', 'login'), data, function (t) {
            $.mbsmessage.close();
            try {
                t = $.parseJSON(t);
                if (t.errorMsg) {
                    $.mbsmessage(t.errorMsg, true, 'alert--danger');
                    return false;
                }
                $.mbsmessage(t.msg, true, 'alert--success');
            }
            catch (exc) {
                console.log(exc);
            }
            location.href = t.redirectUrl;
        });
    }

    sendResetPasswordLink = function (user) {
        if (user == '') {
            return false;
        }
        $.mbsmessage(langLbl.processing, false, 'alert--process');
        fcom.updateWithAjax(fcom.makeUrl("adminGuest", "sendResetPasswordLink", [user]), '', function (t) {
            if (t.status) {
                $.mbsmessage(t.msg, true, 'alert--success');
            }
            else {
                $.mbsmessage(t.msg, true, 'alert--danger');
            }
        });
        return false;
    }

})();
