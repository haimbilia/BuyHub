(function () {
    changeUserPassword = function (id) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(controllerName, 'changePassword', [id]), '', function (t) {
            $.ykmsg.close();
            $.ykmodal(t, true);
            fcom.removeLoader();
        });
    };

    updatePassword = function (frm) {
        if (!$(frm).validate()) return;
        $.ykmodal(fcom.getLoader());
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updatePassword'), data, function (t) {
            fcom.removeLoader();
            reloadList();
            $.ykmodal.close();
        });
    }
})();
