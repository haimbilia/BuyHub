<?php

class ShippingProfileController extends ListingBaseController
{

    protected $modelClass = 'ShippingProfile';
    protected $pageKey = 'MANAGE_SHIPPING_PROFILE';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewShippingManagement();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj), [
            'newRecordBtnAttrs' => [
                'attr' => [
                    'href' => UrlHelper::generateUrl('shippingProfile', 'form'),
                    'onclick' => '',
                ]
            ]
        ]);
        $this->_template->addJs('shipping-profile/page-js/index.js');
        $this->set('actionItemsData', $actionItemsData);
        $this->set('canEdit', $this->objPrivilege->canEditShippingManagement($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set("keywordPlaceholder", Labels::getLabel('LBL_SEARCH_BY_SHIPPING_PROFILE_NAME', $this->siteLangId));
        $this->getListingData();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'shipping-profile/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
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
        $prodCountSrch->addMultipleFields(array("COUNT(1) as totalProducts, shippro_shipprofile_id"));
        $prodCountQuery = $prodCountSrch->getQuery();

        $srch = ShippingProfile::getSearchObject($this->siteLangId);
        $srch->addCondition('sprofile.shipprofile_user_id', '=', 0); /* only admin added profiles */
        $srch->joinTable('(' . $prodCountQuery . ')', 'LEFT OUTER JOIN', 'sproduct.shippro_shipprofile_id = sprofile.shipprofile_id', 'sproduct');
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('sprofile_l.shipprofile_name', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('sprofile.shipprofile_identifier', 'like', '%' . $post['keyword'] . '%');
        }

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();

        $srch->addMultipleFields(array('sprofile.*', 'if(sproduct.totalProducts is null, 0, sproduct.totalProducts) as totalProducts', 'IFNULL(shipprofile_name, shipprofile_identifier) as shipprofile_name'));
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        if (!empty($records)) {
            $zones = (new ShippingProfile())->getZones(array_map('intval', array_column($records, 'shipprofile_id')));
        }
        $this->set("arrListing", $records);
        $this->set("zones", $zones ?? []);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditBrands($this->admin_id, true));
    }

    public function form($profileId = 0)
    {
        $this->objPrivilege->canEditShippingManagement();
        $profileId = FatUtility::int($profileId);
        $frm = $this->getForm($profileId);
       
        $productCount = 0;
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        if (1 > $langId) {
            $langId = CommonHelper::getDefaultFormLangId();
        }

        $data = ['lang_id' => $langId];

        $pageTitle = Labels::getLabel('LBL_SHIPPING_PROFILE_FORM', $this->siteLangId);
        if (0 < $profileId) {
            $data = ShippingProfile::getAttributesByLangId($langId, $profileId, ['shipprofile_user_id', 'shipprofile_name', 'shipprofile_identifier', 'shipprofile_default'], applicationConstants::JOIN_RIGHT);
            if (empty($data)) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }

            if ($data['shipprofile_user_id'] != 0) {
                Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
                FatApp::redirectUser(UrlHelper::generateUrl('shippingProfile'));
            }

            $name = !empty($data['shipprofile_name']) ? $data['shipprofile_name'] : $data['shipprofile_identifier'];
            $str  = Labels::getLabel('LBL_{PROFILE-NAME}_PROFILE_FORM', $this->siteLangId);
            $pageTitle = CommonHelper::replaceStringData($str, ['{PROFILE-NAME}' => $name]);
           
            $data['lang_id'] = $langId;
            $prodCountSrch = new SearchBase(ShippingProfileProduct::DB_TBL, 'selsppro');
            $prodCountSrch->doNotCalculateRecords();
            $prodCountSrch->doNotLimitRecords();
            $prodCountSrch->addCondition('shippro_shipprofile_id', '=', $profileId);
            $rs = $prodCountSrch->getResultSet();
            $productCount = FatApp::getDb()->totalRecords($rs);
        }

        $frm->fill($data);

        $this->set('langId', $langId);
        $this->set('pageTitle', $pageTitle);
        $this->set('profile_id', $profileId);
        $this->set('profileData', $data);
        $this->set('productCount', $productCount);
        $this->set('frm', $frm);
        $this->set('siteDefaultLangId', CommonHelper::getDefaultFormLangId());
        $this->set('languages', Language::getAllNames());

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render();
    }

    public function profileNameForm()
    {
        $this->objPrivilege->canEditShippingManagement();
        $profileId = FatApp::getPostedData('shipprofile_id', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($profileId);
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        if (0 < $profileId) {
            $data = ShippingProfile::getAttributesByLangId($langId, $profileId, ['shipprofile_user_id', 'shipprofile_name', 'shipprofile_identifier'], applicationConstants::JOIN_RIGHT);
            if (empty($data)) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }

            if ($langId == $this->siteLangId) {
                $data['shipprofile_name'] = empty($data['shipprofile_name']) ? $data['shipprofile_identifier'] : $data['shipprofile_name'];
            }

            if ($data['shipprofile_user_id'] != 0) {
                Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
                FatApp::redirectUser(UrlHelper::generateUrl('shippingProfile'));
            }

            $autoFillLangData = FatApp::getPostedData('autoFillLangData', FatUtility::VAR_INT, 0);
            if (0 < $autoFillLangData) {
                $updateLangDataobj = new TranslateLangData(ShippingProfile::DB_TBL_LANG);
                $translatedData = $updateLangDataobj->getTranslatedData($profileId, $langId, CommonHelper::getDefaultFormLangId());
                if (false === $translatedData) {
                    LibHelper::exitWithError($updateLangDataobj->getError(), true);
                }
                $langData = current($translatedData);
                if (!empty($langData)) {
                    $data['shipprofile_name'] = $langData['shipprofile_name'];
                }
            }

            $frm->fill($data);
        }
        $this->set('langId', $langId);
        $this->set('siteDefaultLangId', CommonHelper::getDefaultFormLangId());
        $this->set('profile_id', $profileId);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditShippingManagement();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (empty($post)) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId), true);
        }
        $profileId = $post['shipprofile_id'];
        unset($post['shipprofile_id']);
        $siteDefaultLangId = CommonHelper::getDefaultFormLangId();
        if ($post['lang_id'] == $siteDefaultLangId) {
            $post['shipprofile_identifier'] = $post['shipprofile_name'];
        }

        $spObj = new ShippingProfile($profileId);
        $spObj->assignValues($post);
        if (!$spObj->save()) {
            $msg = $spObj->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }

        if (!$spObj->updateLangData($post['lang_id'], ['shipprofile_name' => $post['shipprofile_name']])) {
            LibHelper::exitWithError($spObj->getError(), true);
        }

        if (1 > $profileId) {
            $shipProZoneId = ShippingProfile::setDefaultZone(AdminAuthentication::getLoggedAdminId(), $spObj->getMainTableRecordId());
            ShippingProfile::setDefaultRates($shipProZoneId, $spObj->getMainTableRecordId());
        }

        $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->siteLangId));
        $this->set('profileId', $spObj->getMainTableRecordId());
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditShippingManagement();

        $shipprofileId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($shipprofileId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
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

    private function getForm($profileId = 0)
    {
        $profileId = FatUtility::int($profileId);
        $frm = new Form('frmShippingProfile', array('id' => 'frmShippingProfile'));
        $frm->addHiddenField('', 'shipprofile_id', $profileId);
        $frm->addHiddenField('', 'shipprofile_user_id', 0);
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        if (0 < $profileId) {
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList(), '', [], '');
        } else {
            $fld = $frm->addHiddenField('', 'lang_id', $siteDefaultLangId);
            $fld->requirements()->setRequired();
        }
        $frm->addRequiredField(Labels::getLabel('FRM_PROFILE_NAME', $this->siteLangId), 'shipprofile_name');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE', $this->siteLangId));
        return $frm;
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', ['sdsd' => 'dsasdsd']);
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'shippack_name');
        }
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $shippingProfileCols = CacheHelper::get('shippingProfileTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shippingProfileCols) {
            return json_decode($shippingProfileCols, true);
        }
        $arr = [
           /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'shipprofile_name' => Labels::getLabel('LBL_NAME', $this->siteLangId),
            'totalProducts' => Labels::getLabel('LBL_PRODUCTS', $this->siteLangId),
            'rates' => Labels::getLabel('LBL_RATES_FOR', $this->siteLangId),
            'action' => '',
        ];
        CacheHelper::create('shippingProfileTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'shipprofile_name',
            'totalProducts',
            'rates',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['shippack_units', 'rates'], Common::excludeKeysForSort());
    }
}
