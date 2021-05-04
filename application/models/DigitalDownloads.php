<?php

class DigitalDownloads extends MyAppModel
{
    public const DB_TBL = 'tbl_product_digital_data_relation';
    public const DB_TBL_PREFIX = 'pddr_';
    
    public const DB_TBL_LINKS = 'tbl_product_digital_links';
    public const DB_TBL_LINKS_PREFIX = 'pdl_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX, $id);
    }

    public function getReferenceId($productId, $productOption)
    {
        $srch = new DigitalDownloadsSearch();
        $srch->addCondition(static::DB_TBL_PREFIX . 'product_id', '=', $productId);
        $srch->addCondition(static::DB_TBL_PREFIX . 'options_code', '=', $productOption);

        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return 0;
        }

        return $row['pddr_id'];
    }
    
    public function saveReference($productId, $optionsCode)
    {
        if ($productId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        $dataToSave = array(
            static::DB_TBL_PREFIX . 'product_id' => $productId,
            static::DB_TBL_PREFIX . 'options_code' => $optionsCode,
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

    public static function allowedWithCatalog($productId)
    {
        /* $product = Product::getAttributesById($productId, ['product_download_attachements_with_inventory']);
        return ($product['product_download_attachements_with_inventory'] == applicationConstants::NO ? applicationConstants::YES : applicationConstants::NO); */
    }
}
