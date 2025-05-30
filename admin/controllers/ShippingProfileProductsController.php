<?php

class ShippingProfileProductsController extends ListingBaseController
{

    protected $modelClass = 'ShippingProfileProduct';
    protected $pageKey = 'MANAGE_SHIPPING_PROFILE_PRODUCT';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewShippingManagement();
    }

    public function index($profileId)
    {
        $this->set("frm", $this->getProductSearchForm($profileId));
        $this->set('profileId', $profileId);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function search($profileId = 0)
    {
        $profileId = FatApp::getPostedData('shippro_shipprofile_id', FatUtility::VAR_INT, $profileId);
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);

        $srch = ShippingProfileProduct::getSearchObject();
        $srch->addCondition('shippro_shipprofile_id', '=', $profileId);
        $srch->addCondition('shippro_user_id', '=', 0);
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $srch->addCondition('p_l.product_name', 'like', '%' . $post['keyword'] . '%');
        }
        $srch->addCondition(Product::DB_TBL_PREFIX . 'type', '=', Product::PRODUCT_TYPE_PHYSICAL);
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->addOrder('product_name', 'ASC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $this->set('productsData', FatApp::getDb()->fetchAll($srch->getResultSet()));
        $this->set('profileData', ShippingProfile::getAttributesById($profileId));
        $this->set('profile_id', $profileId);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function autoComplete()
    {
        $post = FatApp::getPostedData();
        $shipProfileId = FatApp::getPostedData('shipProfileId', FatUtility::VAR_INT, 0);
        $srch = new ProductSearch($this->siteLangId);
        $srch->addOrder('product_name');
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('product_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('product_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->addCondition(Product::DB_TBL_PREFIX . 'type', '=', Product::PRODUCT_TYPE_PHYSICAL);
        $srch->addCondition(Product::DB_TBL_PREFIX . 'active', '=', applicationConstants::YES);
        $srch->addCondition(Product::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);

        $srch->addMultipleFields(array('product_id as id', 'COALESCE(product_name, product_identifier) as product_name'));

        if (0 < $shipProfileId) {
            $srch->joinTable(ShippingProfileProduct::DB_TBL, 'LEFT OUTER JOIN', 'p.product_id = sppro.shippro_product_id and sppro.shippro_user_id = ' . applicationConstants::NO, 'sppro');
            $cnd = $srch->addCondition(ShippingProfileProduct::DB_TBL_PREFIX . 'shipprofile_id', '!=', $shipProfileId);
        }

        $srch->addGroupBy('product_id');
        $rs = $srch->getResultSet();
        $products = FatApp::getDb()->fetchAll($rs, 'id');
        $pageCount = $srch->pages();

        $json = array();
        foreach ($products as $key => $option) {
            $json[] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($option['product_name'], ENT_QUOTES, 'UTF-8')),
            );
        }
        die(json_encode(['pageCount' => $pageCount, 'results' => $json]));
    }

    public function form($profileId)
    {
        $this->objPrivilege->canEditShippingManagement();
        $profileId = FatUtility::int($profileId);
        $this->set('profile_id', $profileId);
        $this->set('frm', $this->getForm($profileId));
        $this->set('languages', []);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditShippingManagement();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false == $post) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $productId = FatApp::getPostedData('shippro_product_id', FatUtility::VAR_INT, 0);
        if (1 > $productId) {
            LibHelper::exitWithError(Labels::getLabel('LBL_INVALID_PRODUCT', $this->siteLangId), true);
        }

        $prodType = Product::getAttributesById($post['shippro_product_id'], 'product_type');
        if (Product::PRODUCT_TYPE_DIGITAL == $prodType) {
            LibHelper::exitWithError(Labels::getLabel('LBL_DIGITAL_PRODUCTS_ARE_NOT_ALLOWED', $this->siteLangId), true);
        }

        $data = array(
            'shippro_user_id' => 0,
            'shippro_product_id' => FatApp::getPostedData('shippro_product_id', FatUtility::VAR_INT, 0),
            'shippro_shipprofile_id' => FatApp::getPostedData('shippro_shipprofile_id', FatUtility::VAR_INT, 0)
        );

        $spObj = new ShippingProfileProduct();
        if (!$spObj->addProduct($data)) {
            LibHelper::exitWithError($spObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeProduct($productId)
    {
        $this->objPrivilege->canEditShippingManagement();
        $defaultProfileId = ShippingProfile::getDefaultProfileId(0);
        /* [ REMOVE PRODUCT FROM CURRENT PROFILE AND ADD TO DEFAULT PROFILE */
        $data = array(
            'shippro_shipprofile_id' => $defaultProfileId,
            'shippro_product_id' => $productId
        );

        $spObj = new ShippingProfileProduct();
        if (!$spObj->addProduct($data)) {
            LibHelper::exitWithError($spObj->getError(), true);
        }
        /* ] */

        $this->set('msg', Labels::getLabel('MSG_PRODUCT_REMOVED_FROM_CURRENT_PROFILE.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($profileId = 0)
    {
        $profileId = FatUtility::int($profileId);
        $frm = new Form('frmProfileProducts');
        $frm->addHiddenField('', 'shippro_shipprofile_id', $profileId)->requirement->setRequired(true);
        $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT_NAME', $this->siteLangId), 'shippro_product_id', [])->requirement->setRequired(true);
        $htm = '<div class="alert alert-solid-brand mt-5" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i>
                    </div>
                    <div class="alert-text text-xs">' . Labels::getLabel("LBL_Product_will_automatically_remove_from_other_profile", $this->siteLangId) . '</div>
                </div>';
        $frm->addHtml('', 'shippro_products_text', $htm);    
        return $frm;
    }

    public function getProductSearchForm($profileId, $fields = [])
    {

        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('FRM_PRODUCT_NAME', 'shippro_shipprofile_id', $profileId)->requirement->setRequired(true);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input omni-search'));
        $fld->overrideFldType('search');
        $frm->addHiddenField('', 'total_record_count');
        return $frm;
    }
}
