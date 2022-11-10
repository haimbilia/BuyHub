<?php

class BadgeRequestsController extends ListingBaseController
{

    protected string $pageKey = 'MANAGE_BADGE_REQUESTS';
    private array $recordData = [];

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBadgeRequests();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_BADGE_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js', 'badge-requests/page-js/index.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeFeatherLightJsCss();
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'badge-requests/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'breq_requested_on');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'breq_requested_on';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = $this->getRequestedBadgeObj();
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'u.user_id = breq_user_id', 'u');
        $srch->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'shop_user_id = if(u.user_parent > 0, user_parent, u.user_id)', 'shop');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'shop.shop_id = s_l.shoplang_shop_id AND shoplang_lang_id = ' . $this->siteLangId, 's_l');
        $srch->addCondition(BadgeRequest::DB_TBL_PREFIX . 'status', '=', 'mysql_func_' . BadgeRequest::REQUEST_PENDING, 'AND', true);
        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('badge_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('badge_identifier', 'like', '%' . $keyword . '%');
        }

        $sellerId = FatApp::getPostedData('user_id', FatUtility::VAR_INT, 0);
        if (!empty($sellerId)) {
            $srch->addCondition(BadgeRequest::DB_TBL_PREFIX . 'user_id', '=', $sellerId);
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(array_merge(
            BadgeRequest::ATTR,
            [
                'COALESCE(' . Badge::DB_TBL_PREFIX . 'name, ' . Badge::DB_TBL_PREFIX . 'identifier) as ' . Badge::DB_TBL_PREFIX . 'name',
                'shop_name',
                'shop_id',
                'shop_user_id',
                'shop_updated_on',
                'user_name',
                Badge::DB_TBL_PREFIX . 'id'
            ]
        ));

        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("arrListing", $records);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditBadgeRequests($this->admin_id, true));
    }

    private function getRequestedBadgeObj()
    {
        $srch = new SearchBase(BadgeRequest::DB_TBL, 'breq');
        $srch->joinTable(BadgeLinkCondition::DB_TBL, 'INNER JOIN', 'blinkcond_id = breq_blinkcond_id', 'blc');
        $srch->joinTable(Badge::DB_TBL, 'INNER JOIN', 'badge_id = blinkcond_badge_id', 'bdg');
        $srch->joinTable(Badge::DB_TBL_LANG, 'LEFT JOIN', 'badgelang_badge_id = badge_id AND badgelang_lang_id = ' . $this->siteLangId, 'bdg_l');
        return $srch;
    }

    public function form()
    {
        $this->objPrivilege->canEditBadgeRequests();
        $badgeReqId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (1 > $badgeReqId) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $srch = $this->getRequestedBadgeObj();
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('breq_id', '=', 'mysql_func_' . $badgeReqId, 'AND', true);
        $requestedBadge = FatApp::getDb()->fetch($srch->getResultSet());
        if ($requestedBadge === false) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
        }
        $this->loadRecords($badgeReqId, true);
        $blinkCondId = $requestedBadge['breq_blinkcond_id'];
        $breqRecordType = $requestedBadge['breq_record_type'];

        $shop = [];
        if (BadgeLinkCondition::RECORD_TYPE_SHOP == $breqRecordType) {
            $shop = Shop::getAttributesByLangId($this->siteLangId, key($this->recordData), ['shop_name', 'shop_id', 'shop_updated_on'], applicationConstants::JOIN_RIGHT);
        }

        $frm = $this->getForm($breqRecordType);
        $frm->fill($requestedBadge);

        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId);
        $fileFound = (false !== $res && 0 < $res['afile_id']);

        $this->set('shopData', $shop);
        $this->set('fileFound', $fileFound);
        $this->set('breqRecordType', $breqRecordType);
        $this->set('blinkCondId', $blinkCondId);
        $this->set('frm', $frm);
        $this->set('badgeReqId', $badgeReqId);
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_REQUEST_TO_BIND_BADGE', $this->siteLangId));

        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditBadgeRequests();
        $breqRecordType = FatApp::getPostedData('breq_record_type', FatUtility::VAR_INT, 0);
        if (1 > $breqRecordType) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_RECORD_TYPE', $this->siteLangId), true);
        }
        $frm = $this->getForm($breqRecordType);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $badgeLinkCondId = FatApp::getPostedData('breq_blinkcond_id', FatUtility::VAR_INT, 0);
        if (1 > $badgeLinkCondId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_BADGE', $this->siteLangId), true);
        }

        $recordIds = FatApp::getPostedData('badgelink_record_ids', FatUtility::VAR_INT, []);
        if (empty($recordIds)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_ATLEAST_ONE_RECORD', $this->siteLangId), true);
        }

        $badgeReqId = FatApp::getPostedData('breq_id', FatUtility::VAR_INT, 0);
        $record = new BadgeRequest($badgeReqId);
        $requestData = $record->getBadgeData($this->siteLangId);
        if (empty($requestData)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_BADGE_REQUEST', $this->siteLangId), true);
        }

        $post['breq_status_updated_on'] = date('Y-m-d H:i:s');

        $requestStatus = FatApp::getPostedData('breq_status', FatUtility::VAR_INT, BadgeRequest::REQUEST_PENDING);

        $status = $requestData['breq_status'];
        $errMsg = BadgeRequest::REQUEST_PENDING == $status ? 'PENDING' : (BadgeRequest::REQUEST_APPROVED == $status ? 'APPROVED' : 'REJECTED');
        $errMsg = Labels::getLabel('ERR_' . $errMsg, $this->siteLangId);

        if ($requestStatus == $status) {
            $msg = Labels::getLabel('ERR_YOUR_REQUEST_TO_THIS_BADGE_ALREADY_{ERROR}', $this->siteLangId);
            $msg = CommonHelper::replaceStringData($msg, ['{ERROR}' => $errMsg]);
            LibHelper::exitWithError($msg, true);
        }

        unset($post['breq_message']);

        $record->assignValues($post);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        $badgeReqId = $record->getMainTableRecordId();

        $db = FatApp::getDb();
        if (!$db->deleteRecords(
            BadgeLinkCondition::DB_TBL_BADGE_LINKS,
            [
                'smt' => 'badgelink_breq_id = ?',
                'vals' => [$badgeReqId]
            ]
        )) {
            LibHelper::exitWithError($db->getError(), true);
        }

        foreach ($recordIds as $recordId) {
            $linkData = array(
                'badgelink_blinkcond_id' => $badgeLinkCondId,
                'badgelink_record_id' => $recordId,
                'badgelink_breq_id' => $badgeReqId
            );
            FatApp::getDb()->insertFromArray(BadgeLinkCondition::DB_TBL_BADGE_LINKS, $linkData, false, [], $linkData);
        }

        $email = new EmailHandler();
        if ($requestStatus != BadgeRequest::REQUEST_PENDING) {
            if (!$email->sendBadgeRequestStatusChangeNotification($this->siteLangId, array_merge($requestData, $post))) {
                LibHelper::exitWithError(Labels::getLabel('LBL_Email_Could_Not_Be_Sent', $this->siteLangId));
            }
        }

        $this->set('msg', Labels::getLabel("MSG_REQUEST_UPDATED_SUCCESSFULLY", $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getSearchForm(array $fields = [])
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'page');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_SELLER_NAME_OR_EMAIL', $this->siteLangId), 'user_id', []);

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'breq_requested_on', applicationConstants::SORT_DESC);
        }
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getForm($breqRecordType)
    {
        $frm = new Form('frmBadgeReq');
        $frm->addHiddenField('', 'breq_id');
        $frm->addHiddenField('', 'breq_record_type', $breqRecordType);
        $frm->addHiddenField('', 'breq_user_id');
        $frm->addHiddenField('', 'breq_blinkcond_id');

        $statusArr = BadgeRequest::getStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'breq_status', $statusArr, '', array(), '');

        $frm->addDateTimeField(Labels::getLabel('FRM_FROM_DATE', $this->siteLangId), 'blinkcond_from_date', '', ['readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender date_js']);
        $frm->addDateTimeField(Labels::getLabel('FRM_TO_DATE', $this->siteLangId), 'blinkcond_to_date', '', ['readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender date_js']);

        $frm->addTextArea(Labels::getLabel('FRM_MESSAGE', $this->siteLangId), 'breq_message');
        $frm->addHTML('', 'request_ref', '');
        $frm->addHTML('', 'link_type', '');

        if (BadgeLinkCondition::RECORD_TYPE_SHOP == $breqRecordType) {
            $frm->addHiddenField('', 'badgelink_record_ids[]', key($this->recordData));
        } else {
            $frm->addSelectBox(Labels::getLabel('FRM_SELECTED_RECORDS', $this->siteLangId), 'badgelink_record_ids[]', $this->recordData, array_keys($this->recordData), ['placeholder' => Labels::getLabel('FRM_SEARCH_RECORD', $this->siteLangId)], '');
        }

        return $frm;
    }

    private function loadRecords(int $badgeReqId)
    {
        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->siteLangId, true);
        /* Bind Records */
        $srch->joinProduct($this->siteLangId);
        $srch->joinSellerProduct($this->siteLangId);
        $srch->joinShop($this->siteLangId);
        /* Bind Records */
        $srch->joinTable(BadgeRequest::DB_TBL, 'INNER JOIN', 'blc.badgelink_breq_id = breq.breq_id', 'breq');

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        $srch->addCondition('breq_id', '=', 'mysql_func_' . $badgeReqId, 'AND', true);
        $result = FatApp::getDb()->fetchAll($srch->getResultSet(), 'badgelink_record_id');

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
                if (isset($this->recordData[$recordId]['record_name'])) {
                    $name = $this->recordData[$recordId]['record_name'];
                }

                $option = '';
                foreach ($optionName as $index => $optname) {
                    $option .= !empty($optname) ? ' | ' . $optname . ' : ' . (isset($optionValueName[$index]) ? $optionValueName[$index] : '') : '';
                }
                $recordName = $name . $option . ' | ' . $seller;
            }

            $this->recordData[$recordId] = $recordName;
        }
        return;
    }

    public function downloadFile(int $badgeReqId)
    {
        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId);
        if ($res == false || 1 > $res['afile_id']) {
            LibHelper::exitWithError(Labels::getLabel('ERR_NOT_AVAILABLE_TO_DOWNLOAD', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('BadgeRequests'));
        }

        if (!file_exists(CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_FILE_NOT_FOUND', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('BadgeRequests'));
        }

        $filePath = AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path'];
        AttachedFile::downloadAttachment($filePath, $res['afile_name']);
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('badgeRequestTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'badge_name' => Labels::getLabel('LBL_BADGE_NAME', $this->siteLangId),
            'media' => Labels::getLabel('LBL_BADGE', $this->siteLangId),
            'seller' => Labels::getLabel('LBL_REQUESTED_BY', $this->siteLangId),
            'download' => Labels::getLabel('LBL_REQUEST_REF.', $this->siteLangId),
            'breq_requested_on' => Labels::getLabel('LBL_REQUESTED_ON', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        if (count(Language::getAllNames()) < 2) {
            unset($arr['language_name']);
        }

        CacheHelper::create('badgeRequestTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            /*  'listSerial', */
            'badge_name',
            'media',
            'seller',
            'download',
            'breq_requested_on',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['media', 'download'], Common::excludeKeysForSort());
    }
}
