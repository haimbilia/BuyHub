<?php

class Badge extends MyAppModel
{
    public const DB_TBL = 'tbl_badges';
    public const DB_TBL_PREFIX = 'badge_';

    public const DB_TBL_LANG = 'tbl_badges_lang';
    public const DB_TBL_LANG_PREFIX = 'badgelang_';

    public const TYPE_BADGE = 1;
    public const TYPE_RIBBON = 2;

    public const SHAPE_CIRCLE = 1;
    public const SHAPE_CAPSULE = 2;

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'type',
        self::DB_TBL_PREFIX . 'shape_type',
        self::DB_TBL_PREFIX . 'color',
        self::DB_TBL_PREFIX . 'identifier',
        self::DB_TBL_PREFIX . 'required_approval',
        self::DB_TBL_PREFIX . 'active'
    ];

    public const LANG_ATTR = [
        self::DB_TBL_LANG_PREFIX . 'lang_id',
        self::DB_TBL_PREFIX . 'name'
    ];

    public const ICON_MIN_WIDTH = 50;
    public const ICON_MIN_HEIGHT = 50;

    public const REMOVED_OLD_IMAGE_TIME = 4;

    /**
     * __construct
     *
     * @param  int $ratingTypeId
     * @return void
     */
    public function __construct(int $ratingTypeId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $ratingTypeId);
        $this->objMainTableRecord->setSensitiveFields([self::DB_TBL_PREFIX . 'id']);
    }

    /**
     * getTypeArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getTypeArr(int $langId): array
    {
        return [
            self::TYPE_BADGE => Labels::getLabel('LBL_BADGE', $langId),
            self::TYPE_RIBBON => Labels::getLabel('LBL_RIBBON', $langId)
        ];
    }
    
    /**
     * getTypeName
     *
     * @param  int $type
     * @param  int $langId
     * @return string
     */
    public static function getTypeName(int $type, int $langId): string
    {
        $arr = self::getTypeArr($langId);
        if (!array_key_exists($type, $arr)) {
            return '';
        }
        return (string) $arr[$type];
    }

    /**
     * getShapeTypesArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getShapeTypesArr(int $langId): array
    {
        return [
            self::SHAPE_CIRCLE => Labels::getLabel('LBL_CIRCLE', $langId),
            self::SHAPE_CAPSULE => Labels::getLabel('LBL_CAPSULE', $langId),
        ];
    }

    /**
     * getShapeTypeName
     *
     * @param  int $type
     * @param  int $langId
     * @return string
     */
    public static function getShapeTypeName(int $type, int $langId): string
    {
        $arr = self::getShapeTypesArr($langId);
        if (!array_key_exists($type, $arr)) {
            return '';
        }
        return (string) $arr[$type];
    }
    
    /**
     * getData
     *
     * @param  int $langId
     * @return array
     */
    public function getData(int $langId): array
    {
        if (1 > $this->getMainTableRecordId()) {
            $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
            return [];
        }

        $srch = new BadgeSearch($langId);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition(self::DB_TBL_PREFIX . 'id', '=', $this->getMainTableRecordId());
        $srch->addMultipleFields(array_merge(self::ATTR, self::LANG_ATTR));
        $srch->descOrder();
        $rs = $srch->getResultSet();
        
        return (array) FatApp::getDb()->fetch($rs);
    }

    /**
     * getAllLangData
     *
     * @return array
     */
    public function getAllLangData(): array
    {
        if (1 > $this->getMainTableRecordId()) {
            $this->error = Labels::getLabel('MSG_INVALID_REQUEST', CommonHelper::getLangId());
            return [];
        }

        $srch = new BadgeSearch();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->joinTable(
            Badge::DB_TBL_LANG,
            'LEFT OUTER JOIN',
            'bdg_l.badgelang_badge_id = bdg.badge_id',
            'bdg_l'
        );
        $srch->addCondition(self::DB_TBL_PREFIX . 'id', '=', $this->getMainTableRecordId());
        $srch->addMultipleFields(array_merge(self::ATTR, self::LANG_ATTR));
        $srch->descOrder();
        $rs = $srch->getResultSet();
        
        return (array) FatApp::getDb()->fetchAll($rs, self::DB_TBL_LANG_PREFIX . 'lang_id');
    }
    
    /**
     * getRequiredApprovalName
     *
     * @param  int $status
     * @param  int $langId
     * @return string
     */
    public static function getRequiredApprovalName(int $status, int $langId): string
    {
        return (applicationConstants::YES == $status ? Labels::getLabel('LBL_REQUESTED', $langId) : Labels::getLabel('LBL_OPEN', $langId));
    }
    
    /**
     * add
     *
     * @param  array $post
     * @return bool
     */
    public function add(array $post): bool
    {
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $recordData = [];
        foreach (Badge::ATTR as $column) {
            switch ($column) {
                case Badge::DB_TBL_PREFIX . 'id':
                    continue 2;
                    break;
                
                case Badge::DB_TBL_PREFIX . 'identifier':
                        $recordData[$column] = "";
                        if (array_key_exists(Badge::DB_TBL_PREFIX . 'name', $post) && is_array($post[Badge::DB_TBL_PREFIX . 'name']) && array_key_exists($siteDefaultLangId, $post[Badge::DB_TBL_PREFIX . 'name'])) {
                            $recordData[$column] = $post[Badge::DB_TBL_PREFIX . 'name'][$siteDefaultLangId];
                        } else {
                            $recordData[$column] = $post[Badge::DB_TBL_PREFIX . 'name'];
                        }
                    break;
                    
                case Badge::DB_TBL_PREFIX . 'active':
                    $recordData[$column] = (0 > $post[Badge::DB_TBL_PREFIX . 'active'] ? applicationConstants::NO : $post[Badge::DB_TBL_PREFIX . 'active']);
                    break;
                        
                default:
                    $recordData[$column] = array_key_exists($column, $post) ? $post[$column] : '';
                    break;
                
            }
        }

        $this->assignValues($recordData);
        if (!$this->save()) {
            return false;
        }

        $badgeId = $this->getMainTableRecordId();

        if (array_key_exists(Badge::DB_TBL_PREFIX . 'name', $post) && is_array($post[Badge::DB_TBL_PREFIX . 'name'])) {
            foreach ($post[Badge::DB_TBL_PREFIX . 'name'] as $langId => $name) {
                $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
                $tranlateToOtherLang = array_key_exists('auto_update_other_langs_data', $post) ? $post['auto_update_other_langs_data'] : 0;
                if (empty($name) && !empty($translatorSubscriptionKey) && 0 < $tranlateToOtherLang) {
                    $updateLangDataobj = new TranslateLangData(self::DB_TBL_LANG);
                    $translatedText = $updateLangDataobj->directTranslate([Badge::DB_TBL_PREFIX . 'name' => $recordData[Badge::DB_TBL_PREFIX . 'identifier']]);
                    if (false === $translatedText) {
                        continue;
                    }
                    $name = current($translatedText)[Badge::DB_TBL_PREFIX . 'name'];
                }

                if (empty($name)) {
                    continue;
                }

                $recordLangData = [
                    Badge::DB_TBL_LANG_PREFIX . 'badge_id' => $badgeId,
                    Badge::DB_TBL_LANG_PREFIX . 'lang_id' => $langId,
                    Badge::DB_TBL_PREFIX . 'name' => $name
                ];
                
                if (!$this->updateLangData($langId, $recordLangData)) {
                    continue;
                }
            }
        }
        return true;
    }
    
    /**
     * deleteImagesWithOutBadgeId
     *
     * @param  int $fileType
     * @return bool
     */
    public static function deleteImagesWithOutBadgeId(int $fileType): bool
    {
        if (empty($fileType) || $fileType != AttachedFile::FILETYPE_BADGE) {
            return false;
        }

        $currentDate = date('Y-m-d  H:i:s');
        $prevDate = strtotime('-' . static::REMOVED_OLD_IMAGE_TIME . ' hour', strtotime($currentDate));
        $prevDate = date('Y-m-d  H:i:s', $prevDate);
        $where = array('smt' => 'afile_type = ? AND afile_record_id = ? AND afile_updated_at <= ?', 'vals' => array($fileType, 0, $prevDate));
        if (!FatApp::getDb()->deleteRecords(AttachedFile::DB_TBL, $where)) {
            return false;
        }
        return true;
    }

}
