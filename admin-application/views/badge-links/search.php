<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'select_all' => Labels::getLabel('LBL_Select_all', $adminLangId),
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    Badge::DB_TBL_PREFIX . 'type' => Labels::getLabel('LBL_TYPE', $adminLangId),
    Badge::DB_TBL_PREFIX . 'shape_type' => Labels::getLabel('LBL_OBJECT', $adminLangId),
    'record_condition' => Labels::getLabel('LBL_TRIGGER', $adminLangId),
    BadgeLink::DB_TBL_PREFIX . 'record_type' => Labels::getLabel('LBL_LINK_TYPE', $adminLangId),
    BadgeLink::DB_TBL_PREFIX . 'condition_type' => Labels::getLabel('LBL_CONDITION_TYPE', $adminLangId),
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
            case 'record_condition':
                $condition = (empty($row['badgelink_record_ids']) || '[]' == $row['badgelink_record_ids'] ? BadgeLink::REC_COND_AUTO : BadgeLink::REC_COND_MANUAL);
                $recordCondition = BadgeLink::getRecordConditionArr($adminLangId)[$condition];
                $htm = ' <span class="badge badge--unified-success badge--inline badge--pill">' . $recordCondition . '</span>';;
                if (BadgeLink::REC_COND_MANUAL == $condition) {
                    $htm = ' <span class="badge badge--unified-brand badge--inline badge--pill">' . $recordCondition . '</span>';
                }
                $td->appendElement('plaintext', array(), $htm, true);
                break;
            case BadgeLink::DB_TBL_PREFIX . 'condition_type':
                $td->appendElement('plaintext', array(), BadgeLink::getConditionTypeName($row[$key], $adminLangId), true);
                break;
            case Badge::DB_TBL_PREFIX . 'shape_type':
                if (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type']) {
                    $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[BadgeLink::DB_TBL_PREFIX . 'badge_id'], 0, $adminLangId, false);
                    $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
                    $td->appendElement('img', ['src' => UrlHelper::getCachedUrl(UrlHelper::generateUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], "MINI", $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'), 'title' => $row[Badge::DB_TBL_PREFIX . 'name'], 'alt' => $row[Badge::DB_TBL_PREFIX . 'name']], '', true);
                } else {
                    $color = empty($row[Badge::DB_TBL_PREFIX . 'color']) ? Labels::getLabel('LBL_N/A', $adminLangId) : '<div class="d-flex align-items-center"><span class="color-' . strtolower(Badge::getShapeTypeName($row[$key], $adminLangId)) . '" style="background-color:' . $row[Badge::DB_TBL_PREFIX . 'color'] . '" title="' . $row[Badge::DB_TBL_PREFIX . 'name'] . '"></span></div>';
                    $td->appendElement('plaintext', [], $color, true);
                }
                break;
            case 'action':
                if ($canEdit) {
                    $function = "form(" . $row[BadgeLink::DB_TBL_PREFIX . 'id'] . ", " . $row[BadgeLink::DB_TBL_PREFIX . 'record_type'] . ")";
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_EDIT', $adminLangId), "onclick" => $function), "<i class='far fa-edit icon'></i>", true);
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_DELETE', $adminLangId), "onclick" => "unlink(event, " . $row[BadgeLink::DB_TBL_PREFIX . 'id'] . ")"), "<i class='fas fa-trash icon'></i>", true);
                } else {
                    $td->appendElement('plaintext', array(), Labels::getLabel('LBL_N/A', $adminLangId), true);
                }
                break;
            default : 
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $sr_no++;
}
if (count($arr_listing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), 'No records found');
}

$frm = new Form('frmSearchListing');
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap actionButtons-js badgesLinksList--js');
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
