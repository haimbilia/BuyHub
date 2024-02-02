<?php

class ShippingProfileProductsController extends SellerBaseController {

    public function __construct($action) {
        parent::__construct($action);
        $this->userPrivilege->canViewShippingProfiles(UserAuthentication::getLoggedUserId());
    }

    public function index($profileId) {
        $frm = $this->getForm($profileId);
        $this->set("frm", $frm);
        $this->_template->render(false, false);
    }

    public function search($profileId) {
        $pageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);

        $srch = ShippingProfileProduct::getSearchObject($this->siteLangId);
        $srch->addCondition('shippro_shipprofile_id', '=', $profileId);
        $srch->addCondition('shippro_user_id', '=', $this->userParentId);
        $srch->addCondition(Product::DB_TBL_PREFIX . 'type', '=', Product::PRODUCT_TYPE_PHYSICAL);
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addOrder('product_name', 'ASC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);   
        $this->set('productsData', FatApp::getDb()->fetchAll($srch->getResultSet()));
        $this->set('profileId', $profileId);
        $this->set('profileData', ShippingProfile::getAttributesById($profileId));
        $this->set('postedData', $post);
        $this->set('canEdit', $this->userPrivilege->canEditShippingProfiles(UserAuthentication::getLoggedUserId(), true));
        $this->_template->render(false, false);
    }

    public function setup() {
        $this->userPrivilege->canEditShippingProfiles(UserAuthentication::getLoggedUserId());
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $prodType = Product::getAttributesById($post['shippro_product_id'], 'product_type');
        if (Product::PRODUCT_TYPE_DIGITAL == $prodType) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_DIGITAL_PRODUCTS_ARE_NOT_ALLOWED', $this->siteLangId));
        }

        $data = array(
            'shippro_user_id' => $this->userParentId,
            'shippro_shipprofile_id' => $post['shippro_shipprofile_id'],
            'shippro_product_id' => $post['shippro_product_id']
        );

        $spObj = new ShippingProfileProduct();
        if (!$spObj->addProduct($data)) {
            FatUtility::dieJsonError($spObj->getError());
        }
        $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeProduct($productId)
    {      
        $this->userPrivilege->canEditShippingProfiles(UserAuthentication::getLoggedUserId());
        $profSrch = ShippingProfileProduct::getSearchObject();
        $profSrch->addCondition('shippro_product_id', '=', $productId);
        $profSrch->addCondition('shippro_user_id', '=', $this->userParentId);
        $proRs = $profSrch->getResultSet();
        $profileData = FatApp::getDb()->fetch($proRs);
        if (empty($profileData)) {
            FatUtility::dieWithError($this->str_invalid_request);
        }
        $defaultProfileId = ShippingProfile::getDefaultProfileId($this->userParentId);
        /* [ REMOVE PRODUCT FROM CURRENT PROFILE AND ADD TO DEFAULT PROFILE */
        $data = array(
            'shippro_user_id' => $this->userParentId,
            'shippro_shipprofile_id' => $defaultProfileId,
            'shippro_product_id' => $productId
        );

        $spObj = new ShippingProfileProduct();
        if (!$spObj->addProduct($data)) {
            FatUtility::dieJsonError($spObj->getError());
        }
        /* ] */

        $this->set('msg', Labels::getLabel('MSG_PRODUCT_REMOVED_FROM_CURRENT_PROFILE.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($profileId = 0) {
        $profileId = FatUtility::int($profileId);
        $frm = new Form('frmProfileProducts');
        $frm->addHiddenField('', 'shippro_shipprofile_id', $profileId);
        $frm->addHiddenField('', 'shippro_product_id', '');
        $fld = $frm->addTextBox(Labels::getLabel('', $this->siteLangId), 'product_name');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    public function autoCompleteProducts(int $excludeAdmin = 0) {
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);
        $post = FatApp::getPostedData();
        $shipProfileId = FatApp::getPostedData('shipProfileId', FatUtility::VAR_INT, 0);
        $srch = new ProductSearch($this->siteLangId, null, null, false, false);
        $srch->joinProductShippedBySeller($this->userParentId);
        $srch->joinTable(AttributeGroup::DB_TBL, 'LEFT OUTER JOIN', 'product_attrgrp_id = attrgrp_id', 'attrgrp');
        $srch->joinTable(UpcCode::DB_TBL, 'LEFT OUTER JOIN', 'upc_product_id = product_id', 'upc');
        //$srch->joinTable(ShippingProfileProduct::DB_TBL, 'LEFT OUTER JOIN', 'product_id = sppro.shippro_product_id', 'sppro');


        if (User::canAddCustomProduct()) {
            $srch->addDirectCondition('((product_seller_id = 0 and psbs.psbs_user_id = ' . $this->userParentId . ') OR product_seller_id = ' . $this->userParentId . ')');
        } else {
            $cnd = $srch->addCondition('psbs.psbs_user_id', '=', $this->userParentId);
            if (1 > $excludeAdmin) {
                $cnd->attachCondition('product_seller_id', '=', 0, 'AND');
            }
        }

        $srch->addCondition(Product::DB_TBL_PREFIX . 'type', '=', Product::PRODUCT_TYPE_PHYSICAL);
        $srch->addCondition('product_deleted', '=', applicationConstants::NO);
        //$srch->addDirectCondition('sppro.shippro_product_id is null');

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('product_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('product_identifier', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('attrgrp_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('product_model', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('upc_code', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('product_upc', 'like', '%' . $keyword . '%');
        }

        if (0 < $shipProfileId) {
            $srch->joinTable(ShippingProfileProduct::DB_TBL, 'LEFT OUTER JOIN', 'p.product_id = sppro.shippro_product_id and shippro_user_id = ' . $this->userParentId, 'sppro');
            $srch->addCondition(ShippingProfileProduct::DB_TBL_PREFIX . 'shipprofile_id', '!=', $shipProfileId);
        }
        $srch->doNotCalculateRecords();
        $srch->addGroupBy('product_id');
        //echo $srch->getQuery();
        $srch->addMultipleFields(
                array(
                    'product_id as id', 'IFNULL(product_name, product_identifier) as product_name', 'product_identifier')
        );

        $srch->setPageSize($pagesize);
        $db = FatApp::getDb();

        $rs = $srch->getResultSet();

        $products = $db->fetchAll($rs, 'id');
        $json = array();
        foreach ($products as $key => $option) {
            $json[] = array(
                'id' => $key,
                'name' => strip_tags(html_entity_decode($option['product_name'], ENT_QUOTES, 'UTF-8')),
                'product_identifier' => strip_tags(html_entity_decode($option['product_identifier'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

}
