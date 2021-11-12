<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$statusButtons = true;
$newRecordBtn = true;
$performBulkAction = true;
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_ZONE_NAME', $siteLangId);

require_once(CONF_THEME_PATH . '_partial/listing/index.php');
