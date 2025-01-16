(function () {
    viewRecord = function (recordId) {
        data = "recordId=" + recordId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "view"), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false, "modal-dialog-vertical-lg");
            fcom.removeLoader();
        });
    };
})();