<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm, 6);
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->setFormTagAttribute('onsubmit', 'setupPromotion(this); return(false);');

if (User::isSeller()) {
    $shopFld = $frm->getField('promotion_shop');
    $shopFld->setWrapperAttribute('class', 'promotion_shop_fld');
    $shopFld->htmlAfterField = '<p class="note">' . Labels::getLabel('LBL_Note:_Used_to_promote_shop.', $siteLangId) . '</p>';

    $shopCpcFld = $frm->getField('promotion_shop_cpc');
    $shopCpcFld->setWrapperAttribute('class', 'promotion_shop_fld');
    $shopCpcFld->htmlAfterField = '<p class="note">' . Labels::getLabel('MSG_PPC_cost_per_click_for_shop', $siteLangId) . '</p>';

    $productFld = $frm->getField('promotion_product');
    $productFld->setWrapperAttribute('class', 'promotion_product_fld');
    $productFld->htmlAfterField = '<p class="note">' . Labels::getLabel('LBL_Note:_Used_to_promote_product.', $siteLangId) . '</p>';

    $productCpcFld = $frm->getField('promotion_product_cpc');
    $productCpcFld->setWrapperAttribute('class', 'promotion_product_fld');
    $productCpcFld->htmlAfterField = '<p class="note">' . Labels::getLabel('MSG_PPC_cost_per_click_for_Product', $siteLangId) . '</p>';
}

$locationFld = $frm->getField('banner_blocation_id');
$locationFld->setFieldTagAttribute('id', 'banner_blocation_id');
$locationFldId = $locationFld->getFieldTagAttribute('id');
$locationFld->setWrapperAttribute('class', 'location_fld');

$slideUrlFld = $frm->getField('slide_url');
$slideUrlFld->setWrapperAttribute('class', 'slide_url_fld');
$slideUrlFld->htmlAfterField = '<p class="note">' . Labels::getLabel('LBL_Note:_Used_to_promote_through_slider.', $siteLangId) . '</p>';

$slideCpcFld = $frm->getField('promotion_slides_cpc');
$slideCpcFld->setWrapperAttribute('class', 'slide_url_fld');
$slideCpcFld->htmlAfterField = '<p class="note">' . Labels::getLabel('MSG_PPC_cost_per_click_for_Slides', $siteLangId) . '</p>';

$urlFld = $frm->getField('banner_url');
$urlFld->setWrapperAttribute('class', 'banner_url_fld');
$urlFld->htmlAfterField = '<p class="note">' . Labels::getLabel('LBL_Note:_Used_to_promote_through_banner.', $siteLangId) . '</p>';

/* $btnSubmitFld = $frm->getField('btn_submit');
$btnSubmitFld->setFieldTagAttribute('class', 'btn btn-brand btn-wide'); */
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_PROMOTION_SETUP'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs">
            <a class="nav-link active" href="javascript:void(0);" title="<?php echo Labels::getLabel('NAV_GENERAL', $siteLangId); ?>" onclick="promotionForm(<?php echo $promotionId; ?>)"><?php echo Labels::getLabel('NAV_GENERAL', $siteLangId); ?></a>

            <a class="nav-link <?php echo (0 == $promotionId) ? 'fat-inactive' : ''; ?>" href="javascript:void(0);" <?php echo (0 < $promotionId) ? "onclick='promotionLangForm(" . $promotionId . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
            </a>
            <?php $inactive = ($promotionId == 0) ? 'fat-inactive' : ''; ?>
            <?php if ($promotionType == Promotion::TYPE_BANNER || $promotionType == Promotion::TYPE_SLIDES) { ?>
                <a class="nav-link <?php echo $inactive; ?>" href="javascript:void(0)" <?php if ($promotionId > 0) { ?> onclick="promotionMediaForm(<?php echo $promotionId; ?>)" <?php } ?>><?php echo Labels::getLabel('LBL_Media', $siteLangId); ?></a>
            <?php } ?>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs sectionbody space">
        <div class="row" id="promotionsChildBlockJs">
            <div class="col-md-12">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>

<script type="text/javascript">
    jQuery('.time').datetimepicker({
        datepicker: false,
        format: 'H:i',
        step: 10
    });

    $("document").ready(function() {
        var PROMOTION_TYPE_BANNER = <?php echo Promotion::TYPE_BANNER; ?>;
        var PROMOTION_TYPE_SHOP = <?php echo Promotion::TYPE_SHOP; ?>;
        var PROMOTION_TYPE_PRODUCT = <?php echo Promotion::TYPE_PRODUCT; ?>;
        var PROMOTION_TYPE_SLIDES = <?php echo Promotion::TYPE_SLIDES; ?>;

        $("select[name='promotion_type']").change(function() {
            var promotionType = $(this).val();
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

            fcom.updateWithAjax(fcom.makeUrl('Advertiser', 'getTypeData', [<?php echo $promotionId; ?>, promotionType]), '', function(t) {
                $.mbsmessage.close();
                if (t.promotionType == PROMOTION_TYPE_SHOP) {
                    $("input[name='promotion_shop']").val(t.label);
                } else if (t.promotionType == PROMOTION_TYPE_PRODUCT) {
                    $("input[name='promotion_product']").val(t.label);
                }
                $("input[name='promotion_record_id']").val(t.value);
            });
        });

        $("select[name='promotion_type']").trigger('change');

        $('input[name=\'promotion_product\']').autocomplete({
            'classes': {
                "ui-autocomplete": "custom-ui-autocomplete"
            },
            'source': function(request, response) {
                $.ajax({
                    url: fcom.makeUrl('Advertiser', 'autoCompleteSelprods'),
                    data: {
                        keyword: request['term'],
                        fIsAjax: 1
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        response($.map(json, function(item) {
                            return {
                                label: item['name'],
                                value: item['name'],
                                id: item['id']
                            };
                        }));
                    },
                });
            },
            'select': function(event, ui) {
                $("input[name='promotion_record_id']").val(ui.item.id);
            }
        });

    });
</script>