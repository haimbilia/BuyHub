(function () {
    changeUserPassword = function (id) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'changePassword', [id]), '', function (t) {
            $.ykmodal(t.html, true);
            fcom.removeLoader();
            $.ykmsg.close();
        });
    };

    updatePassword = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updatePassword'), data, function (t) {
            fcom.removeLoader();
            $.ykmodal.close();
        });
    }
})();
