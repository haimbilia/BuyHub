<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm, 6);
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#' . $frm->getFormTagAttribute('id') . '")[0]); return(false);');

if (0 < $counterOfferId) {
    $frm->setFormTagAttribute('data-onclear', 'counter(' . $counterOfferId . ', ' . $rfqId . ')');
} else {
    $frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', ' . $rfqId . ')');
}

$fld = $frm->getField('offer_comments');
$fld->developerTags['colWidthValues'] = [null, '12', null, null];

$fld = $frm->getField('offer_negotiable');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$fld = $frm->getField('offer_expired_on');
if (null != $fld) {
    $fld->addfieldTagAttribute('class', 'fldDateJs');
}

$unitLabel =  applicationConstants::getWeightUnitName($siteLangId, $rfq_quantity_unit) . '[' . CommonHelper::getCurrencySymbol() . ']';

$fld = $frm->getField('offer_price');
$fld->changeCaption(Labels::getLabel('FRM_OFFER_PRICE_PER_' . $unitLabel));

$fld = $frm->getField('offer_cost');
if (null != $fld) {
    $fld->changeCaption(Labels::getLabel('FRM_OFFER_COST_PER_' . $unitLabel));
}

$fld = $frm->getField('offer_quantity');
if (null != $fld) {
    if (false == RfqOffers::isPosted($rfqId, 0, $recordId)) {
        $fld->addfieldTagAttribute('readOnly', 'true');
    }
    $fld->changeCaption(Labels::getLabel('LBL_OFFER_QUANTITY[' . applicationConstants::getWeightUnitName($siteLangId, $rfq_quantity_unit, true) . ']'));
}
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_RFQ_OFFER_FORM', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>
<script>
    $(document).ready(function() {
        var date = new Date();
        date.setDate(date.getDate() + 1);
        $('.fldDateJs').datepicker('option', {
            minDate: date,
            onClose: function() {
                $(this).closest('form').find('[type="submit"]').focus();
            }
        });
        
        $(document).mousedown(function(){
            if ($.datepicker.initialized && !$(".fldDateJs").datepicker( "widget" ).is(":visible")) {
                $('.submitBtnJs').focus();
            }
        });
    });
</script>