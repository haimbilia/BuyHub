<?php

class AppReleaseVersion extends MyAppModel
{

    const DB_TBL = 'tbl_app_release_versions';
    const DB_TBL_PREFIX = 'arv_';
    const DB_TBL_LOGS = 'tbl_app_release_version_logs';
    const DB_TBL_LOGS_PREFIX = 'arvlog_';

    private $db;

    public function __construct(int $releaseId = 0)
    {
        parent::__construct(static::DB_TBL, 'arv_id', $releaseId);
        $this->db = FatApp::getDb();
    }

    public function saveRecord(int $byAdminId): bool
    {
        $this->db->startTransaction();
        $this->setFldValue('arv_added_by', $byAdminId);
        if ($this->mainTableRecordId == 0) {
            $this->setFldValue('arv_added_on', date('Y-m-d H:i:s'));
        }
        if ($this->mainTableRecordId > 0) {
            $this->setFldValue('arv_updated_on', date('Y-m-d H:i:s'));
            if (false == $this->logHistory($byAdminId)) {
                $this->db->rollbackTransaction();
                return false;
            }
        }
        if (!$this->save()) {
            $this->db->rollbackTransaction();
            return false;
        }
        if (!$this->db->commitTransaction()) {
            $this->db->rollbackTransaction();
            $this->error = $this->db->getError();
            return false;
        }
        return true;
    }

    public function logHistory(int $byAdminId): bool
    {
        $data = parent::getAttributesById($this->mainTableRecordId, ['arv_app_version', 'arv_is_critical', 'arv_description']);
        $record = [
            'arvlog_arv_id' => $this->mainTableRecordId,
            'arvlog_added_on' => date("Y-m-d H:i:s"),
            'arvlog_added_by' => $byAdminId,
            'arvlog_app_version' => $data['arv_app_version'],
            'arvlog_is_critical' => $data['arv_is_critical'],
            'arvlog_description' => $data['arv_description']
        ];
        if (!$this->db->insertFromArray(self::DB_TBL_LOGS, $record, false, [], $record)) {
            $this->error = $this->db->getError();
            return false;
        }
        return true;
    }

}
