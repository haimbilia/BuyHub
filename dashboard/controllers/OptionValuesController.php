<?php

class OptionValuesController extends LoggedUserController
{
    use RecordOperations;
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function index($optionId = 0)
    {
        $optionId = FatUtility::int($optionId);
        if (1 > $optionId) {
            Message::addErrorMessage($this->str_invalid_request);
            FatApp::redirectUser(UrlHelper::generateUrl("seller", "options"));
        }

        $this->userPrivilege->canViewProductOptions(UserAuthentication::getLoggedUserId());

        if (!UserPrivilege::canSellerEditOption($this->userParentId, $optionId)) {
            Message::addErrorMessage($this->str_invalid_request);
            FatApp::redirectUser(UrlHelper::generateUrl("seller", "options"));
        }


        $canAddCustomProd = FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0);
        if (1 > $canAddCustomProd) {
            FatApp::redirectUser(UrlHelper::generateUrl('Seller'));
        }

        $frmSearch = $this->getSearchForm($optionId);
        $this->set('keywordPlaceholder', Labels::getLabel('LBL_SEARCH_BY_OPTION_VALUE', $this->siteLangId));
        $this->set("frmSearch", $frmSearch);
        $this->set("optionId", $optionId);
        $this->set('canEdit', $this->userPrivilege->canEditProductOptions(UserAuthentication::getLoggedUserId(), true));
        $this->_template->render(true, true);
    }

    private function getSearchForm(int $optionId)
    {
        $frm = new Form('frmSearch', array('id' => 'frmSearch'));
        $frm->addTextBox('', 'keyword');
        $frm->addHiddenField('', 'total_record_count');
        $frm->addHiddenField('', 'option_id', $optionId);

        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    public function search()
    {
        $post = FatApp::getPostedData();
        $option_id = FatUtility::int($post['option_id']);
        if ($option_id <= 0) {
            FatUtility::dieWithError($this->str_invalid_request_id);
        }

        $srch = OptionValue::getSearchObject();
        $srch->addFld('ov.*');
        $srch->addCondition('ov.optionvalue_option_id', '=', $option_id);

        $srch->joinTable(
            OptionValue::DB_TBL . '_lang',
            'LEFT OUTER JOIN',
            'ovl.optionvaluelang_optionvalue_id = ov.optionvalue_id
		AND ovl.optionvaluelang_lang_id = ' . $this->siteLangId,
            'ovl'
        );

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('optionvalue_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('optionvalue_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->addMultipleFields(array("ovl.optionvalue_name"));
        $srch->addOrder('ov.optionvalue_id', 'ASC');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set("langId", $this->siteLangId);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $option_id = FatApp::getPostedData('optionvalue_option_id', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($option_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        if ($option_id > 0) {
            if (!UserPrivilege::canSellerEditOption($this->userParentId, $option_id)) {
                FatUtility::dieJsonError($this->str_invalid_request);
            }
        }
        $optionvalue_id = FatApp::getPostedData('optionvalue_id', FatUtility::VAR_INT, 0);
        unset($post['optionvalue_id']);

        if (0 < $optionvalue_id) {
            $optionValueObj = new OptionValue();
            $data = $optionValueObj->getAttributesByIdAndOptionId($option_id, $optionvalue_id, array('optionvalue_id'));
            if ($data === false) {
                FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST_ID', $this->siteLangId));
            }
        }

        $optionValueObj = new OptionValue($optionvalue_id);
        $post[$optionValueObj::tblFld('identifier')] = $post[$optionValueObj::tblFld('name')];
        $optionValueObj->assignValues($post);
        if (!$optionValueObj->save()) {
            FatUtility::dieJsonError($optionValueObj->getError());
        }

        $optionvalue_id = ($optionvalue_id > 0) ? $optionvalue_id : $optionValueObj->getMainTableRecordId();

        $this->setLangData($optionValueObj, [$optionValueObj::tblFld('name') => $post[$optionValueObj::tblFld('name')]]);

        $this->set('optionId', $option_id);
        $this->set('optionValueId', $optionvalue_id);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function form($option_id, $optionvalue_id = 0)
    {
        $option_id = FatUtility::int($option_id);
        if ($option_id <= 0) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST_ID', $this->siteLangId)
            );
        }

        $option = new Option();
        if (!$row = $option->getOption($option_id)) {
            Message::addErrorMessage(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $optionName = (isset($row['option_name'])) ? $row['option_name'][$this->siteLangId] : $row['option_identifier'];

        $optionvalue_id = FatUtility::int($optionvalue_id);
        $frm = $this->getForm($option_id, $optionvalue_id);
        $identifier = '';
        if (0 < $optionvalue_id) {
            $data = OptionValue::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $optionvalue_id, array('m.*', 'IFNULL(optionvalue_name,optionvalue_identifier) as optionvalue_name'), applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                FatUtility::dieWithError(
                    Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
                );
            }
            $frm->fill($data);
            $identifier = $data['optionvalue_identifier'];
        }

        $this->set('frm', $frm);
        $this->set('languages', Language::getAllNames());
        $this->set('identifier', $identifier);
        $this->set('option_id', $option_id);
        $this->set('optionvalue_id', $optionvalue_id);
        $this->set('optionName', $optionName);
        $this->_template->render(false, false);
    }

    private function getForm($option_id = 0, $optionvalue_id = 0)
    {
        $option_id = FatUtility::int($option_id);
        $optionvalue_id = FatUtility::int($optionvalue_id);
        $frm = new Form('frmOptionValues', array('id' => 'frmOptionValues'));
        $frm->addHiddenField('', 'optionvalue_id', $optionvalue_id);
        $frm->addHiddenField('', 'optionvalue_option_id', $option_id);
        $frm->addRequiredField(Labels::getLabel('FRM_OPTION_VALUE_NAME', $this->siteLangId), 'optionvalue_name');
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_DISPLAY_ORDER', $this->siteLangId), 'optionvalue_display_order');
        $fld->requirements()->setInt();
        $fld->requirements()->setPositive();
        $fld->requirements()->setRange(1, 9999999999);
        $optionRow = Option::getAttributesById($option_id);
        if ($optionRow && $optionRow['option_is_color']) {
            $fld = $frm->addTextBox(Labels::getLabel('FRM_OPTION_VALUE_COLOR', $this->siteLangId), 'optionvalue_color_code');
            $fld->overrideFldType('color');
        }

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    public function langForm($optionvalue_id = 0, $langId = 0, $autoFillLangData = 0)
    {
        $optionvalue_id = FatUtility::int($optionvalue_id);
        $langId = FatUtility::int($langId);
        $autoFillLangData = FatUtility::int($autoFillLangData);

        if (1 > $optionvalue_id || 1 > $langId) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        $langFrm = $this->getLangForm($optionvalue_id, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(OptionValue::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($optionvalue_id, $langId, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = OptionValue::getAttributesByLangId($langId, $optionvalue_id, NULL, applicationConstants::JOIN_RIGHT);
        }

        $optionName = '';
        $option_id = 0;
        if ($langData) {
            $langFrm->fill($langData);
            $option_id = $langData['optionvalue_option_id'];
            $option = new Option();
            if (!$row = $option->getOption($option_id)) {
                LibHelper::exitWithError(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId), true);
            }
            $optionName = (isset($row['option_name'])) ? $row['option_name'][$this->siteLangId] : $row['option_identifier'];
        }

        $this->set('langFrm', $langFrm);
        $this->set('optionvalue_id', $optionvalue_id);
        $this->set('option_id', $option_id);
        $this->set('langId', $langId);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('optionName', $optionName);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function langSetup()
    {
        $this->userPrivilege->canEditProductOptions(UserAuthentication::getLoggedUserId());

        $post = FatApp::getPostedData();
        $lang_id = $post['lang_id'];
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $post['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['lang_id'] = $lang_id;
        }

        $optionvalue_id = FatUtility::int($post['optionvalue_id']);
        $optionId = FatUtility::int($post['optionvalue_option_id']);

        if (1 > $optionvalue_id || 1 > $optionId || 1 > $lang_id) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        if (!UserPrivilege::canSellerEditOption($this->userParentId, $optionId)) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }


        $frm = $this->getLangForm($optionvalue_id, $lang_id);
        $post = $frm->getFormDataFromArray($post);
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $recordObj = new OptionValue($optionvalue_id);
        $this->setLangData($recordObj, [$recordObj::tblFld('name') => $post[$recordObj::tblFld('name')]], $lang_id);

        $this->set('optionvalue_option_id', $optionvalue_id);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getLangForm($optionvalue_id = 0, $langId = 0)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;

        $frm = new Form('frmOptionValueLang');
        $frm->addHiddenField('', OptionValue::DB_TBL_PREFIX . 'option_id');
        $frm->addHiddenField('', OptionValue::DB_TBL_PREFIX . 'id', $optionvalue_id);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_NAME', $langId), OptionValue::DB_TBL_PREFIX . 'name');
        return $frm;
    }

    public function deleteRecord()
    {
        $optionvalue_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        $option_id = FatApp::getPostedData('option_id', FatUtility::VAR_INT, 0);

        if ($optionvalue_id < 1 || $option_id < 1) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        if (!UserPrivilege::canSellerEditOption($this->userParentId, $option_id)) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        $optionValueObj = new OptionValue($optionvalue_id);
        if (!$optionValueObj->canEditRecord($option_id)) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        if ($optionValueObj->isLinkedWithInventory($optionvalue_id)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_THIS_OPTION_VALUE_IS_LINKED_WITH_INVENTORY', $this->siteLangId));
        }

        if (!$optionValueObj->deleteRecord()) {
            FatUtility::dieJsonError($optionValueObj->getError());
        }

        FatUtility::dieJsonSuccess(
            Labels::getLabel('MSG_RECORD_DELETED', $this->siteLangId)
        );
    }

    public function setOptionsOrder()
    {
        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $obj = new OptionValue();
            if (!$obj->updateOrder($post['optionvalues'])) {
                FatUtility::dieJsonError($obj->getError());
            }
            $this->set('msg', Labels::getLabel('MSG_ORDER_UPDATED_SUCCESSFULLY', $this->siteLangId));
            $this->_template->render(false, false, 'json-success.php');
        }
    }

    public function getBreadcrumbNodes($action)
    {
        $this->nodes[] = array('title' => ucwords(Labels::getLabel('LBL_OPTIONS', $this->siteLangId)), 'href' => UrlHelper::generateUrl('seller', 'options', [], CONF_WEBROOT_DASHBOARD));
        $this->nodes[] = array('title' => Labels::getLabel('LBL_OPTION_VALUES', $this->siteLangId));
        return $this->nodes;
    }
}
