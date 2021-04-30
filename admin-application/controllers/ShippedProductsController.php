<?php

class ShippedProductsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewShippedProducts();
    }

    public function index()
    {
        $this->objPrivilege->canViewShippedProducts();
        $frmSearch = $this->getShippedProducts();
        $this->set('frmSearch', $frmSearch);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewShippedProducts();
        // $frmSearch = $this->getShippedProducts();
        $data = FatApp::getPostedData();
        $keyword = FatApp::getPostedData('keyword', null, '');
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : FatUtility::int($data['page']);
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $srch = ShippingProfileProduct::getAdminShippedProdcutsObj(true);
        $srch->addCondition('product_added_by_admin_id', '=', applicationConstants::YES);
        $srch->addCondition('product_deleted', '=', applicationConstants::NO);
        $srch->addCondition('spprot.shippro_user_id', '=', '0');
        if (!empty($keyword)) {
            $srch->addCondition('tp_l.product_name', 'like', '%' . $keyword . '%');
        }
        $srch->addMultipleFields(array('sppro.shippro_product_id, tp_l.product_name, spprof.shipprofile_name, tp.product_added_by_admin_id'));
        $srch->addGroupBy('sppro.shippro_product_id');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $records);
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->_template->render(false, false);
    }

    private function getShippedProducts() 
    {
        $frm = new Form('frmShippedProductsSearch');
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword', '', array('id' => 'keyword', 'autocomplete' => 'off'));
        $fld_submit = $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'user_id');
        return $frm;
    }

}