<?php

/**
 *
 * ERR - ERROR Messages 
 * LBL - LABLES (General labels)
 * FRM - Form fields (Labels, Place holders)
 * MSG - Messages
 * VLBL- Form Validations
 * TXT - Text
 * NAV - Navigation
 * CON - confiramtion
 * BCN - BreadcrumbNodes
 */
class Labels extends MyAppModel
{
    public const DB_TBL = 'tbl_language_labels';
    public const DB_TBL_PREFIX = 'label_';
    public const JSON_FILE_DIR_NAME = 'language-labels';

    public const TYPE_WEB = 1;
    public const TYPE_APP = 2;

    private const DIR_LENGTH = 2;

    public function __construct($labelId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $labelId);
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function getTypeArr($langId)
    {
        return array(
            static::TYPE_WEB => self::getLabel('LBL_WEB', $langId),
            static::TYPE_APP => self::getLabel('LBL_APP', $langId)
        );
    }

    public static function getTypeBtnHtml(int $langId, int $status): string
    {
        $arr = self::getTypeArr($langId);
        $msg = $arr[$status] ?? Labels::getLabel('LBL_N/A', $langId);
        switch ($status) {
            case static::TYPE_WEB:
                $status = HtmlHelper::SUCCESS;
                break;
            case static::TYPE_APP:
                $status = HtmlHelper::WARNING;
                break;

            default:
                $status = HtmlHelper::PRIMARY;
                break;
        }
        return HtmlHelper::getStatusHtml($status, $msg);
    }

    public static function getPrefixTypes(int $langId)
    {
        $labelsPrefixes = CacheHelper::get('labelsPrefixes' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if ($labelsPrefixes) {
            return json_decode($labelsPrefixes, true);
        }

        $arr =
            [
                'GEN' => self::getLabel('GEN_GENERAL_LABELS', $langId),
                'TXT' => self::getLabel('TXT_TEXT_MESSAGES', $langId),
                'NAV' => self::getLabel('NAV_NAVIGATION_LABELS', $langId),
                'LBL' => self::getLabel('LBL_GENERAL_LABELS', $langId),
                'FRM' => self::getLabel('FRM_FORM_FIELDS_&_LABELS', $langId),
                'MSG' => self::getLabel('MSG_SYSTEM_MESSAGES', $langId),
                'APP' => self::getLabel('APP_APP_LABELS', $langId),
                'API' => self::getLabel('API_API_LABELS', $langId),
                'BTN' => self::getLabel('BTN_BUTTON_LABELS', $langId),
                'INV' => self::getLabel('GEN_ORDER_OR_INVOICES', $langId),
                'VLBL' => self::getLabel('VLBL_FORM_VALIDATION_LABELS', $langId),
                'USER' => self::getLabel('USER_USER_NOTIFICATIONS', $langId),
                'L' => self::getLabel('L_GENERAL_LABELS', $langId),
                'M' => self::getLabel('M_SYSTEM_MESSAGES', $langId),
                'ERR' => self::getLabel('ERR_ERROR_MESSAGES', $langId),
                'SUC' => self::getLabel('SUC_SUCCESS_MESSAGES', $langId),
                'CON' => self::getLabel('CON_CONFIRMATION_MESSAGES', $langId),
                'BCN' => self::getLabel('BCN_BREADCRUM_NODES', $langId),
            ];
        CacheHelper::create('labelsPrefixes' . $langId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    public static function getSearchObject($langId = 0, $attr = '', $setOrderBy = true)
    {
        $langId = FatUtility::int($langId);

        $srch = new SearchBase(static::DB_TBL, 'lbl');
        if (true === $setOrderBy) {
            $srch->addOrder('lbl.' . static::DB_TBL_PREFIX . 'id', 'DESC');
        }

        $columns = array(
            'lbl.' . static::DB_TBL_PREFIX . 'id',
            'lbl.' . static::DB_TBL_PREFIX . 'lang_id',
            'lbl.' . static::DB_TBL_PREFIX . 'key',
            'lbl.' . static::DB_TBL_PREFIX . 'caption',
            'lbl.' . static::DB_TBL_PREFIX . 'type',
        );

        $attr = (!empty($attr) && is_array($attr)) ? $attr : $columns;

        $srch->addMultipleFields($attr);

        if ($langId > 0) {
            $srch->addCondition('lbl.' . static::DB_TBL_PREFIX . 'lang_id', '=', 'mysql_func_' . $langId, 'AND', true);
        }
        return $srch;
    }

    public static function getLabel(string $key, int $langId = 0, int $type = Labels::TYPE_WEB): string
    {
        if (empty($key)) {
            return '';
        }

        if (preg_match('/\s/', $key)) {
            return $key;
        }

        $type = ($type != static::TYPE_APP) ? static::TYPE_WEB : static::TYPE_APP;

        $langId = (0 < $langId) ? $langId : CommonHelper::getLangId();

        $keyOriginal = $key;
        $key = strtoupper($key);

        $cacheAvailable = static::isAPCUcacheAvailable();
        if ($cacheAvailable) {
            $cacheKey = static::getAPCUcacheKey($key, $langId);
            if (apcu_exists($cacheKey)) {
                return nl2br(strip_tags(trim(apcu_fetch($cacheKey))));
            }
        }

        global $langArray;

        if (isset($langArray[$key][$langId])) {
            if (!empty($langArray[$key][$langId])) {
                return strip_tags($langArray[$key][$langId]);
            }

            $arr = explode(' ', str_replace('_', ' ', strtolower($keyOriginal)));
            array_shift($arr);
            return $langArray[$key][$langId] = nl2br(strip_tags(ucfirst(implode(' ', $arr))));
        }


        $str = '';
        if (FatApp::getConfig('CONF_READ_LABELS_FROM_FILE', FatUtility::VAR_INT, 1)) {
            global $langFileData;
            if (!isset($langFileData[$langId][$key])) {
                $str = $langFileData[$langId][$key] = static::readDataFromFile($langId, $keyOriginal, $type);
            } else {
                if (array_key_exists($key, $langFileData[$langId])) {
                    $str = $langFileData[$langId][$key];
                }
            }
        }

        if (empty($str)) {
            $db = FatApp::getDb();

            $srch = static::getSearchObject($langId);
            $srch->addCondition(static::DB_TBL_PREFIX . 'key', '=', $key);
            $srch->addCondition(static::DB_TBL_PREFIX . 'type', '=', $type);
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();

            if ($lbl = $db->fetch($srch->getResultSet())) {
                if (isset($lbl[static::DB_TBL_PREFIX . 'caption']) && $lbl[static::DB_TBL_PREFIX . 'caption'] != '') {
                    $str = $lbl[static::DB_TBL_PREFIX . 'caption'];
                } else {
                    $arr = explode(' ', str_replace('_', ' ', strtolower($keyOriginal)));
                    array_shift($arr);
                    $str = ucfirst(implode(' ', $arr));
                }
            } else {
                $arr = explode(' ', str_replace('_', ' ', strtolower($keyOriginal)));
                array_shift($arr);

                $str = ucfirst(implode(' ', $arr));
                $assignValues = array(
                    static::DB_TBL_PREFIX . 'key' => $key,
                    static::DB_TBL_PREFIX . 'caption' => $str,
                    static::DB_TBL_PREFIX . 'lang_id' => $langId,
                    static::DB_TBL_PREFIX . 'type' => $type
                );

                FatApp::getDB()->insertFromArray(static::DB_TBL, $assignValues, false, array(), $assignValues);

                $labelsUpdatedAt = array('conf_name' => 'CONF_LANG_LABELS_UPDATED_AT', 'conf_val' => time());
                FatApp::getDb()->insertFromArray('tbl_configurations', $labelsUpdatedAt, false, array(), $labelsUpdatedAt);
            }
        }

        if ($cacheAvailable) {
            apcu_store($cacheKey, $str);
            return nl2br(strip_tags($str));
        }

        global $langArray;
        $langArray[$key][$langId] = $str;
        return nl2br(strip_tags($str));
    }

    public static function readDataFromFile($langId, $key, $type = Labels::TYPE_WEB, $returnVal = true)
    {
        if (strpos(CONF_UPLOADS_PATH, 's3://') !== false) {
            return;
        }
        $keyFileName = strtoupper(substr($key, 0, self::DIR_LENGTH));

        global $languages;
        if (!isset($languages[$langId])) {
            $languages[$langId] = Language::getAttributesById($langId, 'language_code', false);
        }

        $jsonfile = CONF_UPLOADS_PATH . static::JSON_FILE_DIR_NAME . '/' . $type . '/' . $keyFileName . '/' . $languages[$langId] . '.json';
        if (!file_exists($jsonfile)) {
            Labels::updateDataToFile($langId, $languages[$langId], $type, false, $key);
        }

        if ($returnVal === true) {
            $arr =  json_decode(file_get_contents($jsonfile), true);
            if (array_key_exists(strtoupper($key), $arr)) {
                return $arr[strtoupper($key)];
            }
            return;
        }
        return file_get_contents($jsonfile);
    }

    public function addUpdateData($data = array())
    {
        $assignValues = array(
            static::DB_TBL_PREFIX . 'key' => $data['label_key'],
            static::DB_TBL_PREFIX . 'caption' => $data['label_caption'],
            static::DB_TBL_PREFIX . 'lang_id' => $data['label_lang_id'],
            static::DB_TBL_PREFIX . 'type' => $data['label_type'],
        );

        if (!FatApp::getDB()->insertFromArray(static::DB_TBL, $assignValues, false, array(), $assignValues)) {
            return false;
        }

        $labelsUpdatedAt = array('conf_name' => 'CONF_LANG_LABELS_UPDATED_AT', 'conf_val' => time());
        FatApp::getDb()->insertFromArray('tbl_configurations', $labelsUpdatedAt, false, array(), $labelsUpdatedAt);

        $cacheAvailable = static::isAPCUcacheAvailable();
        if ($cacheAvailable) {
            $cacheKey = static::getAPCUcacheKey($data['label_key'], $data['label_lang_id']);
            apcu_store($cacheKey, $data['label_caption']);
        }

        return true;
    }

    public static function isAPCUcacheAvailable()
    {
        return (extension_loaded('apcu') && ini_get('apcu.enabled'));
    }

    public static function getAPCUcacheKey($key, $langId)
    {
        return $_SERVER['SERVER_NAME'] . '_' . $key . '_' . $langId;
    }

    public static function updateDataToFile($langId, $langCode = '', $type = Labels::TYPE_WEB, $updateForceFully = false, $key = '')
    {
        if (empty($langCode)) {
            global $languages;
            if (!isset($languages[$langId])) {
                $languages[$langId] = Language::getAttributesById($langId, 'language_code', false);
            }

            $langCode = $languages[$langId];
        }

        $lastLabelsUpdatedAt = FatApp::getConfig('CONF_LANG_LABELS_UPDATED_AT', FatUtility::VAR_INT, time());

        $path = CONF_UPLOADS_PATH . static::JSON_FILE_DIR_NAME . '/' . $type . '/';
        $keyFileName = '';
        if (!empty($key) && false == $updateForceFully) {
            $keyFileName = strtoupper(substr($key, 0, self::DIR_LENGTH));
            $path .=  $keyFileName . '/';
        }

        if (!file_exists($path)) {
            if (!mkdir($path, 0777, true)) {
                return false;
            }
        }


        if (true == $updateForceFully) {
            $fld = [
                'LEFT(label_key, ' . self::DIR_LENGTH  . ') as keyfilename'
            ];
            $srch = static::getSearchObject($langId, [$fld]);
            $srch->addCondition('label_type', '=', $type);
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $srch->addGroupBy('keyfilename');
            $rs = $srch->getResultSet();
            while ($row = FatApp::getDb()->fetch($rs)) {
                $langFile = $path . $row['keyfilename'] . '/' . $langCode . '.json';

                if (!file_exists($path . $row['keyfilename'] . '/')) {
                    if (!mkdir($path . $row['keyfilename'] . '/', 0777, true)) {
                        continue;
                    }
                }

                $records = static::fetchAllAssoc($langId, array('label_key', 'label_caption'), $type, $row['keyfilename']);
                $records = empty($records) ? (object) array() : $records;
                if (!FatUtility::convertToJson($records, JSON_UNESCAPED_UNICODE)) {
                    continue;
                }

                if (!file_put_contents($langFile, FatUtility::convertToJson($records, JSON_UNESCAPED_UNICODE))) {
                    continue;
                }
            }
            // return true;
        }

        $langFile = $path . $langCode . '.json';
        if ((!file_exists($langFile) || (filemtime($langFile) < $lastLabelsUpdatedAt) || 1 > filesize($langFile)) && $updateForceFully == false) {
            $records = static::fetchAllAssoc($langId, array('label_key', 'label_caption'), $type, $keyFileName);
            $records = empty($records) ? (object) array() : $records;
            if (!FatUtility::convertToJson($records, JSON_UNESCAPED_UNICODE)) {
                return false;
            }
            if (!file_put_contents($langFile, FatUtility::convertToJson($records, JSON_UNESCAPED_UNICODE))) {
                return false;
            }
        }

        if ($type == Labels::TYPE_WEB) {
            CacheHelper::clear(CacheHelper::TYPE_LABELS);
        }

        return true;
    }


    public static function fetchAllAssoc($langId, $attr = '', $type = Labels::TYPE_WEB, $keyPrefix = '')
    {
        $srch = static::getSearchObject($langId, $attr);
        $srch->joinTable('tbl_languages', 'inner join', 'label_lang_id = language_id and language_active = ' . applicationConstants::ACTIVE);
        $srch->addCondition('label_type', '=', $type);
        if (!empty($keyPrefix)) {
            $srch->addCondition('label_key', 'like', $keyPrefix . '%');
        }
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetchAllAssoc($rs);
    }

    public static function displayPrefixType(string $key, int $langId)
    {
        $key =  strtoupper(strstr($key, '_', true));
        $arr = self::getPrefixTypes($langId);
        if (!array_key_exists($key, $arr)) {
            return $key;
        }

        return $arr[$key];
    }
}
