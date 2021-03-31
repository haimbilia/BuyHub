<?php

class DataMigrationBase extends PluginBase
{

    protected $vendorType = 0;

    protected function saveData(array $dataArr): bool
    {
        $dataArr = $dataArr + $this->getData();
        $data = json_encode($dataArr);
        $keyName = 'DATA_MIGRATION_' . strtoupper($this->settings['plugin_code']);

        if ($this->vendorType === DataMigration::SINGLE_VENDOR) {
            $userObj = new User($this->userId);
            if (!$userObj->updateUserMeta($keyName, $data)) {
                $this->error = $userObj->getError();
                return false;
            }
        } else {
            $db = FatApp::getDb();
            $dataToSave = array('conf_name' => $keyName, 'conf_val' => $data);
            if (!$db->insertFromArray(
                            'tbl_configurations', /* Configurations::DB_TBL */
                            $dataToSave,
                            false,
                            array(),
                            $dataToSave
                    )) {
                $this->error = $db->getError();
                return false;
            }
        }
        return true;
    }

    protected function getData($key = '')
    {
        $keyName = 'DATA_MIGRATION_' . strtoupper($this->settings['plugin_code']);
        if ($this->vendorType === DataMigration::SINGLE_VENDOR) {
            $val = User::getUserMeta($this->userId, $keyName);
        } else {
            $val = FatApp::getConfig($keyName, FatUtility::VAR_STRING, '');
        }

        $data = !empty($val) ? json_decode($val, true) : [];
        if (!empty($key)) {
            return isset($data[$key]) ? $data[$key] : null;
        }
        return $data;
    }

    /**
     * 
     * @param int $type
     */
    public function setVendorType(int $type)
    {
        $this->vendorType = $type;
    }

    public function getVendorType(): int
    {
        return $this->vendorType;
    }

}
