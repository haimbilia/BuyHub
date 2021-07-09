<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    'shop_name' => Labels::getLabel('LBL_REQUESTED_BY', $adminLangId),
    'badge_name' => Labels::getLabel('LBL_BADGE', $adminLangId),
    'download' => Labels::getLabel('LBL_DOWNLOAD', $adminLangId),
    'breq_requested_on' => Labels::getLabel('LBL_REQUESTED_ON', $adminLangId),
);
if ($canEdit) {
    $arr_flds['action'] = '';
}
$tableClass = '';
if (0 < count($arrListing)) {
    $tableClass = "table table-responsive table--hovered";
}
$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table ' . $tableClass));
$th = $tbl->appendElement('thead')->appendElement('tr', array('class' => ''));
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr', array('class' => ''));

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no, true);
                break;
            case 'shop_name':
                $name = $row['shop_name'] . '(' . $row['user_name'] . ')';
                $td->appendElement('plaintext', array(), $name);
                break;
            case 'badge_name':
                $name = $row[$key];
                $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[Badge::DB_TBL_PREFIX . 'id'], 0, $adminLangId);
                $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
                $td->appendElement('img', ['src' => UrlHelper::getCachedUrl(UrlHelper::generateUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], "THUMB", $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'), 'title' => $name, 'alt' => $name], '', true);
                break;
            case 'breq_requested_on':
                $td->appendElement('plaintext', array(), (isset($row[$key]) && $row[$key] != '0000-00-00 00:00:00') ? FatDate::Format($row[$key]) : Labels::getLabel('LBL_NA', $adminLangId), true);
                break;
            case 'download':
                $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $row[BadgeRequest::DB_TBL_PREFIX . 'id']);
                $fileName = Labels::getLabel('LBL_N/A', $adminLangId);
                if ($res !== false && 0 < $res['afile_id']) {
                    $fileName = '<a href="'.UrlHelper::generateUrl('BadgeRequests', 'downloadFile', array($row['breq_id'])).'">
                    <i class="fas fa-download"></i></a>';
                }

                $td->appendElement('div', ['class' => "text-break"], $fileName, true);
                break;
            case 'action':
                if ($canEdit) {
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_EDIT', $adminLangId), "onclick" => "form(" . $row['breq_id'] . ")"), "<i class='far fa-edit icon'></i>", true);
                } else {
                    $td->appendElement('plaintext', [], Labels::getLabel('LBL_N/A', $adminLangId), true);
                }
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $sr_no--;
}

if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), 'No records found');
}

$frm = new Form('frmSearchListing');
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap badgeRequestList--js');
$frm->setFormTagAttribute('onsubmit', 'formAction(this, reloadList ); return(false);');

echo $frm->getFormTag();
echo $tbl->getHtml(); ?>
</form>
<?php
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), 'No records found');
}

$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmSrchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
