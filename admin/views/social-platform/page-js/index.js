(function () {
    mediaForm = function (recordId) {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "media", [recordId]), "",
            function (t) {
                fcom.closeProcessing();
                fcom.removeLoader();                
                $.ykmodal(t.html, !$.ykmodal.isSideBarView());
            }
        );
    };   
    mediaFormCallback = function (t) {     
        mediaForm(t.recordId)        
    };

    deleteMedia = function (recordId) {
        if (false === checkControllerName()) {
            return false;
        }

        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "removeMedia"),
            {recordId},
            function (t) {
                fcom.displaySuccessMessage(t.msg);
                mediaForm(recordId)        
            }
        );
    };
})();