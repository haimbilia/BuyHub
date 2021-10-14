<?php

class TaxStructureController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewTax();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_TAX_STRUCTURE', $this->siteLangId));
        $this->getListingData();

        $this->_template->render();
    }

    private function getListingData()
    {
        $db = FatApp::getDb();
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

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

        $srch = TaxStructure::getSearchObject($this->siteLangId);
        $srch->addCondition('taxstr_parent', '=', 0);
        $srch->addMultipleFields(array('ts.*', 'ts_l.*', 'taxstr_id as listSerial'));

        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('taxstr_identifier', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('taxstr_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $arrListing = $db->fetchAll($srch->getResultSet());

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditTax($this->admin_id, true));
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'tax-structure/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function form()
    {
        $this->objPrivilege->canEditTax();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
		
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
		$languages = Language::getAllNames();
       
        $frm = TaxStructure::getForm($this->siteLangId, $recordId);
        $taxStrData = [];
        $combinedTaxes = [];
        if (0 < $recordId) {
			$taxStrData = TaxStructure::getAttributesById($recordId);
            foreach ($languages as $langId => $data) {
                $taxStructure = new TaxStructure();
                $taxStrLangData = $taxStructure->getAttributesByLangId($langId, $recordId);
                if (!empty($taxStrLangData)) {
                    $taxStrData['taxstr_name'][$langId] = $taxStrLangData['taxstr_name'];
                }
                if ($taxStrData['taxstr_is_combined']) {
                    $combinedTaxes = $taxStructure->getCombinedTaxes($recordId);
                }
            }
			
            if ($taxStrData === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($taxStrData);
        }
		$langData = Language::getAllNames();
        unset($langData[$siteDefaultLangId]);

        $this->set('combinedTaxes', $combinedTaxes);
        $this->set('taxStrData', $taxStrData);
        $this->set('otherLangData', $langData);
        $this->set('siteDefaultLangId', $siteDefaultLangId);
        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($this->siteLangId));
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditTax();

        $frm = TaxStructure::getForm($this->siteLangId);
        $post = FatApp::getPostedData();
		
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['taxstr_id'];
        unset($post['taxstr_id']);
		
        $record = new TaxStructure($recordId);
        if (!$record->addUpdateData($post)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }
	
	public function translatedData()
    {
        $taxstrName = FatApp::getPostedData('taxstrName', FatUtility::VAR_STRING, '');
        $toLangId = FatApp::getPostedData('toLangId', FatUtility::VAR_INT, 0);
        $data['taxstr_name'] = $taxstrName;
        $taxStructure = new TaxStructure();
        $translatedData = $taxStructure->getTranslatedData($data, $toLangId);
        if (!$translatedData) {
            LibHelper::exitWithError($taxStructure->getError(), true);
        }
        $this->set('taxstrName', $translatedData[$toLangId]['taxstr_name']);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getFormColumns(): array
    {
        $taxStructureTblHeadingCols = CacheHelper::get('taxStructureTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($taxStructureTblHeadingCols) {
            return json_decode($taxStructureTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'taxstr_identifier' => Labels::getLabel('LBL_Tax_Structure_Name', $this->siteLangId),
            'taxstr_is_combined' => Labels::getLabel('LBL_Combined_Tax', $this->siteLangId),
            'action' =>  Labels::getLabel('LBL_ACTION', $this->siteLangId),
        ];
        CacheHelper::create('taxStructureTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'listSerial',
            'taxstr_identifier',
            'taxstr_is_combined',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['taxstr_is_combined'],Common::excludeKeysForSort());
    }
}
