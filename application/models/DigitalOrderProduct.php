<?php

class DigitalOrderProduct extends OrderProduct
{
    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function canAttachMoreFiles($currentOpStatus)
    {
        $currentOpStatus = FatUtility::int($currentOpStatus);
        
        $statusesToAttachMoreFiles = static::getAllowedMoreAttachmentsStatues();
            
        if (in_array($currentOpStatus, $statusesToAttachMoreFiles)) {
            return true;
        }

        return false;
    }

    public static function getAllowedMoreAttachmentsStatues()
    {
        $statuses = unserialize(FatApp::getConfig("CONF_ALLOW_FILES_TO_ADD_WITH_ORDER_STATUSES", null, ''));
        if (!$statuses) {
            return [];
        }
        return $statuses;
    }
}
