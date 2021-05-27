<?php

class AdvertisersReportController extends AdminBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAdvertisersReport();
    }

    public function index()
    {
        $flds = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($flds);
        $this->set('frmSearch', $frmSearch);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $fields = $this->getFormColumns();
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'name');
        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, 'DESC');
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
                            $yesNoArr = applicationConstants::getYesNoArr($this->adminLangId);
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

            CommonHelper::convertToCsv($sheetData, str_replace("{reportgenerationdate}", date("d-M-Y"), Labels::getLabel("LBL_Advertisers_Report_{reportgenerationdate}", $this->adminLangId)) . '.csv', ',');
            exit;
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();

        $arrListing = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->_template->render(false, false);
    }

    public function export()
    {
        $this->search('export');
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmReportSearch');
        $frm->addHiddenField('', 'page', 1);
        $frm->addTextBox(Labels::getLabel("LBL_Keyword", $this->adminLangId), 'keyword');
        $frm->addDateField(Labels::getLabel('LBL_Reg._Date_From', $this->adminLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Reg._Date_To', $this->adminLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        if (!empty($fields)) {
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->adminLangId), 'sortBy', $fields, '', array(), '');

            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->adminLangId), 'sortOrder', applicationConstants::sortOrder($this->adminLangId), 0, array(),  '');
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);

        return $frm;
    }

    private function getFormColumns()
    {
        $avdertiserUserReportsCacheVar = FatCache::get('avdertiserUserReportsCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$avdertiserUserReportsCacheVar) {
            $arr = [
                'name' => Labels::getLabel('LBL_Name', $this->adminLangId),
                'user_regdate' => Labels::getLabel('LBL_Registration_Date', $this->adminLangId),
                'user_is_supplier' => Labels::getLabel('LBL_Is_Seller', $this->adminLangId),
                'promotionsCount' => Labels::getLabel('LBL_Total_Promotions', $this->adminLangId),
                'activePromotions' => Labels::getLabel('LBL_Active_Promotions', $this->adminLangId),
                'promotionCharged' => Labels::getLabel('LBL_Promotions_Cost', $this->adminLangId),
                'availableBalance' => Labels::getLabel('LBL_Available_Balance', $this->adminLangId),
            ];
            FatCache::set('avdertiserUserReportsCacheVar' . $this->adminLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($avdertiserUserReportsCacheVar);
        }

        return $arr;
    }
}
