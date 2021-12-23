
(function () {
    editRecord = function (recordId) {
        $.ykmodal(fcom.getLoader(), true);
        data = "recordId=" + recordId;
        fcom.ajax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            $.ykmodal(t, true);
            fcom.removeLoader();
        });
    };

    editLangData = function (recordId, langId, autoFillLangData = 0) {
        $.ykmodal(fcom.getLoader(), true);
        data = "recordId=" + recordId + "&langId=" + langId;
        fcom.ajax(
            fcom.makeUrl(controllerName, "langForm", [autoFillLangData]),
            data,
            function (t) {
                $.ykmodal(t, true);
                fcom.removeLoader();
            }
        );
    };
})();
