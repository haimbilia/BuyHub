<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'personalInfo' => (object)$personalInfo,
    'bankInfo' => (object)$bankInfo,
    'privacyPolicyLink' => UrlHelper::generateFullUrl('cms', 'view', array($privacyPolicyLink), CONF_WEBROOT_FRONTEND),
    'gdprPolicyLink' => UrlHelper::generateFullUrl('cms', 'view', array($gdprPolicyLink), CONF_WEBROOT_FRONTEND),
    'faqLink' => UrlHelper::generateFullUrl('custom', 'faq',[], CONF_WEBROOT_FRONTEND),
    'referralModuleIsEnabled' => FatApp::getConfig("CONF_ENABLE_REFERRER_MODULE", FatUtility::VAR_INT, 0),
    'hasDigitalProducts' => $hasDigitalProducts,
    'splitPaymentMethods' => array_values($splitPaymentMethods),
);

if (empty((array)$personalInfo) && empty((array)$bankInfo)) {
    $status = applicationConstants::OFF;
}
