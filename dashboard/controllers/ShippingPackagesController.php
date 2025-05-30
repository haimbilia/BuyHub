<?php

class ShippingPackagesController extends SellerBaseController {

    public function __construct($action) {
        parent::__construct($action);
        if (1 > FatApp::getConfig("CONF_PRODUCT_DIMENSIONS_ENABLE", FatUtility::VAR_INT, 1)) {
            $msg = Labels::getLabel('LBL_PRODUCT_DIMENSION_SETTING_NOT_ENABLED', $this->siteLangId);
            Message::addErrorMessage($msg);
            CommonHelper::redirectUserReferer();
        }

        if (!FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }

        $this->userPrivilege->canViewShippingPackages(UserAuthentication::getLoggedUserId());
    }

    public function index() {
        $frmSearch = $this->getSearchForm();
        $this->set("frmSearch", $frmSearch);
        $this->set('canEdit', $this->userPrivilege->canEditShippingPackages(0, true));
        $this->set('keywordPlaceholder', Labels::getLabel('LBL_SEARCH_BY_SHIPPPING_PACKAGE_NAME', $this->siteLangId));
        $this->_template->render();
    }

    public function search() {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $post = $searchForm->getFormDataFromArray($data);
        $srch = ShippingPackage::getSearchObject();
        if (!empty($post['keyword'])) {
            $srch->addCondition('spack.shippack_name', 'like', '%' . $post['keyword'] . '%');
        }
        $this->setRecordCount(clone $srch, $pagesize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addOrder('shippack_name', 'ASC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set('arrListing', $records);
        $this->set('unitTypeArray', ShippingPackage::getUnitTypes($this->siteLangId));
        $this->set('postedData', $post);
        $this->set('canEdit', $this->userPrivilege->canEditShippingPackages(0, true));
        if (FatApp::getPostedData('popup', FatUtility::VAR_INT, 0)) {
            $this->_template->render(false, false, 'shipping-packages/search-popup.php');
            return;
        }
        $this->_template->render(false, false);
    }

    public function form($packageId = 0) {
        $this->userPrivilege->canEditShippingPackages();
        $packageId = FatUtility::int($packageId);
        $data = array();
        $frm = $this->getForm();
        if (0 < $packageId) {
            $data = ShippingPackage::getAttributesById($packageId);
            if (empty($data)) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
            $frm->fill($data);
        }
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    private function getSearchForm() {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'total_record_count');
        $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('placeholder' => Labels::getLabel('FRM_KEYWORD', $this->siteLangId)));
        
        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    private function getForm() {
        $unitTypeArray = ShippingPackage::getUnitTypes($this->siteLangId);
        $frm = new Form('frmShippingPackages');
        $frm->addHiddenField('', 'shippack_id');
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_PACKAGE_NAME', $this->siteLangId), 'shippack_name');
        $frm->addFloatField(Labels::getLabel('FRM_LENGTH', $this->siteLangId), 'shippack_length');
        $frm->addFloatField(Labels::getLabel('FRM_WIDTH', $this->siteLangId), 'shippack_width');
        $frm->addFloatField(Labels::getLabel('FRM_HEIGHT', $this->siteLangId), 'shippack_height');

        $frm->addSelectBox(Labels::getLabel('FRM_UNIT', $this->siteLangId), 'shippack_units', $unitTypeArray, '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));

        return $frm;
    }

}
