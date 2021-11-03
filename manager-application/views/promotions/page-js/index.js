$(document).on('change', '.language-js', function () {
    var langId = $(this).val();
    var promotion_id = $("form#frm_fat_id_frmPromotionMedia input[name='promotion_id']").val();
    var screen = $(".displayJs").val();
    images(promotion_id, langId, screen);
});

$(document).on('change', '.displayJs', function () {
    var screen = $(this).val();
    var promotion_id = $("form#frm_fat_id_frmPromotionMedia input[name='promotion_id']").val();
    var langId = $(".language-js").val();
    images(promotion_id, langId, screen);
});

$(document).on('blur', "input[name='promotion_budget']", function () {
    var frm = document.frmPromotion;
    var data = fcom.frmData(frm);
    fcom.ajax(fcom.makeUrl('Promotions', 'checkValidPromotionBudget'), data, function (t) {
        var ans = $.parseJSON(t);
        if (ans.status == 0) {
            $.mbsmessage(ans.msg, false, 'alert alert--danger');
            return;
        }
        $.mbsmessage.close();
    });
});

$(document).on('change', "select[name='banner_blocation_id']", function () {
    $("input[name='promotion_budget']").trigger('blur');
});

$(document).on('change', "select[name='promotion_type']", function() {
    setupFormType(this);
});

(function () {
    bindProductNameSelect2 = function () {
        select2("promotionRecordIdJs", fcom.makeUrl('Promotions', 'autoCompleteSelprods', [$('input[name="promotion_user_id"]').val()]), {},
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
    
})();

/* $(document).on('click', '.bannerFile-Js', function () {
    var node = this;
    $('#form-upload').remove();
    var promotionId = document.frmPromotionMedia.promotion_id.value;
    var langId = document.frmPromotionMedia.lang_id.value;
    var promotionType = document.frmPromotionMedia.promotion_type.value;
    var banner_screen = document.frmPromotionMedia.banner_screen.value;

    var frm = '<form enctype="multipart/form-data" id="form-upload" style="position:absolute; top:-100px;" >';
    frm = frm.concat('<input type="file" name="file" />');
    frm = frm.concat('<input type="hidden" name="promotion_id" value="' + promotionId + '"/>');
    frm = frm.concat('<input type="hidden" name="lang_id" value="' + langId + '"/>');
    frm = frm.concat('<input type="hidden" name="promotion_type" value="' + promotionType + '"/>');
    frm = frm.concat('<input type="hidden" name="banner_screen" value="' + banner_screen + '"/>');
    $('body').prepend(frm);
    $('#form-upload input[name=\'file\']').trigger('click');
    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }
    timer = setInterval(function () {
        if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);
            $val = $(node).val();
            $.ajax({
                url: fcom.makeUrl('Promotions', 'promotionUpload', [promotionId]),
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(node).val('Loading');
                },
                complete: function () {
                    $(node).val($val);
                },
                success: function (ans) {
                    $('#form-upload').remove();
                    images(promotionId, langId, banner_screen);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
}); */
