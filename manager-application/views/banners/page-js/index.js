
$(document).on('change', '#imageLanguageJs', function (e) {
    e.stopPropagation();
    let langId = $(this).val();
    let recordId = $(this).closest("form").find('input[name="banner_id"]').val();
    let slideScreen = $(this).closest("form").find('[name="banner_screen"]').val();
    let bannerLocationId = $(this).closest("form").find('[name="blocation_id"]').val();
    (bannerLocationId, recordId, 'logo', slideScreen, langId);
});

(function () {
    addNewBanner = function (bannerLocationId) {
        fcom.resetEditorInstance();
        $(".selectAllJs, .selectItemJs").prop("checked", false)
        $.ykmodal(fcom.getLoader(), false, '');
        fcom.ajax(fcom.makeUrl(controllerName, 'form'), { bannerLocationId }, function (t) {
            $.ykmodal(t, false, '');
            fcom.removeLoader();
        });
    };

    editRecord = function (recordId, bannerLocationId) {
        fcom.resetEditorInstance();
        $.ykmodal(fcom.getLoader());
        data = { recordId, bannerLocationId };
        fcom.ajax(fcom.makeUrl(controllerName, 'form'), data, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    mediaForm = function (recordId, bannerLocationId, langId = 0, slide_screen = 1) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(
            fcom.makeUrl(controllerName, "media", [recordId, bannerLocationId, langId, slide_screen]),
            "",
            function (t) {
                fcom.removeLoader();
                loadImages(bannerLocationId, recordId, "logo", slide_screen, langId);
                $.ykmodal(t);
            }
        );
    };

    loadImages = function (bannerLocationId, recordId, imageType, slide_screen, langId) {
        let slidescreen = $('#slideScreenJs').val();
        var data = { bannerLocationId, recordId, imageType, langId, screen: slidescreen };
        console.log(data);
        fcom.ajax(fcom.makeUrl(controllerName, 'images'), data, function (t) {
            $('#imageListingJs').html(t);
            reloadList();
        });
    };

    deleteMedia = function (bannerLocationId, recordId, afileId, fileType, langId, slideScreen) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeMedia'), { recordId, afileId, fileType, langId, slideScreen }, function (t) {
            loadImages(bannerLocationId, recordId, 'logo', slideScreen, langId);
            reloadList();
            $('.resetModalFormJs').click();
        });
    };

})();