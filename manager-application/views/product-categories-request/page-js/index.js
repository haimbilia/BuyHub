
(function () {
    mediaForm = function (banner_id, langId = 0, slide_screen = 1) {
        fcom.updateWithAjax(fcom.makeUrl('ProductCategoriesRequest', 'media', [banner_id, langId, slide_screen]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
            images(banner_id, 'logo', slide_screen, langId);
            images(banner_id, 'image', slide_screen, langId);
        });
    };

    images = function (recordId, fileType, slide_screen, langId) {
        fcom.updateWithAjax(fcom.makeUrl('ProductCategoriesRequest', 'images', [recordId, fileType, langId, slide_screen]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            if (fileType == 'logo') {
                $('#logoListingJs').html(t.html);
            } else {
                $('#imageListingJs').html(t.html);
            }
        });
    };

    deleteMedia = function (brandId, fileType, afileId, langId, slide_screen) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('ProductCategoriesRequest', 'removeBrandMedia', [brandId, fileType, afileId]), '', function (t) {
            fcom.closeProcessing();
            images(brandId, fileType, slide_screen, langId);
            reloadList();
        });
    };

    $(document).on('change', '#logoLanguageJs', function () {
        var lang_id = $(this).val();
        var recordId = $(this).closest("form").find('input[name="prodcat_id"]').val();
        images(recordId, 'logo', 1, lang_id);
    });
    $(document).on('change', '#imageLanguageJs', function () {
        var lang_id = $(this).val();
        var recordId = $(this).closest("form").find('input[name="prodcat_id"]').val();
        var slide_screen = $("#slideScreenJs").val();
        images(recordId, 'image', slide_screen, lang_id);
    });


    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
            clearSearch();
        });
    };

})();
$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});
