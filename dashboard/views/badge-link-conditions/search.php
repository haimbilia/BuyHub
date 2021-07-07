<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'record_type' => Labels::getLabel('LBL_LINK_TYPE', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'position' => Labels::getLabel('LBL_POSITION', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type' => Labels::getLabel('LBL_CONDITION', $siteLangId),
    'action' => '',
);

if (!$canEdit || 1 > count($arrListing)) {
    unset($arr_flds['action']);
}

if (Badge::TYPE_RIBBON == $badgeType) {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type']);
} else {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'position' ]);
}

if (BadgeLinkCondition::REC_COND_AUTO == $recordCondition) {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'record_type']);
} else {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type']);
}

$conditionTypeArr = BadgeLinkCondition::getConditionTypesArr($siteLangId);
$recordTypeArr = BadgeLinkCondition::getRecordTypeArr($siteLangId);
$recordConditionArr = BadgeLinkCondition::getRecordConditionArr($siteLangId);
$nonPercElements =  [
    BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE,
    BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED
];

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-justified'));

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key => $val) {
    $th->appendElement('th', [], $val);
}

$sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', [], $sr_no, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'record_type':
                $txt = empty($row[$key]) ? Labels::getLabel("LBL_N/A", $siteLangId) : $recordTypeArr[$row[$key]];
                $td->appendElement('plaintext', [], $txt, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'position':
                $txt = Badge::RIBB_POS_TRIGHT == $row[$key] ? Labels::getLabel('LBL_TOP_RIGHT', $siteLangId) : Labels::getLabel('LBL_TOP_LEFT', $siteLangId);
                $td->appendElement('plaintext', [], $txt, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type':
                $conditionType = (empty($row['badgelink_record_ids']) ? $conditionTypeArr[$row[$key]] : Labels::getLabel('LBL_N/A', $siteLangId));
                $td->appendElement('plaintext', [], $conditionType, true);

                if (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type'] && empty($row['badgelink_record_ids'])) {
                    $fromValue = $row[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from'];
                    $toValue = "";
                    if (!empty($row[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to'])) {
                        $toValue = ' - ' . $row[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to'];
                    }
                    
                    $perc = in_array($row[$key], $nonPercElements) ? '' : '%';

                    $htm = $fromValue . $toValue . $perc;
                    $td->appendElement('plaintext', array(), " <i  class='fa fa-info-circle spn_must_field' data-toggle='tooltip' data-placement='top' title='" . $htm . "'></i>", true);
                }
                break;
            case 'action':
                if ($canEdit && empty($conditionTypeArr[$row[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type']])) {
                    $href = UrlHelper::generateUrl('BadgeLinkConditions', 'conditionForm', [$row[Badge::DB_TBL_PREFIX . 'type'], $row[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'], $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id']]);
                    $td->appendElement('a', array('href' => $href, 'class' => 'btn btn-outline-brand btn-sm', 'title' => Labels::getLabel('LBL_EDIT', $siteLangId)), "<i class='far fa-edit icon'></i>", true);
                } else {
                    $td->appendElement('plaintext', [], Labels::getLabel('LBL_N/A', $siteLangId), true);
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
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
