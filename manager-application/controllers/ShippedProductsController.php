<?php

class ShippedProductsController extends ListingBaseController
{

    protected string $modelClass = 'Product';
    protected $pageKey = 'MANAGE_SHIPPED_PRODUCTS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewShippedProducts();
    }

    public function index()
    {
        $this->setModel([0]);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('canEdit', $this->objPrivilege->canEditShippedProducts($this->admin_id, true));
        $this->set("frmSearch", $this->getSearchForm($this->getFormColumns()));
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($this->getFormColumns(), $this->modelObj), [
            'newRecordBtn' => false
        ]);
        $this->set('actionItemsData', $actionItemsData);

        $this->_template->addCss(['css/select2.min.css']);
        $this->_template->addJs([
            'js/select2.js',
            'shipped-products/page-js/index.js'
        ]);
        $this->getListingData();
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME', $this->siteLangId));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'shipped-products/search.php', true),
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
        $post = $searchForm->getFormDataFromArray($data, ['user_id']);

        $srch = new ShippedProducts($this->siteLangId);
        $srch->joinShipProfileProd();
        $srch->joinShippingProfile();
        $srch->addProductByAdminCondition();
        $srch->addProductDeletedCondition();
        $srch->addProductAdminShipCondition();
        $srch->addPhyProductCheckCondition(); 

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $srch->addCondition('tp_l.product_name', 'like', '%' . $post['keyword'] . '%');
        }
        if (!empty($post['user_id']) && $post['user_id'] > 0) {
            $srch->joinSelProdTable();
            $srch->joinUserTable();
            $srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'u.user_id = uc.credential_user_id', 'uc');
            $srch->addCondition('u.user_id', '=', $post['user_id']);
        }

        $shippingProfile = FatApp::getPostedData('shipping_profile', FatUtility::VAR_INT, 0);
        if (0 < $shippingProfile) {
            $srch->addCondition('sppro.shippro_shipprofile_id', '=', $shippingProfile);
        }
        $srch->addGroupBy('sppro.shippro_product_id');
        $this->setRecordCount(clone $srch, $pageSize, $page, $post,true);
        $srch->doNotCalculateRecords(); 
        $srch->addMultipleFields(array('sppro.shippro_shipprofile_id, sppro.shippro_product_id, ifnull(tp_l.product_name, tp.product_identifier) as product_name, COALESCE(spprof_l.shipprofile_name, spprof.shipprofile_identifier) as shipprofile_name, tp.product_added_by_admin_id'));
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);

        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        /* Get Catelog shipped by Admin/seller */
        if (!empty($records)) {
            $prodIdArr = array_column($records, 'shippro_product_id');
            foreach ($prodIdArr as $kay => $prodId) {
                $allProd = new ShippedProducts();
                $allProd->joinSelProdTable();
                $allProd->joinUserTable();
                $allProd->addProductDeletedCondition();
                $allProd->addPhyProductCheckCondition();
                $allProd->addCondition('tp.product_id', '=', $prodId);
                $allProd->addMultipleFields(array('u.user_name'));
                $allProd->addGroupBy('u.user_id');
                $res = $allProd->getResultSet();
                $allRecords = FatApp::getDb()->fetchAll($res);
                $totalProductsCount = (count($allRecords) > 0 && !empty($allRecords[0]['user_name'])) ? count($allRecords) : 0;

                $selProd = clone $allProd;
                $selProd->joinShippedBySeller();
                $resu = $selProd->getResultSet();
                $results = FatApp::getDb()->fetchAll($resu);
                $selProdCount = (count($results) > 0) ? count($results) : 0;

                $records[$kay]['total_seller_ship'] = $selProdCount;
                $records[$kay]['total_admin_seller_ship'] = $totalProductsCount - $selProdCount;
                if (count(array_filter($allRecords)) != count($allRecords)) {
                    $records[$kay]['total_admin_seller_ship'] = 0;
                }
            }
        }

        $this->set("arrListing", $records); 
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditBrands($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditShippedProducts();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $profileId = FatApp::getPostedData('profileId', FatUtility::VAR_INT, 0);
        if (1 > $recordId || 1 > $profileId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frm = $this->getForm();
        $frm->fill(['productId' => $recordId, 'shipping_profile' => $profileId]);
        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('profileId', $profileId);
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_UPDATE_SHIPPING_PROFILE', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditShippedProducts();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        if (1 > $post['productId']) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (isset($post['shipping_profile']) && $post['shipping_profile'] > 0) {
            $shipProProdData = array(
                'shippro_shipprofile_id' => $post['shipping_profile'],
                'shippro_product_id' => $post['productId'],
                'shippro_user_id' => 0
            );
            $spObj = new ShippingProfileProduct();
            if (!$spObj->addProduct($shipProProdData)) {
                LibHelper::exitWithError($spObj->getError(), true);
            }
        }
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getRows()
    {
        $this->viewSellerList(false);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function viewSellerList($render = true)
    {
        $this->objPrivilege->canViewShippedProducts();
        $productId = FatApp::getPostedData('productId', FatUtility::VAR_INT);
        $adminShip = FatApp::getPostedData('adminShip', FatUtility::VAR_INT, 0);
        if (1 > $productId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $post = FatApp::getPostedData();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        /* Get all Products */
        $srch = new ShippedProducts($this->siteLangId);
        $srch->joinShipProfileProd();
        $srch->joinShippingProfile();
        $srch->joinSelProdTable();
        $srch->joinSellerShop();
        $srch->joinUserTable();
        $srch->addProductDeletedCondition();
        $srch->addPhyProductCheckCondition();
        $srch->addCondition('tp.product_id', '=', $productId);
        $srch->addMultipleFields(array('u.user_name', 'u.user_id', 'shop.shop_identifier', 'shop.shop_id'));
        $srch->joinTable(Product::DB_PRODUCT_SHIPPED_BY_SELLER, 'LEFT OUTER JOIN', 'psbs.psbs_product_id = tp.product_id and psbs.psbs_user_id = sp.selprod_user_id', 'psbs');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addGroupBy('u.user_id');
        if (applicationConstants::YES == $adminShip) {
            $srch->addCondition('psbs.psbs_product_id', 'is', 'mysql_func_NULL', 'AND', true);
        } else {
            $srch->addCondition('psbs.psbs_product_id', 'is not', 'mysql_func_NULL', 'AND', true);
        }
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $records);
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('adminShip', $adminShip);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('postedData', $post);
        if ($render != false) {
            $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
        }
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_Keyword', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'shop_name');
        }
        $frm->addSelectBox(
            Labels::getLabel('FRM_SELLER_NAME_OR_EMAIL', $this->siteLangId),
            'user_id',
            [],
            '',
            [
                'class' => 'form-control',
                'id' => 'searchFrmUserIdJs',
                'placeholder' => Labels::getLabel('FRM_SELLER_NAME_OR_EMAIL', $this->siteLangId)
            ]
        );

        $shipProfileArr = ShippingProfile::getProfileArr($this->siteLangId, 0, true, true);
        $frm->addSelectBox(Labels::getLabel('FRM_SHIPPING_PROFILE', $this->siteLangId), 'shipping_profile', $shipProfileArr, '', array(), Labels::getLabel('FRM_DOES_NOT_MATTER', $this->siteLangId));
        $frm->addHiddenField('', 'total_record_count'); 
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-outline-brand');
        return $frm;
    }

    private function getFormColumns(): array
    {
        $shopsTblHeadingCols = CacheHelper::get('shippedProductHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols, true);
        }

        $arr = [
          /*   'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'product_name' => Labels::getLabel('LBL_PRODUCT_NAME', $this->siteLangId),
            'total_seller_ship' => Labels::getLabel('LBL_SHIPPED_BY_SELLER', $this->siteLangId),
            'total_admin_seller_ship' => Labels::getLabel('LBL_SHIPPED_BY_ADMIN', $this->siteLangId),
            'shipprofile_name' => Labels::getLabel('LBL_SHIPPING_PROFILE', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('shippedProductHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'product_name',
            'total_seller_ship',
            'total_admin_seller_ship',
            'shipprofile_name',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['total_seller_ship', 'total_admin_seller_ship'], Common::excludeKeysForSort());
    }

    private function getForm()
    {
        $frm = new Form('productsShippingForm');
        $frm->addHiddenField('', 'productId', 0);
        $shipProfileArr = ShippingProfile::getProfileArr($this->siteLangId, 0, true, true);
        $frm->addSelectBox(Labels::getLabel('FRM_SHIPPING_PROFILE', $this->siteLangId), 'shipping_profile', $shipProfileArr, '', [], Labels::getLabel('LBL_Select', $this->siteLangId))->requirements()->setRequired();
        return $frm;
    }
}
