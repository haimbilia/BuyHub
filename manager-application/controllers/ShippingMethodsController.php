<?php

class ShippingMethodsController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewShippingMethods($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditShippingMethods($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewShippingMethods();
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewShippingMethods();

        $srch = ShippingMethods::getSearchObject(false, $this->siteLangId);

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addOrder('shippingapi_id', 'DESC');

        $rs = $srch->getResultSet();
        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }

        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set("arrListing", $records);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function form($shippingApiId)
    {
        $this->objPrivilege->canViewShippingMethods();
        $shippingApiId = FatUtility::int($shippingApiId);

        $frm = $this->getForm($shippingApiId);

        if (1 > $shippingApiId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = ShippingMethods::getAttributesById($shippingApiId, array('shippingapi_id', 'shippingapi_identifier', 'shippingapi_active'));
        if ($data === false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm->fill($data);

        $this->set('languages', Language::getAllNames());
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditShippingMethods();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $shippingapi_id = FatUtility::int($post['shippingapi_id']);
        unset($post['shippingapi_id']);

        $data = ShippingMethods::getAttributesById($shippingapi_id, array('shippingapi_id'));
        if ($data === false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $record = new ShippingMethods($shippingapi_id);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;

        if ($shippingapi_id > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = ShippingMethods::getAttributesByLangId($langId, $shippingapi_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $shippingapi_id = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('sMethodId', $shippingapi_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($shippingapi_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canViewShippingMethods();

        $shippingapi_id = FatUtility::int($shippingapi_id);
        $lang_id = FatUtility::int($lang_id);

        if ($shippingapi_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($shippingapi_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(ShippingMethods::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($shippingapi_id, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = ShippingMethods::getAttributesByLangId($lang_id, $shippingapi_id);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('lang_id', $lang_id);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditShippingMethods();
        $post = FatApp::getPostedData();

        $shippingapi_id = $post['shippingapi_id'];
        $lang_id = $post['lang_id'];

        if ($shippingapi_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($shippingapi_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['shippingapi_id']);
        unset($post['lang_id']);

        $data = array(
            'shippingapilang_lang_id' => $lang_id,
            'shippingapilang_shippingapi_id' => $shippingapi_id,
            'shippingapi_name' => $post['shippingapi_name']
        );

        $sMethodObj = new ShippingMethods($shippingapi_id);

        if (!$sMethodObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($sMethodObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(ShippingMethods::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($shippingapi_id)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = ShippingMethods::getAttributesByLangId($langId, $shippingapi_id)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('sMethodId', $shippingapi_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateOrder()
    {
        $this->objPrivilege->canEditShippingMethods();

        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $sMethodObj = new ShippingMethods();
            if (!$sMethodObj->updateOrder($post['shippingMethod'])) {
                LibHelper::exitWithError($sMethodObj->getError(), true);
            }
            FatUtility::dieJsonSuccess(Labels::getLabel('LBL_Order_Updated_Successfully', $this->siteLangId));
        }
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditShippingMethods();
        $shippingapiId = FatApp::getPostedData('shippingapiId', FatUtility::VAR_INT, 0);
        if (0 >= $shippingapiId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = ShippingMethods::getAttributesById($shippingapiId, array('shippingapi_id', 'shippingapi_active'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $status = ($data['shippingapi_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->updateShippingMethodsStatus($shippingapiId, $status);

        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditShippingMethods();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $shippingapiIdsArr = FatUtility::int(FatApp::getPostedData('shippingapi_ids'));
        if (empty($shippingapiIdsArr) || -1 == $status) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true
            );
        }

        foreach ($shippingapiIdsArr as $shippingapiId) {
            if (1 > $shippingapiId) {
                continue;
            }

            $this->updateShippingMethodsStatus($shippingapiId, $status);
        }
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateShippingMethodsStatus($shippingapiId, $status)
    {
        $status = FatUtility::int($status);
        $shippingapiId = FatUtility::int($shippingapiId);
        if (1 > $shippingapiId || -1 == $status) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true
            );
        }

        $obj = new ShippingMethods($shippingapiId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    private function getForm($shippingapi_id = 0)
    {
        $shippingapi_id = FatUtility::int($shippingapi_id);

        $frm = new Form('frmShippingMethod');
        $frm->addHiddenField('', 'shippingapi_id', $shippingapi_id);
        $frm->addRequiredField(Labels::getLabel('FRM_SHIPPING_IDENTIFIER', $this->siteLangId), 'shippingapi_identifier');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);

        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'shippingapi_active', $activeInactiveArr, '', array(), '');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getLangForm($shippingapi_id = 0, $lang_id = 0)
    {
        $frm = new Form('frmShippingMethodLang');
        $frm->addHiddenField('', 'shippingapi_id', $shippingapi_id);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_Shipping_Api_Name', $this->siteLangId), 'shippingapi_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }
}
