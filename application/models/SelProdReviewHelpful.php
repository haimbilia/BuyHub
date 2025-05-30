<?php

class SelProdReviewHelpful extends MyAppModel
{
    public const DB_TBL = 'tbl_seller_product_reviews_helpful';
    public const DB_TBL_PREFIX = 'sprh_';

    public const REVIEW_IS_HELPFUL = 1;
    public const REVIEW_IS_NOT_HELPFUL = 0;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public function getdata()
    {
        $srch = new SearchBase(static::DB_TBL, 'sprh');
        $srch->addCondition(static::DB_TBL_PREFIX . 'spreview_id', '=', 'mysql_func_' . $this->mainTableRecordId, 'AND', true);
        $srch->addMultipleFields(
            array('sum(if(sprh_helpful = 1 , 1 ,0)) as helpful', 'sum(if(sprh_helpful = 0 , 1 ,0)) as notHelpful')
        );
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        if ($row = $db->fetch($rs)) {
            return $row;
        }
        return array();
    }
}
