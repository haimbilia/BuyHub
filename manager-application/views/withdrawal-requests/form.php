<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$paymentMethods = User::getAffiliatePaymentMethodArr($siteLangId);
$payoutPlugins = Plugin::getNamesByType(Plugin::TYPE_PAYOUTS, $siteLangId);

$pluginKeyName = '';
if (!in_array($withdrawal_payment_method, array_keys($paymentMethods)) && in_array($withdrawal_payment_method, array_keys($payoutPlugins))) {
    $pluginKeyName = '"' . Plugin::getAttributesById($withdrawal_payment_method, 'plugin_code') . '"';
}
$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#' . $frm->getFormTagAttribute('id') . '")[0], ' . $pluginKeyName . '); return(false);');
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ')');

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    var transactionApprovedStatus = <?php echo Transactions::WITHDRAWL_STATUS_APPROVED ?>;
</script>