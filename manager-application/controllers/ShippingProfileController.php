<?php

class ShippingProfileController extends ListingBaseController {

    protected $modelClass = 'ShippingProfile';
    protected $pageKey = 'MANAGE_SHIPPING_PROFILE';

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewShippingManagement();
    }

    public function index() {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj), [
            'newRecordBtnAttrs' => ['attr' => [
                    'href' => UrlHelper::generateUrl('shippingProfile', 'form'),
                    'onclick' => '',
                    'title' => Labels::getLabel('LBL_ADD_NEW', $this->siteLangId)
                ]
            ]
        ]);
        $this->_template->addJs('shipping-profile/page-js/index.js');
        $this->set('actionItemsData', $actionItemsData);
        $this->set('canEdit', $this->objPrivilege->canEditShippingManagement($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->getListingData();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'shipping-profile/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData() {
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
        $prodCountSrch = ShippingProfileProduct::getSearchObject();
        $prodCountSrch->doNotCalculateRecords();
        $prodCountSrch->doNotLimitRecords();
        $prodCountSrch->addGroupBy('shippro_shipprofile_id');
        $prodCountSrch->addMultipleFields(array("COUNT(*) as totalProducts, shippro_shipprofile_id"));
        $prodCountQuery = $prodCountSrch->getQuery();

        $srch = ShippingProfile::getSearchObject($this->siteLangId);
        $srch->addCondition('sprofile.shipprofile_user_id', '=', 0); /* only admin added profiles */
        $srch->joinTable('(' . $prodCountQuery . ')', 'LEFT OUTER JOIN', 'sproduct.shippro_shipprofile_id = sprofile.shipprofile_id', 'sproduct');

        $srch->addMultipleFields(array('sprofile.*', 'if(sproduct.totalProducts is null, 0, sproduct.totalProducts) as totalProducts', 'IFNULL(shipprofile_name, shipprofile_identifier) as shipprofile_name'));

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('sprofile_l.shipprofile_name', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('sprofile.shipprofile_identifier', 'like', '%' . $post['keyword'] . '%');
        }
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        if (!empty($records)) {
            $zones = (new ShippingProfile())->getZones(array_map('intval', array_column($records, 'shipprofile_id')));
        }
        $this->set("arrListing", $records);
        $this->set("zones", $zones ?? []);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditBrands($this->admin_id, true));
    }

    public function form($profileId = 0) {
        $this->objPrivilege->canEditShippingManagement();
        $profileId = FatUtility::int($profileId);
        $frm = $this->getForm($profileId);
        $data = [];
        $productCount = 0;
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        if (0 < $profileId) {
            $data = ShippingProfile::getAttributesById($profileId);
            if (empty($data)) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            if ($data['shipprofile_user_id'] != 0) {
                Message::addErrorMessage(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
                FatApp::redirectUser(UrlHelper::generateUrl('shippingProfile'));
            }

            $spObj = new ShippingProfile();
            foreach (Language::getAllNames() as $langId => $langName) {
                $profileName = $spObj->getAttributesByLangId($langId, $profileId, 'shipprofile_name');
                if (!empty($profileName)) {
                    $data['shipprofile_name'][$langId] = $profileName;
                }
            }
            if (empty($data['shipprofile_name'][$siteDefaultLangId])) {
                $data['shipprofile_name'][$siteDefaultLangId] = $data['shipprofile_identifier'];
            }

            $frm->fill($data);
            $prodCountSrch = new SearchBase(ShippingProfileProduct::DB_TBL, 'selsppro');
            $prodCountSrch->doNotCalculateRecords();
            $prodCountSrch->doNotLimitRecords();
            $prodCountSrch->addCondition('shippro_shipprofile_id', '=', $profileId);
            $rs = $prodCountSrch->getResultSet();
            $productCount = FatApp::getDb()->totalRecords($rs);
        }
        $this->set('profile_id', $profileId);
        $this->set('profileData', $data);
        $this->set('productCount', $productCount);
        $this->set('frm', $frm);
        $this->set('siteDefaultLangId', $siteDefaultLangId);
        $this->set('languages', Language::getAllNames());
        $this->_template->render();
    }

    public function setup() {
        $this->objPrivilege->canEditShippingManagement();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (empty($post)) {
            FatUtility::exitWithError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId), true);
        }
        $profileId = $post['shipprofile_id'];
        unset($post['shipprofile_id']);
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $post['shipprofile_identifier'] = $post['shipprofile_name'][$siteDefaultLangId] ?? '';
        $spObj = new ShippingProfile($profileId);
        $spObj->assignValues($post);
        if (!$spObj->save()) {
            LibHelper::exitWithError($spObj->getError(), true);
        }

        $languages = Language::getAllNames();
        foreach ($post['shipprofile_name'] as $langId => $profileName) {
            if (empty($profileName)) {
                continue;
            }
            if (!$spObj->updateLangData($langId, ['shipprofile_name' => $profileName])) {
                LibHelper::exitWithError($spObj->getError(), true);
            }
        }

        if (1 > $profileId) {
            $shipProZoneId = ShippingProfile::setDefaultZone(AdminAuthentication::getLoggedAdminId(), $spObj->getMainTableRecordId());
            ShippingProfile::setDefaultRates($shipProZoneId, $spObj->getMainTableRecordId());
        }

        $this->set('msg', Labels::getLabel('LBL_Updated_Successfully', $this->siteLangId));
        $this->set('profileId', $spObj->getMainTableRecordId());
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord() {
        $this->objPrivilege->canEditShippingManagement();

        $shipprofileId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($shipprofileId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id,true);   
        }

        $shippingProfile = ShippingProfile::getAttributesById($shipprofileId);
        if (false == $shippingProfile) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $whr = array('smt' => 'shipprofile_id = ? and shipprofile_default != ?', 'vals' => array($shipprofileId, applicationConstants::YES));
        if (!FatApp::getDb()->deleteRecords(ShippingProfile::DB_TBL, $whr)) {
            LibHelper::exitWithError(FatApp::getDb()->getError(), true);
        }

        $shippingProfData = ShippingProfileZone::getAttributesByProfileId($shipprofileId);
        if (false == $shippingProfData) {
            $this->set('msg', Labels::getLabel('MSG_DELETE_SUCCESSFULLY', $this->siteLangId));
            $this->_template->render(false, false, 'json-success.php');
        }

        $shipprozoneId = $shippingProfData['shipprozone_id'];

        $shippingProfileZone = new ShippingProfileZone($shipprozoneId);
        if (!$shippingProfileZone->deleteRecord()) {
            LibHelper::exitWithError($shippingProfileZone->getError(), true);
        }

        $shippingProfileZone = new ShippingZone($shippingProfData['shipprozone_shipzone_id']);
        if (!$shippingProfileZone->deleteRates($shipprozoneId)) {
            LibHelper::exitWithError($shippingProfileZone->getError(), true);
        }

        if (!$shippingProfileZone->deleteLocations($shippingProfData['shipprozone_shipzone_id'])) {
            LibHelper::exitWithError($shippingProfileZone->getError(), true);
        }

        if (!$shippingProfileZone->deleteRecord()) {
            LibHelper::exitWithError($shippingProfileZone->getError(), true);
        }

        $defaultShipProfileId = ShippingProfile::getDefaultProfileId(0);
        if (0 < $defaultShipProfileId) {
            $data = [
                'shippro_shipprofile_id' => $defaultShipProfileId
            ];
            $whr = array('smt' => 'shippro_shipprofile_id = ? and shippro_user_id = ?', 'vals' => array($shipprofileId, 0));
            FatApp::getDb()->updateFromArray(ShippingProfileProduct::DB_TBL, $data, $whr);
        }

        $this->set('msg', Labels::getLabel('MSG_DELETE_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($profileId = 0) {
        $profileId = FatUtility::int($profileId);
        $frm = new Form('frmShippingProfile');
        $frm->addHiddenField('', 'shipprofile_id', $profileId);
        $frm->addHiddenField('', 'shipprofile_user_id', 0);
        $languages = Language::getAllNames();
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);

        foreach ($languages as $langId => $langName) {
            if ($langId == $siteDefaultLangId) {
                $frm->addRequiredField(Labels::getLabel('FRM_PROFILE_NAME', $this->siteLangId), 'shipprofile_name[' . $langId . ']');
            } else {
                $frm->addTextBox(Labels::getLabel('FRM_PROFILE_NAME', $this->siteLangId) . ' ' . $langName, 'shipprofile_name[' . $langId . ']');
            }
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('FRM_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    protected function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'shippack_name');
        }
        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    protected function getFormColumns(): array {
        $shippingProfileCols = CacheHelper::get('shippingProfileTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shippingProfileCols) {
            return json_decode($shippingProfileCols);
        }
        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'shipprofile_name' => Labels::getLabel('LBL_NAME', $this->siteLangId),
            'totalProducts' => Labels::getLabel('LBL_PRODUCTS', $this->siteLangId),
            'rates' => Labels::getLabel('LBL_RATES_FOR', $this->siteLangId),
            'action' => '',
        ];
        CacheHelper::create('shippingProfileTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array {
        return [
            'listSerial',
            'shipprofile_name',
            'totalProducts',
            'rates',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['shippack_units', 'rates'], Common::excludeKeysForSort());
    }

}
