<?php
class ProductCategoriesController extends ListingBaseController
{
    protected $modelClass = 'ProductCategory';

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

        $pageData = PageLanguageData::getAttributesByKey('MANAGE_CATEGORIES', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems([], $this->modelObj);
        $this->set('actionItemsData', $actionItemsData);
        $this->set('frmSearch', $this->getCatSearchForm());

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);

        $prodCat = new ProductCategory();
        $records = (array) $prodCat->getCategories(true, true);
        $this->set("arrListing", $records);

        $this->_template->addJs(array('js/select2.js', 'js/jquery-sortable-lists.js', 'js/tagify.min.js', 'js/tagify.polyfills.min.js', 'js/cropper.js', 'js/cropper-main.js', 'product-categories/page-js/add-media.js', 'product-categories/page-js/saveCategoryRecord.js'));
        $this->_template->addCss(array('css/select2.min.css', 'css/cropper.css', 'css/tagify.min.css'));

        $this->_template->render();
    }

    private function getCatSearchForm()
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    public function search()
    {
        $this->checkEditPrivilege(true);

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        if (!empty($keyword)) {
            $prodCatSrchObj = new ProductCategorySearch($this->siteLangId, false, true, false, true, true);
            $records = ProductCategory::getTreeArr($this->siteLangId, 0, false, $prodCatSrchObj, false, $keyword);
            $this->set("allOpen", true);
            $this->set("searchRequest", true);
        } else {
            $prodCat = new ProductCategory();
            $records = (array) $prodCat->getCategories(true, true);
        }
        $this->set("keyword", $keyword);
        $this->set("arrListing", $records);
        $this->set("siteLangId", $this->siteLangId);
        $this->set('html', $this->_template->render(false, false, NULL, true, false));
        $this->_template->render(false, false, 'json-success.php', true, false);
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
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
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

        LibHelper::sendAsyncRequest('POST', UrlHelper::generateFullUrl('ProductCategories', 'updateCatOrderCode'), ['sessionId' => LibHelper::getSessionId()]);

        $changeStatus = ProductCategory::getAttributesById($recordId, 'prodcat_active');
        if (applicationConstants::INACTIVE == $changeStatus) {
            $prodCat->disableChildCategories();
        } else {
            $prodCat->enableParentCategories();
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateCatOrderCode()
    {
        $sessionId = FatApp::getPostedData('sessionId', FatUtility::VAR_STRING, '');
        if (empty($sessionId)) {
            return;
        }
        session_destroy();
        session_id($sessionId);
        session_start();

        ProductCategory::updateCatOrderCode();
        return;
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

            $productCatCode = $data['prodcat_code'];
            $productCatCode = explode("_", $productCatCode);
            $productCatCode = array_filter($productCatCode, 'strlen');
            $prodCat = new ProductCategory();
            $categoriesArr = $prodCat->getCategoriesForSelectBox($this->siteLangId, $recordId, $productCatCode, false);
            $categories =  array(0 => Labels::getLabel('FRM_ROOT_CATEGORY', $this->siteLangId)) + $prodCat->makeAssociativeArray($categoriesArr);
            $data['parent_category_name'] = $categories[$data['prodcat_parent']] ?? '';

            $prodCat = new ProductCategory($recordId);
            $ratingTypes = array();
            foreach ($prodCat->getRatingTypes() as $key => $types) {
                $ratingTypes[$key]['id'] = $types['ratingtype_id'];
                $ratingTypes[$key]['value'] = $types['ratingtype_name'];
            }
            $ratingTypes = ['rating_type' => json_encode($ratingTypes)];

            /* url data[ */
            $urlSrch = UrlRewrite::getSearchObject();
            $urlSrch->doNotCalculateRecords();
            $urlSrch->setPageSize(1);
            $urlSrch->addFld('urlrewrite_custom');
            $urlSrch->addCondition('urlrewrite_original', '=', 'category/view/' . $recordId);
            $urlRow = FatApp::getDb()->fetch($urlSrch->getResultSet());
            if ($urlRow) {
                $data['urlrewrite_custom'] = $urlRow['urlrewrite_custom'];
            }
            /* ] */

            $data = array_merge($data, $catNameArr, $ratingTypes);
        }
        $frm->fill($data);

        $this->set('productReq', $productReq);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($this->siteLangId));
        $this->set('canEditRating', $this->objPrivilege->canEditRatingTypes($this->admin_id, true));

        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function imagesForm($recordId)
    {
        $this->checkEditPrivilege();
        $languages = Language::getAllNames();
        $recordId = FatUtility::int($recordId);
        if (!$recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!ProductCategory::getAttributesById($recordId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_NO_RECORD_FOUND', $this->siteLangId), true);
        }

        $getProdCatBannerDimensions = ImageDimension::getScreenSizes(ImageDimension::TYPE_CATEGORY_BANNER);
        $getProdCatLogoDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_ICON, ImageDimension::VIEW_DEFAULT);
        $getProdCatthumbDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_THUMB, ImageDimension::VIEW_DEFAULT);

        $this->set('getProdCatBannerDimensions', $getProdCatBannerDimensions);
        $this->set('getProdCatLogoDimensions', $getProdCatLogoDimensions);
        $this->set('getProdCatthumbDimensions', $getProdCatthumbDimensions);

        $isParent = ProductCategory::isParentCategory($recordId);
        $frm = $this->getImagesFrm($recordId, $isParent);
        $this->set('isParent', $isParent);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('languageCount', count($languages));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getCategoryForm($recordId = 0, $productReq = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmProdCategory');
        $frm->addHiddenField('', 'prodcat_id', $recordId);
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_IDENTIFIER', $this->siteLangId), 'prodcat_identifier');
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_NAME', $this->siteLangId), 'prodcat_name[' . CommonHelper::getDefaultFormLangId() . ']');

        $fld = $frm->addTextBox(Labels::getLabel('FRM_SEO_FRIENDLY_URL', $this->siteLangId), 'urlrewrite_custom');
        $fld->requirements()->setRequired();

        $prodCat = new ProductCategory();
        $categoriesArr = $prodCat->getCategoriesForSelectBox($this->siteLangId, $recordId, [], false);
        $categories =  array(0 => Labels::getLabel('FRM_ROOT_CATEGORY', $this->siteLangId)) + $prodCat->makeAssociativeArray($categoriesArr);
        $frm->addSelectBox(Labels::getLabel('FRM_PARENT_CATEGORY', $this->siteLangId), 'prodcat_parent', $categories, '', array(), '');
        $frm->addTextBox(Labels::getLabel('FRM_RATING_TYPES', $this->siteLangId), 'rating_type');
        $frm->addCheckBox(Labels::getLabel('FRM_PUBLISH', $this->siteLangId), 'prodcat_active', 1, array(), true, 0);

        if (0 < $productReq) {
            $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'prodcat_status', 1, array(), false, 0);
        }

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        $defaultLangId = FatUtility::int(FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1));
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr) && $this->siteLangId == $defaultLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
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

    private function getImagesFrm($recordId = 0, $isParent = 0)
    {
        $frm = new Form('frmRecordImage', array('id' => 'imageFrm'));
        $frm->addHiddenField('', 'prodcat_id', $recordId);
        $frm->addHTML('', 'heading_icon', '');
        $mediaLanguages = applicationConstants::getAllLanguages();

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

        if ($isParent) {
            $frm->addHTML('', 'heading_thumb', '');
            if (count($mediaLanguages) > 1) {
                $frm->addSelectBox(Labels::getLabel('FRM_Language', $this->siteLangId), 'thumb_lang_id', $mediaLanguages, '', array(), '');
            } else {
                $langid = array_key_first($mediaLanguages);
                $frm->addHiddenField('', 'thumb_lang_id', $langid);
            }
            $frm->addHiddenField('', 'thumb_file_type', AttachedFile::FILETYPE_CATEGORY_THUMB);
            $frm->addHiddenField('', 'thumb_min_width');
            $frm->addHiddenField('', 'thumb_min_height');

            $frm->addHtml('', 'cat_thumb', '');
            $frm->addHtml('', 'seperatorthumb', '');
        }

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

        $oldParentCatId = NULL;
        if (0 < $recordId) {
            $prodCatData = ProductCategory::getAttributesById($recordId, ['prodcat_parent', 'prodcat_deleted']);
            if (false === $prodCatData || 0 < $prodCatData['prodcat_deleted']) {
                LibHelper::exitWithError($this->str_invalid_request_id, true);
            }
            $oldParentCatId = $prodCatData['prodcat_parent'];
        }

        $newParentCatId = FatUtility::int($post['prodcat_parent']);
        $isParentUpdated = (1 > $recordId || $newParentCatId != $oldParentCatId);

        $prodCatStatus = FatApp::getPostedData('prodcat_status', FatUtility::VAR_INT, 0);
        $post['prodcat_status'] = 0 < $prodCatReq ? $prodCatStatus : ProductCategory::REQUEST_APPROVED;

        $productCategory = new ProductCategory($recordId);
        if (!$productCategory->saveCategoryData($post)) {
            LibHelper::exitWithError($productCategory->getError(), true);
        }
        $recordId = $productCategory->getMainTableRecordId();

        $newTabLangId = 0;
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        if (0 < count($languages)) {
            foreach ($languages as $langId => $langName) {
                if (!ProductCategory::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        }

        if ($newTabLangId == 0 && !$this->isMediaUploaded($recordId)) {
            $this->set('openMediaForm', true);
        }

        $updateRecordId = ($isParentUpdated ? (1 > $newParentCatId ? $recordId : $newParentCatId) : $recordId);
        if ($isParentUpdated) {
            $prodCatCode = new ProductCategory($updateRecordId);
            $prodCatCode->updateCatCode();
            FatApp::getDb()->query('CALL updateCategoryRelations(' . $updateRecordId . ')');
            if (0 < $oldParentCatId) {
                $prodCatCode->setMainTableRecordId($oldParentCatId);
                $prodCatCode->updateCatCode();
                FatApp::getDb()->query('CALL updateCategoryRelations(' . $oldParentCatId . ')');
            }
        }

        if (0 < $prodCatReq && ProductCategory::REQUEST_PENDING == $post['prodcat_status']) {
            CalculativeDataRecord::updateCategoryRequestCount();
        }

        $prodCat = new ProductCategory($updateRecordId);
        $row = (array) $prodCat->getData(true, true);
        $this->set("row", $row);
        $this->set("canEdit", $this->objPrivilege->canEditProductCategories(0, true));

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $productCategory->getMainTableRecordId());
        $this->set('listingHtml', $this->_template->render(false, false, 'product-categories/search.php', true));
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php', true, false);
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

        if (strtolower($imageType) == strtolower(ImageDimension::VIEW_ICON)) {
            $catIcon = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_ICON, $prodcat_id, 0, $lang_id, (count($languages) > 1 ? false : true));
            $this->set('image', $catIcon);
            $this->set('imageFunction', ImageDimension::VIEW_ICON);
            $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_ICON, ImageDimension::VIEW_THUMB);
            $this->set('imageDimensions', $imageDimensions);
        } elseif (strtolower($imageType) == 'banner') {
            $catBanner = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER, $prodcat_id, 0, $lang_id, (count($languages) > 1) ? false : true, $slide_screen);
            $this->set('image', $catBanner);
            $this->set('imageFunction', 'banner');

            $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_BANNER, ImageDimension::VIEW_THUMB);
            $this->set('imageDimensions', $imageDimensions);
        } elseif (strtolower($imageType) == strtolower(ImageDimension::VIEW_THUMB)) {
            $catThumb = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_THUMB, $prodcat_id, 0, $lang_id, (count($languages) > 1) ? false : true, $slide_screen);
            $this->set('image', $catThumb);
            $this->set('imageFunction', ImageDimension::VIEW_THUMB);
            $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_THUMB, ImageDimension::VIEW_THUMB);
            $this->set('imageDimensions', $imageDimensions);
        }
        $this->set('imageType', $imageType);
        $this->set('languages', Language::getAllNames());
        $this->set('canEdit', $canEdit);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
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

        $allowedFileTypeArr = array(AttachedFile::FILETYPE_CATEGORY_IMAGE, AttachedFile::FILETYPE_CATEGORY_ICON, AttachedFile::FILETYPE_CATEGORY_BANNER, AttachedFile::FILETYPE_CATEGORY_THUMB);

        if (!in_array($file_type, $allowedFileTypeArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('LBL_PLEASE_SELECT_A_FILE', $this->siteLangId), true);
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
        } elseif ($imageType == 'thumb') {
            $fileType = AttachedFile::FILETYPE_CATEGORY_THUMB;
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
        CalculativeDataRecord::updateCategoryRequestCount();
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
        $childCats = $prodCateObj->getChildrens();
        if (1 < count($childCats)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_REMOVE_CHILD_CATEGORIES_FIRST.'), true);
        }

        if (!$prodCateObj->canRecordMarkDelete($prodcat_id)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        /* Sub-Categories have products[ */
        if (true === $prodCateObj->haveProducts(false)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PRODUCTS_ARE_ASSOCIATED_WITH_ITS_CATEGORY/SUB-CATEGORIES_SO_WE_ARE_NOT_ABLE_TO_DELETE_THIS_CATEGORY', $this->siteLangId), true);
        }
        /* ] */

        $prodCateObj->assignValues(
            [
                ProductCategory::tblFld('deleted') => 1,
                ProductCategory::tblFld('identifier') => 'mysql_func_CONCAT(' . ProductCategory::tblFld('identifier') . ',"{deleted}",' . ProductCategory::tblFld('id') . ')'
            ],
            false,
            '',
            '',
            true
        );
        if (!$prodCateObj->save()) {
            LibHelper::exitWithError($prodCateObj->getError(), true);
        }

        Product::updateMinPrices();
        $this->set("msg", $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function autoComplete()
    {
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $search_keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $search_keyword = urldecode($search_keyword);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, $this->siteLangId);
        $excludeRecords = FatApp::getPostedData('excludeRecords', FatUtility::VAR_INT);

        $prodCateObj = new ProductCategory();
        [$categories, $pageCount] = $prodCateObj->getProdCatAutoSuggest($search_keyword, 20, $langId, $excludeRecords, $page);
        $json = array(
            'pageCount' => $pageCount,
            'results' => []
        );
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
        $search = $this->getRequestSearchForm(true);
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

    public function getRequestSearchForm($request = false)
    {
        $frm = new Form('frmSearch', array('id' => 'frmSearch'));
        $f1 = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        if ($request) {
            $frm->addTextBox(Labels::getLabel('FRM_Seller_Name_Or_Email', $this->siteLangId), 'user_name', '', array('id' => 'keyword', 'autocomplete' => 'off'));
            $frm->addHiddenField('', 'user_id');
        }
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId), array('onclick' => 'clearSearch();'));
        $frm->addHiddenField('', 'prodcat_id');
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    public function searchRequests()
    {
        $canEdit = $this->objPrivilege->canEditProductCategories(0, true);

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getRequestSearchForm(true);
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = ProductCategory::getSearchObject(false, $this->siteLangId, false, ProductCategory::REQUEST_PENDING);
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'u.user_id = prodcat_seller_id', 'u');
        $srch->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'shop_user_id = if(u.user_parent > 0, user_parent, u.user_id)', 'shop');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'shop.shop_id = s_l.shoplang_shop_id AND shoplang_lang_id = ' . $this->siteLangId, 's_l');
        $srch->addMultipleFields(array('m.*', 'prodcat_name', 'u.user_name', 'ifnull(shop_name, shop_identifier) as shop_name'));
        $srch->addOrder('prodcat_requested_on', 'desc');
        if (isset($post['keyword']) && '' != $post['keyword']) {
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
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
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

        $this->set('msg', Labels::getLabel('MSG_UPDATED', $this->siteLangId));
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

        $this->set('msg', Labels::getLabel('MSG_REMOVED', $this->siteLangId));
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
        $srch->addCondition('ratingtype_type', 'NOT IN', [RatingType::TYPE_PRODUCT, RatingType::TYPE_SHOP, RatingType::TYPE_DELIVERY]);
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
