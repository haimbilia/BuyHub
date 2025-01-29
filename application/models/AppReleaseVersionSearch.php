<?php

class AppReleaseVersionSearch extends SearchBase
{

    private $db;

    public function __construct()
    {
        parent::__construct(AppReleaseVersion::DB_TBL, 'arv');
        $this->db = FatApp::getDb();
    }

    public function joinWithAdminUsers()
    {
        $this->joinTable(AdminUsers::DB_TBL, 'INNER JOIN', 'arv_added_by = admin_id', 'admin');
    }

    public function applyConditions(array $conditions = [])
    {
        if (empty($conditions)) {
            return true;
        }

        if (isset($conditions['page']) && !empty($conditions['page'])) {
            $this->setPageNumber(FatUtility::int($conditions['page']));
        }

        if (isset($conditions['pageSize']) && !empty($conditions['pageSize'])) {
            $this->setPageSize(FatUtility::int($conditions['pageSize']));
        }

        if (isset($conditions['keyword']) && !empty($conditions['keyword'])) {
            $keyword = trim($conditions['keyword']);
            $cnd = $this->addCondition('arv_package_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('arv_app_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('arv_description', 'like', '%' . $keyword . '%');
        }

        if (isset($conditions['arv_app_type']) && $conditions['arv_app_type'] > 0) {
            $this->addCondition('arv_app_type', '=', $conditions['arv_app_type']);
        }

        if (isset($conditions['arv_package_name']) && !empty($conditions['arv_package_name'])) {
            $this->addCondition('arv_package_name', '=', $conditions['arv_package_name']);
        }

        if (isset($conditions['exclude_arv_id']) && $conditions['exclude_arv_id'] > 0) {
            $this->addCondition('arv_id', '!=', $conditions['exclude_arv_id']);
        }
    }

    public function getListing(array $data = []): array
    {
        $this->joinWithAdminUsers();
        $this->applyConditions($data);
        $this->addMultipleFields([
            'arv.*',
            'admin.admin_name as added_by',
        ]);
        $this->addOrder('arv_app_name', 'ASC');
        $this->addOrder('arv_app_type', 'ASC');
        $this->doNotCalculateRecords();
        return $this->db->fetchAll($this->getResultSet());
    }

    public function searchVersions(array $data): array
    {
        $this->applyConditions($data);
        $this->doNotCalculateRecords();
        $this->setPageSize(1);  
        $record = $this->db->fetch($this->getResultSet());
        return (!empty($record)) ? $record : [];
    }

    public static function getLatestCriticalFromLogs(array $data): array
    {
        $srch = new SearchBase(AppReleaseVersion::DB_TBL_LOGS);
        $srch->addCondition('arvlog_arv_id', '=', $data['arv_id']);
        $srch->addCondition('arvlog_app_version', '>', $data['appversion']);
        $srch->addCondition('arvlog_is_critical', '=', applicationConstants::YES);
        $srch->addOrder('arvlog_app_version', 'DESC');
        $srch->addMultipleFields([
            'arvlog_app_version',
            'arvlog_is_critical',
            'arvlog_description',
        ]);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $record = FatApp::getDb()->fetch($srch->getResultSet());
        return (!empty($record)) ? $record : [];
    }

}
