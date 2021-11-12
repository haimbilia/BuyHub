<?php

class ImportExportController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewImportExport();
    }

    public function index()
    {
        $this->_template->addJs(['js/import-export.js']);
        $this->set('action', 'export'); /* To load initial Tab. */
        $this->set('includeDropZone', true);
        $this->_template->render();
    }

    public function exportData($actionType)
    {
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $exportDataRange = FatApp::getPostedData('export_data_range', FatUtility::VAR_INT, 0);
        $startId = FatApp::getPostedData('start_id', FatUtility::VAR_INT, 0);
        $endId = FatApp::getPostedData('end_id', FatUtility::VAR_INT, 0);
        $batchCount = FatApp::getPostedData('batch_count', FatUtility::VAR_INT, 0);
        $batchNumber = FatApp::getPostedData('batch_number', FatUtility::VAR_INT, 1);
        $sheetType = FatApp::getPostedData('sheet_type', FatUtility::VAR_INT, 0);
        $pluginId = FatApp::getPostedData('plugin_id', FatUtility::VAR_INT, 0);

        if (1 > $langId) {
            $langId = CommonHelper::getLangId();
        }

        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
                $this->objPrivilege->canViewProductCategories();
                break;
            case Importexport::TYPE_PRODUCTS:
            case Importexport::TYPE_SELLER_PRODUCTS:
                $this->objPrivilege->canViewProducts();
                break;
            case Importexport::TYPE_BRANDS:
                $this->objPrivilege->canViewBrands();
                break;
            case Importexport::TYPE_INVENTORIES:
                $this->objPrivilege->canViewSellerProducts();
                break;
            case Importexport::TYPE_OPTIONS:
            case Importexport::TYPE_OPTION_VALUES:
                $this->objPrivilege->canViewOptions();
                break;
            case Importexport::TYPE_TAG:
                $this->objPrivilege->canViewTags();
                break;
            case Importexport::TYPE_COUNTRY:
                $this->objPrivilege->canViewCountries();
                break;
            case Importexport::TYPE_STATE:
                $this->objPrivilege->canViewStates();
                break;
            case Importexport::TYPE_POLICY_POINTS:
                $this->objPrivilege->canViewPolicyPoints();
                break;
            case Importexport::TYPE_USERS:
                $this->objPrivilege->canViewUsers();
                break;
            case Importexport::TYPE_TAX_CATEGORY:
                $this->objPrivilege->canViewTax();
                break;
            case Importexport::TYPE_ORDER_PRODUCTS:
                $this->objPrivilege->canViewOrders();
                break;
            default:
                Message::addErrorMessage($this->str_invalid_request);
                break;
        }

        $obj = new Importexport();
        if (0 < $pluginId) {
            $obj->setPluginId($pluginId);
        }
        $min = null;
        $max = null;
        switch ($exportDataRange) {
            case Importexport::BY_ID_RANGE:
                if (isset($startId) && $startId > 0) {
                    $min = $startId;
                }

                if (isset($endId) && $endId > 1 && $endId > $min) {
                    $max = $endId;
                }
                $obj->export($actionType, $langId, $sheetType, null, null, $min, $max);
                break;
            case Importexport::BY_BATCHES:
                if (isset($batchNumber) && $batchNumber > 0) {
                    $min = $batchNumber;
                }

                $max = Importexport::MAX_LIMIT;
                if (isset($batchCount) && $batchCount > 0 && $batchCount <= Importexport::MAX_LIMIT) {
                    $max = $batchCount;
                }
                $min = (!$min) ? 1 : $min;
                $obj->export($actionType, $langId, $sheetType, $min, $max, null, null);
                break;

            default:
                $obj->export($actionType, $langId, $sheetType, null, null, null, null);
                break;
        }
    }

    public function importData($actionType)
    {
        if (!is_uploaded_file($_FILES['import_file']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Please_Select_A_CSV_File', $this->siteLangId), true);
        }

        $obj = new Importexport();
        if (!$obj->isUploadedFileValidMimes($_FILES['import_file'])) {
            LibHelper::exitWithError(Labels::getLabel("LBL_Not_a_Valid_CSV_File", $this->siteLangId), true);
        }

        $sheetType = FatApp::getPostedData('sheet_type', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);

        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
                $this->objPrivilege->canEditProductCategories();
                break;
            case Importexport::TYPE_BRANDS:
                $this->objPrivilege->canEditBrands();
                break;
            case Importexport::TYPE_PRODUCTS:
            case Importexport::TYPE_SELLER_PRODUCTS:
                $this->objPrivilege->canEditProducts();
                break;
            case Importexport::TYPE_INVENTORIES:
                $this->objPrivilege->canEditSellerProducts();
                break;
            case Importexport::TYPE_OPTIONS:
            case Importexport::TYPE_OPTION_VALUES:
                $this->objPrivilege->canEditOptions();
                break;
            case Importexport::TYPE_TAG:
                $this->objPrivilege->canEditTags();
                break;
            case Importexport::TYPE_COUNTRY:
                $this->objPrivilege->canEditCountries();
                break;
            case Importexport::TYPE_STATE:
                $this->objPrivilege->canEditStates();
                break;
            case Importexport::TYPE_POLICY_POINTS:
                $this->objPrivilege->canEditPolicyPoints();
                break;
            default:
                Message::addErrorMessage($this->str_invalid_request);
                break;
        }

        $obj->import($actionType, $langId, $sheetType);
    }

    public function exportMedia($actionType)
    {
        $post = FatApp::getPostedData();
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $exportDataRange = FatApp::getPostedData('export_data_range', FatUtility::VAR_INT, 0);
        $startId = FatApp::getPostedData('start_id', FatUtility::VAR_INT, 0);
        $endId = FatApp::getPostedData('end_id', FatUtility::VAR_INT, 0);
        $batchCount = FatApp::getPostedData('batch_count', FatUtility::VAR_INT, 0);
        $batchNumber = FatApp::getPostedData('batch_number', FatUtility::VAR_INT, 1);

        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
                $this->objPrivilege->canViewProductCategories();
                break;
            case Importexport::TYPE_BRANDS:
                $this->objPrivilege->canViewBrands();
                break;
            case Importexport::TYPE_PRODUCTS:
            case Importexport::TYPE_SELLER_PRODUCTS:
                $this->objPrivilege->canViewProducts();
                break;
            case Importexport::TYPE_INVENTORIES:
                $this->objPrivilege->canViewSellerProducts();
                break;
            default:
                Message::addErrorMessage($this->str_invalid_request);
                break;
        }

        $obj = new Importexport();

        $min = null;
        $max = null;

        switch ($exportDataRange) {
            case Importexport::BY_ID_RANGE:
                if (isset($startId) && $startId > 0) {
                    $min = $startId;
                }

                if (isset($endId) && $endId > 1 && $endId > $min) {
                    $max = $endId;
                }

                $obj->exportMedia($actionType, $langId, null, null, $min, $max);
                break;
            case Importexport::BY_BATCHES:
                if (isset($batchNumber) && $batchNumber > 0) {
                    $min = $batchNumber;
                }

                $max = Importexport::MAX_LIMIT;
                if (isset($batchCount) && $batchCount > 0 && $batchCount <= Importexport::MAX_LIMIT) {
                    $max = $batchCount;
                }
                $min = (!$min) ? 1 : $min;
                $obj->exportMedia($actionType, $langId, $min, $max, null, null);
                break;

            default:
                $obj->exportMedia($actionType, $langId, null, null, null, null);
                break;
        }
    }

    public function importMedia($actionType)
    {
        $post = FatApp::getPostedData();

        if (!is_uploaded_file($_FILES['import_file']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Please_Select_A_CSV_File', $this->siteLangId), true);
        }

        $obj = new Importexport();
        if (!$obj->isUploadedFileValidMimes($_FILES['import_file'])) {
            LibHelper::exitWithError(Labels::getLabel("LBL_Not_a_Valid_CSV_File", $this->siteLangId), true);
        }
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);

        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
                $this->objPrivilege->canEditProductCategories();
                break;
            case Importexport::TYPE_BRANDS:
                $this->objPrivilege->canEditBrands();
                break;
            case Importexport::TYPE_PRODUCTS:
            case Importexport::TYPE_SELLER_PRODUCTS:
                $this->objPrivilege->canEditProducts();
                break;
            default:
                Message::addErrorMessage($this->str_invalid_request);
                break;
        }

        $obj->importMedia($actionType, $post, $langId);
    }

    public function importForm($actionType)
    {
        $langId = $this->siteLangId;
        $displayMediaTab = true;
        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
                $this->objPrivilege->canEditProductCategories();
                $formTitle = Labels::getLabel('LBL_IMPORT_CATEGORIES', $langId);
                break;
            case Importexport::TYPE_BRANDS:
                $this->objPrivilege->canEditBrands();
                $formTitle = Labels::getLabel('LBL_IMPORT_BRANDS', $langId);
                break;
            case Importexport::TYPE_PRODUCTS:
                $this->objPrivilege->canViewProducts();
                $formTitle = Labels::getLabel('LBL_IMPORT_CATALOGS', $langId);
                break;
            case Importexport::TYPE_SELLER_PRODUCTS:
                $this->objPrivilege->canViewProducts();
                $formTitle = Labels::getLabel('LBL_IMPORT_SELLER_PRODUCTS', $langId);
                break;
            case Importexport::TYPE_INVENTORIES:
                $this->objPrivilege->canViewSellerProducts();
                $displayMediaTab = false;
                $formTitle = Labels::getLabel('LBL_IMPORT_INVENTORIES', $langId);
                break;
            case Importexport::TYPE_OPTIONS:
                $this->objPrivilege->canViewOptions();
                $displayMediaTab = false;
                $formTitle = Labels::getLabel('LBL_IMPORT_OPTIONS', $langId);
                break;
            case Importexport::TYPE_OPTION_VALUES:
                $this->objPrivilege->canViewOptions();
                $displayMediaTab = false;
                $formTitle = Labels::getLabel('LBL_IMPORT_OPTION_VALUES', $langId);
                break;
            case Importexport::TYPE_TAG:
                $this->objPrivilege->canViewTags();
                $displayMediaTab = false;
                $formTitle = Labels::getLabel('LBL_IMPORT_TAGS', $langId);
                break;
            case Importexport::TYPE_ZONES:
                $this->objPrivilege->canViewZones();
                $displayMediaTab = false;
                $formTitle = Labels::getLabel('LBL_IMPORT_ZONES', $langId);
                break;
            case Importexport::TYPE_COUNTRY:
                $this->objPrivilege->canViewCountries();
                $displayMediaTab = false;
                $formTitle = Labels::getLabel('LBL_IMPORT_COUNTRIES', $langId);
                break;
            case Importexport::TYPE_STATE:
                $this->objPrivilege->canViewStates();
                $displayMediaTab = false;
                $formTitle = Labels::getLabel('LBL_IMPORT_STATES', $langId);
                break;
            case Importexport::TYPE_POLICY_POINTS:
                $this->objPrivilege->canViewPolicyPoints();
                $displayMediaTab = false;
                $formTitle = Labels::getLabel('LBL_IMPORT_POLICY_POINTS', $langId);
                break;
            default:
                LibHelper::exitWithError($this->str_invalid_request, true);
                break;
        }

        $frm = $this->getImportExportForm($langId, 'IMPORT', $actionType);
        $this->set('frm', $frm);
        $this->set('actionType', $actionType);
        $this->set('displayMediaTab', $displayMediaTab);
        $this->set('formTitle', $formTitle);
        $this->_template->render(false, false);
    }

    public function importMediaForm($actionType)
    {
        $langId = $this->siteLangId;
        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
                $this->objPrivilege->canEditProductCategories();
                $title = Labels::getLabel('LBL_IMPORT_CATEGORIES_MEDIA', $langId);
                $frm = $this->getImportExportForm($langId, 'IMPORT_MEDIA', $actionType);
                break;
            case Importexport::TYPE_BRANDS:
                $this->objPrivilege->canEditBrands();
                $title = Labels::getLabel('LBL_Import_Brands_Media', $langId);
                $frm = $this->getImportExportForm($langId, 'IMPORT_MEDIA', $actionType);
                break;
            case Importexport::TYPE_PRODUCTS:
                $this->objPrivilege->canEditProducts();
                $title = Labels::getLabel('LBL_IMPORT_CATALOG_MEDIA', $langId);
                $frm = $this->getImportExportForm($langId, 'IMPORT_MEDIA', $actionType);
                break;
            case Importexport::TYPE_SELLER_PRODUCTS:
                $this->objPrivilege->canEditProducts();
                $title = Labels::getLabel('LBL_IMPORT_SELLER_PRODUCTS_MEDIA', $langId);
                $frm = $this->getImportExportForm($langId, 'IMPORT_MEDIA', $actionType);
                break;
            default:
                LibHelper::exitWithError($this->str_invalid_request, true);
                break;
        }

        $this->set('frm', $frm);
        $this->set('displayMediaTab', true);
        $this->set('actionType', $actionType);
        $this->set('formTitle', $title);
        $this->_template->render(false, false);
    }

    public function importInstructions($actionType)
    {
        $langId = $this->siteLangId;
        $obj = new Extrapage();
        $pageData = '';
        $displayMediaTab = false;
        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
                $this->objPrivilege->canEditProductCategories();
                $displayMediaTab = true;
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_PRODUCTS_CATEGORIES_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_BRANDS:
                $this->objPrivilege->canEditBrands();
                $displayMediaTab = true;
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_BRANDS_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_PRODUCTS:
            case Importexport::TYPE_SELLER_PRODUCTS:
                $this->objPrivilege->canViewProducts();
                $displayMediaTab = true;
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_CATALOG_MANAGEMENT_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_INVENTORIES:
                $this->objPrivilege->canViewSellerProducts();
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_PRODUCT_INVENTORY_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_OPTIONS:
                $this->objPrivilege->canViewOptions();
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_OPTIONS_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_OPTION_VALUES:
                $this->objPrivilege->canViewOptions();
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_OPTIONS_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_TAG:
                $this->objPrivilege->canViewTags();
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_TAGS_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_ZONES:
                $this->objPrivilege->canViewZones();
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_ZONE_MANAGEMENT_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_COUNTRY:
                $this->objPrivilege->canViewCountries();
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_COUNTRIES_MANAGEMENT_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_STATE:
                $this->objPrivilege->canViewStates();
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_STATE_MANAGEMENT_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_POLICY_POINTS:
                $this->objPrivilege->canViewPolicyPoints();
                $pageData = $obj->getContentByPageType(Extrapage::ADMIN_TYPE_POLICY_POINTS, $langId);
                break;
            default:
                LibHelper::exitWithError($this->str_invalid_request, true);
                break;
        }
        $this->set('pageData', $pageData);
        $this->set('formTitle', Labels::getLabel('LBL_Import_Instructions', $langId));
        $this->set('actionType', $actionType);
        $this->set('displayMediaTab', $displayMediaTab);
        $this->_template->render(false, false);
    }

    public function exportForm($actionType)
    {
        $langId = $this->siteLangId;
        $displayMediaTab = false;

        $formTitle = Labels::getLabel('LBL_EXPORT', $this->siteLangId);
        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
                $formTitle = Labels::getLabel('LBL_EXPORT_CATEGORIES', $this->siteLangId);
                $this->objPrivilege->canViewProductCategories();
                $displayMediaTab = true;
                break;
            case Importexport::TYPE_BRANDS:
                $formTitle = Labels::getLabel('LBL_EXPORT_BRANDS', $this->siteLangId);
                $this->objPrivilege->canViewBrands();
                $displayMediaTab = true;
                break;
            case Importexport::TYPE_PRODUCTS:
                $formTitle = Labels::getLabel('LBL_EXPORT_PRODUCTS', $this->siteLangId);
                $this->objPrivilege->canViewProducts();
                $displayMediaTab = true;
                break;
            case Importexport::TYPE_SELLER_PRODUCTS:
                $formTitle = Labels::getLabel('LBL_EXPORT_SELLER_PRODUCTS', $this->siteLangId);
                $this->objPrivilege->canViewProducts();
                $displayMediaTab = true;
                break;
            case Importexport::TYPE_INVENTORIES:
                $formTitle = Labels::getLabel('LBL_EXPORT_INVENTORIES', $this->siteLangId);
                $this->objPrivilege->canViewSellerProducts();
                $displayMediaTab = true;
                break;
            case Importexport::TYPE_OPTIONS:
                $formTitle = Labels::getLabel('LBL_EXPORT_OPTIONS', $this->siteLangId);
                $this->objPrivilege->canViewOptions();
                break;
            case Importexport::TYPE_OPTION_VALUES:
                $formTitle = Labels::getLabel('LBL_EXPORT_OPTION_VALUES', $this->siteLangId);
                $this->objPrivilege->canViewOptions();
                break;
            case Importexport::TYPE_TAG:
                $formTitle = Labels::getLabel('LBL_EXPORT_TAG', $this->siteLangId);
                $this->objPrivilege->canViewTags();
                break;
            case Importexport::TYPE_ZONES:
                $formTitle = Labels::getLabel('LBL_EXPORT_ZONES', $this->siteLangId);
                $this->objPrivilege->canViewZones();
                break;
            case Importexport::TYPE_COUNTRY:
                $formTitle = Labels::getLabel('LBL_EXPORT_COUNTRY', $this->siteLangId);
                $this->objPrivilege->canViewCountries();
                break;
            case Importexport::TYPE_STATE:
                $formTitle = Labels::getLabel('LBL_EXPORT_STATE', $this->siteLangId);
                $this->objPrivilege->canViewStates();
                break;
            case Importexport::TYPE_POLICY_POINTS:
                $formTitle = Labels::getLabel('LBL_EXPORT_POLICY_POINTS', $this->siteLangId);
                $this->objPrivilege->canViewPolicyPoints();
                break;
            case Importexport::TYPE_USERS:
                $formTitle = Labels::getLabel('LBL_EXPORT_USERS', $this->siteLangId);
                $this->objPrivilege->canViewUsers();
                break;
            case Importexport::TYPE_TAX_CATEGORY:
                $formTitle = Labels::getLabel('LBL_EXPORT_TAX_CATEGORY', $this->siteLangId);
                $this->objPrivilege->canViewTax();
                break;
            default:
                LibHelper::exitWithError($this->str_invalid_request, true);
                break;
        }

        $frm = $this->getImportExportForm($langId, 'EXPORT', $actionType);
        $this->set('frm', $frm);
        $this->set('actionType', $actionType);
        $this->set('displayMediaTab', $displayMediaTab);
        $this->set('formTitle', $formTitle);
        $this->_template->render(false, false);
    }

    public function exportMediaForm($actionType)
    {
        $langId = $this->siteLangId;
        $formTitle = Labels::getLabel('LBL_EXPORT_MEDIA', $this->siteLangId);
        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
                $this->objPrivilege->canViewProductCategories();
                $formTitle = Labels::getLabel('LBL_EXPORT_CATEGORIES_MEDIA', $this->siteLangId);
                $frm = $this->getImportExportForm($langId, 'EXPORT_MEDIA', $actionType);
                break;
            case Importexport::TYPE_BRANDS:
                $this->objPrivilege->canViewBrands();
                $formTitle = Labels::getLabel('LBL_EXPORT_BRANDS_MEDIA', $this->siteLangId);
                $frm = $this->getImportExportForm($langId, 'EXPORT_MEDIA', $actionType);
                break;
            case Importexport::TYPE_PRODUCTS:
                $this->objPrivilege->canViewProducts();
                $formTitle = Labels::getLabel('LBL_EXPORT_PRODUCTS_MEDIA', $this->siteLangId);
                $frm = $this->getImportExportForm($langId, 'EXPORT_MEDIA', $actionType);
                break;
            case Importexport::TYPE_SELLER_PRODUCTS:
                $this->objPrivilege->canViewProducts();
                $formTitle = Labels::getLabel('LBL_EXPORT_SELLER_PRODUCTS_MEDIA', $this->siteLangId);
                $frm = $this->getImportExportForm($langId, 'EXPORT_MEDIA', $actionType);
                break;
            case Importexport::TYPE_INVENTORIES:
                $this->objPrivilege->canViewSellerProducts();
                $formTitle = Labels::getLabel('LBL_EXPORT_INVENTORIES_MEDIA', $this->siteLangId);
                $frm = $this->getImportExportForm($langId, 'EXPORT_MEDIA', $actionType);
                break;
            default:
                LibHelper::exitWithError($this->str_invalid_request, true);
                break;
        }

        $this->set('frm', $frm);
        $this->set('displayMediaTab', true);
        $this->set('actionType', $actionType);
        $this->set('formTitle', $formTitle);
        $this->_template->render(false, false);
    }

    public function getImportExportForm($langId, $type = 'EXPORT', $actionType)
    {
        $frm = new Form('frmImportExport', array('id' => 'frmImportExport'));
        $languages = Language::getAllNames();

        /* if($type != 'EXPORT_MEDIA'){ */
        if ($type == 'IMPORT_MEDIA') {
            $frm->addSelectBox(Labels::getLabel('LBL_Upload_File_Language', $langId), 'lang_id', $languages, '', array(), '')->requirements()->setRequired();
        } elseif ($type == 'EXPORT_MEDIA') {
            $frm->addSelectBox(Labels::getLabel('LBL_Export_File_Language', $langId), 'lang_id', $languages, '', array(), '')->requirements()->setRequired();
        } else {
            $frm->addSelectBox(Labels::getLabel('LBL_Language', $langId), 'lang_id', $languages, '', array(), '')->requirements()->setRequired();
        }
        /* } */

        $displayRangeFields = false;

        switch (strtoupper($type)) {
            case 'EXPORT':
                switch ($actionType) {
                    case Importexport::TYPE_PRODUCTS:
                    case Importexport::TYPE_SELLER_PRODUCTS:
                        $displayRangeFields = true;
                        $frm->addSelectBox(Labels::getLabel('LBL_Select_Data', $langId), 'sheet_type', Importexport::getProductCatalogContentTypeArr($langId), '', array(), '')->requirements()->setRequired();
                        break;
                    case Importexport::TYPE_INVENTORIES:
                        $displayRangeFields = true;
                        $frm->addSelectBox(Labels::getLabel('LBL_Select_Data', $langId), 'sheet_type', Importexport::getSellerProductContentTypeArr($langId), '', array(), '')->requirements()->setRequired();
                        break;
                    case Importexport::TYPE_USERS:
                        $displayRangeFields = true;
                        break;
                }
                break;
            case 'EXPORT_MEDIA':
                switch ($actionType) {
                    case Importexport::TYPE_PRODUCTS:
                    case Importexport::TYPE_SELLER_PRODUCTS:
                    case Importexport::TYPE_INVENTORIES:
                        $displayRangeFields = true;
                        break;
                }
                break;
            case 'IMPORT':
                switch ($actionType) {
                    case Importexport::TYPE_PRODUCTS:
                    case Importexport::TYPE_SELLER_PRODUCTS:
                        $frm->addSelectBox(Labels::getLabel('LBL_Select_Data', $langId), 'sheet_type', Importexport::getProductCatalogContentTypeArr($langId), '', array(), '')->requirements()->setRequired();
                        break;
                    case Importexport::TYPE_INVENTORIES:
                        $frm->addSelectBox(Labels::getLabel('LBL_Select_Data', $langId), 'sheet_type', Importexport::getSellerProductContentTypeArr($langId), '', array(), '')->requirements()->setRequired();
                        break;
                        /* case Importexport::TYPE_OPTIONS:
                        $frm->addSelectBox(Labels::getLabel('LBL_Select_Data', $langId), 'sheet_type', Importexport::getOptionContentTypeArr($langId), '', array(), '')->requirements()->setRequired();
                        break; */
                }
                $fldImg = $frm->addFileUpload(Labels::getLabel('LBL_File_to_be_uploaded:', $langId), 'import_file', array('id' => 'import_file'));
                $fldImg->requirement->setRequired(true);
                $fldImg->setFieldTagAttribute('onChange', '$(\'#importFileName\').html(this.value)');
                $fldImg->htmlBeforeField = '<div class="filefield"><span class="filename" id="importFileName"></span>';
                $fldImg->htmlAfterField = '<label class="filelabel">' . Labels::getLabel('LBL_Browse_File', $langId) . '</label></div>';
                break;
            case 'IMPORT_MEDIA':
                $fldImg = $frm->addFileUpload(Labels::getLabel('LBL_File_to_be_uploaded:', $langId), 'import_file', array('id' => 'import_file'));
                $fldImg->requirement->setRequired(true);
                $fldImg->setFieldTagAttribute('onChange', '$(\'#importFileName\').html(this.value)');
                $fldImg->htmlBeforeField = '<div class="filefield"><span class="filename" id="importFileName"></span>';
                $fldImg->htmlAfterField = '<label class="filelabel">' . Labels::getLabel('LBL_Browse_File', $langId) . '</label></div>';
                break;
        }

        if ($displayRangeFields) {
            $dataRangeArr = array(0 => Labels::getLabel('LBL_Does_not_matter', $langId)) + Importexport::getDataRangeArr($langId);
            $rangeTypeFld = $frm->addSelectBox(Labels::getLabel('LBL_Export_data_range', $langId), 'export_data_range', $dataRangeArr, '', array(), '');

            /* Start Id[ */
            $frm->addIntegerField(Labels::getLabel('LBL_start_id', $langId), 'start_id', 1);
            $startIdUnReqObj = new FormFieldRequirement('start_id', Labels::getLabel('LBL_start_id', $langId));
            $startIdUnReqObj->setRequired(false);

            $startIdReqObj = new FormFieldRequirement('start_id', Labels::getLabel('LBL_start_id', $langId));
            $startIdReqObj->setRequired(true);
            /*]*/

            /* End Id[ */
            $frm->addIntegerField(Labels::getLabel('LBL_end_id', $langId), 'end_id', Importexport::MAX_LIMIT);
            $endIdUnReqObj = new FormFieldRequirement('end_id', Labels::getLabel('LBL_end_id', $langId));
            $endIdUnReqObj->setRequired(false);

            $endIdReqObj = new FormFieldRequirement('end_id', Labels::getLabel('LBL_end_id', $langId));
            $endIdReqObj->setRequired(true);
            //$endIdReqObj->setRange(1,Importexport::MAX_LIMIT);
            /*]*/

            /* Batch Count[ */
            $frm->addIntegerField(Labels::getLabel('LBL_counts_per_batch', $langId), 'batch_count', Importexport::MAX_LIMIT);
            $batchCountUnReqObj = new FormFieldRequirement('batch_count', Labels::getLabel('LBL_counts_per_batch', $langId));
            $batchCountUnReqObj->setRequired(false);

            $batchCountReqObj = new FormFieldRequirement('batch_count', Labels::getLabel('LBL_counts_per_batch', $langId));
            $batchCountReqObj->setRequired(true);
            $batchCountReqObj->setRange(1, Importexport::MAX_LIMIT);
            /*]*/

            /* Batch Number[ */
            $frm->addIntegerField(Labels::getLabel('LBL_batch_number', $langId), 'batch_number', 1);
            $batchNumberUnReqObj = new FormFieldRequirement('batch_number', Labels::getLabel('LBL_batch_number', $langId));
            $batchNumberUnReqObj->setRequired(false);

            $batchNumberReqObj = new FormFieldRequirement('batch_number', Labels::getLabel('LBL_batch_number', $langId));
            $batchNumberReqObj->setRequired(true);
            /*]*/

            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(0, 'eq', 'batch_count', $batchCountUnReqObj);
            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(0, 'eq', 'batch_number', $batchNumberUnReqObj);
            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(0, 'eq', 'start_id', $startIdUnReqObj);
            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(0, 'eq', 'end_id', $endIdUnReqObj);

            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(Importexport::BY_ID_RANGE, 'eq', 'batch_count', $batchCountUnReqObj);
            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(Importexport::BY_ID_RANGE, 'eq', 'batch_number', $batchNumberUnReqObj);
            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(Importexport::BY_ID_RANGE, 'eq', 'start_id', $startIdReqObj);
            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(Importexport::BY_ID_RANGE, 'eq', 'end_id', $endIdReqObj);

            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(Importexport::BY_BATCHES, 'eq', 'start_id', $startIdUnReqObj);
            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(Importexport::BY_BATCHES, 'eq', 'end_id', $endIdUnReqObj);
            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(Importexport::BY_BATCHES, 'eq', 'batch_count', $batchCountReqObj);
            $rangeTypeFld->requirements()->addOnChangerequirementUpdate(Importexport::BY_BATCHES, 'eq', 'batch_number', $batchNumberReqObj);
        }

        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Submit', $langId));
        return $frm;
    }


    public function loadForm($formType)
    {
        switch (strtoupper($formType)) {
            case 'IMPORT':
                $this->import();
                break;
            case 'EXPORT':
                $this->export();
                break;
            case 'SETTINGS':
                $this->settings();
                break;
            case 'BULK_MEDIA':
                $this->bulkMedia();
                break;
        }
    }

    public function export()
    {
        $options = Importexport::getImportExportTypeArr('export', $this->siteLangId, false);
        $this->set('options', $options);
        $this->_template->render(false, false, 'import-export/export.php');
    }

    public function import()
    {
        $options = Importexport::getImportExportTypeArr('import', $this->siteLangId, false);
        $this->set('options', $options);
        $this->_template->render(false, false, 'import-export/import.php');
    }

    public function settings()
    {
        $frm = $this->getSettingForm();
        $obj = new Importexport();
        $settingArr = $obj->getSettings(0);
        $frm->fill($settingArr);
        $this->set('frm', $frm);
        $this->set('action', 'settings');
        $this->_template->render(false, false, 'import-export/settings.php');
    }

    private function getSettingForm()
    {
        $frm = new Form('frmImportExportSetting', array('id' => 'frmImportExportSetting'));

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_brand_id_instead_of_brand_identifier", $this->siteLangId), 'CONF_USE_BRAND_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_category_id_instead_of_category_identifier", $this->siteLangId), 'CONF_USE_CATEGORY_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_catalog_product_id_instead_of_catalog_product_identifier", $this->siteLangId), 'CONF_USE_PRODUCT_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_user_id_instead_of_username", $this->siteLangId), 'CONF_USE_USER_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_option_id_instead_of_option_identifier", $this->siteLangId), 'CONF_USE_OPTION_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_option_value_id_instead_of_option_identifier", $this->siteLangId), 'CONF_OPTION_VALUE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_tag_id_instead_of_tag_identifier", $this->siteLangId), 'CONF_USE_TAG_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_tax_id_instead_of_tax_identifier", $this->siteLangId), 'CONF_USE_TAX_CATEOGRY_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_product_type_id_instead_of_product_type_identifier", $this->siteLangId), 'CONF_USE_PRODUCT_TYPE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_dimension_unit_id_instead_of_dimension_unit_identifier", $this->siteLangId), 'CONF_USE_DIMENSION_UNIT_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_weight_unit_id_instead_of_weight_unit_identifier", $this->siteLangId), 'CONF_USE_WEIGHT_UNIT_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_lang_id_instead_of_lang_code", $this->siteLangId), 'CONF_USE_LANG_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_currency_id_instead_of_currency_code", $this->siteLangId), 'CONF_USE_CURRENCY_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_Product_condition_id_instead_of_condition_identifier", $this->siteLangId), 'CONF_USE_PROD_CONDITION_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_persent_or_flat_condition_id_instead_of_identifier", $this->siteLangId), 'CONF_USE_PERSENT_OR_FLAT_CONDITION_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_country_id_instead_of_country_code", $this->siteLangId), 'CONF_USE_COUNTRY_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_state_id_instead_of_state_identifier", $this->siteLangId), 'CONF_USE_STATE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_policy_point_id_instead_of_policy_point_identifier", $this->siteLangId), 'CONF_USE_POLICY_POINT_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_shipping_company_id_instead_of_shipping_company_identifier", $this->siteLangId), 'CONF_USE_SHIPPING_COMPANY_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_policy_point_type_id_instead_of_policy_point_type_identifier", $this->siteLangId), 'CONF_USE_POLICY_POINT_TYPE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_shipping_duration_id_instead_of_shipping_duration_identifier", $this->siteLangId), 'CONF_USE_SHIPPING_DURATION_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_shipping_profile_id_instead_of_shipping_profile_identifier", $this->siteLangId), 'CONF_USE_SHIPPING_PROFILE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_shipping_package_id_instead_of_shipping_package_identifier", $this->siteLangId), 'CONF_USE_SHIPPING_PACKAGE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("LBL_Use_1_for_yes_0_for_no", $this->siteLangId), 'CONF_USE_O_OR_1', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        return $frm;
    }

    public function updateSettings()
    {
        $frm = $this->getSettingForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $record = new Configurations();
        if (!$record->update($post)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_SETTINGS_UPDATED_SUCCESSFUL', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function bulkMedia()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $this->set("frmSearch", $frmSearch);
        $this->getListingData();
        $this->set('action', 'bulkMedia');
        $this->_template->render(false, false, 'import-export/bulk-media.php');
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'user');
        }
        return $frm;
    }

    /**
     * search : Search Bulk Media
     *
     * @return void
     */
    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'import-export/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        if ('user' == $sortBy) {
            $sortBy = 'credential_username';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $bulkImage = new UploadBulkImages();
        $srch = $bulkImage->bulkMediaFileObject(0, false);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $searchForm = $this->getSearchForm($fields);
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

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
        $this->set('canEdit', $this->objPrivilege->canEditEmptyCartItems($this->admin_id, true));
    }

    public function upload()
    {
        if (empty($_FILES)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $fileName = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];

        $uploadBulkImgobj = new UploadBulkImages();
        $savedFile = $uploadBulkImgobj->upload($fileName, $tmpName);
        if (false === $savedFile) {
            LibHelper::exitWithError($uploadBulkImgobj->getError(), true);
        }

        $path = CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BULK_IMAGES_PATH;
        $filePath = AttachedFile::FILETYPE_BULK_IMAGES_PATH . $savedFile;

        $msg = Labels::getLabel('MSG_YOUR_UPLOADED_FILES_PATH_WILL_BE:_{PATH}', $this->siteLangId);
        $msg = CommonHelper::replaceStringData($msg, ['{PATH}' => '<br><b>' . $filePath . '</b>']);

        $msg = Labels::getLabel('MSG_Uploaded_Successfully.', $this->siteLangId) . ' ' . $msg;
        $json = [
            "msg" => $msg,
            "path" => base64_encode($path . $savedFile)
        ];
        FatUtility::dieJsonSuccess($json);
    }

    public function downloadPathsFile($path)
    {
        if (empty($path)) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }
        $filesPathArr = UploadBulkImages::getAllFilesPath(base64_decode($path));
        if (!empty($filesPathArr) && 0 < count($filesPathArr)) {
            $headers[] = ['File Path', 'File Name'];
            $filesPathArr = array_merge($headers, $filesPathArr);
            CommonHelper::convertToCsv($filesPathArr, time() . '.csv');
            exit;
        }
        Message::addErrorMessage(Labels::getLabel('MSG_No_File_Found', $this->siteLangId));
        CommonHelper::redirectUserReferer();
    }

    public function removeDir($directory)
    {
        $directory = CONF_UPLOADS_PATH . base64_decode($directory);
        $obj = new UploadBulkImages();
        $msg = $obj->deleteSingleBulkMediaDir($directory);
        FatUtility::dieJsonSuccess($msg);
    }

    public function exportLabels()
    {
        $srch = new SearchBase(Labels::DB_TBL, 'lbl');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->joinTable(Language::DB_TBL, 'INNER JOIN', 'label_lang_id = language_id AND language_active = ' . applicationConstants::ACTIVE);
        $srch->addOrder('label_key', 'DESC');
        $srch->addOrder('label_lang_id', 'ASC');
        $srch->addMultipleFields(array('label_id', 'label_key', 'label_lang_id', 'label_caption'));
        $rs = $srch->getResultSet();

        $langSrch = Language::getSearchObject();
        $langSrch->doNotCalculateRecords();
        $langSrch->addMultipleFields(array('language_id', 'language_code', 'language_name'));
        $langSrch->addOrder('language_id', 'ASC');
        $langRs = $langSrch->getResultSet();
        $languages = FatApp::getDb()->fetchAll($langRs);
        $sheetData = array();

        /* Sheet Heading Row[ */
        $arr = array(Labels::getLabel('LBL_Key', $this->siteLangId));
        if ($languages) {
            foreach ($languages as $lang) {
                array_push($arr, $lang['language_code']);
            }
        }
        array_push($sheetData, $arr);
        /* ] */

        $key = '';
        $counter = 0;
        $arr = array();
        $langArr = array();

        while ($row = FatApp::getDb()->fetch($rs)) {
            if ($key != $row['label_key']) {
                if (!empty($langArr)) {
                    $arr[$counter] = array('label_key' => $key);
                    foreach ($langArr as $k => $val) {
                        if (is_array($val)) {
                            foreach ($val as $key => $v) {
                                $val[$key] = htmlentities($v);
                            }
                        }
                        $arr[$counter]['data'] = $val;
                    }
                    $counter++;
                }
                $key = $row['label_key'];
                $langArr = array();
                foreach ($languages as $lang) {
                    $langArr[$key][$lang['language_id']] = '';
                }
                $langArr[$key][$row['label_lang_id']] = $row['label_caption'];
            } else {
                $langArr[$key][$row['label_lang_id']] = $row['label_caption'];
            }
        }

        foreach ($arr as $a) {
            $sheetArr = array();
            $sheetArr = array($a['label_key']);
            if (!empty($a['data'])) {
                foreach ($a['data'] as $langId => $caption) {
                    array_push($sheetArr, html_entity_decode($caption));
                }
            }
            array_push($sheetData, $sheetArr);
        }
        CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Labels', $this->siteLangId) . ' ' . date("d-M-Y") . '.csv', ',');
    }

    public function importLabelsForm()
    {
        $frm = $this->getImportLabelsForm();
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    private function getImportLabelsForm()
    {
        $frm = new Form('frmImportLabels', array('id' => 'frmImportLabels'));
        $fldImg = $frm->addFileUpload(Labels::getLabel('LBL_Select_File_To_Upload:', $this->siteLangId), 'import_file', array('id' => 'import_file'));
        $fldImg->setFieldTagAttribute('onChange', '$(\'#importFileName\').html(this.value)');
        $fldImg->htmlBeforeField = '<div class="filefield"><span class="filename" id="importFileName"></span>';
        $fldImg->htmlAfterField = '<label class="filelabel">' . Labels::getLabel('LBL_Browse_File', $this->siteLangId) . '</label></div>';

        return $frm;
    }

    public function uploadLabelsImportedFile()
    {
        if (!is_uploaded_file($_FILES['import_file']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Please_Select_A_CSV_File', $this->siteLangId), true);
        }
        if (!in_array($_FILES['import_file']['type'], CommonHelper::isCsvValidMimes())) {
            LibHelper::exitWithError(Labels::getLabel("LBL_Not_a_Valid_CSV_File", $this->siteLangId), true);
        }

        $db = FatApp::getDb();
        /* All Languages[  */
        $langSrch = Language::getSearchObject();
        $langSrch->doNotCalculateRecords();
        $langSrch->addMultipleFields(array('language_id', 'language_code', 'language_name'));
        $langSrch->addOrder('language_id', 'ASC');
        $langRs = $langSrch->getResultSet();
        $languages = $db->fetchAll($langRs, 'language_code');
        /* ] */

        $csvFilePointer = fopen($_FILES['import_file']['tmp_name'], 'r');

        $firstLine = fgetcsv($csvFilePointer);
        array_shift($firstLine);
        $firstLineLangArr = $firstLine;
        $langIndexLangIds = array();
        foreach ($firstLineLangArr as $key => $langCode) {
            if (!array_key_exists($langCode, $languages)) {
                LibHelper::exitWithError(Labels::getLabel("MSG_Invalid_Coloum_CSV_File", $this->siteLangId), true);
            }
            $langIndexLangIds[$key] = $languages[$langCode]['language_id'];
        }

        while (($line = fgetcsv($csvFilePointer)) !== false) {
            if ($line[0] != '') {
                $labelKey = array_shift($line);
                $type = Labels::TYPE_WEB;
                if (strtoupper(substr($labelKey, 0, 3)) == 'APP') {
                    $type = Labels::TYPE_APP;
                }

                foreach ($line as $key => $caption) {
                    $dataToSaveArr = array(
                        'label_key' => $labelKey,
                        'label_lang_id' => $langIndexLangIds[$key],
                        'label_caption' => $caption,
                        'label_type' => $type,
                    );
                    $db->insertFromArray(Labels::DB_TBL, $dataToSaveArr, false, array(), array('label_caption' => $caption));
                }
            }
        }

        $labelsUpdatedAt = array('conf_name' => 'CONF_LANG_LABELS_UPDATED_AT', 'conf_val' => time());
        $db->insertFromArray('tbl_configurations', $labelsUpdatedAt, false, array(), $labelsUpdatedAt);
        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_LABELS_DATA_IMPORTED_SUCCESSFULLY', $this->siteLangId), true);
    }

    protected function getFormColumns(): array
    {
        $bulkMediaTblHeadingCols = CacheHelper::get('bulkMediaTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($bulkMediaTblHeadingCols) {
            return json_decode($bulkMediaTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'user' => Labels::getLabel('LBL_USER', $this->siteLangId),
            'afile_physical_path' => Labels::getLabel('LBL_FILE_LOCATION', $this->siteLangId),
            'files'    => Labels::getLabel('LBL_FILES', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('bulkMediaTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'listSerial',
            'user',
            'afile_physical_path',
            'files',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['files'], Common::excludeKeysForSort());
    }
}
