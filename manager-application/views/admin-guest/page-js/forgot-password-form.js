(function () {
    forgotPassword = function (frm, v) {
        if (!$(frm).validate() || !v.isValid()) {
            return;
        }       
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl("adminGuest", "forgotPassword"), data, function (t) {
            $.ykmsg.success(t.msg);
            frm.reset();
        });
        googleCaptcha();
        return false;
    }
})();
