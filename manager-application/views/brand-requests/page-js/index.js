
(function () {
    mediaForm = function (banner_id, langId = 0, slide_screen = 1) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Brands', 'media', [banner_id, langId, slide_screen]), '', function (t) {
            $.ykmodal(t);
            brandImages(banner_id, 'logo', slide_screen, langId);
            brandImages(banner_id, 'image', slide_screen, langId);
            fcom.removeLoader();
        });
    };

    brandImages = function (brandId, fileType, slide_screen, langId) {
        fcom.ajax(fcom.makeUrl('Brands', 'images', [brandId, fileType, langId, slide_screen]), '', function (t) {
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
        fcom.updateWithAjax(fcom.makeUrl('brands', 'removeBrandMedia', [brandId, fileType, afileId]), '', function (t) {
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
    
    editRequestRecord = function (recordId, displayInPopup = false, dialogClass = '') {
        if (false === checkControllerName()) {
            return false;
        }
        $.ykmodal(fcom.getLoader(), displayInPopup, dialogClass);
        data = "recordId=" + recordId;
        fcom.ajax(fcom.makeUrl(controllerName, "requestForm"), data, function (t) {
            $.ykmodal(t, displayInPopup, dialogClass);
            fcom.removeLoader();
        });
    };

    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
            clearSearch();
        }); 
    };
    
    searchRequestRecords = function (frm) {

        if (false === checkControllerName()) {
            return false;
        }

        setColumnsData(frm);
        var data = "";
        if (frm) {
            data = fcom.frmData(frm);
        }
        var dv = ".listingRecordJs";
        var paginationDv = ".listingPaginationJs";
        var listingTableJs = ".listingTableJs";
        $(listingTableJs).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, "searchBrandRequests"), data, function (res) {
            var res = JSON.parse(res);
            if (res.headSection) {
                $('.tableHeadJs').replaceWith(res.headSection);
            }
            $(dv).replaceWith(res.listingHtml);
            $(paginationDv).replaceWith(res.paginationHtml);
            fcom.removeLoader();
            $(".selectAllJs").prop("checked", false);
            if (0 < $(".listingRecordJs .noRecordFoundJs").length) {
                $(".selectAllJs").prop("disabled", "disabled");
            } else {
                $(".selectAllJs").removeAttr("disabled");
            }
        });
    };
})();
$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});
