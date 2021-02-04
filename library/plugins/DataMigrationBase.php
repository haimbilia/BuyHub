<?php

class DataMigrationBase extends PluginBase
{
        
    protected function saveData($dataArr)
    {
        
        $pluginID = $this->settings['plugin_id'];
        $dataArr = $dataArr + $this->getData();
        $data = json_encode($dataArr);
        $confName = 'DATA_MIGRATION_' . $pluginID;        
        $dataToSave = array('conf_name' => $confName, 'conf_val' => $data);
        
        FatApp::getDb()->insertFromArray(
            Configurations::DB_TBL,
            $dataToSave,
            false,
            array(),
            $dataToSave
        );
    }

    protected function getData($key = '')
    {          
        $pluginID = $this->settings['plugin_id'];
        $confName = 'DATA_MIGRATION_' . $pluginID;
        $val = FatApp::getConfig($confName, FatUtility::VAR_STRING, '');        
        $data = !empty($val) ? json_decode($val, true) : [];
        if (!empty($key)) {
            return isset($data[$key]) ? $data[$key] : null;
        }
        return $data;
    }
            
    
}
