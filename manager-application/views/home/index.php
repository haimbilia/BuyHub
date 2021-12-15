<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); /* CommonHelper::printArray(json_encode( array_values($dashboardInfo['signupsChartData']) ));die; */ ?>
<script type="text/javascript">
    $SalesChartKey = <?php echo json_encode(array_keys($dashboardInfo['salesChartData'])); ?>;
    $SalesChartVal = <?php echo json_encode(array_values($dashboardInfo['salesChartData'])); ?>;
    $signupsKey = <?php echo json_encode(array_keys($dashboardInfo['signupsChartData'])); ?>;
    $signupsVal = <?php echo json_encode(array_values($dashboardInfo['signupsChartData'])); ?>;
    $SalesEarningsKey = <?php echo json_encode(array_keys($dashboardInfo['salesEarningsChartData'])); ?>;
    $SalesEarningsVal = <?php echo json_encode(array_values($dashboardInfo['salesEarningsChartData'])); ?>;
    $affiliateSignupsKey = <?php echo json_encode(array_keys($dashboardInfo['affiliateSignupsChartData'])) ?>;
    $affiliateSignupsVal = <?php echo json_encode(array_values($dashboardInfo['affiliateSignupsChartData'])) ?>;
    $productsKey = <?php echo json_encode(array_keys($dashboardInfo['productsChartData'])) ?>;
    $productsVal = <?php echo json_encode(array_values($dashboardInfo['productsChartData'])) ?>;
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-tabs">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_STATISTICS', $siteLangId); ?></h3>
                        </div>
                        <div class="card-head-toolbar">
                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand navTabsJs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tabs_1" data-tab="tabs_1" data-chart="true" role="tab">
                                        <?php echo Labels::getLabel('NAV_SALES', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabs_2" data-tab="tabs_2" data-chart="true" role="tab">
                                        <?php echo Labels::getLabel('NAV_SALES_EARNINGS', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabs_3" data-tab="tabs_3" data-chart="true" role="tab">
                                        <?php echo Labels::getLabel('NAV_BUYER/Seller_Signups', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabs_4" data-tab="tabs_4" data-chart="true" role="tab">
                                        <?php echo Labels::getLabel('NAV_AFFILIATE_SIGNUPS', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabs_5" data-tab="tabs_5" data-chart="true" role="tab">
                                        <?php echo Labels::getLabel('NAV_PRODUCTS', $siteLangId); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs_1">
                                <div class="statistics" id="monthlysalesJs"></div>
                            </div>
                            <div class="tab-pane" id="tabs_2">
                                <div class="statistics" id="monthlysalesearningsJs"> </div>
                            </div>
                            <div class="tab-pane" id="tabs_3">
                                <div class="statistics" id="monthlySignupsJs"> </div>
                            </div>
                            <div class="tab-pane" id="tabs_4">
                                <div class="statistics" id="monthlyAffiliateSignupsJs"> </div>
                            </div>
                            <div class="tab-pane" id="tabs_5">
                                <div class="statistics" id="monthlyProductsJs"> </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_LATEST_ORDERS', $siteLangId); ?></h3>
                        </div>
                        <div class="card-head-toolbar">
                            <?php if ($objPrivilege->canViewOrders(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <a class="" target='_new' href="<?php echo UrlHelper::generateUrl('Orders'); ?>">
                                    <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="latestOrdersJs"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_TOP_SELLING_PRODUCTS', $siteLangId); ?></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-scrollable js-scrollable" id="topSellingProductsJs">
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title">Total Sales </h3>
                        </div>
                        <?php /*?>
                        <div class="card-head-toolbar">
                            <select class="form-select form-select-sm">
                                <?php foreach ($intervalsArr as $key => $val) { ?>
                                    <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php */ ?>

                    </div>
                    <div class="card-body">

                        <div class="js-total-sale"></div>
                        <ul class="list-stats list-stats-inline">
                            <li class="list-stats-item">
                                <span class="label">
                                    <i class="dot" style="background-color:#d70206;"></i>
                                    <?php echo Labels::getLabel('LBL_Order_Sales', $siteLangId); ?></span>
                                <span class="value">
                                    <i class="icn fas fa-arrow-up font-success"></i>
                                    <?php echo $dashboardInfo["stats"]["totalSales"][4]["totalsales"]; ?></span>
                            </li>
                            <li class="list-stats-item">
                                <span class="label">
                                    <i class="dot" style="background-color: #f05b4f;"></i>
                                    <?php echo Labels::getLabel('LBL_Sales_Earnings', $siteLangId); ?></span>
                                <span class="value">
                                    <i class="icn fas fa-arrow-up font-success"></i>
                                    <?php echo $dashboardInfo["stats"]["totalSales"][4]["totalcommission"]; ?>
                                </span>
                            </li>
                            <li class="list-stats-item">
                                <span class="label"> <i class="dot" style="background-color:#f4c63d;"></i><?php echo Labels::getLabel('LBL_New_Users', $siteLangId); ?></span>
                                <span class="value">
                                    <i class="icn fas fa-arrow-up font-success"></i>
                                    <?php echo $dashboardInfo["stats"]["totalUsers"]['-1']; ?></span>

                            </li>
                            <li class="list-stats-item">
                                <span class="label"> <i class="dot" style="background-color:#d17905;"></i>
                                    <?php echo Labels::getLabel('LBL_New_Shops', $siteLangId); ?></span>
                                <span class="value">
                                    <i class="icn fas fa-arrow-up font-success"></i>
                                    <?php echo $dashboardInfo["stats"]["totalShops"]['-1']; ?>
                                </span>

                            </li>
                        </ul>

                    </div>

                </div>
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_VISITORS_BY_COUNTRIES', $siteLangId); ?> </h3>
                        </div>
                        <div class="card-head-toolbar">
                            <select class="form-select form-select-sm" onClick="topCountries(this.value)">
                                <option value="today"><?php echo Labels::getLabel('LBL_TODAY', $siteLangId); ?></option>
                                <option value="Weekly"><?php echo Labels::getLabel('LBL_WEEKLY', $siteLangId); ?></option>
                                <option value="Monthly"><?php echo Labels::getLabel('LBL_MONTHLY', $siteLangId); ?></option>
                                <option value="Yearly" selected="selected"><?php echo Labels::getLabel('LBL_YEARLY', $siteLangId); ?></option>
                            </select>
                        </div>

                    </div>
                    <div class="card-body">
                        <ul class="list-stats list-stats-double topCountriesJs"></ul>
                    </div>

                </div>

                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title"> <?php echo Labels::getLabel('LBL_CONVERSIONS_STATISTICS', $siteLangId); ?></h3>
                            <span class="text-muted"> <?php echo Labels::getLabel('LBL_RECENT_CONVERSIONS_STATISTICS', $siteLangId); ?></span>
                        </div>

                    </div>
                    <div class="card-body">
                        <ul class="list-stats list-stats-double">

                            <li class="list-stats-item">
                                <span class="label"><?php echo Labels::getLabel('LBL_ADDED_TO_CART', $siteLangId); ?></span>
                                <span class="value">
                                    <i class="icn fas <?php echo (1 > $dashboardInfo['conversionStats']['added_to_cart']['%age']) ? 'fa-arrow-down font-danger' : 'fa-arrow-up font-success'; ?>"></i>
                                    <?php echo $dashboardInfo['conversionStats']['added_to_cart']['%age']; ?>%</span>
                            </li>
                            <li class="list-stats-item">
                                <span class="label"><?php echo Labels::getLabel('LBL_REACHED_CHECKOUT', $siteLangId); ?></span>
                                <span class="value">
                                    <i class="icn fas <?php echo (1 > $dashboardInfo['conversionStats']['reached_checkout']['%age']) ? 'fa-arrow-down font-danger' : 'fa-arrow-up font-success'; ?>"></i>
                                    <?php echo $dashboardInfo['conversionStats']['reached_checkout']['%age']; ?>% </span>
                            </li>
                            <li class="list-stats-item">
                                <span class="label"><?php echo Labels::getLabel('LBL_PURCHASED', $siteLangId); ?></span>
                                <span class="value">
                                    <i class="icn fas <?php echo (1 > $dashboardInfo['conversionStats']['added_to_cart']['%age']) ? 'fa-arrow-down font-danger' : 'fa-arrow-up font-success'; ?>"></i>
                                    <?php echo $dashboardInfo['conversionStats']['purchased']['%age']; ?>%</span>purchased

                            </li>
                            <li class="list-stats-item">
                                <span class="label"><?php echo Labels::getLabel('LBL_CANCELLED', $siteLangId); ?></span>
                                <span class="value">
                                    <i class="icn fas <?php echo (1 > $dashboardInfo['conversionStats']['cancelled']['%age']) ? 'fa-arrow-down font-danger' : 'fa-arrow-up font-success'; ?>"></i>
                                    <?php echo $dashboardInfo['conversionStats']['cancelled']['%age']; ?>%</span>

                            </li>
                        </ul>
                        <div class="widget__chart">
                            <div class="conversions-statistics" id="conversionStatsJs">
                            </div>
                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    var dataCurrency = '<?php echo CommonHelper::getCurrencySymbol(true); ?>';
    var w = $('.tabs_panel_wrap').width();
    //callback function
    google.load('visualization', '1', {
        'packages': ['corechart', 'bar']
    });
    //set callback
    google.setOnLoadCallback(createChart);

    function createChart() {
        <?php /* if($configuredAnalytics){ */ ?>

        // Conversions Statistics
        var dataConversion = google.visualization.arrayToDataTable([<?php echo html_entity_decode($dashboardInfo['conversionChatData'], ENT_QUOTES, 'UTF-8'); ?>]);
        var optionConversion = {
            width: $('#conversionStatsJs').width(),
            height: 240,
            'color': '#AEC785',
            legend: {
                position: "none"
            },
        };
        <?php if ($layoutDirection == 'rtl') { ?>
            optionConversion['hAxis'] = {
                direction: '-1'
            };
            optionConversion['series'] = [{
                targetAxisIndex: 1
            }];
        <?php } ?>

        var conversion = new google.visualization.ColumnChart(document.getElementById('conversionStatsJs'));
        <?php /* } */ ?>

        <?php /* if($configuredAnalytics){ */ ?>

        conversion.draw(dataConversion, optionConversion);
        <?php /* } */ ?>
    }
</script>