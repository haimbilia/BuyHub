(function () {
    getComment = function (recordId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "getComment"), "recordId=" + recordId, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };
})();