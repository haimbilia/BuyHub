<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'select_all' => Labels::getLabel('LBL_Select_all', $siteLangId),
    'listserial' => Labels::getLabel('LBL_#', $siteLangId),
    Badge::DB_TBL_PREFIX . 'type' => Labels::getLabel('LBL_TYPE', $siteLangId),
    Badge::DB_TBL_PREFIX . 'shape_type' => Labels::getLabel('LBL_VIEW', $siteLangId),
    'record_condition' => Labels::getLabel('LBL_TRIGGER', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'record_type' => Labels::getLabel('LBL_LINK_TYPE', $siteLangId),
    BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type' => Labels::getLabel('LBL_CONDITION_TYPE', $siteLangId),
    'action' => '',
);

if (!$canEdit) {
    unset($arr_flds['select_all'], $arr_flds['action']);
}

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
foreach ($arr_listing as $sn => $row) {
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
            
            case Badge::DB_TBL_PREFIX . 'type':
                $td->appendElement('plaintext', [], Badge::getTypeName($row[$key], $siteLangId), true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'record_type':
                $txt = empty($row[$key]) ? Labels::getLabel("LBL_N/R", $siteLangId) : BadgeLinkCondition::getRecordTypeName($row[$key], $siteLangId);
                $td->appendElement('plaintext', [], $txt, true);
                break;
            case 'record_condition':
                $condition = (empty($row['badgelink_record_ids']) ? BadgeLinkCondition::REC_COND_AUTO : BadgeLinkCondition::REC_COND_MANUAL);
                $recordCondition = BadgeLinkCondition::getRecordConditionArr($siteLangId)[$condition];
                $htm = ' <span class="badge badge--unified-success badge--inline badge--pill">' . $recordCondition . '</span>';;
                if (BadgeLinkCondition::REC_COND_MANUAL == $condition) {
                    $htm = ' <span class="badge badge--unified-brand badge--inline badge--pill">' . $recordCondition . '</span>';
                }
                $td->appendElement('plaintext', [], $htm, true);
                break;
            case BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type':
                $conditionType = (empty($row['badgelink_record_ids']) ? BadgeLinkCondition::getConditionTypeName($row[$key], $siteLangId) : Labels::getLabel('LBL_N/R', $siteLangId));
                $td->appendElement('plaintext', [], $conditionType, true);
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
            case 'action':
                if ($canEdit) {
                    $funcName = (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type']) ? 'badgeForm' : 'ribbonForm';
                    $function = $funcName . "(" . $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id'] . ", " . $row[BadgeLinkCondition::DB_TBL_PREFIX . 'record_type'] . ", " . $row[Badge::DB_TBL_PREFIX . 'type'] . ")";
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_EDIT', $siteLangId), "onclick" => $function), "<i class='far fa-edit icon'></i>", true);
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_DELETE', $siteLangId), "onclick" => "unlink(event, " . $row[BadgeLinkCondition::DB_TBL_PREFIX . 'id'] . ")"), "<i class='fas fa-trash icon'></i>", true);
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
if (count($arr_listing) == 0) {
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
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $siteLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
