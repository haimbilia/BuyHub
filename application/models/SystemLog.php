<?php

class SystemLog extends MyAppModel
{
    public const DB_TBL = 'tbl_system_logs';
    public const DB_TBL_PREFIX = 'slog_';
    public const MODULE_TYPE_SYSTEM = 1;
    public const MODULE_TYPE_TRANSACTION = 2;
    public const MODULE_TYPE_PLUGIN = 3;
    
    public const TYPE_ERROR = 1;
    public const TYPE_INFO = 2;
    public const TYPE_SUCCESS = 3;

    public function __construct($logId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $logId);
    }
    
    public static function getSearchObject($isActive = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'sylog');
        return $srch;
    }
    
    public static function getModuleTypes(): array
    {   
        $langId = FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1);
        return [
            self::MODULE_TYPE_SYSTEM =>Labels::getLabel('MSG_System', $langId),
            self::MODULE_TYPE_TRANSACTION =>Labels::getLabel('MSG_Transaction', $langId),
            self::MODULE_TYPE_PLUGIN =>Labels::getLabel('MSG_Plugin', $langId),
        ];
    }

    public static function getTypes(): array
    {   
        $langId = FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1);
        return [
            self::TYPE_ERROR =>Labels::getLabel('MSG_Error', $langId),
            self::TYPE_INFO =>Labels::getLabel('MSG_Info', $langId),
            self::TYPE_SUCCESS =>Labels::getLabel('MSG_Success', $langId),            
        ];
    }

    public static function clearOldLog()
    {
        FatApp::getDb()->deleteRecords(
                self::DB_TBL,
                array(
                    'smt' => 'slog_created_at < ?',
                    'vals' => array(
                        date('Y-m-d', strtotime("-5 Day"))
                    )
                )
        );
    }

    public static function system(string $msg, $title = '', $type = self::TYPE_ERROR, &$error = '')
    {
        return static::set($msg, '', self::MODULE_TYPE_SYSTEM, $type, $title, $error);
    }

    public static function plugin($request = '', $recieve = '', $titleOrPluginName = '', $type = self::TYPE_ERROR, &$error = '')
    {
        return self::set($request, $recieve, self::MODULE_TYPE_PLUGIN, $type, $titleOrPluginName, $error);
    }

    public static function transaction(string $msg, $title = '', $type = self::TYPE_ERROR, &$error = '')
    {
        return static::set($msg, '', self::MODULE_TYPE_TRANSACTION, $type, $title, $error);
    }

    public static function set(string $content = '', string $response = '', int $module_type = self::MODULE_TYPE_SYSTEM, int $type = self::TYPE_ERROR, $title = '', string &$error = ''): bool
    {
        if (!in_array($module_type, self::getModuleTypes()) || !in_array($type, self::getTypes())) {
            $error = Labels::getLabel('MSG_INVALID_REQUEST', CommonHelper::getLangId());
            return false;
        }
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);       
        $backtrace = json_encode(end($backtrace));
        
        $data = [
            self::DB_TBL_PREFIX . 'module_type' => $module_type,
            self::DB_TBL_PREFIX . 'type' => $type,
            self::DB_TBL_PREFIX . 'title' => $title,
            self::DB_TBL_PREFIX . 'content' => $content,
            self::DB_TBL_PREFIX . 'response' => $response,
            self::DB_TBL_PREFIX . 'backtrace' => $backtrace,
            self::DB_TBL_PREFIX . 'created_at' => date('Y-m-d H:i:s'),
        ];
        $self = new self();
        $self->assignValues($data);
        if (!$self->save()) {
            $error = $self->getError();
            return false;
        }
        return true;
    }

}
