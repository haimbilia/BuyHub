

editLangForm = function (pLangKey, langId, autoFillLangData = 0) {
    $.ykmodal(fcom.getLoader());
    //fcom.resetEditorInstance();
    fcom.ajax(fcom.makeUrl(controllerName, 'Form', [pLangKey, langId, autoFillLangData]), '', function (t) {
        $.ykmodal(t, '', 'modal-dialog-vertical-md');
        fcom.removeLoader();
        fcom.setEditorLayout(langId);
        if(!navigator.clipboard){
            $('[data-toggle="tooltip"]').removeAttr('title');
        }else{
            $('[data-toggle="tooltip"]').tooltip();
        }
        
    });
};