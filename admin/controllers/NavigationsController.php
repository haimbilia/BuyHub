<?php
class NavigationsController extends ListingBaseController
{
    protected string $modelClass = 'Navigations';
    protected string $pageKey = 'MANAGE_NAVIGATIONS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewNavigationManagement();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditNavigationManagement($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditNavigationManagement();
        }
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->checkEditPrivilege();
        $this->setModel($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_NAVIGATION_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        
        $this->getListingData();
        
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('tourStep', SiteTourHelper::getStepIndex());
        $this->_template->addJs(['js/jquery-sortable-lists.js']);
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getListingData()
    {
        $this->checkEditPrivilege(true);
        $srch = Navigations::getSearchObject($this->siteLangId, false);

        $qry = '';
        if (FatApp::getConfig('CONF_LAYOUT_MEGA_MENU', FatUtility::VAR_INT, 1) == applicationConstants::YES) {
            $qry = ' AND lnk.' . NavigationLinks::DB_TBL_PREFIX . 'category_id = 0';
        }

        $srch->joinTable(
            NavigationLinks::DB_TBL,
            'LEFT JOIN',
            'lnk.' . NavigationLinks::DB_TBL_PREFIX . 'nav_id = nav.' . Navigations::tblFld('id') . $qry, 'lnk'
        );


        $srch->addMultipleFields([
            'nav.*',
            'navlang_lang_id',
            'COALESCE(nav_name, nav_identifier) as nav_name',
            'COUNT(nlink_id) as nlink_count'
        ]);

        $srch->addOrder('nav_active', 'DESC');
        $srch->addOrder('nav_id', 'DESC');
        $srch->addGroupBy('nav.nav_id');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("arrListing", $records);
        $this->set('canView', $this->objPrivilege->canViewNavigationManagement($this->admin_id, true));
    }

    public function navLinks()
    {
        $this->checkEditPrivilege(true);
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $includeWrapper = FatApp::getPostedData('includeWrapper', FatUtility::VAR_INT, applicationConstants::YES);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $records = $this->getNavLinks();
        $this->set("includeWrapper", $includeWrapper);
        $this->set("arrListing", $records);
        $this->set("navId", $recordId);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getNavLinks(): array
    {
        $srch = new NavigationLinkSearch($this->siteLangId);
        $srch->joinNavigation();
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(
            array(
                'nlink_id', 'nlink_nav_id', 'nlink_cpage_id', 'nlink_target', 'nlink_type', 'nlink_parent_id', 'COALESCE(nlink_caption, nlink_identifier) as nlink_caption'
            )
        );

        if (FatApp::getConfig('CONF_LAYOUT_MEGA_MENU', FatUtility::VAR_INT, 1) == applicationConstants::YES) {
            $srch->addCondition('nlink_category_id', '=', 0);
        }
        
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 < $recordId) {
            $srch->addCondition('nlink_nav_id', '=', $recordId);
        }
        
        $nlinkId = FatApp::getPostedData('nlinkId', FatUtility::VAR_INT, 0);
        if (0 < $nlinkId) {
            $srch->addCondition('nlink_id', '=', $nlinkId);
        }

        $srch->addOrder('nlink_display_order', 'asc');
        return FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    public function form()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $data = Navigations::getAttributesByLangId($this->siteLangId, $recordId, ['*','IFNULL(nav_name,nav_identifier) as nav_name'], applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request_id, true);
            }           
            $frm->fill($data);
        }

        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_NAVIGATION_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, '_partial/listing/form.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditNavigationManagement();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['nav_id'];
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $validateIdentifier = Navigations::getAttributesByIdentifier($post['nav_name'], 'nav_id');
        if (0 < $validateIdentifier && $recordId != $validateIdentifier) {
            LibHelper::exitWithError(Labels::getLabel('ERR_NAVIGATION_WITH_SAME_NAME_ALREADY_EXISTS', $this->siteLangId), true);
        }

        $data = Navigations::getAttributesById($recordId, array('nav_id', 'nav_identifier'));
        if ($data === false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $record = new Navigations($recordId);
        $post['nav_identifier'] = $post['nav_name'];
        $record->assignValues($post);
        if (!$record->save()) {
            $msg = $record->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }       

        if (!$record->updateLangData(CommonHelper::getDefaultFormLangId(), [$record::tblFld('name') => $post[$record::tblFld('name')]])) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Navigations::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        CacheHelper::clear(CacheHelper::TYPE_NAVIGATION);

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm()
    {
        $frm = new Form('frmNavigation');
        $frm->addHiddenField('', 'nav_id', 0);
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_NAME', $this->siteLangId), 'nav_name');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'nav_active', $activeInactiveArr, '', array(), '');
        
        $languageArr = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 0 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $langId = FatUtility::int($langId);
        $langId = 1 > $langId ? $this->siteLangId : $langId;

        $frm = new Form('frmNavigationLang');
        $frm->addHiddenField('', 'nav_id', $recordId);

        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
       
        $frm->addRequiredField(Labels::getLabel('FRM_TITLE', $langId), 'nav_name');
        return $frm;
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditZones();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $navObj = new Navigations($recordId);
        if (!$navObj->changeStatus($status)) {
            LibHelper::exitWithError($navObj->getError(), true);
        }
        CacheHelper::clear(CacheHelper::TYPE_NAVIGATION);
        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_STATUS_UPDATED', $this->siteLangId));
    }

    public function linkForm()
    {
        $this->objPrivilege->canEditNavigationManagement();
        $navId = FatApp::getPostedData('nav_id', FatUtility::VAR_INT, 0);
        $nlinkId = FatApp::getPostedData('nlink_id', FatUtility::VAR_INT, 0);
        if (!$navId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm = $this->getLinksForm();
        if (!$nlinkId) {
            $frm->fill(array('nlink_nav_id' => $navId, 'nlink_id' => $nlinkId));
        } else {
            $srch = new NavigationLinkSearch($this->siteLangId);
            $srch->joinNavigation();
            $srch->setPageSize(1);
            $srch->doNotCalculateRecords();
            $srch->addCondition('nlink_id', '=', $nlinkId);
            $rs = $srch->getResultSet();
            $nlinkRow = FatApp::getDb()->fetch($rs);          
            $nlinkRow['nlink_caption'] = $nlinkRow['nlink_caption'] ?? $nlinkRow['nlink_identifier'];
            $frm->fill($nlinkRow);
        }
        $this->set('nav_id', $navId);
        $this->set('nlink_id', $nlinkId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_NAVIGATION_LINK_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setupLink()
    {
        $this->objPrivilege->canEditNavigationManagement();

        $frm = $this->getLinksForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $nlink_nav_id = FatUtility::int($post['nlink_nav_id']);
        $nlinkId = FatUtility::int($post['nlink_id']);
        unset($post['nlink_id']);

        if (1 > $nlink_nav_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $db = FatApp::getDb();

        $srch = Navigations::getSearchObject($this->siteLangId, false);
        $srch->addCondition('nav_id', '=', $nlink_nav_id);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $navRow = $db->fetch($rs);
        if (!$navRow) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $post['nlink_category_id'] = FatApp::getPostedData('nlink_category_id', FatUtility::VAR_INT, 0);
        $post['nlink_cpage_id'] = FatApp::getPostedData('nlink_cpage_id', FatUtility::VAR_INT, 0);

        if ($post['nlink_type'] == NavigationLinks::NAVLINK_TYPE_CMS) {
            $post['nlink_url'] = '';
            $post['nlink_category_id'] = 0;
        }
        if ($post['nlink_type'] == NavigationLinks::NAVLINK_TYPE_EXTERNAL_PAGE) {
            $post['nlink_cpage_id'] = 0;
            $post['nlink_category_id'] = 0;
        }
        if ($post['nlink_type'] == NavigationLinks::NAVLINK_TYPE_CATEGORY_PAGE) {
            $post['nlink_url'] = '';
            $post['nlink_cpage_id'] = 0;
        }
        $post['nlink_identifier'] = $post['nlink_caption'];

        $navLinkObj = new NavigationLinks($nlinkId);
        $navLinkObj->assignValues($post);
        if (!$navLinkObj->save()) {
            $msg = $navLinkObj->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }

        $nlinkId = $navLinkObj->getMainTableRecordId();
        $this->setLangData($navLinkObj, [
            $navLinkObj::tblFld('caption') => $post[$navLinkObj::tblFld('caption')]
        ]);

        $srch = new NavigationLinkSearch($this->siteLangId);
        $srch->doNotLimitRecords();
        $srch->addFld('nlink_id');
        if (FatApp::getConfig('CONF_LAYOUT_MEGA_MENU', FatUtility::VAR_INT, 1) == applicationConstants::YES) {
            $srch->addCondition('nlink_category_id', '=', 0);
        }
        $srch->addCondition('nlink_nav_id', '=', $nlink_nav_id);
        $srch->getResultSet();
        CacheHelper::clear(CacheHelper::TYPE_NAVIGATION);
        $this->set('navId', $nlink_nav_id);
        $this->set('nlinkId', $nlinkId);
        $this->set('subRecordsCount', $srch->recordCount());
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function linkLangForm($autoFillLangData = 0)
    {
        $post = FatApp::getPostedData();
        $navId = FatUtility::int($post['nav_id']);
        $nlinkId = FatUtility::int($post['nlink_id']);
        $langId = FatUtility::int($post['langId']);
        if (1 > $navId || 1 > $langId || 1 > $nlinkId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $dbNavId = NavigationLinks::getAttributesById($nlinkId, 'nlink_nav_id');
        if ($dbNavId != $navId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $langFrm = $this->getLinksLangForm($langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(NavigationLinks::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($nlinkId, $langId, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = NavigationLinks::getAttributesByLangId($langId, $nlinkId);
        }

        if ($langData) {
            $langData['nlink_id'] = $langData['nlinklang_nlink_id'];
            $langData['nav_id'] = $navId;
            $langFrm->fill($langData);
        } else {
            $langFrm->fill(array('lang_id' => $langId, 'nav_id' => $navId, 'nlink_id' => $nlinkId));
        }

        $this->set('languages', Language::getAllNames());
        $this->set('nav_id', $navId);
        $this->set('nlink_id', $nlinkId);
        $this->set('nav_lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('formTitle', Labels::getLabel('LBL_NAVIGATION_LINK_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setupLinksLang()
    {
        $this->objPrivilege->canEditNavigationManagement();
        $post = FatApp::getPostedData();

        $nlinkId = FatUtility::int($post['nlink_id']);
        $lang_id = $post['lang_id'];

        if ($nlinkId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLinksLangForm($lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['nlink_id']);
        unset($post['lang_id']);

        $data = array(
            'nlinklang_nlink_id' => $nlinkId,
            'nlinklang_lang_id' => $lang_id,
            'nlink_caption' => $post['nlink_caption'],
        );

        $navLinkObj = new NavigationLinks($nlinkId);
        if (!$navLinkObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($navLinkObj->getError(), true);
        }

        $newTabLangId = 0;
        if ($nlinkId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = NavigationLinks::getAttributesByLangId($langId, $nlinkId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $nlinkId = $navLinkObj->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        CacheHelper::clear(CacheHelper::TYPE_NAVIGATION);
        $this->set('langId', $newTabLangId);
        $this->set('nlinkId', $nlinkId);
        $this->set('msg', $this->str_update_record);

        $this->_template->render(false, false, 'json-success.php');
    }

    private function getLinksForm()
    {
        $frm = new Form('frmNavigationLink');
        $frm->addHiddenField('', 'nlink_nav_id');
        $frm->addHiddenField('', 'nlink_id');
        $frm->addRequiredField(Labels::getLabel('FRM_CAPTION', $this->siteLangId), 'nlink_caption');
        $linkTypes = NavigationLinks::getLinkTypeArr($this->siteLangId);
        if (FatApp::getConfig('CONF_LAYOUT_MEGA_MENU', FatUtility::VAR_INT, 1) == applicationConstants::YES) {
            unset($linkTypes[NavigationLinks::NAVLINK_TYPE_CATEGORY_PAGE]);
        }
        $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'nlink_type', $linkTypes, '', array(), '')->requirements()->setRequired();
        $frm->addSelectBox(Labels::getLabel('FRM_LINK_TARGET', $this->siteLangId), 'nlink_target', NavigationLinks::getLinkTargetArr($this->siteLangId), '', array(), '')->requirements()->setRequired();
        $frm->addSelectBox(Labels::getLabel('FRM_LOGIN_PROTECTED', $this->siteLangId), 'nlink_login_protected', NavigationLinks::getLinkLoginTypeArr($this->siteLangId), '', array(), '')->requirements()->setRequired();
        $frm->addTextBox(Labels::getLabel('FRM_DISPLAY_ORDER', $this->siteLangId), 'nlink_display_order')->requirements()->setInt();

        $contentPages = ContentPage::getPagesForSelectBox($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_LINK_TO_CMS_PAGE', $this->siteLangId), 'nlink_cpage_id', $contentPages, '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));

        $categoryPages = ProductCategory::getProdCatParentChildWiseArr($this->siteLangId, 0, false, true);
        $frm->addSelectBox(Labels::getLabel('FRM_LINK_TO_CATEGORY', $this->siteLangId), 'nlink_category_id', $categoryPages, '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));

        $fld = $frm->addTextBox(Labels::getLabel('FRM_EXTERNAL_PAGE', $this->siteLangId), 'nlink_url');
        $fld->htmlAfterField = '<br/>' . Labels::getLabel('FRM_PREFIX_WITH_{SITEROOT}_if_u_want_to_generate_system_site_url', $this->siteLangId) . '<br/>E.g: {SITEROOT}products, {SITEROOT}contact_us' . Labels::getLabel('FRM_ETC', $this->siteLangId) . '.';

        $languageArr = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 0 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    private function getLinksLangForm($langId)
    {
        $frm = new Form('frmNavigationLink');
        $frm->addHiddenField('', 'nav_id');
        $frm->addHiddenField('', 'nlink_id');
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_CAPTION', $this->siteLangId), 'nlink_caption');
        return $frm;
    }

    public function deleteLink()
    {
        $this->objPrivilege->canEditNavigationManagement();

        $nlinkId = FatApp::getPostedData('nlinkId', FatUtility::VAR_INT, 0);
        $navId = FatApp::getPostedData('navId', FatUtility::VAR_INT, 0);
        if ($nlinkId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        $dbNavId = NavigationLinks::getAttributesById($nlinkId, 'nlink_nav_id');
        if ($navId != $dbNavId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $obj = new NavigationLinks($nlinkId);
        if (!$obj->deleteRecord(true)) {
            LibHelper::exitWithError($obj->getError(), true);
        }

        $srch = new NavigationLinkSearch($this->siteLangId);
        $srch->doNotLimitRecords();
        $srch->addFld('nlink_id');
        if (FatApp::getConfig('CONF_LAYOUT_MEGA_MENU', FatUtility::VAR_INT, 1) == applicationConstants::YES) {
            $srch->addCondition('nlink_category_id', '=', 0);
        }
        $srch->addCondition('nlink_nav_id', '=', $navId);
        $srch->getResultSet();
        
        $json = [
            'msg' => $this->str_delete_record,
            'subRecordsCount' => $srch->recordCount()
        ];
        CacheHelper::clear(CacheHelper::TYPE_NAVIGATION);
        FatUtility::dieJsonSuccess($json);
    }

    public function updateNavlinksOrder()
    {
        $this->objPrivilege->canEditNavigationManagement();

        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $nlinkObj = new NavigationLinks();
            if (!$nlinkObj->updateOrder($post['nlinksIds'])) {
                LibHelper::exitWithError($nlinkObj->getError(), true);
            }
            CacheHelper::clear(CacheHelper::TYPE_NAVIGATION);
            FatUtility::dieJsonSuccess(Labels::getLabel('LBL_ORDER_UPDATED_SUCCESSFUL', $this->siteLangId));
        }
    }
}
