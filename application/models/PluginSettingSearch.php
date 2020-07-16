<?php

class PluginSettingSearch extends SearchBase
{    
    private $langId;    
    
    /**
     * __construct
     *
     * @param  int $langId
     * @return void
     */
    public function __construct(int $langId = 0)
    {
        $this->langId = $langId;
        parent::__construct(PluginSetting::DB_TBL, 'tps');
    }
    
    /**
     * joinPlugin
     *
     * @param  int $langId
     * @return void
     */
    public function joinPlugin(int $langId = 0)
    {
        $langId = 0 < $langId ? $langId : $this->langId;
        $this->joinTable(Plugin::DB_TBL, 'LEFT OUTER JOIN', 'plg.plugin_id = tps.pluginsetting_plugin_id', 'plg');
        if (0 < $langId) {
            $this->joinTable(Plugin::DB_TBL_LANG, 'LEFT OUTER JOIN', 'plg_l.pluginlang_plugin_id = plg.plugin_id AND plg_l.pluginlang_lang_id = ' . $langId, 'plg_l');
        }
    }
}
