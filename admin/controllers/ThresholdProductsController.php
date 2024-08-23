<?php

class ThresholdProductsController extends ListingBaseController
{

    protected string $modelClass = 'SellerProduct';
    protected $pageKey = 'THRESHOLD_PRODUCTS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerProducts();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('canEdit', false);
        $this->set("frmSearch", $this->getSearchForm($fields));
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj), [
            'newRecordBtn' => false
        ]);
        $this->set('actionItemsData', $actionItemsData);
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME', $this->siteLangId));
        $this->getListingData();
        $this->_template->addJs(['threshold-products/page-js/index.js']);
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'selprod_id');
        }
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'threshold-products/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchForm($fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = SellerProduct::getSearchObject($this->siteLangId);
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'cred.credential_user_id = selprod_user_id', 'cred');
        $srch->joinTable(SentEmail::DB_TBL, 'LEFT OUTER JOIN', "arch.earch_to_email = cred.credential_email and earch_tpl_name = 'threshold_notification_vendor'", 'arch');
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('product_name', 'LIKE', '%' . $post['keyword'] . '%');
            $condition->attachCondition('selprod_title', 'LIKE', '%' . $post['keyword'] . '%');
        }

        $srch->addDirectCondition('selprod_stock <= selprod_threshold_stock_level');
        $srch->addDirectCondition('selprod_track_inventory = ' . Product::INVENTORY_TRACK);
        $srch->addGroupBy('selprod_id');
        $this->setRecordCount(clone $srch, $pageSize, $page, $post, true);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(array('selprod_id', 'selprod_user_id', 'IF(selprod_title is NULL or selprod_title = "" ,product_name, selprod_title) as product_name', 'selprod_stock', 'selprod_threshold_stock_level', 'earch_sent_on', 'credential_username'));
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $records);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', false);
    }

    public function sendMailThresholdStock($user_id, $selprod_id)
    {
        $user_id = FatUtility::int($user_id);
        $selprod_id = FatUtility::int($selprod_id);

        $userObj = new User($user_id);
        $user = $userObj->getUserInfo(null, false, false);
        if (!$user) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $emailNotificationObj = new EmailHandler();
        if (!$emailNotificationObj->sendProductStockAlert($selprod_id, $this->siteLangId)) {
            LibHelper::exitWithError($emailNotificationObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_YOUR_MESSAGE_SENT_TO', $this->siteLangId) . ' - ' . $user["credential_email"]);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getFormColumns(): array
    {
        $shopsTblHeadingCols = CacheHelper::get('productsthresholdTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols, true);
        }

        $arr = [
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'product_name' => Labels::getLabel('LBL_PRODUCT_NAME', $this->siteLangId),
            'selprod_stock' => Labels::getLabel('LBL_STOCK_LEFT', $this->siteLangId),
            'selprod_threshold_stock_level' => Labels::getLabel('LBL_THRESHOLD_STOCK', $this->siteLangId),
           /*  'earch_sent_on' => Labels::getLabel('LBL_LAST_EMAIL_SENT', $this->siteLangId), */
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('productsthresholdTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'product_name',
            'selprod_stock',
            'selprod_threshold_stock_level',
            /* 'earch_sent_on', */
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
