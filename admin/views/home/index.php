<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (false === $canViewAdminDashboard) {
    $this->includeTemplate('_partial/unauthorised.php', [], false);
} else { ?>
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
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_STATISTICS', $siteLangId); ?>
                                </h3>
                            </div>
                            <div class="card-head-toolbar">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-gray btn-icon dropdown-toggle dropdownBtnJs"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                                        aria-expanded="false">
                                        <?php echo Labels::getLabel('NAV_SALES', $siteLangId); ?>
                                    </button>
                                    <div class="nav nav-tabs navTabsJs dropdown-menu dropdown-menu-right dropdown-menu-anim"
                                        role="tablist">
                                        <a class="dropdown-item tabsJs active" data-bs-toggle="tab" href="#tabs_1"
                                            data-tab="tabs_1" data-chart="true" role="tab">
                                            <?php echo Labels::getLabel('NAV_SALES', $siteLangId); ?>
                                        </a>
                                        <a class="dropdown-item tabsJs" data-bs-toggle="tab" href="#tabs_2"
                                            data-tab="tabs_2" data-chart="true" role="tab">
                                            <?php echo Labels::getLabel('NAV_SALES_EARNINGS', $siteLangId); ?>
                                        </a>
                                        <a class="dropdown-item tabsJs" data-bs-toggle="tab" href="#tabs_3"
                                            data-tab="tabs_3" data-chart="true" role="tab">
                                            <?php echo Labels::getLabel('NAV_BUYER/Seller_Signups', $siteLangId); ?>
                                        </a>
                                        <a class="dropdown-item tabsJs" data-bs-toggle="tab" href="#tabs_4"
                                            data-tab="tabs_4" data-chart="true" role="tab">
                                            <?php echo Labels::getLabel('NAV_PRODUCTS', $siteLangId); ?>
                                        </a>
                                        <a class="dropdown-item tabsJs" data-bs-toggle="tab" href="#tabs_5"
                                            data-tab="tabs_5" data-chart="true" role="tab">
                                            <?php echo Labels::getLabel('NAV_AFFILIATE_SIGNUPS', $siteLangId); ?>
                                        </a>
                                    </div>
                                </div>
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
                                    <div class="statistics" id="monthlyProductsJs"> </div>
                                </div>
                                <div class="tab-pane" id="tabs_5">
                                    <div class="statistics" id="monthlyAffiliateSignupsJs"> </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php if ($objPrivilege->canViewOrders(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                        <div class="card">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">
                                        <?php echo Labels::getLabel('LBL_LATEST_ORDERS', $siteLangId); ?></h3>
                                </div>
                                <div class="card-head-toolbar">
                                    <a class="btn btn-gray" target='_new'
                                        href="<?php echo UrlHelper::generateUrl('Orders'); ?>">
                                        <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?></a>
                                </div>
                            </div>
                            <div class="card-table">
                                <div class="table-responsive" id="latestOrdersJs"></div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    <?php echo Labels::getLabel('LBL_CONVERSIONS_STATISTICS', $siteLangId); ?></h3>
                                <span class="text-muted">
                                    <?php echo Labels::getLabel('LBL_RECENT_CONVERSIONS_STATISTICS', $siteLangId); ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-stats list-stats-double">
                                <li class="list-stats-item">
                                    <span
                                        class="label"><?php echo Labels::getLabel('LBL_HOLDING_CART', $siteLangId); ?></span>
                                    <span class="value">
                                        <?php echo $dashboardInfo['conversionStats']['holding_cart']['%age']; ?>%</span>
                                </li>
                                <li class="list-stats-item">
                                    <span class="label">
                                        <?php echo Labels::getLabel('LBL_REACHED_CHECKOUT', $siteLangId); ?> 
                                    </span>
                                    <span class="value">
                                        <?php echo $dashboardInfo['conversionStats']['reached_checkout']['%age']; ?>%
                                    </span>
                                </li>
                                <li class="list-stats-item">
                                    <span class="label"><?php echo Labels::getLabel('LBL_PURCHASED', $siteLangId); ?></span>
                                    <span class="value">
                                        <?php echo $dashboardInfo['conversionStats']['purchased']['%age']; ?>%</span>

                                </li>
                                <li class="list-stats-item">
                                    <span class="label"><?php echo Labels::getLabel('LBL_CANCELLED', $siteLangId); ?></span>
                                    <span class="value">
                                        <?php echo $dashboardInfo['conversionStats']['cancelled']['%age']; ?>%</span>

                                </li>
                            </ul>
                            <div class="widget__chart">
                                <div class="conversions-statistics" id="conversionStatsJs">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    <?php echo Labels::getLabel('LBL_Visitors_Statistics', $siteLangId); ?></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($dashboardInfo['visitsCount']) { ?>
                                <ul class="list-stats list-stats-double">
                                    <li class="list-stats-item">
                                        <span class="label"><?php echo Labels::getLabel('LBL_Today', $siteLangId); ?></span>
                                        <span class="value">
                                            <?php echo $dashboardInfo['visitsCount']['today'] ?></span>
                                    </li>
                                    <li class="list-stats-item">
                                        <span
                                            class="label"><?php echo Labels::getLabel('LBL_PAST_7_DAYS', $siteLangId); ?></span>
                                        <span class="value">
                                            <?php echo $dashboardInfo['visitsCount']['weekly'] ?></span>
                                    </li>
                                    <li class="list-stats-item">
                                        <span
                                            class="label"><?php echo Labels::getLabel('LBL_last_Month', $siteLangId); ?></span>
                                        <span class="value">
                                            <?php echo $dashboardInfo['visitsCount']['lastMonth'] ?></span>
                                    </li>
                                    <li class="list-stats-item">
                                        <span
                                            class="label"><?php echo Labels::getLabel('LBL_Last_3_Months', $siteLangId); ?></span>
                                        <span class="value">
                                            <?php echo $dashboardInfo['visitsCount']['last3Month'] ?></span>
                                    </li>

                                </ul>
                            <?php } ?>
                            <div class="widget__chart">
                                <div id="visitsGraph" class="ct-chart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    <?php echo Labels::getLabel('LBL_TOP_SELLING_PRODUCTS', $siteLangId); ?></h3>
                            </div>
                        </div>
                        <div class="card-table">
                            <div class="table-responsive table-scrollable js-scrollable" id="topSellingProductsJs">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_TOTAL_SALES', $siteLangId); ?>
                                </h3>
                            </div>
                            <div class="card-head-toolbar">
                                <select class="form-select form-select-sm" onchange="totalSales(this.value)">
                                    <?php foreach ($intervalsArr as $key => $val) { ?>
                                        <option value="<?php echo $key; ?>" <?php if ($defaultStatsInterval == $key) {
                                               echo 'selected="selected"';
                                           } ?>><?php echo $val; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-body" id="totalSalesJs"><?php /* require_once('total-sales.php'); */ ?></div>

                    </div>
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_TRAFFIC', $siteLangId); ?>
                                </h3>
                            </div>
                            <div class="card-head-toolbar">
                                <select class="form-select form-select-sm" onChange="traficSource(this.value)">
                                    <option value="today"><?php echo Labels::getLabel('LBL_TODAY', $siteLangId); ?></option>
                                    <option value="Weekly"><?php echo Labels::getLabel('LBL_PAST_7_DAYS', $siteLangId); ?>
                                    </option>
                                    <option value="Monthly"><?php echo Labels::getLabel('LBL_PAST_30_DAYS', $siteLangId); ?>
                                    </option>
                                    <option value="Yearly" selected="selected">
                                        <?php echo Labels::getLabel('LBL_YEARLY', $siteLangId); ?></option>
                                </select>
                            </div>

                        </div>
                        <div class="card-body">
                            <div id="piechart" class="ct-chart"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    <?php echo Labels::getLabel('LBL_VISITORS_BY_COUNTRIES', $siteLangId); ?> </h3>
                            </div>
                            <div class="card-head-toolbar">
                                <select class="form-select form-select-sm" onChange="topCountries(this.value)">
                                    <option value="today"><?php echo Labels::getLabel('LBL_TODAY', $siteLangId); ?></option>
                                    <option value="Weekly"><?php echo Labels::getLabel('LBL_PAST_7_DAYS', $siteLangId); ?>
                                    </option>
                                    <option value="Monthly"><?php echo Labels::getLabel('LBL_PAST_30_DAYS', $siteLangId); ?>
                                    </option>
                                    <option value="Yearly" selected="selected">
                                        <?php echo Labels::getLabel('LBL_YEARLY', $siteLangId); ?></option>
                                </select>
                            </div>

                        </div>
                        <div class="card-body relative topCountriesJs">
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_TOP_REFERERS', $siteLangId); ?>
                                </h3>
                            </div>
                            <div class="card-head-toolbar">
                                <select class="form-select form-select-sm" onChange="topReferers(this.value)">
                                    <option value="today"><?php echo Labels::getLabel('LBL_TODAY', $siteLangId); ?></option>
                                    <option value="Weekly"><?php echo Labels::getLabel('LBL_PAST_7_DAYS', $siteLangId); ?>
                                    </option>
                                    <option value="Monthly"><?php echo Labels::getLabel('LBL_PAST_30_DAYS', $siteLangId); ?>
                                    </option>
                                    <option value="Yearly" selected="selected">
                                        <?php echo Labels::getLabel('LBL_YEARLY', $siteLangId); ?></option>
                                </select>
                            </div>

                        </div>
                        <div class="card-body relative topReferersJs">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    <?php echo Labels::getLabel('LBL_TOP_SEARCH_KEYWORDS', $siteLangId); ?> </h3>
                            </div>
                            <div class="card-head-toolbar">
                                <select class="form-select form-select-sm" onChange="getTopSearchKeyword(this.value)">
                                    <option value="today"><?php echo Labels::getLabel('LBL_TODAY', $siteLangId); ?></option>
                                    <option value="Weekly"><?php echo Labels::getLabel('LBL_PAST_7_DAYS', $siteLangId); ?>
                                    </option>
                                    <option value="Monthly"><?php echo Labels::getLabel('LBL_PAST_30_DAYS', $siteLangId); ?>
                                    </option>
                                    <option value="Yearly" selected="selected">
                                        <?php echo Labels::getLabel('LBL_YEARLY', $siteLangId); ?></option>
                                </select>
                            </div>

                        </div>
                        <div class="card-body relative topSearchKeywordJs">
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
            <?php if (CommonHelper::getLayoutDirection() == 'rtl') { ?>
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
<?php } ?>