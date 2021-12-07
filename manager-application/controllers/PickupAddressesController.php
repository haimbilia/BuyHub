<?php

class PickupAddressesController extends ListingBaseController {

    protected string $modelClass = 'Address';
    protected $pageKey = 'MANAGE_PICKUP_ADDRESSES';

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewPickupAddresses();
    }

    public function index() {
        $fields = $this->getFormColumns();
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('frmSearch', $this->getSearchForm($fields));
        $this->set('includeTabs', false);
        $this->set('actionItemsData', array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj)));
        $this->set('canEdit', $this->objPrivilege->canEditPickupAddresses($this->admin_id, true));
        $this->getListingData();
        $this->_template->addJs([
            'pickup-addresses/page-js/index.js'
        ]);
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'pickup-addresses/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData() {
        $this->objPrivilege->canViewBrandRequests();
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }
        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchForm($fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $srch = new AddressSearch($this->siteLangId);
        $srch->joinCountry();
        $srch->joinState();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(array('addr.*', 'state_code', 'country_code', 'country_code_alpha3', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name'));
        $srch->addCondition('country_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('state_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition(Address::tblFld('type'), '=', Address::TYPE_ADMIN_PICKUP);
        $srch->addCondition('addr_deleted', '=', 0);
        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('addr_title', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('addr_name', 'like', '%' . $post['keyword'] . '%', 'OR');
            $condition->attachCondition('addr_address1', 'like', '%' . $post['keyword'] . '%', 'OR');
            $condition->attachCondition('addr_address2', 'like', '%' . $post['keyword'] . '%', 'OR');
            $condition->attachCondition('addr_city', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
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
        $this->set('canEdit', $this->objPrivilege->canEditPickupAddresses($this->admin_id, true));
    }

    public function form_1() {
        $this->objPrivilege->canEditBrandRequests();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        if (0 < $recordId) {
            $data = Brand::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, array('brand_name', 'brand_id', 'brand_identifier', 'brand_active', 'brand_featured', 'brand_status', 'brand_seller_id'), true);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $data['urlrewrite_custom'] = AdminShopSearch::getUrlRewrite($this->rewriteUrl . $recordId);
            $frm->fill($data);
        }


        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function form($addressId = 0, $langId = 0) {
        $this->objPrivilege->canEditPickupAddresses();
        $stateId = 0;
        $slotData = [];
        $langId = FatUtility::int($langId);
        if ($langId == 0) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        $addressId = FatUtility::int($addressId);
        $frm = $this->getForm($addressId, $langId);
        $availability = TimeSlot::DAY_INDIVIDUAL_DAYS;
        if (0 < $addressId) {
            $address = new Address($addressId, $langId);
            $data = $address->getData(Address::TYPE_ADMIN_PICKUP, 0);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $stateId = $data['addr_state_id'];

            $timeSlot = new TimeSlot();
            $timeSlots = $timeSlot->timeSlotsByAddrId($addressId);
            $timeSlotsRow = current($timeSlots);
            $availability = isset($timeSlotsRow['tslot_availability']) ? $timeSlotsRow['tslot_availability'] : 0;
            $data['tslot_availability'] = $availability;
            $frm->fill($data);

            if (!empty($timeSlots)) {
                foreach ($timeSlots as $key => $slot) {
                    $slotData['tslot_day'][$slot['tslot_day']] = $slot['tslot_day'];
                    $slotData['tslot_from_time'][$slot['tslot_day']][] = $slot['tslot_from_time'];
                    $slotData['tslot_to_time'][$slot['tslot_day']][] = $slot['tslot_to_time'];
                }
            }
        }
        $this->set('recordId', $addressId);
        $this->set('availability', $availability);
        $this->set('addressId', $addressId);
        $this->set('frm', $frm);
        $this->set('stateId', $stateId);
        $this->set('langId', $langId);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('slotData', $slotData);
        $this->_template->render(false, false);
    }

    public function setup() {
        $this->objPrivilege->canEditPickupAddresses();
        $post = FatApp::getPostedData();
        $availability = FatApp::getPostedData('tslot_availability', FatUtility::VAR_INT, 1);
        $addrStateId = FatUtility::int($post['addr_state_id']);
        $slotDays = isset($post['tslot_day']) ? $post['tslot_day'] : array();
        $slotFromTime = $post['tslot_from_time'];
        $slotToTime = $post['tslot_to_time'];

        $frm = $this->getForm($post['addr_id'], $post['lang_id']);
        $postedData = $frm->getFormDataFromArray($post);
        if (false === $postedData) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }
        if ($availability == TimeSlot::DAY_ALL_DAYS && !isset($slotFromTime[TimeSlot::DAY_SUNDAY])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $addressId = $post['addr_id'];
        unset($post['addr_id']);

        $address = new Address($addressId);
        $data = $post;
        $data['addr_state_id'] = $addrStateId;
        $data['addr_lang_id'] = $post['lang_id'];
        $data['addr_type'] = Address::TYPE_ADMIN_PICKUP;
        $address->assignValues($data);
        if (!$address->save()) {
            LibHelper::exitWithError($address->getError(), true);
        }

        $updatedAddressId = $address->getMainTableRecordId();
        if (!FatApp::getDb()->deleteRecords(TimeSlot::DB_TBL, array('smt' => 'tslot_type = ? and tslot_record_id = ?', 'vals' => array(Address::TYPE_ADMIN_PICKUP, $updatedAddressId)))) {
            LibHelper::exitWithError(FatApp::getDb()->getError(), true);
        }

        if (!empty($slotDays) && $availability == TimeSlot::DAY_INDIVIDUAL_DAYS) {
            foreach ($slotDays as $day) {
                foreach ($slotFromTime[$day] as $key => $fromTime) {
                    if (!empty($fromTime) && !empty($slotToTime[$day][$key])) {
                        $slotData['tslot_type'] = Address::TYPE_ADMIN_PICKUP;
                        $slotData['tslot_availability'] = $availability;
                        $slotData['tslot_record_id'] = $updatedAddressId;
                        $slotData['tslot_day'] = $day;
                        $slotData['tslot_from_time'] = $fromTime;
                        $slotData['tslot_to_time'] = $post['tslot_to_time'][$day][$key];
                        $timeSlot = new TimeSlot();
                        $timeSlot->assignValues($slotData);
                        if (!$timeSlot->save()) {
                            LibHelper::exitWithError($timeSlot->getError(), true);
                        }
                    }
                }
            }
        }
        if (!empty($slotDays) && $availability == TimeSlot::DAY_ALL_DAYS) {
            $daysArr = TimeSlot::getDaysArr($this->siteLangId);
            foreach ($daysArr as $day => $label) {
                foreach ($slotFromTime[TimeSlot::DAY_SUNDAY] as $key => $fromTime) {
                    if (!empty($fromTime) && !empty($slotToTime[TimeSlot::DAY_SUNDAY][$key])) {
                        $slotData['tslot_type'] = Address::TYPE_ADMIN_PICKUP;
                        $slotData['tslot_availability'] = $availability;
                        $slotData['tslot_record_id'] = $updatedAddressId;
                        $slotData['tslot_day'] = $day;
                        $slotData['tslot_from_time'] = $fromTime;
                        $slotData['tslot_to_time'] = $post['tslot_to_time'][TimeSlot::DAY_SUNDAY][$key];
                        $timeSlot = new TimeSlot();
                        $timeSlot->assignValues($slotData);
                        if (!$timeSlot->save()) {
                            LibHelper::exitWithError($timeSlot->getError(), true);
                        }
                    }
                }
            }
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($addressId = 0, $langId) {
        $addressId = FatUtility::int($addressId);
        $frm = new Form('frmAddress');
        $frm->addHiddenField('', 'addr_id', $addressId);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $langId), 'lang_id', Language::getAllNames(), $langId, array(), '');
        $frm->addTextBox(Labels::getLabel('LBL_Address_Label', $langId), 'addr_title');
        $frm->addRequiredField(Labels::getLabel('LBL_Name', $langId), 'addr_name');
        $frm->addRequiredField(Labels::getLabel('LBL_Address_Line1', $langId), 'addr_address1');
        $frm->addTextBox(Labels::getLabel('LBL_Address_Line2', $langId), 'addr_address2');

        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($langId);
        $frm->addSelectBox(Labels::getLabel('LBL_Country', $langId), 'addr_country_id', $countriesArr, '', array(), Labels::getLabel('LBL_Select', $this->siteLangId))->requirement->setRequired(true);

        $frm->addSelectBox(Labels::getLabel('LBL_State', $langId), 'addr_state_id', array(), '', array(), Labels::getLabel('LBL_Select', $this->siteLangId))->requirement->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('LBL_City', $langId), 'addr_city');

        $zipFld = $frm->addRequiredField(Labels::getLabel('LBL_Postalcode', $langId), 'addr_zip');
        $frm->addHiddenField('', 'addr_phone_dcode');
        $phnFld = $frm->addRequiredField(Labels::getLabel('LBL_Phone', $langId), 'addr_phone', '', array('class' => 'phoneJs ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
        $phnFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
        $phnFld->requirements()->setCustomErrorMessage(Labels::getLabel('LBL_Please_enter_valid_phone_number_format.', $langId));

        $slotTimingsTypeArr = TimeSlot::getSlotTypeArr($this->siteLangId);
        $frm->addRadioButtons(Labels::getLabel('LBL_Slot_Timings', $this->siteLangId), 'tslot_availability', $slotTimingsTypeArr, TimeSlot::DAY_INDIVIDUAL_DAYS);

        $daysArr = TimeSlot::getDaysArr($this->siteLangId);
        for ($i = 0; $i < count($daysArr); $i++) {
            $frm->addCheckBox($daysArr[$i], 'tslot_day[' . $i . ']', $i, array(), false);
            $frm->addSelectBox(Labels::getLabel('LBL_From', $this->siteLangId), 'tslot_from_time[' . $i . '][]', TimeSlot::getTimeSlotsArr(), '', array(), Labels::getLabel('LBL_Select', $this->siteLangId));
            $frm->addSelectBox(Labels::getLabel('LBL_To', $this->siteLangId), 'tslot_to_time[' . $i . '][]', TimeSlot::getTimeSlotsArr(), '', array(), Labels::getLabel('LBL_Select', $this->siteLangId));
            $frm->addButton('', 'btn_add_row[' . $i . ']', '+');
        }
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        return $frm;
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditPickupAddresses($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditPickupAddresses();
        }
    }

    public function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'addr_id');
        }
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getFormColumns(): array {
        $pickupTblHeadingCols = CacheHelper::get('pickupAddressTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($pickupTblHeadingCols) {
            return json_decode($pickupTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'addr_id' => Labels::getLabel('LBL_Address', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('pickupAddressTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array {
        return [
            'listSerial',
            'addr_id',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array {
        return array_diff($fields, [], Common::excludeKeysForSort());
    }

}
