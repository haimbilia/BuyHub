<?php
class BannersController extends ListingBaseController
{
    protected string $modelClass = 'Banner';
    protected $pageKey = 'MANAGE_BANNERS';
    protected $bannerLocationId;


    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBanners();
    }

    public function index()
    {
        FatApp::redirectUser(UrlHelper::generateUrl('BannerLocation'));
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
            $this->set("canEdit", $this->objPrivilege->canEditBanners($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditBanners();
        }
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'banners/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getSearchForm($fields = [])
    {
        $fields = $this->getFormColumns();
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'banner_location_id', $this->bannerLocationId);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_BANNER_TYPE', $this->siteLangId), 'banner_type', Banner::getBannerTypesArr($this->siteLangId), '', [], Labels::getLabel('FRM_SELECT_BANNER_TYPE', $this->siteLangId));

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'banner_id');
        }

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function list($bannerLocationId)
    {
        if (1 > $bannerLocationId) {
            Message::addErrorMessage($this->str_invalid_request);
            FatApp::redirectUser(UrlHelper::generateUrl('BannerLocation'));
        }
        $this->bannerLocationId = $bannerLocationId;
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);

        $bannerLocation = BannerLocation::getAttributesByLangId($this->siteLangId, $bannerLocationId, 'blocation_name', applicationConstants::JOIN_RIGHT);
        $pageTitle = $bannerLocation ? Labels::getLabel('LBL_BANNERS_LOCATION', $this->siteLangId) . ' : ' . $bannerLocation : LibHelper::getControllerName(true);
        $this->setModel();

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['newRecordBtnAttrs'] = [
            'attr' => [
                'onclick' => 'addNewBanner(' . $bannerLocationId . ')',
            ],
        ];
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_TITLE', $this->siteLangId));
        $this->getListingData($bannerLocationId);
        $this->checkEditPrivilege(true);

        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js', 'banners/page-js/index.js']);
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }


    public function getListingData($bannerLocationId = 0)
    {
        $recordId = FatApp::getPostedData('banner_location_id', FatUtility::VAR_INT, $bannerLocationId);
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }
        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchForm($fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 :  FatUtility::int($data['page']);
        $post = $searchForm->getFormDataFromArray($data);

        $post['banner_location_id'] = $recordId;

        $srch = new BannerSearch($this->siteLangId, false);
        $srch->joinLocations();
        $srch->joinPromotions($this->siteLangId, true);
        $srch->addPromotionTypeCondition();
        $srch->addMultipleFields(array('IFNULL(promotion_name, promotion_identifier) as promotion_name', 'banner_id', 'banner_type', 'banner_url', 'banner_target', 'banner_active', 'banner_blocation_id', 'banner_title', 'banner_updated_on'));
        $srch->addCondition('b.banner_blocation_id', '=', 'mysql_func_' . $recordId, 'AND', true);

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $srch->addCondition('banner_title', 'like', '%' . $post['keyword'] . '%');
        }

        $bannerType = FatApp::getPostedData('banner_type', FatUtility::VAR_INT, 0);
        if (0 < $bannerType) {
            $srch->addCondition('banner_type', '=', $bannerType);
        }

        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
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
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set('bannerTypeArr', Banner::getBannerTypesArr($this->siteLangId));
        $this->set('linkTargetsArr', applicationConstants::getLinkTargetsArr($this->siteLangId));
        $this->checkEditPrivilege(true);
    }

    private function getForm($bannerLocationId)
    {
        $frm = new Form('frmBanner');
        $frm->addHiddenField('', 'banner_blocation_id', $bannerLocationId);
        $frm->addHiddenField('', 'banner_id');
        $frm->addHiddenField('', 'banner_type');

        $frm->addTextBox(Labels::getLabel('FRM_BANNER_TITLE', $this->siteLangId), 'banner_title')->requirements()->setRequired(true);
        $urlFld = $frm->addTextBox(Labels::getLabel('FRM_URL', $this->siteLangId), 'banner_url');
        $urlFld->requirements()->setRegularExpressionToValidate(ValidateElement::URL_REGEX);
        $urlFld->requirements()->setCustomErrorMessage(Labels::getLabel('FRM_THIS_MUST_BE_AN_ABSOLUTE_URL', $this->siteLangId));
        $urlFld->requirements()->setRequired();
        $linkTargetsArr = applicationConstants::getLinkTargetsArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_OPEN_IN', $this->siteLangId), 'banner_target', $linkTargetsArr, '', array(), '');

        $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'banner_active', applicationConstants::ACTIVE, [], true, applicationConstants::INACTIVE);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        $languageArr = Language::getDropDownList();

        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    public function form()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $bannerLocationId = FatApp::getPostedData('bannerLocationId', FatUtility::VAR_INT, 0);
        if ($bannerLocationId < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frm = $this->getForm($bannerLocationId);
        $data = [
            'banner_blocation_id' => $bannerLocationId,
            'banner_id' => $recordId
        ];
        if (0 < $recordId) {
            $srch = Banner::getSearchObject($this->siteLangId, false);
            $srch->addCondition('banner_blocation_id', '=', 'mysql_func_' . $bannerLocationId, 'AND', true);
            $srch->addCondition('banner_id', '=', 'mysql_func_' . $recordId, 'AND', true);
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $data = FatApp::getDb()->fetch($rs);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $data['banner_blocation_id'] = $bannerLocationId;
        }

        if ($recordId == 0) {
            $data['banner_type'] = Banner::TYPE_BANNER;
        }
        $frm->fill($data);
        $this->set('languages', Language::getAllNames());
        $this->set('bannerLocationId', $bannerLocationId);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_BANNER_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }


    public function setup()
    {
        $this->checkEditPrivilege();
        $data = FatApp::getPostedData();
        $recordId = FatUtility::int($data['banner_id']);
        $bannerLocationId = $data['banner_blocation_id'];
        $frm = $this->getForm($bannerLocationId, $recordId);
        if (false === $data) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (1 > $bannerLocationId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $status = $post['banner_active'];
        if (1 == $recordId && applicationConstants::INACTIVE == $status) {
            $post['banner_active'] = applicationConstants::ACTIVE;
        }

        $data = array(
            'banner_blocation_id' => $bannerLocationId,
            'banner_type' => $post['banner_type'],
            'banner_url' => $post['banner_url'],
            'banner_target' => $post['banner_target'],
            'banner_active' => $post['banner_active'],
        );
        $bannerObj = new Banner($recordId);
        $bannerObj->assignValues($data);
        if (!$bannerObj->save()) {
            LibHelper::exitWithError($bannerObj->getError(), true);
        }

        $recordId = $bannerObj->getMainTableRecordId();
        if (!$bannerObj->updateLangData(CommonHelper::getDefaultFormLangId(), ['banner_title' => $post['banner_title']])) {
            LibHelper::exitWithError($bannerObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Banner::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = (array)Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        foreach ($languages as $langId => $langName) {
            $newTabLangId = $langId;
            if (!Banner::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('bannerLocationId', $bannerLocationId);
        $this->set('langId', $newTabLangId);
        $this->set('formLayout', Language::getLayoutDirection($newTabLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($autoFillLangData = 0)
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (1 > $recordId || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Banner::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = (array) Banner::getAttributesByLangId($langId, $recordId);
        }

        $bannerLocationId = Banner::getAttributesById($recordId, 'banner_blocation_id');
        $langData['banner_id'] = $recordId;
        $langData['lang_id'] = $langId;
        $langData['banner_blocation_id'] = $bannerLocationId;

        $langFrm = $this->getLangForm($recordId, $langId);
        if ($langData) {
            $langFrm->fill($langData);
        }
        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('bannerLocationId', $bannerLocationId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getLangForm($recordId, $langId)
    {
        $frm = new Form('frmBannerLang');
        $frm->addHiddenField('', 'banner_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_BANNER_TITLE', $this->siteLangId), 'banner_title');
        return $frm;
    }

    public function langSetup()
    {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();
        $recordId = $post['banner_id'];
        $langId = $post['lang_id'];

        if ($langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($recordId, $langId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        $data = array(
            'bannerlang_banner_id' => $recordId,
            'bannerlang_lang_id' => $langId,
            'banner_title' => $post['banner_title'],
        );

        $bannerObj = new Banner($recordId);
        if (!$bannerObj->updateLangData($langId, $data)) {
            LibHelper::exitWithError($bannerObj->getError(), true);
        }

        $newTabLangId = 0;
        $languages = (array)Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        foreach ($languages as $lang_id => $langName) {
            if (!Banner::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $lang_id;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false, 'json-success.php');
    }


    private function getMediaForm($bannerLocationId, $recordId)
    {
        $frm = new Form('frmBannerMedia');
        $frm->addHiddenField('', 'banner_id', $recordId);
        $frm->addHiddenField('', 'blocation_id', $bannerLocationId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList(), $this->siteLangId, array(), '');
        //$screenArr = applicationConstants::getDisplaysArr($this->siteLangId);
        //$displayFor = ($bannerLocationId == BannerLocation::HOME_PAGE_MOBILE_BANNER) ? applicationConstants::SCREEN_MOBILE : '';
        //$frm->addSelectBox(Labels::getLabel("FRM_DISPLAY_FOR", $this->siteLangId), 'slide_screen', $screenArr, $displayFor, array(), '');
        $frm->addHiddenField('', 'slide_screen', applicationConstants::SCREEN_DESKTOP);
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_BANNER);
        $frm->addHiddenField('', 'min_width');
        $frm->addHiddenField('', 'min_height');
        $frm->addHTML('', 'banner_image', '');
        return $frm;
    }

    // Media functionality
    public function media($recordId, $bannerLocationId, $langId = 0, $slideScreen = 1)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $bannerLocationId || 1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $bannerDetail = Banner::getAttributesById($recordId);
        if (!false == $bannerDetail && ($bannerDetail['banner_active'] != applicationConstants::ACTIVE)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_OR_INACTIVE_RECORD', $this->siteLangId), true);
        }

        $imageFrm = $this->getMediaForm($bannerLocationId, $recordId);
        if (!false == $bannerDetail) {
            $bannerImge = AttachedFile::getAttachment(AttachedFile::FILETYPE_BANNER, $recordId, 0, -1);
            $this->set('image', $bannerImge);
        }

        $locationDimensions = BannerLocation::getDimensions($bannerLocationId, applicationConstants::SCREEN_DESKTOP);

        $this->set('locationDimensions', $locationDimensions);
        $this->set('frm', $imageFrm);
        $this->set('languages', Language::getAllNames());
        $this->set('bannerLocationId', $bannerLocationId);
        $this->set('recordId', $recordId);
        $this->set('banner_id', $recordId);
        $this->set('langId', $langId);
        $this->set('slideScreen', $slideScreen);
        $this->checkEditPrivilege(true);
        $this->set('html', $this->_template->render(false, false, NULL, true, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }


    public function images()
    {
        $bannerLocationId = FatApp::getPostedData('bannerLocationId', FatUtility::VAR_INT, 0);
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $langId = 0 == $langId ? $this->siteLangId : $langId;
        $screen = FatApp::getPostedData('screen', FatUtility::VAR_INT, applicationConstants::SCREEN_DESKTOP);
        $imageType = FatApp::getPostedData('imageType', FatUtility::VAR_STRING, ImageDimension::VIEW_THUMB);
        $bannerLocationId = FatUtility::int($bannerLocationId);

        if (1 > $bannerLocationId || 1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $bannerDetail = Banner::getAttributesById($recordId);
        if (!false == $bannerDetail && ($bannerDetail['banner_active'] != applicationConstants::ACTIVE)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_OR_INACTIVE_RECORD', $this->siteLangId), true);
        }

        if (!false == $bannerDetail) {
            $bannerImgArr = AttachedFile::getAttachment(AttachedFile::FILETYPE_BANNER, $recordId, 0, $langId, true, $screen);
            $this->set('image', $bannerImgArr);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('screenTypeArr', $this->getDisplayScreenName());
        $this->set('bannerLocationId', $bannerLocationId);
        $this->set('recordId', $recordId);
        $this->set('banner_id', $recordId);
        $this->set('bannerDetail', $bannerDetail);
        $this->checkEditPrivilege(true);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function uploadMedia()
    {
        $this->checkEditPrivilege();
        $fileType = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $recordId = FatApp::getPostedData('banner_id', FatUtility::VAR_INT, 0);
        $bannerLocationId = FatApp::getPostedData('blocation_id', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $slideScreen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 0);
        if (!$fileType || !$recordId || !$bannerLocationId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $file = $_FILES['cropped_image'];
        if (!is_uploaded_file($file['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->saveImage($file['tmp_name'], $fileType, $recordId, 0, $file['name'], -1, true, $langId, $file['type'], $slideScreen)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
            $langId = FatUtility::int($langId);
        } else {
            $universalImage = false;
            $langId = array_key_first($languages);
        }

        $cbgImage = AttachedFile::getAttachment($fileType, $recordId, 0, $langId, $universalImage, $slideScreen);
        $this->set('image', $cbgImage);
        $this->set('imageFunction', 'Slide');
        $this->set('file', $file['name']);
        $this->set('banner_id', $recordId);
        $this->set('recordId', $recordId);
        $this->set('bannerLocationId', $bannerLocationId);
        $this->set('file_type', $fileType);
        $this->set('slide_screen', $slideScreen);
        $this->set('lang_id', $langId);
        $this->set('msg', $file['name'] . ' ' . Labels::getLabel('MSG_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeMedia()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $afileId = FatApp::getPostedData('afileId', FatUtility::VAR_INT, 0);
        $fileType = FatApp::getPostedData('fileType', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $slideScreen = FatApp::getPostedData('slideScreen', FatUtility::VAR_INT, 0);

        if (0 == $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $fileHandlerObj = new AttachedFile($afileId);
        if ($langId == $this->siteLangId) {
            $fileHandlerObj->deleteFile($fileType, $recordId, 0, 0, 0, $slideScreen);
        }

        if (!$fileHandlerObj->deleteFile($fileType, $recordId, $afileId, 0, $langId, $slideScreen)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
            $langId = FatUtility::int($langId);
        } else {
            $universalImage = false;
            $langId = array_key_first($languages);
        }

        $cbgImage = AttachedFile::getAttachment($fileType, $recordId, 0, $langId, $universalImage, $slideScreen);
        $this->set('image', $cbgImage);
        $this->set('imageFunction', 'Slide');
        $this->set('msg', Labels::getLabel('MSG_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getBannerLocationById($recordId)
    {
        $recordId = FatUtility::int($recordId);

        $srch = Banner::getBannerLocationSrchObj(false);
        $srch->addCondition('blocation_id', '=', 'mysql_func_' . $recordId, 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $data = FatApp::getDb()->fetch($srch->getResultSet());
        return $data;
    }

    private function bannerTypeArr($langId = 0)
    {
        if ($langId == 0) {
            $langId = $this->siteLangId;
        }
        return applicationConstants::getDisplaysArr($langId);
    }

    private function getDisplayScreenName()
    {
        $screenTypesArr = applicationConstants::getDisplaysArr($this->siteLangId);
        return array(0 => '') + $screenTypesArr;
    }

    public function getBannerLocationDimensions($bannerLocationId, $deviceType)
    {
        $bannerDimensions = BannerLocation::getDimensions($bannerLocationId, $deviceType);
        $this->set('bannerWidth', $bannerDimensions['blocation_banner_width']);
        $this->set('bannerHeight', $bannerDimensions['blocation_banner_height']);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'list':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => Labels::getLabel('NAV_BANNER_LOCATIONS', $this->siteLangId), 'href' => UrlHelper::generateUrl('BannerLocation')],
                    ['title' => $pageTitle]
                ];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditBanners();
        $bannerId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        if (1 > $bannerId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $data = Banner::getAttributesById($bannerId, array('banner_id', 'banner_active'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new Banner($bannerId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_STATUS_UPDATED', $this->siteLangId));
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $bannersTblHeadingCols = CacheHelper::get('bannersTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($bannersTblHeadingCols) {
            return json_decode($bannersTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_ID', $this->siteLangId), */
            'banner_title' => Labels::getLabel('LBL_TITLE', $this->siteLangId),
            'banner_type' => Labels::getLabel('LBL_TYPE', $this->siteLangId),
            'banner_img' => Labels::getLabel('LBL_IMAGE', $this->siteLangId),
            'banner_target' => Labels::getLabel('LBL_TARGET', $this->siteLangId),
            'banner_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId)
        ];
        CacheHelper::create('bannersTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /* 'listSerial', */
            'banner_title',
            'banner_type',
            'banner_img',
            'banner_target',
            'banner_active',
            'action'
        ];
    }

    /**
     * Undocumented function
     *
     * @param array $fields
     * @return array
     */
    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['banner_img'], Common::excludeKeysForSort());
    }
}
