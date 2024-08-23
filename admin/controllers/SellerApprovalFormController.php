<?php

class SellerApprovalFormController extends ListingBaseController
{
    protected string $pageKey = 'MANAGE_SELLER_APPROVAL_FORM';
    protected string $modelClass = 'SupplierFormFields';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerApprovalForm();
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
            $this->set("canEdit", $this->objPrivilege->canEditSellerApprovalForm($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditSellerApprovalForm();
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
        $this->objPrivilege->canEditSellerApprovalForm();
        $this->setModel($constructorArgs);
        $this->formLangFields = [
            $this->modelObj::tblFld('caption'),
            $this->modelObj::tblFld('comment'),
        ];
        $this->set('formTitle', Labels::getLabel('LBL_SELLER_APPROVAL_FORM_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_CAPTION', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(array('seller-approval-form/page-js/index.js'));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'seller-approval-form/search.php', true),
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
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $searchForm = $this->getSearchForm($fields);
        $postedData = FatApp::getPostedData();
        $post = $searchForm->getFormDataFromArray($postedData);

        $srch = SupplierFormFields::getSearchObject();
        $srch->joinTable(
            SupplierFormFields::DB_TBL . '_lang',
            'LEFT OUTER JOIN',
            'sf_l.sformfieldlang_sformfield_id = sf.sformfield_id AND sf_l.sformfieldlang_lang_id = ' . $this->siteLangId,
            'sf_l'
        );
        $srch->addMultipleFields(['sf.*', 'sf_l.*', 'COALESCE(sformfield_caption, sformfield_identifier) as sformfield_caption']);

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('sf.sformfield_identifier', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('sf_l.sformfield_caption', 'like', '%' . $post['keyword'] . '%');
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);

        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);

       /*  if (1 == count($records)) {
            unset($fields['dragdrop']);
        } */

        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditSellerApprovalForm($this->admin_id, true));

        $this->set("yesNoArr", applicationConstants::getYesNoArr($this->siteLangId));
        $this->set("fieldTypeArr", User::getFieldTypes($this->siteLangId));
    }

    private function getForm()
    {
        $frm = new Form('frmSuppiler');
        $frm->addHiddenField('', 'sformfield_id', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_CAPTION', $this->siteLangId), 'sformfield_caption');
        $frm->addSelectBox(Labels::getLabel('FRM_REQUIRED', $this->siteLangId), 'sformfield_required', applicationConstants::getYesNoArr($this->siteLangId), -1, array(), '');
        $frm->addSelectBox(Labels::getLabel('FRM_FIELD_TYPE', $this->siteLangId), 'sformfield_type', User::getFieldTypes($this->siteLangId), -1, array(), '');
        $frm->addTextarea(Labels::getLabel('FRM_COMMENTS', $this->siteLangId), 'sformfield_comment');
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    public function form()
    {
        $this->objPrivilege->canEditSellerApprovalForm();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm();
        if (0 < $recordId) {
            $attr = [
                'sformfield_id',
                'COALESCE(sformfield_caption, sformfield_identifier) as sformfield_caption',
                'sformfield_required',
                'sformfield_type',
                'sformfield_comment'
            ];
            $data = SupplierFormFields::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, $attr, applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_SELLER_APPROVAL_FORM_SETUP', $this->siteLangId));

        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditSellerApprovalForm();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatUtility::int($post['sformfield_id']);

        if (1 > $recordId) {
            $srch = SupplierFormFields::getSearchObject();
            $srch->doNotCalculateRecords();
            $srch->addFld('MAX(sformfield_display_order) as last_display_order');
            $srch->setPageSize(1);
            $maxOrder = (array)FatApp::getDb()->fetch($srch->getResultSet());
            $maxOrder = ((int)current($maxOrder)) + 1;
            $post['sformfield_display_order'] = $maxOrder;
        }

        $recordObj = new SupplierFormFields($recordId);
        $post['sformfield_identifier'] = $post['sformfield_caption'];
        $recordObj->assignValues($post);

        if (!$recordObj->save()) {
            $msg = $recordObj->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_CAPTION', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }

        $this->setLangData(
            $recordObj,
            [
                $recordObj::tblFld('caption') => $post[$recordObj::tblFld('caption')],
                $recordObj::tblFld('comment') => $post[$recordObj::tblFld('comment')]
            ],
        );

        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getLangForm($recordId, $langId)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $frm = new Form('frmSellerApprovalFormlang');
        $frm->addHiddenField('', 'sformfield_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_CAPTION', $langId), 'sformfield_caption');
        $frm->addTextarea(Labels::getLabel('FRM_COMMENTS', $this->siteLangId), 'sformfield_comment');
        return $frm;
    }

    public function setFieldsOrder()
    {
        $this->objPrivilege->canEditSellerApprovalForm();

        $post = FatApp::getPostedData();

        if (!empty($post)) {
            $obj = new SupplierFormFields();
            if (!$obj->updateOrder($post['formFields'])) {
                LibHelper::exitWithError($obj->getError(), true);
            }

            $this->set('msg', Labels::getLabel('MSG_ORDER_UPDATED_SUCCESSFULLY', $this->siteLangId));
            $this->_template->render(false, false, 'json-success.php');
        }
    }

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $srch = SupplierFormFields::getSearchObject();
        $srch->addFld('COUNT(1) as recordCount');
        $srch->doNotCalculateRecords();
        $result = (array)FatApp::getDb()->fetch($srch->getResultSet());
        if (1 == $result['recordCount']) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_MAINTAIN_ATLEAST_ONE_RECORD.'), true);
        }

        $this->setModel([$recordId]);
        if (!$this->modelObj->deleteRecord(false)) {
            LibHelper::exitWithError($this->modelObj->getError(), true);
        }
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('sellerApprovalFormTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'dragdrop' => '',
            'sformfield_display_order' => Labels::getLabel('LBL_DISPLAY_ORDER', $this->siteLangId),
            'sformfield_caption' => Labels::getLabel('LBL_CAPTION', $this->siteLangId),
            'sformfield_type' => Labels::getLabel('LBL_TYPE', $this->siteLangId),
            'sformfield_required' => Labels::getLabel('LBL_REQUIRED', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        CacheHelper::create('sellerApprovalFormTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'dragdrop',
            'sformfield_display_order',
            'sformfield_caption',
            'sformfield_type',
            'sformfield_required',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['dragdrop', 'sformfield_type', 'sformfield_required'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => $pageTitle]
                ];
        }
        return $this->nodes;
    }
}
