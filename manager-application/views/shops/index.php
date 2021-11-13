<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_NAME', $siteLangId);
$newRecordBtn = true;
$statusButtons = true;
$performBulkAction = true;
$searchFrmTemplate = FatUtility::camel2dashed(LibHelper::getControllerName()) . '/search-form.php';
require_once(CONF_THEME_PATH . '_partial/listing/index.php');
