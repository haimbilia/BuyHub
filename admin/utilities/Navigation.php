<?php
class Navigation
{
    public static function setLeftNavigationVals($template)
    {
        $db = FatApp::getDb();
        $langId = CommonHelper::getLangId();
        $userObj = new User();

        /* seller approval requests */
        $supReqSrchObj = $userObj->getUserSupplierRequestsObj();
        $supReqSrchObj->addCondition('usuprequest_status', '=', 'mysql_func_' . applicationConstants::INACTIVE, 'AND', true);
        $supReqSrchObj->addMultipleFields(array('count(usuprequest_id) as countOfRec'));
        $supReqSrchObj->doNotCalculateRecords();
        // $supReqSrchObj->doNotLimitRecords();
        $supReqSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $supReqResult = $db->fetch($supReqSrchObj->getResultset());
        $supReqCount = FatUtility::int($supReqResult['countOfRec']);

        /* Custom catalog requests */
        $custReqSrchObj = ProductRequest::getSearchObject(0, false, true);
        $custReqSrchObj->addCondition('preq_status', '=', 'mysql_func_' . ProductRequest::STATUS_PENDING, 'AND', true);
        $custReqSrchObj->addMultipleFields(array('count(preq_id) as countOfRec'));
        $custReqSrchObj->doNotCalculateRecords();
        $custReqSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $custProdReqResult = $db->fetch($custReqSrchObj->getResultset());
        $custProdReqCount = FatUtility::int($custProdReqResult['countOfRec']);

        /* Custom brand requests */
        $brandReqSrchObj = Brand::getSearchObject(0, true, false);
        $brandReqSrchObj->addCondition('brand_status', '=', 'mysql_func_' . Brand::BRAND_REQUEST_PENDING, 'AND', true);
        $brandReqSrchObj->addMultipleFields(array('count(brand_id) as countOfRec'));
        $brandReqSrchObj->doNotCalculateRecords();
        $brandReqSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $brandReqResult = $db->fetch($brandReqSrchObj->getResultset());
        $brandReqCount = FatUtility::int($brandReqResult['countOfRec']);

        /* Product category requests */
        $categoryReqSrchObj = ProductCategory::getSearchObject(false, 0, false, ProductCategory::REQUEST_PENDING);
        $categoryReqSrchObj->addOrder('m.prodcat_active', 'DESC');
        $categoryReqSrchObj->addMultipleFields(array('count(prodcat_id) as countOfRec'));
        $categoryReqSrchObj->doNotCalculateRecords();
        $categoryReqSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $categoryReqResult = $db->fetch($categoryReqSrchObj->getResultset());
        $categoryReqCount = FatUtility::int($categoryReqResult['countOfRec']);

        /* withdrawal requests */
        $drReqSrchObj = new WithdrawalRequestsSearch();
        $drReqSrchObj->doNotCalculateRecords();
        $drReqSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $drReqSrchObj->addCondition('withdrawal_status', '=', 'mysql_func_' . applicationConstants::INACTIVE, 'AND', true);
        $drReqSrchObj->addMultipleFields(array('count(withdrawal_id) as countOfRec'));
        $drReqResult = $db->fetch($drReqSrchObj->getResultset());
        $drReqCount = FatUtility::int($drReqResult['countOfRec']);

        /* order cancellation requests */
        $orderCancelReqSrchObj = new OrderCancelRequestSearch($langId);
        $orderCancelReqSrchObj->doNotCalculateRecords();
        $orderCancelReqSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $orderCancelReqSrchObj->addCondition('ocrequest_status', '=', 'mysql_func_' . applicationConstants::INACTIVE, 'AND', true);
        $orderCancelReqSrchObj->addMultipleFields(array('count(ocrequest_id) as countOfRec'));
        $orderCancelReqResult = $db->fetch($orderCancelReqSrchObj->getResultset());
        $orderCancelReqCount = FatUtility::int($orderCancelReqResult['countOfRec']);

        /* order return/refund requests */
        $orderRetReqSrchObj = new OrderReturnRequestSearch();
        $orderRetReqSrchObj->doNotCalculateRecords();
        $orderRetReqSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $orderRetReqSrchObj->addCondition('orrequest_status', '=', 'mysql_func_' . applicationConstants::INACTIVE, 'AND', true);
        $orderRetReqSrchObj->addMultipleFields(array('count(orrequest_id) as countOfRec'));
        $orderRetReqResult = $db->fetch($orderRetReqSrchObj->getResultset());
        $orderRetReqCount = FatUtility::int($orderRetReqResult['countOfRec']);

        /* blog contributions */
        $blogContrSrchObj = BlogContribution::getSearchObject();
        $blogContrSrchObj->doNotCalculateRecords();
        $blogContrSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $blogContrSrchObj->addCondition('bcontributions_status', '=', 'mysql_func_' . applicationConstants::INACTIVE, 'AND', true);
        $blogContrSrchObj->addMultipleFields(array('count(bcontributions_id) as countOfRec'));
        $blogContrResult = $db->fetch($blogContrSrchObj->getResultset());
        $blogContrCount = FatUtility::int($blogContrResult['countOfRec']);

        /* blog comments */
        $blogCommentsSrchObj = BlogComment::getSearchObject();
        $blogCommentsSrchObj->doNotCalculateRecords();
        $blogCommentsSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $blogCommentsSrchObj->addCondition('bpcomment_approved', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $blogCommentsSrchObj->addMultipleFields(array('count(bpcomment_id) as countOfRec'));
        $blogCommentsResult = $db->fetch($blogCommentsSrchObj->getResultset());
        $blogCommentsCount = FatUtility::int($blogCommentsResult['countOfRec']);

        /* threshold level products */
        $selProdSrchObj = SellerProduct::getSearchObject($langId);
        $selProdSrchObj->doNotCalculateRecords();
        $selProdSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);

        $selProdSrchObj->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        // $selProdSrchObj->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = '.CommonHelper::getLangId(), 'p_l');
        $selProdSrchObj->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'cred.credential_user_id = selprod_user_id', 'cred');
        $selProdSrchObj->joinTable('tbl_email_archives', 'LEFT OUTER JOIN', 'arch.earch_to_email = cred.credential_email', 'arch');
        $selProdSrchObj->addDirectCondition('selprod_stock <= selprod_threshold_stock_level');
        $selProdSrchObj->addDirectCondition('selprod_track_inventory = ' . Product::INVENTORY_TRACK);

        // $selProdSrchObj->addCondition('earch_tpl_name', 'LIKE', 'threshold_notification_vendor_custom');
        $selProdSrchObj->addMultipleFields(array('count(DISTINCT(selprod_id)) as countOfRec'));
        $threshSelProdResult = $db->fetch($selProdSrchObj->getResultset());
        $threshSelProdCount = FatUtility::int($threshSelProdResult['countOfRec']);

        /* seller orders */
        /* $sellerOrderStatus = FatApp::getConfig('CONF_BADGE_COUNT_ORDER_STATUS', FatUtility::VAR_STRING, '0');
        if ($sellerOrderStatus && $sellerOrderStatusArr = (array)unserialize($sellerOrderStatus)) {
            $sellerOrderSrchObj = new OrderProductSearch($langId, true, false);
            $sellerOrderSrchObj->addStatusCondition($sellerOrderStatusArr);
            $sellerOrderSrchObj->addMultipleFields(array('count(op_id) as countOfRec'));
            $sellerOrderSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
            $sellerOrderResult = $db->fetch($sellerOrderSrchObj->getResultset());
            $sellerOrderCount = FatUtility::int($sellerOrderResult['countOfRec']);
            $template->set('sellerOrderCount', $sellerOrderCount);
        } */

        /* User GDPR requests */
        $gdprSrch = new UserGdprRequestSearch();
        $gdprSrch->addCondition('ureq_status', '=', 'mysql_func_' . UserGdprRequest::STATUS_PENDING, 'AND', true);
        $gdprSrch->addCondition('ureq_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $gdprSrch->getResultSet();
        $gdprSrch->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $gdprReqCount = $gdprSrch->recordCount();

        /* Badge requests */
        $badgeRequest = new SearchBase(BadgeRequest::DB_TBL, 'breq');
        $badgeRequest->joinTable(BadgeLinkCondition::DB_TBL, 'INNER JOIN', 'blinkcond_id = breq_blinkcond_id', 'blc');
        $badgeRequest->joinTable(Badge::DB_TBL, 'INNER JOIN', 'badge_id = blinkcond_badge_id', 'bdg');
        $badgeRequest->addMultipleFields(['count(' . BadgeRequest::DB_TBL_PREFIX . 'id) as countOfRec']);
        $badgeRequest->addCondition(BadgeRequest::DB_TBL_PREFIX . 'status', '=', 'mysql_func_' . BadgeRequest::REQUEST_PENDING, 'AND', true);
        $badgeRequest->doNotCalculateRecords();
        $badgeRequest->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $badgeRequestResult = $db->fetch($badgeRequest->getResultset());
        $badgeRequestCount = FatUtility::int($badgeRequestResult['countOfRec']);

        /* Order return requests */
        $orderRetReqSrchObj = OrderReturnRequest::getSearchObject();
        $orderRetReqSrchObj->addCondition('orrequest_status', '=', 'mysql_func_' . OrderReturnRequest::RETURN_REQUEST_STATUS_PENDING, 'AND', true);
        $orderRetReqSrchObj->addMultipleFields(array('count(orrequest_id) as countOfRec'));
        $orderRetReqSrchObj->doNotCalculateRecords();
        $orderRetReqSrchObj->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $orderRetReqResult = $db->fetch($orderRetReqSrchObj->getResultset());
        $orderRetReqCount = FatUtility::int($orderRetReqResult['countOfRec']);

        /* Seller product requests */
        $srch = Product::getSearchObject();
        $srch->addCondition('product_approved', '=', Product::UNAPPROVED);
        $srch->addCondition('product_seller_id', '>', 0);
        $srch->addMultipleFields(array('count(1) as countOfRec'));
        $srch->doNotCalculateRecords();
        $srch->setPageSize(HtmlHelper::RECORD_COUNT_LIMIT);
        $selProdReqResult = $db->fetch($srch->getResultset());
        $selProdReqCount = FatUtility::int($selProdReqResult['countOfRec']);


        /* set counter variables [ */
        $template->set('brandReqCount', $brandReqCount);
        $template->set('categoryReqCount', $categoryReqCount);
        $template->set('custProdReqCount', $custProdReqCount);
        $template->set('badgeRequestCount', $badgeRequestCount);
        $template->set('supReqCount', $supReqCount);
        $template->set('selProdReqCount', $selProdReqCount);
        $template->set('drReqCount', $drReqCount);
        $template->set('orderCancelReqCount', $orderCancelReqCount);
        $template->set('orderRetReqCount', $orderRetReqCount);
        $template->set('blogContrCount', $blogContrCount);
        $template->set('blogCommentsCount', $blogCommentsCount);
        $template->set('threshSelProdCount', $threshSelProdCount);
        $template->set('gdprReqCount', $gdprReqCount);
        $template->set('orderRetReqCount', $orderRetReqCount);
        $template->set('siteLangId', CommonHelper::getLangId());
        /* ] */

        $template->set('objPrivilege', AdminPrivilege::getInstance());
        $template->set('adminName', AdminAuthentication::getLoggedAdminAttribute("admin_name"));
    }
}
