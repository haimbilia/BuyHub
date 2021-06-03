<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'select_all' => Labels::getLabel('LBL_Select_all', $adminLangId),
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    Badge::DB_TBL_PREFIX . 'name' => Labels::getLabel('LBL_NAME', $adminLangId),
    Badge::DB_TBL_PREFIX . 'type' => Labels::getLabel('LBL_TYPE', $adminLangId),
    Badge::DB_TBL_PREFIX . 'shape_type' => Labels::getLabel('LBL_VIEW', $adminLangId),
    Badge::DB_TBL_PREFIX . 'required_approval' => Labels::getLabel('LBL_APPROVAL_STATUS', $adminLangId),
    Badge::DB_TBL_PREFIX . 'active' => Labels::getLabel('LBL_PUBLISH', $adminLangId),
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

$sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arr_listing as $sn => $row) {
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', [], '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="badgeIds[]" value=' . $row['badge_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listserial':
                $td->appendElement('plaintext', [], $sr_no, true);
                break;
            case Badge::DB_TBL_PREFIX . 'name':
                $name = array_key_exists(Badge::DB_TBL_PREFIX . 'name', $row) && !empty($row[$key]) ? $row[$key] : $row[Badge::DB_TBL_PREFIX . 'identifier'];
                $td->appendElement('plaintext', [], $name, true);
                break;
            case Badge::DB_TBL_PREFIX . 'type':
                $td->appendElement('plaintext', [], Badge::getTypeName($row[$key], $adminLangId), true);
                break;
            case Badge::DB_TBL_PREFIX . 'shape_type':
                if (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type']) {
                    $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[Badge::DB_TBL_PREFIX . 'id'], 0, 0, false);
                    $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
                    $td->appendElement('img', ['src' => UrlHelper::getCachedUrl(UrlHelper::generateUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], "THUMB", $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'), 'title' => $icon['afile_name'], 'alt' => $icon['afile_name']], '', true);
                } else {
                    $text = $row[Badge::DB_TBL_PREFIX . 'name'];
                    $type = $row[$key];
                    $color = $row[Badge::DB_TBL_PREFIX . 'color'];
                    $return = true;
                    $html = include CONF_THEME_PATH . '/_partial/get-ribbon.php';
                    $html = '<div class="badge-wrap">' . $html . '</div>';
                    $td->appendElement('plaintext', [], $html, true);
                }
                break;
            case Badge::DB_TBL_PREFIX . 'required_approval':
                $class = applicationConstants::YES == $row[$key] ? 'badge--unified-danger' : 'badge--unified-brand'; 
                $htm = ' <span class="badge badge--unified-success badge--inline badge--pill">' . Labels::getLabel('LBL_NOT_REQUIRED', $adminLangId) . '</span>';;
                if (Badge::TYPE_BADGE == $row[Badge::DB_TBL_PREFIX . 'type']) {
                    $htm = ' <span class="badge ' . $class . ' badge--inline badge--pill">' . Badge::getRequiredApprovalName($row[$key], $adminLangId) . '</span>';
                }
                $td->appendElement('plaintext', [], $htm, true);
                break;

            case Badge::DB_TBL_PREFIX . 'active':
                $active = "";
                if (applicationConstants::ACTIVE == $row[Badge::DB_TBL_PREFIX . 'active']) {
                    $active = 'checked';
                }
                
                $statusClass = ($canEdit === false) ? 'disabled' : '';
                $str = '<label class="statustab -txt-uppercase">
                        <input ' . $active . ' type="checkbox" id="switch' . $row[Badge::DB_TBL_PREFIX . 'id'] . '" value="' . $row[Badge::DB_TBL_PREFIX . 'id'] . '" onclick="toggleStatus(event,this,' . (int) !(applicationConstants::ACTIVE == $row[Badge::DB_TBL_PREFIX . 'active']) . ')" class="switch-labels"/>
                        <i class="switch-handles ' . $statusClass . '"></i>';
                $td->appendElement('plaintext', [], $str, true);
                break;
            case 'action':
                if ($canEdit) {
                    $function = "form(" . $row[Badge::DB_TBL_PREFIX . 'id'] . ", " . $row[Badge::DB_TBL_PREFIX . 'type'] . ")";
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_EDIT', $adminLangId), "onclick" => $function), "<i class='far fa-edit icon'></i>", true);
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_DELETE', $adminLangId), "onclick" => "deleteRecord(event, " . $row[Badge::DB_TBL_PREFIX . 'id'] . ")"), "<i class='fas fa-trash icon'></i>", true);
                } else {
                    $td->appendElement('plaintext', [], Labels::getLabel('LBL_N/A', $adminLangId), true);
                }
                break;
        }
    }
    $sr_no--;
}
if (count($arr_listing) == 0) {
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
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
