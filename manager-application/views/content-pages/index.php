<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$statusButtons = false;
$newRecordBtn = true;
$performBulkAction = true;
$deleteButton = true;
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_TITLE', $siteLangId);

require_once(CONF_THEME_PATH . '_partial/listing/index.php'); 