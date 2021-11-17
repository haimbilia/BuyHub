<?php

class ProductCategoriesController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewProductCategories();
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
            $this->set("canEdit", $this->objPrivilege->canEditProductCategories($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditProductCategories();
        }
    }

    /**
     * setModel - This function is used to set related model class and used by its parent class.
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setModel(array $constructorArgs = []): void
    {
        $this->modelObj = (new ReflectionClass('ProductCategory'))->newInstanceArgs($constructorArgs);
    }

    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->checkEditPrivilege();
        $this->setModel($constructorArgs);      
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->checkMediaExist = true;
        $this->set('formTitle', Labels::getLabel('LBL_CATEGORY_SETUP', $this->siteLangId));        
    }

    public function index()
    {        
        $this->checkEditPrivilege(true);
        $srch = new ProductCategorySearch(0, false, false, false, -1);
        $this->set("recordCount", FatApp::getDb()->totalRecords($srch->getResultSet()));

        $this->_template->addJs(array('js/select2.js', 'js/jquery-sortable-lists.js', 'js/tagify.min.js', 'js/tagify.polyfills.min.js', 'js/cropper.js', 'js/cropper-main.js'));
        $this->_template->addCss(array('css/select2.min.css', 'css/cropper.css', 'css/tagify.min.css'));

        $this->_template->render();
    }

    public function search()
    {       
        $prodCat = new ProductCategory();
        $records = (array) $prodCat->getCategories(true, true);

        $this->set("arrListing", $records);
        $this->set("recordCount", count($records));
        $this->set("canEdit", $this->objPrivilege->canEditProductCategories(0, true));
        $this->_template->render(false, false);
    }

    public function getSubCategories()
    {  
        $recordId = FatApp::getPostedData('prodCatId', FatUtility::VAR_INT, 0);
        $level = FatApp::getPostedData('level', FatUtility::VAR_INT, 0);

        $prodCat = new ProductCategory($recordId);
        $childCategories = $prodCat->getCategories(true, true);

        $this->set("childCategories", $childCategories);
        $this->set("level", $level);
        $this->set("canEdit", $this->objPrivilege->canEditProductCategories(0, true));
        $this->_template->render(false, false);
    }

    public function updateOrder()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('catId', FatUtility::VAR_INT, 0);
        $parentCatId = FatApp::getPostedData('parentCatId', FatUtility::VAR_INT, 0);
        $catOrderArr = json_decode(FatApp::getPostedData('catOrder'));
        if ($recordId < 1 || count($catOrderArr) < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $prodCat = new ProductCategory($recordId);
        $prodCat->updateCatParent($parentCatId);
        $prodCat->updateCatCode();
        if (!$prodCat->updateOrder($catOrderArr)) {
            LibHelper::exitWithError($prodCat->getError(), true);
        }

        ProductCategory::updateCatOrderCode();

        $changeStatus = ProductCategory::getAttributesById($recordId, 'prodcat_active');
        if (applicationConstants::INACTIVE == $changeStatus) {
            $prodCat->disableChildCategories();
        } else {
            $prodCat->enableParentCategories();
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function form($productReq = 0)
    {
        $this->checkEditPrivilege();        
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getCategoryForm($recordId, $productReq);
        $data = [];
        if (0 < $recordId) {
            $data = ProductCategory::getAttributesById($recordId);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $langData = ProductCategory::getLangDataArr($recordId, array(ProductCategory::DB_TBL_LANG_PREFIX . 'lang_id', ProductCategory::DB_TBL_PREFIX . 'name'));
            $catNameArr = array();
            foreach ($langData as $value) {
                $catNameArr[ProductCategory::DB_TBL_PREFIX . 'name'][$value[ProductCategory::DB_TBL_LANG_PREFIX . 'lang_id']] = $value[ProductCategory::DB_TBL_PREFIX . 'name'];
            }
            $data['parent_category_name'] = $categories[$data['prodcat_parent']] ?? '';

            $prodCat = new ProductCategory($recordId);
            $ratingTypes = array();
            foreach ($prodCat->getRatingTypes() as $key => $types) {
                $ratingTypes[$key]['id'] = $types['ratingtype_id'];
                $ratingTypes[$key]['value'] = $types['ratingtype_name'];
            }
            $ratingTypes = ['rating_type' => json_encode($ratingTypes)];
            $data = array_merge($data, $catNameArr, $ratingTypes);
        }
        $frm->fill($data);     
 
        $this->set('productReq', $productReq);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);     
        $this->set('formLayout', Language::getLayoutDirection($this->siteLangId));
        $this->set('canEditRating', $this->objPrivilege->canEditRatingTypes($this->admin_id, true));
                
        $this->_template->render(false, false);
    }

    public function imagesForm($recordId)
    {
        $this->checkEditPrivilege();

        $recordId = FatUtility::int($recordId);
        if (!$recordId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
        }

        if (!ProductCategory::getAttributesById($recordId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_NO_RECORD_FOUND', $this->siteLangId), true);
        }
        $frm = $this->getImagesFrm($recordId);    
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        
        $this->_template->render(false, false);
    }

    private function getCategoryForm($recordId = 0, $productReq = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmProdCategory');
        $frm->addHiddenField('', 'prodcat_id', $recordId);
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_NAME', $this->siteLangId), 'prodcat_name[' . CommonHelper::getDefaultFormLangId() . ']');
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_IDENTIFIER', $this->siteLangId), 'prodcat_identifier');

        $prodCat = new ProductCategory();
        $categoriesArr = $prodCat->getCategoriesForSelectBox($this->siteLangId, $recordId, [], false);
        $categories =  array(0 => Labels::getLabel('FRM_ROOT_CATEGORY', $this->siteLangId)) + $prodCat->makeAssociativeArray($categoriesArr);
        $frm->addSelectBox(Labels::getLabel('FRM_PARENT_CATEGORY', $this->siteLangId), 'prodcat_parent', $categories, '', array(), '');
        $frm->addTextBox(Labels::getLabel('FRM_RATING_TYPES', $this->siteLangId), 'rating_type');
        $frm->addCheckBox(Labels::getLabel('FRM_PUBLISH', $this->siteLangId), 'prodcat_active', 1, array(), false, 0);

        if (0 < $productReq) {
            $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'prodcat_status', 1, array(), false, 0);
        }

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }       
        return $frm;
    }


    protected function getLangForm($recordId, $langId = 0)
    {
        $frm = new Form('frmEmptyCartItemLang');
        $frm->addHiddenField('', 'prodcat_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_NAME', $this->siteLangId), 'prodcat_name');
        return $frm;
    }

    private function getImagesFrm($recordId = 0)
    {
        $frm = new Form('frmRecordImage', array('id' => 'imageFrm'));
        $frm->addHiddenField('', 'prodcat_id', $recordId);
        $frm->addHTML('', 'heading_icon', '');
        $mediaLanguages = applicationConstants::bannerTypeArr();

        if (count($mediaLanguages) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_Language', $this->siteLangId), 'icon_lang_id', $mediaLanguages, '', array(), '');
        } else {
            $langid = array_key_first($mediaLanguages);
            $frm->addHiddenField('', 'icon_lang_id', $langid);
        }       

        $frm->addHiddenField('', 'icon_file_type', AttachedFile::FILETYPE_CATEGORY_ICON);
        $frm->addHiddenField('', 'logo_min_width');
        $frm->addHiddenField('', 'logo_min_height');
        //$frm->addFileUpload(Labels::getLabel('FRM_CATEGORY_ICON', $this->siteLangId), 'cat_icon', array('accept' => 'image/*', 'data-frm' => 'frmCategoryIcon'));
        $frm->addHtml('', 'cat_icon', '');
        $frm->addHtml('', 'seperator', '');

        $frm->addHTML('', 'heading_banner', '');
        if (count($mediaLanguages) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_Language', $this->siteLangId), 'banner_lang_id', $mediaLanguages, '', array(), '');
        } else {
            $langid = array_key_first($mediaLanguages);
            $frm->addHiddenField('', 'banner_lang_id', $langid);
        }

        $screenArr = applicationConstants::getDisplaysArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel("FRM_Device", $this->siteLangId), 'slide_screen', $screenArr, '', array(), '');
        $frm->addHiddenField('', 'banner_file_type', AttachedFile::FILETYPE_CATEGORY_BANNER);
        $frm->addHiddenField('', 'banner_min_width');
        $frm->addHiddenField('', 'banner_min_height');
        //$frm->addFileUpload(Labels::getLabel('FRM_CATEGORY_BANNER', $this->siteLangId), 'cat_banner', array('accept' => 'image/*', 'data-frm' => 'frmCategoryBanner'));
        $frm->addHtml('', 'cat_banner', '');
        return $frm;
    }

    public function setup($prodCatReq = 0)
    {
        $this->checkEditPrivilege();
        $frm = $this->getCategoryForm(0, $prodCatReq);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatUtility::int($post['prodcat_id']);
        $prodCatStatus = FatApp::getPostedData('prodcat_status', FatUtility::VAR_INT, 0);
        $post['prodcat_status'] = 0 < $prodCatReq ? $prodCatStatus : ProductCategory::REQUEST_APPROVED;

        $productCategory = new ProductCategory($recordId);
        if (!$productCategory->saveCategoryData($post)) {
            LibHelper::exitWithError($productCategory->getError(), true);
        }

        $newTabLangId = 0;
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        if (0 < count($languages)) {
            foreach ($languages as $langId => $langName) {
                if (!Brand::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        }        

        if ($newTabLangId == 0 && !$this->isMediaUploaded($productCategory->getMainTableRecordId())) {
            $this->set('openMediaForm', true);
        }

        FatApp::getDb()->query('CALL updateCategoryRelations(0)');

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $productCategory->getMainTableRecordId());
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function isMediaUploaded($recordId)
    {
        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_ICON, $recordId, 0);
        if (false !== $attachment && 0 < $attachment['afile_id']) {
            return true;
        }

        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER, $recordId, 0);
        if (false !== $attachment && 0 < $attachment['afile_id']) {
            return true;
        }
        return false;
    }

    public function translatedCategoryData()
    {
        $catName = FatApp::getPostedData('catName', FatUtility::VAR_STRING, '');
        $toLangId = FatApp::getPostedData('toLangId', FatUtility::VAR_INT, 0);
        $data['prodcat_name'] = $catName;
        $productCategory = new ProductCategory();
        $translatedData = $productCategory->getTranslatedCategoryData($data, $toLangId);
        if (!$translatedData) {
            LibHelper::exitWithError($productCategory->getError(), true);
        }
        $this->set('prodCatName', $translatedData[$toLangId]['prodcat_name']);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function images($prodcat_id, $imageType = '', $lang_id = 0, $slide_screen = 0)
    {
        $canEdit = $this->objPrivilege->canEditProductCategories(0, true);
        $prodcat_id = FatUtility::int($prodcat_id);
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatUtility::int($lang_id);
        } else {
            $lang_id = array_key_first($languages);
        }
 
        if ($imageType == 'icon') {
            $catIcon = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_ICON, $prodcat_id, 0, $lang_id, (count($languages) > 1 ? false : true));
            $this->set('image', $catIcon);
            $this->set('imageFunction', 'icon');
        } elseif ($imageType == 'banner') {
            $catBanner = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER, $prodcat_id, 0, $lang_id, (count($languages) > 1) ? false : true, $slide_screen);
            $this->set('image', $catBanner);
            $this->set('imageFunction', 'banner');
        }
        $this->set('imageType', $imageType);
        $this->set('languages', Language::getAllNames());
        $this->set('canEdit', $canEdit);
        $this->_template->render(false, false);
    }

    public function setUpCatImages()
    {
        $this->checkEditPrivilege();
        $file_type = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $prodcat_id = FatApp::getPostedData('prodcat_id', FatUtility::VAR_INT, 0);
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        } else {
            $lang_id = array_key_first($languages);
        }
        $slide_screen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 0);
        $afileId = FatApp::getPostedData('afile_id', FatUtility::VAR_INT, 0);
        if (!$file_type) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $allowedFileTypeArr = array(AttachedFile::FILETYPE_CATEGORY_IMAGE, AttachedFile::FILETYPE_CATEGORY_ICON, AttachedFile::FILETYPE_CATEGORY_BANNER);

        if (!in_array($file_type, $allowedFileTypeArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Please_Select_A_File', $this->siteLangId), true);
        }

        ProductCategory::deleteImagesWithOutCategoryId($file_type);

        $fileHandlerObj = new AttachedFile($afileId);
        if (!$res = $fileHandlerObj->saveImage(
            $_FILES['cropped_image']['tmp_name'],
            $file_type,
            $prodcat_id,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            false,
            $lang_id,
            $_FILES['cropped_image']['type'],
            $slide_screen
        )) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }
        ProductCategory::setImageUpdatedOn($prodcat_id);
        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('prodcat_id', $prodcat_id);
        $this->set('msg', $_FILES['cropped_image']['name'] . ' ' . Labels::getLabel('LBL_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeImage($afileId, $recordId, $imageType = '', $langId = 0, $slide_screen = 0)
    {
        $this->checkEditPrivilege();
        $afileId = FatUtility::int($afileId);
        $recordId = FatUtility::int($recordId);
        $langId = FatUtility::int($langId);
        if (!$afileId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if ($imageType == 'icon') {
            $fileType = AttachedFile::FILETYPE_CATEGORY_ICON;
        } elseif ($imageType == 'banner') {
            $fileType = AttachedFile::FILETYPE_CATEGORY_BANNER;
        }
        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile($fileType, $recordId, $afileId, 0, $langId, $slide_screen)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        ProductCategory::setImageUpdatedOn($recordId);
        $this->set('imageType', $imageType);
        $this->set('msg', Labels::getLabel('MSG_IMAGE_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $prodCatObj = new ProductCategory($recordId);
        if (applicationConstants::INACTIVE == $status) {
            $prodCatObj->disableChildCategories();
        } else {
            $prodCatObj->enableParentCategories();
        }

        $this->setModel([$recordId]);
        if (!$this->modelObj->changeStatus($status)) {
            LibHelper::exitWithError($this->modelObj->getError(), true);
        }
        Product::updateMinPrices();
    }    

    public function changeRequestStatus()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('prodCatId', FatUtility::VAR_INT, 0);

        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $catData = ProductCategory::getAttributesById($recordId, array('prodcat_status'));
        if (!$catData) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $prodCat = new ProductCategory($recordId);
        $prodCat->assignValues(
            array(
                ProductCategory::tblFld('status') => ProductCategory::REQUEST_APPROVED,
                ProductCategory::tblFld('active') => applicationConstants::ACTIVE,
                ProductCategory::tblFld('updated_on') => date('Y-m-d H:i:s'),
                ProductCategory::tblFld('status_updated_on') => date('Y-m-d H:i:s')
            )
        );
        if (!$prodCat->save()) {
            LibHelper::exitWithError($prodCat->getError(), true);
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->checkEditPrivilege();
        $prodcat_id = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($prodcat_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $prodCateObj = new ProductCategory($prodcat_id);
        if (!$prodCateObj->canRecordMarkDelete($prodcat_id)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        /* Sub-Categories have products[ */
        if (true === $prodCateObj->haveProducts()) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Products_are_associated_with_its_category/sub-categories_so_we_are_not_able_to_delete_this_category', $this->siteLangId));
        }
        /* ] */

        $prodCateObj->assignValues(array(ProductCategory::tblFld('deleted') => 1));
        if (!$prodCateObj->save()) {
            FatUtility::dieJsonError($prodCateObj->getError());
        }

        Product::updateMinPrices();
        $this->set("msg", $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
            case 'form':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_Categories', $this->siteLangId), 'href' => UrlHelper::generateUrl('ProductCategories')]
                ];
        }
        return $this->nodes;
    }

    public function autocomplete()
    {
        $search_keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $collectionId = FatApp::getPostedData('collection_id', FatUtility::VAR_INT, 0);
        $search_keyword = urldecode($search_keyword);
        $prodCateObj = new ProductCategory();
        $categories = $prodCateObj->getProdCatAutoSuggest($search_keyword, 10, $this->siteLangId, $collectionId);
        $json = array();
        foreach ($categories as $key => $val) {
            $json['results'][] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($val, ENT_QUOTES, 'UTF-8'))
            );
        }
        echo json_encode($json);
    }

    public function links_autocomplete()
    {
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $prodCatObj = new ProductCategory();
        $arr_options = $prodCatObj->getAutoCompleteProdCatTreeStructure(0, $this->siteLangId, $keyword);
        $json = array();
        foreach ($arr_options as $key => $product) {
            $json['results'][] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($product, ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

    public function requests()
    {
        $this->objPrivilege->canViewProductCategories();
        $search = $this->getSearchForm(true);
        $data = FatApp::getPostedData();
        if ($data) {
            $data['prodcat_id'] = isset($data['id']) ? $data['id'] : 0;
            unset($data['id']);
            $search->fill($data);
        }
        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs('js/cropper.js');
        $this->_template->addJs('js/cropper-main.js');
        $this->set("search", $search);
        $this->_template->render();
    }

    public function getSearchForm($request = false)
    {
        $frm = new Form('frmSearch', array('id' => 'frmSearch'));
        $f1 = $frm->addTextBox(Labels::getLabel('FRM_Keyword', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        if ($request) {
            $frm->addTextBox(Labels::getLabel('FRM_Seller_Name_Or_Email', $this->siteLangId), 'user_name', '', array('id' => 'keyword', 'autocomplete' => 'off'));
            $frm->addHiddenField('', 'user_id');
        }
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('FRM_Search', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('FRM_CLEAR', $this->siteLangId), array('onclick' => 'clearSearch();'));
        $frm->addHiddenField('', 'prodcat_id');
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    public function searchRequests()
    {
        $canEdit = $this->objPrivilege->canEditProductCategories(0, true);

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm(true);
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = ProductCategory::getSearchObject(false, $this->siteLangId, false, ProductCategory::REQUEST_PENDING);
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'u.user_id = prodcat_seller_id', 'u');
        $srch->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'shop_user_id = if(u.user_parent > 0, user_parent, u.user_id)', 'shop');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'shop.shop_id = s_l.shoplang_shop_id AND shoplang_lang_id = ' . $this->siteLangId, 's_l');
        $srch->addMultipleFields(array('m.*', 'prodcat_name', 'u.user_name', 'ifnull(shop_name, shop_identifier) as shop_name'));
        $srch->addOrder('prodcat_requested_on', 'desc');
        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('prodcat_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('prodcat_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        if (!empty($post['prodcat_id'])) {
            $srch->addCondition('prodcat_id', '=', $post['prodcat_id']);
        }
        $user_id = FatApp::getPostedData('user_id', FatUtility::VAR_INT, 0);
        if ($user_id > 0) {
            $srch->addCondition('prodcat_seller_id', '=', $user_id);
        }
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $records);
        $this->set("canEdit", $canEdit);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function getParentIds(int $catId)
    {
        $obj = new ProductCategory($catId);
        $json['data'] = array_keys($obj->getParents());
        CommonHelper::dieJsonSuccess($json);
    }

    public function updateRatingTypes()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('prt_prodcat_id', FatUtility::VAR_INT, 0);
        $rtId = FatApp::getPostedData('prt_ratingtype_id', FatUtility::VAR_INT, 0);
        if ($recordId < 1 || $rtId < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $prodCat = new ProductCategory($recordId);
        if (!$prodCat->addUpdateRatingType($rtId)) {
            LibHelper::exitWithError($prodCat->getError(), true);
        }

        $this->set('msg', Labels::getLabel('LBL_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeRatingType()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('prt_prodcat_id', FatUtility::VAR_INT, 0);
        $rtId = FatApp::getPostedData('prt_ratingtype_id', FatUtility::VAR_INT, 0);
        if ($recordId < 1 || $rtId < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $prodCat = new ProductCategory($recordId);
        if (!$prodCat->removeRatingType($rtId)) {
            LibHelper::exitWithError($prodCat->getError(), true);
        }

        $this->set('msg', Labels::getLabel('LBL_REMOVED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function ratingTypeAutoComplete()
    {
        $this->checkEditPrivilege();
        /* $pagesize = 10; */
        $post = FatApp::getPostedData();

        $srch = new RatingTypeSearch($this->siteLangId);
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('ratingtype_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('ratingtype_identifier', 'like', '%' . $keyword . '%');
        }
        $srch->addCondition('ratingtype_active', '=', applicationConstants::YES);
        $rs = $srch->getResultSet();
        $options = FatApp::getDb()->fetchAll($rs, 'ratingtype_id');

        $json = array();
        foreach ($options as $key => $option) {
            $identifer = array_key_exists('ratingtype_name', $option) && !empty($option['ratingtype_name']) ? $option['ratingtype_name'] : $option['ratingtype_identifier'];
            $json[] = array(
                'id' => $key,
                'name' => $identifer,
                'ratingtype_identifier' => $identifer
            );
        }
        die(json_encode($json));
    }
}
