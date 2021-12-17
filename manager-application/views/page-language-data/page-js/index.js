editLangForm = function (pLangKey, langId, autoFillLangData = 0) {
    $.ykmodal(fcom.getLoader());
    fcom.resetEditorInstance();
    fcom.ajax(fcom.makeUrl(controllerName, 'langForm', [pLangKey, langId, autoFillLangData]), '', function (t) {
        $.ykmodal(t, '', 'modal-dialog-vertical-md');
        fcom.removeLoader();
        fcom.setEditorLayout(langId);
        if(!navigator.clipboard){
            $('[data-toggle="tooltip"]').removeAttr('title');
        }        
    });
};

saveLangData = function (frm) {
    if (!$(frm).validate()) { return; }
    $.ykmodal(fcom.getLoader());

    const data = fcom.frmData(frm);
    fcom.ajax(fcom.makeUrl(controllerName, 'langSetup'), data, function (res) {
        fcom.removeLoader();
        let t = JSON.parse(res);
        if (t.status == 0) {
            $.ykmsg.error(t.msg);
            return false;
        }
        $.ykmsg.success(t.msg);
        reloadList();

    });
};