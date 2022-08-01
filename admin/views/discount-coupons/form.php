<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (!empty($onClear)) {
    $frm->setFormTagAttribute('data-onclear', $onClear);
}

$fld = $frm->getField('coupon_title');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('coupon_code');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('coupon_type');
$fld->addFieldTagAttribute('onChange', 'callCouponTypePopulate(this.value); ');
$fld->addFieldTagAttribute('id', 'couponType');

$fld = $frm->getField('coupon_discount_in_percent');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->addFieldTagAttribute('onChange', 'callCouponDiscountIn(this.value, ' . applicationConstants::PERCENTAGE . ', ' . applicationConstants::FLAT . '); ');
$fld->addFieldTagAttribute('class', 'discountTypeJs');

$fld = $frm->getField('coupon_min_order_value');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('coupon_discount_value');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->addFieldTagAttribute('class', 'discountValueJs');

$fld = $frm->getField('coupon_max_discount_value');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->setWrapperAttribute('id', 'coupon_max_discount_value_div');

$fld = $frm->getField('coupon_start_date');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->addFieldTagAttribute('class', 'couponDateJs');
$fld->htmlAfterField = '<br/><span class=form-text text-muted">' . Labels::getLabel('FRM_CURRENT_DATE_WILL_BE_SELECTED_IF_"DATE_FROM"_NOT_SET.') . ' </span>';

$fld = $frm->getField('coupon_end_date');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->addFieldTagAttribute('class', 'couponDateJs');
$fld->htmlAfterField = '<br/><span class=form-text text-muted">' . Labels::getLabel('FRM_DATE_OF_MAXIMUM_YEAR_FROM_CALENDAR_WILL_BE_SELECTED_IF_"DATE_TO"_NOT_SET.') . ' </span>';

$fld = $frm->getField('coupon_uses_count');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('coupon_uses_coustomer');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('coupon_active');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;
if (true === $isExpired) {
    /* $fld->addFieldTagAttribute('disabled', 'disabled');
    $fld->addFieldTagAttribute('data-bs-toggle', 'tooltip');
    $fld->addFieldTagAttribute('data-bs-placement', 'top');
    $fld->addFieldTagAttribute('title', Labels::getLabel("LBL_EXPIRED", $siteLangId)); */
}

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
];

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>
<script type="text/javascript">
    $(document).ready(function() {
        callCouponTypePopulate(<?php echo $coupon_type; ?>);
        callCouponDiscountIn(<?php echo $couponDiscountIn; ?>, <?php echo applicationConstants::PERCENTAGE; ?>, <?php echo applicationConstants::FLAT; ?>);
    });
    var PERCENTAGE = <?php echo applicationConstants::PERCENTAGE; ?>;
    var currentYear = (new Date().getFullYear());
    $('.couponDateJs').datepicker('option', {
        yearRange: (currentYear - 5) + ':' + (currentYear + 50)
    });
</script>