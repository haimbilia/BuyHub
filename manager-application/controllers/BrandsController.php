<?php

class BrandsController extends AdminBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBrands();
        $this->rewriteUrl = Brand::REWRITE_URL_PREFIX;
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm(false, $fields);

        $this->set('canEdit', $this->objPrivilege->canEditBrands($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_BRANDS', $this->adminLangId));
        $this->getListingData();

        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs('js/cropper.js');
        $this->_template->addJs('js/cropper-main.js');
        $this->_template->render();
    }

    private function getSearchForm($request = false, $fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword', '', array('class' => 'search-input'));

        if ($request) {
            $frm->addTextBox(Labels::getLabel('LBL_Seller_Name_Or_Email', $this->adminLangId), 'user_name', '', array('id' => 'keyword', 'autocomplete' => 'off'));
            $frm->addHiddenField('', 'user_id');
        }

        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $frm->addHtml('', 'btn_clear', '<button name="btn_clear" class="btn btn-outline-brand" onclick="clearSearch();">' . Labels::getLabel('LBL_CLEAR', $this->adminLangId) . '</button>');
        return $frm;
    }
    private function getListingData()
    {
        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }
        
        $data = FatApp::getPostedData();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $searchForm = $this->getSearchForm(false, $fields);
        
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $prodBrandObj = new Brand();
        $srch = $prodBrandObj->getSearchObject($this->adminLangId, true, false, false);
        $srch->addFld('b.*, brand_id as listSerial');

        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('b.brand_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('b_l.brand_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $srch->addMultipleFields(array("b_l.brand_name"));
        $srch->addCondition('brand_status', '=', Brand::BRAND_REQUEST_APPROVED);
        if (!empty($post['brand_id'])) {
            $srch->addCondition('b.brand_id', '=', $post['brand_id']);
        }
        $srch->addOrder($sortBy, $sortOrder);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditStates($this->admin_id, true));
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'brands/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function form()
    {
        $this->objPrivilege->canEditBrands();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $data = Brand::getAttributesById($recordId, array('brand_id', 'brand_identifier', 'brand_active', 'brand_featured'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            /* url data[ */
            $urlSrch = UrlRewrite::getSearchObject();
            $urlSrch->doNotCalculateRecords();
            $urlSrch->setPageSize(1);
            $urlSrch->addFld('urlrewrite_custom');
            $urlSrch->addCondition('urlrewrite_original', '=', $this->rewriteUrl . $recordId);
            $rs = $urlSrch->getResultSet();
            $urlRow = FatApp::getDb()->fetch($rs);
            if ($urlRow) {
                $data['urlrewrite_custom'] = $urlRow['urlrewrite_custom'];
            }
            /* ] */
            $frm->fill($data);
        }
        
        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditBrands();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['brand_id'];
        unset($post['brand_id']);
        $data = $post;

        if ($recordId == 0) {
            $record = Brand::getAttributesByIdentifier($post['brand_identifier']);
            if (!empty($record) && $record['brand_deleted'] == applicationConstants::YES) {
                $recordId = $record['brand_id'];
                $data['brand_deleted'] = applicationConstants::NO;
            }
        }

        $data['brand_status'] = Brand::BRAND_REQUEST_APPROVED;

        $brand = new Brand($recordId);
        $brand->assignValues($data);

        if (!$brand->save()) {
            LibHelper::exitWithError($brand->getError(), true);
        }

        $recordId = $brand->getMainTableRecordId();

        /* url data[ */
        $brandOriginalUrl = $this->rewriteUrl . $recordId;
        if ($post['urlrewrite_custom'] == '') {
            UrlRewrite::remove($brandOriginalUrl);
        } else {
            $brand->rewriteUrl($post['urlrewrite_custom']);
        }
        /* ] */

        $newTabLangId = 0;
        if ($recordId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!Brand::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $brand->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        if ($newTabLangId == 0 && !$this->isMediaUploaded($recordId)) {
            $this->set('openMediaForm', true);
        }

        Product::updateMinPrices(0, 0, $recordId);
        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($recordId = 0)
    {
        $this->objPrivilege->canEditBrands();
        $recordId = FatUtility::int($recordId);

        $action = Labels::getLabel('LBL_Add_New', $this->adminLangId);
        if ($recordId > 0) {
            $action = Labels::getLabel('LBL_Update', $this->adminLangId);
        }

        $frm = new Form('frmProdBrand', array('id' => 'frmProdBrand'));
        $frm->addHiddenField('', 'brand_id', 0);
        $frm->addRequiredField(Labels::getLabel('LBL_Brand_Identifier', $this->adminLangId), 'brand_identifier');
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Brand_SEO_Friendly_URL', $this->adminLangId), 'urlrewrite_custom');
        $fld->requirements()->setRequired();
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->adminLangId);

        $frm->addSelectBox(Labels::getLabel('LBL_Brand_Status', $this->adminLangId), 'brand_active', $activeInactiveArr, '', array(), '');

        /* $frm->addCheckBox(Labels::getLabel('LBL_Featured',$this->adminLangId), 'brand_featured', 1,array(),false,0); */
        $fld = $frm->addHiddenField('', 'brand_logo', '', array('id' => 'brand_logo'));
        // $frm->addSubmitButton('', 'btn_submit', $action);
        return $frm;
    }

    public function langForm($autoFillLangData = 0)
    {
        $this->objPrivilege->canEditBrands();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1));

        if (1 > $recordId || 1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($recordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Brand::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = Brand::getAttributesByLangId($langId, $recordId);
        }
        
        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditBrands();
        $post = FatApp::getPostedData();

        $recordId = $post['brand_id'];
		
		$languages = Language::getAllNames();
		if(count($languages) > 1){
			 $lang_id = $post['lang_id'];
		} else  {
			$lang_id = array_key_first($languages); 
			$post['lang_id'] = $lang_id;
		}
       
		if ($recordId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($recordId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        /* Check if same brand name already exists [ */
        $tblRecord = new TableRecord(Brand::DB_TBL_LANG);
        if ($tblRecord->loadFromDb(array('smt' => 'brand_name = ?', 'vals' => array($post['brand_name'])))) {
            $brandRow = $tblRecord->getFlds();
            if ($brandRow['brandlang_brand_id'] != $recordId) {
                LibHelper::exitWithError(Labels::getLabel('LBL_Brand_name_already_exists', $this->adminLangId), true);
            }
        }
        /* ] */

        unset($post['brand_id']);
        unset($post['lang_id']);
        $data = array(
            'brandlang_lang_id' => $lang_id,
            'brandlang_brand_id' => $recordId,
            'brand_name' => $post['brand_name'],
            //'brand_short_description' => $post['brand_short_description'],
        );
        $prodBrandObj = new Brand($recordId);
        if (!$prodBrandObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($prodBrandObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Brand::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Brand::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        if ($newTabLangId == 0 && !$this->isMediaUploaded($recordId)) {
            $this->set('openMediaForm', true);
        }
        $this->set('msg', Labels::getLabel('MSG_Brand_Setup_Successful', $this->adminLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getLangForm($recordId = 0, $lang_id = 0)
    {
        $frm = new Form('frmProdBrandLang', array('id' => 'frmProdBrandLang'));
        $frm->addHiddenField('', 'brand_id', $recordId);
		
		$languages = Language::getAllNames();
		if(count($languages) > 1){
			  $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->adminLangId), 'lang_id', $languages, $lang_id, array(), '');
		} else  {
			$lang_id = array_key_first($languages); 
			$frm->addHiddenField('', 'lang_id', $lang_id);
		}
		
        $frm->addRequiredField(Labels::getLabel('LBL_Brand_Name', $this->adminLangId), 'brand_name');
        
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->adminLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Update', $this->adminLangId));
        return $frm;
    }

    public function requestForm($brand_id = 0)
    {
        $this->objPrivilege->canEditBrandRequests();

        $brand_id = FatUtility::int($brand_id);
        $prodBrandFrm = $this->getRequestForm($brand_id);

        if (0 < $brand_id) {
            $data = Brand::getAttributesById($brand_id, array('brand_id', 'brand_identifier', 'brand_active', 'brand_featured', 'brand_status', 'brand_seller_id'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            /* url data[ */
            $urlSrch = UrlRewrite::getSearchObject();
            $urlSrch->doNotCalculateRecords();
            $urlSrch->setPageSize(1);
            $urlSrch->addFld('urlrewrite_custom');
            $urlSrch->addCondition('urlrewrite_original', '=', $this->rewriteUrl . $brand_id);
            $rs = $urlSrch->getResultSet();
            $urlRow = FatApp::getDb()->fetch($rs);
            $data['urlrewrite_custom'] = '';
            if ($urlRow) {
                $data['urlrewrite_custom'] = $urlRow['urlrewrite_custom'];
            }

            if ($data['urlrewrite_custom'] == '') {
                $data['urlrewrite_custom'] = CommonHelper::seoUrl($data['brand_identifier']);
            }
            /* ] */
            $prodBrandFrm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('brand_id', $brand_id);
        $this->set('prodBrandFrm', $prodBrandFrm);
        $this->_template->render(false, false);
    }

    public function setupRequest()
    {
        $this->objPrivilege->canEditBrandRequests();

        $frm = $this->getRequestForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $brand_id = $post['brand_id'];
        if ($post['brand_status'] == applicationConstants::YES) {
            $post['brand_active'] = applicationConstants::ACTIVE;
        }

        if ($post['brand_status'] != Brand::BRAND_REQUEST_PENDING) {
            $post['brand_status_updated_on'] = date('Y-m-d H:i:s');
        }

        unset($post['brand_id']);

        $record = new Brand($brand_id);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $brand_id = $record->getMainTableRecordId();

        /* url data[ */
        $shopOriginalUrl = $this->rewriteUrl . $brand_id;
        $shopCustomUrl = CommonHelper::seoUrl($post['urlrewrite_custom']);
        if ($post['urlrewrite_custom'] == '') {
            FatApp::getDb()->deleteRecords(UrlRewrite::DB_TBL, array('smt' => 'urlrewrite_original = ?', 'vals' => array($shopOriginalUrl)));
        } else {
            $urlSrch = UrlRewrite::getSearchObject();
            $urlSrch->doNotCalculateRecords();
            $urlSrch->setPageSize(1);
            $urlSrch->addFld('urlrewrite_custom');
            $urlSrch->addCondition('urlrewrite_original', '=', $shopOriginalUrl);
            $rs = $urlSrch->getResultSet();
            $urlRow = FatApp::getDb()->fetch($rs);
            $recordObj = new TableRecord(UrlRewrite::DB_TBL);
            if ($urlRow) {
                $recordObj->assignValues(array('urlrewrite_custom' => $shopCustomUrl));
                if (!$recordObj->update(array('smt' => 'urlrewrite_original = ?', 'vals' => array($shopOriginalUrl)))) {
                    LibHelper::exitWithError(Labels::getLabel("Please_try_different_url,_URL_already_used_for_another_record.", $this->adminLangId), true);
                }
                //$shopDetails['urlrewrite_custom'] = $urlRow['urlrewrite_custom'];
            } else {
                $recordObj->assignValues(array('urlrewrite_original' => $shopOriginalUrl, 'urlrewrite_custom' => $shopCustomUrl));
                if (!$recordObj->addNew()) {
                    LibHelper::exitWithError(Labels::getLabel("Please_try_different_url,_URL_already_used_for_another_record.", $this->adminLangId), true);
                }
            }
        }
        $brandData = Brand::getAttributesById($brand_id);
        $brandLangData = Brand::getAttributesByLangId($this->adminLangId, $brand_id);
        $brandData['brand_name'] = $brandLangData['brand_name'];
        /* ] */
        $email = new EmailHandler();
        if ($post['brand_status'] != Brand::BRAND_REQUEST_PENDING) {
            if (!$email->sendBrandRequestStatusChangeNotification($this->adminLangId, $brandData)) {
                LibHelper::exitWithError(Labels::getLabel('LBL_Email_Could_Not_Be_Sent', $this->adminLangId), true);
            }
        }

        $newTabLangId = 0;
        if ($brand_id > 0) {
            $brandId = $brand_id;
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Brand::getAttributesByLangId($langId, $brand_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $brandId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        if ($newTabLangId == 0 && !$this->isMediaUploaded($brand_id)) {
            $this->set('openMediaForm', true);
        }

        Product::updateMinPrices(0, 0, $brandId);
        $this->set('msg', Labels::getLabel('MSG_Brand_Setup_Successful', $this->adminLangId));
        $this->set('brandId', $brandId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function media($recordId = 0, $langId = 0, $slide_screen = 0)
    {
        $this->objPrivilege->canEditBrands();
        $recordId = FatUtility::int($recordId);
        $logoFrm = $this->getBrandLogoForm($recordId);
        $data['lang_id'] = $langId;
        $data['ratio_type'] = AttachedFile::RATIO_TYPE_SQUARE;
        if (0 < $recordId) {
            $brandLogo = current(AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BRAND_LOGO, $recordId, 0, $langId, false));
            if (is_array($brandLogo) && count($brandLogo)) {
                $data['ratio_type'] = $brandLogo['afile_aspect_ratio'];
            }
        }
        $logoFrm->fill($data);

        $data['slide_screen'] = 1 > $slide_screen ? applicationConstants::SCREEN_DESKTOP : $slide_screen;
        $imageFrm = $this->getBrandImageForm($recordId);
        $imageFrm->fill($data);

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('logoFrm', $logoFrm);
        $this->set('imageFrm', $imageFrm);
        $this->_template->render(false, false);
    }

    public function images($brand_id, $file_type, $lang_id = 0, $slide_screen = 0)
    {
		
		$languages = Language::getAllNames();
		if(count($languages) > 1){
			$lang_id = FatUtility::int($lang_id);
		} else  {
			$lang_id = array_key_first($languages); 
		}
		
		$slide_screen = FatUtility::int($slide_screen);
        $brand_id = FatUtility::int($brand_id);
        if ($file_type == 'logo') {
            $brandLogos = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BRAND_LOGO, $brand_id, 0, $lang_id, (count($languages) > 1) ? false : true);
			$this->set('images', $brandLogos);
            $this->set('imageFunction', 'brandReal');
        } else {
            $brandImages = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BRAND_IMAGE, $brand_id, 0, $lang_id, (count($languages) > 1) ? false : true, $slide_screen);
            $this->set('images', $brandImages);
            $this->set('imageFunction', 'brandImage');
        }

        $this->set('file_type', $file_type);
        $this->set('brand_id', $brand_id);
        $this->set('languages', $languages);
        $this->_template->render(false, false);
    }

    public function requestMedia($brand_id = 0)
    {
        $this->objPrivilege->canEditBrands();
        $brand_id = FatUtility::int($brand_id);
        $brandLogoFrm = $this->getBrandLogoForm($brand_id);
        $brandImageFrm = $this->getBrandImageForm($brand_id);
        $this->set('languages', Language::getAllNames());
        $this->set('brand_id', $brand_id);
        $this->set('brandLogoFrm', $brandLogoFrm);
        $this->set('brandImageFrm', $brandImageFrm);
        $this->_template->render(false, false);
    }

    public function uploadMedia()
    {
        $this->objPrivilege->canEditBrands();
        $post = FatApp::getPostedData();
        if (empty($post)) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Request_Or_File_not_supported', $this->adminLangId), true);
        }
        $brand_id = FatApp::getPostedData('brand_id', FatUtility::VAR_INT, 0);
		$languages = Language::getAllNames();
		if(count($languages) > 1){
			$lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
		} else  {
			$lang_id = array_key_first($languages); 
		}
        $file_type = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $slide_screen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 0);
        $aspectRatio = FatApp::getPostedData('ratio_type', FatUtility::VAR_INT, 0);

        if (!$brand_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Please_Select_A_File', $this->adminLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        $fileHandlerObj->deleteFile($file_type, $brand_id, 0, 0, $lang_id, $slide_screen);

        if (!$fileHandlerObj->saveAttachment(
            $_FILES['cropped_image']['tmp_name'],
            $file_type,
            $brand_id,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            $unique_record = false,
            $lang_id,
            $slide_screen,
            $aspectRatio
        )) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('brandId', $brand_id);
        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('msg', $_FILES['cropped_image']['name'] . Labels::getLabel('MSG_File_Uploaded_Successfully', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function isMediaUploaded($brandId)
    {
        if ($attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_LOGO, $brandId, 0)) {
            return true;
        }
        return false;
    }

    public function getBrandLogoForm($recordId)
    {
        $frm = new Form('frmBrandLogo');
        
        $languagesAssocArr = Language::getAllNames();
        $frm->addHiddenField('', 'recordId', $recordId);
		
		if(count($languagesAssocArr) > 1){
			 $frm->addSelectBox(Labels::getLabel('LBL_Language', $this->adminLangId), 'lang_id', array(0 => Labels::getLabel('LBL_Universal', $this->adminLangId)) + $languagesAssocArr, '', array(), '');
		} else  {
			$lang_id = array_key_first($languagesAssocArr); 
			$frm->addHiddenField('', 'lang_id', $lang_id);
		}
        
        
		$ratioArr = AttachedFile::getRatioTypeArray($this->adminLangId);
        $frm->addRadioButtons(Labels::getLabel('LBL_Ratio', $this->adminLangId), 'ratio_type', $ratioArr, AttachedFile::RATIO_TYPE_SQUARE);
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_BRAND_LOGO);
        $frm->addHiddenField('', 'logo_min_width');
        $frm->addHiddenField('', 'logo_min_height');
        $frm->addFileUpload(Labels::getLabel('LBL_Upload', $this->adminLangId), 'logo', array('accept' => 'image/*', 'data-frm' => 'frmBrandLogo'));
        $frm->addHtml('', 'brand_logo_display_div', '');

        return $frm;
    }

    public function getBrandImageForm($recordId)
    {
        $frm = new Form('frmRecordImage');
        $languagesAssocArr = Language::getAllNames();
        $frm->addHiddenField('', 'recordId', $recordId);
		if(count($languagesAssocArr) > 1){
			 $frm->addSelectBox(Labels::getLabel('LBL_Language', $this->adminLangId), 'lang_id', array(0 => Labels::getLabel('LBL_Universal', $this->adminLangId)) + $languagesAssocArr, '', array(), '');
		} else  {
			$lang_id = array_key_first($languagesAssocArr); 
			$frm->addHiddenField('', 'lang_id', $lang_id);
		}
		$screenArr = applicationConstants::getDisplaysArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel("LBL_Display_For", $this->adminLangId), 'slide_screen', $screenArr, '', array(), '');
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_BRAND_IMAGE);
        $frm->addHiddenField('', 'banner_min_width');
        $frm->addHiddenField('', 'banner_min_height');
        $frm->addFileUpload(Labels::getLabel('LBL_Upload', $this->adminLangId), 'image', array('accept' => 'image/*', 'data-frm' => 'frmBrandImage'));
        $frm->addHtml('', 'brand_image_display_div', '');

        return $frm;
    }

    private function getRequestForm($brand_id = 0)
    {
        $this->objPrivilege->canEditBrands();
        $brand_id = FatUtility::int($brand_id);

        $action = Labels::getLabel('LBL_Add_New', $this->adminLangId);
        if ($brand_id > 0) {
            $action = Labels::getLabel('LBL_Update', $this->adminLangId);
        }

        $frm = new Form('frmProdBrand', array('id' => 'frmProdBrand'));
        $frm->addHiddenField('', 'brand_id', 0);
        $frm->addHiddenField('', 'brand_seller_id', 0);
        $frm->addRequiredField(Labels::getLabel('LBL_Brand_Identifier', $this->adminLangId), 'brand_identifier');
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Brand_SEO_Friendly_URL', $this->adminLangId), 'urlrewrite_custom');
        $fld->requirements()->setRequired();
        $reqStatusArr = Brand::getBrandReqStatusArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_brand_status', $this->adminLangId), 'brand_status', $reqStatusArr, '', [], Labels::getLabel('LBL_Select', $this->adminLangId));
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->adminLangId);
        $frm->addTextArea('', 'brand_comments', '');
        /* $frm->addCheckBox(Labels::getLabel('LBL_Featured',$this->adminLangId), 'brand_featured', 1,array(),false,0); */
        $fld = $frm->addHiddenField('', 'brand_logo', '', array('id' => 'brand_logo'));
        $frm->addSubmitButton('', 'btn_submit', $action);
        return $frm;
    }

    public function requestLangForm($brand_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canEditBrands();

        $brand_id = FatUtility::int($brand_id);
        $lang_id = FatUtility::int($lang_id);

        if ($brand_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $prodBrandLangFrm = $this->getLangForm($brand_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Brand::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($brand_id, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = Brand::getAttributesByLangId($lang_id, $brand_id);
        }
        
        if ($langData) {
            $prodBrandLangFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('brand_id', $brand_id);
        $this->set('brand_lang_id', $lang_id);
        $this->set('prodBrandLangFrm', $prodBrandLangFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
    }

    public function removeBrandMedia($brand_id, $imageType = '', $afileId = 0)
    {
        $brand_id = FatUtility::int($brand_id);
        if (!$brand_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if ($imageType == 'logo') {
            $fileType = AttachedFile::FILETYPE_BRAND_LOGO;
        } elseif ($imageType == 'image') {
            $fileType = AttachedFile::FILETYPE_BRAND_IMAGE;
        }
        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile($fileType, $brand_id, $afileId)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_Successfully', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditBrands();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $this->markAsDeleted($recordId);
        Product::updateMinPrices(0, 0, $recordId);
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditBrands();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('brandIds'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $prodBrandObj = new Brand($recordId);
        if (!$prodBrandObj->canRecordMarkDelete($recordId)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $prodBrandObj->assignValues(array(Brand::tblFld('deleted') => 1));
        if (!$prodBrandObj->save()) {
            LibHelper::exitWithError($prodBrandObj->getError(), true);
        }
    }

    public function autoComplete()
    {
        $pagesize = 10;
        $post = FatApp::getPostedData();
        $this->objPrivilege->canViewBrands();
        $fetchAllRecords = FatApp::getPostedData('fetchAllRecords', FatUtility::VAR_INT, 0);
        $brandObj = new Brand();
        $srch = $brandObj->getSearchObject();
        $srch->joinTable(
            Brand::DB_TBL . '_lang',
            'LEFT OUTER JOIN',
            'brandlang_brand_id = brand_id AND brandlang_lang_id = ' . $this->adminLangId
        );
        $srch->addMultipleFields(array('brand_id, IFNULL(brand_name, brand_identifier) as brand_name'));

        if (!empty($post['keyword'])) {
            $srch->addCondition('brand_name', 'LIKE', '%' . $post['keyword'] . '%')
                ->attachCondition('brand_identifier', 'LIKE', '%' . $post['keyword'] . '%');
        }
        $srch->addCondition('brand_active', '=', applicationConstants::YES);
        $srch->addCondition('brand_deleted', '=', applicationConstants::NO);
        //$srch->setPageSize($pagesize);
        if ($fetchAllRecords == 1) {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
        } else {
            $srch->setPageSize($pagesize);
        }

        $collectionId = FatApp::getPostedData('collection_id', FatUtility::VAR_INT, 0);
        $alreadyAdded = Collections::getRecords($collectionId);
        if (!empty($alreadyAdded) && 0 < count($alreadyAdded)) {
            $srch->addCondition('brand_id', 'NOT IN', array_keys($alreadyAdded));
        }

        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $brands = $db->fetchAll($rs, 'brand_id');
        $json = array();
        foreach ($brands as $key => $brand) {
            $json[] = array(
                'id' => $key,
                'name' => strip_tags(html_entity_decode($brand['brand_name'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
        /* $this->set('brands', $db->fetchAll($rs,'brand_id') );
        $this->_template->render(false,false); */
    }

    public function brandRequests()
    {
        $this->objPrivilege->canViewBrandRequests();
        $search = $this->getSearchForm(true);
        $data = FatApp::getPostedData();
        if ($data) {
            $data['brand_id'] = $data['id'];
            unset($data['id']);
            $search->fill($data);
        }
        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs('js/cropper.js');
        $this->_template->addJs('js/cropper-main.js');
        $this->set("search", $search);
        $this->_template->render();
    }

    public function searchBrandRequests()
    {
        $this->objPrivilege->canViewBrands();

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm(true);
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $prodBrandObj = new Brand();

        $srch = $prodBrandObj->getSearchObject();
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'u.user_id = brand_seller_id', 'u');
        $srch->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'shop_user_id = if(u.user_parent > 0, user_parent, u.user_id)', 'shop');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'shop.shop_id = s_l.shoplang_shop_id AND shoplang_lang_id = ' . $this->adminLangId, 's_l');
        $srch->addMultipleFields(array('b.*', 'u.user_name', 'ifnull(shop_name, shop_identifier) as shop_name'));
        $srch->addCondition('brand_status', '=', applicationConstants::NO);
        $srch->addCondition('brand_seller_id', '>', 0);
        $srch->addOrder('b.brand_id', 'desc');
        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('b.brand_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('bl.brand_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        if (!empty($post['brand_id'])) {
            $srch->addCondition('b.brand_id', '=', $post['brand_id']);
        }
        $user_id = FatApp::getPostedData('user_id', FatUtility::VAR_INT, 0);
        if ($user_id > 0) {
            $srch->addCondition('brand_seller_id', '=', $user_id);
        }
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $srch->joinTable(
            Brand::DB_TBL . '_lang',
            'LEFT OUTER JOIN',
            'brandlang_brand_id = b.brand_id AND brandlang_lang_id = ' . $this->adminLangId,
            'bl'
        );
        $srch->addMultipleFields(array("bl.brand_name"));
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditBrands();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 == $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->changeStatus($recordId, $status);
        Product::updateMinPrices(0, 0, $recordId);
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditBrands();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $brandIdsArr = FatUtility::int(FatApp::getPostedData('brandIds'));
        if (empty($brandIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($brandIdsArr as $brandId) {
            if (1 > $brandId) {
                continue;
            }

            $this->changeStatus($brandId, $status);
        }
        Product::updateMinPrices();
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
        }

        $brandObj = new Brand($recordId);
        if (!$brandObj->changeStatus($status)) {
            LibHelper::exitWithError($brandObj->getError(), true);
        }
    }

    private function getFormColumns(): array
    {
        $brandsTblHeadingCols = CacheHelper::get('brandsTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($brandsTblHeadingCols) {
            return json_decode($brandsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'brand_identifier' => Labels::getLabel('LBL_BRAND_NAME', $this->adminLangId),
            'brand_active' => Labels::getLabel('LBL_STATUS', $this->adminLangId),
            'action' => '',
        ];
        CacheHelper::create('brandsTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'brand_identifier',
            'brand_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['brand_active'], Common::excludeKeysForSort());
    }
}
