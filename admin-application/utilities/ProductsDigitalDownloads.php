<?php

trait ProductsDigitalDownloads
{
    public function sellerProductDownloadFrm($selProdId)
    {
        $this->objPrivilege->canEditSellerProducts();

        $selProdId = FatUtility::int($selProdId);

        $sellerProductRow = SellerProduct::getAttributesById($selProdId, ['selprod_user_id', 'selprod_product_id']);

        if (false == $sellerProductRow) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
        }

        $productId = $sellerProductRow['selprod_product_id'];

        $product = Product::getAttributesById($productId, ['product_attachements_with_inventory']);

        if (false == $product) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
        }

        $canDo = DigitalDownload::canDo($selProdId, Product::CATALOG_TYPE_INVENTORY, 0, $this->adminLangId, true, true);
        
        $frm = DigitalDownload::getDownloadForm($this->adminLangId);

        $savedOptions = array();
        $productOptions = Product::getProductOptions($productId, $this->adminLangId, true);
        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');
        
        foreach ($optionCombinations as $optionKey => $optionValue) {
            /* Check if product is added for this option [ */
            $selProdCode = $productId . '_' . $optionKey;
            $selProdAvailable = Product::isSellProdAvailableForUser($selProdCode, $this->adminLangId, $sellerProductRow['selprod_user_id']);
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

        $product = Product::getAttributesById($productId, ['product_attachements_with_inventory']);

        if (1 !== $product['product_attachements_with_inventory']) {
            $frm->removeField($fld);
            $showFldAttachWithExistingOrders = false;
        }
        
        $this->set('showFldAttachWithExistingOrders', $showFldAttachWithExistingOrders);

        $data = [
            'product_id' => $productId,
            'selprod_id' =>  $selProdId,
        ];
        $frm->fill($data);
        $this->set('canDo', $canDo);
        $this->set('savedOptions', $savedOptions);
        $this->set('downloadFrm', $frm);
        $this->set('adminLangId', $this->adminLangId);
        $this->set('product_id', $productId);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function getInventoryDigitalDownloads()
    {
        $this->objPrivilege->canViewSellerProducts();

        $selProdId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $type = FatApp::getPostedData('download_type', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $records = DigitalDownloadSearch::getInventoryLinks($selProdId, $langId);
        } else {
            $records = DigitalDownloadSearch::getInventoryAttachments($selProdId, $langId);
        }
        
        $canDelete = DigitalDownload::canDelete($selProdId, Product::CATALOG_TYPE_INVENTORY, 0, $this->adminLangId, true, true);
        $canDoDigDownload = DigitalDownload::canDo($selProdId, Product::CATALOG_TYPE_INVENTORY, 0, $this->adminLangId, true, true);
        
        $this->set('canDelete', $canDelete);
        $this->set('canDoDigDownload', $canDoDigDownload);
        $this->set('records', $records);
        $this->set('recordId', $selProdId);
        $this->set('downloadrefType', Product::CATALOG_TYPE_INVENTORY);
        $languages = Language::getAllNames();
        $languages = array('0' => Labels::getLabel('LBL_All', $this->adminLangId)) + $languages;
        $this->set('languages', $languages);

        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            echo $this->_template->render(false, false, 'seller-products/inventory-digital-download-links-list.php', true);
        } else {
            echo $this->_template->render(false, false, 'seller-products/inventory-digital-download-attachments-list.php', true);
        }
    }

    public function setupDigitalDownloads()
    {
        $this->objPrivilege->canEditSellerProducts();

        $inventoryId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        
        if (1 > $inventoryId) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
        }

        if (false == DigitalDownload::canDo($inventoryId, Product::CATALOG_TYPE_INVENTORY, 0, $this->adminLangId, true, true)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Attachments_or_links_allowed_with_Product', $this->adminLangId));
        }

        
        $selProdData = SellerProduct::getAttributesById($inventoryId, array('selprod_user_id', 'selprod_code'));
        if (false == $selProdData) {
            Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS", $this->adminLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }
        
        $selProdOption = explode('_', $selProdData['selprod_code']);
        array_shift($selProdOption);
        if (0 < count($selProdOption)) {
            $optionComb = implode('_', $selProdOption);
        } else {
            $optionComb = '0';
        }
        
        $type = FatApp::getPostedData('download_type', FatUtility::VAR_INT, 1);
        
        $ddObj = new DigitalDownload();
        
        $refId = $ddObj->getReferenceId($inventoryId, $optionComb, Product::CATALOG_TYPE_INVENTORY);
        
        if (1 > $refId) {
            if (!$ddObj->saveReference($inventoryId, $optionComb, Product::CATALOG_TYPE_INVENTORY)) {
                FatUtility::dieWithError($ddObj->getError());
            }
            $refId = $ddObj->getMainTableRecordId();
        }
        
        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            if (true == $this->setupDigitalLink($ddObj, $refId, $inventoryId)) {
                FatUtility::dieJsonSuccess(Message::getHtml());
            }
        } else {
            if (true == $this->setupDigitalFile($ddObj, $refId, $inventoryId)) {
                FatUtility::dieJsonSuccess(Message::getHtml());
            }
        }
        
        FatUtility::dieJsonError(Message::getHtml());
    }

    private function setupDigitalFile($ddObj, $refId, $recordId)
    {
        if (!isset($_FILES['downloadable_file']['tmp_name']) || !is_uploaded_file($_FILES['downloadable_file']['tmp_name'])) {
            Message::addErrorMessage(Labels::getLabel('MSG_Please_select_a_file', $this->adminLangId));
            return false;
        }

        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);

        $mainFileId = $ddObj->saveAttachment(
            $_FILES['downloadable_file']['tmp_name'],
            $_FILES['downloadable_file']['name'],
            $refId,
            0,
            $langId
        );
        if (1 > $mainFileId) {
            Message::addErrorMessage($ddObj->getError());
            return false;
        }

        if (isset($_FILES['preview_file']['tmp_name']) && is_uploaded_file($_FILES['preview_file']['tmp_name'])) {
            $ddObj->saveAttachment(
                $_FILES['preview_file']['tmp_name'],
                $_FILES['preview_file']['name'],
                $refId,
                $mainFileId,
                $langId,
                true
            );
        }

        $attachWithExistingOrders = FatApp::getPostedData('attach_with_existing_orders', FatUtility::VAR_INT, 0);
        
        Message::addErrorMessage(Labels::getLabel('MSG_Uploaded_Successfully', $this->adminLangId));
        if (0 === $attachWithExistingOrders) {
            return true;
        }

        $ddObj->attachFileWithOrderedProducts($mainFileId, $recordId, Product::CATALOG_TYPE_INVENTORY, $langId);

        return true;
    }

    public function setupDigitalPreviewFile()
    {
        $this->objPrivilege->canEditSellerProducts();

        $recId = FatApp::getPostedData('dd_link_id', FatUtility::VAR_INT, 0);
        $subRecId = FatApp::getPostedData('dd_link_ref_id', FatUtility::VAR_INT, 0);
        
        if (1 > $recId || 1 > $subRecId) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }
        
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        if (!isset($_FILES['preview_file']['tmp_name']) || !is_uploaded_file($_FILES['preview_file']['tmp_name'])) {
            Message::addErrorMessage(Labels::getLabel('MSG_Please_select_a_file', $this->adminLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $ddObj = new DigitalDownload();
        if (!$ddObj->saveAttachment(
            $_FILES['preview_file']['tmp_name'],
            $_FILES['preview_file']['name'],
            $recId,
            $subRecId,
            $langId,
            true
        )) {
            Message::addErrorMessage($ddObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_Uploaded_Successfully', $this->adminLangId));
    }

    private function setupDigitalLink($ddObj, $refId, $recordId)
    {
        
        $downloadLink = FatApp::getPostedData('product_downloadable_link', null, '');
        $previewLink = FatApp::getPostedData('product_preview_link', null, '');
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $ddLinkId = FatApp::getPostedData('dd_link_id', FatUtility::VAR_INT, 0);
        $ddRefId = FatApp::getPostedData('dd_link_ref_id', FatUtility::VAR_INT, 0);
        
        if (!$ddObj->saveLink($refId, $langId, $downloadLink, $previewLink, $ddLinkId)) {
            Message::addMessage($ddObj->getError());
            return false;
        }

        if (1 <= $ddLinkId) {
            $totalLinksCount = DigitalDownloadSearch::getTotalLinksCount($ddRefId);
            $totalAttachmentCount = DigitalDownloadSearch::getTotalAttachmentsCount($ddRefId);

            if (1 > $totalLinksCount && 1 > $totalAttachmentCount) {
                $ddObj->deleteReference($ddRefId);
            }
        }
        
        $attachWithExistingOrders = FatApp::getPostedData('attach_with_existing_orders', FatUtility::VAR_INT, 0);
        
        Message::addMessage(Labels::getLabel('LBL_Links_added_successfully', $this->adminLangId));
        if (0 === $attachWithExistingOrders) {
            return true;
        }

        $ddObj->attachLinkWithOrderedProducts($downloadLink, $recordId, Product::CATALOG_TYPE_INVENTORY, $langId);
        
        return true;
    }

    public function deleteDigitalLink()
    {
        $this->objPrivilege->canEditSellerProducts();

        $refId = FatApp::getPostedData('ref_id', FatUtility::VAR_INT, 0);
        $linkId = FatApp::getPostedData('link_id', FatUtility::VAR_INT, 0);

        if (1 > $refId || 1 > $linkId) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $ddObj = new DigitalDownload();
        
        if (!$ddObj->deleteLink($linkId, $refId)) {
            FatUtility::dieJsonError($ddObj->getError());
        }

        $totalLinksCount = DigitalDownloadSearch::getTotalLinksCount($refId);
        $totalAttachmentCount = DigitalDownloadSearch::getTotalAttachmentsCount($refId);
        
        if (1 > $totalLinksCount && 1 > $totalAttachmentCount) {
            $ddObj->deleteReference($refId);
        }
        
        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_Removed_successfully', $this->adminLangId));
    }

    public function deleteDigitalFile()
    {
        $this->objPrivilege->canEditSellerProducts();

        $refId = FatApp::getPostedData('ref_id', FatUtility::VAR_INT, 0);
        $aFileId = FatApp::getPostedData('afile_id', FatUtility::VAR_INT, 0);

        if (1 > $refId || 1 > $aFileId) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $digDownload = new DigitalDownload();
        
        if (!$digDownload->deleteAttachment($aFileId, $refId)) {
            FatUtility::dieJsonError($digDownload->getError());
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_Removed_successfully', $this->adminLangId));
    }

    public function downloadAttachment($aFileId, $recordId, $requestType, $isPreview = 0)
    {
        $this->objPrivilege->canViewSellerProducts();
        
        $aFileId = FatUtility::int($aFileId);
        $recordId = FatUtility::int($recordId);
        $isPreview = FatUtility::int($isPreview);
        $requestType = FatUtility::int($requestType);

        if (1 > $aFileId || 1 > $recordId) {
            FatUtility::dieWithError(Labels::getLabel("LBL_Invalid_Request", $this->adminLangId));
        }
        
        $selProdData = SellerProduct::getAttributesById($recordId, array('selprod_user_id', 'selprod_product_id'));
        
        if (false == $selProdData) {
            FatUtility::dieWithError(Labels::getLabel("MSG_INVALID_ACCESS", $this->adminLangId));
        }
        
        if (false == DigitalDownload::allowedWithInventory($selProdData['selprod_product_id'])) {
            $recordId = $selProdData['selprod_product_id'];
            $requestType = Product::CATALOG_TYPE_PRIMARY;
        }

        $file = DigitalDownloadSearch::getAttachmentDetail($aFileId, $recordId, $requestType, $isPreview);
        if (1 > count($file)) {
            FatUtility::dieWithError(Labels::getLabel("LBL_File_not_found", $this->adminLangId));
        }
        
        if ($file['pddr_record_id'] != $recordId) {
            FatUtility::dieWithError(Labels::getLabel("MSG_INVALID_ACCESS", $this->adminLangId));
        }
        
        if (!file_exists(CONF_UPLOADS_PATH . $file['afile_physical_path'])) {
            FatUtility::dieWithError(Labels::getLabel("LBL_File_not_found", $this->adminLangId));
        }
        
        $fileName = isset($file['afile_physical_path']) ? $file['afile_physical_path'] : '';
        AttachedFile::downloadAttachment($fileName, $file['afile_name']);
    }
}