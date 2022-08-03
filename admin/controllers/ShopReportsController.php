<?php

class ShopReportsController extends ListingBaseController
{
    protected string $modelClass = 'ShopReport';
    protected $pageKey = 'REPORT_SHOPS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewShopReports();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $shopId = FatApp::getPostedData('shop_id', FatUtility::VAR_INT, 0);
        if (0 < $shopId) {
            $shop = Shop::getAttributesByLangId($this->siteLangId, $shopId, ['COALESCE(shop_name, shop_identifier) as shop_name'], applicationConstants::JOIN_LEFT);
            $frmSearch->fill(['keyword' => $shop['shop_name']]);
        }

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->getListingData();
        $this->_template->addJs(array('shop-reports/page-js/index.js'));
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_SHOP_NAME', $this->siteLangId));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'shop-reports/search.php', true),
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


        $reportReasonObj = ShopReportReason::getSearchObject($this->siteLangId);
        $reportReasonObj->addMultipleFields(array('reportreason.*', 'reportreason_l.reportreason_title'));
        $reportReasonObj->doNotCalculateRecords();
        $reportReasonObj->doNotLimitRecords();
        $result_report_reasons = $reportReasonObj->getQuery();

        $srch = ShopReport::getSearchObject($this->siteLangId);
        $srch->joinTable('tbl_users', 'INNER JOIN', 'u.user_id = sreport.sreport_user_id', 'u');
        $srch->joinTable('tbl_shops', 'INNER JOIN', 's.shop_id = sreport.sreport_shop_id', 's');
        $srch->joinTable('tbl_shops_lang', 'INNER JOIN', 'sl.shoplang_shop_id = s.shop_id AND sl.shoplang_lang_id = ' . $this->siteLangId, 'sl');
        $srch->joinTable('(' . $result_report_reasons . ')', 'LEFT OUTER JOIN', 'reportreason.reportreason_id = sreport.sreport_reportreason_id', 'reportreason');


        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, -1);
        if (0 < $recordId) {
            $srch->addCondition('sreport_id', '=', $recordId);
        }

        $shopId = FatApp::getPostedData('shop_id', FatUtility::VAR_INT, 0);
        if (0 < $shopId) {
            $srch->addCondition('sreport_shop_id', '=', $shopId);
        }

        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('s.shop_identifier', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('sl.shop_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->addMultipleFields(array('sreport.*', 'COALESCE(shop_name, shop_identifier) as shop_name', 'u.user_name', 'reportreason.reportreason_title'));

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();


        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
    }

    public function getComment()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $this->set('comment', ShopReport::getAttributesById($recordId, 'sreport_message'));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('shopReportsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'shop_name' => Labels::getLabel('LBL_SHOP', $this->siteLangId),
            'user_name' => Labels::getLabel('LBL_REPORTED_BY', $this->siteLangId),
            'reportreason_title' => Labels::getLabel('LBL_REPORT_REASON', $this->siteLangId),
            'sreport_message' => Labels::getLabel('LBL_MESSAGE', $this->siteLangId),
            'sreport_added_on' => Labels::getLabel('LBL_POSTED_ON', $this->siteLangId),
        ];
        CacheHelper::create('shopReportsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'shop_name',
            'user_name',
            'reportreason_title',
            'sreport_message',
            'sreport_added_on',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, [], Common::excludeKeysForSort());
    }
}
