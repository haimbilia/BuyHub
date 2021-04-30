<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'select_all' => Labels::getLabel('LBL_Select_all', $adminLangId),
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    Badge::DB_TBL_PREFIX . 'name' => Labels::getLabel('LBL_BADGE_OR_RIBBON', $adminLangId),
    Badge::DB_TBL_PREFIX . 'type' => Labels::getLabel('LBL_TYPE', $adminLangId),
    BadgeLink::DB_TBL_PREFIX . 'record_name' => Labels::getLabel('LBL_RECORD_NAME', $adminLangId),
    BadgeLink::DB_TBL_PREFIX . 'record_type' => Labels::getLabel('LBL_RECORD_TYPE', $adminLangId),
    BadgeLink::DB_TBL_PREFIX . 'condition_type' => Labels::getLabel('LBL_CONDITION_TYPE', $adminLangId),
    BadgeLink::DB_TBL_PREFIX . 'condition_from' => Labels::getLabel('LBL_CONDITION_FROM', $adminLangId),
    BadgeLink::DB_TBL_PREFIX . 'condition_to' => Labels::getLabel('LBL_CONDITION_TO', $adminLangId),
    'action' => '',
);

if (!$canEdit) {
    unset($arr_flds['select_all'], $arr_flds['action']);
}

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table--hovered table-responsive'));

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key => $val) {
    if ('select_all' == $key) {
        $th->appendElement('th')->appendElement('plaintext', array(), '<label class="checkbox"><input title="' . $val . '" type="checkbox" onclick="selectAll( $(this) )" class="selectAll-js"><i class="input-helper"></i></label>', true);
    } else {
        $th->appendElement('th', array(), $val);
    }
}

$sr_no = 1;
foreach ($arr_listing as $sn => $row) {
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="badgeLinkIds[]" value=' . $row['badgelink_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no, true);
                break;
            case Badge::DB_TBL_PREFIX . 'type':
                $td->appendElement('plaintext', array(), Badge::getTypeName($row[$key], $adminLangId), true);
                break;
            case BadgeLink::DB_TBL_PREFIX . 'record_type':
                $td->appendElement('plaintext', array(), BadgeLink::getRecordTypeName($row[$key], $adminLangId), true);
                break;
            case BadgeLink::DB_TBL_PREFIX . 'condition_type':
                $td->appendElement('plaintext', array(), BadgeLink::getConditionTypeName($row[$key], $adminLangId), true);
                break;
            case 'action':
                if ($canEdit) {
                    $function = "form(" . $row[BadgeLink::DB_TBL_PREFIX . 'id'] . ")";
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_EDIT', $adminLangId), "onclick" => $function), "<i class='far fa-edit icon'></i>", true);
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_UNLINK', $adminLangId), "onclick" => "unlink(event, " . $row[BadgeLink::DB_TBL_PREFIX . 'id'] . ")"), "<i class='far fa-unlink icon'></i>", true);
                } else {
                    $td->appendElement('plaintext', array(), Labels::getLabel('LBL_N/A', $adminLangId), true);
                }
                break;
            default : 
                break;
        }
    }
    $sr_no++;
}
if (count($arr_listing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), 'No records found');
}

$frm = new Form('frmSearchListing');
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap actionButtons-js');
$frm->setFormTagAttribute('onsubmit', 'formAction(this, reloadList ); return(false);');
$frm->setFormTagAttribute('action', UrlHelper::generateUrl('BadgeLinks', 'bulkBadgesUnlink'));

echo $frm->getFormTag();
echo $tbl->getHtml(); ?>
</form>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmSrchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
