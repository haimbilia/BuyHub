<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('data-onclear', 'editConditionRecord(' . $badgeId . ', ' . $recordId . ', ' . (BadgeLinkCondition::RECORD_TYPE_SHOP == $recordType) . ')');

$fld = $frm->getField('seller');
if (null != $fld) {
    $fld->addFieldTagAttribute('id', 'sellerJs');
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('blinkcond_record_type');
if (null != $fld) {
    $fld->addFieldTagAttribute('id', 'recordTypeJs');
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('blinkcond_from_date');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('blinkcond_to_date');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('badgelink_record_id');
if (null != $fld) {
    $fld->addFieldTagAttribute('id', 'recordIdJs');
    $fld->addFieldTagAttribute('multiple', true);
    $fld->addFieldTagAttribute('data-close-on-select', false);
}

$fld = $frm->getField('blinkcond_condition_from');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('blinkcond_condition_to');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script>
    var recordType = <?php echo $recordType; ?>;
    var sellerId = <?php echo $sellerId; ?>;

    var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
    var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
    var RECORD_TYPE_SHOP = <?php echo BadgeLinkCondition::RECORD_TYPE_SHOP; ?>;
    $(document).ready(function() {
        bindUserSelect2("sellerJs", {
            user_is_supplier: 1,
            joinShop: 1,
            credential_active: 1,
            credential_verified: 1
        });
    });

    var recordId = <?php echo $recordId; ?>;
    if (0 < recordId) {
        bindLinkToSelect2();
    }
</script>