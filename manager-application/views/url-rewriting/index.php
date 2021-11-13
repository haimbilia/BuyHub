<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_ORIGINAL_AND_CUSTOM', $siteLangId);
$statusButtons = false;
$newRecordBtn = true;
$deleteButton = true;
$performBulkAction = true;
$formAction = 'deleteSelected';
$searchFrmTemplate = FatUtility::camel2dashed(LibHelper::getControllerName()) . '/search-form.php';
require_once(CONF_THEME_PATH . '_partial/listing/index.php');
