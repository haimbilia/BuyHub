<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arr_flds = array(
    'listSerial' => Labels::getLabel('LBL_#', $adminLangId),
    'eattrgroup_identifier' => Labels::getLabel('LBL_Identifier_Name', $adminLangId),
);
if ($canEdit) {
    $arr_flds['action'] = Labels::getLabel('LBL_Action', $adminLangId);
}
$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $tr = $tbl->appendElement('tr');
    $tr->setAttribute("id", $row['eattrgroup_id']);

    foreach ($fields as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'eattrgroup_identifier':
                if ($row['eattrgroup_name'] != '') {
                    $td->appendElement('plaintext', array(), $row['eattrgroup_name'], true);
                    $td->appendElement('br', array());
                    $td->appendElement('plaintext', array(), '(' . $row[$key] . ')', true);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                }
                break;
            case 'action':
                if ($canEdit) {
                    $ul = $td->appendElement("ul", array("class" => "actions"));
                    $li = $ul->appendElement("li");
                    $li->appendElement('a', array('href' => UrlHelper::generateUrl('ExtraAttributes', 'index', array($row['eattrgroup_id'])), 'class' => 'button small green', 'title' => Labels::getLabel('LBL_Extra_Attributes', $adminLangId)), '<i class="ion-navicon-round icon"></i>', true);

                    $li = $ul->appendElement("li");
                    $li->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'button small green', 'title' => Labels::getLabel('LBL_Edit', $adminLangId), "onclick" => "extraAttributeGroupForm(" . $row['eattrgroup_id'] . ")"), '<i class="far fa-edit icon"></i>', true);

                    $li = $ul->appendElement("li");
                    $li->appendElement('a', array('href' => "javascript:void(0)", 'class' => 'button small green', 'title' => Labels::getLabel('LBL_Delete', $adminLangId), "onclick" => "deleteRecord(" . $row['eattrgroup_id'] . ")"), '<i class="fa fa-trash  icon"></i>', true);
                }
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Records_Found', $adminLangId));
}
echo $tbl->getHtml();
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmExtraAttributeGroupSearchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
?>