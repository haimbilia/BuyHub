editLangForm = function (pLangKey, langId, autoFillLangData = 0) {
    fcom.resetEditorInstance();
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'langForm', [pLangKey, langId, autoFillLangData]), '', function (t) {
        $.ykmodal(t.html, '', 'modal-dialog-vertical-md');
        fcom.removeLoader();
        fcom.setEditorLayout(langId);
        if (!navigator.clipboard) {
            $('[data-toggle="tooltip"]').removeAttr('title');
        }
    });
};

saveLangData = function (frm) {
    if (!$(frm).validate()) { return; }

    const data = fcom.frmData(frm);
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'langSetup'), data, function (res) {
        reloadList();
    });
};