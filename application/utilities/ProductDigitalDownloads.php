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
        $productId = FatUtility::int($productId);
        $selProdId = FatUtility::int($selProdId);
        
        $ddObj = new DigitalDownload();

        if (0 < $selProdId) {
            $canDo = $ddObj->canDo($selProdId, Product::CATALOG_TYPE_INVENTORY, $this->userParentId, $this->siteLangId, true, true);
            $sellerProductRow = SellerProduct::getAttributesById($selProdId);
            $productId = $sellerProductRow['selprod_product_id'];
        } else {
            $canDo = $ddObj->canDo($productId, Product::CATALOG_TYPE_PRIMARY, 0, $this->siteLangId, true, true);
        }
        

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
        $savedOptions = array_filter($savedOptions);
        
        $fld = $frm->getField('option_comb_id');
        if (1 > count($savedOptions)) {
            $frm->removeField($fld);
        } else {
            $fld->options = $savedOptions;
        }

        $showFldAttachWithExistingOrders = true;

        $fld = $frm->getField('attach_with_existing_orders');

        // $product = Product::getAttributesById($productId, ['product_attachements_with_inventory']);
        $product = $ddObj->getProduct($productId);

        if (!is_array($product) && 1 > count($product)) {
            $showFldAttachWithExistingOrders = false;
            if (1 !== $product['product_attachements_with_inventory']) {
                $frm->removeField($fld);
            }
        }
        
        $this->set('showFldAttachWithExistingOrders', $showFldAttachWithExistingOrders);
        
        $data = [
            'product_id' => $productId,
            'selprod_id' =>  $selProdId,
        ];
        $frm->fill($data);
        $this->set('siteLangId', $this->siteLangId);
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

        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $records = DigitalDownloadSearch::getInventoryLinks($selProdId, $langId);
        } else {
            $records = DigitalDownloadSearch::getInventoryAttachments($selProdId, $langId);
            $records = DigitalDownloadSearch::processAttachmentsWithPreview($records);
        }

        $canDelete = DigitalDownload::canDelete($selProdId, Product::CATALOG_TYPE_INVENTORY, 0, $this->siteLangId, true, true);
        
        $ddObj = new DigitalDownload();

        $canDoDigDownload = $ddObj->canDo($selProdId, Product::CATALOG_TYPE_INVENTORY, $this->userParentId, $this->siteLangId, true, true);

        $this->set('records', $records);
        $this->set('canDelete', $canDelete);
        $this->set('canDoDigDownload', $canDoDigDownload);
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
        switch ($requestType) {
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

                $product = Product::getAttributesById($selProdData['selprod_product_id']);
                
                if (false == $product) {
                    static::returnResponseOrDie();
                }
                
                if (applicationConstants::NO == $product['product_attachements_with_inventory']
                    && $product['product_seller_id'] !== $this->userParentId
                    && applicationConstants::NO == $isPreview
                ) {
                    FatUtility::dieWithError(Labels::getLabel("LBL_Unauthorized_Access", $this->siteLangId));
                }
                
                if (applicationConstants::NO == $product['product_attachements_with_inventory']) {
                    $recordId = $selProdData['selprod_product_id'];
                    $requestType = Product::CATALOG_TYPE_PRIMARY;
                }
                break;
            default:
                FatUtility::dieWithError(Labels::getLabel("LBL_Invalid_Request", $this->siteLangId));
                break;
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
            Message::addErrorMessage(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'products'));
        }
    
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

    public function setupAdditionalOpAttachment()
    {
        $opId = FatApp::getPostedData('op_id', FatUtility::VAR_INT, 0);
        if (1 > $opId) {
            FatUtility::dieJsonError(Labels::getLabel("MSG_INVALID_REQUEST", $this->siteLangId) . __LINE__);
        }

        $opSrch = OrderProduct::getSearchObject();

        $opSrch->addCondition('op_id', '=', $opId);
        $opSrch->addCondition('op_product_type', '=', Product::PRODUCT_TYPE_DIGITAL);

        $opSrch->addMultipleFields(['op_status_id', 'op_selprod_user_id']);

        $opSrch->doNotCalculateRecords();
        $opSrch->setPageSize(1);

        $rs = $opSrch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!is_array($row)) {
            FatUtility::dieJsonError(Labels::getLabel("MSG_INVALID_REQUEST", $this->siteLangId));
        }

        if ($this->userParentId != $row['op_selprod_user_id']) {
            FatUtility::dieJsonError(Labels::getLabel("MSG_INVALID_REQUEST", $this->siteLangId));
        }

        if (!DigitalOrderProduct::canAttachMoreFiles($row['op_status_id'])) {
            FatUtility::dieJsonError(Labels::getLabel("MSG_INVALID_REQUEST", $this->siteLangId));
        }
        
        if (!isset($_FILES['additional_attachment']['tmp_name'])
            || !is_uploaded_file($_FILES['additional_attachment']['tmp_name'])
        ) {
            Message::addErrorMessage(Labels::getLabel('MSG_Please_select_a_file', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
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
}