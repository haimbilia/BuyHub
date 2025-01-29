<?php

class AppReleaseVersionController extends ListingBaseController
{
    protected string $modelClass = 'AppReleaseVersion';
    protected $pageKey = 'MANAGE_APP_RELEASE';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAppReleaseVersions();
    }

    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditAppReleaseVersions($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditAppReleaseVersions();
        }
    }

    public function index()
    {
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_RELEASE_VERSION', $this->siteLangId));
        $this->checkEditPrivilege(true);
        $this->getListingData();
        $this->_template->render(true, true, '_partial/listing/index.php');

    }

    public function getListingData()
    {
        $frm = $this->getSearchForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $post['page'] = (isset($post['page']) && $post['page'] > 0) ? $post['page'] : 1;
        $post['pageSize'] = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $fields = $this->getFormColumns();
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $srch = new AppReleaseVersionSearch();
        $srch->joinWithAdminUsers();
        $srch->applyConditions($post);
        $srch->addMultipleFields([
            'arv.*',
            'admin.admin_name as added_by',
        ]);
        $srch->addOrder('arv_app_name', 'ASC');
        $srch->addOrder('arv_app_type', 'ASC');
        $srch->doNotCalculateRecords();
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('arrListing',$records);
        $this->set('fields', $fields);
        $this->set('page', $post['page']);
        $this->set('pageSize', $post['pageSize']);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('postedData', $post);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditAppReleaseVersions(0, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditAppReleaseVersions();
        $releaseId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm();
        if ($releaseId > 0) {
            $frm->fill(AppReleaseVersion::getAttributesById($releaseId));
        }
        $this->set('frm', $frm);
        $this->set('displayLangTab', false);
        $this->set('formTitle', Labels::getLabel('LBL_APP_PACKAGE_NAME', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'app-release-version/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }


    private function getForm()
    {
        $frm = new Form('frmversion');
        $frm->addHiddenField('', 'arv_id', 0);
        $frm->addRequiredField(Labels::getLabel('LBL_App_Name', $this->siteLangId), 'arv_app_name');
        $fld = $frm->addRequiredField(Labels::getLabel('LBL_PACKAGE_NAME/BUNDLE_ID', $this->siteLangId), 'arv_package_name');
        $fld->htmlAfterField = "<small class='form-text text-muted'>" . Labels::getLabel("LBL_Enter_Unique_Package_Name", $this->siteLangId) . "</small>";
        $fld = $frm->addRadioButtons(Labels::getLabel("LBL_Release_For", $this->siteLangId), 'arv_app_type', applicationConstants::getAppTypeArray($this->siteLangId), applicationConstants::LOGIN_VIA_ANDROID, ['class' => 'list-radio']);
        $fld->requirements()->setRequired();

        $fld = $frm->addRequiredField(Labels::getLabel('LBL_App_Version', $this->siteLangId), 'arv_app_version');
        $fld->htmlAfterField = "<small class='form-text text-muted'>" . Labels::getLabel("LBL_Enter_Latest_Version_Uploaded_On_Google_Play/Apple_Store", $this->siteLangId) . "</small>";

        $fld = $frm->addRequiredField(Labels::getLabel('LBL_STORE_URL', $this->siteLangId), 'arv_store_url');
        $fld->htmlAfterField = "<small class='form-text text-muted'>" . Labels::getLabel("LBL_Enter_store_url_for_Google_Play/Apple_Store", $this->siteLangId) . "</small>";

        $fld = $frm->addRadioButtons(Labels::getLabel("LBL_IS_CRITICAL_VERSION?", $this->siteLangId), 'arv_is_critical', applicationConstants::getYesNoArr($this->siteLangId), applicationConstants::NO, ['class' => 'list-radio']);
        $fld->requirements()->setRequired();
        $fld->htmlAfterField = "<small class='form-text text-muted'>" . Labels::getLabel("LBL_Critical_Version_Ask_Users_To_Force_App_Update", $this->siteLangId) . "</small>";

        $fld = $frm->addTextarea(Labels::getLabel("LBL_App_Latest_Version_Features", $this->siteLangId), 'arv_description');
        $fld->htmlAfterField = "<small class='form-text text-muted'>" . Labels::getLabel("LBL_Describe_Features_Included_In_this_App_Version", $this->siteLangId) . "</small>";
        return $frm;
    }

    public function setup()
    {
        $this->objPrivilege->canEditAppReleaseVersions();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $post['exclude_arv_id'] = FatApp::getPostedData('arv_id');

        $srch = new AppReleaseVersionSearch();
        if (!empty($srch->searchVersions($post))) {
            FatUtility::dieJsonError(Labels::getLabel("MSG_App_already_exist", $this->siteLangId));
        }

        $record = new AppReleaseVersion($post['arv_id']);
        unset($post['arv_id']);
        $record->assignValues($post);
        if (!$record->saveRecord(AdminAuthentication::getLoggedAdminId())) {
            FatUtility::dieJsonError($record->getError());
        }
        $this->set('msg', Labels::getLabel('LBL_Setup_Successful', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getFormColumns(): array
    {
        $appReleaseTblHeadingCols = CacheHelper::get('appReleaseTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($appReleaseTblHeadingCols) {
            return json_decode($appReleaseTblHeadingCols, true);
        }

        $arr = [
            'listserial' => Labels::getLabel('LBL_Sr._No', $this->siteLangId),
            'arv_app_name' => Labels::getLabel('LBL_Platform_Name', $this->siteLangId),
            'arv_package_name' => Labels::getLabel('LBL_Package_Name', $this->siteLangId),
            'arv_app_version' => Labels::getLabel('LBL_Live_Version', $this->siteLangId),
            'arv_is_critical' => Labels::getLabel('LBL_Is_critical_Version?', $this->siteLangId),
            'arv_added_on' => Labels::getLabel('LBL_CREATED_ON', $this->siteLangId),
            'added_by' => Labels::getLabel('LBL_Added_By', $this->siteLangId),
            'action' => Labels::getLabel('LBL_Action', $this->siteLangId),
        ];
        CacheHelper::create('appReleaseTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(){
        return[
            'listserial',
            'arv_app_name',
            'arv_package_name',
            'arv_app_version',
            'arv_is_critical',
            'arv_added_on',
            'added_by',
            'action',
        ];

    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['listserial','arv_is_critical', 'added_by'], Common::excludeKeysForSort());
    }

}
