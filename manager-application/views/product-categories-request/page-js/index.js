
(function () {
    mediaForm = function (banner_id, langId = 0, slide_screen = 1) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('ProductCategoriesRequest', 'media', [banner_id, langId, slide_screen]), '', function (t) {
            $.ykmodal(t);
            images(banner_id, 'logo', slide_screen, langId);
            images(banner_id, 'image', slide_screen, langId);
            fcom.removeLoader();
        });
    };

    images = function (brandId, fileType, slide_screen, langId) {
        fcom.ajax(fcom.makeUrl('ProductCategoriesRequest', 'images', [brandId, fileType, langId, slide_screen]), '', function (t) {
            if (fileType == 'logo') {
                $('#logoListingJs').html(t);
            } else {
                $('#imageListingJs').html(t);
            }
        });
    };

    deleteMedia = function (brandId, fileType, afileId, langId, slide_screen) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('ProductCategoriesRequest', 'removeBrandMedia', [brandId, fileType, afileId]), '', function (t) {
            images(brandId, fileType, slide_screen, langId);
            reloadList();
        });
    };

    $(document).on('change', '#logoLanguageJs', function () {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="prodcat_id"]').val();
        images(ProductCategoriesRequest, 'logo', 1, lang_id);
    });
    $(document).on('change', '#imageLanguageJs', function () {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="prodcat_id"]').val();
        var slide_screen = $("#slideScreenJs").val();
        images(ProductCategoriesRequest, 'image', slide_screen, lang_id);
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
