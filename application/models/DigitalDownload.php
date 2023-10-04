<?php

class DigitalDownload extends MyAppModel
{
    public const DB_TBL = 'tbl_product_digital_data_relation';
    public const DB_TBL_PREFIX = 'pddr_';
    
    public const DB_TBL_LINKS = 'tbl_product_digital_links';
    public const DB_TBL_LINKS_PREFIX = 'pdl_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX.'id', $id);
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
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', CommonHelper::getLangId());
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

    public function saveLink( $langId, $downloadLink, $previewLink = '', $ddLinkid = 0)
    {
        if (1 > $this->getMainTableRecordId()) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', CommonHelper::getLangId());
            return false;
        }

        $dataToSave = array(
            static::DB_TBL_LINKS_PREFIX . 'record_id' => $this->getMainTableRecordId(),
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

    public static function getDownloadForm($langId, $type = -1 , $recordId = 0)
    {
        $frm = new Form('frmDownload');

        $frm->addSelectBox(Labels::getLabel('FRM_OPTION', $langId), 'option_comb_id', [], '', array('class' => 'option-comb-id-js'), '');

        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', array(0 => Labels::getLabel('FRM_ALL_LANGUAGES', $langId)) + Language::getDropDownList(), '', array('class' => 'file-language-js'), '')->requirements()->setRequired();
        if ($type == applicationConstants::DIGITAL_DOWNLOAD_FILE) {
            $frm->addFileUpload(Labels::getLabel('FRM_UPLOAD_FILE', $langId), 'downloadable_file');
            $frm->addFileUpload(Labels::getLabel('FRM_UPLOAD_PREVIEW', $langId), 'preview_file');
            $frm->addHiddenField('', 'download_type', $type);
        }elseif($type == applicationConstants::DIGITAL_DOWNLOAD_LINK){
            $frm->addTextBox(Labels::getLabel('FRM_DOWNLOADABLE_LINK', $langId), 'product_downloadable_link');
            $frm->addTextBox(Labels::getLabel('FRM_PREVIEW_LINK', $langId), 'product_preview_link');
            $frm->addHiddenField('', 'download_type', $type);
        } else {
            $digitalDownloadTypeArr = applicationConstants::digitalDownloadTypeArr($langId);
            $frm->addSelectBox(Labels::getLabel('FRM_DIGITAL_DOWNLOAD_TYPE', $langId), 'download_type', $digitalDownloadTypeArr, '', array('class' => 'download-type'), '')->requirements()->setRequired();
        }
        $frm->addSelectBox(Labels::getLabel('FRM_ATTACH_WITH_EXISTING_ORDERS', $langId), 'attach_with_existing_orders', applicationConstants::getYesNoArr($langId), applicationConstants::NO, array('id' => 'attach_with_existing_orders'), '');
        $frm->addHiddenField('', 'record_id', $recordId);

        $frm->addHiddenField('', 'dd_link_id');
        $frm->addHiddenField('', 'is_preview', 0);
        $frm->addHiddenField('', 'dd_link_ref_id');
        $frm->addHiddenField('', 'ref_file_id', 0);
      
        return $frm;
    }    

    public static function getDownloadFormInventory($langId, $recordId = 0)
    {
        $frm = new Form('frmDownload');
        $bannerTypeArr = array(0 => Labels::getLabel('FRM_ALL_LANGUAGES', $langId)) + Language::getDropDownList();
        $digitalDownloadTypeArr = applicationConstants::digitalDownloadTypeArr($langId);

        $frm->addSelectBox(Labels::getLabel('FRM_OPTION', $langId), 'option_comb_id', [], '', array('class' => 'option-comb-id-js'), '')->requirements()->setRequired();
        
        $frm->addSelectBox(Labels::getLabel('FRM_DIGITAL_DOWNLOAD_TYPE', $langId), 'download_type', $digitalDownloadTypeArr, '', array('class' => 'download-type'), '')->requirements()->setRequired();

        $frm->addSelectBox(Labels::getLabel('FRM_ATTACH_WITH_EXISTING_ORDERS', $langId), 'attach_with_existing_orders', applicationConstants::getYesNoArr($langId), applicationConstants::NO, array('id' => 'attach_with_existing_orders'), '');
        
        $fld = $frm->addTextBox(Labels::getLabel('FRM_DOWNLOADABLE_LINK', $langId), 'product_downloadable_link');
       

        $frm->addTextBox(Labels::getLabel('FRM_PREVIEW_LINK', $langId), 'product_preview_link');
        
        $frm->addButton('', 'attachment_link_btn', Labels::getLabel('FRM_ADD', $langId));

        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', $bannerTypeArr, '', array('class' => 'file-language-js'), '')->requirements()->setRequired();

        $fldImg = $frm->addFileUpload(Labels::getLabel('FRM_UPLOAD_FILE', $langId), 'downloadable_file', array('id' => 'downloadable_file'));
        
        $frm->addFileUpload(Labels::getLabel('FRM_UPLOAD_PREVIEW', $langId), 'preview_file', array('id' => 'preview_file'));

        $frm->addButton('', 'attachement_upload_btn', Labels::getLabel('FRM_UPLOAD', $langId));
        $frm->addButton('', 'reset', Labels::getLabel('FRM_RESET', $langId));
        
        $frm->addHiddenField('', 'record_id', $recordId);      
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

    public static function returnResponseOrDie($returnResult = false, $response = false, $message = '')
    {
        if (true == $returnResult) {
            return $response;
        }

        if ($message == '') {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', CommonHelper::getLangId()) . __LINE__;
        }
        FatUtility::dieJsonError($message);
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

    public function attachLinkWithOrderedProducts($downloadLink, $recordId, $requestType, $option)
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
