<?php

class HomeController extends ListingBaseController
{
    protected $pageKey = 'DASHBOARD';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->defaultStatsInterval = Statistics::BY_THIS_MONTH;
        if ('index' != $action) {
            $this->objPrivilege->canViewAdminDashboard($this->admin_id);
        }
    }

    public function index()
    {
        $accountId = false;
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        if (false == $this->objPrivilege->canViewAdminDashboard($this->admin_id, true)) {
            $this->set('pageTitle', $pageTitle);
            $this->set('canViewAdminDashboard', false);
            $this->_template->render();
            return;
        }

        $statsObj = new Statistics();
        $analyticArr = array(
            'clientId' => FatApp::getConfig("CONF_ANALYTICS_CLIENT_ID", FatUtility::VAR_STRING, ''),
            'clientSecretKey' => FatApp::getConfig("CONF_ANALYTICS_SECRET_KEY", FatUtility::VAR_STRING, ''),
            'redirectUri' => UrlHelper::generateFullUrl('configurations', 'redirect', array(), '', false),
            'googleAnalyticsID' => FatApp::getConfig("CONF_ANALYTICS_ID", FatUtility::VAR_STRING, '')
        );

        // simple Caching with:        
        $dashboardInfoCache = FatCache::get('dashboardInfoCache' . $this->siteLangId, CONF_HOME_PAGE_CACHE_TIME, '.txt');
        //$dashboardInfo = array();
        if (!$dashboardInfoCache) {
            include_once CONF_INSTALLATION_PATH . 'library/analytics/analyticsapi.php';
            try {
                if (1 == FatApp::getConfig('CONF_GOOGLE_ANALYTICS_4', FatUtility::VAR_INT, 0)) {
                    include_once(CONF_INSTALLATION_PATH . 'library/ga4/autoloader.php');
                    $analytics = new Analytics();
                } else {
                    $analytics = new Ykart_analytics($analyticArr);
                    $token = $analytics->getRefreshToken(FatApp::getConfig("CONF_ANALYTICS_ACCESS_TOKEN"));

                    $analytics->setAccessToken((isset($token['accessToken'])) ? $token['accessToken'] : '');

                    $accountId = $analytics->setAccountId(FatApp::getConfig("CONF_ANALYTICS_ID"));
                    if (!$accountId) {
                        Message::addErrorMessage(Labels::getLabel('ERR_ANALYTIC_ID_DOES_NOT_EXIST_WITH_CONFIGURED_ACCOUNT', $this->siteLangId));
                    } else {
                        $this->set('configuredAnalytics', true);
                    }
                }
            } catch (exception $e) {
                /* Message::addErrorMessage(Labels::getLabel('ERR_ANALYTIC_ID_DOES_NOT_EXIST_WITH_CONFIGURED_ACCOUNT',$this->siteLangId)); */
                //Message::addErrorMessage($e->getMessage());
            }

            if ($accountId) {
                $statsInfo = $analytics->getVisitsByDate();

                $chatStats = array();
                if (!empty($statsInfo['stats'])) {
                    $chatStats = "[['" . Labels::getLabel('LBL_Year', $this->siteLangId) . "', '" . Labels::getLabel('LBL_Today', $this->siteLangId) . "','" . Labels::getLabel('LBL_PAST_7_DAYS', $this->siteLangId) . "','" . Labels::getLabel('LBL_Last_Month', $this->siteLangId) . "','" . Labels::getLabel('LBL_Last_3_Month', $this->siteLangId) . "'],";
                    foreach ($statsInfo['stats'] as $key => $val) {
                        if ($key == '') {
                            continue;
                        }

                        $chatStats .= "['" . FatDate::format($key) . "',";
                        $chatStats .= isset($val['today']['visit']) ? FatUtility::int($val['today']['visit']) : 0;
                        $chatStats .= ',';
                        $chatStats .= isset($val['weekly']['visit']) ? FatUtility::int($val['weekly']['visit']) : 0;
                        $chatStats .= ',';
                        $chatStats .= isset($val['lastMonth']['visit']) ? FatUtility::int($val['lastMonth']['visit']) : 0;
                        $chatStats .= ',';
                        $chatStats .= isset($val['last3Month']['visit']) ? FatUtility::int($val['last3Month']['visit']) : 0;
                        $chatStats .= ',';
                    }
                }
                $chatStats = rtrim($chatStats, ',');
                $visits_chart_data = $chatStats .= "]";
                $visitCount = $statsInfo['result'];
                foreach ($statsInfo['result'] as $key => $val) {
                    $visitCount[$key] = $val['totalsForAllResults'] ?? 0;
                }
            }

            /* Conversion Stats [*/
            $conversionStats = $statsObj->getConversionStats();
            $conversionChatData = "['Type','user',{ role: 'style' }],";
            foreach ($conversionStats as $key => $val) {
                $key = Labels::getLabel('LBL_' . ucwords($key), $this->siteLangId);
                $conversionChatData .= "['" . $key . "', " . $val["count"] . ",'#AEC785'],";
            }
            $conversionChatData = rtrim($conversionChatData, ',');
            $dashboardInfo['conversionChatData'] = $conversionChatData;
            $dashboardInfo['conversionStats'] = $conversionStats;
            /* ] */

            /* Statistics [*/
            $salesData = $statsObj->getDashboardLast12MonthsSummary($this->siteLangId, 'sales', array(), 6);
            $salesChartData = array();
            foreach ($salesData as $key => $val) {
                $salesChartData[$val["duration"]] = $val["value"];
            }

            $salesEarningsData = $statsObj->getDashboardLast12MonthsSummary($this->siteLangId, 'earnings', array(), 6);
            $salesEarningsChartData = [];
            foreach ($salesEarningsData as $key => $val) {
                $salesEarningsChartData[$val["duration"]] = $val["value"];
            }

            $signupsData = $statsObj->getDashboardLast12MonthsSummary($this->siteLangId, 'signups', array('user_is_buyer' => 1, 'user_is_supplier' => 1), 6);
            $signupsChartData = [];
            foreach ($signupsData as $key => $val) {
                $signupsChartData[$val["duration"]] = $val["value"];
            }

            $affiliateSignupsData = $statsObj->getDashboardLast12MonthsSummary($this->siteLangId, 'signups', array('user_is_affiliate' => 1), 6);
            $affiliateSignupsChartData = array();
            foreach ($affiliateSignupsData as $key => $val) {
                $affiliateSignupsChartData[$val["duration"]] = $val["value"];
            }

            $productsData = $statsObj->getDashboardLast12MonthsSummary($this->siteLangId, 'products', array(), 6);
            $productsChartData = [];
            foreach ($productsData as $key => $val) {
                $productsChartData[$val["duration"]] = $val["value"];
            }

            if (CommonHelper::getLayoutDirection() != 'rtl') {
                $dashboardInfo['salesChartData'] = array_reverse($salesChartData);
                $dashboardInfo['salesEarningsChartData'] = array_reverse($salesEarningsChartData);
                $dashboardInfo['signupsChartData'] = array_reverse($signupsChartData);
                $dashboardInfo['affiliateSignupsChartData'] = array_reverse($affiliateSignupsChartData);
                $dashboardInfo['productsChartData'] = array_reverse($productsChartData);
            } else {
                $dashboardInfo['salesChartData'] = $salesChartData;
                $dashboardInfo['salesEarningsChartData'] = $salesEarningsChartData;
                $dashboardInfo['signupsChartData'] = $signupsChartData;
                $dashboardInfo['affiliateSignupsChartData'] = $affiliateSignupsChartData;
                $dashboardInfo['productsChartData'] = $productsChartData;
            }
            /* ] */

            $dashboardInfo['visits_chart_data'] = isset($visits_chart_data) ? rtrim($visits_chart_data, ',') : '';
            $dashboardInfo['visitsCount'] = (isset($visitCount)) ? $visitCount : '';
            $dashboardInfo['conversionChatData'] = $conversionChatData;
            $dashboardInfo['conversionStats'] = $conversionStats;
            FatCache::set('dashboardInfoCache' . $this->siteLangId, serialize($dashboardInfo), '.txt');
            //$cache->set("dashboardInfo" . $this->siteLangId, $dashboardInfo, 24 * 60 * 60);
        } else {
            $dashboardInfo =  unserialize($dashboardInfoCache);
        }

        //$saleStats = Stats::getTotalSalesStats();
        $this->_template->addJs(array('js/chartist.min.js'));
        $this->_template->addCss(array('css/chartist.css'));

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false) {
            $this->_template->addCss('css/ie.css');
        }
        $this->set('dashboardInfo', $dashboardInfo);
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('configuredAnalytics', false);
        $this->set('objPrivilege', $this->objPrivilege);
        $this->set('intervalsArr', Statistics::getIntervals($this->siteLangId));
        $this->set('defaultStatsInterval', $this->defaultStatsInterval);
        $this->set('canViewAdminDashboard', $this->objPrivilege->canViewAdminDashboard($this->admin_id, true));
        $this->_template->render();
    }

    public function totalSales()
    {
        $interval = FatApp::getPostedData('interval', FatUtility::VAR_INT, $this->defaultStatsInterval);
        $statsObj = new Statistics();
        $orderSalesStats = $statsObj->getOrderSalesStats($interval);
        $shopsSignupStats = $statsObj->getShopsSignupStats($interval);
        $userSignupStats = $statsObj->getUserSignupStats($interval);

        $this->set('orderSalesStats', $orderSalesStats[$interval]);
        $this->set('shopsSignupStats', $shopsSignupStats[$interval]);
        $this->set('userSignupStats', $userSignupStats[$interval]);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function searchStatistics()
    {
        $post = FatApp::getPostedData();
        $type = $post['type'];

        $statsObj = new Statistics();
        $dashboardInfo = array();

        switch (strtolower($type)) {
            case 'statistics':
                $dashboardInfo["stats"]["totalUsers"] = $statsObj->getStats('total_members');
                $dashboardInfo["stats"]["totalSellerProducts"] = $statsObj->getStats('total_seller_products');
                $dashboardInfo["stats"]["totalShops"] = $statsObj->getStats('total_shops');
                $dashboardInfo["stats"]["totalOrders"] = $statsObj->getStats('total_orders');
                $dashboardInfo["stats"]["totalSales"] = $statsObj->getStats('total_sales');
                $dashboardInfo["stats"]["totalWithdrawalRequests"] = $statsObj->getStats('total_withdrawal_requests');
                $dashboardInfo["stats"]["totalAffiliateCommission"] = $statsObj->getStats('total_affiliate_commission');
                $dashboardInfo["stats"]["totalPpc"] = $statsObj->getStats('total_ppc_earnings');
                $dashboardInfo["stats"]["subscriptionEarnings"] = $statsObj->getStats('total_subscription_earnings');
                $dashboardInfo["stats"]["affiliateWithdrawalRequest"] = $statsObj->getStats('total_affiliate_withdrawal_requests');
                $dashboardInfo["stats"]["productReviews"] = $statsObj->getStats('total_product_reviews');
                break;
            case 'sellerproducts':
                $srch = new ProductSearch($this->siteLangId);
                $srch->doNotCalculateRecords();
                $srch->setPageNumber(1);
                $srch->setPageSize(10);
                $srch->setDefinedCriteria(0);
                $srch->joinProductToCategory();
                $srch->addMultipleFields(array('selprod_title', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(brand_name, brand_identifier) as brand_name', 'IFNULL(shop_name, shop_identifier) as shop_name', 'theprice', 'selprod_stock'));
                /* groupby added, because if same product is linked with multiple categories, then showing in repeat for each category[ */
                $srch->addGroupBy('selprod_id');
                $srch->addOrder('selprod_added_on', 'DESC');
                /* ] */
                $rs = $srch->getResultSet();
                $sellerProductsList = FatApp::getDb()->fetchAll($rs);
                $dashboardInfo['sellerProductsList'] = $sellerProductsList;
                break;
            case 'shops':
                $srch = new ShopSearch($this->siteLangId);
                $srch->setDefinedCriteria($this->siteLangId, 0);
                $srch->doNotCalculateRecords();
                $srch->setPageNumber(1);
                $srch->setPageSize(10);
                $srch->addOrder('shop_created_on', 'DESC');
                $srch->addMultipleFields(
                    array(
                        'IFNULL(shop_name, shop_identifier) as shop_name',
                        'credential_username as shop_owner_username', 'shop_created_on', 'shop_active'
                    )
                );

                $rs = $srch->getResultSet();
                $dashboardInfo['shopsList'] = FatApp::getDb()->fetchAll($rs);
                break;
            case 'signups':
                $userObj = new User();
                $srch = $userObj->getUserSearchObj();
                $srch->doNotCalculateRecords();
                $srch->addOrder('u.user_id', 'DESC');
                $cnd = $srch->addCondition('u.user_is_supplier', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                $cnd->attachCondition('u.user_is_buyer', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                $srch->addMultipleFields(
                    array(
                        'user_name', 'credential_username', 'credential_email', 'user_phone_dcode', 'user_phone',
                        'user_regdate', 'user_is_buyer', 'user_is_supplier'
                    )
                );
                $srch->setPageNumber(1);
                $srch->setPageSize(10);
                $rs = $srch->getResultSet();
                $buyerSellerList = FatApp::getDb()->fetchAll($rs);
                $dashboardInfo['buyerSellerList'] = $buyerSellerList;
                break;
            case 'advertisers':
                $userObj = new User();
                $srch = $userObj->getUserSearchObj();
                $srch->doNotCalculateRecords();
                $srch->addOrder('u.user_id', 'DESC');
                $srch->addCondition('u.user_is_advertiser', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                $srch->addCondition('u.user_parent', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
                $srch->addMultipleFields(array('user_name', 'credential_username', 'credential_email', 'user_phone_dcode', 'user_phone', 'user_regdate'));
                $srch->setPageNumber(1);
                $srch->setPageSize(10);
                $rs = $srch->getResultSet();
                $advertisersList = FatApp::getDb()->fetchAll($rs);
                $dashboardInfo['advertisersList'] = $advertisersList;
                break;
            case 'affiliates':
                $userObj = new User();
                $srch = $userObj->getUserSearchObj();
                $srch->doNotCalculateRecords();
                $srch->addOrder('u.user_id', 'DESC');
                $srch->addCondition('u.user_is_affiliate', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                $srch->addMultipleFields(array('user_name', 'credential_username', 'credential_email', 'user_phone_dcode', 'user_phone', 'user_regdate'));
                $srch->setPageNumber(1);
                $srch->setPageSize(10);
                $rs = $srch->getResultSet();
                $affiliatesList = FatApp::getDb()->fetchAll($rs);
                $dashboardInfo['affiliatesList'] = $affiliatesList;
                break;
        }

        $this->set('type', $type);
        $this->set('dashboardInfo', $dashboardInfo);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function latestOrders($limit = 5)
    {
        $dashboardInfo = array();
        $srch = new OrderSearch();
        $srch->joinOrderBuyerUser();
        $srch->addOrder('order_date_added', 'DESC');
        $srch->addCondition('order_type', '=', 'mysql_func_' . Orders::ORDER_PRODUCT, 'AND', true);
        $srch->setPageSize($limit);
        $srch->addMultipleFields(array('order_id', 'order_number', 'order_date_added', 'order_payment_status', 'buyer.user_name as buyer_user_name', 'buyer.user_updated_on as buyer_updated_on', 'buyer_cred.credential_username as buyer_credential_username', 'buyer_cred.credential_email as buyer_credential_email', 'order_user_id',  'order_net_amount'));
        $rs = $srch->getResultSet();
        $ordersList = FatApp::getDb()->fetchAll($rs);
        $dashboardInfo['recentOrders'] = $ordersList;
        $dashboardInfo['orderPaymentStatusArr'] = Orders::getOrderPaymentStatusArr($this->siteLangId);
        $this->set('dashboardInfo', $dashboardInfo);
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function topSellingProducts($limit = 5)
    {
        $srch = new OrderProductSearch($this->siteLangId, true);
        $srch->joinPaymentMethod();
        $srch->joinSellerProducts();
        $srch->joinShop();
        $cnd = $srch->addCondition('order_payment_status', '=', 'mysql_func_' . Orders::ORDER_PAYMENT_PAID, 'AND', true);
        $cnd->attachCondition('plugin_code', '=', 'cashondelivery');
        $cnd->attachCondition('plugin_code', '=', 'payatstore');
        $srch->addStatusCondition(unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS")));
        $srch->setPageSize($limit);
        $srch->addOrder('SUM(op_qty - op_refund_qty)', 'DESC');
        $srch->addMultipleFields(array('op_selprod_title', 'order_id', 'op_product_name as product_name', 'op_selprod_options', 'op_brand_name', 'SUM(op_qty - op_refund_qty) as totSoldQty', 'op.op_selprod_id', 'op_selprod_sku', 'op_shop_name', 'op_selprod_id', 'shop_id', 'SUBSTRING( op.op_selprod_code, 1, (LOCATE( "_", op.op_selprod_code ) - 1 ) ) as product_id'));
        $srch->addGroupBy('op.op_selprod_id');
        $srch->addHaving('totSoldQty', '>', 0);
        $srch->doNotCalculateRecords();       
        $rs = $srch->getResultSet();
        $productsList = FatApp::getDb()->fetchAll($rs);

        $this->set('productsList', $productsList);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function dashboardStats()
    {
        $post = FatApp::getPostedData();
        $type = $post['rtype'];
        $interval = isset($post['interval']) ? $post['interval'] : '';

        $dashboardInfoCache = FatCache::get("dashboardInfo_" . $type . '_' . $interval . '_' . $this->siteLangId, CONF_HOME_PAGE_CACHE_TIME, '.txt');
        //$result = $cache->get("dashboardInfo_" . $type . '_' . $interval . '_' . $this->siteLangId);        
        if (!$dashboardInfoCache) {
            $result = [];
            if (strtoupper($type) == 'TOP_PRODUCTS') {
                $statsObj = new Statistics();
                $result = $statsObj->getTopProducts($interval, $this->siteLangId, 10);
            } else if (strtoupper($type) == 'TOP_SEARCH_KEYWORD') {
                $statsObj = new Statistics();
                $result = $statsObj->getTopSearchKeywords($interval, 10);
            } else {
                try {
                    if (1 == FatApp::getConfig('CONF_GOOGLE_ANALYTICS_4', FatUtility::VAR_INT, 0)) {
                        include_once(CONF_INSTALLATION_PATH . 'library/ga4/autoloader.php');
                        $analytics = new Analytics();
                    } else {
                        include_once CONF_INSTALLATION_PATH . 'library/analytics/analyticsapi.php';
                        $analyticArr = array(
                            'clientId' => FatApp::getConfig("CONF_ANALYTICS_CLIENT_ID"),
                            'clientSecretKey' => FatApp::getConfig("CONF_ANALYTICS_SECRET_KEY"),
                            'redirectUri' => UrlHelper::generateFullUrl('configurations', 'redirect', array(), '', false),
                            'googleAnalyticsID' => FatApp::getConfig("CONF_ANALYTICS_ID")
                        );
                        
                        $analytics = new Ykart_analytics($analyticArr);
                        $token = $analytics->getRefreshToken(FatApp::getConfig("CONF_ANALYTICS_ACCESS_TOKEN"));
                        if (isset($token['accessToken'])) {
                            $analytics->setAccessToken($token['accessToken']);
                        }
                        $analytics->setAccountId(FatApp::getConfig("CONF_ANALYTICS_ID"));
                    }

                    switch (strtoupper($type)) {
                        case 'TOP_COUNTRIES':
                            $result = $analytics->getTopCountries($interval, 9);
                            break;
                        case 'TOP_REFERRERS':
                            $result = $analytics->getTopReferrers($interval, 9);
                            break;
                            /* case 'TOP_SEARCH_KEYWORD':
                            $statsObj = new Statistics();
                            $result = $statsObj->getTopSearchKeywords($interval, 10);
                            break; */
                        case 'TRAFFIC_SOURCE':
                            $result = $analytics->getTrafficSource($interval);
                            break;
                        case 'VISITORS_STATS':
                            $result = $analytics->getVisitsByDate();
                            break;
                            /* case 'TOP_PRODUCTS':
                            $statsObj = new Statistics();
                            $result = $statsObj->getTopProducts($interval, $this->siteLangId, 10);
                            break; */
                    }
                } catch (exception $e) {
                    $str = "<li class='list-stats-item'>" . $e->getMessage() . "</li>";
                    $this->set('html', $str);
                    $this->set('analyticsError', 1);
                    $this->_template->render(false, false, 'json-success.php', true, false);
                }
            }
            if (!empty($result)) {
                FatCache::set("dashboardInfo_" . $type . '_' . $interval . '_' . $this->siteLangId, serialize($result), '.txt');
            }
            // $cache->set("dashboardInfo_" . $type . '_' . $interval . '_' . $this->siteLangId, $result, 6 * 60 * 60);
        } else {
            $result = unserialize($dashboardInfoCache);
        }
        $this->set('stats_type', strtoupper($type));
        $this->set('stats_info', $result);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function clear()
    {
        CommonHelper::recursiveDelete(CONF_UPLOADS_PATH . "caching");
        FatCache::clearAll();
        if (Labels::isAPCUcacheAvailable()) {
            apcu_clear_cache();
        }

        $languages = Language::getAllNames();
        foreach ($languages as $langId => $lang) {
            $manifestFile = CONF_UPLOADS_PATH . '/manifest-' . $langId . '.json';
            if (file_exists($manifestFile)) {
                unlink($manifestFile);
            }
        }

        /* $cacheKey = rtrim(CONF_UPLOADS_PATH, '/') . '/cache_keys.txt';
        if (file_exists($cacheKey)) {
            unlink($cacheKey);
        } */

        Product::updateMinPrices();
        if (CommonHelper::demoUrl()) {
            $str = file_get_contents('https://' . $_SERVER['SERVER_NAME'] . '/admin/admin-users/createProcedures');
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_CACHE_HAS_BEEN_CLEARED', $this->siteLangId));
        //FatApp::redirectUser(UrlHelper::generateUrl("home"));
    }
    public function setLanguage($langId = 0)
    {
        $langId = FatUtility::int($langId);
        if (1 > $langId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_ANY_LANGUAGE', $this->siteLangId), true);
        }
        $languages = Language::getAllNames();
        if (array_key_exists($langId, $languages)) {
            setcookie('defaultAdminSiteLang', $langId, time() + 3600 * 24 * 10, CONF_WEBROOT_FRONT_URL);
        }
        $this->set('msg', Labels::getLabel('MSG_PLEASE_WAIT_WE_ARE_REDIRECTING_YOU...', $this->siteLangId));
        $this->set('langId', $langId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function segregateUrl()
    {
        $url = FatApp::getPostedData('url', FatUtility::VAR_STRING, '');
        if (empty($url)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $segments = CommonHelper::segregateUrl($url);
        if (empty($segments)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_URL', $this->siteLangId), true);
        }

        $data = [
            'controller' => $segments[0] ?? '',
            'action' => $segments[1] ?? '',
            'recordId' => $segments[2] ?? 0,
            'subRecordId' => $segments[3] ?? 0,
        ];
        FatUtility::dieJsonSuccess($data);
    }
}
