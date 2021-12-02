<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arr_flds = array(
    'listSerial' => Labels::getLabel('LBL_#', $adminLangId),
    'filtergroup_identifier' => Labels::getLabel('LBL_Identifier_Name', $adminLangId),
    //'filtergroup_active'=>'Active',		
    'action' => Labels::getLabel('LBL_Action', $adminLangId),
);
$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $tr = $tbl->appendElement('tr');
    $tr->setAttribute("id", $row['filtergroup_id']);

    if ($row['filtergroup_active'] != applicationConstants::ACTIVE) {
        $tr->setAttribute("class", "fat-inactive");
    }
    foreach ($fields as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'filtergroup_identifier':
                if ($row['filtergroup_name'] != '') {
                    $td->appendElement('plaintext', array(), $row['filtergroup_name'], true);
                    $td->appendElement('br', array());
                    $td->appendElement('plaintext', array(), '(' . $row[$key] . ')', true);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                }
                break;
            case 'filtergroup_active':
                $active = "active";
                if ($row['filtergroup_active']) {
                    $active = '';
                }
                $statucAct = ($canEdit === true) ? 'toggleStatus(this)' : '';
                $str = '<label id="' . $row['filtergroup_id'] . '" class="statustab ' . $active . '" onclick="' . $statucAct . '">
					  <span data-off="' . Labels::getLabel('LBL_Active', $adminLangId) . '" data-on="' . Labels::getLabel('LBL_Inactive', $adminLangId) . '" class="switch-labels"></span>
					  <span class="switch-handles"></span>
					</label>';
                $td->appendElement('plaintext', array(), $str, true);
                break;
            case 'action':
                $ul = $td->appendElement("ul", array("class" => "actions"));
                if ($canEdit) {
                    $li = $ul->appendElement("li");
                    $li->appendElement('a', array('href' => UrlHelper::generateUrl('Filters', 'index', array($row['filtergroup_id'])), 'class' => 'button small green', 'title' => Labels::getLabel('LBL_Filters', $adminLangId)), '<i class="ion-navicon-round icon"></i>', true);

                    $li = $ul->appendElement("li");
                    $li->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'button small green', 'title' => Labels::getLabel('LBL_Edit', $adminLangId), "onclick" => "filterGroupForm(" . $row['filtergroup_id'] . ")"), '<i class="far fa-edit icon"></i>', true);

                    $li = $ul->appendElement("li");
                    $li->appendElement('a', array('href' => "javascript:void(0)", 'class' => 'button small green', 'title' => Labels::getLabel('LBL_Delete', $adminLangId), "onclick" => "deleteRecord(" . $row['filtergroup_id'] . ")"), '<i class="fa fa-trash  icon"></i>', true);
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
    'name' => 'frmFilterGroupSearchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'adminLangId' => $adminLangId, 'recordCount' => $recordCount);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
?>