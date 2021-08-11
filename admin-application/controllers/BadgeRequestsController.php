<?php

class BadgeRequestsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();

        $this->objPrivilege->canViewBadgeRequests($this->admin_id);
    }

    public function index()
    {
        $frmSearch = $this->getSearchForm();
        $this->set("canEdit", $this->objPrivilege->canEditBadgeRequests($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }

    public function search()
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($searchForm->getValidationErrors()));
        }

        $srch = $this->getRequestedBadgeObj();
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'u.user_id = breq_user_id', 'u');
        $srch->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'shop_user_id = if(u.user_parent > 0, user_parent, u.user_id)', 'shop');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'shop.shop_id = s_l.shoplang_shop_id AND shoplang_lang_id = ' . $this->adminLangId, 's_l');
        $srch->addCondition(BadgeRequest::DB_TBL_PREFIX . 'status', '=', BadgeRequest::REQUEST_PENDING);
        
        $srch->addMultipleFields(array_merge(
            BadgeRequest::ATTR,
            [
                'COALESCE(' . Badge::DB_TBL_PREFIX . 'name, ' . Badge::DB_TBL_PREFIX . 'identifier) as ' . Badge::DB_TBL_PREFIX . 'name',
                'shop_name',
                'user_name',
                Badge::DB_TBL_PREFIX . 'id'
            ]
        ));

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('badge_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('badge_identifier', 'like', '%' . $keyword . '%');
        }

        $sellerId = $post['user_id'];
        if (!empty($sellerId)) {
            $srch->addCondition(BadgeRequest::DB_TBL_PREFIX . 'user_id', '=',  $sellerId);
        }

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("canEdit", $this->objPrivilege->canEditBadgeRequests($this->admin_id, true));
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    private function getRequestedBadgeObj()
    {
        $srch = new SearchBase(BadgeRequest::DB_TBL, 'breq');
        $srch->joinTable(BadgeLinkCondition::DB_TBL, 'INNER JOIN', 'blinkcond_id = breq_blinkcond_id', 'blc');
        $srch->joinTable(Badge::DB_TBL, 'INNER JOIN', 'badge_id = blinkcond_badge_id', 'bdg');
        $srch->joinTable(Badge::DB_TBL_LANG, 'LEFT JOIN', 'badgelang_badge_id = badge_id AND badgelang_lang_id = ' . $this->adminLangId, 'bdg_l');
        $srch->addOrder(BadgeRequest::DB_TBL_PREFIX . 'requested_on', 'DESC');
        return $srch;
    }

    public function form(int $badgeReqId)
    {
        $this->objPrivilege->canEditBadgeRequests();
        $frm = $this->getForm();

        if (0 < $badgeReqId) {
            $srch = $this->getRequestedBadgeObj();
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $srch->addCondition('breq_id', '=', $badgeReqId);
            $requestedBadge = FatApp::getDb()->fetch($srch->getResultSet());
            if ($requestedBadge === false) {
                FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
            }
            $requestedBadge['record_ids'] = json_encode($this->records($badgeReqId, true));
            $blinkCondId = $requestedBadge['breq_blinkcond_id'];
            $frm->fill($requestedBadge);

            $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId);
            $this->set('fileFound', (false !== $res && 0 < $res['afile_id']));
        }

        $this->set('blinkCondId', $blinkCondId);
        $this->set('frm', $frm);
        $this->set('badgeReqId', $badgeReqId);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditBadgeRequests();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $badgeLinkCondId = FatApp::getPostedData('breq_blinkcond_id', FatUtility::VAR_INT, 0);
        if (1 > $badgeLinkCondId) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_BADGE', $this->adminLangId));
        }

        $recordIds = isset($post['record_ids']) ? json_decode($post['record_ids'], true) : [];
        if (null === $recordIds || false === $recordIds || empty($recordIds)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_PLEASE_SELECT_ATLEAST_ONE_RECORD', $this->adminLangId));
        }

        $badgeReqId = FatApp::getPostedData('breq_id', FatUtility::VAR_INT, 0);

        $post['breq_status_updated_on'] = date('Y-m-d H:i:s');

        $status = BadgeRequest::getRequestStatus($post['breq_blinkcond_id'], UserAuthentication::getLoggedUserId());
        if (BadgeRequest::REQUEST_APPROVED == $status || BadgeRequest::REQUEST_REJECTED == $status) {
            $msg = Labels::getLabel('MSG_YOUR_REQUEST_TO_THIS_BADGE_ID_ALREADY_APPROVED/REJECTED', $this->adminLangId);
            FatUtility::dieJsonError($msg);
        }
        
        $record = new BadgeRequest($badgeReqId);
        $record->assignValues($post);

        if (!$record->save()) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $badgeReqId = $record->getMainTableRecordId();

        $msg = Labels::getLabel("MSG_REQUEST_UPDATED_SUCCESSFULLY", $this->adminLangId);
        $this->set('msg', $msg);
        $this->set('badgeReqId', $badgeReqId);
        $this->_template->render(false, false, 'json-success.php');
    }


    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->adminLangId), 'keyword', '');

        $frm->addTextBox(Labels::getLabel('LBL_SELLER_NAME_OR_EMAIL', $this->adminLangId), 'user_name', '', array('id' => 'keyword', 'autocomplete' => 'off'));
        $frm->addHiddenField('', 'user_id');

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getForm()
    {
        $frm = new Form('frmBadgeReq');
        $frm->addHiddenField('', 'breq_id');
        $frm->addHiddenField('', 'record_ids');
        $frm->addHiddenField('', 'breq_record_type');
        $frm->addHiddenField('', 'breq_user_id');
        $frm->addHiddenField('', 'breq_blinkcond_id');

        $frm->addTextArea(Labels::getLabel('LBL_MESSAGE', $this->adminLangId), 'breq_message');
        $frm->addSelectBox(Labels::getLabel('LBL_LINK_TO', $this->adminLangId), 'badgelink_record_id', [], '', ['placeholder' => Labels::getLabel('LBL_SEARCH_RECORD', $this->adminLangId), 'class' => 'recordIds--js'], '');
        
        $statusArr = BadgeRequest::getStatusArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_STATUS', $this->adminLangId), 'breq_status', $statusArr, '', array(), '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel("LBL_UPDATE", $this->adminLangId));
        return $frm;
    }

    public function records(int $badgeReqId, bool $returnAllRecordIds = false)
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;

        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->adminLangId, true);
        /* Bind Records */
        $srch->joinProduct($this->adminLangId);
        $srch->joinSellerProduct($this->adminLangId);
        $srch->joinShop($this->adminLangId);
        /* Bind Records */
        $srch->joinTable(BadgeRequest::DB_TBL, 'INNER JOIN', 'blc.badgelink_breq_id = breq.breq_id', 'breq');

        if (false === $returnAllRecordIds) {
            $srch->setPageNumber($page);
            $srch->setPageSize($pagesize);
        } else {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
        }

        $srch->addCondition('breq_id', '=', $badgeReqId);
        $result = FatApp::getDb()->fetchAll($srch->getResultSet(), 'badgelink_record_id');
        
        if (true === $returnAllRecordIds) {
            return array_keys($result);
        }

        $records = [];
        foreach ($result as $badgeLink) {
            if (array_key_exists('badgelink_record_id', $badgeLink) && empty($badgeLink['badgelink_record_id'])) {
                break;
            }

            $recordId = $badgeLink['badgelink_record_id'];
            $recordName = $badgeLink['record_name'];
            $optionName = explode('|', $badgeLink['option_name']);
            $optionValueName = explode('|', $badgeLink['option_value_name']);
            $seller = $badgeLink['seller'];
            unset($badgeLink['badgelink_record_id'], $badgeLink['record_name'], $badgeLink['option_name'], $badgeLink['option_value_name'], $badgeLink['seller']);

            if (BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT == $badgeLink['blinkcond_record_type']) {
                $name = $recordName;
                if (isset($records[$recordId]['record_name'])) {
                    $name = $records[$recordId]['record_name'];
                }

                $option = '';
                foreach ($optionName as $index => $optname) {
                    $option .= !empty($optname) ? ' | ' .  $optname . ' : ' . (isset($optionValueName[$index]) ? $optionValueName[$index] : '') : '';   
                }
                $recordName = $name . $option . ' | ' . $seller;
            }

            $records[$recordId] = [
                'badgelink_record_id' => $recordId,
                'record_name' => $recordName
            ];
        }

        $this->set('badgeReqId', $badgeReqId);
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('recordCount', $srch->recordCount());
        $this->set('pageCount', $srch->pages());
        $this->set('records', $records);
        $this->set('postedData', FatApp::getPostedData());
        $this->_template->render(false, false);
    }

    public function unlinkRecord(int $badgeReqId, int $record_id = 0)
    {
        if (1 > $badgeReqId || 1 > $record_id) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
        }
        $smt = 'badgelink_breq_id = ?';
        $vals = [$badgeReqId];
        if (0 < $record_id) {
            $smt .= ' AND badgelink_record_id = ?';
            $vals[] = $record_id;
        }

        $db = FatApp::getDb();
        if (!$db->deleteRecords(
            BadgeLinkCondition::DB_TBL_BADGE_LINKS,
            [
                'smt' => $smt,
                'vals' => $vals
            ]
        )) {
            FatUtility::dieJsonError($db->getError());
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESS', $this->adminLangId));
    }

    public function downloadFile(int $badgeReqId)
    {
        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId);
        if ($res == false || 1 > $res['afile_id']) {
            Message::addErrorMessage(Labels::getLabel("MSG_NOT_AVAILABLE_TO_DOWNLOAD", $this->adminLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('BadgeRequests'));
        }

        if (!file_exists(CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path'])) {
            Message::addErrorMessage(Labels::getLabel('LBL_FILE_NOT_FOUND', $this->adminLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('BadgeRequests'));
        }

        $filePath = AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path'];
        AttachedFile::downloadAttachment($filePath, $res['afile_name']);
    }
}
