<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'record_type' => Labels::getLabel('LBL_LINK_TYPE', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'position' => Labels::getLabel('LBL_POSITION', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type' => Labels::getLabel('LBL_CONDITION', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from' => Labels::getLabel('LBL_CONDITION_FROM', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to' => Labels::getLabel('LBL_CONDITION_TO', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'from_date' => Labels::getLabel('LBL_VAILD_FROM', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'to_date' => Labels::getLabel('LBL_VALID_TO', $siteLangId),
    'action' => '#',
);

if (!$canEdit || 1 > count($arrListing)) {
    unset($arr_flds['action']);
}

if (Badge::TYPE_RIBBON == $badgeType) {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type']);
} else {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'position']);
}

if (Badge::COND_AUTO == $badgeConditionType) {
    unset($arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'record_type']);
} else {
    unset(
        $arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type'],
        $arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from'],
        $arr_flds[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to']
    );
}

$conditionTypeArr = BadgeLinkCondition::getConditionTypesArr($siteLangId);
$recordTypeArr = BadgeLinkCondition::getRecordTypeArr($siteLangId);
$recordConditionArr = BadgeLinkCondition::getRecordConditionArr($siteLangId);
$nonPercElements =  [
    BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS
];

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table'));

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
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from':
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to':
                $lbl = (in_array($row[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type'], $nonPercElements) ? $row[$key] : $row[$key] . '%');
                $td->appendElement('plaintext', [], $lbl, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'from_date':
            case BadgeLinkCondition::DB_TBL_PREFIX . 'to_date':
                $lbl = (1 > strtotime($row[$key]) ? Labels::getLabel('LBL_N/A', $siteLangId) : date('Y-m-d H:i', strtotime($row[$key])));
                $td->appendElement('plaintext', [], $lbl, true);
                break;
            case 'action':
                if ($canEdit) {
                    $ul = $td->appendElement("ul", array("class"=>"actions"));
                    if (Badge::COND_MANUAL == $badgeConditionType) {
                        $href = UrlHelper::generateUrl('BadgeLinkConditions', 'conditionForm', [$row[Badge::DB_TBL_PREFIX . 'type'], $row[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'], $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id']]);

                        $icon = "<i class='far fa-edit icon'></i>";
                        $title = Labels::getLabel('LBL_EDIT', $siteLangId);

                        if ($row[Badge::DB_TBL_PREFIX . 'required_approval'] == Badge::APPROVAL_REQUIRED) {
                            $icon = "<i class='far fa-eye icon'></i>";
                            $title = Labels::getLabel('LBL_VIEW', $siteLangId);
                        }
                        $li = $ul->appendElement("li"); 
                        $li->appendElement('a', array('href' => $href, 'title' => $title), $icon, true);
                        if ($row[Badge::DB_TBL_PREFIX . 'required_approval'] == Badge::APPROVAL_OPEN) {
                            $li = $ul->appendElement("li"); 
                            $li->appendElement('a', array('href' => 'javascript:void(0)', 'title' => Labels::getLabel('LBL_DELETE', $siteLangId), "onclick" => "unlink(event, " . $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id'] . ")"), "<i class='fas fa-trash icon'></i>", true);
                        }
                    } else if (in_array($row['blinkcond_condition_type'], BadgeLinkCondition::SHOP_BADGES_COND_TYPES)) {
                        $lbl = Labels::getLabel('LBL_N/A', $siteLangId);
                        $class = 'label-danger';
                        if (in_array($row['blinkcond_id'], $autoSatisfiedBadgesArr)) {
                            $lbl = Labels::getLabel('LBL_TRUE', $siteLangId);
                            $class = 'label-success';
                        }

                        $htm = ' <span class="label label-inline ' . $class . ' rounded-pill">' . $lbl . '</span>';
                        $li = $ul->appendElement("li"); 
                        $li->appendElement('plaintext', [], $htm, true);
                    } else {
                        $href = UrlHelper::generateUrl('BadgeLinkConditions', 'conditionForm', [$row[Badge::DB_TBL_PREFIX . 'type'], $row[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'], $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id']]);
                        $icon = "<i class='far fa-eye icon'></i>";
                        $title = Labels::getLabel('LBL_VIEW', $siteLangId);
                        $li = $ul->appendElement("li"); 
                        $li->appendElement('a', array('href' => $href, 'title' => $title), $icon, true);
                    }
                } else {
                    $td->appendElement('plaintext', [], Labels::getLabel('LBL_N/A', $siteLangId), true);
                }
                break;
            default:
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
