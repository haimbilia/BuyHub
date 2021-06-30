<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$badgeLbl = (Badge::TYPE_BADGE == $badgeType);
$headingLabel = $badgeLbl ? Labels::getLabel('LBL_MANAGE_BADGES', $siteLangId) : Labels::getLabel('LBL_MANAGE_RIBBONS', $siteLangId);
$listingLabel = $badgeLbl ? Labels::getLabel('LBL_BADGES_LIST', $siteLangId) : Labels::getLabel('LBL_RIBBONS_LIST', $siteLangId);

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');