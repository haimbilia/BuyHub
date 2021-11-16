<?php

class AdvertisersReportController extends ListingBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAdvertisersReport();
    }

    public function index()
    {
        $formColumns = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($formColumns);
        $pageData = PageLanguageData::getAttributesByKey('ADVERTISERS_REPORT', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('formColumns', $formColumns);
        $this->getListingData(false);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $this->getListingData($type);
        $jsonData = [
            'headSection' => $this->_template->render(false, false, '_partial/listing/head-section.php', true),
            'listingHtml' => $this->_template->render(false, false, 'advertisers-report/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getListingData($type = false)
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('listingColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current(array_keys($fields)));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current(array_keys($fields));
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');

        $srch = new UserSearch();
        $srch->includeTransactionBalance();
        $srch->includePromotionCharges();
        $srch->includePromotionsCount();
        $srch->addMultipleFields(
            array(
                'u.user_name as name', 'uc.credential_email as email', 'u.user_regdate', 'u.user_is_supplier', 'activePromotions', 'promotionsCount', 'promotionCharged'
            )
        );
        $srch->addCondition('u.user_is_advertiser', '=', applicationConstants::YES);

        $date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('u.user_regdate', '>=', $date_from . ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('u.user_regdate', '<=', $date_to . ' 23:59:59');
        }

        if (!empty($keyword)) {
            $srch->addCondition('u.user_name', 'like', '%' . $keyword . '%');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder(CommonHelper::getLangId()))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        switch ($sortBy) {
            default:
                $srch->addOrder($sortBy, $sortOrder);
                break;
        }


        if ($type == 'export') {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();

            array_push($sheetData, array_values($fields));

            $count = 1;
            while ($row = FatApp::getDb()->fetch($rs)) {
                $arr = [];
                foreach ($fields as $key => $val) {
                    switch ($key) {
                        case 'listserial':
                            $arr[] = $count;
                            break;
                        case 'name':
                            $name = $row['name'] . "\n" . $row['email'];
                            $arr[] = $name;
                            break;
                        case 'user_is_supplier':
                            $yesNoArr = applicationConstants::getYesNoArr($this->siteLangId);
                            $arr[] = $yesNoArr[$row['user_is_supplier']];
                            break;
                        case 'availableBalance':
                        case 'promotionCharged':
                            $arr[] = CommonHelper::displayMoneyFormat($row[$key], true, true, false);
                            break;
                        default:
                            $arr[] = $row[$key];
                            break;
                    }
                }

                array_push($sheetData, $arr);
                $count++;
            }

            CommonHelper::convertToCsv($sheetData, str_replace("{reportgenerationdate}", date("d-M-Y"), Labels::getLabel("LBL_Advertisers_Report_{reportgenerationdate}", $this->siteLangId)) . '.csv', ',');
            exit;
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();

        $arrListing = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', array_keys($fields));
    }

    public function export()
    {
        $this->search('export');
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'product_name', applicationConstants::SORT_ASC);
        }

        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addDateField(Labels::getLabel('FRM_REG._DATE_FROM', $this->siteLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_REG._DATE_TO', $this->siteLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-outline-brand');

        return $frm;
    }

    protected function getFormColumns()
    {
        $avdertiserUserReportsCacheVar = FatCache::get('avdertiserUserReportsCacheVar' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$avdertiserUserReportsCacheVar) {
            $arr = [
                'name' => Labels::getLabel('LBL_Name', $this->siteLangId),
                'user_regdate' => Labels::getLabel('LBL_Registration_Date', $this->siteLangId),
                'user_is_supplier' => Labels::getLabel('LBL_Is_Seller', $this->siteLangId),
                'promotionsCount' => Labels::getLabel('LBL_Total_Promotions', $this->siteLangId),
                'activePromotions' => Labels::getLabel('LBL_Active_Promotions', $this->siteLangId),
                'promotionCharged' => Labels::getLabel('LBL_Promotions_Cost', $this->siteLangId),
                'availableBalance' => Labels::getLabel('LBL_Available_Balance', $this->siteLangId),
            ];
            FatCache::set('avdertiserUserReportsCacheVar' . $this->siteLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($avdertiserUserReportsCacheVar);
        }

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return ['name', 'user_regdate', 'user_is_supplier', 'promotionsCount', 'activePromotions', 'promotionCharged', 'availableBalance'];
    }
}
