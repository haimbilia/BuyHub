$(document).on('change', '.languageJs', function () {
    var form = $(this).closest('form');
    var langId = $(this).val();
    var promotion_id = $("input[name='record_id']", form).val();
    var screen = $(".displayJs").val();
    images(promotion_id, langId, screen);
});

$(document).on('change', '.displayJs', function () {
    var form = $(this).closest('form');
    var screen = $(this).val();
    var promotion_id = $("input[name='record_id']", form).val();
    var langId = $(".languageJs").val();
    images(promotion_id, langId, screen);
});

$(document).on('blur', "input[name='promotion_budget']", function () {
    var frm = document.frmPromotion;
    var data = fcom.frmData(frm);
    fcom.ajax(fcom.makeUrl(controllerName, 'checkValidPromotionBudget'), data, function (t) {
        var ans = $.parseJSON(t);
        if (ans.status == 0) {
            fcom.displayErrorMessage(ans.msg);
            return;
        }
    });
});

$(document).on('change', "select[name='banner_blocation_id']", function () {
    $("input[name='promotion_budget']").trigger('blur');
});

$(document).on('change', "select[name='promotion_type']", function () {
    setupFormType(this);
});

(function () {
    bindProductNameSelect2 = function () {
        select2("promotionRecordIdJs", fcom.makeUrl(controllerName, 'autoCompleteSelprods', [$('input[name="promotion_user_id"]').val()]), {},
            function (e) {
                $("input[name='promotion_record_id']").val(e.params.args.data.id);
            }, function (e) {
                $("input[name='promotion_record_id']").val('');
            });
    }

    setupFormType = function (element) {
        var promotionType = $(element).val();
        $(".promotion_shop_fld").hide();
        $(".promotion_product_fld").hide();
        $(".banner_url_fld").hide();
        $(".location_fld").hide();
        $(".slide_url_fld").hide();

        if (promotionType == PROMOTION_TYPE_BANNER) {
            $(".banner_url_fld").show();
            $(".location_fld").show();
        }

        if (promotionType == PROMOTION_TYPE_SHOP) {
            $(".promotion_shop_fld").show();
        }

        if (promotionType == PROMOTION_TYPE_PRODUCT) {
            $(".promotion_product_fld").show();
        }

        if (promotionType == PROMOTION_TYPE_SLIDES) {
            $(".slide_url_fld").show();
        }
    };

    promotionMediaForm = function (recordId, langId = 0, screen_id = 1) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "media", [recordId]), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
            images(recordId, langId, screen_id);
        });
    };

    images = function (promotion_id, lang_id, screen_id) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'images', [promotion_id, lang_id, screen_id]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $("#imageListingJs").html(t.html);
        });
    };

    removeMedia = function (promotionId, bannerId, langId, screen) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        data = 'promotionId=' + promotionId + '&bannerId=' + bannerId + '&langId=' + langId + '&screen=' + screen;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeMedia'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            images(promotionId, langId, screen);
        });
    };
})();