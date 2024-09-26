<?php

class ImportExportController extends SellerBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $shop = new Shop(0, $this->userParentId);
        if (!$shop->isActive()) {
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'shop'));
        }

        if (!UserPrivilege::isUserHasValidSubsription($this->userParentId)) {
            Message::addInfo(Labels::getLabel("MSG_Please_buy_subscription", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'Packages'));
        }
        $this->userPrivilege->canViewImportExport();
    }

    public function index()
    {
        $this->set('canEditImportExport', $this->userPrivilege->canEditImportExport(0, true));
        $this->set('canUploadBulkImages', $this->userPrivilege->canUploadBulkImages(0, true));
        $this->_template->render(true, true);
    }

    public function exportData($actionType)
    {
        $this->userPrivilege->canViewImportExport();
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $exportDataRange = FatApp::getPostedData('export_data_range', FatUtility::VAR_INT, 0);
        $startId = FatApp::getPostedData('start_id', FatUtility::VAR_INT, 0);
        $endId = FatApp::getPostedData('end_id', FatUtility::VAR_INT, 0);
        $batchCount = FatApp::getPostedData('batch_count', FatUtility::VAR_INT, 0);
        $batchNumber = FatApp::getPostedData('batch_number', FatUtility::VAR_INT, 1);
        $sheetType = FatApp::getPostedData('sheet_type', FatUtility::VAR_INT, 0);
        $userId = $this->userParentId;

        if (1 > $langId) {
            $langId = CommonHelper::getLangId();
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
                $obj->export($actionType, $langId, $sheetType, null, null, $min, $max, $userId, true);
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
                $obj->export($actionType, $langId, $sheetType, $min, $max, null, null, $userId, true);
                break;

            default:
                $obj->export($actionType, $langId, $sheetType, null, null, null, null, $userId, true);
                break;
        }
    }

    public function importData($actionType)
    {
        $this->userPrivilege->canEditImportExport();
        if (!is_uploaded_file($_FILES['import_file']['tmp_name'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_A_CSV_FILE', $this->siteLangId));
        }

        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $obj = new Importexport();
        if (!$obj->isUploadedFileValidMimes($_FILES['import_file'])) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_NOT_A_VALID_CSV_FILE", $this->siteLangId));
        }

        $sheetType = FatApp::getPostedData('sheet_type', FatUtility::VAR_INT, 0);
        $userId = $this->userParentId;

        $obj->import($actionType, $langId, $sheetType, $userId);
    }

    public function exportMedia($actionType)
    {
        $this->userPrivilege->canViewImportExport();
        $post = FatApp::getPostedData();
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $exportDataRange = FatApp::getPostedData('export_data_range', FatUtility::VAR_INT, 0);
        $startId = FatApp::getPostedData('start_id', FatUtility::VAR_INT, 0);
        $endId = FatApp::getPostedData('end_id', FatUtility::VAR_INT, 0);
        $batchCount = FatApp::getPostedData('batch_count', FatUtility::VAR_INT, 0);
        $batchNumber = FatApp::getPostedData('batch_number', FatUtility::VAR_INT, 1);
        $userId = $this->userParentId;

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

                $obj->exportMedia($actionType, $langId, null, null, $min, $max, $userId);
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
                $obj->exportMedia($actionType, $langId, $min, $max, null, null, $userId);
                break;

            default:
                $obj->exportMedia($actionType, $langId, null, null, null, null, $userId);
                break;
        }
    }

    public function importMedia($actionType)
    {
        $this->userPrivilege->canEditImportExport();
        $post = FatApp::getPostedData();
        $userId = $this->userParentId;
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);

        if (!is_uploaded_file($_FILES['import_file']['tmp_name'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_A_CSV_FILE', $this->siteLangId));
        }

        $obj = new Importexport();
        if (!$obj->isUploadedFileValidMimes($_FILES['import_file'])) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_NOT_A_VALID_CSV_FILE", $this->siteLangId));
        }

        $obj->importMedia($actionType, $post, $langId, $userId);
    }

    public function loadForm($formType)
    {
        switch (strtoupper($formType)) {
            case 'GENERAL_INSTRUCTIONS':
                $this->generalInstructions();
                break;
            case 'IMPORT':
                $this->import();
                break;
            case 'EXPORT':
                $this->export();
                break;
            case 'SETTINGS':
                $this->settings();
                break;
            case 'INVENTORYUPDATE':
                $this->inventoryUpdate();
                break;
            case 'BULK_MEDIA':
                $this->bulkMedia();
                break;
        }
    }

    public function exportForm($actionType)
    {
        $displayMediaTab = false;
        $options = Importexport::getImportExportTypeArr('export', $this->siteLangId, true);
        if (!isset($options[$actionType])) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }

        $title = $options[$actionType];

        switch ($actionType) {
                /* case Importexport::TYPE_CATEGORIES:         */
            case Importexport::TYPE_BRANDS:
            case Importexport::TYPE_PRODUCTS:
            case Importexport::TYPE_SELLER_PRODUCTS:
            case Importexport::TYPE_INVENTORIES:
                $displayMediaTab = true;
                break;
        }

        $frm = $this->getImportExportForm($this->siteLangId, 'EXPORT', $actionType);
        $this->set('frm', $frm);
        $this->set('actionType', $actionType);
        $this->set('displayMediaTab', $displayMediaTab);
        $this->set('formTitle', $title);
        $this->_template->render(false, false);
    }

    public function exportMediaForm($actionType)
    {
        $options = Importexport::getImportExportTypeArr('export', $this->siteLangId, true);

        if (!isset($options[$actionType])) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }
        $title = $options[$actionType];

        $frm = $this->getImportExportForm($this->siteLangId, 'EXPORT_MEDIA', $actionType);
        $this->set('frm', $frm);
        $this->set('actionType', $actionType);
        $this->set('formTitle', $title);
        $this->set('displayMediaTab', true);
        $this->_template->render(false, false);
    }

    public function importForm($actionType)
    {
        $post = FatApp::getPostedData();
        $options = Importexport::getImportExportTypeArr('import', $this->siteLangId, true);
        if (!isset($options[$actionType])) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }

        $title = $options[$actionType];

        $displayMediaTab = false;
        switch ($actionType) {
            case Importexport::TYPE_CATEGORIES:
            case Importexport::TYPE_BRANDS:
            case Importexport::TYPE_SELLER_PRODUCTS:
                $displayMediaTab = true;
                break;
        }

        $frm = $this->getImportExportForm($this->siteLangId, 'IMPORT', $actionType);
        if (!empty($post)) {
            $frm->fill($post);
        }
        $this->set('frm', $frm);
        $this->set('actionType', $actionType);
        $this->set('displayMediaTab', $displayMediaTab);
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
            case Importexport::TYPE_PRODUCTS:
            case Importexport::TYPE_SELLER_PRODUCTS:
                $displayMediaTab = true;
                $pageData = $obj->getContentByPageType(Extrapage::SELLER_CATALOG_MANAGEMENT_INSTRUCTIONS, $langId);
                break;
            case Importexport::TYPE_INVENTORIES:
                $pageData = $obj->getContentByPageType(Extrapage::SELLER_PRODUCT_INVENTORY_INSTRUCTIONS, $langId);
                break;
            default:
                FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $langId));
                break;
        }
        $title = Labels::getLabel('LBL_Import_Instructions', $langId);
        $this->set('pageData', $pageData);
        $this->set('formTitle', $title);
        $this->set('actionType', $actionType);
        $this->set('displayMediaTab', $displayMediaTab);
        $this->_template->render(false, false);
    }

    public function importMediaForm($actionType)
    {
        $options = Importexport::getImportExportTypeArr('import', $this->siteLangId, true);
        if (!isset($options[$actionType])) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }

        $title = $options[$actionType];

        $frm = $this->getImportExportForm($this->siteLangId, 'IMPORT_MEDIA', $actionType);
        $this->set('frm', $frm);
        $this->set('actionType', $actionType);
        $this->set('formTitle', $title);
        $this->set('displayMediaTab', true);
        $this->_template->render(false, false);
    }

    public function import()
    {
        $this->userPrivilege->canEditImportExport();
        $this->set('canEditImportExport', $this->userPrivilege->canEditImportExport(0, true));
        $this->set('canUploadBulkImages', $this->userPrivilege->canUploadBulkImages(0, true));
        $this->set('action', 'import');

        $options = Importexport::getImportExportTypeArr('import', $this->siteLangId, true);
        $this->set('options', $options);
        $optionsMessages = Importexport::getImportExportTypeMsgArr('import', $this->siteLangId, true);
        $this->set('optionsMessages', $optionsMessages);
        $this->_template->render(false, false, 'import-export/import.php');
    }

    public function export()
    {
        $this->userPrivilege->canViewImportExport();
        $this->set('canEditImportExport', $this->userPrivilege->canEditImportExport(0, true));
        $this->set('canUploadBulkImages', $this->userPrivilege->canUploadBulkImages(0, true));
        $this->set('action', 'export');

        $options = Importexport::getImportExportTypeArr('export', $this->siteLangId, true);
        $this->set('options', $options);
        $optionsMessages = Importexport::getImportExportTypeMsgArr('export', $this->siteLangId, true);
        $this->set('optionsMessages', $optionsMessages);
        $this->_template->render(false, false, 'import-export/export.php');
    }

    public function generalInstructions()
    {
        $langId = $this->siteLangId;
        $obj = new Extrapage();
        $pageData = $obj->getContentByPageType(Extrapage::SELLER_GENERAL_SETTINGS_INSTRUCTIONS, $langId);
        $this->set('canEditImportExport', $this->userPrivilege->canEditImportExport(0, true));
        $this->set('canUploadBulkImages', $this->userPrivilege->canUploadBulkImages(0, true));
        $this->set('pageData', $pageData);
        $this->set('action', 'generalInstructions');
        $this->_template->render(false, false, 'import-export/general-instructions.php');
    }
    public function bulkMedia()
    {
        $this->userPrivilege->canUploadBulkImages();
        $frm = $this->getBulkMediaUploadForm($this->siteLangId);
        $this->set('canEditImportExport', $this->userPrivilege->canEditImportExport(0, true));
        $this->set('canUploadBulkImages', $this->userPrivilege->canUploadBulkImages(0, true));
        $this->set('action', 'bulkMedia');
        $this->set('frm', $frm);
        $this->_template->render(false, false, 'import-export/bulk-media.php');
    }

    private function getBulkMediaUploadForm($langId)
    {
        $frm = new Form('uploadBulkImages', array('id' => 'uploadBulkImages'));

        $fldImg = $frm->addFileUpload(Labels::getLabel('FRM_FILE_TO_BE_UPLOADED:', $langId), 'bulk_images', array('id' => 'bulk_images', 'accept' => '.zip'));
        $fldImg->requirement->setRequired(true);
        $fldImg->setFieldTagAttribute('onChange', '$("#uploadFileName").html(this.value)');
        $fldImg->htmlBeforeField = '<div class="filefield">';
        $fldImg->htmlAfterField = '<label class="filelabel"></label></div>';

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SUBMIT', $langId));
        return $frm;
    }

    public function updateSettings()
    {
        $this->userPrivilege->canEditImportExport();
        $frm = $this->getSettingForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $userId = $this->userParentId;
        $obj = new Importexport();
        $settingArr = $obj->getSettingsArr();

        foreach ($settingArr as $k => $val) {
            $data = array(
                'impexp_setting_key' => $k,
                'impexp_setting_user_id' => $userId,
                'impexp_setting_value' => isset($post[$k]) ? $post[$k] : 0,
            );
            FatApp::getDb()->insertFromArray(Importexport::DB_TBL_SETTINGS, $data, false, array(), $data);
        }

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function settings()
    {
        $this->userPrivilege->canViewImportExport();
        $frm = $this->getSettingForm($this->siteLangId);
        $userId = $this->userParentId;

        $obj = new Importexport();
        $settingArr = $obj->getSettings($userId);

        $frm->fill($settingArr);
        $this->set('canEditImportExport', $this->userPrivilege->canEditImportExport(0, true));
        $this->set('canUploadBulkImages', $this->userPrivilege->canUploadBulkImages(0, true));
        $this->set('frm', $frm);
        $this->set('action', 'settings');
        $this->_template->render(false, false, 'import-export/settings.php');
    }

    private function getSettingForm($langId)
    {
        $frm = new Form('frmImportExportSetting', array('id' => 'frmImportExportSetting'));

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_BRAND_ID_INSTEAD_OF_BRAND_IDENTIFIER", $langId), 'CONF_USE_BRAND_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_CATEGORY_ID_INSTEAD_OF_CATEGORY_IDENTIFIER", $langId), 'CONF_USE_CATEGORY_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_CATALOG_PRODUCT_ID_INSTEAD_OF_CATALOG_PRODUCT_IDENTIFIER", $langId), 'CONF_USE_PRODUCT_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        if (!FatApp::getConfig('CONF_WITHOUT_PROD_VARIANTS', FatUtility::VAR_INT, 0)) {
            $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_OPTION_ID_INSTEAD_OF_OPTION_IDENTIFIER", $langId), 'CONF_USE_OPTION_ID', 1, array(), false, 0);
            HtmlHelper::configureSwitchForCheckbox($fld);

            $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_OPTION_VALUE_ID_INSTEAD_OF_OPTION_IDENTIFIER", $langId), 'CONF_OPTION_VALUE_ID', 1, array(), false, 0);
            HtmlHelper::configureSwitchForCheckbox($fld);
        }

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_TAG_ID_INSTEAD_OF_TAG_IDENTIFIER", $langId), 'CONF_USE_TAG_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_TAX_ID_INSTEAD_OF_TAX_IDENTIFIER", $langId), 'CONF_USE_TAX_CATEOGRY_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_PRODUCT_TYPE_ID_INSTEAD_OF_PRODUCT_TYPE_IDENTIFIER", $langId), 'CONF_USE_PRODUCT_TYPE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_WEIGHT_UNIT_ID_INSTEAD_OF_WEIGHT_UNIT_IDENTIFIER", $langId), 'CONF_USE_WEIGHT_UNIT_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_LANG_ID_INSTEAD_OF_LANG_CODE", $langId), 'CONF_USE_LANG_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_CURRENCY_ID_INSTEAD_OF_CURRENCY_CODE", $langId), 'CONF_USE_CURRENCY_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_PRODUCT_CONDITION_ID_INSTEAD_OF_CONDITION_IDENTIFIER", $langId), 'CONF_USE_PROD_CONDITION_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_PERSENT_OR_FLAT_CONDITION_ID_INSTEAD_OF_IDENTIFIER", $langId), 'CONF_USE_PERSENT_OR_FLAT_CONDITION_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_COUNTRY_ID_INSTEAD_OF_COUNTRY_CODE", $langId), 'CONF_USE_COUNTRY_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_STATE_ID_INSTEAD_OF_STATE_IDENTIFIER", $langId), 'CONF_USE_STATE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_POLICY_POINT_ID_INSTEAD_OF_POLICY_POINT_IDENTIFIER", $langId), 'CONF_USE_POLICY_POINT_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_POLICY_POINT_TYPE_ID_INSTEAD_OF_POLICY_POINT_TYPE_IDENTIFIER", $langId), 'CONF_USE_POLICY_POINT_TYPE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_SHIPPING_PROFILE_ID_INSTEAD_OF_SHIPPING_PROFILE_IDENTIFIER", $langId), 'CONF_USE_SHIPPING_PROFILE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_SHIPPING_PACKAGE_ID_INSTEAD_OF_SHIPPING_PACKAGE_IDENTIFIER", $langId), 'CONF_USE_SHIPPING_PACKAGE_ID', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        $fld = $frm->addCheckBox(Labels::getLabel("FRM_USE_1_FOR_YES_0_FOR_NO", $langId), 'CONF_USE_O_OR_1', 1, array(), false, 0);
        HtmlHelper::configureSwitchForCheckbox($fld);

        return $frm;
    }

    private function getImportExportForm($langId, $type, $actionType)
    {
        $frm = new Form('frmImportExport', array('id' => 'frmImportExport'));
        $languages = Language::getAllNames();

        /* if($type != 'EXPORT_MEDIA'){ */
        if ($type == 'IMPORT_MEDIA') {
            $frm->addSelectBox(Labels::getLabel('FRM_UPLOAD_FILE_LANGUAGE', $langId), 'lang_id', $languages, '', array(), '')->requirements()->setRequired();
        } elseif ($type == 'EXPORT_MEDIA') {
            $frm->addSelectBox(Labels::getLabel('FRM_EXPORT_FILE_LANGUAGE', $langId), 'lang_id', $languages, '', array(), '')->requirements()->setRequired();
        } else {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', $languages, '', array(), '')->requirements()->setRequired();
        }
        /* } */

        $displayRangeFields = false;

        switch (strtoupper($type)) {
            case 'EXPORT':
                switch ($actionType) {
                    case Importexport::TYPE_PRODUCTS:
                    case Importexport::TYPE_SELLER_PRODUCTS:
                        $displayRangeFields = true;
                        $frm->addSelectBox(Labels::getLabel('FRM_SELECT_DATA', $langId), 'sheet_type', Importexport::getProductCatalogContentTypeArr($langId), '', array(), '')->requirements()->setRequired();
                        break;
                    case Importexport::TYPE_INVENTORIES:
                        $displayRangeFields = true;
                        $frm->addSelectBox(Labels::getLabel('FRM_SELECT_DATA', $langId), 'sheet_type', Importexport::getSellerProductContentTypeArr($langId), '', array(), '')->requirements()->setRequired();
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
                    case Importexport::TYPE_SELLER_PRODUCTS:
                        $frm->addSelectBox(Labels::getLabel('FRM_SELECT_DATA', $langId), 'sheet_type', Importexport::getProductCatalogContentTypeArr($langId), '', array(), '')->requirements()->setRequired();
                        break;
                    case Importexport::TYPE_INVENTORIES:
                        $frm->addSelectBox(Labels::getLabel('FRM_SELECT_DATA', $langId), 'sheet_type', Importexport::getSellerProductContentTypeArr($langId), '', array(), '')->requirements()->setRequired();
                        break;
                }
                $fldImg = $frm->addFileUpload(Labels::getLabel('FRM_FILE_TO_BE_UPLOADED:', $langId), 'import_file', array('id' => 'import_file'));
                $fldImg->setFieldTagAttribute('onChange', '$(\'#impoRTFILENAME\').html(this.value)');
                $fldImg->htmlBeforeField = '<div class="filefield">';
                $fldImg->htmlAfterField = "</div><span class='form-text text-muted'>" . Labels::getLabel('MSG_Invalid_data_will_not_be_processed', $langId) . "</span>";
                /*$fldImg->htmlBeforeField = '<div class="filefield"><span class="filename" id="importFileName"></span>';
                $fldImg->htmlAfterField = '</div>'; */
                break;
            case 'IMPORT_MEDIA':
                $fldImg = $frm->addFileUpload(Labels::getLabel('FRM_FILE_TO_BE_UPLOADED:', $langId), 'import_file', array('id' => 'import_file'));
                $fldImg->setFieldTagAttribute('onChange', '$(\'#impoRTFILENAME\').html(this.value)');
                $fldImg->htmlBeforeField = '<div class="filefield">';
                $fldImg->htmlAfterField = "</div><span class='form-text text-muted'>" . Labels::getLabel('MSG_Invalid_data_will_not_be_processed', $langId) . "</span>";
                /* $fldImg->htmlBeforeField = '<div class="filefield"><span class="filename" id="importFileName"></span>';
                $fldImg->htmlAfterField = '</div>'; */
                break;
        }

        if ($displayRangeFields) {
            $dataRangeArr = array(0 => Labels::getLabel('FRM_DOES_NOT_MATTER', $langId)) + Importexport::getDataRangeArr($langId);
            $rangeTypeFld = $frm->addSelectBox(Labels::getLabEL('FRM_EXPORT_DATA_RANGE', $langId), 'export_data_range', $dataRangeArr, '', array(), '');

            /* Start Id[ */
            $frm->addIntegerField(Labels::getLabel('FRM_START_ID', $langId), 'start_id', 1);
            $startIdUnReqObj = new FormFieldRequirement('START_Id', Labels::getLabel('FRM_START_ID', $langId));
            $startIdUnReqObj->setRequired(false);

            $startIdReqObj = new FormFieldRequirement('start_id', Labels::getLabel('FRM_START_ID', $langId));
            $startIdReqObj->setRequired(true);
            /*]*/

            /* End Id[ */
            $frm->addIntegerField(Labels::getLabel('FRM_END_ID', $langId), 'end_id', Importexport::MAX_LIMIT);
            $endIdUnReqObj = new FormFieldRequirement('eND_ID', Labels::getLabel('FRM_END_ID', $langId));
            $endIdUnReqObj->setRequired(false);

            $endIdReqObj = new FormFieldRequirement('end_id', Labels::getLabel('FRM_END_ID', $langId));
            $endIdReqObj->setRequired(true);
            //$endIdReqObj->setRange(1,Importexport::MAX_LIMIT);
            /*]*/

            /* Batch Count[ */
            $frm->addIntegerField(Labels::getLabel('FRM_COUNTS_PER_BATCH', $langId), 'batch_count', Importexport::MAX_LIMIT);
            $batchCountUnReqObj = new FormFieldRequiremeNT('BATCH_COUNT', Labels::getLabel('FRM_COUNTS_PER_BATCH', $langId));
            $batchCountUnReqObj->setRequired(false);

            $batchCountReqObj = new FormFieldRequirement('batch_count', Labels::getLabel('FRM_COUNTS_PER_BATCH', $langId));
            $batchCountReqObj->setRequired(true);
            $batchCountReqObj->setRange(1, Importexport::MAX_LIMIT);
            /*]*/

            /* Batch Number[ */
            $frm->addIntegerField(Labels::getLabel('FRM_BATCH_NUMBER', $langId), 'batch_number', 1);
            $batchNumberUnReqObj = new FormFieldRequiremENT('BATCH_Number', Labels::getLabel('FRM_BATCH_NUMBER', $langId));
            $batchNumberUnReqObj->setRequired(false);

            $batchNumberReqObj = new FormFieldRequirement('batch_number', Labels::getLabel('FRM_BATCH_NUMBER', $langId));
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
        $this->set('displayRangeFields', $displayRangeFields);
        return $frm;
    }

    public function uploadBulkMedia()
    {
        $this->userPrivilege->canUploadBulkImages();
        if ($_FILES['bulk_images']['error'] !== UPLOAD_ERR_OK) {
            $message = AttachedFile::uploadErrorMessage($_FILES['bulk_images']['error'], $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $fileName = $_FILES['bulk_images']['name'];
        $tmpName = $_FILES['bulk_images']['tmp_name'];

        $uploadBulkImgobj = new UploadBulkImages();
        $savedFile = $uploadBulkImgobj->upload($fileName, $tmpName, $this->userParentId);
        if (false === $savedFile) {
            FatUtility::dieJsonError($uploadBulkImgobj->getError());
        }

        $path = CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BULK_IMAGES_PATH;

        $filePath = AttachedFile::FILETYPE_BULK_IMAGES_PATH . $savedFile;

        $msg = '<br>' . str_replace('{path}', '<br><b>' . $filePath . '</b>', Labels::getLabel('MSG_Your_uploaded_files_path_will_be:_{path}', $this->siteLangId));
        $msg = Labels::getLabel('MSG_Uploaded_Successfully.', $this->siteLangId) . ' ' . $msg;
        $json = [
            "msg" => $msg,
            "path" => base64_encode($path . $savedFile)
        ];
        FatUtility::dieJsonSuccess($json);
    }

    public function uploadedBulkMediaList()
    {
        $this->userPrivilege->canUploadBulkImages();
        $db = FatApp::getDb();
        $post = FatApp::getPostedData();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $obj = new UploadBulkImages();
        $srch = $obj->bulkMediaFileObject($this->userParentId);

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $rs = $srch->getResultSet();
        $arrListing = $db->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('siteLangId', $this->siteLangId);
        $this->_template->render(false, false);
    }

    public function removeDir($directory)
    {
        $db = FatApp::getDb();
        $obj = new UploadBulkImages();
        $srch = $obj->bulkMediaFileObject($this->userParentId);
        $srch->addCondition('afile_physical_path', '=', base64_decode($directory));
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);

        if (0 < count($row)) {
            $directory = CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BULK_IMAGES_PATH . base64_decode($directory) . '/';
            $obj = new UploadBulkImages();
            $msg = $obj->deleteSingleBulkMediaDir($directory);
            FatUtility::dieJsonSuccess($msg);
        } else {
            $errMsg = Labels::getLabel("MSG_Directory_not_found.", $this->siteLangId);
            FatUtility::dieJsonError($errMsg);
        }
    }

    public function downloadPathsFile($path)
    {
        $this->userPrivilege->canViewImportExport();
        if (empty($path)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }
        $filesPathArr = UploadBulkImages::getAllFilesPath(base64_decode($path));
        if (!empty($filesPathArr) && 0 < count($filesPathArr)) {
            $headers[] = ['File Path', 'File Name'];
            $filesPathArr = array_merge($headers, $filesPathArr);
            CommonHelper::convertToCsv($filesPathArr, time() . '.csv');
            exit;
        }
        Message::addErrorMessage(Labels::getLabel('ERR_NO_FILE_FOUND', $this->siteLangId));
        CommonHelper::redirectUserReferer();
    }

    public function inventoryUpdate()
    {
        $this->userPrivilege->canViewImportExport();
        $extraPage = new Extrapage();
        $pageData = $extraPage->getContentByPageType(Extrapage::PRODUCT_INVENTORY_UPDATE_INSTRUCTIONS, $this->siteLangId);
        $frm = $this->getInventoryUpdateForm($this->siteLangId);
        $this->set('frm', $frm);
        $this->set('pageData', $pageData);
        $this->set('canEditImportExport', $this->userPrivilege->canEditImportExport(0, true));
        $this->set('canUploadBulkImages', $this->userPrivilege->canUploadBulkImages(0, true));
        $this->set('action', 'inventoryUpdate');
        $this->_template->render(false, false, 'seller/inventory-update.php');
    }

    private function getInventoryUpdateForm($langId = 0)
    {
        $frm = new Form('frmInventoryUpdate');
        $frm->addHiddenField('', 'lang_id', $langId);

        $fld = $frm->addButton('', 'csvfile', Labels::getLabel('FRM_UPLOAD_CSV_FILE', $this->siteLangId), array('class' => 'csvFile-Js', 'id' => 'csvFile-Js'));
        return $frm;
    }

    public function updateInventory()
    {
        if (!$this->userPrivilege->canEditImportExport(0, true)) {
            FatUtility::dieJsonError(Labels::getLabel('FRM_UNAUTHORIZED_ACCESS!', $this->siteLangId));
        }
        $frm = $this->getInventoryUpdateForm($this->siteLangId);
        $post = FatApp::getPostedData();
        $loggedUserId = $this->userParentId;
        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        if (!isset($_FILES['file'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_FILE_UPLOAD', $this->siteLangId));
        }

        if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId));
        }

        $uploadedFile = $_FILES['file']['tmp_name'];
        $fileHandle = fopen($uploadedFile, 'r');
        if ($fileHandle == false) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_FILE_UPLOAD', $this->siteLangId));
        }

        /* validate file extension[ */
        $mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv', 'application/octet-stream');
        if (!in_array($_FILES['file']['type'], $mimes)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_FILE_UPLOAD', $this->siteLangId));
        }
        /* ] */

        $defaultColArr = $this->getInventorySheetColoum($this->siteLangId);

        $importExport = new Importexport();
        $importExport->validateCSVHeaders($fileHandle, $defaultColArr, $this->siteLangId);

        $db = FatApp::getDb();
        $error = false;
        $row = 1;

        $importExport = new ImportexportCommon();
        $sheetName = Labels::getLabel('FRM_INVENTORY_UPDATE_ERROR', $this->siteLangId);
        $CSVfileObj = $importExport->openCSVfileToWrite($sheetName, $this->siteLangId, true);
        while (($dataArray = fgetcsv($fileHandle)) !== false) {
            $row++;
            $selprod_id = FatUtility::int($dataArray[0]);
            $selprod_sku = $dataArray[1];
            $selprod_cost_price = FatUtility::float($dataArray[3]);
            $selprod_price = FatUtility::float($dataArray[4]);
            $selprod_stock = FatUtility::int($dataArray[5]);

            $productId = SellerProduct::getAttributesById($selprod_id, 'selprod_product_id', false);
            $prodData = Product::getAttributesById($productId, array('product_min_selling_price'));

            if ($selprod_cost_price <= 0) {
                $msg = Labels::getLabel('MSG_PRODUCT_COST_PRICE_MUST_BE_GREATER_THAN_0', $this->siteLangId);
                $err = array($row, 4, $msg);
                CommonHelper::writeToCSVFile($CSVfileObj, $err);
                $error = true;
                continue;
            }

            if ($selprod_price < $prodData['product_min_selling_price']) {
                $msg = Labels::getLabel('MSG_SELLING_PRICE_SHOULD_BE_GREATER_THAN_EQUALS_TO_PRODUCT_MIN_SELLING_PRICE', $this->siteLangId);
                $err = array($row, 5, $msg);
                CommonHelper::writeToCSVFile($CSVfileObj, $err);
                $error = true;
                continue;
            }

            if ($selprod_price <= 0) {
                $msg = Labels::getLabel('MSG_PRODUCT_SELLING_PRICE_MUST_BE_GREATER_THAN_0', $this->siteLangId);
                $err = array($row, 5, $msg);
                CommonHelper::writeToCSVFile($CSVfileObj, $err);
                $error = true;
                continue;
            }

            if ($selprod_stock <= 0) {
                $msg = Labels::getLabel('MSG_STOCK_VALUE_MUST_BE_GREATER_THAN_0', $this->siteLangId);
                $err = array($row, 6, $msg);
                CommonHelper::writeToCSVFile($CSVfileObj, $err);
                $error = true;
                continue;
            }

            $assignValues = array();
            if ($selprod_price != '') {
                $assignValues['selprod_price'] = $selprod_price;
            }

            $assignValues['selprod_cost'] = $selprod_cost_price;
            $assignValues['selprod_stock'] = $selprod_stock;
            $assignValues['selprod_sku'] = $selprod_sku;
            if ($selprod_id > 0) {
                $whereSmt = array('smt' => 'selprod_user_id = ? and selprod_id = ?', 'vals' => array($loggedUserId, $selprod_id));
                $db->updateFromArray(SellerProduct::DB_TBL, $assignValues, $whereSmt);
            }
        }
        // Close File
        CommonHelper::writeToCSVFile($CSVfileObj, array(), true);
        if (CommonHelper::checkCSVFile($importExport->getCsvFileName())) {
            $success['CSVfileUrl'] = UrlHelper::generateFullUrl('custom', 'downloadLogFile', array($importExport->getCsvFileName()), CONF_WEBROOT_FRONTEND);
        }

        if ($error) {
            $success['msg'] = Labels::getLabel('FRM_ERROR!_PLEASE_CHECK_ERROR_LOG_SHEET', $this->siteLangId);
            FatUtility::dieJsonError($success);
        }

        Product::updateMinPrices();
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_Inventory_has_been_updated_successfully', $this->siteLangId));
    }

    public function exportInventory()
    {
        $this->userPrivilege->canViewImportExport();
        $srch = SellerProduct::getSearchObject($this->siteLangId);
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $srch->addCondition('selprod_user_id', '=', $this->userParentId);
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addCondition('selprod_active', '=', applicationConstants::ACTIVE);
        $srch->addOrder('product_name');
        $srch->addOrder('selprod_active', 'DESC');
        $srch->addMultipleFields(array('selprod_id', 'selprod_sku', 'selprod_price', 'selprod_cost', 'selprod_stock', 'IFNULL(product_name, product_identifier) as product_name', 'selprod_title'));
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        $inventoryData = FatApp::getDb()->fetchAll($rs, 'selprod_id');

        /* if( count($data) ){
          //$data['options'] = SellerProduct::getSellerProductOptions(0,true,$this->siteLangId);
          foreach( $data as & $arr ){
          $options = SellerProduct::getSellerProductOptions( $arr['selprod_id'], true, $this->siteLangId );
          }
          } */

        $sheetData = array();
        /* $arr = array('selprod_id','selprod_sku','selprod_title', 'selprod_price','selprod_stock'); */
        $arr = $this->getInventorySheetColoum($this->siteLangId);
        array_push($sheetData, $arr);

        foreach ($inventoryData as $key => $val) {
            $title = $val['product_name'];
            if ($val['selprod_title'] != "") {
                $title .= "-[" . $val['selprod_title'] . "]";
            }
            $arr = array($val['selprod_id'], $val['selprod_sku'], $title, $val['selprod_cost'], $val['selprod_price'], $val['selprod_stock']);
            array_push($sheetData, $arr);
        }

        CommonHelper::convertToCsv($sheetData, str_replace(' ', '_', Labels::getLabel('LBL_Inventory_Report', $this->siteLangId)) . '_' . date("Y-m-d") . '.csv', ',');
        exit;
    }

    private function getInventorySheetColoum($langId)
    {
        $arr = array(
            Labels::getLabel("LBL_Seller_Product_Id", $langId),
            Labels::getLabel("LBL_SKU", $langId),
            Labels::getLabel("LBL_Product", $langId),
            Labels::getLabel('LBL_Cost_Price', $langId),
            Labels::getLabel("LBL_Price", $langId),
            Labels::getLabel("LBL_Stock/Quantity", $langId)
        );
        return $arr;
    }
}
