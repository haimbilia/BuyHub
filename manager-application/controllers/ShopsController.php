<?php

class ShopsController extends ListingBaseController {

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewShops();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditShops($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditShops();
        }
    }

    /**
     * setModel - This function is used to set related model class and used by its parent class.
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setModel(array $constructorArgs = []): void {
        $this->modelObj = (new ReflectionClass('Shop'))->newInstanceArgs($constructorArgs);
    }

    public function index() {
        $this->search();
        $pageData = PageLanguageData::getAttributesByKey('MANAGE_SHOPS', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('canEdit', $this->objPrivilege->canEditShops($this->admin_id, true));
        $this->set("frmSearch", $this->getSearchForm($this->getFormColumns()));
        $this->set('canViewShopReports', $this->objPrivilege->canViewShopReports(0, true));
        $this->set('canViewSellerProducts', $this->objPrivilege->canViewSellerProducts(0, true));
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
        $searchForm = $this->getSearchForm($fields);
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
        $this->set('canViewShopReports', $this->objPrivilege->canViewShopReports(0, true));
        $this->set('canViewSellerProducts', $this->objPrivilege->canViewSellerProducts(0, true));
        if (FatApp::getPostedData('fIsAjax')) {
            LibHelper::exitWithSuccess([
                'listingHtml' => $this->_template->render(false, false, 'shops/search.php', true),
                'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
                    ], true);
        }
    }

    public function form() {
        $this->checkEditPrivilege();
        $shop_id = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($shop_id);
        $lang = Language::getDropDownList($this->getDefaultFormLangId());
        if (0 < $shop_id) {
            $data = Shop::getAttributesByLangId($this->getDefaultFormLangId(), $shop_id, null, true);
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
        $this->set('languages', $lang);
        $this->set('recordId', $shop_id);
        $this->set('stateId', $data['shop_state_id'] ?? 0);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup() {
        $this->checkEditPrivilege();
        $shop_id = FatApp::getPostedData('shop_id', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($shop_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }
        unset($post['shop_id']);
        $post['shop_country_id'] = Countries::getCountryByCode($post['shop_country_code'], 'country_id');
        $stateData = States::getStateByCountryAndCode($post['shop_country_id'], FatApp::getPostedData('shop_state'));
        $post['shop_state_id'] = $stateData['state_id'];
        $post['shop_phone_dcode'] = FatApp::getPostedData('shop_phone_dcode', FatUtility::VAR_STRING, '');

        $shop = new Shop($shop_id);
        $shop->assignValues($post);
        if (!$shop->save()) {
            LibHelper::exitWithError($shop->getError(), true);
        }

        $recordId = $shop->getMainTableRecordId();
        if (!$shop->updateLangData($this->getDefaultFormLangId(), [
                    'shop_name' => $post['shop_name'],
                    'shop_city' => $post['shop_city'],
                    'shop_contact_person' => $post['shop_contact_person'],
                    'shop_description' => $post['shop_description'],
                    'shop_payment_policy' => $post['shop_payment_policy'],
                    'shop_delivery_policy' => $post['shop_delivery_policy'],
                    'shop_refund_policy' => $post['shop_refund_policy'],
                    'shop_additional_info' => $post['shop_additional_info'],
                    'shop_seller_info' => $post['shop_seller_info'],
                ])) {
            LibHelper::exitWithError($shop->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Brand::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $post['ss_shop_id'] = $shop_id;
        $shopSpecificsObj = new ShopSpecifics($shop_id);
        $shopSpecificsObj->assignValues($post);
        $data = $shopSpecificsObj->getFlds();
        if (!$shopSpecificsObj->addNew(array(), $data)) {
            LibHelper::exitWithError($shopSpecificsObj->getError(), true);
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

    protected function setLangTemplateData(array $constructorArgs = []): void {
        $this->objPrivilege->canEditShops();
        $this->modelObj = (new ReflectionClass('Shop'))->newInstanceArgs([FatApp::getPostedData('shop_id', FatUtility::VAR_INT, 0)]);
        $this->formLangFields = [
            $this->modelObj::tblFld('name'),
            $this->modelObj::tblFld('city'),
            $this->modelObj::tblFld('contact_person'),
            $this->modelObj::tblFld('shop_description'),
            $this->modelObj::tblFld('payment_policy'),
            $this->modelObj::tblFld('delivery_policy'),
            $this->modelObj::tblFld('refund_policy'),
            $this->modelObj::tblFld('additional_info'),
            $this->modelObj::tblFld('seller_info')
        ];
        $this->set('formTitle', Labels::getLabel('LBL_Shop_SETUP', $this->siteLangId));
        $this->checkMediaExist = true;
    }

    protected function isMediaUploaded($shopId) {
        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_SHOP_LOGO, $shopId, 0);
        if (false !== $attachment && 0 < $attachment['afile_id']) {
            return true;
        }
        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_SHOP_BANNER, $shopId, 0);
        if (false !== $attachment && 0 < $attachment['afile_id']) {
            return true;
        }

        return false;
    }

    public function media($shop_id) {
        $this->checkEditPrivilege();
        $shop_id = FatUtility::int($shop_id);
        $shopLogoFrm = $this->getShopLogoForm($shop_id, $this->siteLangId);
        $shopBannerFrm = $this->getShopBannerForm($shop_id, $this->siteLangId);
        $languages = Language::getAllNames();
        if (1 == count($languages)) {
            $langId = array_key_first($languages);
        }
        
        $this->set('recordId', $shop_id);
        $shopDetails = Shop::getAttributesById($shop_id);
        $shopLayoutTemplateId = $shopDetails['shop_ltemplate_id'];
        if ($shopLayoutTemplateId == 0) {
            $shopLayoutTemplateId = 10001;
        }

        $this->set('shopDetails', $shopDetails);
        $this->set('shopLayoutTemplateId', $shopLayoutTemplateId);
        $this->set('logoFrm', $shopLogoFrm);
        $this->set('shopBannerFrm', $shopBannerFrm);
        $this->set('bannerTypeArr', applicationConstants::bannerTypeArr());
        
        $this->_template->render(false, false);
    }

    public function images($shop_id, $file_type, $lang_id = 0, $slide_screen = 0) {
        $languages = Language::getAllNames();
        $slide_screen = FatUtility::int($slide_screen);
        $shop_id = FatUtility::int($shop_id);
        $lang_id = (count($languages) > 1) ? FatUtility::int($lang_id) : array_key_first($languages);

        if ($file_type == 'logo') {
            $logo = AttachedFile::getAttachment(AttachedFile::FILETYPE_SHOP_LOGO, $shop_id, 0, $lang_id, (count($languages) > 1) ? false : true);
            $this->set('image', $logo);
            $this->set('imageFunction', 'shopLogo');
        } else {
            $brandImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_SHOP_BANNER, $shop_id, 0, $lang_id, (count($languages) > 1) ? false : true, $slide_screen);
            $this->set('image', $brandImage);
            $this->set('imageFunction', 'shopBanner');
        }

        $this->set('file_type', $file_type);
        $this->set('shop_id', $shop_id);
        $this->set('canEdit', $this->objPrivilege->canEditShops($this->admin_id, true));
        $this->_template->render(false, false);
    }

    public function uploadMedia() {
        $this->objPrivilege->canEditBrands();
        $post = FatApp::getPostedData();
        if (empty($post)) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Request_Or_File_not_supported', $this->siteLangId), true);
        }
        $shop_id = FatApp::getPostedData('shop_id', FatUtility::VAR_INT, 0);
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        } else {
            $lang_id = array_key_first($languages);
        }
        $file_type = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $slide_screen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 0);
        $aspectRatio = FatApp::getPostedData('ratio_type', FatUtility::VAR_INT, 0);

        if (!$shop_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Please_Select_A_File', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        $fileHandlerObj->deleteFile($file_type, $shop_id, 0, 0, $lang_id, $slide_screen);

        if (!$fileHandlerObj->saveAttachment(
                        $_FILES['cropped_image']['tmp_name'],
                        $file_type,
                        $shop_id,
                        0,
                        $_FILES['cropped_image']['name'],
                        -1,
                        false,
                        $lang_id,
                        $slide_screen,
                        $aspectRatio
                )) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('shopId', $shop_id);
        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('msg', $_FILES['cropped_image']['name'] . Labels::getLabel('MSG_File_Uploaded_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeMedia($recordId, $imageType = '', $afileId = 0) {
        $recordId = FatUtility::int($recordId);
        if (!$recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if ($imageType == 'logo') {
            $fileType = AttachedFile::FILETYPE_SHOP_LOGO;
        } elseif ($imageType == 'image') {
            $fileType = AttachedFile::FILETYPE_SHOP_BANNER;
        }
        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile($fileType, $recordId, $afileId)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getShopLogoForm($shop_id, $land_id) {
        $land_id = FatUtility::int($land_id);
        $frm = new Form('frmShopLogo');
        $frm->addHTML('', Labels::getLabel('LBL_Logo', $this->siteLangId), '<h3>' . Labels::getLabel('LBL_Logo', $this->siteLangId) . '</h3>');
        $frm->addHiddenField('', 'shop_id', $shop_id);
        $bannerTypeArr = applicationConstants::bannerTypeArr();

        if (count($bannerTypeArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_Language', $this->siteLangId), 'lang_id', $bannerTypeArr, '', array(), '');
        } else {
            $land_id = array_key_first($bannerTypeArr);
            $frm->addHiddenField('', 'lang_id', $land_id);
        }
        $ratioArr = AttachedFile::getRatioTypeArray($this->siteLangId);
        $frm->addRadioButtons(Labels::getLabel('LBL_Ratio', $this->siteLangId), 'ratio_type', $ratioArr, AttachedFile::RATIO_TYPE_SQUARE);
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_SHOP_LOGO);
        $frm->addHiddenField('', 'min_width');
        $frm->addHiddenField('', 'min_height');
        $frm->addHTML('', 'shop_logo', '');
        return $frm;
    }

    private function getShopBannerForm($shop_id, $land_id) {
        $land_id = FatUtility::int($land_id);
        $frm = new Form('frmShopBanner');
        $frm->addHTML('', Labels::getLabel('LBL_Banners', $this->siteLangId), '<h3>' . Labels::getLabel('LBL_Banners', $this->siteLangId) . '</h3>');
        $frm->addHiddenField('', 'shop_id', $shop_id);
        $bannerTypeArr = applicationConstants::bannerTypeArr();
        if (count($bannerTypeArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_Language', $this->siteLangId), 'lang_id', $bannerTypeArr, '', array(), '');
        } else {
            $land_id = array_key_first($bannerTypeArr);
            $frm->addHiddenField('', 'lang_id', $land_id);
        }

        $screenArr = applicationConstants::getDisplaysArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel("LBL_Display_For", $this->siteLangId), 'slide_screen', $screenArr, '', array(), '');
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_SHOP_BANNER);
        $frm->addHiddenField('', 'min_width');
        $frm->addHiddenField('', 'min_height');
        $frm->addHTML('', 'shop_banner', '');
        return $frm;
    }

    public function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_Keyword', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'shop_name');
        }
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        $frm->addHiddenField('', 'shop_id');
        $frm->addSelectBox(Labels::getLabel('LBL_Featured', $this->siteLangId), 'shop_featured', array('-1' => Labels::getLabel('LBL_Does_Not_Matter', $this->siteLangId)) + applicationConstants::getYesNoArr($this->siteLangId), -1, array(), '');
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'shop_active', array('-1' => 'Does not Matter') + applicationConstants::getActiveInactiveArr($this->siteLangId), -1, array(), '');
        $frm->addSelectBox(Labels::getLabel('LBL_Shop_Status_By_Seller', $this->siteLangId), 'shop_supplier_display_status', array('-1' => Labels::getLabel('LBL_Does_Not_Matter', $this->siteLangId)) + applicationConstants::getOnOffArr($this->siteLangId), -1, array(), '');
        $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->siteLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->siteLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        return $frm;
    }

    protected function getFormColumns(): array {
        $shopsTblHeadingCols = CacheHelper::get('shopsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'shop_name' => Labels::getLabel('LBL_SHOP_NAME', $this->siteLangId),
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
        $action = ($shop_id > 0) ? Labels::getLabel('FRM_Add_New', $this->siteLangId) : Labels::getLabel('FRM_UPDATE', $this->siteLangId);
        $frm->addHiddenField('', 'shop_id', $shop_id);
        $frm->addRequiredField(Labels::getLabel('LBL_Shop_Name', $this->siteLangId), 'shop_name');
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Shop_SEO_Friendly_URL', $this->siteLangId), 'urlrewrite_custom');
        $fld->requirements()->setRequired();
        $frm->addHiddenField('', 'shop_phone_dcode');
        $phnFld = $frm->addTextBox(Labels::getLabel('LBL_Phone', $this->siteLangId), 'shop_phone', '', array('class' => 'phoneJs ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
        $phnFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($this->siteLangId, true, 'country_code');
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_Country', $this->siteLangId), 'shop_country_code', $countriesArr, FatApp::getConfig('CONF_COUNTRY', FatUtility::VAR_INT, 223), [], Labels::getLabel('LBL_Select', $this->siteLangId));
        $fld->requirement->setRequired(true);

        $frm->addSelectBox(Labels::getLabel('LBL_State', $this->siteLangId), 'shop_state', array(), '', [], Labels::getLabel('LBL_Select', $this->siteLangId))->requirement->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('LBL_Postal_Code', $this->siteLangId), 'shop_postalcode');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);

        $fld = $frm->addTextBox(Labels::getLabel('LBL_ORDER_CANCELLATION_AGE', $this->siteLangId), 'shop_cancellation_age');
        $fld->requirements()->setInt();
        $fld->requirements()->setPositive();

        $fld = $frm->addTextBox(Labels::getLabel('LBL_ORDER_RETURN_AGE', $this->siteLangId), 'shop_return_age');
        $fld->requirements()->setInt();
        $fld->requirements()->setPositive();

        $frm->addCheckBox(Labels::getLabel('LBL_Featured', $this->siteLangId), 'shop_featured', 1, array(), false, 0);

        $fld = $frm->addTextBox(Labels::getLabel('LBL_Minimum_Wallet_Balance', $this->siteLangId), 'shop_cod_min_wallet_balance');
        $fld->requirements()->setFloat();
        $fld->htmlAfterField = "<br><small>" . Labels::getLabel("LBL_Seller_needs_to_maintain_to_accept_COD_orders._Default_is_-1", $this->siteLangId) . "</small>";
        $fulFillmentArr = Shipping::getFulFillmentArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_FULFILLMENT_METHOD', $this->siteLangId), 'shop_fulfillment_type', $fulFillmentArr, applicationConstants::NO, [], Labels::getLabel('LBL_Select', $this->siteLangId));
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'shop_active', $activeInactiveArr, '', array(), '');
        $this->appendLangFormFields($frm, $this->siteLangId);
        $frm->addHiddenField('', 'shop_lat');
        $frm->addHiddenField('', 'shop_lng');
        $frm->addHtml('', 'space', '');
        $frm->addHtml('', 'space', '');
        return $frm;
    }

    protected function getLangForm($shop_id = 0, $lang_id = 0) {
        $frm = new Form('frmShopLang', array('id' => 'frmShopLang'));
        $frm->addHiddenField('', 'shop_id', $shop_id);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList($this->getDefaultFormLangId()), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_Shop_Name', $lang_id), 'shop_name');
        $this->appendLangFormFields($frm);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->siteLangId));
        return $frm;
    }

    private function appendLangFormFields(&$frm, $lang_id = 0) {
        $frm->addTextBox(Labels::getLabel('LBL_Shop_City', $lang_id), 'shop_city');
        $frm->addTextBox(Labels::getLabel('LBL_Contact_person', $lang_id), 'shop_contact_person');
        $frm->addTextarea(Labels::getLabel('LBL_Description', $lang_id), 'shop_description');
        $frm->addTextarea(Labels::getLabel('LBL_Payment_Policy', $lang_id), 'shop_payment_policy');
        $frm->addTextarea(Labels::getLabel('LBL_Delivery_Policy', $lang_id), 'shop_delivery_policy');
        $frm->addTextarea(Labels::getLabel('LBL_Refund_Policy', $lang_id), 'shop_refund_policy');
        $frm->addTextarea(Labels::getLabel('LBL_Additional_Information', $lang_id), 'shop_additional_info');
        $frm->addTextarea(Labels::getLabel('LBL_Seller_Information', $lang_id), 'shop_seller_info');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $lang_id), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    protected function getDefaultColumns(): array {
        return [
            'select_all',
            'listSerial',
            'shop_name',
            'numOfProducts',
            'numOfReports',
            'numOfReviews',
            'shop_featured',
            'shop_created_on',
            'shop_supplier_display_status',
            'shop_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['shop_active', 'numOfReports', 'numOfProducts', 'numOfReviews'], Common::excludeKeysForSort());
    }

}
