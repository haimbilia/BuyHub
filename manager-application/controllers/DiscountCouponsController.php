<?php

class DiscountCouponsController extends ListingBaseController
{
    protected string $pageKey = 'MANAGE_DISCOUNT_COUPONS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewDiscountCoupons();
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
            $this->set("canEdit", $this->objPrivilege->canEditDiscountCoupons($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditDiscountCoupons();
        }
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->checkEditPrivilege();
        $this->setModel($constructorArgs);
        $this->formLangFields = [
            $this->modelObj::tblFld('title'),
            $this->modelObj::tblFld('description')
        ];
        $this->set('formTitle', Labels::getLabel('LBL_DISCOUNT_COUPONS_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['statusButtons'] = true;

        /* Mark As Inactive, those were Expired. */
        FatApp::getDb()->query("UPDATE " . DiscountCoupons::DB_TBL . " SET coupon_active = 0 WHERE coupon_end_date < CURDATE() AND coupon_end_date != 0");
        /* --------------------------------- */

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_COUPON_TITLE_OR_COUPON_TITLE', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js', 'discount-coupons/page-js/index.js']);
        $this->_template->addCss('css/cropper.css');
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'discount-coupons/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'coupon_active');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC));

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = DiscountCoupons::getSearchObject($this->siteLangId, false);

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('dc.coupon_identifier', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('dc.coupon_code', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('dc_l.coupon_title', 'like', '%' . $post['keyword'] . '%');
        }
        if (!empty($post['type'])) {
            $srch->addCondition('dc.coupon_type', '=', $post['type']);
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

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

        $discountTypeArr = DiscountCoupons::getTypeArr($this->siteLangId);
        $this->set('discountTypeArr', $discountTypeArr);
        $this->set('canEdit', $this->objPrivilege->canEditDiscountCoupons($this->admin_id, true));
        $this->set('canView', $this->objPrivilege->canViewDiscountCoupons($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditDiscountCoupons();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm();

        if (0 < $recordId) {
            $data = DiscountCoupons::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, null, true);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        } else {
            $frm->fill(array('coupon_id' => $recordId));
        }

        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('coupon_type', (isset($data['coupon_type']) ? $data['coupon_type'] : DiscountCoupons::TYPE_DISCOUNT));
        $this->set('couponDiscountIn', isset($data['coupon_discount_in_percent']) ? $data['coupon_discount_in_percent'] : applicationConstants::PERCENTAGE);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditDiscountCoupons();

        $frm = $this->getForm();

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['coupon_id'];
        unset($post['coupon_id']);

        $record = new DiscountCoupons($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($recordId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = DiscountCoupons::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', Labels::getLabel('MSG_Coupon_Setup_Successful.', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function isMediaUploaded($recordId)
    {
        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_DISCOUNT_COUPON_IMAGE, $recordId, 0);
        if (false !== $attachment && 0 < $attachment['afile_id']) {
            return true;
        }
        return false;
    }



    public function updateStatus()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);

        $this->changeStatus($recordId, $status);

        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditOrderStatus();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('record_ids'));

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || !in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
        }

        $data = DiscountCoupons::getAttributesById($recordId, array('coupon_id', 'coupon_active'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons($recordId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'coupon_active', applicationConstants::SORT_DESC);
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        $frm->addSelectBox(Labels::getLabel('FRM_COUPON_TYPE', $this->siteLangId), 'coupon_type', DiscountCoupons::getTypeArr($this->siteLangId, true));

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $this->objPrivilege->canViewDiscountCoupons();
        $frm = new Form('frmCoupon');
        $frm->addHiddenField('', 'coupon_id', $recordId);

        $frm->addRequiredField(Labels::getLabel('FRM_COUPON_IDENTIFIER', $this->siteLangId), 'coupon_identifier');
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_COUPON_CODE', $this->siteLangId), 'coupon_code');
        $fld->setUnique(DiscountCoupons::DB_TBL, 'coupon_code', 'coupon_id', 'coupon_id', 'coupon_id');
        $typeArr = DiscountCoupons::getTypeArr($this->siteLangId, true);

        $frm->addSelectBox(Labels::getLabel('FRM_SELECT_DISCOUNT_TYPE', $this->siteLangId), 'coupon_type', $typeArr)->requirements()->setRequired();

        $percentageFlatArr = applicationConstants::getPercentageFlatArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_DISCOUNT_IN', $this->siteLangId), 'coupon_discount_in_percent', $percentageFlatArr, '', array(), '');

        $frm->addFloatField(Labels::getLabel('FRM_DISCOUNT_VALUE', $this->siteLangId), 'coupon_discount_value');
        $frm->addFloatField(Labels::getLabel('FRM_MIN_ORDER_VALUE', $this->siteLangId), 'coupon_min_order_value')->requirements()->setFloatPositive();
        $frm->addFloatField(Labels::getLabel('FRM_MAX_DISCOUNT_VALUE', $this->siteLangId), 'coupon_max_discount_value');

        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'coupon_start_date', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));

        $fld = $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'coupon_end_date', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $fld->requirements()->setCompareWith('coupon_start_date', 'ge', Labels::getLabel('FRM_DATE_TO', $this->siteLangId));

        $frm->addIntegerField(Labels::getLabel('FRM_USES_PER_COUPON', $this->siteLangId), 'coupon_uses_count', 1);
        $frm->addIntegerField(Labels::getLabel('FRM_USES_PER_CUSTOMER', $this->siteLangId), 'coupon_uses_coustomer', 1);

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_COUPON_STATUS', $this->siteLangId), 'coupon_active', $activeInactiveArr, '', array(), '');

        $flatDiscountVal = new FormFieldRequirement('coupon_discount_value', Labels::getLabel('FRM_DISCOUNT_VALUE', $this->siteLangId));
        $flatDiscountVal->setRequired(true);
        $percentDiscountVal = new FormFieldRequirement('coupon_discount_value', Labels::getLabel('FRM_DISCOUNT_VALUE', $this->siteLangId));
        $percentDiscountVal->setRequired(true);
        $percentDiscountVal->setFloatPositive();

        $couponMinOrderValueReqTrue = new FormFieldRequirement('coupon_min_order_value', 'value');
        $couponMinOrderValueReqTrue->setRequired();
        $couponMinOrderValueReqTrue->setRange('0.00001', '9999999999');
        $couponMinOrderValueReqFalse = new FormFieldRequirement('coupon_min_order_value', 'value');
        $couponMinOrderValueReqFalse->setRequired(false);

        $couponMaxDiscountValueReqTrue = new FormFieldRequirement('coupon_max_discount_value', 'value');
        $couponMaxDiscountValueReqTrue->setRequired();
        $couponMaxDiscountValueReqFalse = new FormFieldRequirement('coupon_max_discount_value', 'value');
        $couponMaxDiscountValueReqFalse->setRequired(false);

        $couponMaxDiscountValueReqTrue->setFloatPositive();
        $couponMaxDiscountValueReqTrue->setRange('0.00001', '9999999999');

        $cType_fld = $frm->getField('coupon_type');
        $cType_fld->requirements()->addOnChangerequirementUpdate(DiscountCoupons::TYPE_DISCOUNT, 'eq', 'coupon_min_order_value', $couponMinOrderValueReqTrue);
        $cType_fld->requirements()->addOnChangerequirementUpdate(DiscountCoupons::TYPE_SELLER_PACKAGE, 'eq', 'coupon_min_order_value', $couponMinOrderValueReqFalse);

        $coupon_discount_in_percent_fld = $frm->getField('coupon_discount_in_percent');

        $coupon_discount_in_percent_fld->requirements()->addOnChangerequirementUpdate(applicationConstants::FLAT, 'eq', 'coupon_discount_value', $flatDiscountVal);
        $coupon_discount_in_percent_fld->requirements()->addOnChangerequirementUpdate(applicationConstants::PERCENTAGE, 'eq', 'coupon_discount_value', $percentDiscountVal);

        $coupon_discount_in_percent_fld->requirements()->addOnChangerequirementUpdate(applicationConstants::PERCENTAGE, 'eq', 'coupon_max_discount_value', $couponMaxDiscountValueReqTrue);
        $coupon_discount_in_percent_fld->requirements()->addOnChangerequirementUpdate(applicationConstants::FLAT, 'eq', 'coupon_max_discount_value', $couponMaxDiscountValueReqFalse);

        return $frm;
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $langId = FatUtility::int($langId);
        $langId = 1 > $langId ? $this->siteLangId : $langId;

        $frm = new Form('frmCouponLang');
        $frm->addHiddenField('', 'coupon_id', $recordId);
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', $languages, $langId, array(), '');

        $frm->addRequiredField(Labels::getLabel('FRM_COUPON_TITLE', $langId), 'coupon_title');
        $frm->addTextArea(Labels::getLabel('FRM_COUPON_DESCRIPTION', $langId), 'coupon_description');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $langId == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $langId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    private function getMediaForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $frm = new Form('frmCouponMedia');
        $frm->addHiddenField('', 'coupon_id', $recordId);
        $bannerTypeArr = applicationConstants::bannerTypeArr();

        if (count($bannerTypeArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $bannerTypeArr, '', array(), '');
        } else {
            $lang_id = array_key_first($bannerTypeArr);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }

        $frm->addFileUpload(Labels::getLabel('FRM_UPLOAD', $this->siteLangId), 'coupon_image', array('accept' => 'image/*', 'data-frm' => 'frmCouponMedia'));
        return $frm;
    }

    public function linkProductForm($recordId = 0)
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frmProduct = $this->getProductForm();

        $srch = DiscountCoupons::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array('coupon_id', 'IFNULL(coupon_title,coupon_identifier) as coupon_name', 'coupon_code'));
        $srch->addCondition('coupon_id', '=', $recordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $row['coupon_name'] = "<h3> " . Labels::getLabel('LBL_Coupon_Name', $this->siteLangId) . " : " . $row['coupon_name'] . " | " . Labels::getLabel('LBL_Coupon_Code', $this->siteLangId) . " : " . $row['coupon_code'] . "</h3>";
        $frmProduct->fill($row);
        $this->set('coupon_id', $recordId);
        $this->set('couponData', $row);
        $this->set('frmProduct', $frmProduct);
        $this->_template->render(false, false);
    }

    public function linkCategoryForm($recordId = 0)
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frmCategory = $this->getCategoryForm();

        $srch = DiscountCoupons::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array('coupon_id', 'IFNULL(coupon_title,coupon_identifier) as coupon_name', 'coupon_code'));
        $srch->addCondition('coupon_id', '=', $recordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $row['coupon_name'] = "<h3> " . Labels::getLabel('LBL_Coupon_Name', $this->siteLangId) . " : " . $row['coupon_name'] . " | " . Labels::getLabel('LBL_Coupon_Code', $this->siteLangId) . " : " . $row['coupon_code'] . "</h3>";
        $frmCategory->fill($row);
        $this->set('coupon_id', $recordId);
        $this->set('couponData', $row);
        $this->set('frmCategory', $frmCategory);
        $this->_template->render(false, false);
    }

    public function linkUserForm($recordId = 0)
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frmCategory = $this->getCategoryForm();
        $frmProduct = $this->getProductForm();
        $frmUser = $this->getDiscountUserForm();

        $srch = DiscountCoupons::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array('coupon_id', 'IFNULL(coupon_title,coupon_identifier) as coupon_name', 'coupon_code'));
        $srch->addCondition('coupon_id', '=', $recordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $row['coupon_name'] = "<h3> " . Labels::getLabel('LBL_Coupon_Name', $this->siteLangId) . " : " . $row['coupon_name'] . " | " . Labels::getLabel('LBL_Coupon_Code', $this->siteLangId) . " : " . $row['coupon_code'] . "</h3>";
        $frmCategory->fill($row);
        $frmProduct->fill($row);
        $frmUser->fill($row);
        $this->set('coupon_id', $recordId);
        $this->set('couponData', $row);
        $this->set('frmCategory', $frmCategory);
        $this->set('frmProduct', $frmProduct);
        $this->set('frmUser', $frmUser);
        $this->_template->render(false, false);
    }
    public function linkPlanForm($recordId = 0)
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frmPlan = $this->getPlanForm();

        $srch = DiscountCoupons::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array('coupon_id', 'IFNULL(coupon_title,coupon_identifier) as coupon_name', 'coupon_code'));
        $srch->addCondition('coupon_id', '=', $recordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $row['coupon_name'] = "<h3> " . Labels::getLabel('LBL_Coupon_Name', $this->siteLangId) . " : " . $row['coupon_name'] . " | " . Labels::getLabel('LBL_Coupon_Code', $this->siteLangId) . " : " . $row['coupon_code'] . "</h3>";

        $this->set('coupon_id', $recordId);
        $this->set('couponData', $row);
        $this->set('spPlanFrm', $frmPlan);

        $this->_template->render(false, false);
    }

    public function linkShopForm($recordId = 0)
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frm = $this->getShopForm();

        $srch = DiscountCoupons::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array('coupon_id', 'IFNULL(coupon_title,coupon_identifier) as coupon_name', 'coupon_code'));
        $srch->addCondition('coupon_id', '=', $recordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $row['coupon_name'] = "<h3> " . Labels::getLabel('LBL_Coupon_Name', $this->siteLangId) . " : " . $row['coupon_name'] . " | " . Labels::getLabel('LBL_Coupon_Code', $this->siteLangId) . " : " . $row['coupon_code'] . "</h3>";
        $frm->fill($row);
        $this->set('coupon_id', $recordId);
        $this->set('couponData', $row);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function linkBrandForm($recordId = 0)
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frm = $this->getBrandForm();

        $srch = DiscountCoupons::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array('coupon_id', 'IFNULL(coupon_title,coupon_identifier) as coupon_name', 'coupon_code'));
        $srch->addCondition('coupon_id', '=', $recordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $row['coupon_name'] = "<h3> " . Labels::getLabel('LBL_Coupon_Name', $this->siteLangId) . " : " . $row['coupon_name'] . " | " . Labels::getLabel('LBL_Coupon_Code', $this->siteLangId) . " : " . $row['coupon_code'] . "</h3>";
        $frm->fill($row);
        $this->set('coupon_id', $recordId);
        $this->set('couponData', $row);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function media($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $couponData = DiscountCoupons::getAttributesById($recordId);

        if (false == $couponData) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $couponMediaFrm = $this->getMediaForm($recordId);
        $this->set('coupon_id', $recordId);
        $this->set('couponMediaFrm', $couponMediaFrm);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function images($recordId = 0, $lang_id = 0)
    {
        $recordId = FatUtility::int($recordId);
        $couponData = DiscountCoupons::getAttributesById($recordId);
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatUtility::int($lang_id);
        } else {
            $lang_id = array_key_first($languages);
        }

        if (false == $couponData) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $couponImages = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_DISCOUNT_COUPON_IMAGE, $recordId, 0, $lang_id, (count($languages) > 1) ? false : true);
        $this->set('coupon_id', $recordId);
        $this->set('images', $couponImages);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function couponCategories($recordId = 0)
    {
        $this->objPrivilege->canViewDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $couponCategories = DiscountCoupons::getCouponCategories($recordId, $this->siteLangId);
        $this->set('couponCategories', $couponCategories);
        $this->set('coupon_id', $recordId);
        $this->_template->render(false, false);
    }

    public function couponProducts($recordId = 0)
    {
        $this->objPrivilege->canViewDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $couponProducts = DiscountCoupons::getCouponProducts($recordId, $this->siteLangId);
        $this->set('couponProducts', $couponProducts);
        $this->set('coupon_id', $recordId);
        $this->_template->render(false, false);
    }
    public function couponPlans($recordId = 0)
    {
        $this->objPrivilege->canViewDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $couponPlans = DiscountCoupons::getCouponPlans($recordId, $this->siteLangId);
        $this->set('couponPlans', $couponPlans);
        $this->set('coupon_id', $recordId);
        $this->_template->render(false, false);
    }

    public function couponUsers($recordId = 0)
    {
        $this->objPrivilege->canViewDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $couponUsers = DiscountCoupons::getCouponUsers($recordId, $this->siteLangId);
        $this->set('couponUsers', $couponUsers);
        $this->set('coupon_id', $recordId);
        $this->_template->render(false, false);
    }

    public function couponShops($recordId = 0)
    {
        $this->objPrivilege->canViewDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $couponShops = DiscountCoupons::getCouponShops($recordId, $this->siteLangId);
        $this->set('couponShops', $couponShops);
        $this->set('coupon_id', $recordId);
        $this->_template->render(false, false);
    }

    public function couponBrands($recordId = 0)
    {
        $this->objPrivilege->canViewDiscountCoupons();
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $couponBrands = DiscountCoupons::getCouponBrands($recordId, $this->siteLangId);
        $this->set('couponBrands', $couponBrands);
        $this->set('coupon_id', $recordId);
        $this->_template->render(false, false);
    }

    public function updateCouponCategory()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();

        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $prodcat_id = FatUtility::int($post['prodcat_id']);

        if (1 > $recordId || 1 > $prodcat_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->addUpdateCouponCategory($recordId, $prodcat_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateCouponProduct()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();

        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $product_id = FatUtility::int($post['product_id']);

        if (1 > $recordId || 1 > $product_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->addUpdateCouponProduct($recordId, $product_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
    public function updateCouponPlan()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();

        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $spplan_id = FatUtility::int($post['spplan_id']);

        if (1 > $recordId || 1 > $spplan_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->addUpdateCouponPlan($recordId, $spplan_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateCouponShop()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();

        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $shop_id = FatUtility::int($post['shop_id']);

        if (1 > $recordId || 1 > $shop_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->addUpdateCouponShop($recordId, $shop_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateCouponBrand()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();

        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $brand_id = FatUtility::int($post['brand_id']);

        if (1 > $recordId || 1 > $brand_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->addUpdateCouponBrand($recordId, $brand_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeCouponPlan()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();
        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $spplan_id = FatUtility::int($post['spplan_id']);
        if (1 > $recordId || 1 > $spplan_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->removeCouponPlan($recordId, $spplan_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
    public function removeCouponCategory()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();
        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $prodcat_id = FatUtility::int($post['prodcat_id']);
        if (1 > $recordId || 1 > $prodcat_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->removeCouponCategory($recordId, $prodcat_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeCouponProduct()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();
        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $product_id = FatUtility::int($post['product_id']);
        if (1 > $recordId || 1 > $product_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->removeCouponProduct($recordId, $product_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateCouponUser()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();

        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $user_id = FatUtility::int($post['user_id']);

        if (1 > $recordId || 1 > $user_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->addUpdateCouponUser($recordId, $user_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeCouponShop()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();
        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $shop_id = FatUtility::int($post['shop_id']);
        if (1 > $recordId || 1 > $shop_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->removeCouponShop($recordId, $shop_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeCouponBrand()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();
        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $brand_id = FatUtility::int($post['brand_id']);
        if (1 > $recordId || 1 > $brand_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->removeCouponBrand($recordId, $brand_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeCouponUser()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();
        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $user_id = FatUtility::int($post['user_id']);
        if (1 > $recordId || 1 > $user_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new DiscountCoupons();
        if (!$obj->removeCouponUser($recordId, $user_id)) {
            LibHelper::exitWithError(Labels::getLabel($obj->getError(), $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Updated_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeCouponImage()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $post = FatApp::getPostedData();
        if (false === $post) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['coupon_id']);
        $lang_id = FatUtility::int($post['lang_id']);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_DISCOUNT_COUPON_IMAGE, $recordId, 0, 0, $lang_id)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Record_Deleted_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function uploadImage($recordId = 0, $lang_id = 0)
    {
        $this->objPrivilege->canEditDiscountCoupons();

        $recordId = FatUtility::int($recordId);

        $lang_id = FatUtility::int($lang_id);

        $languages = Language::getAllNames();
        if (count($languages) <= 1) {
            $lang_id =  array_key_first($languages);
        }

        if ($recordId == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $post = FatApp::getPostedData();

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Please_select_a_file.', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        $fileHandlerObj->deleteFile(AttachedFile::FILETYPE_DISCOUNT_COUPON_IMAGE, $recordId, 0, 0, $lang_id);
        if (!$res = $fileHandlerObj->saveImage($_FILES['cropped_image']['tmp_name'], AttachedFile::FILETYPE_DISCOUNT_COUPON_IMAGE, $recordId, 0, $_FILES['cropped_image']['name'], -1, true, $lang_id)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('coupon_id', $recordId);
        $this->set('msg', $_FILES['cropped_image']['name'] . ' ' . Labels::getLabel('MSG_Uploaded_Successfully.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $recordId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);

        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = DiscountCoupons::getAttributesById($recordId);
        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $obj = new DiscountCoupons($recordId);
        $obj->assignValues(array(DiscountCoupons::tblFld('deleted') => 1));
        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function usesHistory($recordId)
    {
        $this->objPrivilege->canViewDiscountCoupons();
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $couponData = DiscountCoupons::getAttributesById($recordId, array('coupon_code'));
        if ($couponData == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $post = FatApp::getPostedData();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : $post['page'];
        $page = (empty($page) || $page <= 0) ? 1 : FatUtility::int($page);

        $srch = CouponHistory::getSearchObject();
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'user_id = couponhistory_user_id');
        $srch->joinTable(Credential::DB_TBL, 'LEFT OUTER JOIN', 'credential_user_id = user_id');
        $srch->addCondition('couponhistory_coupon_id', '=', $recordId);
        $srch->addMultipleFields(array('couponhistory_id', 'couponhistory_coupon_id', 'couponhistory_order_id', 'couponhistory_user_id', 'couponhistory_amount', 'couponhistory_added_on', 'credential_username'));
        $srch->addOrder('couponhistory_added_on', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('couponId', $recordId);
        $this->set('couponData', $couponData);

        $this->_template->render(false, false);
    }

    private function getCategoryForm()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $frm = new Form('frmCouponCategory');
        $frm->addHiddenField('', 'coupon_id');
        $frm->addHtml('', 'coupon_name', '');
        $fld1 = $frm->addTextBox(Labels::getLabel('FRM_ADD_CATEGORY', $this->siteLangId), 'category_name');
        $fld2 = $frm->addHtml('', 'addNewCategoryLink', '<small class="text--small"><a target="_blank" href="' . UrlHelper::generateUrl('productCategories') . '">' . Labels::getLabel('FRM_CATEGORY_NOT_FOUND?_Click_here_to_add_new_category', $this->siteLangId) . '</a></small>');
        $fld1->attachField($fld2);
        return $frm;
    }

    private function getProductForm()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $frm = new Form('frmCouponProduct');
        $frm->addHiddenField('', 'coupon_id');
        $frm->addHtml('', 'coupon_name', '');
        $fld1 = $frm->addTextBox(Labels::getLabel('FRM_ADD_PRODUCT', $this->siteLangId), 'product_name');
        $fld1->htmlAfterField = '<small class="text--small"><a target="_blank" href="' . UrlHelper::generateUrl('products') . '">' . Labels::getLabel('FRM_PRODUCT_NOT_FOUND?_Click_here_to_add_new_product', $this->siteLangId) . '</a></small>';
        return $frm;
    }
    private function getPlanForm()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $frm = new Form('frmCouponProduct');
        $frm->addHiddenField('', 'coupon_id');
        $frm->addHtml('', 'coupon_name', '');
        $fld1 = $frm->addTextBox(Labels::getLabel('FRM_ADD_PLAN', $this->siteLangId), 'plan_name');
        $fld2 = $frm->addHtml('', 'addNewPlanLink', '<br/><a target="_blank" href="' . UrlHelper::generateUrl('sellerPackages') . '">' . Labels::getLabel('FRM_PLAN_NOT_FOUND?_Click_here_to_add_new_plan', $this->siteLangId) . '</a>');
        $fld1->attachField($fld2);
        return $frm;
    }

    private function getDiscountUserForm()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $frm = new Form('frmCouponUser');
        $frm->addHiddenField('', 'coupon_id');
        $frm->addHtml('', 'coupon_name', '');
        $frm->addTextBox(Labels::getLabel('FRM_ADD_USER', $this->siteLangId), 'user_name');
        return $frm;
    }

    private function getShopForm()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $frm = new Form('frmCouponProduct');
        $frm->addHiddenField('', 'coupon_id');
        $frm->addHtml('', 'coupon_name', '');
        $fld1 = $frm->addTextBox(Labels::getLabel('FRM_ADD_SHOP', $this->siteLangId), 'shop_name');
        return $frm;
    }

    private function getBrandForm()
    {
        $this->objPrivilege->canEditDiscountCoupons();
        $frm = new Form('frmCouponProduct');
        $frm->addHiddenField('', 'coupon_id');
        $frm->addHtml('', 'coupon_name', '');
        $fld1 = $frm->addTextBox(Labels::getLabel('FRM_ADD_BRAND', $this->siteLangId), 'brand_name');
        $fld1->htmlAfterField = '<small class="text--small"><a target="_blank" href="' . UrlHelper::generateUrl('brands') . '">' . Labels::getLabel('FRM_BRAND_NOT_FOUND?_Click_here_to_add_new_brand', $this->siteLangId) . '</a></small>';
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('discountCouponsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'coupon_title' => Labels::getLabel('LBL_COUPON_TITLE', $this->siteLangId),
            'coupon_code' => Labels::getLabel('LBL_COUPON_CODE', $this->siteLangId),
            'coupon_type' => Labels::getLabel('LBL_COUPON_TYPE', $this->siteLangId),
            'coupon_discount_value' => Labels::getLabel('LBL_COUPON_DISCOUNT', $this->siteLangId),
            'coupon_start_date' => Labels::getLabel('LBL_AVAILABLE_FROM', $this->siteLangId),
            'coupon_end_date' => Labels::getLabel('LBL_AVAILABLE_TO', $this->siteLangId),
            'coupon_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('discountCouponsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'coupon_title',
            'coupon_code',
            'coupon_type',
            'coupon_discount_value',
            'coupon_start_date',
            'coupon_end_date',
            'coupon_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
