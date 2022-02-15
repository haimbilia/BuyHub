(function () {   
    $(document).on('change', '.brandPrefRatioJs', function() {
        if ($(this).val() == ratioTypeSquare) {
            $(minWidthLogoEle).val(500);
            $(minHeightLogoEle).val(500);
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '500 x 500'));
        } else {
            $(minWidthLogoEle).val(500);
            $(minHeightLogoEle).val(280);
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '500 x 280'));
        }
    });
   
    $(document).on('change', '#brandlogoLanguageJs', function () {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="brand_id"]').val();
        loadImages(brand_id, 'logo', 0, lang_id);
    });

    $(document).on('change', '#brandBannerLanguageJs', function () {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="brand_id"]').val();
        var slide_screen = $("#slideScreenJs").val();
        loadImages(brand_id, 'image', slide_screen, lang_id);        
    });
})();

