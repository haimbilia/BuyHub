<?php

class ShippingCompaniesController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewShippingCompanies($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditShippingCompanies($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewShippingCompanies();
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewShippingCompanies();

        $srch = ShippingCompanies::getSearchObject(false, $this->siteLangId);

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addOrder('scompany_id', 'DESC');

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

    public function form($shippingCompanyId)
    {
        $this->objPrivilege->canViewShippingCompanies();
        $shippingCompanyId = FatUtility::int($shippingCompanyId);

        $frm = $this->getForm($shippingCompanyId);
        if (0 < $shippingCompanyId) {
            $data = ShippingCompanies::getAttributesById($shippingCompanyId, array('scompany_id', 'scompany_identifier', 'scompany_active'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }
        $this->set('languages', Language::getAllNames());
        $this->set('scompany_id', $shippingCompanyId);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditShippingCompanies();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $scompany_id = FatUtility::int($post['scompany_id']);
        unset($post['scompany_id']);

        $record = new ShippingCompanies($scompany_id);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($scompany_id > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = ShippingCompanies::getAttributesByLangId($langId, $scompany_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $scompany_id = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('sCompanyId', $scompany_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($scompany_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canViewShippingCompanies();

        $scompany_id = FatUtility::int($scompany_id);
        $lang_id = FatUtility::int($lang_id);

        if ($scompany_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($scompany_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(ShippingCompanies::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($scompany_id, $lang_id, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = ShippingCompanies::getAttributesByLangId($lang_id, $scompany_id);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('scompany_id', $scompany_id);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditShippingCompanies();
        $post = FatApp::getPostedData();

        $scompany_id = $post['scompany_id'];
        $lang_id = $post['lang_id'];

        if ($scompany_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($scompany_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['scompany_id']);
        unset($post['lang_id']);

        $data = array(
            'scompanylang_lang_id' => $lang_id,
            'scompanylang_scompany_id' => $scompany_id,
            'scompany_name' => $post['scompany_name']
        );

        $sCompanyObj = new ShippingCompanies($scompany_id);

        if (!$sCompanyObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($sCompanyObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(ShippingCompanies::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($scompany_id, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = ShippingCompanies::getAttributesByLangId($langId, $scompany_id)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('sCompanyId', $scompany_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateOrder()
    {
        $this->objPrivilege->canEditShippingCompanies();

        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $sCompanyObj = new ShippingCompanies();
            if (!$sCompanyObj->updateOrder($post['shippingMethod'])) {
                LibHelper::exitWithError($sCompanyObj->getError(), true);
            }
            FatUtility::dieJsonSuccess(Labels::getLabel('LBL_Order_Updated_Successfully', $this->siteLangId));
        }
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditShippingCompanies();
        $scompanyId = FatApp::getPostedData('scompanyId', FatUtility::VAR_INT, 0);
        if (0 >= $scompanyId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = ShippingCompanies::getAttributesById($scompanyId, array('scompany_id', 'scompany_active'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $status = ($data['scompany_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->updateShippingCompanyStatus($scompanyId, $status);

        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditShippingCompanies();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $scompanyIdsArr = FatUtility::int(FatApp::getPostedData('scompany_ids'));
        if (empty($scompanyIdsArr) || -1 == $status) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId),
                true
            );
        }

        foreach ($scompanyIdsArr as $scompanyId) {
            if (1 > $scompanyId) {
                continue;
            }

            $this->updateShippingCompanyStatus($scompanyId, $status);
        }
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateShippingCompanyStatus($scompanyId, $status)
    {
        $status = FatUtility::int($status);
        $scompanyId = FatUtility::int($scompanyId);
        if (1 > $scompanyId || -1 == $status) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId),
                true
            );
        }

        $obj = new ShippingCompanies($scompanyId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    private function getForm($scompany_id = 0)
    {
        $scompany_id = FatUtility::int($scompany_id);

        $frm = new Form('frmShippingCompany');
        $frm->addHiddenField('', 'scompany_id', $scompany_id);
        $frm->addRequiredField(Labels::getLabel('FRM_SHIPPING_IDENTIFIER', $this->siteLangId), 'scompany_identifier');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);

        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'scompany_active', $activeInactiveArr, '', array(), '');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getLangForm($scompany_id = 0, $lang_id = 0)
    {
        $frm = new Form('frmShippingCompanyLang');
        $frm->addHiddenField('', 'scompany_id', $scompany_id);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_SHIPPING_API_NAME', $this->siteLangId), 'scompany_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }
}
