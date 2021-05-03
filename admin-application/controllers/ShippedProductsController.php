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
        $data = FatApp::getPostedData();
        $keyword = FatApp::getPostedData('keyword', null, '');
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : FatUtility::int($data['page']);
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        // $srch = ShippingProfileProduct::getAdminShippedProdcutsObj($this->adminLangId);
        $srch = new ShippedProducts();
        $srch->joinProduct();
        $srch->joinProductLang($this->adminLangId);
        $srch->joinShippingProfile();
        $srch->addProductByAdminCondition();
        $srch->addProductDeletedCondition();
        $srch->addProductAdminShipCondition();
        $srch->addPhyProductCheckCondition();
        if (!empty($keyword)) {
            $srch->addCondition('tp_l.product_name', 'like', '%' . $keyword . '%');
        }
        $srch->addMultipleFields(array('sppro.shippro_shipprofile_id, sppro.shippro_product_id, ifnull(tp_l.product_name, tp.product_identifier) as product_name, spprof.shipprofile_name, tp.product_added_by_admin_id'));
        $srch->addGroupBy('sppro.shippro_product_id');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder('shippro_product_id', 'DESC');
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);


        /* Get Seller Inventory Catelog */
        if(!empty($records)) {
            $sellerShippingCount = [];
            $prodIdArr = array_column($records, 'shippro_product_id');
            foreach($prodIdArr as $kay => $prodId) {
                $selProd = new ShippedProducts(applicationConstants::YES);
                $selProd->joinProduct(applicationConstants::YES);
                $selProd->joinUserTable();
                $selProd->joinShippedBySeller();
                $selProd->addProductDeletedCondition();
                $selProd->addPhyProductCheckCondition();
                $selProd->addCondition('tp.product_id', '=', $prodId);
                $selProd->addMultipleFields(array('u.user_name'));
                // $selProd->addGroupBy('tp.product_id');
                $res = $selProd->getResultSet();
                $results = FatApp::getDb()->fetchAll($res);
            
                // echo count($results);die;
                // echo $selProd->getQuery();die;
                // CommonHelper::printArray($results);die;

               $records[$kay]['total_seller_ship'] = (count($results) > 0) ? count($results) : 0;
            }
        }
        /* End here */

        $this->set("arrListing", $records);
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('canEdit', $this->objPrivilege->canEditShippedProducts(0, true));
        $this->_template->render(false, false);
    }

    public function updateProductsShipping($productId, $shipProfileId)
    {
        $this->objPrivilege->canEditShippedProducts();
        $productId = FatUtility::int($productId);
        $shipProfileId = FatUtility::int($shipProfileId);

        if (1 > $productId || 1 > $shipProfileId) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $data = array('productId' => $productId, 'shipping_profile' => $shipProfileId);
        $frm = $this->productsShippingForm();
        $frm->fill($data);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditShippedProducts();
        $frm = $this->productsShippingForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        if (1 > $post['productId']) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        if (isset($post['shipping_profile']) && $post['shipping_profile'] > 0) {
            $shipProProdData = array(
                'shippro_shipprofile_id' => $post['shipping_profile'],
                'shippro_product_id' => $post['productId'],
                'shippro_user_id' => 0
            );
            $spObj = new ShippingProfileProduct();
            if (!$spObj->addProduct($shipProProdData)) {
                Message::addErrorMessage($spObj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
        }
        $this->set('msg', Labels::getLabel('LBL_Shipping_Updated_Successfully', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getShippedProducts()
    {
        $frm = new Form('frmShippedProductsSearch');
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword', '', array('id' => 'keyword', 'autocomplete' => 'off'));
        $fld_submit = $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function productsShippingForm()
    {
        $frm = new Form('productsShippingForm');
        $shipProfileArr = ShippingProfile::getProfileArr(0, true, true);
        $frm->addSelectBox(Labels::getLabel('LBL_Shipping_Profile', $this->adminLangId), 'shipping_profile', $shipProfileArr, '', [], Labels::getLabel('LBL_Select', $this->adminLangId))->requirements()->setRequired();
        $frm->addHiddenField('', 'productId', 0);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Update', $this->adminLangId));
        return $frm;
    }
}
