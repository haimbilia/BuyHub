<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$tableHeadAttrArr = isset($tableHeadAttrArr) ? $tableHeadAttrArr : [];

$tbl = new HtmlElement(
    'table',
    array('width' => '100%', 'class' => 'table table-dashed')
);
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($fields as $key => $val) {
    $headColumData = HtmlHelper::getListingHeaderColumnHtml($key, $sortBy, $sortOrder);
    $cls = '';
    $html = '';
    if (in_array($key, $allowedKeysForSorting)) {
        $cls .= 'headerColumnJs sorting ' . $headColumData['class'];
        $html = $headColumData['html'];
    }

    if ('action' == strtolower($key)) {
        $cls .= 'align-right';
    }

    $thWidth = '';
    if (!empty($tableHeadAttrArr) && array_key_exists($key, $tableHeadAttrArr)) {
        $thWidth = $tableHeadAttrArr[$key]['width'];
    }

    $td = $th->appendElement('th', ['class' => $cls, 'data-field' => $key, 'width' => $thWidth]);
    $span = $td->appendElement('span');

    switch ($key) {
        case 'select_all':
            $span->appendElement('plaintext', [], '<label class="checkbox"><input title="' . $val . '" type="checkbox" onclick="selectAll( $(this) )" class="selectAllJs"><i class="input-helper"></i></label>', true);
            break;
        default:
            $span->appendElement('plaintext', [], $val . $html, true);
            break;
    }
}
$tbody = $tbl->appendElement('tbody', ['class' => 'listingRecordJs']);