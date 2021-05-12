<?php

trait InventoryDigitalDownloads
{
    public function sellerProductDownloadFrm($selProdId)
    {
        $this->objPrivilege->canEditSellerProducts();

        $selProdId = FatUtility::int($selProdId);

        DigitalDownload::canDo($selProdId, Product::CATALOG_TYPE_INVENTORY, 0, $this->adminLangId, false);

        $sellerProductRow = SellerProduct::getAttributesById($selProdId);

        $productId = $sellerProductRow['selprod_product_id'];

        $productRow = Product::getAttributesById($productId, array('product_type'));

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
        
        $fld = $frm->getField('option_comb_id');
        if (1 > count($savedOptions)) {
            $frm->removeField($fld);
        } else {
            $fld->options = $savedOptions;
        }

        $data = [
            'product_id' => $productId,
            'selprod_id' =>  $selProdId,
        ];
        $frm->fill($data);
        $this->set('savedOptions', $savedOptions);
        $this->set('downloadFrm', $frm);
        $this->set('product_id', $productId);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function getInventoryDigitalDownloads()
    {
        $this->objPrivilege->canEditSellerProducts();
        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $selProdId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $linkId = FatApp::getPostedData('link_id', FatUtility::VAR_INT, 0);
        $type = FatApp::getPostedData('download_type', FatUtility::VAR_INT, 0);

        $prodRefType = Product::CATALOG_TYPE_INVENTORY;

        
        $optionComb = FatApp::getPostedData('option_comb', FatUtility::VAR_INT, 0);
        
        $selProdData = SellerProduct::getAttributesById($optionComb, array('selprod_code'));
        
        $selProdOption = explode('_', $selProdData['selprod_code']);
        array_shift($selProdOption);
        if (0 < count($selProdOption)) {
            $optionComb = implode('_', $selProdOption);
        } else {
            $optionComb = '0';
        }
        
        $langId = FatApp::getPostedData('langId', null, 0);
        
        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $records = DigitalDownloadSearch::getLinks($selProdId, $prodRefType, $optionComb, $langId);
        } else {
            $records = DigitalDownloadSearch::getAttachments($selProdId, $prodRefType, $optionComb, $langId);
        }
        
        $this->set('records', $records);
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

        $prodId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $inventoryId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        
        if (1 > $prodId && 1 > $inventoryId) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId) . __LINE__);
        }
        
        $requstedProd = Product::CATALOG_TYPE_INVENTORY;
        
        DigitalDownload::canDo($inventoryId, $requstedProd, 0, $this->adminLangId, false);
        
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
        
        $refId = $ddObj->getReferenceId($inventoryId, $optionComb, $requstedProd);
        
        if (1 > $refId) {
            if (!$ddObj->saveReference($inventoryId, $optionComb, $requstedProd)) {
                FatUtility::dieWithError($ddObj->getError());
            }
            $refId = $ddObj->getMainTableRecordId();
        }
        
        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $this->setupDigitalLink($ddObj, $refId);
        } else {
            $this->setupDigitalFile($ddObj, $refId);
        }

        FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
    }

    private function setupDigitalFile($ddObj, $refId)
    {
        if (!isset($_FILES['downloadable_file']['tmp_name']) || !is_uploaded_file($_FILES['downloadable_file']['tmp_name'])) {
            Message::addErrorMessage(Labels::getLabel('MSG_Please_select_a_file', $this->adminLangId));
            FatUtility::dieJsonError(Message::getHtml());
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
            FatUtility::dieJsonError(Message::getHtml());
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

        FatUtility::dieJsonSuccess('Uploaded Successfully!!!');
    }

    public function setupDigitalPreviewFile()
    {
        $this->objPrivilege->canEditSellerProducts();

        $recId = FatApp::getPostedData('dd_link_id', FatUtility::VAR_INT, 0);
        $subRecId = FatApp::getPostedData('dd_link_ref_id', FatUtility::VAR_INT, 0);
        $requstedProd = FatApp::getPostedData('prod_ref_type', FatUtility::VAR_INT, 0);
        
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
        FatUtility::dieJsonSuccess('Uploaded Successfully!!!');
    }

    private function setupDigitalLink($ddObj, $refId)
    {
        $downloadLink = FatApp::getPostedData('product_downloadable_link', null, '');
        $previewLink = FatApp::getPostedData('product_preview_link', null, '');
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $ddLinkId = FatApp::getPostedData('dd_link_id', FatUtility::VAR_INT, 0);
        $ddRefId = FatApp::getPostedData('dd_link_ref_id', FatUtility::VAR_INT, 0);
        
        if (!$ddObj->saveLink($refId, $langId, $downloadLink, $previewLink, $ddLinkId)) {
            FatUtility::dieJsonError($digitalDownload->getError());
        }

        if (1 <= $ddLinkId) {
            $totalLinksCount = DigitalDownloadSearch::getTotalLinksCount($ddRefId);
            $totalAttachmentCount = DigitalDownloadSearch::getTotalAttachmentsCount($ddRefId);

            if (1 > $totalLinksCount && 1 > $totalAttachmentCount) {
                $ddObj->deleteReference($ddRefId);
            }
        }
        
        if (1 <= $ddLinkId) {
            $ret['msg'] = Labels::getLabel('LBL_Links_added_successfully', $this->adminLangId);
        } else {
            $ret['msg'] = Labels::getLabel('LBL_Links_updated_successfully', $this->adminLangId);
        }
        $ret['btn_label'] = Labels::getLabel('LBL_Add', $this->adminLangId);

        FatUtility::dieJsonSuccess($ret);
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
}