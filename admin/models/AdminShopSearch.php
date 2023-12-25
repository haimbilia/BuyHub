<?php

class AdminShopSearch extends SearchBase
{
    private $langId;

    public function __construct(int $langId = 0)
    {
        parent::__construct(Shop::DB_TBL, 'shop');
        $this->langId = $langId;
        if ($this->langId > 0) {
            $this->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'shopLang.shoplang_shop_id = shop.shop_id AND shopLang.shoplang_lang_id = ' . $this->langId, 'shopLang');
        }
    }

    public function joinWithUser()
    {
        $this->joinTable(User::DB_TBL, 'INNER JOIN', 'users.user_id = shop.shop_user_id', 'users');
    }

    public function joinWithCredential()
    {
        $this->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'users.user_id = cred.credential_user_id', 'cred');
    }

    public function getListingRecords()
    {
        $this->addMultipleFields([
            'shop.shop_id',
            'shop.shop_user_id',
            'shop.shop_active',
            'shop.shop_created_on',
            'shop.shop_updated_on',
            'shop.shop_identifier',
            'shop.shop_featured',
            'shop.shop_supplier_display_status',
            'IFNULL(shopLang.shop_name, shop.shop_identifier) as shop_name',
            'users.user_name',
            'cred.credential_username',
            'shop.shop_updated_on'
        ]);
        $this->doNotCalculateRecords();
        $results = Fatapp::getDb()->fetchAll($this->getResultSet());
        if (empty($results)) {
            return [];
        }
        $reports = $this->numOfReports(array_column($results, 'shop_id'));
        $products = $this->numOfProducts(array_column($results, 'shop_user_id'));
        $reviews = $this->prodReviewSearch(array_column($results, 'shop_user_id'));
        foreach ($results as $key => $result) {
            $results[$key]['numOfReports'] = $reports[$result['shop_id']] ?? 0;
            $results[$key]['numOfProducts'] = $products[$result['shop_user_id']] ?? 0;
            $results[$key]['numOfReviews'] = $reviews[$result['shop_user_id']] ?? 0;
        }
        return $results;
    }

    private function numOfReports(array $shopIds)
    {
        if (empty($shopIds)) {
            return [];
        }
        $shopReportObj = ShopReport::getSearchObject($this->langId);
        $shopReportObj->addMultipleFields(array('sreport_shop_id', 'count(1) as numOfReports'));
        $shopReportObj->addDirectCondition('( sreport_shop_id  IN (' . implode(',', $shopIds) . '))');
        $shopReportObj->addGroupby('sreport_shop_id');
        $shopReportObj->doNotCalculateRecords();
        $shopReportObj->doNotLimitRecords();
        return Fatapp::getDb()->fetchAllAssoc($shopReportObj->getResultSet());
    }

    private function numOfProducts(array $shopUserIds)
    {
        if (empty($shopUserIds)) {
            return [];
        }
        $prodSrch = SellerProduct::getSearchObject();
        $prodSrch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $prodSrch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'selprod_user_id = u.user_id', 'u');
        $prodSrch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'u.user_id = uc.credential_user_id', 'uc');
        $prodSrch->addCondition('selprod_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $prodSrch->addCondition('product_deleted', '=', applicationConstants::NO);
        $prodSrch->addCondition('product_active', '=', applicationConstants::ACTIVE);
        $prodSrch->addCondition('product_approved', '=', applicationConstants::YES);
        $prodSrch->addDirectCondition('( selprod_user_id  IN (' . implode(',', $shopUserIds) . '))');
        $prodSrch->addMultipleFields(array('selprod_user_id', 'count(1) as numOfProducts'));
        $prodSrch->addGroupby('selprod_user_id');
        $prodSrch->doNotCalculateRecords();
        $prodSrch->doNotLimitRecords();
        return Fatapp::getDb()->fetchAllAssoc($prodSrch->getResultSet());
    }

    private function prodReviewSearch(array $shopUserIds)
    {
        if (empty($shopUserIds)) {
            return [];
        }
        $ratingSrch = new SelProdReviewSearch($this->langId);
        $ratingSrch->joinUser();
        $ratingSrch->joinSeller();
        $ratingSrch->joinProducts();
        $ratingSrch->joinSellerProducts();
        $ratingSrch->joinSelProdRating();
        $ratingSrch->addCondition('rt.ratingtype_type', '=', RatingType::TYPE_PRODUCT);
        $ratingSrch->addMultipleFields(array('spreview_seller_user_id', 'count(1) as numOfReviews'));
        $ratingSrch->addDirectCondition('( spreview_seller_user_id  IN (' . implode(',', $shopUserIds) . '))');
        $ratingSrch->addGroupby('spreview_seller_user_id');
        $ratingSrch->doNotCalculateRecords();
        $ratingSrch->doNotLimitRecords();
        return Fatapp::getDb()->fetchAllAssoc($ratingSrch->getResultSet());
    }

    public function applySearchConditions(array $conditions)
    {
        if (empty($conditions)) {
            return;
        }

        if (!empty($conditions['sortOrder']) && !empty($conditions['sortBy'])) {
            $this->addOrder($conditions['sortBy'], $conditions['sortOrder']);
        }

        if (isset($conditions['page']) && !empty($conditions['page'])) {
            $this->setPageNumber(FatUtility::int($conditions['page']));
        }

        if (isset($conditions['pageSize']) && !empty($conditions['pageSize'])) {
            $this->setPageSize($conditions['pageSize']);
        }

        if (!empty($conditions['keyword'])) {
            $cond = $this->addCondition('shop.shop_identifier', 'like', '%' . $conditions['keyword'] . '%', 'AND');
            $cond->attachCondition('shopLang.shop_name', 'like', '%' . $conditions['keyword'] . '%', 'OR');
            $cond->attachCondition('users.user_name', 'like', '%' . $conditions['keyword'] . '%', 'OR');
            $cond->attachCondition('cred.credential_username', 'like', '%' . $conditions['keyword'] . '%', 'OR');
            $cond->attachCondition('cred.credential_email', 'like', '%' . $conditions['keyword'] . '%', 'OR');
        }
        $shopFeatured = FatUtility::convertToType($conditions['shop_featured'], FatUtility::VAR_INT, -1);
        if ($shopFeatured > -1 && $conditions['shop_featured'] != '') {
            $this->addCondition('shop_featured', '=', 'mysql_func_' . $shopFeatured, 'AND', true);
        }

        $shopActive = FatUtility::convertToType($conditions['shop_active'], FatUtility::VAR_INT, -1);
        if ($shopActive > -1 && $conditions['shop_active'] != '') {
            $this->addCondition('shop_active', '=', 'mysql_func_' . $shopActive, 'AND', true);
        }
        $shopDisplayStatus = FatUtility::convertToType($conditions['shop_supplier_display_status'], FatUtility::VAR_INT, -1);
        if ($shopDisplayStatus > -1 && $conditions['shop_supplier_display_status'] != '') {
            $this->addCondition('shop_supplier_display_status', '=', 'mysql_func_' . $shopDisplayStatus, 'AND', true);
        }

        $date_from = FatUtility::convertToType($conditions['date_from'], FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $this->addCondition('shop_created_on', '>=', $date_from . ' 00:00:00');
        }

        $date_to = FatUtility::convertToType($conditions['date_to'], FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $this->addCondition('shop_created_on', '<=', $date_to . ' 23:59:59');
        }

        if (!empty($conditions['shop_id'])) {
            $this->addCondition('shop_id', '=', 'mysql_func_' . FatUtility::int($conditions['shop_id']), 'AND', true);
        }
    }

    public static function getUrlRewrite($searchId)
    {
        $urlSrch = UrlRewrite::getSearchObject();
        $urlSrch->doNotCalculateRecords();
        $urlSrch->setPageSize(1);
        $urlSrch->addFld('urlrewrite_custom');
        $urlSrch->addCondition('urlrewrite_original', '=', $searchId);
        $urlRow = FatApp::getDb()->fetch($urlSrch->getResultSet());
        if ($urlRow) {
            return $urlRow['urlrewrite_custom'];
        }
        return '';
    }
}
