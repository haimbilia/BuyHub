<?php

trait ProductDigitalDownloads
{
    public function sellerProductDownloadFrm($productId, $selProdId = 0)
    {
        $this->userPrivilege->canEditProducts(UserAuthentication::getLoggedUserId());

        if (!UserPrivilege::isUserHasValidSubsription($this->userParentId)) {
            Message::addErrorMessage(Labels::getLabel("MSG_Please_buy_subscription", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'Packages'));
        }
        
        $canDo = DigitalDownload::canDo($selProdId, Product::CATALOG_TYPE_INVENTORY, 0, $this->siteLangId, false, true);

        $productId = FatUtility::int($productId);
        $selProdId = FatUtility::int($selProdId);

        $frm = DigitalDownload::getDownloadForm($this->siteLangId);

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
        $this->set('canDo', $canDo);
        $this->set('savedOptions', $savedOptions);
        $this->set('downloadFrm', $frm);
        $this->set('product_id', $productId);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function getInventoryDigitalDownloads()
    {
        $this->userPrivilege->canViewProducts();
        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $selProdId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $linkId = FatApp::getPostedData('link_id', FatUtility::VAR_INT, 0);
        $type = FatApp::getPostedData('download_type', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        /* $prodRefType = Product::CATALOG_TYPE_INVENTORY; */
        
        /* $optionComb = FatApp::getPostedData('option_comb', FatUtility::VAR_INT, 0); */
        
        /* $selProdData = SellerProduct::getAttributesById($selProdId, array('selprod_code'));
        
        $selProdOption = explode('_', $selProdData['selprod_code']);
        array_shift($selProdOption);
        if (0 < count($selProdOption)) {
            $optionComb = implode('_', $selProdOption);
        } else {
            $optionComb = '0';
        }
        
        
        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $records = DigitalDownloadSearch::getLinks($selProdId, $prodRefType, $optionComb, $langId);
        } else {
            $records = DigitalDownloadSearch::getAttachments($selProdId, $prodRefType, $optionComb, $langId);
        } */
        
        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $records = DigitalDownloadSearch::getInventoryLinks($selProdId, $langId);
        } else {
            $records = DigitalDownloadSearch::getInventoryAttachments($selProdId, $langId);
        }

        $canDelete = DigitalDownload::canDelete($selProdId, Product::CATALOG_TYPE_INVENTORY, 0, $this->siteLangId, true, true);

        $this->set('records', $records);
        $this->set('canDelete', $canDelete);
        $this->set('recordId', $selProdId);
        $this->set('downloadrefType', Product::CATALOG_TYPE_INVENTORY);

        $languages = Language::getAllNames();
        $languages = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $languages;
        $this->set('languages', $languages);
        $this->set('selProdId', $selProdId);

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
        switch($requestType) {
            case Product::CATALOG_TYPE_PRIMARY:
                $product = Product::getAttributesById($recordId, array('product_seller_id'));
                if (false == $product) {
                    FatUtility::dieWithError(Labels::getLabel("LBL_Invalid_Request", $this->siteLangId));
                }
                
                if ($product['product_seller_id'] !== $this->userParentId) {
                    FatUtility::dieWithError(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
                }
                break;
            case Product::CATALOG_TYPE_REQUEST:
                $reqData = ProductRequest::getAttributesById($recordId, array('preq_user_id', 'preq_status', 'preq_deleted'));
                if (false == $reqData
                    || ProductRequest::STATUS_APPROVED == $reqData['preq_status']
                    || applicationConstants::YES == $reqData['preq_deleted']
                ) {
                    FatUtility::dieWithError(Labels::getLabel("LBL_Invalid_Request", $this->siteLangId));
                }

                if ($reqData['preq_user_id'] !== $this->userParentId) {
                    FatUtility::dieWithError(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
                }
                break;
            case Product::CATALOG_TYPE_INVENTORY:
                $selProdData = SellerProduct::getAttributesById($recordId, array('selprod_user_id', 'selprod_product_id'));
                if (false == $selProdData) {
                    FatUtility::dieWithError(Labels::getLabel("LBL_Invalid_Request", $this->siteLangId));
                }
                
                if ($selProdData['selprod_user_id'] !== $this->userParentId) {
                    FatUtility::dieWithError(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
                }

                if (false == DigitalDownload::allowedWithInventory($selProdData['selprod_product_id'])) {
                    $recordId = $selProdData['selprod_product_id'];
                    $requestType = Product::CATALOG_TYPE_PRIMARY;
                }
                break;
            default:
                FatUtility::dieWithError(Labels::getLabel("LBL_Invalid_Request", $this->siteLangId));
                break;
        }
        // CommonHelper::printArray([['file' => __FILE__, 'line' => __LINE__], $aFileId, $recordId, $requestType, $isPreview], 1);
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





    public function uploadDigitalFile_not_in_use()
    {
        if (!$this->userPrivilege->canEditProducts(UserAuthentication::getLoggedUserId(), true)) {
            Message::addErrorMessage(Labels::getLabel('LBL_Unauthorized_Access!', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }
        $userId = $this->userParentId;
        $post = FatApp::getPostedData();
        $selprod_id = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('lang_id' . $selprod_id, FatUtility::VAR_INT, 0);
        /* $download_type = FatApp::getPostedData('download_type'.$selprod_id, FatUtility::VAR_INT, 0); */
        if (!$selprod_id) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $selProdData = SellerProduct::getAttributesById($selprod_id, array('selprod_user_id'));
        if ($selProdData == false || ($selProdData && $selProdData['selprod_user_id'] !== $userId)) {
            Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        if (isset($_FILES['downloadable_file']) && is_uploaded_file($_FILES['downloadable_file']['tmp_name'])) {
            $fileHandlerObj = new AttachedFile();
            if (!$res = $fileHandlerObj->saveAttachment(
                $_FILES['downloadable_file']['tmp_name'],
                AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD,
                $selprod_id,
                0,
                $_FILES['downloadable_file']['name'],
                -1,
                $unique_record = false,
                $lang_id
            )) {
                Message::addErrorMessage($fileHandlerObj->getError());
                FatUtility::dieJsonError(Message::getHtml());
            }
            Message::addMessage(Labels::getLabel('MSG_File_Uploaded_Successfully.', $this->siteLangId));
            FatUtility::dieJsonSuccess(Message::getHtml());
        }

        if (!empty($post['selprod_downloadable_link' . $selprod_id])) {
            $data_to_be_save = array();
            $data_to_be_save['selprod_downloadable_link'] = $post['selprod_downloadable_link' . $selprod_id];
            $sellerProdObj = new SellerProduct($selprod_id);
            $sellerProdObj->assignValues($data_to_be_save);

            if (!$sellerProdObj->save()) {
                Message::addErrorMessage(Labels::getLabel($sellerProdObj->getError(), $this->siteLangId));
                FatUtility::dieJsonError(Message::getHtml());
            }
            Message::addMessage(Labels::getLabel('MSG_Setup_Successful.', $this->siteLangId));
            FatUtility::dieJsonSuccess(Message::getHtml());
        }
    }

    public function deleteDigitalFile_not_in_use($selprodId, $afileId = 0)
    {
        $this->userPrivilege->canEditProducts(UserAuthentication::getLoggedUserId());
        $selprodId = FatUtility::int($selprodId);
        $afileId = FatUtility::int($afileId);

        if (!$selprodId || !$afileId) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        /* Validate product belongs to current logged seller[ */
        $productRow = SellerProduct::getAttributesById($selprodId, array('selprod_user_id'));
        if ($productRow['selprod_user_id'] != $this->userParentId) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }
        /* ] */

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD, $selprodId, $afileId)) {
            Message::addErrorMessage($fileHandlerObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        Message::addMessage(Labels::getLabel('LBL_Removed_successfully.', $this->siteLangId));
        FatUtility::dieJsonSuccess(Message::getHtml());
    }

    public function downloadDigitalFile_not_in_use($aFileId, $recordId = 0, $fileType = AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD)
    {
        $aFileId = FatUtility::int($aFileId);
        $recordId = FatUtility::int($recordId);
        $fileType = FatUtility::int($fileType);
        $userId = $this->userParentId;

        if (1 > $aFileId || 1 > $recordId) {
            Message::addErrorMessage(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'products'));
        }

        if ($fileType == AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD) {
            $selProdData = SellerProduct::getAttributesById($recordId, array('selprod_user_id'));
            if ($selProdData == false || ($selProdData && $selProdData['selprod_user_id'] !== $userId)) {
                Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
                FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'viewOrder', array($recordId)));
            }
        } else {
            $srch = new OrderProductSearch(0, true);
            $srch->addMultipleFields(array('op_id', 'op_selprod_user_id'));
            $srch->addCondition('op_id', '=', $recordId);
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $row = FatApp::getDb()->fetch($srch->getResultSet());
            if ($row == false || ($row && $row['op_selprod_user_id'] !== $userId)) {
                Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
                FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'viewOrder', array($recordId)));
            }
        }

        $file_row = AttachedFile::getAttributesById($aFileId);
        if ($file_row == false || $file_row['afile_record_id'] != $recordId || $file_row['afile_type'] != $fileType) {
            Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'viewOrder', array($recordId)));
        }

        if (!file_exists(CONF_UPLOADS_PATH . $file_row['afile_physical_path'])) {
            Message::addErrorMessage(Labels::getLabel('LBL_File_not_found', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'viewOrder', array($recordId)));
        }

        $fileName = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        AttachedFile::downloadAttachment($fileName, $file_row['afile_name']);
    }
}