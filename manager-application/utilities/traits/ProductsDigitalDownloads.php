<?php

trait ProductsDigitalDownloads
{
    public function sellerProductDownloadFrm($selProdId)
    {
        $this->objPrivilege->canEditSellerProducts();

        $selProdId = FatUtility::int($selProdId);

        $sellerProductRow = SellerProduct::getAttributesById($selProdId, ['selprod_user_id', 'selprod_product_id']);

        if (false == $sellerProductRow) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        $productId = $sellerProductRow['selprod_product_id'];

        $product = Product::getAttributesById($productId, ['product_attachements_with_inventory']);

        if (false == $product) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        $ddpObj = new DigitalDownloadPrivilages();

        $canDo = $ddpObj->canEdit($selProdId, Product::CATALOG_TYPE_INVENTORY, 0, $this->siteLangId, true, true);

        $frm = DigitalDownload::getDownloadFormInventory($this->siteLangId,$selProdId);

        $savedOptions = array();
        $productOptions = Product::getProductOptions($productId, $this->siteLangId, true);
        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');

        foreach ($optionCombinations as $optionKey => $optionValue) {
            /* Check if product is added for this option [ */
            $selProdCode = $productId . '_' . $optionKey;
            $selProdAvailable = Product::isSellProdAvailableForUser($selProdCode, $this->siteLangId, $sellerProductRow['selprod_user_id']);
            if (empty($selProdAvailable) || $selProdAvailable['selprod_deleted']) {
                continue;
            }
            $savedOptions[$selProdAvailable['selprod_id']] = $optionValue;
            /* ] */
        }
        $currentOption[$selProdId] = (array_key_exists($selProdId, $savedOptions)) ? $savedOptions[$selProdId] : '';
        $savedOptions = $currentOption;

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
            if (1 !== $product['product_attachements_with_inventory']) {
                $frm->removeField($fld);
                $showFldAttachWithExistingOrders = false;
            }
        }

        $this->set('showFldAttachWithExistingOrders', $showFldAttachWithExistingOrders);

        $this->set('canDo', $canDo);
        $this->set('formTitle', Labels::getLabel('LBL_DIGITAL_FILES_OR_LINKS', $this->siteLangId));
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function getInventoryDigitalDownloads()
    {
        $this->objPrivilege->canViewSellerProducts();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $type = FatApp::getPostedData('download_type', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $records = DigitalDownloadSearch::getInventoryLinks($recordId, $langId);
        } else {
            $records = DigitalDownloadSearch::getInventoryAttachments($recordId, $langId);
            $records = DigitalDownloadSearch::processAttachmentsWithPreview($records);
        }

        $ddpObj = new DigitalDownloadPrivilages();

        $canDoDigDownload = $ddpObj->canEdit($recordId, Product::CATALOG_TYPE_INVENTORY, 0, $this->siteLangId, true, true);

        $this->set('canDelete', $canDoDigDownload);
        $this->set('canDoDigDownload', $canDoDigDownload);
        $this->set('arrListing', $records);
        $this->set('recordId', $recordId);
        $this->set('downloadrefType', Product::CATALOG_TYPE_INVENTORY);
        $languages = Language::getAllNames();
        $languages = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $languages;
        $this->set('languages', $languages);

        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $html =  $this->_template->render(false, false, 'seller-products/inventory-digital-download-links-list.php', true);
        } else {
            $html = $this->_template->render(false, false, 'seller-products/inventory-digital-download-attachments-list.php', true);
        }
        $this->set('html', $html);
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function downloadAttachment($aFileId, $recordId, $requestType, $isPreview = 0)
    {
        $this->objPrivilege->canViewSellerProducts();

        $aFileId = FatUtility::int($aFileId);
        $recordId = FatUtility::int($recordId);
        $isPreview = FatUtility::int($isPreview);
        $requestType = FatUtility::int($requestType);

        if (1 > $aFileId || 1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel("LBL_Invalid_Request", $this->siteLangId));
        }

        $ddpObj = new DigitalDownloadPrivilages();

        $ddpObj->getSellerProduct($recordId);

        $selProdData = $ddpObj->getSellerProduct($recordId);

        if (1 > count($selProdData)) {
            LibHelper::exitWithError(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
        }

        $ddpObj->getProduct($selProdData['selprod_product_id']);

        if (false == $ddpObj->allowedWithInventory($selProdData['selprod_product_id'])) {
            $recordId = $selProdData['selprod_product_id'];
            $requestType = Product::CATALOG_TYPE_PRIMARY;
        }

        $canDo = $ddpObj->canDownload($recordId, $requestType, 0, $this->siteLangId, $isPreview, true);

        if (false == $canDo) {
            LibHelper::exitWithError($ddpObj->getError());
        }

        $file = DigitalDownloadSearch::getAttachmentDetail($aFileId, $recordId, $requestType, $isPreview);
        if (1 > count($file)) {
            LibHelper::exitWithError(Labels::getLabel("LBL_File_not_found", $this->siteLangId));
        }

        if ($file['pddr_record_id'] != $recordId) {
            LibHelper::exitWithError(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
        }

        if (!file_exists(CONF_UPLOADS_PATH . $file['afile_physical_path'])) {
            LibHelper::exitWithError(Labels::getLabel("LBL_File_not_found", $this->siteLangId));
        }

        $fileName = isset($file['afile_physical_path']) ? $file['afile_physical_path'] : '';
        AttachedFile::downloadAttachment($fileName, $file['afile_name']);
    }
}
