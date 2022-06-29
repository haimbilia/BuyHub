
$(document).on('change', '#imageLanguageJs', function (e) {
    e.stopPropagation();
    let langId = $(this).val();
    let recordId = $(this).closest("form").find('input[name="banner_id"]').val();
    let slideScreen = $(this).closest("form").find('[name="banner_screen"]').val();
    let bannerLocationId = $(this).closest("form").find('[name="blocation_id"]').val();
    loadImages(bannerLocationId, recordId, 'logo', slideScreen, langId);
});

(function () {
    reloadList = function () {
        searchRecords(document.frmRecordSearch);
    };
    addNewBanner = function (bannerLocationId) {
        fcom.resetEditorInstance();
        $(".selectAllJs, .selectItemJs").prop("checked", false)
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'form'), { bannerLocationId }, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false, '');
            fcom.removeLoader();
        });
    };

    editRecord = function (recordId, bannerLocationId) {
        fcom.resetEditorInstance();
        data = { recordId, bannerLocationId };
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'form'), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    mediaForm = function (recordId, bannerLocationId, langId = 0, slide_screen = 1) {
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "media", [recordId, bannerLocationId, langId, slide_screen]),
            "",
            function (t) {
                fcom.closeProcessing();
                fcom.removeLoader();
                loadImages(bannerLocationId, recordId, "logo", slide_screen, langId);
                $.ykmodal(t.html);
            }
        );
    };

    loadImages = function (bannerLocationId, recordId, imageType, slide_screen, langId) {
        let slidescreen = $('#slideScreenJs').val();
        var data = { bannerLocationId, recordId, imageType, langId, screen: slidescreen };
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'images'), data, function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $('#imageListingJs').html(t.html);
        });
    };

    deleteMedia = function (bannerLocationId, recordId, afileId, fileType, langId, slideScreen) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeMedia'), { recordId, afileId, fileType, langId, slideScreen }, function (t) {
            loadImages(bannerLocationId, recordId, 'logo', slideScreen, langId);
            reloadList();
            $('.resetModalFormJs').click();
            fcom.displaySuccessMessage(t.msg);
        });
    };

})();