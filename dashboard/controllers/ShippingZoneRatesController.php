<?php
class ShippingZoneRatesController extends SellerBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function form($zoneId, $rateId = 0)
    {
        $rateId = FatUtility::int($rateId);
        $data = array();
        $frm = $this->getForm($zoneId, $rateId);
        if (0 < $rateId) {
            $data = ShippingRate::getAttributesById($rateId);
            if (empty($data)) {
                FatUtility::dieWithError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
            }
            $data['is_condition'] = 0;
            if ($data['shiprate_condition_type'] > 0) {
                $data['is_condition'] = 1;
            }
            $frm->fill($data);
        }
        $this->set('languages', Language::getAllNames());
        $this->set('zoneId', $zoneId);
        $this->set('rateId', $rateId);
        $this->set('frm', $frm);
        $this->set('rateData', $data);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $frm = $this->getForm();
        $conditionType = FatApp::getPostedData('shiprate_condition_type', FatUtility::VAR_INT, 0);
        $isCondition = FatApp::getPostedData('is_condition', FatUtility::VAR_INT, 0);
        if (1 > $conditionType && $isCondition > 0) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_CONDITION_TYPE", $this->siteLangId));
        }

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (empty($post)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $rateId = FatApp::getPostedData('shiprate_id', FatUtility::VAR_INT, 0);

        if ($isCondition < 1) {
            $post['shiprate_condition_type'] = 0;
            $post['shiprate_min_val'] = 0;
            $post['shiprate_max_val'] = 0;
        }

        unset($post['shiprate_id']);

        $srObj = new ShippingRate($rateId);
        $srObj->assignValues($post);

        if (!$srObj->save()) {
            FatUtility::dieJsonError($srObj->getError());
        }
        $rateId = $srObj->getMainTableRecordId();
        $newTabLangId = 0;
        if ($rateId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = ShippingRate::getAttributesByLangId($langId, $rateId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $shipProfileId = ShippingProfileZone::getAttributesById($post['shiprate_shipprozone_id'], 'shipprozone_shipprofile_id');
        ShippingProfile::setDefaultRates($post['shiprate_shipprozone_id'], $shipProfileId);

        $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->siteLangId));
        $this->set('zoneId', $post['shiprate_shipprozone_id']);
        $this->set('rateId', $rateId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($zoneId = 0, $rateId = 0, $langId = 0)
    {
        $zoneId = FatUtility::int($zoneId);
        $rateId = FatUtility::int($rateId);
        $langId = FatUtility::int($langId);

        if ($rateId == 0 || $langId == 0) {
            FatUtility::dieWithError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
        }

        $langFrm = $this->getLangForm($zoneId, $rateId, $langId);
        $langData = ShippingRate::getAttributesByLangId($langId, $rateId);
        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('zoneId', $zoneId);
        $this->set('rateId', $rateId);
        $this->set('langId', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false);
    }

    public function langSetup()
    {
        $post = FatApp::getPostedData();
        $zoneId = $post['zone_id'];
        $rateId = $post['rate_id'];
        $langId = $post['lang_id'];

        if ($rateId == 0 || $langId == 0) {
            Message::addErrorMessage(Labels::getLabel('LBL_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $frm = $this->getLangForm($zoneId, $rateId, $langId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        $data = array(
            'shipratelang_lang_id' => $langId,
            'shipratelang_shiprate_id' => $rateId,
            'shiprate_name' => $post['shiprate_name']
        );
        $srObj = new ShippingRate($rateId);
        if (!$srObj->updateLangData($langId, $data)) {
            FatUtility::dieJsonError($srObj->getError());
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(ShippingRate::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($rateId)) {
                FatUtility::dieJsonError($updateLangDataobj->getError());
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $key => $langName) {
            if (!$row = ShippingRate::getAttributesByLangId($key, $rateId)) {
                $newTabLangId = $key;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->siteLangId));
        $this->set('zoneId', $zoneId);
        $this->set('rateId', $rateId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRate(int $rateId)
    {
        $srch = ShippingRate::getSearchObject(0);
        $srch->joinTable(
            ShippingProfileZone::DB_TBL,
            'LEFT OUTER JOIN',
            'tspz.' . ShippingProfileZone::DB_TBL_PREFIX . 'id = srate.' . ShippingRate::DB_TBL_PREFIX . 'shipprozone_id',
            'tspz'
        );
        $srch->joinTable(
            ShippingRate::DB_TBL,
            'LEFT OUTER JOIN',
            'tsr.' . ShippingRate::DB_TBL_PREFIX . 'shipprozone_id = tspz.' . ShippingProfileZone::DB_TBL_PREFIX . 'id',
            'tsr'
        );
        $srch->addMultipleFields(['tsr.*']);
        $srch->addCondition('srate.shiprate_id', '=', $rateId);
        $rs = $srch->getResultSet();
        $rates = FatApp::getDb()->fetchAll($rs);
        if (is_array($rates) && !empty($rates)) {
            $canDelete = false;
            $withoutCondtionCount = 0;
            $conditional = false;
            foreach ($rates as $rate) {
                if ($rateId == $rate['shiprate_id'] && 0 != $rate['shiprate_condition_type']) {
                    $conditional = true;
                    break;
                }

                if (0 == $rate['shiprate_condition_type']) {
                    $withoutCondtionCount++;
                }
            }

            if (0 == $withoutCondtionCount || 1 < $withoutCondtionCount || true === $conditional) {
                $canDelete = true;
            }

            if (false === $canDelete) {
                $msg = Labels::getLabel('MSG_PLEASE_MAINTAIN_ATLEASE_ONE_SHIPPING_RATE_WITHOUT_CONDITION', $this->siteLangId);
                FatUtility::dieJsonError($msg);
            }
        }

        $sObj = new ShippingRate($rateId);
        if (!$sObj->deleteRecord(true)) {
            FatUtility::dieJsonError($sObj->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_RATE_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($zoneId = 0, $rateId = 0)
    {
        $conditionTypes = ShippingRate::getConditionTypes($this->siteLangId);
        $zoneId = FatUtility::int($zoneId);
        $rateId = FatUtility::int($rateId);
        $frm = new Form('frmShippingRates');
        $frm->addHiddenField('', 'shiprate_shipprozone_id', $zoneId);
        $frm->addHiddenField('', 'shiprate_id', $rateId);
        $cndFld = $frm->addHiddenField('', 'is_condition', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_RATE_IDENTIFIER', $this->siteLangId), 'shiprate_identifier');

        $frm->addFloatField(Labels::getLabel('FRM_COST', $this->siteLangId), 'shiprate_cost');
        $frm->addHtml('', 'add_condition', '');

        $frm->addRadioButtons('', 'shiprate_condition_type', $conditionTypes, ShippingRate::CONDITION_TYPE_WEIGHT , array('class' => 'list-inline'));

        $fldCndTypeUnReq = new FormFieldRequirement('shiprate_condition_type', Labels::getLabel('FRM_CONDITION_TYPE', $this->siteLangId));
        $fldCndTypeUnReq->setRequired(false);

        $fldCndTypeReq = new FormFieldRequirement('shiprate_condition_type', Labels::getLabel('FRM_CONDITION_TYPE', $this->siteLangId));
        $fldCndTypeReq->setRequired(true);

        $frm->addFloatField(Labels::getLabel('FRM_MINIMUM', $this->siteLangId), 'shiprate_min_val');

        $fldMinUnReq = new FormFieldRequirement('shiprate_min_val', Labels::getLabel('FRM_MINIMUM', $this->siteLangId));
        $fldMinUnReq->setRequired(false);

        $fldMinReq = new FormFieldRequirement('shiprate_min_val', Labels::getLabel('FRM_MINIMUM', $this->siteLangId));
        $fldMinReq->setRequired(true);
        $fldMinReq->setFloatPositive();
        $fldMinReq->setRange('0.001', '99999999');

        $frm->addFloatField(Labels::getLabel('FRM_MAXIMUM', $this->siteLangId), 'shiprate_max_val');

        $fldMaxUnReq = new FormFieldRequirement('shiprate_max_val', Labels::getLabel('FRM_MAXIMUM', $this->siteLangId));
        $fldMaxUnReq->setRequired(false);

        $fldMaxReq = new FormFieldRequirement('shiprate_max_val', Labels::getLabel('FRM_MAXIMUM', $this->siteLangId));
        $fldMaxReq->setRequired(true);
        $fldMaxReq->setFloatPositive();
        $fldMaxReq->setRange('0.001', '99999999');
        $fldMaxReq->setCompareWith('shiprate_min_val', 'gt', '');

        $cndFld->requirements()->addOnChangerequirementUpdate(1, 'eq', 'shiprate_min_val', $fldMinReq);
        $cndFld->requirements()->addOnChangerequirementUpdate(0, 'eq', 'shiprate_min_val', $fldMinUnReq);

        $cndFld->requirements()->addOnChangerequirementUpdate(1, 'eq', 'shiprate_max_val', $fldMaxReq);
        $cndFld->requirements()->addOnChangerequirementUpdate(0, 'eq', 'shiprate_max_val', $fldMaxUnReq);

        $cndFld->requirements()->addOnChangerequirementUpdate(1, 'eq', 'shiprate_condition_type', $fldCndTypeReq);
        $cndFld->requirements()->addOnChangerequirementUpdate(0, 'eq', 'shiprate_condition_type', $fldCndTypeUnReq);

        return $frm;
    }

    private function getLangForm($zoneId = 0, $rateId = 0, $langId = 0)
    {
        $langId = 0 < $langId ? $langId : $this->siteLangId;
        $frm = new Form('frmRateLang');
        $frm->addHiddenField('', 'zone_id', $zoneId);
        $frm->addHiddenField('', 'rate_id', $rateId);
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getAllNames(), $langId, array(), '');
        } else {
            $langId = array_key_first($languages);
            $frm->addHiddenField('', 'lang_id', $langId);
        }
        $frm->addRequiredField(Labels::getLabel('FRM_RATE_NAME', $langId), 'shiprate_name');
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $langId == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $langId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }
}
