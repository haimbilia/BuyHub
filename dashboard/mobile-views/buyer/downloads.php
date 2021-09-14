<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'downloads' => $downloads,
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
);

if (1 > $recordCount) {
    $status = applicationConstants::OFF;
}
