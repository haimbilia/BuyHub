<?php

class TagsController extends ListingBaseController
{

    protected string $modelClass = 'Tag';
    protected $pageKey = 'MANAGE_TAGS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewTags();
    }

    public function index()
    {
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);

        if (1 > $langId) {
            $langId = $this->siteLangId;
        }

        $fields = $this->getFormColumns($langId);
        $frmSearch = $this->getSearchFrm($fields, $langId);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $langId);
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageData['plang_title'] ?? LibHelper::getControllerName(true));

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;

        $languages = Language::getDropDownList();
        if (0 < $languages) {
            $langHtmlObj  = new HtmlElement('div', ['class' => 'd-flex'], '', true);
            $selectObj = $langHtmlObj->appendElement('select', ['class' => 'form-control form-select select-language', 'id' => 'tagLangId', 'onchange' => 'languageToggle(this)']);
            array_walk($languages, function ($langName, $languageId) use ($selectObj, $langId) {
                $elAttr = ['value' => $languageId];
                if ($languageId == $langId) {
                    $elAttr['selected'] = true;
                }
                $selectObj->appendElement('option', $elAttr, $langName);
            });
            $actionItemsData['headerHtmlContent'] = $langHtmlObj->getHtml();
        }

        $actionItemsData['langId'] = $langId;

        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->setCustomColumnWidth();
        $this->set('autoTableColumWidth', false);
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME_AND_MODEL', $langId));
        $this->getListingData();

        if (FatUtility::isAjaxCall()) {
            $this->_template->render(false, false, null, false, false);
            return;
        }

        $this->_template->addJs([
            'js/select2.js',
            'js/tagify.min.js',
            'js/tagify.polyfills.min.js',
        ]);
        $this->_template->addCss(['css/select2.min.css', 'css/tagify.min.css']);
        $this->_template->render(true, true, null, false, false);
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'tags/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }


    public function setup()
    {
        $this->objPrivilege->canEditTags();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $tag_id = FatUtility::int($post['tag_id']);
        $post['tag_lang_id'] = FatUtility::int($post['tag_lang_id']);
        if (1 > $post['tag_lang_id']) {
            $post['tag_lang_id'] = $this->siteLangId;
        }

        $recordObj = new Tag($tag_id);
        $recordObj->assignValues($post);
        if (!$recordObj->save()) {
            LibHelper::exitWithError($recordObj->getError(), true);
        }

        $tag_id = $recordObj->getMainTableRecordId();

        /* update product tags association and tag string in products lang table[ */
        Tag::updateTagStrings($tag_id);
        /* ] */

        $this->set('msg', $this->str_setup_successful);
        $this->set('tagId', $tag_id);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function autoComplete()
    {
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        if (1 > $langId) {
            $langId = $this->siteLangId;
        }
        $srch = Tag::getSearchObject();
        $srch->addCondition('tag_lang_id', '=', $langId);
        $srch->addMultipleFields(array('tag_id', 'tag_name'));
        if (!empty($keyword)) {
            $srch->addCondition('tag_name', 'LIKE', '%' . $keyword . '%');
        }
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        die(FatUtility::convertToJson($records));
    }

    private function getForm()
    {
        $this->objPrivilege->canEditTags();
        $frm = new Form('frmTag');
        $frm->addHiddenField('', 'tag_id');
        $frm->addHiddenField('', 'tag_lang_id');
        $frm->addRequiredField(Labels::getLabel('FRM_TAG_NAME', $this->siteLangId), 'tag_name');
        return $frm;
    }

    protected function getSearchFrm($fields, $langId)
    {
        $fields = $this->getFormColumns($langId);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));

        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'lang_id', $langId);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $langId), 'keyword');
        $fld->overrideFldType('search');

        if (!empty($fields)) {
            $this->addSortingElements($frm, current($allowedKeysForSorting));
        }

        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        if (1 > $langId) {
            $langId = $this->siteLangId;
        }

        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns($langId);
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchFrm($fields, $langId);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $srch = new ProductSearch($langId, null, null);        /*
        $srch->addDirectCondition(
                '((CASE
                    WHEN product_seller_id = 0 THEN product_active = 1
                    WHEN product_seller_id > 0 THEN product_active IN (1, 0)
                    END ) )'
        );
        */

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('product_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('product_identifier', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('product_model', 'like', '%' . $keyword . '%');
        }
        $srch->addMultipleFields(['product_id', 'IFNULL(product_name, product_identifier) as product_name']);
        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("arrListing", $records);
        $this->set('langId', $langId);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('canEdit', $this->objPrivilege->canEditTags($this->admin_id, true));
    }

    protected function getFormColumns(int $langId = 0): array
    {
        $tblHeadingCols = CacheHelper::get('tagsTblHeadingCols' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $langId),
            'product_name' => Labels::getLabel('LBL_PRODUCT_NAME', $langId),
            'tags' => Labels::getLabel('LBL_TAGS', $langId)
        ];
        CacheHelper::create('tagsTblHeadingCols' . $langId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'product_name',
            'tags',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['tags'], Common::excludeKeysForSort());
    }

    /**
     * setCustomColumnWidth
     *
     * @return void
     */
    protected function setCustomColumnWidth(): void
    {
        $arr = [
            'listSerial' => [
                'width' => '5%'
            ],
            'product_name' => [
                'width' => '35%'
            ],
            'tags' => [
                'width' => '60%'
            ],
        ];

        $this->set('tableHeadAttrArr', $arr);
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => $pageTitle]
                ];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }
}
