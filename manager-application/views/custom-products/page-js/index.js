
$(function () {
    select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), { 'joinShop': 1, 'user_is_supplier': 1 });
    requestStatusForm = function (recordId) {
        $.ykmodal(fcom.getLoader(), true);
        fcom.updateWithAjax(fcom.makeUrl('CustomProducts', "requestStatusForm", [recordId]), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };

    changeRequestStatus = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        if (!confirm(langLbl.areYouSure)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'changeRequestStatus'), data, function (t) {
            fcom.closeProcessing();
            closeForm();
            reloadList();
        });
    };
});