<?php

class TransactionReportController extends AdminBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewFinancialReport();
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
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'name');
        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, 'DESC');
        $keyword = FatApp::getPostedData('keyword', null, '');
        $fromDate = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        $toDate = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');

        $srch = Transactions::getSearchObject();
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'u.user_id = utxn.utxn_user_id', 'u');
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'uc.credential_user_id = u.user_id', 'uc');
        $srch->addMultipleFields(['utxn.utxn_id', 'utxn.utxn_order_id', 'utxn.utxn_status', 'utxn.utxn_credit', 'utxn.utxn_debit', 'utxn.utxn_date', 'utxn.utxn_comments', 'if(utxn.utxn_credit > 0, utxn.utxn_credit, if(utxn.utxn_debit>0,CONCAT("-", utxn.utxn_debit),0)) as transactionAmount', 'u.user_name', 'uc.credential_email']);
        if (!empty($keyword)) {
            $cond = $srch->addCondition('utxn.utxn_order_id', 'like', '%' . $keyword . '%');
            $cond->attachCondition('utxn.utxn_op_id', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('utxn.utxn_comments', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('concat("TN-" ,lpad( utxn.`utxn_id`,7,0))', 'like', '%' . $keyword . '%', 'OR', true);
            $cond->attachCondition('u.user_name', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('uc.credential_email', 'like', '%' . $keyword . '%', 'OR');
        }

        if (!empty($fromDate)) {
            $cond = $srch->addCondition('utxn.utxn_date', '>=', $fromDate);
        }

        if (!empty($toDate)) {
            $cond = $srch->addCondition('cast( utxn.`utxn_date` as date)', '<=', $toDate, 'and', true);
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
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
            $statusArr = Transactions::getStatusArr($this->adminLangId);
            while ($row = FatApp::getDb()->fetch($rs)) {
                $arr = [];
                foreach ($fields as $key => $val) {
                    switch ($key) {
                        case 'listserial':
                            $arr[] = $count;
                            break;
                        case 'utxn_id':
                            $arr[] = Transactions::formatTransactionNumber($row[$key]);
                            break;
                        case 'utxn_date':
                            $arr[] = FatDate::format($row[$key]);
                            break;
                        case 'utxn_date':
                            $name = $row[$key];
                            $name .= !empty($row['credential_email']) ? ' (' . $row['credential_email'] . ')' : '';
                            $arr[] = $name;
                            break;
                        case 'utxn_status':
                            $arr[] = $statusArr[$row[$key]];
                            break;
                        case 'utxn_credit':
                        case 'utxn_debit':
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

            CommonHelper::convertToCsv($sheetData, Labels::getLabel("LBL_Transaction_Report", $this->adminLangId) . '.csv', ',');
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

        $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->adminLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->adminLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));

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
        $transcationReportsCacheVar = FatCache::get('transcationReportsCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$transcationReportsCacheVar) {
            $arr = [
                'utxn_date' => Labels::getLabel('LBL_Date', $this->adminLangId),
                'utxn_id' => Labels::getLabel('LBL_Transaction_ID', $this->adminLangId),
                'user_name' => Labels::getLabel('LBL_Name', $this->adminLangId),
                'utxn_status' => Labels::getLabel('LBL_Payment_Status', $this->adminLangId),
                'utxn_order_id' => Labels::getLabel('LBL_Order_Id', $this->adminLangId),
                'utxn_credit' => Labels::getLabel('LBL_Credit', $this->adminLangId),
                'utxn_debit' => Labels::getLabel('LBL_Debit', $this->adminLangId),
                'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $this->adminLangId),
                'utxn_comments' => Labels::getLabel('LBL_Comments', $this->adminLangId),
            ];
            FatCache::set('transcationReportsCacheVar' . $this->adminLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($transcationReportsCacheVar);
        }

        return $arr;
    }
}
