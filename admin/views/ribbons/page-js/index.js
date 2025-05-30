
(function () {
    editRecord = function (recordId) {
        data = "recordId=" + recordId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    editLangData = function (recordId, langId, autoFillLangData = 0) {
        data = "recordId=" + recordId + "&langId=" + langId;
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "langForm", [autoFillLangData]),
            data,
            function (t) {
                fcom.closeProcessing();
                $.ykmodal(t.html);
                fcom.removeLoader();
            }
        );
    };
})();
