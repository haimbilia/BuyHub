(function () {
    forgotPassword = function (frm, v) {
        if (!$(frm).validate() || !v.isValid()) {
            return;
        }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl("adminGuest", "forgotPassword"), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            frm.reset();
        });
    }
})();
