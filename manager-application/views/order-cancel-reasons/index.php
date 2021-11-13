<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$deleteButton = true;
$newRecordBtn = true;
$performBulkAction = true;
$formAction = 'deleteSelected';
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_TITLE', $siteLangId);

require_once(CONF_THEME_PATH . '_partial/listing/index.php');
