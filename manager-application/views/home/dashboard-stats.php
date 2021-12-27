<?php
switch (strtoupper($stats_type)) {
    case 'TOP_COUNTRIES':
        if (null != $stats_info && array_key_exists('rows', $stats_info) && $stats_info['totalsForAllResults'] > 0) {
            foreach ($stats_info['rows'] as $key => $val) {
                $cls = (1 >  $val['%age']) ? 'fa-arrow-down font-danger' : 'fa-arrow-up font-success';
                echo '<li class="list-stats-item">
                        <span class="label">' . $key . '</span>
                        <span class="value">
                            <i class="icn fas ' . $cls . '"></i>' . $val['%age'] . '%</span>
                    </li>';
            }
        } else {
            echo "<li class='list-stats-item'>" . Labels::getLabel('LBL_NO_RECORD_FOUND', $siteLangId) . "</li>";
        }

        break;
    case 'TOP_REFERRERS':
        if (null != $stats_info && array_key_exists('rows', $stats_info) && $stats_info['totalsForAllResults'] > 0) {
            foreach ($stats_info['rows'] as $key => $val) {
                $cls = (30 <  $val['visit']) ? 'fa-arrow-up font-success' : '';
                echo '<li class="list-stats-item">
                    <span class="label">' . $key . '</span>
                    <span class="value">
                        <i class="icn fas ' . $cls . '"></i>' . $val['visit'] . '%</span>
                </li>';
            }
        } else {
            echo "<li class='list-stats-item'>" . Labels::getLabel('LBL_No_Record_Found', $siteLangId) . "</li>";
        }
        break;
    case 'TRAFFIC_SOURCE':
        $pieChatStats = "[['Source', 'Visitors'],";
        if ($stats_info != null && array_key_exists('totalsForAllResults', $stats_info) && $stats_info['totalsForAllResults'] > 0) {
            foreach ($stats_info['rows'] as $key => $val) {
                if ($key == '') {
                    continue;
                }
                $pieChatStats .= "['" . $key . "'," . intval($val['visit']) . "],";
            }
            $pieChatStats = rtrim($pieChatStats, ',');
            echo $pieChatStats .= "],['title','Traffic source']";
        } else {
            echo "<li class='list-stats-item'>" . Labels::getLabel('LBL_No_Record_Found', $siteLangId) . "</li>";
        }
        break;
    case 'VISITORS_STATS':
        if (!empty($stats_info['stats'])) {
            $chatStats = "[['Year', 'Today','Weekly','Last Month','Last 3 Month'],";
            foreach ($stats_info['stats'] as $key => $val) {
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
                $chatStats .= '],';
            }
            $chatStats = rtrim($chatStats, ',');
            echo $chatStats .= "]";
        } else {
            echo "<li class='list-stats-item'>" . Labels::getLabel('LBL_No_Record_Found', $siteLangId) . "</li>";
        }
        break;
    case 'TOP_PRODUCTS':
        if ($stats_info != null && count($stats_info) > 0) {
            $count = 1;

            foreach ($stats_info as $row) {
                if ($count > 11) {
                    break;
                }
                echo '<li>' . $row['product_name'] . '<span class="count">' . $row['sold'] . ' sold</span></li>';
            }
        } else {
            echo "<li>" . Labels::getLabel('LBL_No_Record_Found', $siteLangId) . "</li>";
        }

        break;
    case 'TOP_SEARCH_KEYWORD':
        if ($stats_info != null && count($stats_info) > 0) {
            $count = 1;
            foreach ($stats_info as $row) {
                if ($count > 11) {
                    break;
                }
                $cls = (30 <  $row['search_count']) ? 'fa-arrow-up font-success' : '';
                $keyword = ($row['searchitem_keyword'] == '') ? 'Blank Search' : $row['searchitem_keyword'];
                echo '<li class="list-stats-item">
                    <span class="label">' . $keyword . '</span>
                    <span class="value">
                        <i class="icn fas ' . $cls . '"></i>' . $row['search_count'] . '%</span>
                </li>';
            }
        } else {
            echo "<li class='list-stats-item'>" . Labels::getLabel('LBL_No_Record_Found', $siteLangId) . "</li>";
        }
        break;
}
