<?php

class DigitalDownloadsSearch extends SearchBase
{
    public function __construct()
    {
        parent::__construct(DigitalDownloads::DB_TBL);
    }

    public function getLinkDetailByLinkId($linkId)
    {
        $this->joinTable(DigitalDownloads::DB_TBL, 'INNER JOIN', 'pdl_record_id = pddr_id');
        $this->addCondition(DigitalDownloads::DB_TBL_LINKS_PREFIX . 'id', '=', $linkId);

        $this->setPageSize(1);
        $this->doNotCalculateRecords();

        $rs = $this->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return [];
        }

        // CommonHelper::printArray([$row], 1);
        return $row;
    }
}
