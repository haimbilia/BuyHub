<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$tableHeadAttrArr = isset($tableHeadAttrArr) ? $tableHeadAttrArr : [];
$tableId = isset($tableId) ?  $tableId : '';

$disableSelectAll = empty($arrListing) ? 'disabled="disabled"' : '';

/* No sorting functionality required if no record found. */
if (2 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tbl = new HtmlElement(
    'table',
    array('width' => '100%', 'class' => 'table table-dashed', 'id' => $tableId)
);
$th = $tbl->appendElement('thead', ['class' => 'tableHeadJs'])->appendElement('tr');
foreach ($fields as $key => $val) {
    $defaultSortingClass = HtmlHelper::getDefaultSortingClass($key, $sortBy, $sortOrder);
    
    $cls = '';
    if (in_array($key, $allowedKeysForSorting)) {
        $cls .= 'headerColumnJs sorting ' . $defaultSortingClass;
    }

    if ('action' == strtolower($key)) {
        $cls .= !empty($cls) ? ' ' : '';
        $cls .= 'align-right';
    }

    $thWidth = '';
    if (!empty($tableHeadAttrArr) && array_key_exists($key, $tableHeadAttrArr)) {
        $thWidth = $tableHeadAttrArr[$key]['width'] ?? '';
    }
    
    if (!empty($tableHeadAttrArr) && array_key_exists($key, $tableHeadAttrArr)) {
        $cls .= !empty($cls) ? ' ' : '';
        $cls .= $tableHeadAttrArr[$key]['class'] ?? '';
    }

    if ('listSerial' == $key) {
        $cls .= !empty($cls) ? ' ' : '';
        $cls .= 'col-sr';
    } else if ('select_all' == $key) {
        $cls .= !empty($cls) ? ' ' : '';
        $cls .= 'col-check';
    }

    $td = $th->appendElement('th', ['class' => $cls, 'data-field' => $key, 'width' => $thWidth]);
    $span = $td->appendElement('span');

    switch ($key) {
        case 'select_all':
            $span->appendElement('plaintext', [], '<label class="checkbox"><input title="' . $val . '" type="checkbox" ' . $disableSelectAll . ' onclick="selectAll(this)" class="selectAllJs"><i class="input-helper"></i></label>', true);
            break;
        default:
            $span->appendElement('plaintext', [], $val, true);
            break;
    }
}
$tbody = $tbl->appendElement('tbody', ['class' => 'listingRecordJs']);
