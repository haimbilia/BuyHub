(function () {
    brandImages = function (brandId, fileType, slide_screen, langId) {
        fcom.updateWithAjax(fcom.makeUrl('Brands', 'images', [brandId, fileType, langId, slide_screen]), '', function (t) {
            fcom.removeLoader();
            $.ykmsg.close();
            if (fileType == 'logo') {
                $('#logoListingJs').html(t.html);
            } else {
                $('#imageListingJs').html(t.html);
            }
        });
    };

    deleteMedia = function (brandId, fileType, afileId, langId, slide_screen) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        fcom.updateWithAjax(fcom.makeUrl('brands', 'removeMedia', [brandId, fileType, afileId]), '', function (t) {
            brandImages(brandId, fileType, slide_screen, langId);
            reloadList();
        });
    };

    $(document).on('change', '#logoLanguageJs', function () {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="brand_id"]').val();
        brandImages(brand_id, 'logo', 1, lang_id);
    });
    $(document).on('change', '#imageLanguageJs', function () {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="brand_id"]').val();
        var slide_screen = $("#slideScreenJs").val();
        brandImages(brand_id, 'image', slide_screen, lang_id);
    });
})();

