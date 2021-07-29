<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="js-scrollable table-wrap scroll scroll-x">
    <?php
    $arr_flds = array(
        'listserial' => Labels::getLabel('LBL_#', $siteLangId),
        'badge_name' => Labels::getLabel('LBL_BADGE', $siteLangId),
        'breq_record_type' => Labels::getLabel('LBL_RECORD_TYPE', $siteLangId),
        'breq_status' => Labels::getLabel('LBL_Status', $siteLangId),
        'breq_requested_on' => Labels::getLabel('LBL_REQUESTED_ON', $siteLangId),
    );
    if ($canEdit) {
        $arr_flds['action'] = '';
    }
    $tableClass = '';
    if (0 < count($arrListing)) {
        $tableClass = "table-justified";
    }

    $recordTypeArr = BadgeLinkCondition::getRecordTypeArr($siteLangId);
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
                case 'badge_name':
                    $name = $row[$key];
                    $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[Badge::DB_TBL_PREFIX . 'id'], 0, $siteLangId);
                    $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
                    $td->appendElement('img', ['src' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], "THUMB", $icon['afile_screen']), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'), 'title' => $name, 'alt' => $name], '', true);
                    break;
                case 'breq_record_type':
                    $txt = empty($row[$key]) ? Labels::getLabel("LBL_N/A", $siteLangId) : $recordTypeArr[$row[$key]];
                    $td->appendElement('plaintext', [], $txt, true);
                    break;
                case 'breq_status':
                    $class = (BadgeRequest::REQUEST_PENDING == $row[$key]) ? 'label-info' : ((BadgeRequest::REQUEST_APPROVED == $row[$key]) ? 'label-success' : 'label-danger');

                    $td->appendElement('span', array('class' => 'label label-inline ' . $class), $statusArr[$row[$key]] . '<br>', true);
                    $td->appendElement('small', array('class' => 'ml-1'), (isset($row['breq_status_updated_on']) && $row['breq_status_updated_on'] != '0000-00-00 00:00:00') ? FatDate::Format($row['breq_status_updated_on']) : '', true);
                    break;
                case 'breq_requested_on':
                    $td->appendElement('plaintext', array(), (isset($row[$key]) && $row[$key] != '0000-00-00 00:00:00') ? FatDate::Format($row[$key]) : Labels::getLabel('LBL_NA', $siteLangId), true);
                    break;
                case 'action':
                    if ($row['breq_status'] == BadgeRequest::REQUEST_PENDING) {
                        $ul = $td->appendElement("ul", array('class' => 'actions'), '', true);
                        $li = $ul->appendElement("li");
                        $li->appendElement(
                            'a',
                            array('href' => 'javascript:void(0)', 'onclick' => "addBadgeReqForm(" . $row['breq_id'] . ", " . $row['badge_id'] . ")", 'class' => '', 'title' => Labels::getLabel('LBL_Edit', $siteLangId)),
                            '<i class="fa fa-edit"></i>',
                            true
                        );
                        $li = $ul->appendElement("li");
                        $li->appendElement(
                            'a',
                            array('href' => 'javascript:void(0)', 'onclick' => "deleteBadgeRequest(" . $row['breq_id'] . ")", 'class' => '', 'title' => Labels::getLabel('LBL_DELETE', $siteLangId)),
                            '<i class="fa fa-trash"></i>',
                            true
                        );
                    }
                    break;
                default:
                    $td->appendElement('plaintext', array(), $row[$key], true);
                    break;
            }
        }
        $sr_no--;
    }

    echo $tbl->getHtml();
    if (count($arrListing) == 0) {
        $message = Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId);
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
    } ?>
</div>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmSearchBadgeRequest'));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'callBackJsFunc' => 'goToBadgeSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
