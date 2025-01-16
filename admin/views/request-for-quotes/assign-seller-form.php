<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'assignSeller($("#' . $frm->getFormTagAttribute('id') . '")[0]); return(false);');
$frm->setFormTagAttribute('data-onclear', 'assignSellerForm(' . $recordId . ')');
$fld = $frm->getField('rfqts_user_id');
$fld->setFieldTagAttribute('id', 'aSellerJs');
$fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_USER_NAME,_EMAIL_OR_SHOP_NAME', $siteLangId));

$extraBodyParts = '<h6 class="h6">' . Labels::getLabel('LBL_SELECTED_SELLERS') . '</h6>
                    <ul class="list-bullet">';
foreach ($selectedSellers as $userId => $shopuser) {
    $extraBodyParts .= '<li class="list-bullet-item">' . $shopuser . '</li>';
}
$extraBodyParts .= '</ul>';

$extraBodyParts = empty($selectedSellers) ? '' : $extraBodyParts;
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
