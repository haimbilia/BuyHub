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
                'COALESCE(badge_name, badge_identifier) as badge_name',
                'shop_name',
                'user_name'
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
        $srch->joinTable(Badge::DB_TBL, 'INNER JOIN', 'badge_id = breq_badge_id', 'bdg');
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
            $srch->addMultipleFields(array_merge(
                BadgeRequest::ATTR,
                ['COALESCE(badge_name, badge_identifier) as badge_name']
            ));
            $srch->addCondition('breq_id', '=', $badgeReqId);
            $requestedBadge = FatApp::getDb()->fetch($srch->getResultSet());
            if ($requestedBadge === false) {
                FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
            }
            $frm->fill($requestedBadge);
        }

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

        $badgeReqId = FatApp::getPostedData('breq_id', FatUtility::VAR_INT, 0);
        $post['breq_status_updated_on'] = date('Y-m-d H:i:s');

        $record = new BadgeRequest($badgeReqId);
        $record->assignValues($post);

        if (!$record->save()) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        
        $this->set('msg', Labels::getLabel("MSG_UPDATED_SUCCESSFULLY", $this->adminLangId));
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

        $approvalRequiredBadges = Badge::getAllBadgesAndRibbons($this->adminLangId, Badge::TYPE_BADGE, applicationConstants::YES);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_SELECT_BADGE', $this->adminLangId), 'breq_badge_id', $approvalRequiredBadges);
        $fld->requirements()->setRequired(true);
        $frm->addTextArea(Labels::getLabel('LBL_MESSAGE', $this->adminLangId), 'breq_message');

        $statusArr = BadgeRequest::getStatusArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_STATUS', $this->adminLangId), 'breq_status', $statusArr, '', array(), '');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel("LBL_REQUEST", $this->adminLangId));
        return $frm;
    }

    public function downloadFile(int $recordId)
    {
        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $recordId);
        if ($res == false) {
            Message::addErrorMessage(Labels::getLabel("MSG_Not_available_to_download", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('BadgeRequests'));
        }

        if (!file_exists(CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path'])) {
            Message::addErrorMessage(Labels::getLabel('LBL_File_not_found', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('BadgeRequests'));
        }

        $filePath = AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path'];
        AttachedFile::downloadAttachment($filePath, $res['afile_name']);
    }
}
