<?php

class SystemLog extends MyAppModel
{
    public const DB_TBL = 'tbl_system_logs';
    public const DB_TBL_PREFIX = 'slog_';
    
    
    public const MODULE_TYPE_SYSTEM = 1;
    public const MODULE_TYPE_TRANSACTION = 2;
    public const MODULE_TYPE_PLUGIN = 3;

    public const TYPE_ERROR = 1;
    public const TYPE_REQUEST = 2;
    public const TYPE_RESPONSE = 3;

    public function __construct($logId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $logId);
    }
    
    public static function getModuleTypes(): array
    {
        return [
            self::MODULE_TYPE_SYSTEM,
            self::MODULE_TYPE_TRANSACTION,
            self::MODULE_TYPE_PLUGIN,
        ];
    }
    
    public static function getTypes(): array
    {
        return [
            self::TYPE_ERROR,
            self::TYPE_REQUEST,
            self::TYPE_RESPONSE,
        ];
    }

    public static function clearOldLog()
    {
        FatApp::getDb()->deleteRecords(
            self::DB_TBL,
            array(
                'smt' => 'slog_created_at < ?',
                'vals' => array(
                    date('Y-m-d', strtotime("-3 Day"))
                )
            )
        );
    }

    
    public static function set(string $msg, int $module_type = self::MODULE_TYPE_SYSTEM, int $type = self::TYPE_ERROR, $recordId = 0, string &$error = ''): bool
    {
        if (!in_array($module_type, self::getModuleTypes()) || !in_array($type, self::getTypes()) || empty($msg)) {
            $error = Labels::getLabel('MSG_INVALID_REQUEST', CommonHelper::getLangId());
            return false;
        }

        $data = [
            self::DB_TBL_PREFIX . 'module_type' => $module_type,
            self::DB_TBL_PREFIX . 'type' => $type,
            self::DB_TBL_PREFIX . 'details' => $msg,
            self::DB_TBL_PREFIX . 'record_id' => $recordId,
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
