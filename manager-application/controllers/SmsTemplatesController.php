<?php

class SmsTemplatesController extends ListingBaseController
{
    protected string $pageKey = 'MANAGE_SMS_TEMPLATES';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSmsTemplate();

        if (false === SmsArchive::canSendSms()) {
            $msg = Labels::getLabel("MSG_NO_SMS_PLUGIN_CONFIGURED", $this->siteLangId);
            LibHelper::exitWithError($msg, false, true);
            FatApp::redirectUser(UrlHelper::generateUrl());
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['statusButtons'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_TEMPLATE_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['sms-templates/page-js/index.js']);
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'sms-templates/search.php', true),
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

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = SmsTemplate::getSearchObject($this->siteLangId);
        $srch->addGroupBy(SmsTemplate::DB_TBL_PREFIX . 'code');

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('stpl_code', 'like', '%' . $post['keyword'] . '%');
            $cond->attachCondition('stpl_name', 'like', '%' . $post['keyword'] . '%', 'OR');
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
        $this->set('canEdit', $this->objPrivilege->canEditSmsTemplate($this->admin_id, true));
    }

    public function editTemplate($stplCode, $lang_id = 0, $autoFillLangData = 0)
    {
        $lang_id = FatUtility::int($lang_id);

        if (empty($stplCode) || 1 > $lang_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $tempFrm = $this->getTemplateForm($stplCode, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(SmsTemplate::DB_TBL);
            $translatedData = $updateLangDataobj->getTranslatedData($stplCode, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $tempData = current($translatedData);
        } else {
            $stplObj = new SmsTemplate($stplCode);
            $tempData = $stplObj->getTpl($stplCode, $lang_id);
        }

        if ($tempData) {
            $tempFrm->fill($tempData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('stplCode', $stplCode);
        $this->set('lang_id', $lang_id);
        $this->set('tempFrm', $tempFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getTemplateForm($stplCode, $langId)
    {
        $this->objPrivilege->canViewSmsTemplate();
        $frm = new Form('frmEtplLang');
        $frm->addHiddenField('', 'stpl_code', $stplCode);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getAllNames(), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_NAME', $langId), 'stpl_name');
        $fld = $frm->addTextArea(Labels::getLabel('FRM_BODY', $langId), 'stpl_body');
        $fld->requirements()->setRequired(true);
        $frm->addHtml(Labels::getLabel('FRM_REPLACEMENT_CAPTION', $langId), 'replacement_caption', '<h3>' . Labels::getLabel('FRM_REPLACEMENT_VARS', $langId) . '</h3>');
        $frm->addHtml(Labels::getLabel('FRM_REPLACEMENT_VARS', $langId), 'stpl_replacements', '');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $langId == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $langId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    public function setup()
    {
        $this->objPrivilege->canEditSmsTemplate();
        $data = FatApp::getPostedData();
        $lang_id = $data['lang_id'];
        $frm = $this->getTemplateForm($data['stpl_code'], $lang_id);
        $post = $frm->getFormDataFromArray($data);
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $stplCode = $post['stpl_code'];

        $data = [
            'stpl_lang_id' => $lang_id,
            'stpl_code' => $stplCode,
            'stpl_name' => $post['stpl_name'],
            'stpl_body' => $post['stpl_body'],
        ];

        $stplCode = $data['stpl_code'];
        $stplObj = new SmsTemplate($stplCode);

        if (!$stplObj->addUpdateData($data)) {
            LibHelper::exitWithError($stplObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(SmsTemplate::DB_TBL);
            if (false === $updateLangDataobj->updateTranslatedData($stplCode)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditSmsTemplate();

        $stplCode = FatApp::getPostedData('recordId', FatUtility::VAR_STRING, '');
        if (empty($stplCode)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->changeTplStatus($stplCode, $status);
        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditSmsTemplate();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $stplCodesArr = FatApp::getPostedData('stpl_codes');
        if (empty($stplCodesArr) || 0 > $status) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        foreach ($stplCodesArr as $stplCode) {
            $this->changeTplStatus($stplCode, $status);
        }
        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    private function changeTplStatus(string $stplCode, int $status)
    {
        if (empty($stplCode) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new SmsTemplate($stplCode);
        if (applicationConstants::ACTIVE == $status) {
            if (false == $obj->makeActive()) {
                LibHelper::exitWithError($obj->getError(), true);
            }
        } else if (applicationConstants::INACTIVE == $status) {
            if (false == $obj->makeInActive()) {
                LibHelper::exitWithError($obj->getError(), true);
            }
        }
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('smsTemplatesTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'stpl_name' => Labels::getLabel('LBL_name', $this->siteLangId),
            'stpl_status' => Labels::getLabel('LBL_Status', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        if (count(Language::getAllNames()) < 2) {
            unset($arr['language_name']);
        }

        CacheHelper::create('smsTemplatesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'stpl_name',
            'stpl_status',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
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
