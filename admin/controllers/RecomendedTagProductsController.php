<?php
class RecomendedTagProductsController extends ListingBaseController
{
    protected $pageKey = 'RECOMMENDED_TAG_PRODUCTS_WEIGHTAGES';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewRecomendedTagProducts();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_TAG_NAME_OR_PRODUCT_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['recomended-tag-products/page-js/index.js']);
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'recomended-tag-products/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $post = FatApp::getPostedData();

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

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT,$this->siteLangId);

        $srch = new SearchBase('tbl_tag_product_recommendation', 'tpr');
        $srch->joinTable(Tag::DB_TBL, 'INNER JOIN', 't.tag_id = tpr.tpr_tag_id', 't');
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = tpr.tpr_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p_l.productlang_product_id = p.product_id and p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING);
        
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('tag_name', 'LIKE', '%' . $keyword . '%');
            $cnd->attachCondition('product_name', 'LIKE', '%' . $keyword . '%');
        }
        if (!empty($langId)) {
            $srch->addCondition('t.tag_lang_id', '=', $langId); 
        }
        
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords(); 
        $srch->addMultipleFields(array('tpr.*', 't.tag_name', 'IFNULL(p_l.product_name,p.product_identifier) as product_name'));
        $srch->addOrder($sortBy, $sortOrder); 
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);  
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet())); 
        $this->set('postedData', $post); 
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditRecomendedWeightages($this->admin_id, true));
    }

    public function setup()
    {
        $this->objPrivilege->canEditRecomendedWeightages();
        $post = FatApp::getPostedData();
        $product_id = FatUtility::int($post['product_id']);
        $tag_id = FatUtility::int($post['tag_id']);

        $data = array();
        $value = '';
        if (isset($post['tpr_custom_weightage'])) {
            $value = $data['tpr_custom_weightage'] = $post['tpr_custom_weightage'];
        }

        if (isset($post['tpr_custom_weightage_valid_till'])) {
            $value = $data['tpr_custom_weightage_valid_till'] = $post['tpr_custom_weightage_valid_till'];
        }

        if (!FatApp::getDb()->updateFromArray('tbl_tag_product_recommendation', $data, array('smt' => 'tpr_product_id = ? and tpr_tag_id = ?', 'vals' => array($product_id, $tag_id)))) {
            LibHelper::exitWithError(FatApp::getDb()->getError(), true);
        }

        $json = array(
            'status' => true,
            'msg' => $this->str_setup_successful,
            'data' => ['value' => $value]
        );
        FatUtility::dieJsonSuccess($json);
    }

    protected function getFormColumns(): array
    {
        $recTagProdsTblHeadingCols = CacheHelper::get('recTagProdsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($recTagProdsTblHeadingCols) {
            return json_decode($recTagProdsTblHeadingCols, true);
        }

        $arr = [
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'tag_name' => Labels::getLabel('LBL_TAG', $this->siteLangId),
            'product_name' => Labels::getLabel('LBL_PRODUCT', $this->siteLangId),
            'tpr_weightage' => Labels::getLabel('LBL_SYSTEM_WEIGHTAGE', $this->siteLangId),
            'tpr_custom_weightage' => Labels::getLabel('LBL_CUSTOM_WEIGHTAGE', $this->siteLangId),
            'tpr_custom_weightage_valid_till' => Labels::getLabel('LBL_VALID_TILL_<BR/>(CUSTOM_WEIGHTAGE)', $this->siteLangId),
        ];

        if (count(Language::getAllNames()) < 2) {
            unset($arr['language_name']);
        }

        CacheHelper::create('recTagProdsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'tag_name',
            'product_name',
            'tpr_weightage',
            'tpr_custom_weightage',
            'tpr_custom_weightage_valid_till',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'tag_name');
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList(), $this->siteLangId ,[], '');
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }
}
