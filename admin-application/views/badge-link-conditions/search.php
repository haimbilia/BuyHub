<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'select_all' => Labels::getLabel('LBL_Select_all', $adminLangId),
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    'cond_seller_name' => Labels::getLabel('LBL_SELLER', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'record_type' => Labels::getLabel('LBL_LINK_TYPE', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'position' => Labels::getLabel('LBL_POSITION', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type' => Labels::getLabel('LBL_CONDITION', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from' => Labels::getLabel('LBL_CONDITION_FROM', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to' => Labels::getLabel('LBL_CONDITION_TO', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'from_date' => Labels::getLabel('LBL_VAILD_FROM', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'to_date' => Labels::getLabel('LBL_VALID_TO', $adminLangId),
    'action' => '',
);

if (!$canEdit || 1 > count($arrListing)) {
    unset($arr_flds['select_all'], $arr_flds['action']);
}

if (Badge::TYPE_RIBBON == $badgeType) {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type']);
} else {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'position' ]);
}

if (Badge::COND_AUTO == $badgeConditionType) {
    unset($arr_flds['cond_seller_name'], 
        $arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'record_type']);
} else {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type'], 
        $arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from'], 
        $arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to']);
}

$conditionTypeArr = BadgeLinkCondition::getConditionTypesArr($adminLangId);
$recordTypeArr = BadgeLinkCondition::getRecordTypeArr($adminLangId);
$recordConditionArr = BadgeLinkCondition::getRecordConditionArr($adminLangId);
$nonPercElements =  [
    BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS
];

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table--hovered table-responsive'));

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key => $val) {
    if ('select_all' == $key) {
        $th->appendElement('th')->appendElement('plaintext', [], '<label class="checkbox"><input title="' . $val . '" type="checkbox" onclick="selectAll( $(this) )" class="selectAll-js"><i class="input-helper"></i></label>', true);
    } else {
        $th->appendElement('th', [], $val);
    }
}

$sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', [], '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="badgeLinkIds[]" value=' . $row['blinkcond_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listserial':
                $td->appendElement('plaintext', [], $sr_no, true);
                break;
            case 'cond_seller_name':
                $td->appendElement('plaintext', [], $row[$key], true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'record_type':
                $txt = empty($row[$key]) ? Labels::getLabel("LBL_N/A", $adminLangId) : $recordTypeArr[$row[$key]];
                $td->appendElement('plaintext', [], $txt, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'position':
                $txt = Badge::RIBB_POS_TRIGHT == $row[$key] ? Labels::getLabel('LBL_TOP_RIGHT', $adminLangId) : Labels::getLabel('LBL_TOP_LEFT', $adminLangId);
                $td->appendElement('plaintext', [], $txt, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type':
                $conditionAuto = (BadgeLinkCondition::REC_COND_AUTO == $recordCondition);
                $conditionType = ($conditionAuto ? $conditionTypeArr[$row[$key]] : Labels::getLabel('LBL_N/A', $adminLangId));
                $td->appendElement('plaintext', [], $conditionType, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from':
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to':
                $lbl = $row[$key];
                if (!empty($lbl) && (in_array($row[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type'], $nonPercElements))) {
                    $lbl = $row[$key] . '%';    
                }
                $td->appendElement('plaintext', [], (!empty($lbl) ? $lbl : Labels::getLabel('LBL_N/A', $adminLangId)), true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'from_date':
            case BadgeLinkCondition::DB_TBL_PREFIX . 'to_date':
                $lbl = (1 > strtotime($row[$key]) ? Labels::getLabel('LBL_N/A', $adminLangId) : date('Y-m-d H:i', strtotime($row[$key])));
                $td->appendElement('plaintext', [], $lbl, true);
                break;
            case 'action':
                if ($canEdit) {
                    $href = UrlHelper::generateUrl('BadgeLinkConditions', 'conditionForm', [$row[Badge::DB_TBL_PREFIX . 'type'], $row[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'], $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id']]);
                    $td->appendElement('a', array('href' => $href, 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_EDIT', $adminLangId)), "<i class='far fa-edit icon'></i>", true);
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_DELETE', $adminLangId), "onclick" => "unlink(event, " . $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id'] . ")"), "<i class='fas fa-trash icon'></i>", true);
                } else {
                    $td->appendElement('plaintext', [], Labels::getLabel('LBL_N/A', $adminLangId), true);
                }
                break;
            default : 
                $td->appendElement('plaintext', [], $row[$key], true);
                break;
        }
    }
    $sr_no--;
}
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), 'No records found');
}

$frm = new Form('frmSearchListing');
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap actionButtons-js badgesLinksList--js');
$frm->setFormTagAttribute('onsubmit', 'formAction(this, reloadList ); return(false);');
$frm->setFormTagAttribute('action', UrlHelper::generateUrl('BadgeLinkConditions', 'bulkBadgesUnlink'));

echo $frm->getFormTag();
echo $tbl->getHtml(); ?>
</form>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmSrchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
