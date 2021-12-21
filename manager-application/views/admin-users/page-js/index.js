(function () {
    changeUserPassword = function (id) {
        $.ykmodal(fcom.getLoader(), true);
        fcom.ajax(fcom.makeUrl(controllerName, 'changePassword', [id]), '', function (t) {
            $.ykmodal(t, true);
            fcom.removeLoader();
        });
    };

    updatePassword = function (frm) {
        if (!$(frm).validate()) return;
        $.ykmodal(fcom.getLoader(), true);
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updatePassword'), data, function (t) {
            fcom.removeLoader();
            reloadList();
            $.ykmodal.close();
        });
    }
})();
