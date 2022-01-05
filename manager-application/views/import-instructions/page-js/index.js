(function () {
    editLangData = function (recordId, langId, autoFillLangData = 0) {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();
        data = "recordId=" + recordId + "&langId=" + langId;
        $.ykmodal(fcom.getLoader(), false);
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "langForm", [autoFillLangData]),
            data,
            function (t) {
                $.ykmodal(t.html, false, "modal-dialog-vertical-md");
                fcom.removeLoader();
                $.ykmsg.close();
            }
        );
    };
})();