<?php

class DigitalDownloadsSearch extends SearchBase
{
    public function __construct()
    {
        parent::__construct(DigitalDownloads::DB_TBL);
    }

    public function getLinkDetailByLinkId($linkId)
    {
        $this->joinTable(DigitalDownloads::DB_TBL_LINKS, 'INNER JOIN', 'pdl_record_id = pddr_id');
        $this->addCondition(DigitalDownloads::DB_TBL_LINKS_PREFIX . 'id', '=', $linkId);

        $this->setPageSize(1);
        $this->doNotCalculateRecords();

        $rs = $this->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return [];
        }

        return $row;
    }

    public function getLinks($linkId = 0, $refId = 0)
    {

        $linkId = FatUtility::int($linkId);
        $refId = FatUtility::int($refId);

        if ($linkId < 1 && $refId < 1) {
            return [];
        }

        $this->joinTable(DigitalDownloads::DB_TBL_LINKS, 'INNER JOIN', 'pdl_record_id = pddr_id');

        if(1 <= $linkId) {
            $this->addCondition(DigitalDownloads::DB_TBL_LINKS_PREFIX . 'id', '=', $linkId);
        }

        if(1 <= $refId) {
            $this->addCondition(DigitalDownloads::DB_TBL_LINKS_PREFIX . 'record_id', '=', $refId);
        }

        if (0 < $linkId) {
            $this->setPageSize(1);
        }

        $this->doNotCalculateRecords();

        $rs = $this->getResultSet();
        $rows = FatApp::getDb()->fetchAll($rs);
        if (0 < count($rows) && 0 < $linkId) {
            return current($rows);
        }

        return $rows;
    }

    public function getTotalLinksCount($refId)
    {
        $linkId = FatUtility::int($refId);

        if ($refId < 1) {
            return [];
        }

        $this->joinTable(DigitalDownloads::DB_TBL_LINKS, 'INNER JOIN', 'pdl_record_id = pddr_id');

        $this->addCondition(DigitalDownloads::DB_TBL_LINKS_PREFIX . 'record_id', '=', $refId);

        $this->addFld('count(pdl_id) as total');
        $this->doNotCalculateRecords();

        $rs = $this->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return 0;
        }

        return $row['total'];
    }

}
