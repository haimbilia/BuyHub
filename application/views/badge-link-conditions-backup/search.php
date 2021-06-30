<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $siteLangId),
    Badge::DB_TBL_PREFIX . 'type' => Labels::getLabel('LBL_TYPE', $siteLangId),
    Badge::DB_TBL_PREFIX . 'shape_type' => Labels::getLabel('LBL_VIEW', $siteLangId),
    'record_condition' => Labels::getLabel('LBL_TRIGGER', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'record_type' => Labels::getLabel('LBL_LINK_TYPE', $siteLangId),
    Badge::DB_TBL_PREFIX . 'required_approval' => Labels::getLabel('LBL_APPROVAL', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type' => Labels::getLabel('LBL_CONDITION_TYPE', $siteLangId),
);

$typeArr = Badge::getTypeArr($siteLangId);
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
            
            case Badge::DB_TBL_PREFIX . 'type':
                $td->appendElement('plaintext', [], $typeArr[$row[$key]], true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'record_type':
                $txt = empty($row[$key]) ? Labels::getLabel("LBL_N/A", $siteLangId) : $recordTypeArr[$row[$key]];
                $td->appendElement('plaintext', [], $txt, true);
                break;
            case 'record_condition':
                $condition = (empty($row['badgelink_record_ids']) ? BadgeLinkCondition::REC_COND_AUTO : BadgeLinkCondition::REC_COND_MANUAL);
                $htm = ' <span class="label label-inline label-success rounded-pill">' . $recordConditionArr[$condition] . '</span>';;
                if (BadgeLinkCondition::REC_COND_MANUAL == $condition) {
                    $htm = ' <span class="label label-inline label-info rounded-pill">' . $recordConditionArr[$condition] . '</span>';
                }
                $td->appendElement('plaintext', [], $htm, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type':
                $conditionType = (empty($row['badgelink_record_ids']) ? $conditionTypeArr[$row[$key]] : Labels::getLabel('LBL_N/A', $siteLangId));
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
            case Badge::DB_TBL_PREFIX . 'shape_type':
                if (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type']) {
                    $name = $row[Badge::DB_TBL_PREFIX . 'name'];
                    $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'], 0, 0, false);
                    $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
                    $td->appendElement('img', ['src' => UrlHelper::getCachedUrl(UrlHelper::generateUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], "THUMB", $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'), 'title' => $name, 'alt' => $name], '', true);
                } else {
                    $ribbRow = $row;
                    include CONF_THEME_PATH . '/_partial/get-ribbon.php';
                    $html = '<div class="badge-wrap">' . $ribbon . '</div>';
                    $td->appendElement('plaintext', [], $html, true);
                }
                break;
            
            case Badge::DB_TBL_PREFIX . 'required_approval':
                $class = applicationConstants::YES == $row[$key] ? 'label-danger' : 'label-success'; 
                $htm = ' <span class="label label-inline label-success">' . Labels::getLabel('LBL_NOT_REQUIRED', $siteLangId) . '</span>';;
                if (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type']) {
                    $htm = ' <span class="label label-inline ' . $class . '">' . $approvalStatusArr[$row[$key]] . '</span>';
                }
                $td->appendElement('plaintext', [], $htm, true);
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
