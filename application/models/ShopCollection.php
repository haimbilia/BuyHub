<?php

class ShopCollection extends MyAppModel
{
    public const DB_TBL = 'tbl_shop_collections';
    public const DB_TBL_PREFIX = 'scollection_';

    public const DB_TBL_LANG = 'tbl_shop_collections_lang';
    public const DB_TBL_LANG_PREFIX = 'scollectionlang_';

    public const DB_TBL_SHOP_COLLECTION_PRODUCTS = 'tbl_shop_collection_products';
    public const DB_TBL_SHOP_COLLECTION_PRODUCTS_PREFIX = 'scp_';

    public const DB_SELLER_PRODUCTS = 'tbl_seller_products';
    public const DB_SELLER_PRODUCTS_PREFIX = 'selprod_';

    public const DB_SELLER_PRODUCTS_LANG_TBL = 'tbl_seller_products_lang';
    public const DB_SELLER_PRODUCTS_LANG_TBL_PREFIX = 'selprodlang_';

    public function __construct($scollectionId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $scollectionId);
        $this->objMainTableRecord->setSensitiveFields(array(static::DB_TBL_PREFIX . 'id'));
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'scol');
    }
    
    public function save()
    {
        if (!($this->mainTableRecordId > 0)) {
            $this->setFldValue('scollection_active', 1);
        }
        parent::save();
        return $this->mainTableRecordId;
    }

    public static function getCollectionGeneralDetail($shop_id, $scollection_id = 0, $langId = 0, $join = 'LEFT OUTER JOIN')
    {
        $langId = FatUtility::int($langId);
        $shop_id = FatUtility::int($shop_id);
        $srch = self::getSearchObject();
        if (0 < $langId) {
            $srch->joinTable(static::DB_TBL_LANG, $join, static::DB_TBL_LANG_PREFIX . 'scollection_id = ' . static::DB_TBL_PREFIX . 'id and ' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId);
            $srch->addMultipleFields(['scollection_id', 'scollection_shop_id', 'scollection_identifier', 'scollection_active', 'IFNULL(scollection_name, scollection_identifier) as scollection_name']);
        }

        $srch->addCondition(static::DB_TBL_PREFIX . "shop_id", "=", 'mysql_func_' . $shop_id, 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        if (0 < $scollection_id) {
            $srch->addCondition(static::DB_TBL_PREFIX . "id", "=", 'mysql_func_' . $scollection_id, 'AND', true);
            $rs = $srch->getResultSet();
            return  FatApp::getDb()->fetch($rs);
        }
        $rs = $srch->getResultSet();
        return  FatApp::getDb()->fetchAll($rs);
    }

    public function addUpdateShopCollectionLang($data = array())
    {
        if (!$data['scollection_id']) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }
        $record = new TableRecord(static::DB_TBL_LANG);
        $to_save_arr = array();
        $to_save_arr[static::DB_TBL_LANG_PREFIX . 'scollection_id'] = $data['scollection_id'];
        $to_save_arr[static::DB_TBL_LANG_PREFIX . 'lang_id'] = $data['lang_id'];
        $to_save_arr[static::DB_TBL_PREFIX . 'name'] = $data['name'];
        $record->assignValues($to_save_arr);
        if (!$record->addNew(array(), $to_save_arr)) {
            $this->error = $record->getError();
            return false;
        }
        return true;
    }

    public function addUpdateSellerCollectionProducts($scp_scollection_id, $selProds = array())
    {
        if (!$scp_scollection_id) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        FatApp::getDb()->deleteRecords(static::DB_TBL_SHOP_COLLECTION_PRODUCTS, array('smt' => static::DB_TBL_SHOP_COLLECTION_PRODUCTS_PREFIX . 'scollection_id = ?', 'vals' => array($scp_scollection_id)));
        if (empty($selProds)) {
            return true;
        }

        $record = new TableRecord(static::DB_TBL_SHOP_COLLECTION_PRODUCTS);
        foreach ($selProds as $product_id) {
            $to_save_arr = array();
            $to_save_arr[static::DB_TBL_SHOP_COLLECTION_PRODUCTS_PREFIX . 'scollection_id'] = $scp_scollection_id;
            $to_save_arr[static::DB_TBL_SHOP_COLLECTION_PRODUCTS_PREFIX . 'selprod_id'] = $product_id;
            $record->assignValues($to_save_arr);
            if (!$record->addNew(array(), $to_save_arr)) {
                $this->error = $record->getError();
                return false;
            }
        }
        return true;
    }

    public function getShopCollectionProducts($scollection_id, $lang_id)
    {
        $scollection_id = FatUtility::convertToType($scollection_id, FatUtility::VAR_INT);
        $lang_id = FatUtility::convertToType($lang_id, FatUtility::VAR_INT);
        if (!$scollection_id) {
            trigger_error(Labels::getLabel("ERR_Arguments_not_specified.", $this->commonLangId), E_USER_ERROR);
            return false;
        }
        $srch = new SearchBase(static::DB_TBL_SHOP_COLLECTION_PRODUCTS);
        $srch->addCondition(static::DB_TBL_SHOP_COLLECTION_PRODUCTS_PREFIX . 'scollection_id', '=', 'mysql_func_' . $scollection_id, 'AND', true);
        $srch->joinTable(static::DB_SELLER_PRODUCTS, 'INNER JOIN', static::DB_SELLER_PRODUCTS_PREFIX . 'id = ' . static::DB_TBL_SHOP_COLLECTION_PRODUCTS_PREFIX . 'selprod_id');
        $srch->joinTable(static::DB_SELLER_PRODUCTS . '_lang', 'LEFT JOIN', 'slang.' . static::DB_SELLER_PRODUCTS_LANG_TBL_PREFIX . 'selprod_id = ' . static::DB_TBL_SHOP_COLLECTION_PRODUCTS_PREFIX . 'selprod_id AND ' . static::DB_SELLER_PRODUCTS_LANG_TBL_PREFIX . 'lang_id = ' . $lang_id, 'slang');
        $srch->joinTable(Product::DB_TBL, 'LEFT JOIN', Product::DB_TBL_PREFIX . 'id = ' . static::DB_SELLER_PRODUCTS_PREFIX . 'product_id');
        $srch->joinTable(Product::DB_TBL . '_lang', 'LEFT JOIN', 'lang.productlang_product_id = ' . static::DB_SELLER_PRODUCTS_LANG_TBL_PREFIX . 'selprod_id AND productlang_lang_id = ' . $lang_id, 'lang');
        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'selprod_user_id = seller_user.user_id and seller_user.user_is_supplier = ' . applicationConstants::YES . ' AND seller_user.user_deleted = ' . applicationConstants::NO, 'seller_user');
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'credential_user_id = seller_user.user_id and credential_active = ' . applicationConstants::ACTIVE . ' and credential_verified = ' . applicationConstants::YES, 'tuc');
        $srch->addMultipleFields(
            array(
                'selprod_id', 'IFNULL(selprod_title ,product_name) as product_name', 'product_identifier', 'credential_username'
            )
        );


        $srch->doNotCalculateRecords();
        $srch->addOrder('selprod_active', 'DESC');
        //echo $srch->getQuery();
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $data = array();
        if ($row = $db->fetchAll($rs)) {
            return $row;
        }
        return $data;
    }

    public static function getShopCollectionsDetail($shop_id, $langId)
    {
        $shop_id = FatUtility::int($shop_id);
        $srch = self::getSearchObject();
        $srch->joinTable(static::DB_TBL_LANG, 'LEFT OUTER JOIN', static::DB_TBL_LANG_PREFIX . 'scollection_id = ' . static::DB_TBL_PREFIX . 'id and ' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId);
        $srch->addMultipleFields(array('scollection_id', 'IFNULL(scollection_name, scollection_identifier) as scollection_name', 'scollection_shop_id'));
        $srch->addCondition(static::DB_TBL_PREFIX . "shop_id", "=", 'mysql_func_' . $shop_id, 'AND', true);
        $srch->addCondition(static::DB_TBL_PREFIX . "active", "=", 'mysql_func_' . applicationConstants::YES, 'AND', true);
        $srch->addGroupBy('scollection_id');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        return  FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    public function deleteCollection($collection_id)
    {
        $collection_id = FatUtility::int($collection_id);
        $db = FatApp::getDb();
        if (1 > $collection_id) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST.', $this->commonLangId);
            return false;
        }

        if (!$db->deleteRecords(static::DB_TBL, array('smt' => static::DB_TBL_PREFIX . 'id = ?', 'vals' => array($collection_id)))) {
            $this->error = $db->getError();
            return false;
        }

        if (!$db->deleteRecords(static::DB_TBL_LANG, array('smt' => static::DB_TBL_LANG_PREFIX . 'scollection_id =  ?', 'vals' => array($collection_id)))) {
            $this->error = $db->getError();
            return false;
        }

        if (!$db->deleteRecords(static::DB_TBL_SHOP_COLLECTION_PRODUCTS, array('smt' => static::DB_TBL_SHOP_COLLECTION_PRODUCTS_PREFIX . 'scollection_id = ?', 'vals' => array($collection_id)))) {
            $this->error = $db->getError();
            return false;
        }

        return true;
    }
}
