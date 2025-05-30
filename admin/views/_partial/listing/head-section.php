<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$tableHeadAttrArr = isset($tableHeadAttrArr) ? $tableHeadAttrArr : [];
$tableId = isset($tableId) ?  $tableId : '';

$disableSelectAll = empty($arrListing) ? 'disabled="disabled"' : '';

$th = new HtmlElement('thead', ['class'=>'tableHeadJs']);
$th->appendElement('tr');
foreach ($fields as $key => $val) {
    $defaultSortingClass = HtmlHelper::getDefaultSortingClass($key, $sortBy, $sortOrder);
    $cls = '';
    if (in_array($key, $allowedKeysForSorting)) {
        $cls .= 'headerColumnJs sorting ' . $defaultSortingClass;
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
            $span->appendElement('plaintext', [], '<label class="checkbox"><input title="' . $val . '" type="checkbox" ' . $disableSelectAll . ' onclick="selectAll(this)" class="selectAllJs"><i class="input-helper"></i></label>', true);
            break;
        default:
            $span->appendElement('plaintext', [], $val, true);
            break;
    }
}
echo $th->getHtml();
