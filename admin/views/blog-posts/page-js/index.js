(function () {
    mediaForm = function (post_id) {
        fcom.resetEditorInstance();
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'imagesForm', [post_id]), '', function (t) {
            loadImages(post_id);
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    loadImages = function (post_id, lang_id) {      
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'images', [post_id, lang_id]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $('#imageListingJs').html(t.html);
          
        });
    };

    deleteImage = function (post_id, afile_id, lang_id) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.ajax(fcom.makeUrl(controllerName, 'deleteImage', [post_id, afile_id, lang_id]), '', function (t) {
            var ans = $.parseJSON(t);
            if (ans.status == 0) {
                fcom.displayErrorMessage(ans.msg);
                return;
            }
            
            fcom.displaySuccessMessage(ans.msg);
            loadImages(post_id, lang_id);
        });
    }

})();