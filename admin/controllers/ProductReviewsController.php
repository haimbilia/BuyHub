<?php

class ProductReviewsController extends ListingBaseController
{

    protected string $modelClass = 'SelProdReview';
    protected $pageKey = 'MANAGE_PRODUCT_REVIEWS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewProductReviews();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditProductReviews($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditProductReviews();
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['performBulkAction'] = false;
        $actionItemsData['deleteButton'] = false;
        $actionItemsData['searchFrmTemplate'] = 'product-reviews/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('canEdit', $this->objPrivilege->canEditZones($this->admin_id, true));
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT', $this->siteLangId));
        $this->getListingData();
        $this->_template->addJs(['js/select2.js', 'product-reviews/page-js/index.js']);
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'seller_id', 0);
        $frm->addHiddenField('', 'spreview_id', 0);
        $frm->addHiddenField('', 'reviewed_for', 0);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $reviewedForId = FatApp::getPostedData('reviewed_for_id', FatUtility::VAR_INT, 0);
        $options = [];
        if (0 < $reviewedForId) {
            $user = new User($reviewedForId);
            $userInfo = $user->getUserInfo();
            $options = [
                $reviewedForId => $userInfo['user_name'] . ' (' . $userInfo['credential_username'] . ')'
            ];
        }

        $frm->addSelectBox(Labels::getLabel('FRM_REVIEW_FOR', $this->siteLangId), 'reviewed_for_id', $options, $reviewedForId);
        $statusArr = SelProdReview::getReviewStatusArr($this->siteLangId);
        $reqLbl = Labels::getLabel('FRM_REQUEST_STATUS', $this->siteLangId);
        $frm->addSelectBox($reqLbl, 'spreview_status', $statusArr, '', [], Labels::getLabel('FRM_DOES_NOT_MATTER', $this->siteLangId));

        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addHiddenField('', 'page');
        $this->addSortingElements($frm, 'spreview_posted_on', applicationConstants::SORT_DESC);
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'product-reviews/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }


    public function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'spreview_posted_on');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'spreview_posted_on';
        }
        switch ($sortBy) {
            case 'seller_username':
                $sortBy = 'usc.credential_username';
                break;
            case 'product_name':
                $sortBy = 'product_identifier';
                break;
            case 'buyer_name':
                $sortBy = 'u.user_name';
                break;
            case 'selprod_title':
                $sortBy = 'product_identifier';
                break;
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC), applicationConstants::SORT_DESC);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $searchForm = $this->getSearchForm($fields);
        $post = $searchForm->getFormDataFromArray($data, ['reviewed_for_id']);

        $srch = new SelProdReviewSearch($this->siteLangId);
        $srch->joinUser();
        $srch->joinSeller();
        $srch->joinShops($this->siteLangId);
        $srch->joinProducts();
        $srch->joinSellerProducts($this->siteLangId);
        $srch->joinSelProdRating();
        $srch->addCondition('rt.ratingtype_type', '=', RatingType::TYPE_PRODUCT);

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('product_name', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('product_identifier', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('selprod_title', 'LIKE', '%' . $post['keyword'] . '%');
        }

        if ($post['reviewed_for_id'] > 0) {
            $cnd = $srch->addCondition('shop_user_id', '=', $post['reviewed_for_id']);
            $cnd->attachCondition('spreview_seller_user_id', '=', $post['seller_id'], 'OR');
        }

        if ($post['seller_id'] > 0) {
            $srch->addCondition('spreview_seller_user_id', '=', $post['seller_id']);
        }

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, -1);
        $reviewId = FatApp::getPostedData('spreview_id', FatUtility::VAR_INT, $recordId);
        if (0 < $reviewId) {
            $srch->addCondition('spreview_id', '=', $reviewId);
        }

        if ($post['spreview_status'] != '' && $post['spreview_status'] > -1) {
            $srch->addCondition('spreview_status', '=', $post['spreview_status']);
        }

        $date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('spreview_posted_on', '>=', $date_from . ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('spreview_posted_on', '<=', $date_to . ' 23:59:59');
        }

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields([
            'IFNULL(product_name,product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
            'selprod_id', 'usc.credential_username as seller_username', 'uc.credential_username as reviewed_by', 'uc.credential_user_id', 'spreview_id',
            'spreview_posted_on', 'spreview_status', 'sprating_rating', 'shop_id', 'shop_user_id', 'IFNULL(shop_name, shop_identifier) as shop_name',
            'u.user_name AS buyer_name', 'us.user_name AS seller_name', 'selprod_product_id', 'product_updated_on'
        ]);
        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet(), 'spreview_id'));
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->checkEditPrivilege(true);
        $this->set('reviewStatus', SelProdReview::getReviewStatusArr($this->siteLangId));
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
        $this->checkEditPrivilege(true);
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frm = $this->getForm($recordId);
        $srch = new SelProdReviewSearch($this->siteLangId);
        $srch->joinUser();
        $srch->joinProducts();
        $srch->addMultipleFields(array('IFNULL(product_name,product_identifier) as product_name', 'uc.credential_username as reviewed_by', 'spreview_id', 'spreview_posted_on', 'spreview_status', 'spreview_title', 'spreview_description'));
        $srch->addOrder('spreview_posted_on', 'DESC');
        $srch->addCondition('spreview_id', '=', $recordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetch($rs);

        $frm->fill($records);

        $avgRatingSrch = SelProdRating::getSearchObj();
        $avgRatingSrch->addCondition('sprating_spreview_id', '=', $recordId);
        $avgRatingSrch->addMultipleFields(array('AVG(sprating_rating) as average_rating'));
        $avgRatingSrch->doNotCalculateRecords();
        $avgRatingSrch->setPageSize(1);
        $avgRatingRs = $avgRatingSrch->getResultSet();
        $avgRatingData = FatApp::getDb()->fetch($avgRatingRs);

        $ratingSrch = SelProdRating::getSearchObj();
        $ratingSrch->joinTable(
            RatingType::DB_TBL,
            'INNER JOIN',
            'rt.ratingtype_id = sprating_ratingtype_id',
            'rt'
        );
        $ratingSrch->joinTable(
            RatingType::DB_TBL_LANG,
            'LEFT OUTER JOIN',
            'rt_l.ratingtypelang_ratingtype_id = rt.ratingtype_id AND rt_l.ratingtypelang_lang_id = ' . $this->siteLangId,
            'rt_l'
        );
        $ratingSrch->addCondition('sprating_spreview_id', '=', $recordId);
        $ratingSrch->addMultipleFields(array('sprating_spreview_id', 'sprating_ratingtype_id', 'sprating_rating', 'COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name'));
        $ratingSrch->doNotCalculateRecords();
        $ratingSrch->doNotLimitRecords();

        $ratingRs = $ratingSrch->getResultSet();
        $ratingData = FatApp::getDb()->fetchAll($ratingRs);
        $abusiveWords = Abusive::getAbusiveWords();
        $this->set("recordId", $recordId);
        $this->set("abusiveWords", $abusiveWords);
        $this->set("data", $records);
        $this->set("ratingData", $ratingData);
        $this->set("avgRatingData", $avgRatingData);
        $this->set("frm", $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm($recordId)
    {
        $frm = new Form('reviewRequestForm');
        $frm->addHiddenField('', 'spreview_id', $recordId);
        $frm->addRequiredField(Labels::getLabel('FRM_TITLE', $this->siteLangId), 'spreview_title');
        $frm->addTextArea(Labels::getLabel('FRM_DESCRIPTION', $this->siteLangId), 'spreview_description')->requirements()->setRequired();
        $statusArr = SelProdReview::getReviewStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'spreview_status', $statusArr, '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId))->requirements()->setRequired();
        HtmlHelper::addButtonHtml(Labels::getLabel('FRM_UPDATE_STATUS', $this->siteLangId));
        return $frm;
    }

    public function setup()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('spreview_id', FatUtility::VAR_INT, 0);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frm = $this->getForm($recordId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $data = SelProdReview::getAttributesById($recordId, ['spreview_id', 'spreview_status', 'spreview_lang_id', 'spreview_seller_user_id','spreview_product_id']);
        if (false == $data) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $record = new SelProdReview($recordId);
        $record->assignValues($post);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        SelProdRating::updateSellerRating($data['spreview_seller_user_id']);
        SelProdReview::updateSellerTotalReviews($data['spreview_seller_user_id']);
        SelProdReview::updateProductRating($data['spreview_product_id']);

        $emailNotificationObj = new EmailHandler();
        $emailNotificationObj->sendBuyerReviewStatusUpdatedNotification($recordId, $data['spreview_lang_id']);

        $this->set('msg', $this->str_update_record);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $ContentPageTblHeadingCols = CacheHelper::get($this->pageKey . 'headingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($ContentPageTblHeadingCols) {
            return json_decode($ContentPageTblHeadingCols, true);
        }

        $arr = [
            /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'selprod_title' => Labels::getLabel('LBL_PRODUCT', $this->siteLangId),
            'seller_username' => Labels::getLabel('LBL_REVIEW_FOR', $this->siteLangId),
            'reviewed_by' => Labels::getLabel('LBL_REVIEWED_BY', $this->siteLangId),
            'sprating_rating' => Labels::getLabel('LBL_REVIEW_RATING', $this->siteLangId),
            'spreview_posted_on' => Labels::getLabel('LBL_DATE', $this->siteLangId),
            'spreview_status' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId)
        ];
        CacheHelper::create($this->pageKey . 'headingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'selprod_title',
            'seller_username',
            'reviewed_by',
            'sprating_rating',
            'spreview_posted_on',
            'spreview_status',
            'action'
        ];
    }

    /**
     * Undocumented function
     *
     * @param array $fields
     * @return array
     */
    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, [], Common::excludeKeysForSort());
    }
}
