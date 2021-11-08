<?php

class ShopsController extends AdminBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewShops();
    }

    public function index()
    {
        $this->search();
        $this->set('canEdit', $this->objPrivilege->canEditShops($this->admin_id, true));
        $this->set("frmSearch", $this->getSearchForm(false, $this->getFormColumns()));
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_SHOPS', $this->siteLangId));
        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js']);
        $this->_template->render();
    }

    public function search()
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));

        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields) || $sortBy == 'listSerial') {
            $sortBy = current($allowedKeysForSorting);
        }
        $searchForm = $this->getSearchForm(false, $fields);
        $data = FatApp::getPostedData();
        $post = $searchForm->getFormDataFromArray($data);
        $post['sortOrder'] = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $post['sortBy'] = $sortBy;
        $post['page'] = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post['pageSize'] = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $shopSrch = new ShopSearch($this->siteLangId);
        $shopSrch->applySearchConditions($post);
        $this->set("arrListing", $shopSrch->getListingRecords());
        $this->set('pageCount', $shopSrch->pages());
        $this->set('recordCount', $shopSrch->recordCount());
        $this->set('page', $post['page']);
        $this->set('pageSize', $post['pageSize']);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $post['sortOrder']);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditShops($this->admin_id, true));
        if (FatApp::getPostedData('fIsAjax')) {
            LibHelper::exitWithSuccess([
                'listingHtml' => $this->_template->render(false, false, 'shops/search.php', true),
                'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
            ], true);
        }
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditShops();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 == $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $shopObj = new Shop($recordId);
        if (!$shopObj->changeStatus($status)) {
            LibHelper::exitWithError($shopObj->getError(), true);
        }
        Product::updateMinPrices(0, 0, $recordId);
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditShops();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $shopsArr = FatUtility::int(FatApp::getPostedData('shop_ids'));
        if (empty($shopsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $shopObj = new Shop(0);
        var_dump($shopObj->bulkStatusUpdate($shopsArr, $status));
        die('here');
    }

    public function getSearchForm($request = false, $fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_Keyword', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');

        if ($request) {
            $frm->addTextBox(Labels::getLabel('FRM_SELLER_NAME_OR_EMAIL', $this->siteLangId), 'user_name', '', array('id' => 'keyword', 'autocomplete' => 'off', 'placeholder' => Labels::getLabel('LBL_SELLER_NAME_OR_EMAIL', $this->siteLangId)));
            $frm->addHiddenField('', 'user_id');
        }

        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getFormColumns(): array
    {
        $shopsTblHeadingCols = CacheHelper::get('shopsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'user_name' => Labels::getLabel('LBL_OWNER', $this->siteLangId),
            'shop_identifier' => Labels::getLabel('LBL_SHOP_NAME', $this->siteLangId),
            'numOfProducts' => Labels::getLabel('LBL_Products', $this->siteLangId),
            'numOfReports' => Labels::getLabel('LBL_Reports', $this->siteLangId),
            'numOfReviews' => Labels::getLabel('LBL_Reviews', $this->siteLangId),
            'shop_featured' => Labels::getLabel('LBL_Featured', $this->siteLangId),
            'shop_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'shop_created_on' => Labels::getLabel('LBL_Created_on', $this->siteLangId),
            'shop_supplier_display_status' => Labels::getLabel('LBL_Status_by_seller', $this->siteLangId),
            'action' => '',
        ];
        CacheHelper::create('shopsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'user_name',
            'shop_identifier',
            'numOfProducts',
            'numOfReports',
            'numOfReviews',
            'shop_featured',
            'shop_active',
            'shop_created_on',
            'shop_supplier_display_status',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['shop_active', 'numOfReports', 'numOfProducts', 'numOfReviews'], Common::excludeKeysForSort());
    }
}
