
(function () {
    mediaForm = function (banner_id, langId = 0, slide_screen = 1) {
        fcom.updateWithAjax(fcom.makeUrl('BrandRequests', 'media', [banner_id, langId, slide_screen]), '', function (t) {
            $.ykmodal(t.html);
            brandImages(banner_id, 'logo', slide_screen, langId);
            brandImages(banner_id, 'image', slide_screen, langId);
            fcom.removeLoader();
        });
    };

    brandImages = function (brandId, fileType, slide_screen, langId) {
        fcom.updateWithAjax(fcom.makeUrl('BrandRequests', 'images', [brandId, fileType, langId, slide_screen]), '', function (t) {
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
        fcom.updateWithAjax(fcom.makeUrl('BrandRequests', 'removeBrandMedia', [brandId, fileType, afileId]), '', function (t) {
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

    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
            clearSearch();
        }); 
    }; 
})();

$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});
