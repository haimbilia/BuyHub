<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arr_flds = array(
    'listSerial' => Labels::getLabel('LBL_#', $siteLangId),
    'prodcat_identifier' => Labels::getLabel('LBL_Category_Name', $siteLangId),
    'prodcat_parent' => Labels::getLabel('LBL_Parent_category', $siteLangId),
    'shop_name' => Labels::getLabel('LBL_Requested_BY', $siteLangId),
    'prodcat_requested_on' => Labels::getLabel('LBL_Requested_On', $siteLangId),
    'action' => '',
);

if (!$canEdit) {
    unset($arr_flds['action']);
}

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive table-scrollable js-scrollable table--hovered'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($fields as $key => $val) {
    $e = $th->appendElement('th', array(), $val);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr');
    $tr->setAttribute("id", $row['prodcat_id']);

    foreach ($fields as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'shop_name':
                $name = (0 < $row['prodcat_seller_id'] ? $row['shop_name'] . '(' . $row['user_name'] . ')' : Labels::getLabel('LBL_ADMIN', $siteLangId));
                $td->appendElement('plaintext', array(), $name);
                break;
            case 'prodcat_parent':
                $prodCat = new productCategory();
                $name = $prodCat->getParentTreeStructure($row['prodcat_id'], 0, '', $siteLangId, false, -1);
                $td->appendElement('plaintext', array(), $name, true);
                break;
            case 'prodcat_identifier':
                if ($row['prodcat_name'] != '') {
                    $td->appendElement('plaintext', array(), $row['prodcat_name'], true);
                    $td->appendElement('br', array());
                    $td->appendElement('plaintext', array(), '(' . $row[$key] . ')', true);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                }
                break;
            case 'prodcat_requested_on':
                $td->appendElement('plaintext', array(), HtmlHelper::formatDateTime($row[$key]), true);
                break;
            case 'action':
                if ($canEdit) {
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_Edit', $siteLangId), "onclick" => "editProdCatRequestForm(" . $row['prodcat_id'] . ")"), "<i class='far fa-edit icon'></i>", true);
                }
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $serialNo++;
}
echo $tbl->getHtml();

if (count($arrListing) == 0) {
    $this->includeTemplate('_partial/no-record-found.php');
}

$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmCategorySearchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
?>
