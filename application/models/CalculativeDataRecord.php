<?php
class CalculativeDataRecord
{
    private static $allCdValues = [];

    /**
     * loadAllValues
     *
     * @param  int $type
     * @return void
     */
    public static function loadAllValues(int $type): void
    {
        if (empty(self::$allCdValues)) {
            self::$allCdValues = CalculativeData::getValuesByType($type);
        }
    }

    /**
     * getValue
     *
     * @param  int $key
     * @return mixed
     */
    public static function getValue(int $key): mixed
    {
        $value = self::$allCdValues[$key] ?? '';
        if (NULL == $value) {
            $value = self::updateAndGetRecordValue($key);
        }
        return $value;
    }

    /**
     * updateAndGetRecordValue
     *
     * @param  int $key
     * @return mixed
     */
    public static function updateAndGetRecordValue(int $key): mixed
    {
        switch ($key) {
            case CalculativeData::KEY_SELLER_APPROVAL:
                $value = self::updateSellerApprovalCount();
                break;
            case CalculativeData::KEY_CUSTOM_CATALOG:
                $value = self::updateCustomCatalogCount();
                break;
            case CalculativeData::KEY_CUSTOM_BRAND:
                $value = self::updateBrandRequestCount();
                break;
            case CalculativeData::KEY_PRODUCT_CATEGORY:
                $value = self::updateCategoryRequestCount();
                break;
            case CalculativeData::KEY_WITHDRAWAL:
                $value = self::updateWithdrawalRequestCount();
                break;
            case CalculativeData::KEY_ORDER_CANCELLATION:
                $value = self::updateOrderCancelRequestCount();
                break;
            case CalculativeData::KEY_ORDER_RETURN:
                $value = self::updateBlogContributionRequestCount();
                break;
            case CalculativeData::KEY_BLOG_CONTRIBUTIONS:
                $value = self::updateBlogCommentRequestCount();
                break;
            case CalculativeData::KEY_BLOG_COMMENTS:
                $value = self::updateThresholdSelprodRequestCount();
                break;
            case CalculativeData::KEY_THRESHOLD_LEVEL_PRODUCTS:
                $value = self::updateGdprRequestCount();
                break;
            case CalculativeData::KEY_USER_GDPR:
                $value = self::updateBadgeRequestCount();
                break;
            case CalculativeData::KEY_BADGE:
                $value = self::updateOrderReturnRequestCount();
                break;
            case CalculativeData::KEY_SELLER_PRODUCT:
                $value = self::updateSelprodRequestCount();
                break;
            default:
                trigger_error('Invalid Key', E_USER_ERROR);
                break;
        }
        return $value;
    }

    /**
     * updateSellerApprovalCount -  Seller Approval Request
     *
     * @return int
     */
    public static function updateSellerApprovalCount(): int
    {
        $userObj = new User();
        $supReqSrchObj = $userObj->getUserSupplierRequestsObj();
        $supReqSrchObj->addCondition('usuprequest_status', '=', 'mysql_func_' . applicationConstants::INACTIVE, 'AND', true);
        $supReqSrchObj->addMultipleFields(['count(usuprequest_id) as countOfRec']);
        $supReqSrchObj->doNotCalculateRecords();
        $supReqResult = FatApp::getDb()->fetch($supReqSrchObj->getResultset());
        $count = is_array($supReqResult) && isset($supReqResult['countOfRec']) ? $supReqResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_SELLER_APPROVAL, $count);
        return $count;
    }

    /**
     * updateCustomCatalogCount -  Custom catalog requests
     *
     * @return int
     */
    public static function updateCustomCatalogCount(): int
    {
        $custReqSrchObj = ProductRequest::getSearchObject(0, false, true);
        $custReqSrchObj->addCondition('preq_status', '=', 'mysql_func_' . ProductRequest::STATUS_PENDING, 'AND', true);
        $custReqSrchObj->addMultipleFields(array('count(preq_id) as countOfRec'));
        $custReqSrchObj->doNotCalculateRecords();
        $custProdReqResult = FatApp::getDb()->fetch($custReqSrchObj->getResultset());
        $count = is_array($custProdReqResult) && isset($custProdReqResult['countOfRec']) ? $custProdReqResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_CUSTOM_CATALOG, $count);
        return $count;
    }

    /**
     * updateBrandRequestCount -  Brand requests
     *
     * @return int
     */
    public static function updateBrandRequestCount(): int
    {
        $brandReqSrchObj = Brand::getSearchObject(0, true, false, false);
        $brandReqSrchObj->addCondition('brand_status', '=', 'mysql_func_' . Brand::BRAND_REQUEST_PENDING, 'AND', true);
        $brandReqSrchObj->addMultipleFields(array('count(brand_id) as countOfRec'));
        $brandReqSrchObj->doNotCalculateRecords();
        $brandReqResult = FatApp::getDb()->fetch($brandReqSrchObj->getResultset());
        $count = is_array($brandReqResult) && isset($brandReqResult['countOfRec']) ? $brandReqResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_CUSTOM_BRAND, $count);
        return $count;
    }

    /**
     * updateCategoryRequestCount -  Category requests
     *
     * @return int
     */
    public static function updateCategoryRequestCount(): int
    {
        $categoryReqSrchObj = ProductCategory::getSearchObject(false, 0, false, ProductCategory::REQUEST_PENDING);
        $categoryReqSrchObj->addOrder('m.prodcat_active', 'DESC');
        $categoryReqSrchObj->addMultipleFields(array('count(prodcat_id) as countOfRec'));
        $categoryReqSrchObj->doNotCalculateRecords();
        $categoryReqResult = FatApp::getDb()->fetch($categoryReqSrchObj->getResultset());
        $count = is_array($categoryReqResult) && isset($categoryReqResult['countOfRec']) ? $categoryReqResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_PRODUCT_CATEGORY, $count);
        return $count;
    }

    /**
     * updateWithdrawalRequestCount -  Withdrawal requests
     *
     * @return int
     */
    public static function updateWithdrawalRequestCount(): int
    {
        $drReqSrchObj = new WithdrawalRequestsSearch();
        $drReqSrchObj->doNotCalculateRecords();
        $drReqSrchObj->addCondition('withdrawal_status', '=', 'mysql_func_' . applicationConstants::INACTIVE, 'AND', true);
        $drReqSrchObj->addMultipleFields(array('count(withdrawal_id) as countOfRec'));
        $drReqResult = FatApp::getDb()->fetch($drReqSrchObj->getResultset());
        $count = is_array($drReqResult) && isset($drReqResult['countOfRec']) ? $drReqResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_WITHDRAWAL, $count);
        return $count;
    }

    /**
     * updateOrderCancelRequestCount -  Order Cancellation requests
     *
     * @return int
     */
    public static function updateOrderCancelRequestCount(): int
    {
        $orderCancelReqSrchObj = new OrderCancelRequestSearch(CommonHelper::getLangId());
        $orderCancelReqSrchObj->doNotCalculateRecords();
        $orderCancelReqSrchObj->addCondition('ocrequest_status', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $orderCancelReqSrchObj->addMultipleFields(array('count(ocrequest_id) as countOfRec'));
        $orderCancelReqResult = FatApp::getDb()->fetch($orderCancelReqSrchObj->getResultset());
        $count = is_array($orderCancelReqResult) && isset($orderCancelReqResult['countOfRec']) ? $orderCancelReqResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_ORDER_CANCELLATION, $count);
        return $count;
    }

    /**
     * updateBlogContributionRequestCount -  Blog Contribution requests
     *
     * @return int
     */
    public static function updateBlogContributionRequestCount(): int
    {
        $blogContrSrchObj = BlogContribution::getSearchObject();
        $blogContrSrchObj->doNotCalculateRecords();
        $blogContrSrchObj->addCondition('bcontributions_status', '=', 'mysql_func_' . applicationConstants::INACTIVE, 'AND', true);
        $blogContrSrchObj->addMultipleFields(array('count(bcontributions_id) as countOfRec'));
        $blogContrResult = FatApp::getDb()->fetch($blogContrSrchObj->getResultset());
        $count = is_array($blogContrResult) && isset($blogContrResult['countOfRec']) ? $blogContrResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_ORDER_RETURN, $count);
        return $count;
    }

    /**
     * updateBlogCommentRequestCount -  Blog Comments requests
     *
     * @return int
     */
    public static function updateBlogCommentRequestCount(): int
    {
        $blogCommentsSrchObj = BlogComment::getSearchObject();
        $blogCommentsSrchObj->doNotCalculateRecords();
        $blogCommentsSrchObj->addCondition('bpcomment_approved', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $blogCommentsSrchObj->addMultipleFields(array('count(bpcomment_id) as countOfRec'));
        $blogCommentsResult = FatApp::getDb()->fetch($blogCommentsSrchObj->getResultset());
        $count = is_array($blogCommentsResult) && isset($blogCommentsResult['countOfRec']) ? $blogCommentsResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_BLOG_CONTRIBUTIONS, $count);
        return $count;
    }

    /**
     * updateThresholdSelprodRequestCount -  Threshold Seller Product requests
     *
     * @return int
     */
    public static function updateThresholdSelprodRequestCount(): int
    {
        $selProdSrchObj = SellerProduct::getSearchObject(CommonHelper::getLangId());
        $selProdSrchObj->doNotCalculateRecords();
        $selProdSrchObj->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $selProdSrchObj->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'cred.credential_user_id = selprod_user_id', 'cred');
        $selProdSrchObj->joinTable('tbl_email_archives', 'LEFT OUTER JOIN', 'arch.earch_to_email = cred.credential_email', 'arch');
        $selProdSrchObj->addDirectCondition('selprod_stock <= selprod_threshold_stock_level');
        $selProdSrchObj->addDirectCondition('selprod_track_inventory = ' . Product::INVENTORY_TRACK);
        $selProdSrchObj->addMultipleFields(array('count(DISTINCT(selprod_id)) as countOfRec'));
        $threshSelProdResult = FatApp::getDb()->fetch($selProdSrchObj->getResultset());
        $count = is_array($threshSelProdResult) && isset($threshSelProdResult['countOfRec']) ? $threshSelProdResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_BLOG_COMMENTS, $count);
        return $count;
    }

    /**
     * updateGdprRequestCount -  Gdpr requests
     *
     * @return int
     */
    public static function updateGdprRequestCount(): int
    {
        $gdprSrch = new UserGdprRequestSearch();
        $gdprSrch->addCondition('ureq_status', '=', 'mysql_func_' . UserGdprRequest::STATUS_PENDING, 'AND', true);
        $gdprSrch->addCondition('ureq_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $gdprSrch->addMultipleFields(array('count(1) as countOfRec'));
        $gdprSrch->doNotCalculateRecords();
        $gdprResult = FatApp::getDb()->fetch($gdprSrch->getResultset());
        $count = is_array($gdprResult) && isset($gdprResult['countOfRec']) ? $gdprResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_THRESHOLD_LEVEL_PRODUCTS, $count);
        return $count;
    }

    /**
     * updateBadgeRequestCount -  Badge requests
     *
     * @return int
     */
    public static function updateBadgeRequestCount(): int
    {
        $badgeRequest = new SearchBase(BadgeRequest::DB_TBL, 'breq');
        $badgeRequest->joinTable(BadgeLinkCondition::DB_TBL, 'INNER JOIN', 'blinkcond_id = breq_blinkcond_id', 'blc');
        $badgeRequest->joinTable(Badge::DB_TBL, 'INNER JOIN', 'badge_id = blinkcond_badge_id', 'bdg');
        $badgeRequest->addMultipleFields(['count(' . BadgeRequest::DB_TBL_PREFIX . 'id) as countOfRec']);
        $badgeRequest->addCondition(BadgeRequest::DB_TBL_PREFIX . 'status', '=', 'mysql_func_' . BadgeRequest::REQUEST_PENDING, 'AND', true);
        $badgeRequest->doNotCalculateRecords();
        $badgeRequestResult = FatApp::getDb()->fetch($badgeRequest->getResultset());
        $count = is_array($badgeRequestResult) && isset($badgeRequestResult['countOfRec']) ? $badgeRequestResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_USER_GDPR, $count);
        return $count;
    }

    /**
     * updateOrderReturnRequestCount -  Order Return requests
     *
     * @return int
     */
    public static function updateOrderReturnRequestCount(): int
    {
        $orderRetReqSrchObj = OrderReturnRequest::getSearchObject();
        $orderRetReqSrchObj->addCondition('orrequest_status', '=', 'mysql_func_' . OrderReturnRequest::RETURN_REQUEST_STATUS_PENDING, 'AND', true);
        $orderRetReqSrchObj->addMultipleFields(array('count(orrequest_id) as countOfRec'));
        $orderRetReqSrchObj->doNotCalculateRecords();
        $orderRetReqResult = FatApp::getDb()->fetch($orderRetReqSrchObj->getResultset());
        $count = is_array($orderRetReqResult) && isset($orderRetReqResult['countOfRec']) ? $orderRetReqResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_BADGE, $count);
        return $count;
    }

    /**
     * updateSelprodRequestCount -  Seller product/catalog requests
     *
     * @return int
     */
    public static function updateSelprodRequestCount(): int
    {
        $srch = Product::getSearchObject();
        $srch->addCondition('product_approved', '=', Product::UNAPPROVED);
        $srch->addCondition('product_seller_id', '>', 0);
        $srch->addMultipleFields(array('count(1) as countOfRec'));
        $srch->doNotCalculateRecords();
        $selProdReqResult = FatApp::getDb()->fetch($srch->getResultset());
        $count = is_array($selProdReqResult) && isset($selProdReqResult['countOfRec']) ? $selProdReqResult['countOfRec'] : 0;
        CalculativeData::updateValue(CalculativeData::KEY_SELLER_PRODUCT, $count);
        return $count;
    }
}
