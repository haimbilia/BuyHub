<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('addr_title');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('addr_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('addr_country_id');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->setFieldTagAttribute('id', 'addrCountryIdJs');
$fld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#addrStateIdJs\')');

$fld = $frm->getField('addr_state_id');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->setFieldTagAttribute('id', 'addrStateIdJs');

$fld = $frm->getField('addr_city');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('addr_zip');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

if (1 > $user_id) {
    $fld = $frm->getField('addr_record_id');
    $fld->addFieldTagAttribute('id', 'userIdJs');
    $fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_SELECT_USER', $siteLangId));
}

$formTitle = Labels::getLabel('LBL_USER_ADDRESS_SETUP', $siteLangId);

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    $(document).ready(function() {
        bindUserSelect2('userIdJs');
        <?php if (0 < $stateId) { ?>
            getCountryStates($("#addrCountryIdJs").val(), <?php echo $stateId; ?>, '#addrStateIdJs');
        <?php } ?>

        setTimeout(() => {
            stylePhoneNumberFld('.phoneJs');
        }, 200);
    });
</script>