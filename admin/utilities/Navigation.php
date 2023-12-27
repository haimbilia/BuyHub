<?php
class Navigation
{
    public static function setLeftNavigationVals($template)
    {
        CalculativeDataRecord::loadAllValues(CalculativeData::TYPE_REQUESTS);

        /* seller approval requests */
        $supReqCount = CalculativeDataRecord::getValue(CalculativeData::KEY_SELLER_APPROVAL);

        /* Custom catalog requests */
        $custProdReqCount = CalculativeDataRecord::getValue(CalculativeData::KEY_CUSTOM_CATALOG);

        /* Custom brand requests */
        $brandReqCount = CalculativeDataRecord::getValue(CalculativeData::KEY_CUSTOM_BRAND);

        /* Product category requests */
        $categoryReqCount = CalculativeDataRecord::getValue(CalculativeData::KEY_PRODUCT_CATEGORY);

        /* withdrawal requests */
        $drReqCount = CalculativeDataRecord::getValue(CalculativeData::KEY_WITHDRAWAL);

        /* order cancellation requests */
        $orderCancelReqCount = CalculativeDataRecord::getValue(CalculativeData::KEY_ORDER_CANCELLATION);

        /* blog contributions */
        $blogContrCount = CalculativeDataRecord::getValue(CalculativeData::KEY_ORDER_RETURN);

        /* blog comments */
        $blogCommentsCount = CalculativeDataRecord::getValue(CalculativeData::KEY_BLOG_CONTRIBUTIONS);

        /* threshold level products */
        $threshSelProdCount = CalculativeDataRecord::getValue(CalculativeData::KEY_BLOG_COMMENTS);

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
        $gdprReqCount = CalculativeDataRecord::getValue(CalculativeData::KEY_THRESHOLD_LEVEL_PRODUCTS);

        /* Badge requests */
        $badgeRequestCount = CalculativeDataRecord::getValue(CalculativeData::KEY_USER_GDPR);

        /* Order return requests */
        $orderRetReqCount = CalculativeDataRecord::getValue(CalculativeData::KEY_BADGE);

        /* Seller product requests */
        $selProdReqCount = CalculativeDataRecord::getValue(CalculativeData::KEY_SELLER_PRODUCT);


        /* set counter variables [ */
        $template->set('brandReqCount', $brandReqCount);
        $template->set('categoryReqCount', $categoryReqCount);
        $template->set('custProdReqCount', $custProdReqCount);
        $template->set('badgeRequestCount', $badgeRequestCount);
        $template->set('supReqCount', $supReqCount);
        $template->set('selProdReqCount', $selProdReqCount);
        $template->set('drReqCount', $drReqCount);
        $template->set('orderCancelReqCount', $orderCancelReqCount);
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
