<?php

class Questions extends MyAppModel
{
    public const DB_TBL = 'tbl_questions';
    public const DB_TBL_LANG = 'tbl_questions_lang';

    public const DB_TBL_PREFIX = 'question_';
    public const DB_TBL_LANG_PREFIX = 'questionlang_';

    public const TYPE_TEXT = 1;
    public const TYPE_SINGLE_CHOICE = 2;
    public const TYPE_MULTIPLE_CHOICE = 3;
    public const TYPE_RATING_5 = 4;
    public const TYPE_RATING_10 = 5;

    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject($langId = 0, $active = true, $deleted = true)
    {
        $langId = FatUtility::int($langId);

        $srch = new SearchBase(static::DB_TBL, 'q');
        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'q_l.' . static::DB_TBL_LANG_PREFIX . 'question_id = q.' . static::tblFld('id') . ' and
			q_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'q_l'
            );
        }

        if ($active == true) {
            $srch->addCondition('q.' . static::DB_TBL_PREFIX . 'active', '=', applicationConstants::ACTIVE);
        }

        if ($deleted == true) {
            $srch->addCondition('q.' . static::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        }
        return $srch;
    }

    public static function getQuestionTypesArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
        static::TYPE_TEXT => Labels::getLabel('LBL_QUESTION_TYPE_TEXT', $langId),
        static::TYPE_SINGLE_CHOICE => Labels::getLabel('LBL_QUESTION_TYPE_SINGLE_CHOICE', $langId),
        static::TYPE_MULTIPLE_CHOICE => Labels::getLabel('LBL_QUESTION_TYPE_MULTIPLE_CHOICE', $langId),
        static::TYPE_RATING_5 => Labels::getLabel('LBL_QUESTION_TYPE_RATING_5', $langId),
        static::TYPE_RATING_10 => Labels::getLabel('LBL_QUESTION_TYPE_RATING_10', $langId),
        );
    }
}
