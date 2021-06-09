<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
echo '<div class="datatable datatable-sticky scroll scroll-x">';
$tbl = new HtmlElement(
    'table',
    array('width' => '100%', 'class' => 'datatable__table')
);

$th = $tbl->appendElement('thead', ['class' => 'datatable__head'])->appendElement('tr', ['class' => 'datatable__row']);
$count = 0;
$staticFlds = [];
foreach ($fields as $key => $val) {
    $cls = 'datatable_cell datatable_cell-sort datatable_cell_top headerColumnJs';
    if (0 == $count) {
        $staticFlds = [$key];
        $cls .= ' datatable_cell_left';
    }

    $cls .= ($key == $sortBy) ? ' datatable_cell-sorted' : '';

    $td = $th->appendElement('th', ['class' => $cls, 'data-field' => $key]);
    $span = $td->appendElement('span');
    $span->appendElement('plaintext', array(), $val);
    if ($key == $sortBy) {
        $arrow = ($sortOrder == applicationConstants::SORT_ASC) ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>';
        $span->appendElement('plaintext', array(), $arrow, true);
    }
    $count++;
}

$tbody = $tbl->appendElement('tbody', ['class' => 'datatable__body']);
$sr_no = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
    $cls = (($sr_no % 2) == 0) ? 'datatable__row datatable__row--even' : 'datatable__row';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $sr_no]);

    foreach ($fields as $key => $val) {
        if (in_array($key, $staticFlds)) {
            $td = $tr->appendElement('th', ['class' => 'datatable_cell datatable_cell_left']);
            $span = $td->appendElement('span');
        } else {
            $td = $tr->appendElement('td', ['class' => 'datatable_cell']);
            $span = $td->appendElement('span');
        }
        switch ($key) {
            case 'listserial':
                $span->appendElement('plaintext', array(), $sr_no);
                break;

            case 'shop_name':
                $shop = $row['shop_name'];
                $shop .= '<br/>Created On: ' . FatDate::format($row['shop_created_on'], false, true, FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get()));

                $span->appendElement('plaintext', array(), $shop, true);
                break;

            case 'owner_name':
                $span->appendElement('plaintext', array(), $row['owner_name'] . '<br/>(' . $row['owner_email'] . ')', true);
                break;

            case 'totRating':
                $rating = '<ul class="rating list-inline">';
                for ($j = 1; $j <= 5; $j++) {
                    $class = ($j <= round($row['totRating'])) ? "active" : "in-active";
                    $fillColor = ($j <= round($row['totRating'])) ? "#f5851f" : "#474747";
                    $rating .= '<li class="' . $class . '">
                    <svg xml:space="preserve" enable-background="new 0 0 70 70" viewBox="0 0 70 70" height="18px" width="18px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
                    <g><path d="M51,42l5.6,24.6L35,53.6l-21.6,13L19,42L0,25.4l25.1-2.2L35,0l9.9,23.2L70,25.4L51,42z M51,42" fill="' . $fillColor . '" /></g></svg>

                  </li>';
                }
                $rating .= '</ul>';
                $span->appendElement('plaintext', array(), $rating, true);
                break;
            case 'grossSales':
            case 'transactionAmount':
            case 'inventoryValue':
            case 'taxTotal':
            case 'adminTaxTotal':
            case 'sellerTaxTotal':
            case 'shippingTotal':
            case 'sellerShippingTotal':
            case 'adminShippingTotal':
            case 'discountTotal':
            case 'couponDiscount':
            case 'volumeDiscount':
            case 'rewardDiscount':
            case 'refundedAmount':
            case 'refundedShipping':
            case 'refundedTax':
            case 'orderNetAmount':
            case 'commissionCharged':
            case 'refundedCommission':
            case 'adminSalesEarnings':
                $span->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;

            default:
                $span->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $sr_no++;
}
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields)
        ),
        Labels::getLabel('LBL_No_Records_Found', $adminLangId)
    );
}

echo $tbl->getHtml();
echo '</div>';
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmShopsReportSearchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false); ?>
<script>
    resetReportFirstColumnWidth();
</script>