<?php

class RatingTypesController extends ListingBaseController
{

    protected string $modelClass = 'RatingType';
    protected $pageKey = 'RATING_TYPES';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewRatingTypes();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('canEdit', $this->objPrivilege->canEditRatingTypes($this->admin_id, true));
        $this->set("frmSearch", $this->getSearchForm($fields));
        $this->set('actionItemsData', HtmlHelper::getDefaultActionItems($fields, $this->modelObj));
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_RATING_TYPE', $this->siteLangId));
        $this->getListingData();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'rating-types/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getListingData()
    {
        $this->objPrivilege->canViewRatingTypes();
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'ratingtype_id');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'ratingtype_id';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $searchForm = $this->getSearchForm($fields);

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = new RatingTypeSearch($this->siteLangId);
        $attr = array_merge(RatingType::ATTR, RatingType::LANG_ATTR, ['COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name']);
        $srch->addMultipleFields($attr);
        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('ratingtype_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('ratingtype_identifier', 'like', '%' . $keyword . '%');
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('restrictTypes', [RatingType::TYPE_PRODUCT, RatingType::TYPE_SHOP, RatingType::TYPE_DELIVERY]);
        $this->set('types', RatingType::getTypeArr($this->siteLangId));
        $this->set("arrListing", $records);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditBrands($this->admin_id, true));
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
            $this->set("canEdit", $this->objPrivilege->canEditRatingTypes($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditRatingTypes();
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
        $this->objPrivilege->canEditRatingTypes();
        $this->setModel($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_RATING_TYPES_SETUP', $this->siteLangId));
        $this->checkMediaExist = false;
    }

    public function form()
    {
        $this->objPrivilege->canEditRatingTypes();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        if (0 < $recordId) {
            $data = RatingType::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, ['IFNULL(ratingtype_name,ratingtype_identifier) as ratingtype_name', 'ratingtype_identifier', 'ratingtype_active'], applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }           
            $frm->fill($data);
        }
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_RATING_TYPES_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, '_partial/listing/form.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditRatingTypes();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatApp::getPostedData('ratingtype_id', FatUtility::VAR_INT, 0);
        $restrictTypes = [RatingType::TYPE_PRODUCT, RatingType::TYPE_SHOP, RatingType::TYPE_DELIVERY];

        $post['ratingtype_type'] = RatingType::TYPE_OTHER;
        if (in_array($recordId, $restrictTypes)) {
            $post['ratingtype_type'] = $recordId;
        }

        if (!in_array($recordId, $restrictTypes)) {
            $post['ratingtype_identifier'] = $post['ratingtype_name'];
        }

        if (RatingType::TYPE_PRODUCT == $recordId) {
            $post['ratingtype_active'] = applicationConstants::ACTIVE;
        }

        $rating = new RatingType($recordId);
        $rating->assignValues($post);
        if (!$rating->save()) {
            $msg = $rating->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }

        $recordId = $rating->getMainTableRecordId();

        $this->setLangData($rating, [$rating::tblFld('name') => $post[$rating::tblFld('name')]]);
        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($recordId = 0)
    {
        $this->objPrivilege->canEditRatingTypes();
        $recordId = FatUtility::int($recordId);
        $frm = new Form('frmRating', array('id' => 'frmRating'));
        $frm->addHiddenField('', 'ratingtype_id', $recordId);

        $label = Labels::getLabel('LBL_THIS_CAN_BE_BIND_WITH_CATEGORIES.', $this->siteLangId);
        if (in_array($recordId, [RatingType::TYPE_PRODUCT, RatingType::TYPE_SHOP, RatingType::TYPE_DELIVERY])) {
            $label = Labels::getLabel('LBL_THIS_IS_DEFAULT_RATING_TYPE_CANNOT_BE_ASSIGNED.', $this->siteLangId);
        }
        
        $htm = '<div class="alert alert-solid-brand " role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i>
                    </div>
                    <div class="alert-text text-xs">' . $label . '</div>
                </div>';
        $frm->addHtml('', 'rating_type_info', $htm);

        $frm->addRequiredField(Labels::getLabel('FRM_RATING_TYPE', $this->siteLangId), 'ratingtype_name');

        $attr = (RatingType::TYPE_PRODUCT == $recordId ? ['disabled' => 'disabled'] : []);
        $fld = $frm->addCheckBox(Labels::getLabel('FRM_RATING_TYPE_STATUS', $this->siteLangId), 'ratingtype_active', applicationConstants::ACTIVE, $attr, true, applicationConstants::INACTIVE);
        HtmlHelper::configureSwitchForCheckbox($fld);
        $fld->developerTags['noCaptionTag'] = true;

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, [], false, 0);
        }
        return $frm;
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $frm = new Form('frmRatingLang', array('id' => 'frmRatingLang'));
        $frm->addHiddenField('', 'ratingtype_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_RATING_TYPE', $langId), 'ratingtype_name');
        return $frm;
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'ratingtype_id');
        }
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    protected function changeStatus(int $recordId, int $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (RatingType::TYPE_PRODUCT == $recordId) {
            $status = applicationConstants::ACTIVE;
        }

        $this->setModel([$recordId]);
        if (!$this->modelObj->changeStatus($status)) {
            LibHelper::exitWithError($this->modelObj->getError(), true);
        }
    }

    private function getFormColumns(): array
    {
        $shopsTblHeadingCols = CacheHelper::get('ratingTypeTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'ratingtype_name' => Labels::getLabel('LBL_RATING_TYPE', $this->siteLangId),
            'ratingtype_type' => Labels::getLabel('LBL_TYPE', $this->siteLangId),
            'ratingtype_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('ratingTypeTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'ratingtype_name',
            'ratingtype_type',
            'ratingtype_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, [], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => $pageTitle]
                ];
        }
        return $this->nodes;
    }
}
