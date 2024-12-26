<?php

trait RequestForQuotesUtility
{
    public $isSeller = false;
    public $isBuyer = false;

    public function getRequestForQuotesCols()
    {
        return array(
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'rfq_number' => Labels::getLabel('LBL_RFQ_NO.', $this->siteLangId),
            'rfq_title' => Labels::getLabel('LBL_REQUEST_INFO', $this->siteLangId),
            'acceptedOffers' => Labels::getLabel('LBL_ACCEPTED', $this->siteLangId),
            'rejectedOffers' => Labels::getLabel('LBL_REJECTED', $this->siteLangId),
            'rfq_approved' => Labels::getLabel('LBL_APPROVAL', $this->siteLangId),
            'rfq_status' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'rfq_added_on' => Labels::getLabel('LBL_REQUESTED_ON', $this->siteLangId),
            'action' => '',
        );
    }

    public function index()
    {
        $funcName = $this->get('funcName') ?? __FUNCTION__;
        $placementType = (__FUNCTION__ == $funcName ? RequestForQuote::VISIBILITY_TYPE_CLOSED : RequestForQuote::VISIBILITY_TYPE_OPEN);
        $frm = $this->getSearchForm();
        if ($this->isSeller || (1 > FatApp::getConfig('CONF_GLOBAL_RFQ_MODULE', FatUtility::VAR_INT, 0))) {
            $frm->fill(['rfq_visibility_type' => $placementType]);
        }
        $this->set('frmSearch', $frm);

        $keys = $this->getRequestForQuotesCols();
        $this->set('headerCols', $keys);
        unset($keys['listSerial'], $keys['acceptedOffers'], $keys['rejectedOffers'], $keys['action']);
        $this->set('sortKeys', $keys);
        $this->set('sortBy', Labels::getLabel('LBL_REQUESTED_ON', $this->siteLangId));
        $this->set('sortKey', 'rfq_added_on');

        $this->_template->addJs(['request-for-quotes/page-js/index.js']);
        $this->_template->render(true, true, 'request-for-quotes/index.php');
    }

    protected function getSearchForm()
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'pageSize');
        if ($this->isSeller || (1 > FatApp::getConfig('CONF_GLOBAL_RFQ_MODULE', FatUtility::VAR_INT, 0))) {
            $frm->addHiddenField('', 'rfq_visibility_type');
        } else {
            $frm->addSelectBox(Labels::getLabel('FRM_RFQ_VISIBILITY_TYPE', $this->siteLangId), 'rfq_visibility_type', RequestForQuote::getVisibilityTypeArr($this->siteLangId));
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD'), 'keyword', '');
        $fld->overrideFldType('search');

        if ($this->isBuyer) {
            $approvalArr = RequestForQuote::getApprovalStatusArr($this->siteLangId);
            $frm->addSelectBox(Labels::getLabel('FRM_APPROVAL'), 'rfq_approved', $approvalArr);
        }

        $statusArr = RequestForQuote::getStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS'), 'rfq_status', $statusArr, '', [], Labels::getLabel('LBL_SELECT_STATUS', $this->siteLangId));

        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    public function search()
    {
        $frm = $this->getSearchForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $pagesize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT, 10));

        $srch = new RequestForQuoteSearch();
        $srch->addCondition('rfq_deleted', '=', applicationConstants::NO);
        if ($this->isSeller) {
            $srch->addCondition('rfq_approved', '=', RequestForQuote::APPROVED);
            $userRegDate = User::getAttributesById($this->userParentId, 'user_regdate');
            $srch->addCondition('rfq_added_on', '>=', $userRegDate);
        }
        $srch->joinBuyer();
        $srch->addMultipleFields([
            'rfq_id',
            'rfq_selprod_id',
            'rfq_number',
            'rfq_title',
            'rfq_selprod_id',
            'rfq_visibility_type',
            'rfq_product_id',
            'rfq_user_id',
            'rfq_type',
            'rfq_quantity',
            'rfq_quantity_unit',
            'rfq_status',
            'rfq_approved',
            'rfq_added_on',
            'rfq_delivery_date',
            'buc.credential_username as credential_username',
            'bu.user_id as user_id',
            'bu.user_updated_on',
            'buc.credential_email',
            'bu.user_name',
            '0 as totalOffers',
            '0 as rejectedOffers',
            '0 as acceptedOffers'
        ]);

        $visibilityType = $post['rfq_visibility_type'];
        if (0 < $visibilityType) {
            $srch->addCondition('rfq_visibility_type', '=', $visibilityType);
        }

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cond = $srch->addCondition('rfq_title', 'like', '%' . $keyword . '%');
            $cond->attachCondition('rfq_number', 'like', '%' . $keyword . '%');
        }

        $approved = $post['rfq_approved'] ?? -1;
        if (-1 < $approved) {
            $srch->addCondition('rfq_approved', '=', $approved);
        }
        $status = $post['rfq_status'] ?? -1;
        if (-1 < $status) {
            $srch->addCondition('rfq_status', '=', $status);
        }

        if ($this->isSeller) {
            if (RequestForQuote::VISIBILITY_TYPE_CLOSED == $visibilityType) {
                $srch->joinSellers();
                $srch->addFld('rfqts_user_id');
                $srch->addCondition('rfqts_user_id', '=', $this->userParentId);
            }
            $srch->addCondition('rfq_added_on', '>=', $userRegDate);
        } else {
            $srch->addCondition('rfq_user_id', '=', $this->userParentId);
        }

        $this->setRecordCount(clone $srch, $pagesize, $page, $post);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'rfq_added_on');
        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, 'DESC');
        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $arrListing = FatApp::getDb()->fetchAll($srch->getDataResultSet(), 'rfq_id');
        $assignedSellersCount = [];
        if (!empty($arrListing)) {
            $rfqIds = array_keys($arrListing);
            if ($this->isSeller) {
                $assignedSellersCount = RequestForQuote::assignedSellersCount($rfqIds);
            }

            $srch = new SearchBase(RfqOffers::DB_RFQ_LATEST_OFFER, 'rlo');
            if ($this->isSeller) {
                $srch->joinTable(RfqOffers::DB_TBL, 'INNER JOIN', 'ro.offer_id = rlo_primary_offer_id AND offer_user_id = ' . $this->userParentId, 'ro');
                $srch->addCondition('offer_user_id', '=', $this->userParentId);
            }

            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $srch->addCondition('rlo_rfq_id', 'IN', $rfqIds);
            $srch->addGroupBy('rlo_rfq_id');
            $srch->addCondition('rlo_deleted', '=', applicationConstants::NO);
            $srch->addMultipleFields(['rlo_rfq_id', 'rlo_status', 'COUNT(rlo_rfq_id) as totalOffers', 'SUM(IF(rlo_status =' . RfqOffers::STATUS_REJECTED . ',1,0)) as rejectedOffers', 'SUM(IF(rlo_status =' . RfqOffers::STATUS_ACCEPTED . ',1,0)) as acceptedOffers']);
            $arr = FatApp::getDb()->fetchAll($srch->getResultSet(), 'rlo_rfq_id');
            foreach ($arr as $key => $rfqVal) {
                $arrListing[$key]['totalOffers'] = $rfqVal['totalOffers'];
                $arrListing[$key]['acceptedOffers'] = $rfqVal['acceptedOffers'];
                $arrListing[$key]['rejectedOffers'] = $rfqVal['rejectedOffers'];
            }
        }

        $this->set('sellerLinkingLimit', FatApp::getConfig('CONF_GLOBAL_RFQ_SELLER_LINKING_LIMIT', FatUtility::VAR_INT, 5));
        $this->set('assignedSellersCountArr', $assignedSellersCount);
        $this->set('visibilityType', $visibilityType);
        $this->set('arrListing', $arrListing);
        $this->set('postedData', $post);
        $this->set('pagesize', $pagesize);
        $this->set("approvalStatusArr", RequestForQuote::getApprovalStatusArr($this->siteLangId));
        $this->set("statusArr", RequestForQuote::getStatusArr($this->siteLangId));
        $this->set("isBuyer", $this->isBuyer);
        $this->set('canEdit', $this->userPrivilege->canEditRfqOffers($this->userId, true));
        $this->set("isSeller", $this->isSeller);
        $this->set("userParentId", $this->userParentId);
        if (MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $tableCols = $this->getRequestForQuotesCols();
        if ($this->isSeller) {
            unset($tableCols['rfq_approved']);
        }
        $this->set('headerCols', $tableCols);
        $this->_template->render(false, false, 'request-for-quotes/search.php');
    }

    public function view(int $recordId)
    {
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if ($this->isSeller && !$this->userPrivilege->canViewRequestForQuote($this->userId, true)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS'), true);
        }

        $visibilityType = FatApp::getPostedData('rfq_visibility_type', FatUtility::VAR_INT, 0);

        $srch = new RequestForQuoteSearch();
        $srch->joinBuyer();
        $srch->joinBuyerAddress($this->siteLangId);
        $srch->joinCountry(true);
        $srch->joinState(true);
        $srch->joinRfqCategory(true);

        $dbFlds = array_merge(RequestForQuote::FIELDS, ['addr_name', 'addr_address1', 'addr_address2', 'addr_city', 'state_name', 'country_name', 'addr_zip', 'addr_phone_dcode', 'addr_phone', 'buc.credential_username as credential_username', 'bu.user_id as user_id', 'bu.user_updated_on', 'credential_email', 'bu.user_name', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name', 'COALESCE(prodcat_name, prodcat_identifier) as prodcat_name']);
        $srch->addMultipleFields($dbFlds);

        $srch->addCondition('rfq_id', '=', $recordId);
        if ($this->isSeller) {
            $userRegDate = User::getAttributesById($this->userParentId, 'user_regdate');
            if (RequestForQuote::VISIBILITY_TYPE_CLOSED == $visibilityType) {
                $srch->joinSellers('INNER');
                $srch->addCondition('rfqts_user_id', '=', $this->userParentId);
            }
            $srch->addCondition('rfq_added_on', '>=', $userRegDate);
        } else {
            $srch->addCondition('rfq_user_id', '=', $this->userParentId);
        }
        $this->set("rfqData", FatApp::getDb()->fetch($srch->getDataResultSet()));
        $this->set("approvalStatusArr", RequestForQuote::getApprovalStatusArr($this->siteLangId));
        $this->set("statusArr", RequestForQuote::getStatusArr($this->siteLangId));
        $this->set("productTypes", Product::getProductTypes($this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set("isSeller", $this->isSeller);

        if (MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->set('html', $this->_template->render(false, false, 'request-for-quotes/view.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function downloadFile(int $recordId)
    {
        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_RFQ, $recordId, 0, -1);
        if ($res == false || 1 > $res['afile_id']) {
            LibHelper::exitWithError(Labels::getLabel('ERR_NOT_AVAILABLE_TO_DOWNLOAD', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('RequestForQuotes'));
        }

        if (!file_exists(CONF_UPLOADS_PATH . $res['afile_physical_path'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_FILE_NOT_FOUND', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('RequestForQuotes'));
        }

        AttachedFile::downloadAttachment($res['afile_physical_path'], $res['afile_name']);
    }

    public function getSellersByProductId()
    {
        $json = RequestForQuote::getSellersByProductId($this->siteLangId);

        if (MOBILE_APP_API_CALL) {
            $this->set('data', ['sellers' => $json]);
            $this->_template->render();
        }

        die(FatUtility::convertToJson($json));
    }

    public function closeRfq(int $rfqId)
    {
        if (1 > $rfqId || $this->isSeller) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $userId = RequestForQuote::getAttributesById($rfqId, 'rfq_user_id');
        if ($userId != $this->userParentId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $rfq = new RequestForQuote($rfqId);
        if (false == $rfq->add(['rfq_status' => RequestForQuote::STATUS_CLOSED])) {
            LibHelper::exitWithError($rfq->getError(), true);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_CLOSED!', $this->siteLangId));
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel("LBL_REQUEST_FOR_QUOTES", $this->siteLangId)]
                ];
                break;
            case 'global':
                $this->nodes = [
                    ['title' => Labels::getLabel("LBL_GLOBAL_REQUEST_FOR_QUOTES", $this->siteLangId)]
                ];
                break;
        }
        return $this->nodes;
    }
}
