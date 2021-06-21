<?php

class DigitalDownload extends MyAppModel
{
    public const DB_TBL = 'tbl_product_digital_data_relation';
    public const DB_TBL_PREFIX = 'pddr_';
    
    public const DB_TBL_LINKS = 'tbl_product_digital_links';
    public const DB_TBL_LINKS_PREFIX = 'pdl_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX, $id);
    }

    public function getReferenceId($recordId, $option, $refType = 0)
    {
        $recordId = FatUtility::int($recordId);
        $refType = FatUtility::int($refType);

        $srch = new DigitalDownloadSearch();
        $srch->addCondition(static::DB_TBL_PREFIX . 'record_id', '=', $recordId);
        $srch->addCondition(static::DB_TBL_PREFIX . 'options_code', '=', $option);
        $srch->addCondition(static::DB_TBL_PREFIX . 'type', '=', $refType);

        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return 0;
        }

        return $row['pddr_id'];
    }
    
    public function saveReference($recordId, $optionsCode, $refType = 0)
    {
        $recordId = FatUtility::int($recordId);

        if ($recordId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', CommonHelper::getLangId());
            return false;
        }

        $refType = FatUtility::int($refType);

        $dataToSave = array(
            static::DB_TBL_PREFIX . 'record_id' => $recordId,
            static::DB_TBL_PREFIX . 'options_code' => $optionsCode,
            static::DB_TBL_PREFIX . 'type' => $refType,
        );

        $this->assignValues($dataToSave);
        if (!$this->save()) {
            return false;
        }
        return true;
    }

    public function saveLink($refId, $langId, $downloadLink, $previewLink = '', $ddLinkid = 0)
    {
        if ($refId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', CommonHelper::getLangId());
            return false;
        }

        $dataToSave = array(
            static::DB_TBL_LINKS_PREFIX . 'record_id' => $refId,
            static::DB_TBL_LINKS_PREFIX . 'lang_id' => $langId,
            static::DB_TBL_LINKS_PREFIX . 'download_link' => $downloadLink,
            static::DB_TBL_LINKS_PREFIX . 'preview_link' => $previewLink,
        );

        if (1 > $ddLinkid) {
            if (!FatApp::getDb()->insertFromArray(static::DB_TBL_LINKS, $dataToSave)) {
                $this->error = FatApp::getDb()->getError();
                return false;
            }
        } else {
            $whr = [
                'smt' => static::DB_TBL_LINKS_PREFIX . 'id = ?',
                'vals' => [$ddLinkid],
            ];
            if (!FatApp::getDb()->updateFromArray(static::DB_TBL_LINKS, $dataToSave, $whr)) {
                $this->error = FatApp::getDb()->getError();
                return false;
            }
        }
        return true;
    }

    public function deleteLink($linkid, $refId)
    {
        $whr = [
            'smt' => static::DB_TBL_LINKS_PREFIX . 'id = ? AND ' . static::DB_TBL_LINKS_PREFIX . 'record_id = ?',
            'vals' => [$linkid, $refId],
        ];

        FatApp::getDb()->deleteRecords(static::DB_TBL_LINKS, $whr);

        if (1 > FatApp::getDb()->rowsAffected()) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }

        return true;
    }

    public function deleteAttachment($aFileId, $refRecordId, $isPreview = 0, $delFullRow = 0)
    {
        $aFileObj = new AttachedFile();
        
        $fileType = AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD;
        if (1 == $isPreview) {
            $fileType = AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD_PREVIEW;
        }
        
        if (false == $aFileObj->deleteFile($fileType, $refRecordId, $aFileId)) {
            $this->error = $aFileObj->getError();
            return false;
        }

        if (1 == $delFullRow) {
            $aFileObj->deleteFile(
                AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD_PREVIEW,
                $refRecordId,
                0,
                $aFileId
            );
        }

        return true;
    }

    public function deleteReference($refId)
    {
        $whr = [
            'smt' => static::DB_TBL_PREFIX . 'id = ?',
            'vals' => [$refId],
        ];

        FatApp::getDb()->deleteRecords(static::DB_TBL, $whr);

        if (1 > FatApp::getDb()->rowsAffected()) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }

        return true;
    }

    public function saveAttachment($file, $fileName, $recId, $subRecId, $langId, $isPreview = false)
    {
        $fileType = AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD;
        if (true === $isPreview) {
            $fileType = AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD_PREVIEW;
        }

        $fileHandlerObj = new AttachedFile();
        if ($res = $fileHandlerObj->saveAttachment(
            $file,
            $fileType,
            $recId,
            $subRecId,
            $fileName,
            -1,
            false,
            $langId
        )) {
            return $fileHandlerObj->getMainTableRecordId();
        }
        $this->error = $fileHandlerObj->getError();
        return 0;
    }

    public static function getDownloadForm($langId)
    {
        $frm = new Form('frmDownload');
        $bannerTypeArr = applicationConstants::bannerTypeArr($langId);
        $digitalDownloadTypeArr = applicationConstants::digitalDownloadTypeArr($langId);

        $frm->addSelectBox(Labels::getLabel('LBL_Option', $langId), 'option_comb_id', [], '', array('class' => 'option-comb-id-js'), '')->requirements()->setRequired();
        
        $frm->addSelectBox(Labels::getLabel('LBL_Digital_Download_Type', $langId), 'download_type', $digitalDownloadTypeArr, '', array('class' => 'download-type'), '')->requirements()->setRequired();

        $frm->addSelectBox(Labels::getLabel('LBL_Attach_with_existing_orders', $langId), 'attach_with_existing_orders', applicationConstants::getYesNoArr($langId), applicationConstants::NO, array('id' => 'attach_with_existing_orders'), '');
        
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Downloadable_Link', $langId), 'product_downloadable_link');
        /* $fld->requirements()->setRequired(); */

        $frm->addTextBox(Labels::getLabel('LBL_Preview_Link', $langId), 'product_preview_link');
        
        $frm->addButton('', 'attachment_link_btn', Labels::getLabel('LBL_Add', $langId));

        $frm->addSelectBox(Labels::getLabel('Lbl_Language', $langId), 'lang_id', $bannerTypeArr, '', array('class' => 'file-language-js'), '')->requirements()->setRequired();

        $fldImg = $frm->addFileUpload(Labels::getLabel('LBL_Upload_File', $langId), 'downloadable_file', array('id' => 'downloadable_file'));
        
        $frm->addFileUpload(Labels::getLabel('LBL_Upload_Preview', $langId), 'preview_file', array('id' => 'preview_file'));

        $frm->addButton('', 'attachement_upload_btn', Labels::getLabel('LBL_Upload', $langId));
        $frm->addButton('', 'reset', Labels::getLabel('LBL_Reset', $langId));
        
        $frm->addHiddenField('', 'product_id');
        $frm->addHiddenField('', 'selprod_id');
        $frm->addHiddenField('', 'preq_id');
        $frm->addHiddenField('', 'dd_link_id');
        $frm->addHiddenField('', 'is_preview', 0);
        $frm->addHiddenField('', 'dd_link_ref_id');
        $frm->addHiddenField('', 'ref_file_id', 0);
        return $frm;
    }

    public static function getProductOptionCombinations($recordId, $langId, $requestedProd = false, $addDefOption = true, $optSeparator = '_')
    {
        $optionCombinations = [];

        if (true == $requestedProd) {
            $productOptions = ProductRequest::getProductReqOptions($recordId, $langId, true);
        } else {
            $productOptions = Product::getProductOptions($recordId, $langId, true);
        }

        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', $optSeparator);

        if (true == $addDefOption) {
            $optionCombinations = array('0' => Labels::getLabel('LBL_All', $langId)) + $optionCombinations;
        }
        return $optionCombinations;
    }

    public static function canView($recordId, $recordType = 0, $sellerUserId = 0, $langId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $sellerUserId = FatUtility::int($sellerUserId);
        $langId = FatUtility::int($langId);
        
        if (1 > $sellerUserId) {
            return static::returnResponseOrDie();
        }
        
        if (Product::CATALOG_TYPE_REQUEST == $recordType) {
            /* Marketplace requested Product - by seller*/
            $productReqRow = ProductRequest::getAttributesById($recordId);
            
            if (false === $productReqRow) {
                return static::returnResponseOrDie();
            }
            
            $product = json_decode($productReqRow['preq_content'], true);

            if (!$product) {
                return static::returnResponseOrDie();
            }
        } else {
            $product = Product::getAttributesById($recordId, ['product_seller_id', 'product_type']);
        
            if (false == $product) {
                return static::returnResponseOrDie();
            }
        }

        if (Product::PRODUCT_TYPE_DIGITAL != $product['product_type']) {
            return static::returnResponseOrDie(false, false, Labels::getLabel('LBL_Attachments_or_links_allowed_only_with_digital_products', $langId));
        }
        
        /* To check whether product belogs to logged seller? */
        if ($product['product_seller_id'] == $sellerUserId) {
            return true;
        }
        return static::returnResponseOrDie();
    }

    /**
     * Name: canDo
     * Description: Function to check whether a user can add/upload with a record
     * Params:
     * @recordId - Id of record for which add/upload permission is going to be checked
     * @recordType - Type of record Id (Inventory Id (Seller Product Id), Product request Id, Product Id)
     * @sellerUserId - user Id for which record is belongs to, It is required in case to check add/upload request from a seller. In case delete request from admin it will be zero
     * @langId
     * @validateAllowedWithInventory - To check whether add/upload allowed with Inventory/Product
     * @returnResult - return response or die
     */

    // public static function canDo($recordId, $recordType = 0, $sellerUserId = 0, $langId = 0, $returnResult = false)
    public static function canDo($recordId, $recordType = 0, $sellerUserId = 0, $langId = 0, $validateAllowedWithInventory = true, $returnResult = false)
    {
        $recordId = FatUtility::int($recordId);
        $sellerUserId = FatUtility::int($sellerUserId);
        $langId = FatUtility::int($langId);

        if (1 > $langId) {
            $langId = CommonHelper::getLangId();
        }
        
        if (Product::CATALOG_TYPE_REQUEST == $recordType) {
            /* Marketplace requested Product - by seller*/
            $productReqRow = ProductRequest::getAttributesById($recordId);
            
            if (false === $productReqRow) {
                return static::returnResponseOrDie($returnResult);
            }
            
            if ($productReqRow['preq_status'] == ProductRequest::STATUS_APPROVED || $productReqRow['preq_deleted'] == applicationConstants::YES) {
                return static::returnResponseOrDie($returnResult, false);
            }

            $product = json_decode($productReqRow['preq_content'], true);

            if (!$product) {
                return static::returnResponseOrDie($returnResult);
            }
            if (!array_key_exists('product_attachements_with_inventory', $product)) {
                $product['product_attachements_with_inventory'] = applicationConstants::YES;
            }
        } else {
            if (Product::CATALOG_TYPE_INVENTORY == $recordType) {
                /* Seller Inventroy*/
                $sellerProduct = SellerProduct::getAttributesById($recordId, ['selprod_user_id', 'selprod_product_id'], false);
                if (false == $sellerProduct) {
                    return static::returnResponseOrDie($returnResult);
                }
                /* $inventoryId = $recordId; Can be used id required further. As of now no need*/
                $recordId = $sellerProduct['selprod_product_id'];
            }

            $product = Product::getAttributesById($recordId, ['product_seller_id', 'product_type', 'product_attachements_with_inventory']);
        
            if (false == $product) {
                return static::returnResponseOrDie($returnResult);
            }
        }

        if (Product::PRODUCT_TYPE_DIGITAL != $product['product_type']) {
            return static::returnResponseOrDie($returnResult, false, Labels::getLabel('LBL_Attachments_or_links_allowed_only_with_digital_products', $langId));
        }

        /* To check whether product belogs to logged seller? */
        if (0 < $sellerUserId) {
            if (Product::CATALOG_TYPE_INVENTORY == $recordType) {
                /* Seller Inventory */
                $recordOwnerId = $sellerProduct['selprod_user_id'];
            } else { /* Catalog product */
                $recordOwnerId = $product['product_seller_id'];
            }
            if ($recordOwnerId != $sellerUserId) {
                return static::returnResponseOrDie($returnResult);
            }
        }
        
        if (true == $validateAllowedWithInventory) {
            if (applicationConstants::YES == $product['product_attachements_with_inventory']) {
                return static::returnResponseOrDie($returnResult, true, Labels::getLabel('LBL_Attachments_or_links_allowed_with_inventory', $langId));
            } else {
                return static::returnResponseOrDie($returnResult, false, Labels::getLabel('LBL_Attachments_or_links_Not_allowed_with_inventory', $langId));
            }
        }
        
        
        if (applicationConstants::YES == $product['product_attachements_with_inventory']) {
            return static::returnResponseOrDie($returnResult, false, Labels::getLabel('LBL_Attachments_or_links_allowed_with_inventory', $langId));
        } else {
            return static::returnResponseOrDie($returnResult, true, Labels::getLabel('LBL_Attachments_or_links_allowed_with_Product', $langId));
        }
    }

    /**
     * Name: canDelete
     * Description: Function to check whether a valid delete request
     * Params:
     * @recordId - Id of record for which delete permission is going to be checked
     * @recordType - Type of record Id (Inventory Id (Seller Product Id), Product request Id, Product Id)
     * @sellerUserId - user Id for which record is belongs to, It is required in case to check delete request from a seller. In case delete request from admin it will be zero
     * @langId
     * @returnResult - return response or die
     */

    public static function canDelete($recordId, $recordType = 0, $sellerUserId = 0, $langId = 0, $validateAllowedWithInventory = true, $returnResult = false)
    {
        $recordId = FatUtility::int($recordId);
        $sellerUserId = FatUtility::int($sellerUserId);
        $langId = FatUtility::int($langId);

        if (1 > $langId) {
            $langId = CommonHelper::getLangId();
        }

        /* TODO: Need to confirm to add checks that product has been purchased? */

        switch ($recordType) {
            case Product::CATALOG_TYPE_INVENTORY:
                /* Seller Inventroy*/
                $sellerProduct = SellerProduct::getAttributesById($recordId, ['selprod_user_id', 'selprod_product_id'], false);
                if (false == $sellerProduct) {
                    return static::returnResponseOrDie($returnResult);
                }
                if (true == $validateAllowedWithInventory) {
                    $product = Product::getAttributesById($sellerProduct['selprod_product_id'], ['product_attachements_with_inventory']);
                    
                    if (false == $product) {
                        return static::returnResponseOrDie($returnResult);
                    }
                }
                
                $recordOwnerId = $sellerProduct['selprod_user_id'];
                break;
            case Product::CATALOG_TYPE_REQUEST:
                /* Marketplace requested Product - by seller*/
                $productReqRow = ProductRequest::getAttributesById($recordId);
                
                if (false === $productReqRow) {
                    return static::returnResponseOrDie($returnResult);
                }
                
                if ($productReqRow['preq_status'] == ProductRequest::STATUS_APPROVED || $productReqRow['preq_deleted'] == applicationConstants::YES) {
                    return static::returnResponseOrDie($returnResult);
                }

                $product = json_decode($productReqRow['preq_content'], true);

                if (!$product) {
                    return static::returnResponseOrDie($returnResult);
                }
                $recordOwnerId = $product['product_seller_id'];
                break;
            case Product::CATALOG_TYPE_PRIMARY:
                $product = Product::getAttributesById($recordId, ['product_seller_id', 'product_type', 'product_attachements_with_inventory']);
        
                if (false == $product) {
                    return static::returnResponseOrDie($returnResult);
                }
                $recordOwnerId = $product['product_seller_id'];
                break;
            default:
                return static::returnResponseOrDie(false);
                break;
        }
        
        /* To check whether product belogs to logged seller? */
        if (0 < $sellerUserId) {
            if ($recordOwnerId != $sellerUserId) {
                return static::returnResponseOrDie($returnResult);
            }
        }
        
        if (true == $validateAllowedWithInventory) {
            if (applicationConstants::YES == $product['product_attachements_with_inventory']) {
                return static::returnResponseOrDie($returnResult, true, Labels::getLabel('LBL_Attachments_or_links_allowed_with_inventory', $langId));
            } else {
                return static::returnResponseOrDie($returnResult, false, Labels::getLabel('LBL_Attachments_or_links_Not_allowed_with_inventory', $langId));
            }
        }

        if (applicationConstants::YES == $product['product_attachements_with_inventory']) {
            return static::returnResponseOrDie($returnResult, false, Labels::getLabel('LBL_Attachments_or_links_allowed_with_inventory', $langId));
        } else {
            return static::returnResponseOrDie($returnResult, true, Labels::getLabel('LBL_Attachments_or_links_allowed_with_Product', $langId));
        }
    }

    public static function returnResponseOrDie($returnResult = false, $response = false, $message = '')
    {
        if (true == $returnResult) {
            return $response;
        }

        if ($message == '') {
            $message = Labels::getLabel('MSG_INVALID_REQUEST', CommonHelper::getLangId()) . __LINE__;
        }
        FatUtility::dieJsonError($message);
    }

    public static function allowedWithInventory($productId)
    {
        $productId = FatUtility::int($productId);
        $product = Product::getAttributesById($productId);
        
        if (false == $product) {
            static::returnResponseOrDie();
        }

        if (1 == $product['product_attachements_with_inventory']) {
            return true;
        }
        
        return false;
    }

    public static function getProductPreviews($productId)
    {
        $productId = FatUtility::int($productId);
        $product = Product::getAttributesById($productId);
        
        if (false == $product) {
            static::returnResponseOrDie();
        }

        if (1 == $product['product_attachements_with_inventory']) {
            return true;
        }
        
        return false;
    }

    public function attachFileWithOrderedProducts($uploadedFileId, $recordId, $requestType, $langId, $option)
    {
        if (!in_array($requestType, [Product::CATALOG_TYPE_INVENTORY, Product::CATALOG_TYPE_PRIMARY])) {
            return;
        }
        
        $rows = $this->getOrderedProducts($recordId, $requestType, $option);

        
        if (1 > count($rows)) {
            return true;
        }
        $mainFileRow = AttachedFile::getAttributesById($uploadedFileId);
        if (false == $mainFileRow) {
            return true;
        }
        
        $afileObj = new AttachedFile();
        $fileData = [
            'afile_type' => AttachedFile::FILETYPE_ORDER_PRODUCT_DIGITAL_DOWNLOAD,
            'afile_record_subid' => 0,
            'afile_physical_path' => $mainFileRow['afile_physical_path'],
            'afile_name' => $mainFileRow['afile_name'],
            'afile_lang_id' => $langId
        ];
        foreach ($rows as $key => $op) {
            /* don't attach new files only with not expired orders [*/

            $dateAvailable = '';
            if ($op['op_selprod_download_validity_in_days'] != '-1') {
                $dateAvailable = date('Y-m-d', strtotime($op['order_date_added'] . ' + ' . $op['op_selprod_download_validity_in_days'] . ' days'));
            }
            
            if ($dateAvailable != '' && $dateAvailable < date('Y-m-d')) {
                continue;
            }
            /* ] */
            $fileData['afile_record_id'] = $op['op_id'];
            $afileObj->setMainTableRecordId(0);
            $afileObj->assignValues($fileData);
            $afileObj->save();
        }
        return true;
    }

    public function attachLinkWithOrderedProducts($downloadLink, $recordId, $requestType, $langId, $option)
    {
        if (!in_array($requestType, [Product::CATALOG_TYPE_INVENTORY, Product::CATALOG_TYPE_PRIMARY])
            || '' == $downloadLink
        ) {
            return;
        }

        $rows = $this->getOrderedProducts($recordId, $requestType, $option);

        if (1 > count($rows)) {
            return true;
        }

        $linkData['opddl_downloadable_link'] = $downloadLink;
        foreach ($rows as $key => $op) {
            /* don't attach new files only with not expired orders [*/

            $dateAvailable = '';
            if ($op['op_selprod_download_validity_in_days'] != '-1') {
                $dateAvailable = date('Y-m-d', strtotime($op['order_date_added'] . ' + ' . $op['op_selprod_download_validity_in_days'] . ' days'));
            }
            
            if ($dateAvailable != '' && $dateAvailable < date('Y-m-d')) {
                continue;
            }
            /* ] */

            $linkData['opddl_op_id'] = $op['op_id'];
            FatApp::getDb()->insertFromArray(OrderProductDigitalLinks::DB_TBL, $linkData);
        }
        return true;
    }

    public function getOrderedProducts($recordId, $requestType, $option)
    {
        if (!in_array($requestType, [Product::CATALOG_TYPE_INVENTORY, Product::CATALOG_TYPE_PRIMARY])) {
            return [];
        }
        $opSrchObj = new OrderProductSearch(0, true);
        
        if (Product::CATALOG_TYPE_INVENTORY == $requestType) {
            $opSrchObj->addCondition('op.op_selprod_id', '=', $recordId);
        } else {
            $opSrchObj->joinSellerProducts();
            $opSrchObj->addCondition('sp.selprod_product_id', '=', $recordId);

            if (0 != $option) {
                $opSrchObj->addCondition('sp.selprod_code', '=', $recordId . '_' .  $option);
            }
        }

        $opSrchObj->addMultipleFields([
            'op_id',
            'op_order_id',
            'order_date_added',
            'op_selprod_download_validity_in_days'
        ]);
        $opSrchObj->addDigitalDownloadCondition();
        $opSrchObj->doNotCalculateRecords();
        
        return FatApp::getDb()->fetchAll($opSrchObj->getResultSet());
    }
}
