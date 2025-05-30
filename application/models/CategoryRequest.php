<?php

class CategoryRequest extends MyAppModel
{
    public const DB_TBL = 'tbl_seller_category_requests';
    public const DB_TBL_LANG = 'tbl_seller_category_requests_lang';
    public const DB_TBL_PREFIX = 'scategoryreq_';
    public const DB_TBL_LANG_PREFIX = 'scategoryreqlang_';
    public const CATEGORY_REQUEST_PENDING = 0;
    public const CATEGORY_REQUEST_APPROVED = 1;
    public const CATEGORY_REQUEST_CANCELLED = 2;
    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject($langId = 0)
    {
        $srch = new SearchBase(static::DB_TBL, 'cat');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'cat_l.' . static::DB_TBL_LANG_PREFIX . 'scategoryreq_id = cat.' . static::tblFld('id') . ' and
			cat_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'cat_l'
            );
        }
        $srch->addOrder('cat.' . static::DB_TBL_PREFIX . 'id', 'DESC');
        return $srch;
    }

    public static function getCategoryReqStatusArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId == 0) {
            trigger_error(Labels::getLabel('ERR_LANGUAGE_ID_NOT_SPECIFIED.', CommonHelper::getLangId()), E_USER_ERROR);
        }
        $arr = array(
        static::CATEGORY_REQUEST_PENDING => Labels::getLabel('LBL_PENDING', $langId),
        static::CATEGORY_REQUEST_APPROVED => Labels::getLabel('LBL_APPROVED', $langId),
        static::CATEGORY_REQUEST_CANCELLED => Labels::getLabel('LBL_CANCELLED', $langId)
        );
        return $arr;
    }

    public function updateCategoryRequest($data = array())
    {
        if (empty($data)) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', CommonHelper::getLangId());
            return false;
        }

        $srequest_id = FatUtility::int($data['request_id']);

        $assignValues = array(
        'scategoryreq_status' => $data['status'],
        /* 'scategoryreq_comments'=>isset($data['comments'])?$data['comments']:'', */
        );
        if (!FatApp::getDb()->updateFromArray(
            static::DB_TBL,
            $assignValues,
            array('smt' => 'scategoryreq_id = ? ', 'vals' => array((int)$srequest_id))
        )) {
            $this->error = $this->db->getError();
            return false;
        }
        return true;
    }

    public function addCategory($scategoryReqId = 0)
    {
        $brequestData = CategoryRequest::getAttributesById($scategoryReqId, array('scategoryreq_seller_id', 'scategoryreq_identifier'));
        $categoryDataToSave = array(
        'scategoryreq_identifier' => $brequestData['scategoryreq_identifier'],
        'scategoryreq_seller_id' => $brequestData['scategoryreq_seller_id'],
        );
    }
}
