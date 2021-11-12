<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$statusButtons = true;
$deleteButton = true;
$newRecordBtn = true;
$performBulkAction = true;
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_STATE_NAME_AND_CODE', $siteLangId);

$searchFrmTemplate = FatUtility::camel2dashed(LibHelper::getControllerName()) . '/search-form.php';
require_once(CONF_THEME_PATH . '_partial/listing/index.php');
