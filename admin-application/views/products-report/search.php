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

            case 'product_name':
                $name = "<strong>" . Labels::getLabel('LBL_Catalog_Name', $adminLangId) . ": </strong>" . $row['product_name'];
                if ($row['selprod_title'] != '') {
                    $name .= '<br/><strong>' . Labels::getLabel('LBL_Custom_Title', $adminLangId) . ': </strong>' . $row['selprod_title'];
                }
                if ($row['grouped_option_name'] != '') {
                    $groupedOptionNameArr = explode(',', $row['grouped_option_name']);
                    $groupedOptionValueArr = explode(',', $row['grouped_optionvalue_name']);
                    if (!empty($groupedOptionNameArr)) {
                        foreach ($groupedOptionNameArr as $key => $optionName) {
                            $name .= '<br/><strong>' . $optionName . ':</strong> ' . $groupedOptionValueArr[$key];
                        }
                    }
                }

                if ($row['brand_name'] != '') {
                    $name .= "<br/><strong>" . Labels::getLabel('LBL_Brand', $adminLangId) . ":  </strong>" . $row['brand_name'];
                }

                if ($row['shop_name'] != '') {
                    $name .= '<br/><strong>' . Labels::getLabel('LBL_Sold_By', $adminLangId) . ':  </strong>' . $row['shop_name'];
                }
                $span->appendElement('plaintext', array(), $name, true);
                break;

            case 'price':
                $span->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row['selprod_price'], true, true));
                break;

            case 'followers':
                $span->appendElement('plaintext', array(), $row[$key], true);
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

                /* case 'order_date':
                $td->appendElement('plaintext', array(), '<a href="'.UrlHelper::generateUrl('SalesReport','index',array($row[$key])).'">'.FatDate::format($row[$key]).'</a>',true);
                break;
            */

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
echo '<div>';
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmProductsReportSearchPaging'
));

$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false); ?>
<script>
    var x = $(".container-fluid").width();
    var actualWidth = x / 7;
    $('.datatable_cell_left').children('span').css('width', actualWidth + 'px');
    $('.datatable_cell_left').children('span').css('display', 'block');
</script>