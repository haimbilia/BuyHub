<?php

class Statistics
{
    public static function sellerSalesGraph($template)
    {
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }

        $dashboardStats = Stats::getUserSales($loggedUserId, STATS::SELLER_DASHBOARD_SALES_MONTH);
        $sales_earnings_chart_data = array();
        foreach ($dashboardStats as $saleskey => $salesval) {
            $salesval = $salesval ?? 0;
            $sales_earnings_chart_data[$saleskey] = round($salesval, 2);
        }
        $dashboardInfo['sales_earnings_chart_data'] = $sales_earnings_chart_data;
        if ('ltr' == mb_strtolower(CommonHelper::getLayoutDirection())) {
            $dashboardInfo['sales_earnings_chart_data'] = array_reverse($sales_earnings_chart_data);
        }
        $template->set('siteLangId', CommonHelper::getLangId());
        $template->set('dashboardInfo', $dashboardInfo);
    }
}
