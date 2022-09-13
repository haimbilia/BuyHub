<?php

class DigitalDownloadSearch extends SearchBase
{
    public function __construct()
    {
        parent::__construct(DigitalDownload::DB_TBL);
    }

    public static function getSearchObject()
    {
        return new SearchBase(DigitalDownload::DB_TBL);
    }

    public static function getLinkDetail($linkId)
    {
        $linkId = FatUtility::int($linkId);

        if ($linkId < 1) {
            return [];
        }

        $srch = static::getSearchObject();
        $srch->joinTable(DigitalDownload::DB_TBL_LINKS, 'INNER JOIN', 'pdl_record_id = pddr_id');

        $srch->addCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'id', '=', $linkId);

        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);


        if (!is_array($row)) {
            return [];
        }

        return $row;
    }

    public static function getAttachmentDetail($aFileId, $refRecordId = 0, $refRecordType = -1, $isPreview = 0)
    {
        $aFileId = FatUtility::int($aFileId);
        $isPreview = FatUtility::int($isPreview);

        if ($aFileId < 1) {
            return [];
        }

        $srch = static::getSearchObject();

        if (0 < $refRecordId) {
            $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'record_id', '=', $refRecordId);
        }

        if (-1 != $refRecordType) {
            $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'type', '=', $refRecordType);
        }

        $attahcedTblOn = 'afile.' . AttachedFile::DB_TBL_PREFIX . 'record_id =' . DigitalDownload::DB_TBL_PREFIX . 'id';
        $srch->joinTable(AttachedFile::DB_TBL, 'INNER JOIN', $attahcedTblOn, 'afile');

        $srch->addCondition('afile.' . AttachedFile::DB_TBL_PREFIX . 'id', '=', $aFileId);
        if (1 == $isPreview) {
            $srch->addCondition('afile.' . AttachedFile::DB_TBL_PREFIX . 'type', '=', AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD_PREVIEW);
        } else {
            $srch->addCondition('afile.' . AttachedFile::DB_TBL_PREFIX . 'type', '=', AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD);
        }

        $srch->addMultipleFields(
            [
                'pddr_id',
                'pddr_record_id',
                'pddr_type',
                'afile.afile_id as afile_id',
                'afile.afile_record_id',
                'afile.afile_physical_path',
            ]
        );

        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return [];
        }

        return $row;
    }

    public static function getAttachments(
        $recordId,
        $recordType,
        $optionCombi = null,
        $langId = 0,
        $displayUniversalFiles = false,
        $fileType = null,
        $attr = []
    ) {
        $srch = static::getSearchObject();

        $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'record_id', '=', $recordId);
        $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'type', '=', $recordType);

        /* $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', '=', $optionCombi); */
        if (null != $optionCombi) {
            if (is_array($optionCombi)) {
                $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', 'IN', $optionCombi);
                // } elseif (is_string($optionCombi) && '0' != $optionCombi) {
                //     $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', '=', $optionCombi);
                // }
            } elseif (is_string($optionCombi)) {
                $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', '=', $optionCombi);
            }
        }

        $attahcedTblOn = 'afile.' . AttachedFile::DB_TBL_PREFIX . 'record_id =' . DigitalDownload::DB_TBL_PREFIX . 'id';
        $srch->joinTable(AttachedFile::DB_TBL, 'INNER JOIN', $attahcedTblOn, 'afile');

        //if (0 < $langId) {
        $langCond = $srch->addCondition('afile.' . AttachedFile::DB_TBL_PREFIX . 'lang_id', '=', $langId);
        if (true === $displayUniversalFiles) {
            /* adding a language id 0 if added previews for all language  */
            $langCond->attachCondition('afile.' . AttachedFile::DB_TBL_PREFIX . 'lang_id', '=', 0);
        }
        //}

        if (is_array($attr)) {
            $srch->addMultipleFields($attr);
        } else {
            $srch->addMultipleFields(['pddr_id', 'pddr_options_code', 'afile_record_id', 'afile_record_subid', 'afile_name', 'afile_lang_id', 'afile_id', 'afile_type']);
        }


        if (null != $fileType) {
            if (is_array($fileType)) {
                $srch->addCondition('afile.' . AttachedFile::DB_TBL_PREFIX . 'type', 'IN', $fileType);
            } elseif (is_numeric($fileType)) {
                $srch->addCondition('afile.' . AttachedFile::DB_TBL_PREFIX . 'type', '=', $fileType);
            }
        } else {
            $srch->addCondition(
                'afile.' . AttachedFile::DB_TBL_PREFIX . 'type',
                'IN',
                [AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD, AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD_PREVIEW]
            );
        }

        $srch->doNotCalculateRecords();
        $srch->addOrder('afile.afile_updated_at', 'DESC');
        $rs = $srch->getResultSet();
        $rows = FatApp::getDb()->fetchAll($rs, 'afile_id');

        /* $rows = static::processAttachmentsWithPreview($rows); */

        return $rows;
    }

    public static function getLinks($recordId, $recordType, $optionCombi = null, $langId = 0, $attr = null, $onlyPreview = false)
    {
        $srch = static::getSearchObject();

        $srch->joinTable(DigitalDownload::DB_TBL_LINKS, 'INNER JOIN', DigitalDownload::DB_TBL_LINKS_PREFIX . 'record_id =' . DigitalDownload::DB_TBL_PREFIX . 'id');

        $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'record_id', '=', $recordId);
        $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'type', '=', $recordType);

        /* $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', '=', $optionCombi); */
        if (null != $optionCombi) {
            if (is_array($optionCombi)) {
                $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', 'IN', $optionCombi);
                // } elseif (is_string($optionCombi) && '0' != $optionCombi) {
                //     $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', '=', $optionCombi);
                // }
            } elseif (is_string($optionCombi)) {
                $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', '=', $optionCombi);
            }
        }

        if (0 < $langId) {
            $srch->addCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'lang_id', '=', $langId);
        } else {
            $cnd = $srch->addCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'lang_id', '=', 0);
            $cnd->attachCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'lang_id', '=', $langId, 'OR');
        }

        if (true == $onlyPreview) {
            $srch->addCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'preview_link', '!=', '');
        }

        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

        $srch->doNotCalculateRecords();
        $srch->addOrder(DigitalDownload::DB_TBL_LINKS_PREFIX . 'id', 'DESC');

        $rs = $srch->getResultSet();
        $rows = FatApp::getDb()->fetchAll($rs, 'pdl_id');

        return $rows;
    }

    public static function getTotalLinksCount($refId)
    {
        $linkId = FatUtility::int($refId);

        if ($refId < 1) {
            return [];
        }

        $srch = static::getSearchObject();

        $srch->joinTable(DigitalDownload::DB_TBL_LINKS, 'INNER JOIN', 'pdl_record_id = pddr_id');

        $srch->addCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'record_id', '=', $refId);

        $srch->addFld('count(pdl_id) as total');
        $srch->doNotCalculateRecords();

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return 0;
        }

        return $row['total'];
    }

    public static function getTotalAttachmentsCount($refId)
    {
        $linkId = FatUtility::int($refId);

        if ($refId < 1) {
            return [];
        }

        $srch = static::getSearchObject();

        $srch->joinTable(AttachedFile::DB_TBL, 'INNER JOIN', 'afile_record_id = pddr_id');

        $srch->addCondition(AttachedFile::DB_TBL_PREFIX . 'record_id', '=', $refId);
        $fileTypes = [AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD, AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD_PREVIEW];

        $srch->addCondition(AttachedFile::DB_TBL_PREFIX . 'type', 'IN', $fileTypes);

        $srch->addFld('count(afile_id) as total');
        $srch->doNotCalculateRecords();

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return 0;
        }

        return $row['total'];
    }

    public static function getInventoryLinks($selProdId, $langId)
    {
        $selProdData = SellerProduct::getAttributesById($selProdId, ['selprod_code', 'selprod_product_id']);

        if (false === $selProdData) {
            return [];
        }

        $selProdOption = explode('_', $selProdData['selprod_code']);
        array_shift($selProdOption);
        if (0 < count($selProdOption)) {
            $optionComb = implode('_', $selProdOption);
            $optionComb = ['0', $optionComb];
        } else {
            $optionComb = '0';
        }

        $product = Product::getAttributesById($selProdData['selprod_product_id'], ['product_attachements_with_inventory']);
        if (false === $product) {
            return [];
        }

        $recordId = $selProdId;
        $productType = Product::CATALOG_TYPE_INVENTORY;
        if (0 == $product['product_attachements_with_inventory']) {
            $recordId = $selProdData['selprod_product_id'];
            $productType = Product::CATALOG_TYPE_PRIMARY;
        }

        $records = static::getLinks($recordId, $productType, $optionComb, $langId);
        /* $commonRecords = [];
        if ('0' != $optionComb) {
            $commonRecords = static::getLinks($recordId, $productType, '0', $langId);
        }
        $records = array_replace($records, $commonRecords); */

        return $records;
    }
    public static function getInventoryAttachments($selProdId, $langId)
    {
        $selProdData = SellerProduct::getAttributesById($selProdId, ['selprod_code', 'selprod_product_id']);

        if (false === $selProdData) {
            return [];
        }

        $selProdOption = explode('_', $selProdData['selprod_code']);
        array_shift($selProdOption);
        if (0 < count($selProdOption)) {
            $optionComb = implode('_', $selProdOption);
            $optionComb = ['0', $optionComb];
        } else {
            $optionComb = '0';
        }

        $product = Product::getAttributesById($selProdData['selprod_product_id'], ['product_attachements_with_inventory']);

        if (false === $product) {
            return [];
        }

        $recordId = $selProdId;
        $productType = Product::CATALOG_TYPE_INVENTORY;
        if (0 == $product['product_attachements_with_inventory']) {
            $recordId = $selProdData['selprod_product_id'];
            $productType = Product::CATALOG_TYPE_PRIMARY;
        }
        $records = static::getAttachments($recordId, $productType, $optionComb, $langId);
        /* $commonRecords = [];
        if ('0' != $optionComb) {
            $commonRecords = static::getAttachments($recordId, $productType, '0', $langId);
        }

        $records = array_replace($records, $commonRecords); */

        return $records;
    }

    public static function processAttachmentsWithPreview($attachments)
    {
        if (0 > count($attachments)) {
            return [];
        }
        $rows = [];
        foreach ($attachments as $key => $attachment) {
            if ($attachment['afile_type'] == AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD) {
                if (!array_key_exists($key, $rows)) {
                    $rows[$key]['pddr_id'] = $attachment['pddr_id'] . 1;
                    $rows[$key]['pddr_options_code'] = $attachment['pddr_options_code'];
                    $rows[$key]['afile_record_id'] = $attachment['afile_record_id'];
                    $rows[$key]['mainfile'] = $attachment['afile_name'];
                    $rows[$key]['afile_lang_id'] = $attachment['afile_lang_id'];
                    $rows[$key]['afile_id'] = $attachment['afile_id'];
                    $rows[$key]['preview'] = '';
                    $rows[$key]['prev_afile_id'] = 0;
                }
                continue;
            }
            if ($attachment['afile_record_subid'] == 0) { /* only preview attached */
                $rows[$key]['pddr_id'] = $attachment['pddr_id'];
                $rows[$key]['pddr_options_code'] = $attachment['pddr_options_code'];
                $rows[$key]['preview'] = $attachment['afile_name'];
                $rows[$key]['prev_afile_id'] = $attachment['afile_id'];
                $rows[$key]['afile_lang_id'] = $attachment['afile_lang_id'];
                $rows[$key]['afile_record_id'] = $attachment['afile_record_id'];
                $rows[$key]['mainfile'] = '';
                $rows[$key]['afile_id'] = 0;
                continue;
            }

            if (!array_key_exists($attachment['afile_record_subid'], $rows)) {
                $rows[$attachment['afile_record_subid']]['pddr_id'] = $attachment['pddr_id'] . 3;
                $rows[$attachment['afile_record_subid']]['pddr_options_code'] = $attachment['pddr_options_code'];
                $rows[$attachment['afile_record_subid']]['afile_record_id'] = $attachment['afile_record_id'];
                $rows[$attachment['afile_record_subid']]['afile_lang_id'] = $attachment['afile_lang_id'];

                $rows[$attachment['afile_record_subid']]['mainfile'] = '';
                $rows[$attachment['afile_record_subid']]['afile_id'] = 0;

                if (array_key_exists($attachment['afile_record_subid'], $attachments)) {
                    $rows[$attachment['afile_record_subid']]['mainfile'] = $attachments[$attachment['afile_record_subid']]['afile_name'];
                    $rows[$attachment['afile_record_subid']]['afile_id'] = $attachment['afile_record_subid'];
                }
            }
            $rows[$attachment['afile_record_subid']]['preview'] = $attachment['afile_name'];
            $rows[$attachment['afile_record_subid']]['prev_afile_id'] = $attachment['afile_id'];
        }

        return $rows;
    }
}
