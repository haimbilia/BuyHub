<?php

class AffiliatesReportController extends AdminBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAffiliatesReport();
    }

    public function index($orderDate = '')
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('fields', $fields);
        $this->_template->addJs('js/report.js');
        $this->_template->render();
    }

    public function search($type = false)
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current(array_keys($fields)));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current(array_keys($fields));
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_DESC;
        }
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $srch = new UserSearch();
        $srch->includeTransactionBalance();
        $srch->includeAffiliateUserRevenue();
        $srch->includeAffiliateUsersCount();
        $srch->addMultipleFields(
            array(
                'u.user_name as name', 'uc.credential_email as email', 'u.user_regdate', 'totAffilateRevenue', 'totAffilateSignupRevenue', 'totAffilateOrdersRevenue', 'totAffiliatedUsers', 'u.user_referral_code'
            )
        );
        $srch->addCondition('u.user_is_affiliate', '=', applicationConstants::YES);

        $date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('u.user_regdate', '>=', $date_from . ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('u.user_regdate', '<=', $date_to . ' 23:59:59');
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
                        case 'affiliateLink':
                            $arr[] = UrlHelper::generateFullUrl('Home', 'referral', [$row['user_referral_code']], CONF_WEBROOT_FRONTEND);
                            break;
                        case 'name':
                            $name = $row['name'] . "\n" . $row['email'];
                            $arr[] = $name;
                            break;
                        case 'availableBalance':
                        case 'totAffilateRevenue':
                        case 'totAffilateSignupRevenue':
                        case 'totAffilateOrdersRevenue':
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

            CommonHelper::convertToCsv($sheetData, str_replace("{reportgenerationdate}", date("d-M-Y"), Labels::getLabel("LBL_Affiliates_Report_{reportgenerationdate}", $this->adminLangId)) . '.csv', ',');
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
        $frm->addDateField(Labels::getLabel('LBL_Reg._Date_From', $this->adminLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Reg._Date_To', $this->adminLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'name');
            $frm->addHiddenField('', 'sortOrder', applicationConstants::SORT_ASC);
            $frm->addHiddenField('', 'reportColumns', '');
            /* $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->adminLangId), 'sortBy', $fields, '', array(), '');
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->adminLangId), 'sortOrder', applicationConstants::sortOrder($this->adminLangId), 0, array(),  ''); */
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);

        return $frm;
    }

    private function getFormColumns()
    {
        $affiliatesUserReportsCacheVar = CacheHelper::get('affiliatesUserReportsCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$affiliatesUserReportsCacheVar) {
            $arr = [
                'name' => Labels::getLabel('LBL_Name', $this->adminLangId),
                'user_regdate' => Labels::getLabel('LBL_Registration_Date', $this->adminLangId),
                'totAffiliatedUsers' => Labels::getLabel('LBL_Affiliate_Registered', $this->adminLangId),
                'availableBalance' => Labels::getLabel('LBL_Available_Balance', $this->adminLangId),
                'totAffilateRevenue' => Labels::getLabel('LBL_Total_Revenue', $this->adminLangId),
                'totAffilateSignupRevenue' => Labels::getLabel('LBL_SignUps_Revenue', $this->adminLangId),
                'totAffilateOrdersRevenue' => Labels::getLabel('LBL_Orders_Revenue', $this->adminLangId),
                'affiliateLink' => Labels::getLabel('LBL_Affiliate_link', $this->adminLangId),
            ];
            CacheHelper::create('affiliatesUserReportsCacheVar' . $this->adminLangId, serialize($arr), CacheHelper::TYPE_LABELS);
        } else {
            $arr =  unserialize($affiliatesUserReportsCacheVar);
        }

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['name', 'user_regdate', 'totAffiliatedUsers', 'availableBalance', 'totAffilateRevenue', 'totAffilateSignupRevenue', 'totAffilateOrdersRevenue', 'affiliateLink'];
    }
}
