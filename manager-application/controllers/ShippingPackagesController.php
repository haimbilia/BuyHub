<?php

class ShippingPackagesController extends ListingBaseController {

    protected string $modelClass = 'ShippingPackage';
    protected $pageKey = 'MANAGE_SHIPPING_PACKAGES';

    public function __construct($action) {
        parent::__construct($action);
        if (1 > FatApp::getConfig("CONF_PRODUCT_DIMENSIONS_ENABLE", FatUtility::VAR_INT, 1)) {
            $msg = Labels::getLabel('LBL_PLEASE_TURN_ON_PRODUCT_DIMENSION_SETTING_FIRST_GENERAL_SETTINGS_>_PRODUCT', $this->siteLangId);
            Message::addErrorMessage($msg);
            FatApp::redirectUser(UrlHelper::generateUrl('configurations'));
        }
        $this->objPrivilege->canViewShippingPackages();
    }

    public function index() {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj));
        $this->set('actionItemsData', $actionItemsData);
        $this->set('canEdit', $this->objPrivilege->canEditShippingPackages($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->getListingData();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'shipping-packages/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData() {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }
        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchForm($fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $srch = ShippingPackage::getSearchObject();
        $srch->addOrder('shippack_name', 'ASC');
        if (!empty($post['keyword'])) {
            $srch->addCondition('spack.shippack_name', 'like', '%' . $post['keyword'] . '%');
        }
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditBrands($this->admin_id, true));
    }

    public function form() {
        $this->objPrivilege->canEditShippingPackages();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm();
        if (0 < $recordId) {
            $data = ShippingPackage::getAttributesById($recordId);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }
        $this->set('includeTabs', false);
        $this->set('languages', []);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false, '_partial/listing/form.php');
    }

    public function setup() {
        $this->objPrivilege->canEditShippingPackages();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (empty($post)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $packageName = FatApp::getPostedData('shippack_name', FatUtility::VAR_STRING, '');
        $recordId = FatUtility::int(ShippingPackage::getPackageIdByName($packageName));
        $packageId = $post['shippack_id'];
        if (0 < $recordId && $packageId != $recordId) {
            LibHelper::exitWithError(Labels::getLabel('LBL_THIS_PACKAGE_NAME_ALREDY_IN_USE.', $this->siteLangId));
        }
        unset($post['shippack_id']);
        $spObj = new ShippingPackage($packageId);
        $spObj->assignValues($post);
        if (!$spObj->save()) {
            LibHelper::exitWithError($spObj->getError());
        }

        $this->set('msg', Labels::getLabel('SUC_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm() {
        $frm = new Form('frmShippingPackages');
        $frm->addHiddenField('', 'shippack_id');
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_PACKAGE_NAME', $this->siteLangId), 'shippack_name');
        $frm->addFloatField(Labels::getLabel('FRM_LENGTH', $this->siteLangId), 'shippack_length');
        $frm->addFloatField(Labels::getLabel('FRM_WIDTH', $this->siteLangId), 'shippack_width');
        $frm->addFloatField(Labels::getLabel('FRM_HEIGHT', $this->siteLangId), 'shippack_height');
        $frm->addSelectBox(Labels::getLabel('FRM_UNIT', $this->siteLangId), 'shippack_units', ShippingPackage::getUnitTypes($this->siteLangId), '', [], Labels::getLabel('LBL_SELECT', $this->siteLangId));

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    public function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        $frm->setFormTagAttribute('class', 'actionButtonsJs');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'shippack_id');
        }
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getFormColumns(): array {
        $shopsTblHeadingCols = CacheHelper::get('shippingPackTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols);
        }
        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'shippack_name' => Labels::getLabel('LBL_NAME', $this->siteLangId),
            'shippack_units' => Labels::getLabel('LBL_DIMENSIONS', $this->siteLangId),
            'action' => '',
        ];
        CacheHelper::create('shippingPackTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array {
        return [
            'listSerial',
            'shippack_name',
            'shippack_units',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['shippack_units'], Common::excludeKeysForSort());
    }

}
