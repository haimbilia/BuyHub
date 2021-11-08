<?php

class ShopsController extends AdminBaseController {

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewShops();
    }

    public function index() {
        $this->search();
        $this->set('canEdit', $this->objPrivilege->canEditShops($this->admin_id, true));
        $this->set("frmSearch", $this->getSearchForm(false, $this->getFormColumns()));
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_SHOPS', $this->siteLangId));
        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js']);
        $this->_template->render();
    }

    public function search() {
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

        $shopSrch = new AdminShopSearch($this->siteLangId);
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

    public function form($shop_id = 0) {
        $this->objPrivilege->canEditShops();
        $shop_id = FatUtility::int($shop_id);
        $frm = $this->getForm($shop_id);
        if (0 < $shop_id) {
            $data = Shop::getAttributesById($shop_id, null, true);
            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }

            $data['urlrewrite_custom'] = AdminShopSearch::getUrlRewrite('shops/view/' . $shop_id);
            $data['shop_country_code'] = Countries::getCountryById($data['shop_country_id'], $this->siteLangId, 'country_code');
            $stateObj = new States();
            $statesArr = $stateObj->getStatesByCountryId($data['shop_country_id'], $this->siteLangId, true, 'state_code');
            $frm->getField('shop_state')->options = $statesArr;
            $stateCode = States::getAttributesById($data['shop_state_id'], 'state_code');
            $data['shop_state'] = $stateCode;
            $frm->fill($data);
        }
        $this->set('languages', Language::getAllNames());
        $this->set('shop_id', $shop_id);
        $this->set('stateId', $data['shop_state_id'] ?? 0);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }
    
    public function setup() {
        $this->objPrivilege->canEditShops(); 
        $frm = $this->getForm(); 
        $post = FatApp::getPostedData();
        $stateCode = $post['shop_state'];
        $post = $frm->getFormDataFromArray($post);

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $shop_id = FatUtility::int($post['shop_id']);
        unset($post['shop_id']);
        $post['shop_country_id'] = Countries::getCountryByCode($post['shop_country_code'], 'country_id');
        $stateData = States::getStateByCountryAndCode($post['shop_country_id'], $stateCode);
        $post['shop_state_id'] = $stateData['state_id'];

        $post['shop_phone_dcode'] = FatApp::getPostedData('shop_phone_dcode', FatUtility::VAR_STRING, '');

        $shop = new Shop($shop_id);
        $shop->assignValues($post);

        if (!$shop->save()) {
            Message::addErrorMessage($shop->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $post['ss_shop_id'] = $shop_id;

        $shopSpecificsObj = new ShopSpecifics($shop_id);
        $shopSpecificsObj->assignValues($post);
        $data = $shopSpecificsObj->getFlds();
        if (!$shopSpecificsObj->addNew(array(), $data)) {
            Message::addErrorMessage($shopSpecificsObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        /* url data[ */
        $shopOriginalUrl = Shop::SHOP_TOP_PRODUCTS_ORGINAL_URL . $shop_id;

        if ($post['urlrewrite_custom'] == '') {
            FatApp::getDb()->deleteRecords(UrlRewrite::DB_TBL, array('smt' => 'urlrewrite_original = ?', 'vals' => array($shopOriginalUrl)));
        } else {
            $shop->rewriteUrlShop($post['urlrewrite_custom']);
            $shop->rewriteUrlReviews($post['urlrewrite_custom']);
            $shop->rewriteUrlTopProducts($post['urlrewrite_custom']);
            $shop->rewriteUrlContact($post['urlrewrite_custom']);
            $shop->rewriteUrlpolicy($post['urlrewrite_custom']);
        }
        /* ] */
        $newTabLangId = 0;
        if ($shop_id > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Shop::getAttributesByLangId($langId, $shop_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $shop_id = $shop->getMainTableRecordId();
            $newTabLangId = $this->siteLangId;
        }

        Product::updateMinPrices(0, $shop_id);
        $this->set('msg', Labels::getLabel("MSG_Setup_Successful", $this->siteLangId));
        $this->set('shopId', $shop_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateStatus() {
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
            Message::addErrorMessage($shopObj->getError());
            LibHelper::exitWithError(Message::getHtml());
        }
        Product::updateMinPrices(0, 0, $recordId);
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses() {
        $this->objPrivilege->canEditShops();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $shopsArr = FatUtility::int(FatApp::getPostedData('shop_ids'));
        if (empty($shopsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $shopObj = new Shop(0);
        if ($shopObj->bulkStatusUpdate($shopsArr, $status) == false) {
            LibHelper::exitWithError(Labels::getLabel($shopObj->getError(), $this->adminLangId), true);
        }
        Product::updateMinPrices();
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getSearchForm($request = false, $fields = []) {
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

    private function getFormColumns(): array {
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

    private function getForm($shop_id = 0) {
        $shop_id = FatUtility::int($shop_id);
        $frm = new Form('frmShop');
        $frm->addHiddenField('', 'shop_id', $shop_id);
        $frm->addRequiredField(Labels::getLabel('LBL_Shop_Identifier', $this->siteLangId), 'shop_identifier');
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Shop_SEO_Friendly_URL', $this->siteLangId), 'urlrewrite_custom');
        $fld->requirements()->setRequired();
        $frm->addHiddenField('', 'shop_phone_dcode');
        $phnFld = $frm->addTextBox(Labels::getLabel('LBL_Phone', $this->siteLangId), 'shop_phone', '', array('class' => 'phone-js ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
        $phnFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($this->siteLangId, true, 'country_code');
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_Country', $this->siteLangId), 'shop_country_code', $countriesArr, FatApp::getConfig('CONF_COUNTRY', FatUtility::VAR_INT, 223), [], Labels::getLabel('LBL_Select', $this->siteLangId));
        $fld->requirement->setRequired(true);

        $frm->addSelectBox(Labels::getLabel('LBL_State', $this->siteLangId), 'shop_state', array(), '', [], Labels::getLabel('LBL_Select', $this->siteLangId))->requirement->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('LBL_Postal_Code', $this->siteLangId), 'shop_postalcode');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'shop_active', $activeInactiveArr, '', array(), '');
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Minimum_Wallet_Balance', $this->siteLangId), 'shop_cod_min_wallet_balance');
        $fld->requirements()->setFloat();
        $fld->htmlAfterField = "<br><small>" . Labels::getLabel("LBL_Seller_needs_to_maintain_to_accept_COD_orders._Default_is_-1", $this->siteLangId) . "</small>";
        $frm->addCheckBox(Labels::getLabel('LBL_Featured', $this->siteLangId), 'shop_featured', 1, array(), false, 0);

        $fulFillmentArr = Shipping::getFulFillmentArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_FULFILLMENT_METHOD', $this->siteLangId), 'shop_fulfillment_type', $fulFillmentArr, applicationConstants::NO, [], Labels::getLabel('LBL_Select', $this->siteLangId));

        $fld = $frm->addTextBox(Labels::getLabel('LBL_ORDER_RETURN_AGE', $this->siteLangId), 'shop_return_age');
        $fld->requirements()->setInt();
        $fld->requirements()->setPositive();

        $fld = $frm->addTextBox(Labels::getLabel('LBL_ORDER_CANCELLATION_AGE', $this->siteLangId), 'shop_cancellation_age');
        $fld->requirements()->setInt();
        $fld->requirements()->setPositive();
        $frm->addHiddenField('', 'shop_lat');
        $frm->addHiddenField('', 'shop_lng');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->siteLangId));
        return $frm;
    }

    private function getDefaultColumns(): array {
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

    private function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['shop_active', 'numOfReports', 'numOfProducts', 'numOfReviews'], Common::excludeKeysForSort());
    }

}
