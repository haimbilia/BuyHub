<?php

class SavedSearchProduct extends MyAppModel
{
    public const DB_TBL = 'tbl_product_saved_search';
    public const DB_TBL_PREFIX = 'pssearch_';

    public const PAGE_CATEGORY = 1;
    public const PAGE_PRODUCT = 2;
    public const PAGE_BRAND = 3;
    public const PAGE_SHOP = 4;
    public const PAGE_FEATURED_PRODUCT = 5;
    public const PAGE_PRODUCT_INDEX = 6;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);      
    }

    public static function getPageUrl()
    {
        return array(
            static::PAGE_CATEGORY => 'Category/view/',
            static::PAGE_PRODUCT => 'Products/search/',
            static::PAGE_PRODUCT_INDEX => 'Products/index/',
            static::PAGE_BRAND => 'Brands/view/',
            static::PAGE_SHOP => 'Shops/view/',
            static::PAGE_FEATURED_PRODUCT => 'Products/featured/'
        );
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'sps');
    }

    public static function getSearchPageFullUrl($type, $recordId)
    {
        $url = '';
        switch ($type) {
            case static::PAGE_CATEGORY:
                $url = UrlHelper::generateFullUrl('Category', 'view', array($recordId), CONF_WEBROOT_FRONTEND);
                break;
            case static::PAGE_PRODUCT:
                $url = UrlHelper::generateFullUrl('Products', 'search', [], CONF_WEBROOT_FRONTEND);
                break;
            case static::PAGE_PRODUCT_INDEX:
                $url = UrlHelper::generateFullUrl('Products', 'index', [], CONF_WEBROOT_FRONTEND);
                break;
            case static::PAGE_BRAND:
                $url = UrlHelper::generateFullUrl('Brands', 'view', array($recordId), CONF_WEBROOT_FRONTEND);
                break;
            case static::PAGE_SHOP:
                $url = UrlHelper::generateFullUrl('Shops', 'view', array($recordId), CONF_WEBROOT_FRONTEND);
                break;
            case static::PAGE_FEATURED_PRODUCT:
                $url = UrlHelper::generateFullUrl('Products', 'featured', [], CONF_WEBROOT_FRONTEND);
                break;
        }
        return $url;
    }

    public static function getSearhResultFormat($arr, $langId = 0)
    {
        $result = [];
        $count = 1;
        foreach ($arr as $key => $row) {
            switch ($key) {
                case 'price-min-range':
                    $result[$count]['label'] = Labels::getLabel('LBL_PRICE_MIN', $langId);
                    $result[$count]['value'] = $row;
                    break;
                case 'price-max-range':
                    $result[$count]['label'] = Labels::getLabel('LBL_PRICE_MAX', $langId);
                    $result[$count]['value'] = $row;
                    break;
                case 'featured':
                    $result[$count]['label'] = Labels::getLabel('LBL_FEATURED', $langId);
                    $result[$count]['value'] = Labels::getLabel('LBL_YES', $langId);
                    break;
                case 'currency_id':
                    $currency = Currency::getAttributesById($row, array('currency_code'));
                    if ($currency) {
                        $result[$count]['label'] = Labels::getLabel('LBL_CURRENCY', $langId);
                        $result[$count]['value'] = $currency['currency_code'];
                    }
                    break;
                case 'brand':
                    $brand = Brand::getSearchObject($langId);
                    $brand->addMultipleFields(array('IFNULL(brand_name,brand_identifier) as brand_name,brand_identifier'));
                    $brand->addCondition('brand_id', 'in', $row);
                    $brand->doNotCalculateRecords();
                    $rs = $brand->getResultSet();
                    $brandData = FatApp::getDb()->fetchAll($rs);
                    if (!empty($brandData)) {
                        $result[$count]['label'] = Labels::getLabel('LBL_BRAND', $langId);
                        $result[$count]['value'] = [];
                        foreach ($brandData as $val) {
                            $result[$count]['value'][] = ($val['brand_name'] != '') ? $val['brand_name'] : $val['brand_identifier'];
                        }
                    }
                    break;
                case 'prodcat':
                    $productCategory = ProductCategory::getSearchObject(false, $langId);
                    $productCategory->addOrder('m.prodcat_active', 'DESC');
                    $productCategory->addMultipleFields(array('IFNULL(prodcat_name,prodcat_identifier) as prodcat_name,prodcat_identifier'));
                    $productCategory->addCondition('prodcat_id', 'in', $row);
                    $productCategory->doNotCalculateRecords();
                    $rs = $productCategory->getResultSet();
                    $productCategoryData = FatApp::getDb()->fetchAll($rs);
                    if (!empty($productCategoryData)) {
                        $result[$count]['label'] = Labels::getLabel('LBL_CATEGORY', $langId);
                        $result[$count]['value'] = [];
                        foreach ($productCategoryData as $val) {
                            $result[$count]['value'][] = ($val['prodcat_name'] != '') ? $val['prodcat_name'] : $val['prodcat_identifier'];
                        }
                    }
                    break;
                case 'condition':
                    $conditionArr = Product::getConditionArr($langId);
                    $result[$count]['label'] = Labels::getLabel('LBL_CONDITION', $langId);
                    $result[$count]['value'] = [];
                    foreach ($row as $val) {
                        if (!array_key_exists($val, $conditionArr)) {
                            continue;
                        }
                        $result[$count]['value'][] = $conditionArr[$val];
                    }
                    break;
                case 'optionvalue':
                    $optionValue = OptionValue::getSearchObject($langId);
                    $optionValue->addMultipleFields(array('IFNULL(optionvalue_name,optionvalue_identifier) as optionvalue_name,optionvalue_identifier'));
                    $optionValue->addCondition('optionvalue_id', 'in', $row);
                    $optionValue->doNotCalculateRecords();
                    $rs = $optionValue->getResultSet();
                    $optionValueData = FatApp::getDb()->fetchAll($rs);
                    if (!empty($optionValueData)) {
                        $result[$count]['label'] = Labels::getLabel('LBL_OPTIONS', $langId);
                        $result[$count]['value'] = [];
                        foreach ($optionValueData as $val) {
                            $result[$count]['value'][] = ($val['optionvalue_name'] != '') ? $val['optionvalue_name'] : $val['optionvalue_identifier'];
                        }
                    }
                    break;
                case 'availability':
                    if (in_array(1, $row)) {
                        $result[$count]['label'] = Labels::getLabel('LBL_OUT_OF_STOCK', $langId);
                        $result[$count]['value'] = Labels::getLabel('LBL_YES', $langId);
                    }
                    break;
            }
            $count++;
        }
        return $result;
    }
}
