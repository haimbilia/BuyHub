<?php

class ShippingZoneRatesController extends ListingBaseController {

    protected $modelClass = 'ShippingRate';
    protected $pageKey = 'MANAGE_SHIPPING_RATES';

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewShippingManagement();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditShippingManagement($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditShippingManagement();
        }
    }

    public function form($zoneId, $rateId = 0) {
        $this->objPrivilege->canEditShippingManagement();
        $rateId = FatUtility::int($rateId);
        $data = array();
        $frm = $this->getForm($zoneId, $rateId);
        if (0 < $rateId) {
            $data = ShippingRate::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $rateId, [
                        'shiprate_name',
                        'shiprate_condition_type',
                        'shiprate_cost',
                        'shiprate_min_val',
                        'shiprate_max_val',
                            ], true);
            if (empty($data)) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $data['is_condition'] = 0;
            if ($data['shiprate_condition_type'] > 0) {
                $data['is_condition'] = 1;
            }
            $frm->fill($data);
        }
        $generalTab = [
            'attr' => [
                'href' => 'javascript:void(0);',
                'onclick' => "addEditShipRates(" . $zoneId . "," . $rateId . ");",
                'title' => Labels::getLabel('LBL_GENERAL', $this->siteLangId)
            ],
            'label' => Labels::getLabel('LBL_GENERAL', $this->siteLangId),
            'isActive' => true
        ];
        $this->set('activeGentab', true);
        $this->set('languages', Language::getAllNames());
        $this->set('zoneId', $zoneId);
        $this->set('rateId', $rateId);
        $this->set('recordId', $zoneId);
        $this->set('frm', $frm);
        $this->set('rateData', $data);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup() {
        $this->objPrivilege->canEditShippingManagement();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (empty($post)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $rateId = $post['shiprate_id'];
        $isCondition = $post['is_condition'];
        if ($isCondition < 1) {
            $post['shiprate_condition_type'] = 0;
            $post['shiprate_min_val'] = 0;
            $post['shiprate_max_val'] = 0;
        }
        unset($post['shiprate_id']);
        $post['shiprate_identifier'] = $post['shiprate_name'];

        $srObj = new ShippingRate($rateId);
        $srObj->assignValues($post);
        if (!$srObj->save()) {
            $msg = $srObj->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }
        $rateId = $srObj->getMainTableRecordId();
        $this->setLangData($srObj, [
            'shiprate_name' => $post['shiprate_name']
        ]);
        $shipProfileId = ShippingProfileZone::getAttributesById($post['shiprate_shipprozone_id'], 'shipprozone_shipprofile_id');
        ShippingProfile::setDefaultRates($post['shiprate_shipprozone_id'], $shipProfileId);
        $this->set('msg', $this->str_update_record);
        $this->set('zoneId', $post['shiprate_shipprozone_id']);
        $this->set('rateId', $rateId);
        $this->set('recordId', $rateId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($zoneId = 0, $rateId = 0, $langId = 0) {
        $this->objPrivilege->canEditShippingManagement();
        $zoneId = FatUtility::int($zoneId);
        $rateId = FatUtility::int($rateId);
        $langId = FatUtility::int($langId);

        if ($rateId == 0 || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
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
        $this->set('activeLangtab', true);

        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup() {
        $this->objPrivilege->canEditShippingManagement();
        $post = FatApp::getPostedData();
        $zoneId = $post['zone_id'];
        $rateId = $post['rate_id'];
        $langId = $post['lang_id'];

        if ($rateId == 0 || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
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
            LibHelper::exitWithError($srObj->getError(), true);
        }
        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $key => $langName) {
            if (!$row = ShippingRate::getAttributesByLangId($key, $rateId)) {
                $newTabLangId = $key;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('zoneId', $zoneId);
        $this->set('rateId', $rateId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRate($rateId) {
        $this->objPrivilege->canEditShippingManagement();

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
                LibHelper::exitWithError($msg, true);    
            }
        }

        $sObj = new ShippingRate($rateId);
        if (!$sObj->deleteRecord(true)) {
             LibHelper::exitWithError($sObj->getError(), true);   
        }
        $this->set('msg', Labels::getLabel('LBL_Rate_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($zoneId = 0, $rateId = 0) {
        $conditionTypes = ShippingRate::getConditionTypes($this->siteLangId);
        $zoneId = FatUtility::int($zoneId);
        $rateId = FatUtility::int($rateId);
        $frm = new Form('frmShippingRates');
        $frm->addHiddenField('', 'shiprate_shipprozone_id', $zoneId);
        $frm->addHiddenField('', 'shiprate_id', $rateId);
        $cndFld = $frm->addHiddenField('', 'is_condition', 0);
        $fld = $frm->addRequiredField(Labels::getLabel('LBL_Rate_Name', $this->siteLangId), 'shiprate_name');

        $frm->addFloatField(Labels::getLabel('LBL_Cost', $this->siteLangId), 'shiprate_cost');
        $frm->addHtml('', 'add_condition', '');

        $fld = $frm->addRadioButtons('', 'shiprate_condition_type', $conditionTypes, '', array('class' => 'list-inline'));

        $fldCndTypeUnReq = new FormFieldRequirement('shiprate_condition_type', Labels::getLabel('LBL_Condition_type', $this->siteLangId));
        $fldCndTypeUnReq->setRequired(false);

        $fldCndTypeReq = new FormFieldRequirement('shiprate_condition_type', Labels::getLabel('LBL_Condition_type', $this->siteLangId));
        $fldCndTypeReq->setRequired(true);

        $frm->addFloatField(Labels::getLabel('LBL_Minimum', $this->siteLangId), 'shiprate_min_val');

        $fldMinUnReq = new FormFieldRequirement('shiprate_min_val', Labels::getLabel('LBL_Minimum', $this->siteLangId));
        $fldMinUnReq->setRequired(false);

        $fldMinReq = new FormFieldRequirement('shiprate_min_val', Labels::getLabel('LBL_Minimum', $this->siteLangId));
        $fldMinReq->setRequired(true);
        $fldMinReq->setFloatPositive();
        $fldMinReq->setRange('0.001', '99999999');

        $frm->addFloatField(Labels::getLabel('LBL_Maximum', $this->siteLangId), 'shiprate_max_val');

        $fldMaxUnReq = new FormFieldRequirement('shiprate_max_val', Labels::getLabel('LBL_Maximum', $this->siteLangId));
        $fldMaxUnReq->setRequired(false);

        $fldMaxReq = new FormFieldRequirement('shiprate_max_val', Labels::getLabel('LBL_Maximum', $this->siteLangId));
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

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    protected function getLangForm($zoneId = 0, $rateId = 0, $langId = 0) {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $frm = new Form('frmzoneLang', array('id' => 'frmzoneLang'));
        $frm->addHiddenField('', 'zone_id', $zoneId);
        $frm->addHiddenField('', 'rate_id', $rateId);
        $frm->addHiddenField('', 'lang_id', $langId);
        $langFld = $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $langFld->setfieldTagAttribute('onChange', "editRateLangForm($zoneId,$rateId,this.value);");
        $frm->addRequiredField(Labels::getLabel('LBL_Rate_Name', $langId), 'shiprate_name');
        return $frm;
    }

}
