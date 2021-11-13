<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_CATEGORY_NAME', $siteLangId);
$statusButtons = true;
$newRecordBtn = true;
$deleteButton = true;
$performBulkAction = true;
require_once(CONF_THEME_PATH . '_partial/listing/index.php');
