
(function () {
    viewDetails = function (id, langId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'viewDetails', [id, langId]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    saveRecord = function (frm, pluginName = '') {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        var status = frm.withdrawal_status.value;
        var id = frm.withdrawal_id.value;
        var comment = frm.withdrawal_comments.value;
        if (status == transactionApprovedStatus && pluginName != '') {
            requestOutside(pluginName, id, status, comment);
            return;
        }

        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
            reloadList();
            $.ykmodal.close();
        });
    };

    requestOutside = function (pluginName, id, status, comment = '') {
        data = 'id=' + id + '&status=' + status + '&comment=' + comment;
        fcom.updateWithAjax(fcom.makeUrl(pluginName), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
            reloadList();
            $.ykmodal.close();
        });
    };
})();