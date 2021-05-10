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

    public function getReferenceId($productId, $productOption, $refType = 0)
    {
        $refType = FatUtility::int($refType);

        $srch = new DigitalDownloadSearch();
        $srch->addCondition(static::DB_TBL_PREFIX . 'record_id', '=', $productId);
        $srch->addCondition(static::DB_TBL_PREFIX . 'options_code', '=', $productOption);
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
    
    public function saveReference($productId, $optionsCode, $refType = 0)
    {
        if ($productId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        $refType = FatUtility::int($refType);

        $dataToSave = array(
            static::DB_TBL_PREFIX . 'record_id' => $productId,
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
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
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

    public function deleteAttachment($aFileId, $refId)
    {
        $aFileObj = new AttachedFile();
        
        if (false == $aFileObj->deleteFile(AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD, $refId, $aFileId)) {
            $this->error = $aFileObj->getError();
            return false;
        }

        $this->deletePreviewAttachment($refId, $aFileId);

        return true;
    }

    public function deletePreviewAttachment($recordId, $subRecordId)
    {
        $aFileObj = new AttachedFile();
        
        if (false == $aFileObj->deleteFile(AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD_PREVIEW, $recordId, 0, $subRecordId)) {
            $this->error = $aFileObj->getError();
            return false;
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

    public static function getDownloadForm($recordId, $langId)
    {
        $frm = new Form('frmDownload');
        $bannerTypeArr = applicationConstants::bannerTypeArr($langId);
        $digitalDownloadTypeArr = applicationConstants::digitalDownloadTypeArr($langId);

        $frm->addSelectBox(Labels::getLabel('LBL_Option', $langId), 'option_comb_id', [], '', array('class' => 'option-comb-id-js'), '')->requirements()->setRequired();
        
        $frm->addSelectBox(Labels::getLabel('LBL_Digital_Download_Type', $langId), 'download_type', $digitalDownloadTypeArr, '', array('class' => 'file-language-js'), '')->requirements()->setRequired();
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Downloadable_Link', $langId), 'product_downloadable_link');
        $fld->requirements()->setRequired();

        $frm->addTextBox(Labels::getLabel('LBL_Preview_Link', $langId), 'product_preview_link');
        
        $frm->addButton('', 'attachment_link_btn', Labels::getLabel('LBL_Add', $langId));

        $frm->addSelectBox(Labels::getLabel('Lbl_Language', $langId), 'lang_id', $bannerTypeArr, '', array('class' => 'file-language-js'), '')->requirements()->setRequired();

        // $frm->addSelectBox(Labels::getLabel('LBL_Preview_File?', $langId), 'is_preview', applicationConstants::getYesNoArr($langId), applicationConstants::NO, array('id' => 'is_preview'), '')->requirements()->setRequired();
        $fldImg = $frm->addFileUpload(Labels::getLabel('LBL_Upload_File', $langId), 'downloadable_file', array('id' => 'downloadable_file'));
        
        $frm->addFileUpload(Labels::getLabel('LBL_Upload', $langId), 'preview_file', array('id' => 'preview_file'));

        $frm->addButton('', 'attachement_upload_btn', Labels::getLabel('LBL_Upload', $langId));

        $frm->addHiddenField('', 'product_id');
        $frm->addHiddenField('', 'preq_id');
        $frm->addHiddenField('', 'dd_link_id');
        $frm->addHiddenField('', 'dd_link_ref_id');
        return $frm;
    }

    public static function getProductOptionCombinations($prodId, $langId, $requestedProd = false, $addDefOption = true, $optSeparator = '_')
    {
        $optionCombinations = [];

        if(true == $requestedProd) {
            $productOptions = ProductRequest::getProductReqOptions($preqId, $langId, true);
        } else {
            $productOptions = Product::getProductOptions($prodId, $langId, true);
        }

        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', $optSeparator);

        if (true == $addDefOption) {
            $optionCombinations = array('0' => Labels::getLabel('LBL_All', $langId)) + $optionCombinations;
        }
        return $optionCombinations;
    }

    public static function canDo($recordId, $recordType = 0, $sellerUserId = 0, $langId = 0, $returnResult = false)
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
                if (true == $returnResult) {
                    return false;
                }
                FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $langId));
            }
            
            $product = json_decode($productReqRow['preq_content'], true);

            if (!$product) {
                if (true == $returnResult) {
                    return false;
                }
                FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $langId));
            }
        } else {
            if (Product::CATALOG_TYPE_INVENTORY == $recordType) {
                /* Seller Inventroy*/
                $sellerProduct = SellerProduct::getAttributesById($splprice_selprod_id, ['selprod_user_id', 'selprod_product_id'], false);
                if (false == $sellerProduct) {
                    if (true == $returnResult) {
                        return false;
                    }
                    FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $langId));
                }
                /* $inventoryId = $recordId; Can be used id required further. As of now no need*/
                $recordId = $sellerProduct['selprod_product_id'];
            }

            $product = Product::getAttributesById($recordId, ['product_type', 'product_download_attachements_with_inventory']);
        
            if (false == $product) {
                if (true == $returnResult) {
                    return false;
                }
                FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $langId));
            }
        }

        
        /*
        TODO: To check whether product belogs to logged seller?
        sellerUserId
        */
        if (0 < $sellerUserId) {
            if (Product::CATALOG_TYPE_INVENTORY == $recordType) {
                /* Seller Invetory */
                $recordOwnerId = $sellerProduct['selprod_user_id'];
            } else { /* Catalog product */
                $recordOwnerId = $product['product_seller_id'];
            }
            if ($recordOwnerId != $sellerUserId) {
                if (true == $returnResult) {
                    return false;
                }
                FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $langId) . 'Invalid Seller');
            }
        }
        
        if (Product::PRODUCT_TYPE_DIGITAL != $product['product_type']) {
            if (true == $returnResult) {
                return false;
            }
            FatUtility::dieWithError(Labels::getLabel('LBL_Attachments_or_links_allowed_only_with_digital_products', $langId));
        }

        if (applicationConstants::NO == $product['product_download_attachements_with_inventory']) {
            return true;
        }

        if (true == $returnResult) {
            return false;
        }
        FatUtility::dieWithError(Labels::getLabel('LBL_Attachments_or_links_allowed_with_inventory', $langId));
    }
}
