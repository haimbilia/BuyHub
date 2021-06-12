<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$headingLabel = Labels::getLabel('LBL_MANAGE_BADGE_REQUESTS', $adminLangId);
$listingLabel = Labels::getLabel('LBL_BADGE_REQUEST_LIST', $adminLangId);


require_once (CONF_THEME_PATH . '_partial/index-page-common.php');