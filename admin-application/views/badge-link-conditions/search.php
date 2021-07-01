<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'select_all' => Labels::getLabel('LBL_Select_all', $adminLangId),
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'record_type' => Labels::getLabel('LBL_LINK_TYPE', $adminLangId),
    'record_condition' => Labels::getLabel('LBL_TRIGGER', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'position' => Labels::getLabel('LBL_POSITION', $adminLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type' => Labels::getLabel('LBL_CONDITION_TYPE', $adminLangId),
    'action' => '',
);

if (!$canEdit || 1 > count($arrListing)) {
    unset($arr_flds['select_all'], $arr_flds['action']);
}

if (Badge::TYPE_RIBBON == $badgeType) {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type'], $arr_flds['record_condition']);
} else {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'position' ]);
}

$conditionTypeArr = BadgeLinkCondition::getConditionTypesArr($adminLangId);
$recordTypeArr = BadgeLinkCondition::getRecordTypeArr($adminLangId);
$recordConditionArr = BadgeLinkCondition::getRecordConditionArr($adminLangId);
$nonPercElements =  [
    BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE,
    BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED
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
            case BadgeLinkCondition::DB_TBL_PREFIX . 'record_type':
                $txt = empty($row[$key]) ? Labels::getLabel("LBL_N/A", $adminLangId) : $recordTypeArr[$row[$key]];
                $td->appendElement('plaintext', [], $txt, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'position':
                $txt = Badge::RIBB_POS_TRIGHT == $row[$key] ? Labels::getLabel('LBL_TOP_RIGHT', $adminLangId) : Labels::getLabel('LBL_TOP_LEFT', $adminLangId);
                $td->appendElement('plaintext', [], $txt, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type':
                $conditionType = (empty($row['badgelink_record_ids']) ? $conditionTypeArr[$row[$key]] : Labels::getLabel('LBL_N/A', $adminLangId));
                $td->appendElement('plaintext', [], $conditionType, true);

                if (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type'] && empty($row['badgelink_record_ids'])) {
                    $fromValue = $row[BadgeLinkCondition::DB_TBL_PREFIX . 'from_value'];
                    $toValue = "";
                    if (!empty($row[BadgeLinkCondition::DB_TBL_PREFIX . 'to_value'])) {
                        $toValue = ' - ' . $row[BadgeLinkCondition::DB_TBL_PREFIX . 'to_value'];
                    }
                    
                    $perc = in_array($row[$key], $nonPercElements) ? '' : '%';

                    $htm = $fromValue . $toValue . $perc;
                    $td->appendElement('plaintext', array(), " <i  class='fa fa-info-circle spn_must_field' data-toggle='tooltip' data-placement='top' title='" . $htm . "'></i>", true);
                }
                break;
            case 'record_condition':
                $condition = (empty($row['badgelink_record_ids']) ? BadgeLinkCondition::REC_COND_AUTO : BadgeLinkCondition::REC_COND_MANUAL);
                $htm = ' <span class="badge badge--unified-success badge--inline badge--pill">' . $recordConditionArr[$condition] . '</span>';;
                if (BadgeLinkCondition::REC_COND_MANUAL == $condition) {
                    $htm = ' <span class="badge badge--unified-brand badge--inline badge--pill">' . $recordConditionArr[$condition] . '</span>';
                }
                $td->appendElement('plaintext', [], $htm, true);
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
