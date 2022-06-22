<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('promotion_budget');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('promotion_start_date');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('promotion_end_date');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('promotion_start_time');
$fld->htmlAfterField = '<span class="form-text">' . Labels::getLabel('LBL_SERVER_TIME', $siteLangId).': '.FatDate::format('now', true) . '</span>';
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('promotion_end_time');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('promotion_approved');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('promotion_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('promotion_type');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->setFieldTagAttribute('disabled', 'disabled');

$fld = $frm->getField('promotion_duration');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$shopFld = $frm->getField('promotion_shop');
$shopFld->setWrapperAttribute('class', 'promotion_shop_fld');
$shopFld->htmlAfterField = '<span class="form-text">' . Labels::getLabel('LBL_Note:_Used_to_promote_shop.', $siteLangId) . '</span>';

$shopCpcFld = $frm->getField('promotion_shop_cpc');
$shopCpcFld->setWrapperAttribute('class', 'promotion_shop_fld');
$shopCpcFld->htmlAfterField = '<span class="form-text">' . Labels::getLabel('LBL_PPC_cost_per_click_for_shop', $siteLangId) . '</span>';
$shopCpcFld->developerTags['colWidthValues'] = [null, '6', null, null];

$productFld = $frm->getField('promotion_product');
$productFld->setFieldTagAttribute('id', 'promotionRecordIdJs');
$productFld->setWrapperAttribute('class', 'promotion_product_fld');
$productFld->htmlAfterField = '<span class="form-text">' . Labels::getLabel('LBL_Note:_Used_to_promote_product.', $siteLangId) . '</span>';

$productCpcFld = $frm->getField('promotion_product_cpc');
$productCpcFld->setWrapperAttribute('class', 'promotion_product_fld');
$productCpcFld->htmlAfterField = '<span class="form-text">' . Labels::getLabel('LBL_PPC_cost_per_click_for_Product', $siteLangId) . '</span>';
$productCpcFld->developerTags['colWidthValues'] = [null, '6', null, null];

$locationFld = $frm->getField('banner_blocation_id');
$locationFld->setWrapperAttribute('class', 'location_fld');
$locationFld->developerTags['colWidthValues'] = [null, '6', null, null];

$urlFld = $frm->getField('banner_url');
$urlFld->setWrapperAttribute('class', 'banner_url_fld');
$urlFld->htmlAfterField = '<span class="form-text">' . Labels::getLabel('LBL_Note:_Used_to_promote_through_banner.', $siteLangId) . '</span>';

$slideUrlFld = $frm->getField('slide_url');
$slideUrlFld->setWrapperAttribute('class', 'slide_url_fld');
$slideUrlFld->htmlAfterField = '<span class="form-text">' . Labels::getLabel('LBL_Note:_Used_to_promote_through_slider.', $siteLangId) . '</span>';

$slideCpcFld = $frm->getField('promotion_slides_cpc');
$slideCpcFld->setWrapperAttribute('class', 'slide_url_fld');
$slideCpcFld->htmlAfterField = '<span class="form-text">' . Labels::getLabel('LBL_PPC_cost_per_click_for_Slides', $siteLangId) . '</span>';
$slideCpcFld->developerTags['colWidthValues'] = [null, '6', null, null];

$otherButtons = [];
if ($promotionType == Promotion::TYPE_BANNER || $promotionType == Promotion::TYPE_SLIDES) {
    $otherButtons = [
        [
            'attr' => [
                 'href' => 'javascript:void(0)',
                 'onclick' => 'promotionMediaForm(' . $recordId . ', 0, ' . applicationConstants::SCREEN_DESKTOP . ')',
                 'title' => Labels::getLabel('LBL_Media', $siteLangId)
             ],
             'label' => Labels::getLabel('LBL_Media', $siteLangId),
             'isActive' => false
         ]
    ];
}

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        bindProductNameSelect2();
        setupFormType($("select[name='promotion_type']")[0]);
    });
</script>