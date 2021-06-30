<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $siteLangId),
    Badge::DB_TBL_PREFIX . 'shape_type' => Labels::getLabel('LBL_IMAGE', $siteLangId),
    Badge::DB_TBL_PREFIX . 'name' => Labels::getLabel('LBL_NAME', $siteLangId),
    Badge::DB_TBL_PREFIX . 'required_approval' => Labels::getLabel('LBL_APPROVAL', $siteLangId),
    'action' => '#',
);

if (!$canEdit) {
    unset($arr_flds['action']);
}

if (Badge::TYPE_RIBBON == $badgeType) {
    unset($arr_flds[Badge::DB_TBL_PREFIX . 'required_approval']);
}

$typeArr = Badge::getTypeArr($siteLangId);

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-justified'));

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key => $val) {
    $th->appendElement('th', array(), $val);
}

$sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr');
    $name = $row[Badge::DB_TBL_PREFIX . 'identifier'];
    if (array_key_exists(Badge::DB_TBL_PREFIX . 'name', $row) && !empty($row[Badge::DB_TBL_PREFIX . 'name'])) {
        $name = $row[Badge::DB_TBL_PREFIX . 'name'];
    }
    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', [], $sr_no, true);
                break;
            case Badge::DB_TBL_PREFIX . 'name':
                $td->appendElement('plaintext', [], $name, true);
                break;
            case Badge::DB_TBL_PREFIX . 'shape_type':
                if (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type']) {
                    $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[Badge::DB_TBL_PREFIX . 'id'], 0, 0, false);
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
                $class = applicationConstants::YES == $row[$key] ? 'label-danger' : 'label-info'; 
                $htm = ' <span class="label label-inline label-success rounded-pill">' . Labels::getLabel('LBL_NOT_REQUIRED', $siteLangId) . '</span>';;
                if (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type']) {
                    $htm = ' <span class="label label-inline ' . $class . ' rounded-pill">' . $approvalStatusArr[$row[$key]] . '</span>';
                }
                $td->appendElement('plaintext', [], $htm, true);
                break;
            case 'action':
                if ($canEdit && 0 < (int) $row['canAccess']) {
                    $btnClass = 'btn btn-clean btn-sm btn-icon';
                    $function = "form(" . $row[Badge::DB_TBL_PREFIX . 'type'] . ", " . $row[Badge::DB_TBL_PREFIX . 'id'] . ")";
                    $td->appendElement('a', array('href' => UrlHelper::generateUrl('BadgeLinkConditions', 'list', [$row[Badge::DB_TBL_PREFIX . 'id']]), 'class' => $btnClass, 'title' => Labels::getLabel('LBL_BIND_CONDITION', $siteLangId)), "<i class='fas fa-link icon'></i>", true);
                } else {
                    $td->appendElement('plaintext', [], Labels::getLabel('LBL_N/A', $siteLangId), true);
                }
                break;
        }
    }
    $sr_no--;
}
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), 'No records found');
}

$frm = new Form('frmSearchListing');
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap actionButtons-js badgesList--js');
$frm->setFormTagAttribute('onsubmit', 'formAction(this, reloadList ); return(false);');
$frm->setFormTagAttribute('action', UrlHelper::generateUrl('Badges', 'toggleBulkStatuses'));
$frm->addHiddenField('', 'status');

echo $frm->getFormTag();
echo $frm->getFieldHtml('status');
echo $tbl->getHtml(); ?>
</form>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmSrchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
