<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$displayInPopup = (int)(Badge::COND_AUTO == $triggerType || BadgeLinkCondition::RECORD_TYPE_SHOP == $recordType);

$frm->setFormTagAttribute('data-onclear', 'editConditionRecord(' . $badgeId . ', ' . $recordId . ', ' . $displayInPopup . ')');

$fld = $frm->getField('blinkcond_user_id');
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

$fld = $frm->getField('badgelink_record_ids[]');
if (null != $fld) {
    $fld->setWrapperAttribute('id', 'recordIdSectionJs');
    $fld->addFieldTagAttribute('id', 'recordIdJs');
    $fld->addFieldTagAttribute('multiple', true);
}

$fld = $frm->getField('blinkcond_condition_type');
if (null != $fld) {
    $fld->addFieldTagAttribute('id', 'conditionTypeJs');
}

$fld = $frm->getField('blinkcond_condition_from');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
    $fld->addFieldTagAttribute('id', 'conditionFromJs');
    $fld->setWrapperAttribute('id', 'conditionFromSectionJs');
}

$fld = $frm->getField('blinkcond_condition_to');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
    $fld->addFieldTagAttribute('id', 'conditionToJs');
    $fld->setWrapperAttribute('id', 'conditionToSectionJs');
}

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script>
    var recordId = <?php echo $recordId; ?>;
    var recordType = <?php echo $recordType; ?>;
    var sellerId = <?php echo $sellerId; ?>;

    var triggerType = <?php echo $triggerType; ?>;

    var COND_AUTO = <?php echo Badge::COND_AUTO; ?>;
    var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
    var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
    var RECORD_TYPE_SHOP = <?php echo BadgeLinkCondition::RECORD_TYPE_SHOP; ?>;

    var COND_TYPE_AVG_RATING_SHOP = <?php echo BadgeLinkCondition::COND_TYPE_AVG_RATING_SHOP; ?>;
    var COND_TYPE_RETURN_ACCEPTANCE = <?php echo BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE; ?>;
    var COND_TYPE_ORDER_CANCELLED = <?php echo BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED; ?>;
    $(document).ready(function() {
        if (COND_AUTO == triggerType) {
            if (0 < $("#conditionTypeJs").length) {
                $("#conditionTypeJs").trigger("change");
            }
        } else {
            bindUserSelect2("sellerJs", {
                user_is_supplier: 1,
                joinShop: 1,
                credential_active: 1,
                credential_verified: 1
            });

            if (0 < recordId) {
                bindRecordsSelect2();
            }
        }
    });
</script>