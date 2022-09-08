<?php

trait ProductDigitalDownloads
{
    public function sellerProductDownloadFrm($productId, $selProdId = 0)
    {
        $this->userPrivilege->canEditProducts(UserAuthentication::getLoggedUserId());

        if (!UserPrivilege::isUserHasValidSubsription($this->userParentId)) {
            Message::addErrorMessage(Labels::getLabel("ERR_PLEASE_BUY_SUBSCRIPTION", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'Packages'));
        }
        $productId = FatUtility::int($productId);

        if (1 > $productId) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $productType = Product::getAttributesById($productId, 'product_type');
        if ($productType == false || $productType != Product::PRODUCT_TYPE_DIGITAL) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $selProdId = FatUtility::int($selProdId);

        $ddpObj = new DigitalDownloadPrivilages();

        if (0 < $selProdId) {
            $canDo = $ddpObj->canEdit(
                $selProdId,
                Product::CATALOG_TYPE_INVENTORY,
                $this->userParentId,
                $this->siteLangId,
                true
            );

            $sellerProductRow = $ddpObj->getSellerProduct($selProdId);
            $productId = $sellerProductRow['selprod_product_id'];
        } else {
            $canDo = $ddpObj->canEdit(
                $productId,
                Product::CATALOG_TYPE_PRIMARY,
                0,
                $this->siteLangId,
                true
            );
        }

        $frm = DigitalDownload::getDownloadFormInventory($this->siteLangId);

        $savedOptions = array();
        $productOptions = Product::getProductOptions($productId, $this->siteLangId, true);

        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');

        foreach ($optionCombinations as $optionKey => $optionValue) {
            /* Check if product is added for this option [ */
            $selProdCode = $productId . '_' . $optionKey;
            $selProdAvailable = Product::isSellProdAvailableForUser($selProdCode, $this->siteLangId, $this->userParentId);
            if (empty($selProdAvailable) || $selProdAvailable['selprod_deleted']) {
                continue;
            }
            $savedOptions[$selProdAvailable['selprod_id']] = $optionValue;
            /* ] */
        }

        if ($selProdId > 0) {
            $currentOption[$selProdId] = (array_key_exists($selProdId, $savedOptions)) ? $savedOptions[$selProdId] : '';
            $savedOptions = $currentOption;
        }
        $savedOptions = array_filter($savedOptions);

        $fld = $frm->getField('option_comb_id');
        if (1 > count($savedOptions)) {
            $frm->removeField($fld);
        } else {
            $fld->options = $savedOptions;
        }

        $showFldAttachWithExistingOrders = true;

        $fld = $frm->getField('attach_with_existing_orders');

        $product = $ddpObj->getProduct($productId);

        if (!is_array($product) && 1 > count($product)) {
            $showFldAttachWithExistingOrders = false;
            if (1 !== $product['product_attachements_with_inventory']) {
                $frm->removeField($fld);
            }
        }

        $this->set('showFldAttachWithExistingOrders', $showFldAttachWithExistingOrders);

        $data = ['record_id' => $selProdId];
        $frm->fill($data);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('canDo', $canDo);
        $this->set('savedOptions', $savedOptions);
        $this->set('downloadFrm', $frm);
        $this->set('selProdId', $selProdId);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function getInventoryDigitalDownloads()
    {

        $this->userPrivilege->canViewProducts();
        $recordId = FatApp::getPostedData('record_id', FatUtility::VAR_INT, 0);
        $type = FatApp::getPostedData('download_type', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $records = DigitalDownloadSearch::getInventoryLinks($recordId, $langId);
        } else {
            $records = DigitalDownloadSearch::getInventoryAttachments($recordId, $langId);
            $records = DigitalDownloadSearch::processAttachmentsWithPreview($records);
        }

        $ddpObj = new DigitalDownloadPrivilages();
        $canDo = $ddpObj->canEdit(
            $recordId,
            Product::CATALOG_TYPE_INVENTORY,
            $this->userParentId,
            $this->siteLangId,
            true
        );

        $this->set('records', $records);
        $this->set('canDelete', $canDo);
        $this->set('canDoDigDownload', $canDo);
        $this->set('recordId', $recordId);
        $this->set('downloadrefType', Product::CATALOG_TYPE_INVENTORY);

        $languages = Language::getAllNames();
        $languages = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $languages;
        $this->set('languages', $languages);

        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            echo $this->_template->render(false, false, 'seller/inventory-digital-download-links-list.php', true);
        } else {
            echo $this->_template->render(false, false, 'seller/inventory-digital-download-attachments-list.php', true);
        }
    }

    public function downloadAttachment($aFileId, $recordId, $requestType, $isPreview = 0)
    {
        $this->userPrivilege->canViewProducts();

        $aFileId = FatUtility::int($aFileId);
        $recordId = FatUtility::int($recordId);
        $isPreview = FatUtility::int($isPreview);
        $requestType = FatUtility::int($requestType);

        if (1 > $aFileId || 1 > $recordId) {
            FatUtility::dieWithError(Labels::getLabel("LBL_Invalid_Request", $this->siteLangId));
        }

        $ddpObj = new DigitalDownloadPrivilages();
        $canDo = $ddpObj->canDownload(
            $recordId,
            $requestType,
            $this->userParentId,
            $this->siteLangId,
            $isPreview
        );

        if (false == $canDo) {
            FatUtility::dieJsonError($ddpObj->getError());
        }

        if (Product::CATALOG_TYPE_INVENTORY == $requestType) {
            $sellerProduct = $ddpObj->getSellerProduct($recordId);
            $product = $ddpObj->getProduct($sellerProduct['selprod_product_id']);

            if (applicationConstants::NO == $product['product_attachements_with_inventory']) {
                $recordId = $sellerProduct['selprod_product_id'];
                $requestType = Product::CATALOG_TYPE_PRIMARY;
            }
        }

        $file = DigitalDownloadSearch::getAttachmentDetail($aFileId, $recordId, $requestType, $isPreview);

        if (1 > count($file)) {
            FatUtility::dieWithError(Labels::getLabel("LBL_File_not_found", $this->siteLangId));
        }

        if ($file['pddr_record_id'] != $recordId) {
            FatUtility::dieWithError(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
        }

        if (!file_exists(CONF_UPLOADS_PATH . $file['afile_physical_path'])) {
            FatUtility::dieWithError(Labels::getLabel("LBL_File_not_found", $this->siteLangId));
        }

        $fileName = isset($file['afile_physical_path']) ? $file['afile_physical_path'] : '';
        AttachedFile::downloadAttachment($fileName, $file['afile_name']);
    }

    public function downloadOpAttachment($aFileId, $recordId)
    {
        $aFileId = FatUtility::int($aFileId);
        $recordId = FatUtility::int($recordId);
        $fileType = AttachedFile::FILETYPE_ORDER_PRODUCT_DIGITAL_DOWNLOAD;
        $userId = $this->userParentId;

        if (1 > $aFileId || 1 > $recordId) {
            Message::addErrorMessage(Labels::getLabel('LBL_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'products'));
        }

        $srch = new OrderProductSearch(0, true);
        $srch->addMultipleFields(array('op_id', 'op_selprod_user_id'));
        $srch->addCondition('op_id', '=', 'mysql_func_' . $recordId, 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        if ($row == false || ($row && $row['op_selprod_user_id'] !== $userId)) {
            Message::addErrorMessage(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'viewOrder', array($recordId)));
        }

        $file_row = AttachedFile::getAttributesById($aFileId);
        if ($file_row == false || $file_row['afile_record_id'] != $recordId || $file_row['afile_type'] != $fileType) {
            Message::addErrorMessage(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'viewOrder', array($recordId)));
        }

        if (!file_exists(CONF_UPLOADS_PATH . $file_row['afile_physical_path'])) {
            Message::addErrorMessage(Labels::getLabel('LBL_FILE_NOT_FOUND', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'viewOrder', array($recordId)));
        }

        $fileName = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        AttachedFile::downloadAttachment($fileName, $file_row['afile_name']);
    }

    public function setupAdditionalOpAttachment()
    {
        $opId = FatApp::getPostedData('op_id', FatUtility::VAR_INT, 0);
        if (1 > $opId) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId) . __LINE__);
        }

        $opSrch = OrderProduct::getSearchObject();

        $opSrch->addCondition('op_id', '=', 'mysql_func_' . $opId, 'AND', true);
        $opSrch->addCondition('op_product_type', '=', 'mysql_func_' . Product::PRODUCT_TYPE_DIGITAL, 'AND', true);

        $opSrch->addMultipleFields(['op_status_id', 'op_selprod_user_id']);

        $opSrch->doNotCalculateRecords();
        $opSrch->setPageSize(1);

        $rs = $opSrch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!is_array($row)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
        }

        if ($this->userParentId != $row['op_selprod_user_id']) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
        }

        if (!DigitalOrderProduct::canAttachMoreFiles($row['op_status_id'])) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
        }

        if (
            !isset($_FILES['additional_attachment']['tmp_name'])
            || !is_uploaded_file($_FILES['additional_attachment']['tmp_name'])
        ) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId));
        }

        $fileHandlerObj = new AttachedFile();

        if ($fileHandlerObj->saveAttachment(
            $_FILES['additional_attachment']['tmp_name'],
            AttachedFile::FILETYPE_ORDER_PRODUCT_DIGITAL_DOWNLOAD,
            $opId,
            0,
            $_FILES['additional_attachment']['name'],
            -1,
            false,
            0
        )) {
            FatUtility::dieJsonSuccess(Labels::getLabel('LBL_File_uploaded_successfully', $this->siteLangId));
        }

        FatUtility::dieJsonError($fileHandlerObj->getError());
    }

    abstract protected function checkEditPrivilege(): bool;
    abstract protected function getCatalogType(): int;

    public function digitalDownloadForm($recordId, $type)
    {
        $this->checkEditPrivilege();
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (!array_key_exists($type, applicationConstants::digitalDownloadTypeArr($this->siteLangId))) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $catalogType = $this->getCatalogType();
        if (Product::CATALOG_TYPE_REQUEST == $catalogType) {
            $productData = ProductRequest::getAttributesById($recordId, ['preq_content', 'preq_user_id']);
            if ($productData == false) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
            $productData = $productData + json_decode($productData['preq_content'], true);
            if (!isset($productData['product_type']) || $productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
            $productOptions = ProductRequest::getProductReqOptions($recordId, $this->siteLangId, true);
        } else {
            $productData = Product::getAttributesById($recordId, ['product_type', 'product_seller_id']);
            if ($productData == false) {
                LibHelper::exitWithError($this->str_invalid_request_id, true);
            }
            if (false == $productData || $productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }

            $productOptions = Product::getProductOptions($recordId, $this->siteLangId, true);
        }

        $frm = DigitalDownload::getDownloadForm($this->siteLangId, $type, $recordId);
        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');

        $fld = $frm->getField('option_comb_id');
        if (1 > count($optionCombinations)) {
            $frm->removeField($fld);
        } else {
            $optionCombinations = array('0' => Labels::getLabel('FRM_All', $this->siteLangId)) + $optionCombinations;
            $fld->options = $optionCombinations;
        }

        $formTitle = Labels::getLabel('LBL_DIGITAL_LINKS_SETUP', $this->siteLangId);
        if ($type == applicationConstants::DIGITAL_DOWNLOAD_FILE) {
            $formTitle = Labels::getLabel('LBL_DIGITAL_FILES_ATTACHMENT_SETUP', $this->siteLangId);
        }

        $this->set('frm', $frm);
        $this->set('type', $type);
        $this->set('formTitle', $formTitle);
        $this->set('html', $this->_template->render(false, false, 'products/digital-download-form.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }


    public function fileLinkForm($recordId)
    {
        $this->checkEditPrivilege();
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $productData = Product::getAttributesById($recordId, ['product_type', 'product_seller_id', 'product_added_by_admin_id', 'product_attachements_with_inventory']);
        if (false == $productData || $productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (0 < $productData['product_added_by_admin_id'] && 0 < $productData['product_attachements_with_inventory']) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $productOptions = Product::getProductOptions($recordId, $this->siteLangId, true);

        $frm = $this->getFileLinkForm($recordId);
        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');

        $fld = $frm->getField('option_comb_id');
        if (1 > count($optionCombinations)) {
            $frm->removeField($fld);
        } else {
            $optionCombinations = array('0' => Labels::getLabel('FRM_All', $this->siteLangId)) + $optionCombinations;
            $fld->options = $optionCombinations;
        }

        $formTitle = Labels::getLabel('LBL_DIGITAL_LINKS_SETUP', $this->siteLangId);

        $this->set('frm', $frm);
        $this->set('formTitle', $formTitle);
        $this->set('html', $this->_template->render(false, false, 'products/file-link-form.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }


    private function getFileLinkForm($recordId)
    {
        $frm = new Form('frmDownload');
        $digitalDownloadTypeArr = applicationConstants::digitalDownloadTypeArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_DIGITAL_DOWNLOAD_TYPE', $this->siteLangId), 'download_type', $digitalDownloadTypeArr, '', array('class' => 'download-type'), '')->requirements()->setRequired();
        $frm->addSelectBox(Labels::getLabel('FRM_OPTION', $this->siteLangId), 'option_comb_id', [], '', array('class' => 'option-comb-id-js'), '');
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', array(0 => Labels::getLabel('FRM_ALL_LANGUAGES', $this->siteLangId)) + Language::getDropDownList(), '', array(), '')->requirements()->setRequired();
        $frm->addHiddenField('', 'record_id', $recordId);
        return $frm;
    }

    public function getDigitalDownloadLinks()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $optionCombi = FatApp::getPostedData('option_comb', null, '0');
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        $catalogType = $this->getCatalogType();

        if (Product::CATALOG_TYPE_REQUEST == $catalogType) {
            $productData = ProductRequest::getAttributesById($recordId, ['preq_content', 'preq_user_id']);
            if ($productData == false) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
            $productData = $productData + json_decode($productData['preq_content'], true);
            if (!isset($productData['product_type']) || $productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
        } else {
            $productData = Product::getAttributesById($recordId, ['product_type', 'product_seller_id', 'product_added_by_admin_id', 'product_attachements_with_inventory']);
            if (false == $productData || $productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            if (0 < $productData['product_added_by_admin_id'] && 0 < $productData['product_attachements_with_inventory']) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
        }

        $ddpObj = new DigitalDownloadPrivilages();
        $canDo = $ddpObj->canEdit($recordId, $catalogType, UserAuthentication::getLoggedUserId(), $this->siteLangId, false);
        $this->set('canDo', $canDo);

        $product = $ddpObj->getProduct($recordId);
        $this->set('product', $product);

        $rows = DigitalDownloadSearch::getLinks($recordId, $catalogType, $optionCombi, $langId);
        $languages = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + Language::getAllNames();

        if (Product::CATALOG_TYPE_REQUEST == $catalogType) {
            $productOptions = ProductRequest::getProductReqOptions($recordId, $this->siteLangId, true);
        } else {
            $productOptions = Product::getProductOptions($recordId, $this->siteLangId, true);
        }
        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');
        $optionCombinations = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $optionCombinations;

        $this->set('links', $rows);
        $this->set('languages', $languages);
        $this->set('options', $optionCombinations);
        $this->set('showNoRecordFound', FatApp::getPostedData('showNoRecordFound', FatUtility::VAR_INT, 0));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function getDigitalDownloadAttachments()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $optionComb = FatApp::getPostedData('option_comb', null, '0');
        $langId = FatApp::getPostedData('langId', null, 0);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $ddpObj = new DigitalDownloadPrivilages();

        $catalogType = $this->getCatalogType();

        if (Product::CATALOG_TYPE_REQUEST == $catalogType) {
            $productData = ProductRequest::getAttributesById($recordId, ['preq_content', 'preq_user_id']);
            if ($productData == false) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
            $productData = $productData + json_decode($productData['preq_content'], true);
            if (!isset($productData['product_type']) || $productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
        } else {
            $productData = Product::getAttributesById($recordId, ['product_type', 'product_seller_id', 'product_attachements_with_inventory', 'product_added_by_admin_id']);
            if (false == $productData || $productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }

            if (0 < $productData['product_added_by_admin_id'] && 0 < $productData['product_attachements_with_inventory']) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
        }

        $canDo = $ddpObj->canEdit($recordId, $catalogType, UserAuthentication::getLoggedUserId(), $this->siteLangId, false);
        $this->set('canDo', $canDo);

        $attachments = DigitalDownloadSearch::getAttachments($recordId, $catalogType, $optionComb, $langId);

        $attachments = DigitalDownloadSearch::processAttachmentsWithPreview($attachments);

        $this->set('attachments', $attachments);
        $this->set('languages', array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + Language::getAllNames());

        if (Product::CATALOG_TYPE_REQUEST == $catalogType) {
            $productOptions = ProductRequest::getProductReqOptions($recordId, $this->siteLangId, true);
        } else {
            $productOptions = Product::getProductOptions($recordId, $this->siteLangId, true);
        }

        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');
        $optionCombinations = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $optionCombinations;

        $this->set('options', $optionCombinations);
        $this->set('recordId', $recordId);
        $this->set('downloadrefType', $catalogType);
        $this->set('showNoRecordFound', FatApp::getPostedData('showNoRecordFound', FatUtility::VAR_INT, 0));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setupDigitalDownload()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('record_id', FatUtility::VAR_INT, 0);
        $type = FatApp::getPostedData('download_type', FatUtility::VAR_INT, 0);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $catalogType = $this->getCatalogType();

        if (Product::CATALOG_TYPE_REQUEST == $catalogType) {
            $productData = ProductRequest::getAttributesById($recordId, ['preq_content', 'preq_user_id']);
            if ($productData == false) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
            $productData = $productData + json_decode($productData['preq_content'], true);
            if (!isset($productData['product_type']) || $productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
            $userId =  $productData['preq_user_id'];
        } elseif (Product::CATALOG_TYPE_INVENTORY == $catalogType) {
            $selProdData = SellerProduct::getAttributesById($recordId, array('selprod_user_id', 'selprod_code', 'selprod_product_id'));
            if (!is_array($selProdData) && 1 > count($selProdData)) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
            $userId =  $selProdData['selprod_user_id'];
        } else {
            $productData = Product::getAttributesById($recordId, ['product_type', 'product_seller_id']);
            if ($productData == false) {
                LibHelper::exitWithError($this->str_invalid_request_id, true);
            }
            if (false == $productData || $productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $userId =  $productData['product_seller_id'];
        }

        if (!array_key_exists($type, applicationConstants::digitalDownloadTypeArr($this->siteLangId))) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if ($userId !== $this->userParentId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $optionValId = FatApp::getPostedData('option_comb_id', null, 0);

        $ddpObj = new DigitalDownloadPrivilages();
        if (Product::CATALOG_TYPE_INVENTORY == $catalogType) {
            $canDo = $ddpObj->canEdit($recordId, $catalogType, $userId, $this->siteLangId, true);
            if (false === $canDo) {
                FatUtility::dieJsonError($ddpObj->getError());
            }
            $selProdOption = explode('_', $selProdData['selprod_code']);
            array_shift($selProdOption);
            if (0 < count($selProdOption)) {
                $optionValId = implode('_', $selProdOption);
            } else {
                $optionValId = '0';
            }
            $this->set('productId', $selProdData['selprod_product_id']);
        } else {
            $canDo = $ddpObj->canEdit($recordId, $catalogType, $userId, $this->siteLangId, false);
            if (false === $canDo) {
                LibHelper::exitWithError($ddpObj->getError());
            }
        }

        $frm = DigitalDownload::getDownloadForm($this->siteLangId, $type, $recordId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $post['option_comb_id'] = $optionValId;

        $ddObj = new DigitalDownload();
        $refId = $ddObj->getReferenceId($recordId, $optionValId, $catalogType);
        if (1 > $refId) {
            if (!$ddObj->saveReference($recordId, $optionValId, $catalogType)) {
                LibHelper::exitWithError($ddObj->getError(), true);
            }
        } else {
            $ddObj->setMainTableRecordId($refId);
        }

        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $this->setupDigitalLink($ddObj, $post);
        } else {
            $this->setupDigitalFile($ddObj, $post);
        }
    }

    public function deleteDigitalLink($linkId, $refId)
    {
        $this->checkEditPrivilege();
        $refId = FatUtility::int($refId);
        $linkId = FatUtility::int($linkId);

        if (1 > $refId || 1 > $linkId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $reference = DigitalDownload::getAttributesById($refId);

        if (false == $reference) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $link = DigitalDownloadSearch::getLinkDetail($linkId);
        if (1 > count($link)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $catalogType = $this->getCatalogType();
        if (false == $reference ||  $catalogType != $reference['pddr_type']) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $validateAllowedWithInventory = false;
        if (Product::CATALOG_TYPE_INVENTORY == $reference['pddr_type']) {
            $validateAllowedWithInventory = true;
        }

        if (Product::CATALOG_TYPE_REQUEST == $reference['pddr_type']) {
            $userId = ProductRequest::getAttributesById($reference['pddr_record_id'], 'preq_user_id');
        } else {
            $userId = Product::getAttributesById($reference['pddr_record_id'], 'product_seller_id');
        }

        $ddpObj = new DigitalDownloadPrivilages();
        $canDo = $ddpObj->canEdit(
            $reference['pddr_record_id'],
            $reference['pddr_type'],
            $userId,
            $this->siteLangId,
            $validateAllowedWithInventory
        );

        if (false == $canDo) {
            LibHelper::exitWithError($ddpObj->getError(), true);
        }

        $ddObj = new DigitalDownload();

        if (!$ddObj->deleteLink($linkId, $refId)) {
            LibHelper::exitWithError($ddObj->getError(), true);
        }

        $totalLinksCount = DigitalDownloadSearch::getTotalLinksCount($refId);
        $totalAttachmentCount = DigitalDownloadSearch::getTotalAttachmentsCount($refId);

        if (1 > $totalLinksCount && 1 > $totalAttachmentCount) {
            $ddObj->deleteReference($refId);
        }
        LibHelper::exitWithSuccess($this->str_delete_record, true);
    }

    private function setupDigitalFile($ddObj, $post)
    {
        if ((!isset($_FILES['downloadable_file']['tmp_name']) || !is_uploaded_file($_FILES['downloadable_file']['tmp_name'])) && (!isset($_FILES['preview_file']['tmp_name']) || !is_uploaded_file($_FILES['preview_file']['tmp_name']))
        ) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId), true);
        }

        $langId = FatUtility::int($post['lang_id']);
        $optionComb = $post['option_comb_id'];
        $isPreview = FatUtility::int($post['is_preview']);
        $refFileId = FatUtility::int($post['ref_file_id']);
        $mainFileId = 0;
        if (1 == $isPreview) {
            if (AttachedFile::getAttributesById($refFileId, 'afile_record_id') != $ddObj->getMainTableRecordId()) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            if (array_key_exists('downloadable_file', $_FILES)) {
                unset($_FILES['downloadable_file']);
            }
            $mainFileId = $refFileId;
        }

        if (
            isset($_FILES['downloadable_file']['tmp_name']) && is_uploaded_file($_FILES['downloadable_file']['tmp_name'])
        ) {
            $mainFileId = $this->setupDigitalMainFile($ddObj, $langId);
            if (1 > $mainFileId) {
                LibHelper::exitWithError($ddObj->getError(), true);
            }

            $attachWithExistingOrders = $post['attach_with_existing_orders'];
            if (1 == $attachWithExistingOrders) {
                $ddObj->attachFileWithOrderedProducts($mainFileId, $post['record_id'], $this->getCatalogType(), $langId, $optionComb);
            }
        }

        if (
            isset($_FILES['preview_file']['tmp_name']) && is_uploaded_file($_FILES['preview_file']['tmp_name'])
        ) {
            if (1 > $this->setupDigitalPreviewFile($ddObj, $langId, $mainFileId)) {
                LibHelper::exitWithError($ddObj->getError(), true);
            }
        }
        $this->set('langId', $langId);
        $this->set('optionComb', $optionComb);
        $this->set('recordId', $post['record_id']);
        $this->set('downloadType', $post['download_type']);
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteDigitalFile()
    {
        $this->checkEditPrivilege();

        $refId = FatApp::getPostedData('ref_id', FatUtility::VAR_INT, 0);
        $aFileId = FatApp::getPostedData('afile_id', FatUtility::VAR_INT, 0);
        $isPreviewFile = FatApp::getPostedData('is_preview', FatUtility::VAR_INT, 0);
        $delFullRow = FatApp::getPostedData('frow', FatUtility::VAR_INT, 0);

        if (1 > $refId || 1 > $aFileId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $reference = DigitalDownload::getAttributesById($refId);
        $catalogType = $this->getCatalogType();
        if (false == $reference ||  $catalogType != $reference['pddr_type']) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $validateAllowedWithInventory = false;
        if (Product::CATALOG_TYPE_INVENTORY == $reference['pddr_type']) {
            $validateAllowedWithInventory = true;
        }

        if (Product::CATALOG_TYPE_REQUEST == $reference['pddr_type']) {
            $userId = ProductRequest::getAttributesById($reference['pddr_record_id'], 'preq_user_id');
        }
        if (Product::CATALOG_TYPE_INVENTORY == $reference['pddr_type']) {
            $userId = SellerProduct::getAttributesById($reference['pddr_record_id'], 'selprod_user_id');
        } else {
            $userId = Product::getAttributesById($reference['pddr_record_id'], 'product_seller_id');
        }

        $ddpObj = new DigitalDownloadPrivilages();
        $canDo = $ddpObj->canEdit(
            $reference['pddr_record_id'],
            $reference['pddr_type'],
            $userId,
            $this->siteLangId,
            $validateAllowedWithInventory
        );

        if (false == $canDo) {
            LibHelper::exitWithError($ddpObj->getError(), true);
        }

        $digDownload = new DigitalDownload();
        if (!$digDownload->deleteAttachment($aFileId, $refId, $isPreviewFile, $delFullRow)) {
            LibHelper::exitWithError($digDownload->getError(), true);
        }

        LibHelper::exitWithSuccess($this->str_delete_record, true);
    }

    private function setupDigitalMainFile($ddObj, $langId)
    {
        $fileId = $ddObj->saveAttachment(
            $_FILES['downloadable_file']['tmp_name'],
            $_FILES['downloadable_file']['name'],
            $ddObj->getMainTableRecordId(),
            0,
            $langId
        );
        if (1 > $fileId) {
            return 0;
        }

        return $fileId;
    }

    private function setupDigitalPreviewFile($ddObj, $langId, $mainFileId = 0)
    {
        $fileId = $ddObj->saveAttachment(
            $_FILES['preview_file']['tmp_name'],
            $_FILES['preview_file']['name'],
            $ddObj->getMainTableRecordId(),
            $mainFileId,
            $langId,
            true
        );

        if (1 > $fileId) {
            return 0;
        }

        return $fileId;
    }

    private function setupDigitalLink($ddObj, $post)
    {
        $downloadLink = FatApp::getPostedData('product_downloadable_link', null, '');
        $previewLink = FatApp::getPostedData('product_preview_link', null, '');

        if ('' == $post['product_downloadable_link'] && '' == $post['product_preview_link']) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_ADD_LINK', $this->siteLangId), true);
        }

        $langId = FatUtility::int($post['lang_id']);
        $optionComb = $post['option_comb_id'];
        $ddLinkId = FatUtility::int($post['dd_link_id']);

        if (!$ddObj->saveLink($langId, $downloadLink, $previewLink, $ddLinkId)) {
            LibHelper::exitWithError($ddObj->getError(), true);
        }

        $attachWithExistingOrders = FatUtility::int($post['attach_with_existing_orders']);
        if ($attachWithExistingOrders == applicationConstants::YES && '' != $downloadLink) {
            $ddObj->attachLinkWithOrderedProducts($downloadLink, $post['record_id'], $this->getCatalogType(), $optionComb);
        }

        $this->set('langId', $langId);
        $this->set('optionComb', $optionComb);
        $this->set('recordId', $post['record_id']);
        $this->set('downloadType', $post['download_type']);
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }
}
