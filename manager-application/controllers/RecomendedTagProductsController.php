<?php
class RecomendedTagProductsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewRecomendedTagProducts();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('languages', Language::getAllNames());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_RECOMENDATIONS_TAG_PRODUCTS', $this->siteLangId));
        $this->getListingData();

        $this->_template->render();
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

        $srch = new SearchBase('tbl_tag_product_recommendation', 'tpr');
        $srch->joinTable(Tag::DB_TBL, 'INNER JOIN', 't.tag_id = tpr.tpr_tag_id', 't');
        $srch->joinTable(Tag::DB_TBL_LANG, 'LEFT OUTER JOIN', 't_l.taglang_tag_id = t.tag_id and t_l.taglang_lang_id = ' . $this->siteLangId, 't_l');
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = tpr.tpr_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p_l.productlang_product_id = p.product_id and p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $srch->addMultipleFields(array('tpr.*', 'tpr_tag_id as listSerial', 'IFNULL(t_l.tag_name,t.tag_identifier) as tag_name', 'IFNULL(p_l.product_name,p.product_identifier) as product_name'));

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING);
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('tag_name', 'LIKE', '%' . $keyword . '%');
            $cnd->attachCondition('product_name', 'LIKE', '%' . $keyword . '%');
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

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
        $this->set('canEdit', $this->objPrivilege->canEditRecomendedWeightages($this->admin_id, true));
        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
    }

    public function setup()
    {
        $this->objPrivilege->canEditRecomendedWeightages();
        $post = FatApp::getPostedData();
        $product_id = FatUtility::int($post['product_id']);
        $tag_id = FatUtility::int($post['tag_id']);

        $data = array();
        if (isset($post['tpr_custom_weightage'])) {
            $data['tpr_custom_weightage'] = $post['tpr_custom_weightage'];
        }

        if (isset($post['tpr_custom_weightage_valid_till'])) {
            $data['tpr_custom_weightage_valid_till'] = $post['tpr_custom_weightage_valid_till'];
        }

        if (!FatApp::getDb()->updateFromArray('tbl_tag_product_recommendation', $data, array('smt' => 'tpr_product_id = ? and tpr_tag_id = ?', 'vals' => array($product_id, $tag_id)))) {
            LibHelper::exitWithError(FatApp::getDb()->getError(), true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getFormColumns(): array
    {
        $recTagProdsTblHeadingCols = CacheHelper::get('recTagProdsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($recTagProdsTblHeadingCols) {
            return json_decode($recTagProdsTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'tag_name' => Labels::getLabel('LBL_Tag', $this->siteLangId),
            'product_name' => Labels::getLabel('LBL_Product', $this->siteLangId),
            'tpr_weightage' => Labels::getLabel('LBL_System_Weightage', $this->siteLangId),
            'tpr_custom_weightage' => Labels::getLabel('LBL_Custom_Weightage', $this->siteLangId),
            'tpr_custom_weightage_valid_till' => Labels::getLabel('LBL_Valid_Till_<br/>(Custom_Weightage)', $this->siteLangId),
        ];

        if (count(Language::getAllNames()) < 2) {
            unset($arr['language_name']);
        }

        CacheHelper::create('recTagProdsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'listSerial',
            'tag_name',
            'product_name',
            'tpr_weightage',
            'tpr_custom_weightage',
            'tpr_custom_weightage_valid_till',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
