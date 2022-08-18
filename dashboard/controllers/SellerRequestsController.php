<?php
class SellerRequestsController extends SellerBaseController
{
    use BadgeRequestSetup;
    use RecordOperations;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->userPrivilege->canViewSellerRequests(UserAuthentication::getLoggedUserId());
    }

    public function index()
    {
        $this->set('canEdit', $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true));

        $srch = $this->getRequestedbrandObj();
        $srch->setPageSize(1);
        $reqBrands = FatApp::getDb()->fetchAll($srch->getResultSet());

        $srch = $this->getRequestedCatObj();
        $srch->setPageSize(1);
        $reqCategories = FatApp::getDb()->fetchAll($srch->getResultSet());

        $srch = $this->getRequestedProdObj();
        $srch->setPageSize(1);
        $reqProducts = FatApp::getDb()->fetchAll($srch->getResultSet());

        $srch = $this->getRequestedBadgeObj();
        $srch->setPageSize(1);
        $reqBadges = FatApp::getDb()->fetchAll($srch->getResultSet());

        $noRecordFound = false;
        if (empty($reqBrands) && empty($reqCategories) && empty($reqProducts) && empty($reqBadges)) {
            $noRecordFound = true;
        }
        $approvalRequiredBadges = BadgeLinkCondition::getApprovalRequestBadges($this->siteLangId);

        $this->set('approvalRequiredBadges', $approvalRequiredBadges);
        $this->set('reqBadges', $reqBadges);
        $this->set('canRequestBadge', $this->userPrivilege->canEditBadgesAndRibbons(UserAuthentication::getLoggedUserId(), true));
        $this->set('noRecordFound', $noRecordFound);
        $this->_template->addJs(array('js/cropper.js', 'js/cropper-main.js', 'js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render();
    }

    public function searchBrandRequests()
    {
        $post = FatApp::getPostedData();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);

        $srch = $this->getRequestedbrandObj();
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $requestedBrands = FatApp::getDb()->fetchAll($rs);

        $this->set('canEdit', $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true));
        $this->set("arrListing", $requestedBrands);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('statusArr', Brand::getBrandReqStatusArr($this->siteLangId));
        $this->set('statusClassArr', Brand::getBrandReqStatusClassArr());
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function searchProdCategoryRequests()
    {
        $post = FatApp::getPostedData();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);

        $srch = $this->getRequestedCatObj();
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $requestedCategories = FatApp::getDb()->fetchAll($rs);

        $this->set('canEdit', $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true));
        $this->set("arrListing", $requestedCategories);
        $this->set('pageCount', $srch->pages());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('statusArr', ProductCategory::getStatusArr($this->siteLangId));
        $this->set('statusClassArr', ProductCategory::getStatusClassArr());
        $this->_template->render(false, false);
    }

    public function searchCustomCatalogProducts()
    {
        // $this->canAddCustomCatalogProduct();
        $post = FatApp::getPostedData();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);

        $srch = $this->getRequestedProdObj();
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $arrListing = FatApp::getDb()->fetchAll($rs);

        foreach ($arrListing as $key => $row) {
            $content = (!empty($row['preq_content'])) ? json_decode($row['preq_content'], true) : array();
            $langContent = (!empty($row['preq_lang_data'])) ? json_decode($row['preq_lang_data'], true) : array();

            $row = array_merge($row, $content);
            if (!empty($langContent)) {
                $row = array_merge($row, $langContent);
            }

            $arr = array(
                'preq_id' => $row['preq_id'],
                'preq_user_id' => $row['preq_user_id'],
                'preq_added_on' => $row['preq_added_on'],
                'preq_requested_on' => $row['preq_requested_on'],
                'preq_status_updated_on' => isset($row['preq_status_updated_on']) ?? $row['preq_status_updated_on'],
                'preq_status' => $row['preq_status'],
                'product_identifier' => $row['product_identifier'],
                'product_name' => (!empty($row['product_name'])) ? $row['product_name'] : '',
            );
            $arrListing[$key] = $arr;
        }
        $this->set('canEdit', $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true));
        $this->set("arrListing", $arrListing);
        $this->set('recordCount', $srch->recordCount());
        $this->set('pageCount', $srch->pages());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('statusArr', ProductRequest::getStatusArr($this->siteLangId));
        $this->set('statusClassArr', ProductRequest::getStatusClassArr());
        $this->set('CONF_CUSTOM_PRODUCT_REQUIRE_ADMIN_APPROVAL', FatApp::getConfig("CONF_CUSTOM_PRODUCT_REQUIRE_ADMIN_APPROVAL", FatUtility::VAR_INT, 1));
        $this->_template->render(false, false);
    }

    private function getRequestedbrandObj()
    {
        $srch = Brand::getSearchObject($this->siteLangId);

        $userArr = User::getAuthenticUserIds(UserAuthentication::getLoggedUserId(), $this->userParentId);
        $srch->addCondition('brand_seller_id', 'in', $userArr);
        $srch->addCondition('brand_deleted', '=', applicationConstants::NO);

        $srch->addOrder('brand_updated_on', 'DESC');

        return $srch;
    }

    private function getRequestedCatObj()
    {
        $srch = ProductCategory::getSearchObject(false, $this->siteLangId, false, -1);
        $srch->addOrder('m.prodcat_active', 'DESC');

        $userArr = User::getAuthenticUserIds(UserAuthentication::getLoggedUserId(), $this->userParentId);
        $srch->addCondition('prodcat_seller_id', 'in', $userArr);
        $srch->addCondition('prodcat_deleted', '=', applicationConstants::NO);

        $srch->addOrder('prodcat_updated_on', 'DESC');

        return $srch;
    }

    private function getRequestedProdObj()
    {
        $srch = ProductRequest::getSearchObject($this->siteLangId);

        $userArr = User::getAuthenticUserIds(UserAuthentication::getLoggedUserId(), $this->userParentId);
        $srch->addCondition('preq_user_id', 'in', $userArr);
        $srch->addCondition('preq_deleted', '=', applicationConstants::NO);

        $srch->addOrder('preq_added_on', 'DESC');
        return $srch;
    }

    /* ------Product Category Request [------*/

    public function categoryReqForm($categoryReqId = 0)
    {
        $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true);
        $frm = $this->getCategoryForm();
        $identifier = '';
        if (0 < $categoryReqId) {
            $data = ProductCategory::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $categoryReqId, array('prodcat_parent', 'IFNULL(prodcat_name,prodcat_identifier) as prodcat_name', 'prodcat_id', 'prodcat_identifier'), applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            }
            $frm->fill($data);
            $identifier = $data['prodcat_identifier'];
        }
        $this->set('frm', $frm);
        $this->set('categoryReqId', $categoryReqId);
        $this->set('identifier', $identifier);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    private function getCategoryForm($prodCatId = 0)
    {
        $prodCatId = FatUtility::int($prodCatId);
        $frm = new Form('frmCategoryReq', array('id' => 'frmCategoryReq'));
        $frm->addHiddenField('', 'prodcat_id', $prodCatId);
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_NAME', $this->siteLangId), 'prodcat_name');
        $prodCat = new ProductCategory();
        $categoriesArr = $prodCat->getCategoriesForSelectBox($this->siteLangId, $prodCatId);
        $categories = array(0 => Labels::getLabel('FRM_ROOT_CATEGORY', $this->siteLangId)) + $prodCat->makeAssociativeArray($categoriesArr);
        $frm->addSelectBox(Labels::getLabel('FRM_PARENT_CATEGORY', $this->siteLangId), 'prodcat_parent', $categories, '', array(), '');

        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        $languages = Language::getAllNames();
        if (!empty($translatorSubscriptionKey) && 1 <  count($languages)) {
            $frm->addCheckBox(Labels::getLabel('FRM_TRANSLATE_TO_OTHER_LANGUAGES', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    public function setupCategoryReq()
    {
        $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true);
        $post = FatApp::getPostedData();
        $frm = $this->getCategoryForm();
        $post = $frm->getFormDataFromArray($post);
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $categoryReqId = $post['prodcat_id'];
        if ($categoryReqId > 0 && !UserPrivilege::canSellerUpdateCategoryRequest(UserAuthentication::getLoggedUserId(), $categoryReqId)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        $approvalRequired = FatApp::getConfig('CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', FatUtility::VAR_INT, 0);
        if (!$approvalRequired) {
            $post['prodcat_active'] = applicationConstants::ACTIVE;
            $post['prodcat_status'] = ProductCategory::REQUEST_APPROVED;
            $post['prodcat_status_updated_on'] = date('Y-m-d H:i:s');
        } else {
            $post['prodcat_active'] = applicationConstants::INACTIVE;
            $post['prodcat_status'] = ProductCategory::REQUEST_PENDING;
        }

        $post['prodcat_requested_on'] = date('Y-m-d H:i:s');
        $post['prodcat_identifier'] = $post['prodcat_name'];
        $post['prodcat_seller_id'] = $this->userParentId;

        $record = new ProductCategory($categoryReqId);
        $record->assignValues($post);
        if (!$record->save()) {
            $msg = $record->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }
        $categoryReqId = $record->getMainTableRecordId();

        $this->setLangData($record, [$record::tblFld('name') => $post[$record::tblFld('name')]]);

        $notificationData = array(
            'notification_record_type' => Notification::TYPE_PRODUCT_CATEGORY,
            'notification_record_id' => $categoryReqId,
            'notification_user_id' => UserAuthentication::getLoggedUserId(true),
            'notification_label_key' => Notification::PRODUCT_CATEGORY_REQUEST_NOTIFICATION,
            'notification_added_on' => date('Y-m-d H:i:s'),
        );

        if (!Notification::saveNotifications($notificationData)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId));
        }

        $categoryData = ProductCategory::getAttributesById($categoryReqId);
        $email = new EmailHandler();
        if (!$email->sendCategoryRequestAdminNotification($this->siteLangId, $categoryData)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId));
        }
        $msg = $this->str_setup_successful;
        if ($approvalRequired) {
            $msg = Labels::getLabel("MSG_CATEGORY_REQUEST_SUBMITTED_SUCCESSFULLY", $this->siteLangId);
        }

        if ($this->get('langId') == 0 && !$this->isCategoryMediaUploaded($categoryReqId)) {
            $this->set('openMediaForm', true);
        }
        $this->set('msg', $msg);
        $this->set('categoryReqId', $categoryReqId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function categoryReqLangForm($categoryReqId = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true);
        $categoryReqId = FatUtility::int($categoryReqId);
        $lang_id = FatUtility::int($lang_id);

        if (1 > $categoryReqId || 1 > $lang_id) {
            FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }

        $frm = $this->getCategoryReqLangForm($categoryReqId, $lang_id);

        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(ProductCategory::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($categoryReqId, $lang_id, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $langData = current($translatedData);
        } else {
            $langData = ProductCategory::getAttributesByLangId($lang_id, $categoryReqId);
        }

        if ($langData) {
            $frm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('categoryReqId', $categoryReqId);
        $this->set('langId', $lang_id);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
    }

    public function categoryReqLangSetup()
    {
        $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true);
        $post = FatApp::getPostedData();

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $post['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['lang_id'] = $lang_id;
        }

        $categoryReqId = $post['prodcat_id'];

        if (1 > $categoryReqId || 1 > $lang_id) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        if (!UserPrivilege::canSellerUpdateCategoryRequest(UserAuthentication::getLoggedUserId(), $categoryReqId)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        $frm = $this->getCategoryReqLangForm($categoryReqId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $recordObj = new ProductCategory($categoryReqId);
        $this->setLangData($recordObj, [$recordObj::tblFld('name') => $post[$recordObj::tblFld('name')]], $lang_id);

        if ($this->get('langId') == 0 && !$this->isCategoryMediaUploaded($categoryReqId)) {
            $this->set('openMediaForm', true);
        }

        $this->set('categoryReqId', $categoryReqId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getCategoryReqLangForm($categoryReqId = 0, $lang_id = 0)
    {
        $frm = new Form('frmCategoryReqLang', array('id' => 'frmBrandReqLang'));
        $frm->addHiddenField('', 'prodcat_id', $categoryReqId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $lang_id), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $lang_id, array(), '');
        $fld->requirements()->setRequired();
        $fld->requirements()->setInt();
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_NAME', $lang_id), 'prodcat_name');

        return $frm;
    }

    public function categoryReqMediaForm($recordId, $langId)
    {
        $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true);
        $recordId = FatUtility::int($recordId);
        if (!$recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $image = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_ICON, $recordId, 0, $langId, false);

        $frm = $this->getCategoryReqImagesFrm($recordId, $langId);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('image', $image);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    private function getCategoryReqImagesFrm($recordId = 0, $langId = 0)
    {
        $frm = new Form('frmRecordImage', array('id' => 'imageFrm'));
        $frm->addHiddenField('', 'record_id', $recordId);
        $mediaLanguages = applicationConstants::getAllLanguages();
        if (count($mediaLanguages) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_Language', $this->siteLangId), 'lang_id', $mediaLanguages, $langId, array(), '');
        } else {
            $langid = array_key_first($mediaLanguages);
            $frm->addHiddenField('', 'lang_id', $langid);
        }

        $dimension = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_ICON, ImageDimension::VIEW_DEFAULT);
        $frm->addHiddenField('', 'min_width', $dimension['width']);
        $frm->addHiddenField('', 'min_height', $dimension['height']);
        $frm->addHtml('', 'cat_icon', '');
        return $frm;
    }

    public function uploadCategoryLogo()
    {
        $recordId = FatApp::getPostedData('record_id', FatUtility::VAR_INT, 0);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        } else {
            $lang_id = array_key_first($languages);
        }

        if (!$recordId) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        if (!UserPrivilege::canSellerUpdateCategoryRequest(UserAuthentication::getLoggedUserId(), $recordId)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId));
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->saveAttachment(
            $_FILES['cropped_image']['tmp_name'],
            $fileHandlerObj::FILETYPE_CATEGORY_ICON,
            $recordId,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            true,
            $lang_id
        )) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('recordId', $recordId);
        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('msg', $_FILES['cropped_image']['name'] . Labels::getLabel('MSG_FILE_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeCategoryLogo($recordId = 0, $lang_id = 0)
    {
        $recordId = FatUtility::int($recordId);
        $lang_id = FatUtility::int($lang_id);
        if (!$recordId) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        if (!UserPrivilege::canSellerUpdateCategoryRequest(UserAuthentication::getLoggedUserId(), $recordId)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_CATEGORY_ICON, $recordId, 0, 0, $lang_id)) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    /* ] */

    /* ------Brand Request ------*/

    public function addBrandReqForm($brandReqId = 0)
    {
        $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true);
        $frm = $this->getBrandForm();
        $identifier = '';
        if (0 < $brandReqId) {
            $data = Brand::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $brandReqId, array('IFNULL(brand_name,brand_identifier) as brand_name', 'brand_id', 'brand_identifier', 'brand_active', 'brand_featured', 'brand_status', 'brand_seller_id'), applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            }
            $frm->fill($data);
            $identifier = $data['brand_identifier'];
        }
        $this->set('frmBrandReq', $frm);
        $this->set('brandReqId', $brandReqId);
        $this->set('langId', $this->siteLangId);
        $this->set('identifier', $identifier);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function setupBrandReq()
    {
        $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true);
        $post = FatApp::getPostedData();
        $frm = $this->getBrandForm();
        $post = $frm->getFormDataFromArray($post);
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $brandReqId = $post['brand_id'];

        if ($brandReqId > 0 && !UserPrivilege::canSellerUpdateBrandRequest(UserAuthentication::getLoggedUserId(), $brandReqId)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        unset($post['brandReqId']);

        if (!FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) {
            $post['brand_active'] = applicationConstants::ACTIVE;
            $post['brand_status'] = applicationConstants::YES;
            $post['brand_status_updated_on'] = date('Y-m-d H:i:s');
        }

        $post['brand_requested_on'] = date('Y-m-d H:i:s');

        $post['brand_seller_id'] = UserAuthentication::getLoggedUserId();
        $record = new Brand($brandReqId);
        $post[$record::tblFld('identifier')] = $post[$record::tblFld('name')];
        $record->assignValues($post);

        if (!$record->save()) {
            $msg = $record->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            FatUtility::dieJsonError($msg);
        }

        $brandReqId = $record->getMainTableRecordId();

        $this->setLangData($record, [$record::tblFld('name') => $post[$record::tblFld('name')]]);

        $notificationData = array(
            'notification_record_type' => Notification::TYPE_BRAND,
            'notification_record_id' => $brandReqId,
            'notification_user_id' => UserAuthentication::getLoggedUserId(true),
            'notification_label_key' => Notification::BRAND_REQUEST_NOTIFICATION,
            'notification_added_on' => date('Y-m-d H:i:s'),
        );

        if (!Notification::saveNotifications($notificationData)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId));
        }

        if (empty($post['brand_id'])) {
            $brandReqId = $record->getMainTableRecordId();
            $brandData = Brand::getAttributesById($brandReqId);
            $email = new EmailHandler();
            $email->sendBrandRequestAdminNotification($this->siteLangId, $brandData);
        }

        if ($this->get('langId') == 0 && !$this->isBrandMediaUploaded($brandReqId)) {
            $this->set('openMediaForm', true);
        }

        $this->set('brandReqId', $brandReqId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function brandReqLangSetup()
    {
        $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true);
        $post = FatApp::getPostedData();

        $brandReqId = $post['brand_id'];
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $post['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['lang_id'] = $lang_id;
        }

        if ($brandReqId == 0 || $lang_id == 0) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        if (!UserPrivilege::canSellerUpdateBrandRequest(UserAuthentication::getLoggedUserId(), $brandReqId)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        $frm = $this->getBrandReqLangForm($brandReqId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $recordObj = new Brand($brandReqId);
        $this->setLangData($recordObj, [$recordObj::tblFld('name') => $post[$recordObj::tblFld('name')]], $lang_id);

        if ($this->get('langId') == 0 && !$this->isBrandMediaUploaded($brandReqId)) {
            $this->set('openMediaForm', true);
        }
        $this->set('brandReqId', $brandReqId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function brandReqLangForm($brandReqId = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $brandReqId = FatUtility::int($brandReqId);
        $lang_id = FatUtility::int($lang_id);

        if ($brandReqId == 0 || $lang_id == 0) {
            FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }

        if (!UserPrivilege::canSellerUpdateBrandRequest(UserAuthentication::getLoggedUserId(), $brandReqId)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $brandReqLangFrm = $this->getBrandReqLangForm($brandReqId, $lang_id);

        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Brand::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($brandReqId, $lang_id, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $langData = current($translatedData);
        } else {
            $langData = Brand::getAttributesByLangId($lang_id, $brandReqId);
        }

        if ($langData) {
            $brandReqLangFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('brandReqId', $brandReqId);
        $this->set('brandReqLangId', $lang_id);
        $this->set('brandReqLangFrm', $brandReqLangFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
    }

    public function brandMediaForm($recordId = 0, $langId = 0, $slide_screen = 0)
    {
        $recordId = FatUtility::int($recordId);
        if (!UserPrivilege::canSellerUpdateBrandRequest(UserAuthentication::getLoggedUserId(), $recordId)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $logoFrm = $this->getBrandLogoForm($recordId, $langId);
        $bannerFrm = $this->getBrandBannerForm($recordId);
        $data['lang_id'] = $langId;
        $data['ratio_type'] = AttachedFile::RATIO_TYPE_SQUARE;
        if (0 < $recordId) {
            $brandLogo = current(AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BRAND_LOGO, $recordId, 0, $langId, false));
            if (is_array($brandLogo) && count($brandLogo) && 0 < $brandLogo['afile_aspect_ratio']) {
                $data['ratio_type'] = $brandLogo['afile_aspect_ratio'];
            }
        }
        $data['ratio_type'] = ($data['ratio_type'] == 0) ? AttachedFile::RATIO_TYPE_SQUARE : $data['ratio_type'];
        $logoFrm->fill($data);
        $data['slide_screen'] = 1 > $slide_screen ? applicationConstants::SCREEN_DESKTOP : $slide_screen;
       
        $brandImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_LOGO, $recordId, 0, $langId, false);
        $bannerTypeArr = applicationConstants::getAllLanguages();

        $getBrandRequestDimensions = ImageDimension::getScreenSizes(ImageDimension::TYPE_BRAND_IMAGE);
        $getBrandRequestLogoSquare = ImageDimension::getData(ImageDimension::TYPE_BRAND_LOGO, ImageDimension::VIEW_DEFAULT, AttachedFile::RATIO_TYPE_SQUARE);
        $getBrandRequestLogoRactangle = ImageDimension::getData(ImageDimension::TYPE_BRAND_LOGO, ImageDimension::VIEW_DEFAULT, AttachedFile::RATIO_TYPE_RECTANGULAR);
       
        $this->set('getBrandRequestLogoSquare', $getBrandRequestLogoSquare);
        $this->set('getBrandRequestLogoRactangle', $getBrandRequestLogoRactangle);
        $this->set('getBrandRequestDimensions', $getBrandRequestDimensions);
        $this->set('ratio_type', $data['ratio_type']);
       
        $this->set('languages', Language::getAllNames());
        $this->set('brandReqId', $recordId);
        $this->set('logoFrm', $logoFrm);
        $this->set('bannerFrm', $bannerFrm);
        $this->set('image', $brandImage);
        $this->set('bannerTypeArr', $bannerTypeArr);
        $this->_template->render(false, false);
    }

    public function getBrandBannerForm($brandId)
    {
        $frm = new Form('frmBrandImage');
        $languagesAssocArr = Language::getAllNames();
        $frm->addHiddenField('', 'brand_id', $brandId);
        $frm->addHTML('', 'heading', '');
        if (count($languagesAssocArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', array(0 => Labels::getLabel('FRM_UNIVERSAL', $this->siteLangId)) + $languagesAssocArr, '', array(), '');
        } else {
            $lang_id = array_key_first($languagesAssocArr);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }
        $screenArr = applicationConstants::getDisplaysArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel("FRM_DISPLAY_FOR", $this->siteLangId), 'slide_screen', $screenArr, '', array(), '');
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_BRAND_IMAGE);
        $frm->addHiddenField('', 'min_width');
        $frm->addHiddenField('', 'min_height');
        $frm->addHTML('', 'banner', '');
        return $frm;
    }


    public function uploadBrandMedia()
    {
        $brand_id = FatApp::getPostedData('brand_id', FatUtility::VAR_INT, 0);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        } else {
            $lang_id = array_key_first($languages);
        }

        if (!$brand_id) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        if (!UserPrivilege::canSellerUpdateBrandRequest(UserAuthentication::getLoggedUserId(), $brand_id)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId));
        }

        $file_type = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $slide_screen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 0);
        $aspectRatio = FatApp::getPostedData('ratio_type', FatUtility::VAR_INT, 0);

        $fileHandlerObj = new AttachedFile();      
        $fileHandlerObj->deleteFile($file_type, $brand_id, 0, 0, $lang_id, $slide_screen);

        if (!$fileHandlerObj->saveAttachment(
            $_FILES['cropped_image']['tmp_name'],
            $file_type,
            $brand_id,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            false,
            $lang_id,
            $slide_screen,
            $aspectRatio
        )) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('brandId', $brand_id);
        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('msg', $_FILES['cropped_image']['name'] . Labels::getLabel('MSG_File_Uploaded_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getBrandLogoForm($brand_id, $langId)
    {
        $frm = new Form('frmBrandMedia');
        $languagesAssocArr = Language::getAllNames();
        $frm->addHiddenField('', 'brand_id', $brand_id);
        if (count($languagesAssocArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', array(0 => Labels::getLabel('FRM_UNIVERSAL', $this->siteLangId)) + $languagesAssocArr, $langId, array(), '');
        } else {
            $lang_id = array_key_first($languagesAssocArr);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }
        $frm->addHTML('', 'heading', '');

        $ratioArr = AttachedFile::getRatioTypeArray($this->siteLangId);
        $frm->addRadioButtons(Labels::getLabel('FRM_RATIO', $this->siteLangId), 'ratio_type', $ratioArr, AttachedFile::RATIO_TYPE_SQUARE);
        $frm->addHtml('', 'logo', '');
        $frm->addHiddenField('', 'min_width');
        $frm->addHiddenField('', 'min_height');
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_BRAND_LOGO);
        return $frm;
    }

    public function brandImages($brand_id, $file_type, $lang_id = 0, $slide_screen = 0)
    {
        $languages = Language::getAllNames();
        $slide_screen = FatUtility::int($slide_screen);
        $brand_id = FatUtility::int($brand_id);
        if (count($languages) > 1) {
            $lang_id = FatUtility::int($lang_id);
        } else {
            $lang_id = array_key_first($languages);
        }
        if ($file_type == 'logo') {
            $brandLogo = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_LOGO, $brand_id, 0, $lang_id, (count($languages) > 1) ? false : true);

            $aspectRatioType = $brandLogo['afile_aspect_ratio'];
            $aspectRatioType = ($aspectRatioType > 0) ? $aspectRatioType : 1;
            $imageBrandDimensions = ImageDimension::getData(ImageDimension::TYPE_BRAND_LOGO, ImageDimension::VIEW_THUMB, $aspectRatioType);
            $this->set('aspectRatioType', $aspectRatioType);
            $this->set('image', $brandLogo);
            $this->set('imageFunction', 'brandReal');
            $this->set('imageBrandDimensions', $imageBrandDimensions);
        } else {
            $imageBrandDimensions = ImageDimension::getData(ImageDimension::TYPE_BRAND_IMAGE, ImageDimension::VIEW_THUMB);
            $brandImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_IMAGE, $brand_id, 0, $lang_id, (count($languages) > 1) ? false : true, $slide_screen);
            $this->set('image', $brandImage);
            $this->set('imageFunction', 'brandImage');
            $this->set('imageBrandDimensions', $imageBrandDimensions);
        }

        $this->set('file_type', $file_type);
        $this->set('brand_id', $brand_id);
        $this->set('canEdit', $this->userPrivilege->canEditSellerRequests(UserAuthentication::getLoggedUserId(), true));       
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }    

    public function removeBrandMedia($brand_id, $imageType = 'logo', $afileId = 0)
    {
        $brand_id = FatUtility::int($brand_id);
      
        if (!$brand_id) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }
        if ($imageType == 'logo') {
            $fileType = AttachedFile::FILETYPE_BRAND_LOGO;
        } elseif ($imageType == 'image') {
            $fileType = AttachedFile::FILETYPE_BRAND_IMAGE;
        }

        if (!UserPrivilege::canSellerUpdateBrandRequest(UserAuthentication::getLoggedUserId(), $brand_id)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile($fileType, $brand_id, $afileId)) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getBrandForm()
    {
        $frm = new Form('frmBrandReq', array('id' => 'frmBrandReq'));
        $frm->addHiddenField('', 'brand_id');
        $frm->addRequiredField(Labels::getLabel('FRM_BRAND_NAME', $this->siteLangId), 'brand_name');
        //->setUnique(Brand::DB_TBL, Brand::DB_TBL_PREFIX . 'identifier', Brand::DB_TBL_PREFIX . 'id', Brand::DB_TBL_PREFIX . 'id', Brand::DB_TBL_PREFIX . 'name');

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    private function getBrandReqLangForm($brandReqId = 0, $lang_id = 0)
    {
        $frm = new Form('frmBrandReqLang', array('id' => 'frmBrandReqLang'));
        $frm->addHiddenField('', 'brand_id', $brandReqId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $lang_id), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $lang_id, array(), '');
        $fld->requirements()->setRequired();
        $fld->requirements()->setInt();
        $frm->addRequiredField(Labels::getLabel('FRM_BRAND_NAME', $lang_id), 'brand_name');

        return $frm;
    }


    private function isBrandMediaUploaded($brandId)
    {
        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_LOGO, $brandId, 0);
        return (!empty($attachment) && 0 < $attachment['afile_id']);
    }

    private function isCategoryMediaUploaded($recordId)
    {
        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_ICON, $recordId, 0);
        return (!empty($attachment) && 0 < $attachment['afile_id']);
    }

    public function customCatalogInfo($prodReqId)
    {
        $prodReqId = FatUtility::int($prodReqId);
        $srch = $this->getRequestedProdObj();
        $srch->joinTable(Brand::DB_TBL, 'LEFT OUTER JOIN', 'tb.brand_id = preq_brand_id', 'tb');
        $srch->joinTable(Brand::DB_TBL_LANG, 'LEFT OUTER JOIN', 'brandlang_brand_id = tb.brand_id	AND brandlang_lang_id = ' . $this->siteLangId, 'tb_l');
        $srch->joinTable(ProductCategory::DB_TBL, 'INNER JOIN', 'tc.prodcat_id = preq_prodcat_id', 'tc');
        $srch->joinTable(ProductCategory::DB_TBL_LANG, 'LEFT OUTER JOIN', 'prodcatlang_prodcat_id = tc.prodcat_id AND prodcatlang_lang_id = ' . $this->siteLangId, 'tc_l');
        $srch->addMultipleFields(array('preq.*', 'IFNULL(brand_name, brand_identifier) as brand_name', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name'));
        $srch->addCondition('preq_id', '=', $prodReqId);
        $rs = $srch->getResultSet();
        $product = FatApp::getDb()->fetchAll($rs);

        $productSpecData = [];
        foreach ($product as $key => $row) {
            $content = (!empty($row['preq_content'])) ? json_decode($row['preq_content'], true) : array();
            $langContent = (!empty($row['preq_lang_data'])) ? json_decode($row['preq_lang_data'], true) : array();

            $row = array_merge($row, $content);
            if (!empty($langContent)) {
                $row = array_merge($row, $langContent);
            }
            $arr = array(
                'preq_id' => $row['preq_id'],
                'preq_comment' => $row['preq_comment'],
                'product_name' => (!empty($row['product_name'])) ? $row['product_name'] : $row['product_identifier'],
                'product_min_selling_price' => $row['product_min_selling_price'],
                'product_model' => (isset($row['product_model'])) ? $row['product_model'] : '',
                'ptt_taxcat_id' => $row['ptt_taxcat_id'],
                'brand_name' => $row['brand_name'],
                'prodcat_name' => $row['prodcat_name'],
            );
            $productInfo = $arr;
        }
        /* ] */

        $this->set('product', $productInfo);
        $this->_template->render(false, false);
    }


    /* ------Badge Request ------*/
    public function searchBadgeRequests()
    {
        $post = FatApp::getPostedData();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);

        $srch = $this->getRequestedBadgeObj();
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $requestedBadges = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('canEdit', $this->userPrivilege->canEditBadgesAndRibbons(UserAuthentication::getLoggedUserId(), true));
        $this->set("arrListing", $requestedBadges);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('statusArr', BadgeRequest::getStatusArr($this->siteLangId));
        $this->_template->render(false, false);
    }

    public function downloadFile(int $badgeReqId)
    {
        $reqUserId = BadgeRequest::getAttributesById($badgeReqId, 'breq_user_id');
        if ($reqUserId != UserAuthentication::getLoggedUserId(0)) {
            Message::addErrorMessage(Labels::getLabel("ERR_INVALID_FILE", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('SellerRequests'));
        }

        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId);
        if ($res == false || 1 > $res['afile_id']) {
            Message::addErrorMessage(Labels::getLabel("ERR_NOT_AVAILABLE_TO_DOWNLOAD", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('SellerRequests'));
        }

        if (!file_exists(CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path'])) {
            Message::addErrorMessage(Labels::getLabel('LBL_FILE_NOT_FOUND', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('SellerRequests'));
        }

        $filePath = AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path'];
        AttachedFile::downloadAttachment($filePath, $res['afile_name']);
    }

    public function removeBadgeRequestRefFile(int $badgeReqId)
    {
        $reqUserId = BadgeRequest::getAttributesById($badgeReqId, 'breq_user_id');
        if ($reqUserId != UserAuthentication::getLoggedUserId(0)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_FILE", $this->siteLangId));
        }

        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId);
        $aFileObj = new AttachedFile();
        if (false == $aFileObj->deleteFile(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId)) {
            FatUtility::dieJsonError($aFileObj->getError());
        }

        if ($res !== false && !empty($res['afile_physical_path'])) {
            unlink(CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BADGE_REQUEST_IMAGE_PATH . $res['afile_physical_path']);
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_REMOVED', $this->siteLangId));
    }

    public function deleteBadgeRequest(int $badgeReqId)
    {
        $badgeReqData = BadgeRequest::getAttributesById($badgeReqId, ['breq_user_id', 'breq_status']);
        if (empty($badgeReqData) || $badgeReqData['breq_user_id'] !== UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        /* if ($badgeReqData['breq_status'] !== BadgeRequest::REQUEST_PENDING) {
            FatUtility::dieJsonError('MSG_ALREADY_APPROVED/_REJECTED', $this->siteLangId);
        } */
        $deleteQuery = "DELETE br, blc, blnk
        FROM tbl_badge_requests br
        LEFT JOIN tbl_badge_link_conditions blc ON br.breq_blinkcond_id = blc.blinkcond_id
        LEFT JOIN tbl_badge_links blnk ON br.breq_blinkcond_id = blnk.badgelink_blinkcond_id
        WHERE br.breq_id = " . $badgeReqId;
        FatApp::getDb()->query($deleteQuery);
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_REMOVED', $this->siteLangId));
    }
}
