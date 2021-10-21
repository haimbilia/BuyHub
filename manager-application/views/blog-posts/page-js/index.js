(function () {
    postImages = function (post_id) {
        fcom.resetEditorInstance();
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('BlogPosts', 'imagesForm', [post_id]), '', function (t) {
            loadImages(post_id);
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    loadImages = function (post_id, lang_id) {
        fcom.ajax(fcom.makeUrl('BlogPosts', 'images', [post_id, lang_id]), '', function (t) {
            $('#imageListingJs').html(t);
        });
    };

    deleteImage = function (post_id, afile_id, lang_id) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.ajax(fcom.makeUrl('BlogPosts', 'deleteImage', [post_id, afile_id, lang_id]), '', function (t) {
            var ans = $.parseJSON(t);
            if (ans.status == 0) {
                $.ykmsg.error(ans.msg);
                return;
            }
            
            $.ykmsg.success(ans.msg);
            loadImages(post_id, lang_id);
        });
    }

})();