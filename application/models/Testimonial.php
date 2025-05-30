<?php

class Testimonial extends MyAppModel
{
    public const DB_TBL = 'tbl_testimonials';
    public const DB_TBL_PREFIX = 'testimonial_';

    public const DB_TBL_LANG = 'tbl_testimonials_lang';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject($langId = 0, $active = true)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 't');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                't_l.testimoniallang_testimonial_id = t.testimonial_id
			AND testimoniallang_lang_id = ' . $langId,
                't_l'
            );
        }
        if ($active == true) {
            $srch->addCondition('t.testimonial_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        }
        $srch->addCondition('t.testimonial_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        return $srch;
    }

    public function canRecordMarkDelete(int $testimonialId): bool
    {
        $srch = static::getSearchObject();
        $srch->addCondition('testimonial_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $srch->addCondition('testimonial_id', '=', $testimonialId);
        $srch->addFld('testimonial_id');
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!empty($row) && $row['testimonial_id'] == $testimonialId) {
            return true;
        }
        return false;
    }
}
