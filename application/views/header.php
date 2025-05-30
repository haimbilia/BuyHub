<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

array_walk($jsVariables, function (&$item1, $key) {
    $item1 = html_entity_decode($item1, ENT_QUOTES, 'UTF-8');
});
$commonHeadData = array(
    'siteLangId' => $siteLangId,
    'controllerName' => $controllerName,
    'action' => $action,
    'jsVariables' => $jsVariables,
    'canonicalUrl' => isset($canonicalUrl) ? $canonicalUrl : '',
);

if (isset($socialShareContent) && $socialShareContent != '') {
    $commonHeadData['socialShareContent'] = $socialShareContent;
}

$this->includeTemplate('_partial/header/commonHeadTop.php', $commonHeadData, false);
/* This is not included in common head, because, commonhead file not able to access the $this->Controller and $this->action[ */
echo $this->writeMetaTags();
/* ] */
$this->includeTemplate('_partial/header/commonHeadMiddle.php', $commonHeadData, false);

/* This is not included in common head, because, if we are adding any css/js from any controller then that file is not included[ */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE);
/* ] */

$this->includeTemplate('_partial/header/commonHeadBottom.php', $commonHeadData, false);

if (!isset($exculdeMainHeaderDiv) || false == $exculdeMainHeaderDiv) {
    $this->includeTemplate('_partial/topHeader.php', array('siteLangId' => $siteLangId, 'layoutType' => applicationConstants::SCREEN_DESKTOP, 'controllerName' => $controllerName), false);
}

if (!$isAppUser) {
    switch (strtolower($controllerName)) {
        case 'checkout':
        case 'walletpay':
        case 'subscriptioncheckout':
            $this->includeTemplate('_partial/header/checkout-header.php', array('siteLangId' => $siteLangId, 'headerData' => $headerData, 'controllerName' => $controllerName, 'action' => $action), false);
            break;
    }
}