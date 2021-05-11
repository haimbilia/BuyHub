<?php

class DigitalDownloadSearch extends SearchBase
{
    public function __construct()
    {
        parent::__construct(DigitalDownload::DB_TBL);
    }

    public function getLinkDetailByLinkId($linkId)
    {
        $this->joinTable(DigitalDownload::DB_TBL_LINKS, 'INNER JOIN', 'pdl_record_id = pddr_id');
        $this->addCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'id', '=', $linkId);

        $this->setPageSize(1);
        $this->doNotCalculateRecords();

        $rs = $this->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return [];
        }

        return $row;
    }

    public function getLinksById($linkId)
    {

        $linkId = FatUtility::int($linkId);

        if ($linkId < 1) {
            return [];
        }

        $this->joinTable(DigitalDownload::DB_TBL_LINKS, 'INNER JOIN', 'pdl_record_id = pddr_id');

        $this->addCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'id', '=', $linkId);

        $this->setPageSize(1);
        $this->doNotCalculateRecords();

        $rs = $this->getResultSet();
        $row = FatApp::getDb()->fetch($rs);


        if (!is_array($row)) {
            return [];
        }

        return $row;
    }

    public static function getAttachments($recordId, $recordType, $optionCombi = '0', $langId = 0)
    {
        $srch = new SearchBase(DigitalDownload::DB_TBL);

        $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'record_id', '=', $recordId);
        $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'type', '=', $recordType);
        
        if ('0' != $optionCombi) {
            $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', '=', $optionCombi);
        }
        
        $attahcedTblOn = 'afile.' . AttachedFile::DB_TBL_PREFIX . 'record_id =' . DigitalDownload::DB_TBL_PREFIX . 'id';
        $srch->joinTable(AttachedFile::DB_TBL, 'INNER JOIN', $attahcedTblOn, 'afile');

        $srch->joinTable(
            AttachedFile::DB_TBL,
            'LEFT JOIN',
            'pa.afile_record_subid = afile.afile_id AND pa.' . AttachedFile::DB_TBL_PREFIX . 'type =' . AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD_PREVIEW,
            'pa'
        );
        
        if (0 < $langId) {
            $srch->addCondition('afile.' . AttachedFile::DB_TBL_PREFIX . 'lang_id', '=', $langId);
        }
        $srch->addMultipleFields(
            [
                'pddr_id',
                'pddr_options_code',
                'pa.afile_name as preview',
                'afile.afile_record_id as afile_record_id',
                'afile.afile_name as mainfile',
                'afile.afile_lang_id as afile_lang_id',
                'afile.afile_id as afile_id'
            ]
        );
        $srch->addCondition('afile.' . AttachedFile::DB_TBL_PREFIX . 'type', '=', AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD);
        
        $srch->doNotCalculateRecords();
        $srch->addOrder('afile.afile_updated_at', 'DESC');

        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetchAll($rs, 'afile_id');
    }
    
    public static function getLinks($recordId, $recordType, $optionCombi = '0', $langId = 0)
    {
        $srch = new SearchBase(DigitalDownload::DB_TBL);

        $srch->joinTable(DigitalDownload::DB_TBL_LINKS, 'INNER JOIN', DigitalDownload::DB_TBL_LINKS_PREFIX . 'record_id =' . DigitalDownload::DB_TBL_PREFIX . 'id');

        $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'record_id', '=', $recordId);
        $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'type', '=', $recordType);
        
        if ($optionCombi != '0') {
            $srch->addCondition(DigitalDownload::DB_TBL_PREFIX . 'options_code', '=', $optionCombi);
        }

        if (0 < $langId) {
            $srch->addCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'lang_id', '=', $langId);
        }

        $srch->doNotCalculateRecords();

        $srch->addOrder(DigitalDownload::DB_TBL_LINKS_PREFIX . 'id', 'DESC');

        $rs = $srch->getResultSet();
        $rows = FatApp::getDb()->fetchAll($rs);

        return $rows;
    }

    public function getTotalLinksCount($refId)
    {
        $linkId = FatUtility::int($refId);

        if ($refId < 1) {
            return [];
        }

        $this->joinTable(DigitalDownload::DB_TBL_LINKS, 'INNER JOIN', 'pdl_record_id = pddr_id');

        $this->addCondition(DigitalDownload::DB_TBL_LINKS_PREFIX . 'record_id', '=', $refId);

        $this->addFld('count(pdl_id) as total');
        $this->doNotCalculateRecords();

        $rs = $this->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return 0;
        }

        return $row['total'];
    }

    public function getTotalAttachmentsCount($refId)
    {
        $linkId = FatUtility::int($refId);

        if ($refId < 1) {
            return [];
        }

        $this->joinTable(AttachedFile::DB_TBL, 'INNER JOIN', 'afile_record_id = pddr_id');

        $this->addCondition(AttachedFile::DB_TBL_PREFIX . 'record_id', '=', $refId);
        $fileTypes = [AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD, AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD_PREVIEW];

        $this->addCondition(AttachedFile::DB_TBL_PREFIX . 'type', 'IN', $fileTypes);

        $this->addFld('count(afile_id) as total');
        $this->doNotCalculateRecords();

        $rs = $this->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return 0;
        }

        return $row['total'];
    }

}
