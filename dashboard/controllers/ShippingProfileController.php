<?php
class ShippingProfileController extends SellerBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->userPrivilege->canViewShippingProfiles(UserAuthentication::getLoggedUserId());
    }

    public function index()
    {
        /* Add Default Shipping If Not Created */
        ShippingProfile::getDefaultProfileId($this->userParentId);
        /* Add Default Shipping If Not Created */

        $frmSearch = $this->getSearchForm();
        $this->set('canEdit', $this->userPrivilege->canEditShippingProfiles(UserAuthentication::getLoggedUserId(), true));
        $this->set("frmSearch", $frmSearch);
        $this->set("keywordPlaceholder", Labels::getLabel('LBL_SEARCH_BY_SHIPPING_PROFILE_NAME', $this->siteLangId));
        $this->_template->render();
    }

    public function search()
    {
        $pageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $post = $searchForm->getFormDataFromArray($data);

        $prodCountSrch = ShippingProfileProduct::getSearchObject($this->siteLangId);
        $prodCountSrch->addCondition('shippro_user_id', '=', $this->userParentId);
        $prodCountSrch->doNotCalculateRecords();
        $prodCountSrch->doNotLimitRecords();
        $prodCountSrch->addGroupBy('shippro_shipprofile_id');
        $prodCountSrch->addMultipleFields(array("COUNT(*) as totalProducts, shippro_shipprofile_id"));
        $prodCountQuery = $prodCountSrch->getQuery();

        $srch = ShippingProfile::getSearchObject($this->siteLangId);
        $srch->addCondition('sprofile.shipprofile_user_id', '=', $this->userParentId);
        $srch->joinTable('(' . $prodCountQuery . ')', 'LEFT OUTER JOIN', 'sproduct.shippro_shipprofile_id = sprofile.shipprofile_id', 'sproduct');

        if (!empty($post['keyword'])) {
            $cnd =  $srch->addCondition('sprofile_l.shipprofile_name', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('sprofile.shipprofile_identifier', 'like', '%' . $post['keyword'] . '%');
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();

        $srch->addMultipleFields(array('sprofile.*', 'if(sproduct.totalProducts is null, 0, sproduct.totalProducts) as totalProducts', 'IFNULL(shipprofile_name, shipprofile_identifier) as shipprofile_name'));
        $srch->addOrder('shipprofile_default', 'DESC');
        $srch->addOrder('shipprofile_id', 'ASC');

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $zones = array();
        if (!empty($records)) {
            $profileIds = array_column($records, 'shipprofile_id');
            $profileIds = array_map('intval', $profileIds);
            $zones = $this->getZones($profileIds);
        }

        $this->set('arrListing', $records);
        $this->set('zones', $zones);
        $this->set('postedData', $post);
        $this->set('canEdit', $this->userPrivilege->canEditShippingProfiles(UserAuthentication::getLoggedUserId(), true));
        $this->_template->render(false, false);
    }

    public function form($profileId = 0)
    {
        $userId = $this->userParentId;
        $profileId = FatUtility::int($profileId);
        $frm = $this->getForm($profileId);
        $data = [];

        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        if (0 < $profileId) {
            $data = ShippingProfile::getAttributesById($profileId);
            if ($data === false) {
                Message::addErrorMessage(Labels::getLabel('LBL_INVALID_REQUEST', $this->siteLangId));
                FatApp::redirectUser(UrlHelper::generateUrl('shippingProfile'));
            }
            if ($data['shipprofile_user_id'] != $userId) {
                Message::addErrorMessage(Labels::getLabel('LBL_INVALID_REQUEST', $this->siteLangId));
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
        }

        $this->set('profile_id', $profileId);
        $this->set('frm', $frm);
        $this->set('profileData', $data);
        $this->set('canEdit', $this->userPrivilege->canEditShippingProfiles(UserAuthentication::getLoggedUserId(), true));
        $this->set('siteDefaultLangId', $siteDefaultLangId);
        $this->set('languages', Language::getAllNames());
        $this->_template->render();
    }

    public function setup()
    {
        $this->userPrivilege->canEditShippingProfiles(UserAuthentication::getLoggedUserId());
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (empty($post)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);

        $profileId = $post['shipprofile_id'];
        unset($post['shipprofile_id']);

        $post['shipprofile_identifier'] = $post['shipprofile_name'][$siteDefaultLangId] ?? '';

        $spObj = new ShippingProfile($profileId);

        $spObj->assignValues($post);

        if (!$spObj->save()) {
            FatUtility::dieJsonError($spObj->getError());
        }

        $languages = Language::getAllNames();
        foreach ($post['shipprofile_name'] as $langId => $profileName) {
            if (empty($profileName)) {
                continue;
            }
            if (!$spObj->updateLangData($langId, ['shipprofile_name' => $profileName])) {
                Message::addErrorMessage($spObj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
        }

        if (1 > $profileId) {
            $shipProZoneId = ShippingProfile::setDefaultZone(UserAuthentication::getLoggedUserId(), $spObj->getMainTableRecordId());
            ShippingProfile::setDefaultRates($shipProZoneId, $spObj->getMainTableRecordId());
        }

        $profileId = $spObj->getMainTableRecordId();

        $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->siteLangId));
        $this->set('profileId', $profileId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->userPrivilege->canEditShippingProfiles(UserAuthentication::getLoggedUserId());

        $shipprofileId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($shipprofileId < 1) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST_ID', $this->siteLangId));
        }

        $shippingProfile = ShippingProfile::getAttributesById($shipprofileId);
        if (false == $shippingProfile) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $whr = array('smt' => 'shipprofile_id = ? and shipprofile_default != ? and shipprofile_user_id = ?', 'vals' => array($shipprofileId, applicationConstants::YES, $this->userParentId));
        if (!FatApp::getDb()->deleteRecords(ShippingProfile::DB_TBL, $whr)) {
            FatUtility::dieJsonError(FatApp::getDb()->getError());
        }

        $shippingProfData = ShippingProfileZone::getAttributesByProfileId($shipprofileId);
        if (false == $shippingProfData) {
            $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->siteLangId));
            $this->_template->render(false, false, 'json-success.php');
        }

        $shipprozoneId = $shippingProfData['shipprozone_id'];

        $shippingProfileZone = new ShippingProfileZone($shipprozoneId);
        if (!$shippingProfileZone->deleteRecord()) {
            FatUtility::dieJsonError($shippingProfileZone->getError());
        }

        $shippingProfileZone = new ShippingZone($shippingProfData['shipprozone_shipzone_id']);
        if (!$shippingProfileZone->deleteRates($shipprozoneId)) {
            FatUtility::dieJsonError($shippingProfileZone->getError());
        }

        if (!$shippingProfileZone->deleteLocations($shippingProfData['shipprozone_shipzone_id'])) {
            FatUtility::dieJsonError($shippingProfileZone->getError());
        }

        if (!$shippingProfileZone->deleteRecord()) {
            FatUtility::dieJsonError($shippingProfileZone->getError());
        }

        $defaultShipProfileId = ShippingProfile::getDefaultProfileId($this->userParentId);
        if (0 < $defaultShipProfileId) {
            $data = [
                'shippro_shipprofile_id' => $defaultShipProfileId
            ];
            $whr = array('smt' => 'shippro_shipprofile_id = ? and shippro_user_id = ?', 'vals' => array($shipprofileId, $this->userParentId));
            FatApp::getDb()->updateFromArray(ShippingProfileProduct::DB_TBL, $data, $whr);
        }

        $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getZones($profileIds)
    {
        if (empty($profileIds)) {
            return array();
        }
        $zSrch = ShippingProfileZone::getSearchObject();
        $zSrch->addCondition("shipprozone_shipprofile_id", "IN", $profileIds);
        $zSrch->doNotCalculateRecords();
        $zRs = $zSrch->getResultSet();
        $zonesData = FatApp::getDb()->fetchAll($zRs);
        $zones = array();
        if (!empty($zonesData)) {
            foreach ($zonesData as $zone) {
                $profileId = $zone['shipprozone_shipprofile_id'];
                $zones[$profileId][] = $zone;
            }
        }
        return $zones;
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'total_record_count', '');
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->siteLangId), 'keyword', '', array('placeholder' => Labels::getLabel('LBL_Keyword', $this->siteLangId)));

        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    private function getForm($profileId = 0)
    {
        $userId = $this->userParentId;
        $profileId = FatUtility::int($profileId);
        $frm = new Form('frmShippingProfile');
        $frm->addHiddenField('', 'shipprofile_id', $profileId);
        $frm->addHiddenField('', 'shipprofile_user_id', $userId);
        $languages = Language::getAllNames();
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        foreach ($languages as $langId => $langName) {
            if ($langId == $siteDefaultLangId) {
                $fld = $frm->addRequiredField(Labels::getLabel('FRM_PROFILE_NAME', $this->siteLangId) . " " . $langName, 'shipprofile_name[' . $langId . ']', '', ['placeholder' => Labels::getLabel('FRM_PROFILE_NAME', $this->siteLangId)]);
            } else {
                $fld = $frm->addTextBox(Labels::getLabel('FRM_PROFILE_NAME', $this->siteLangId) . " " . $langName, 'shipprofile_name[' . $langId . ']', '', ['placeholder' => Labels::getLabel('FRM_PROFILE_NAME', $this->siteLangId)]);
            }
        }
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    public function getBreadcrumbNodes($action)
    {
        if (FatUtility::isAjaxCall()) {
            return;
        }

        $className = get_class($this);
        $arr = explode('-', FatUtility::camel2dashed($className));
        array_pop($arr);
        $className = ucwords(implode('_', $arr));

        if ($action == 'index') {
            $this->nodes[] = array('title' => ucwords(Labels::getLabel('BCN_' . $className)));
        } else if ($action == 'form') {
            $action = str_replace('-', ' _', FatUtility::camel2dashed($action));
            $this->nodes[] = array('title' => Labels::getLabel('LBL_SHIPPING_PROFILE'), 'href' => UrlHelper::generateUrl("ShippingProfile"));
            $this->nodes[] = array('title' => ucwords(Labels::getLabel('BCN_' . $action)));
        } else {
            $action = str_replace('-', '_', FatUtility::camel2dashed($action));
            $this->nodes[] = array('title' => ucwords(Labels::getLabel('BCN_' . $action)));
        }
        return $this->nodes;
    }
}
