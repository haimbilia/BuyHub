<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm, 6);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this, "addBankInfoForm"); return(false);');
$dobFld = $frm->getField('user_dob');
$dobFld->addFieldTagAttribute('class', 'user_dob_js');

if ($recordId > 0) {
    $fld = $frm->getField('credential_username');
    $fld->setFieldTagAttribute('disabled', 'disabled');

    $fld = $frm->getField('credential_email');
    $fld->setFieldTagAttribute('disabled', 'disabled');

    $fld = $frm->getField('user_phone');
    $fld->setFieldTagAttribute('disabled', 'disabled');
}

$fld = $frm->getField('user_profile_info');
if ($fld != null) {
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}
$fld = $frm->getField('user_products_services');
if ($fld != null) {
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$countryFld = $frm->getField('user_country_id');
$countryFld->setFieldTagAttribute('id', 'addrCountryIdJs');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#addrStateIdJs\')');

$stateFld = $frm->getField('user_state_id');
$stateFld->setFieldTagAttribute('id', 'addrStateIdJs');

$formTitle = Labels::getLabel('LBL_USER_SETUP', $siteLangId);

$otherButtons = [];

if ($userParent == 0) {
    $otherButtons = [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'addBankInfoForm(' . $recordId . ')',
                'title' => Labels::getLabel('LBL_BANK_INFO', $siteLangId),
            ],
            'label' => Labels::getLabel('LBL_BANK_INFO', $siteLangId),
            'isActive' => false
        ]
    ];
}

$otherButtons[] = [
    'attr' => [
        'href' => 'javascript:void(0)',
        'onclick' => 'displayCookiesPerferences(' . $recordId . ')',
        'title' => Labels::getLabel('LBL_COOKIES_PREFERENCES', $siteLangId),
    ],
    'label' => Labels::getLabel('LBL_COOKIES_PREFERENCES', $siteLangId),
    'isActive' => false
];
$colWidthValuesDefault = 6;
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script language="javascript">
    $(document).ready(function() {
        getCountryStates($("#addrCountryIdJs").val(), <?php echo $stateId; ?>, '#addrStateIdJs');
    });
</script>