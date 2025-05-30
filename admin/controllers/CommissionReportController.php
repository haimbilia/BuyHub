<?php

class CommissionReportController extends ListingBaseController
{
    private $canView;
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewCommissionReport($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditCommissionReport($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewCommissionReport();
        $frmSearch = $this->getSearchForm();
        $this->set('frmSearch', $frmSearch);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $this->objPrivilege->canViewCommissionReport();
        $db = FatApp::getDb();

        $srchFrm = $this->getSearchForm();
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $attr = array('op_shop_name', 'op.op_selprod_user_id', 'o.order_id', 'op.op_id', 'count(op.op_id) as totChildOrders', 'seller.user_name as owner_name', 'seller_cred.credential_email as owner_email', 'sum(( op_unit_price * op_qty ) + op_other_charges - op_refund_amount) as total_sales', 'SUM(op_commission_charged - op_refund_commission) as total_commission');
        $srch = Report::salesReportObject($this->siteLangId, true, $attr);

        $srch->addGroupBy('op.op_shop_id');
        /* $srch->addMultipleFields( array('op_shop_name', 'op.op_selprod_user_id', 'o.order_id', 'op.op_id', 'count(op.op_id) as totChildOrders', 'seller.user_name as owner_name','seller_cred.credential_email as owner_email', 'sum(( op_unit_price * op_qty ) + op_other_charges - op_refund_amount) as total_sales', 'SUM(op_commission_charged - op_refund_commission) as total_commission') ); */

        $op_shop_id = FatApp::getPostedData('op_shop_id', null, '');
        $shop_keyword = FatApp::getPostedData('shop_name', null, '');
        if ($op_shop_id) {
            $op_shop_id = FatUtility::int($op_shop_id);
            $srch->addCondition('op.op_shop_id', '=', $op_shop_id);
        }

        $op_selprod_user_id = FatApp::getPostedData('op_selprod_user_id', null, '');
        $shop_owner_keyword = FatApp::getPostedData('user_name', null, '');
        if ($op_selprod_user_id) {
            $op_selprod_user_id = FatUtility::int($op_selprod_user_id);
            $srch->addCondition('op.op_selprod_user_id', '=', $op_selprod_user_id);
        }

        if ($op_shop_id == 0 and $op_selprod_user_id == 0 and $shop_keyword != '') {
            $cond = $srch->addCondition('op_shop_name', '=', $shop_keyword);
            $cond->attachCondition('op_shop_name', 'like', '%' . $shop_keyword . '%', 'OR');
        }

        if ($op_shop_id == 0 and $op_selprod_user_id == 0 and $shop_owner_keyword != '') {
            $cond1 = $srch->addCondition('user_name', '=', $shop_owner_keyword);
            $cond1->attachCondition('user_name', 'like', '%' . $shop_owner_keyword . '%', 'OR');
            $cond1->attachCondition('credential_email', 'like', '%' . $shop_owner_keyword . '%');
        }

        if ($type == 'export') {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();
            $arr = array(Labels::getLabel("LBL_SHOP_NAME", $this->siteLangId), Labels::getLabel("LBL_OWNER", $this->siteLangId), Labels::getLabel("LBL_SALES", $this->siteLangId), Labels::getLabel("LBL_COIMMISSION", $this->siteLangId));
            array_push($sheetData, $arr);
            while ($row = $db->fetch($rs)) {
                $arr = array($row['op_shop_name'], $row['owner_name'] . "\n(" . $row['owner_email'] . ")", CommonHelper::displayMoneyFormat($row['total_sales'], true, true), CommonHelper::displayMoneyFormat($row['total_commission'], true, true));
                array_push($sheetData, $arr);
            }
            $name = CommonHelper::replaceStringData(Labels::getLabel("LBL_COMMISSION_REPORT_{GENERATIONDATE}", $this->siteLangId), ["{generationdate}" => date("d-M-Y")]);
            CommonHelper::convertToCsv($sheetData, $name . '.csv', ',');
            exit;
        } else {
            $srch->setPageNumber($page);
            $srch->setPageSize($pageSize);
            $rs = $srch->getResultSet();
            $arrListing = $db->fetchAll($rs);
            $this->set("arrListing", $arrListing);
            $this->set('pageCount', $srch->pages());
            $this->set('recordCount', $srch->recordCount());
            $this->set('page', $page);
            $this->set('pageSize', $pageSize);
            $this->set('postedData', $post);
            $this->set('html', $this->_template->render(false, false, NULL, true));
            $this->_template->render(false, false, 'json-success.php', true, false);
        }
    }

    public function export()
    {
        $this->search('export');
    }

    public function getSearchForm(array $fields = [])
    {
        $frm = new Form('frmCommissionReportSearch');
        $frm->addHiddenField('', 'page', 1);

        $frm->addTextBox(Labels::getLabel('FRM_SHOP', $this->siteLangId), 'shop_name');
        $frm->addHiddenField('', 'op_shop_id', 0);

        $frm->addTextBox(Labels::getLabel('FRM_SHOP_OWNER', $this->siteLangId), 'user_name');
        $frm->addHiddenField('', 'op_selprod_user_id', 0);

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }
}
