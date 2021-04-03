<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arrFlds = array(
	'title'	=>	Labels::getLabel('LBL_Title', $adminLangId),
	'totOrders' => Labels::getLabel('LBL_No._of_Orders', $adminLangId),
	'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $adminLangId),
	'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $adminLangId),
	'netSoldQty' => Labels::getLabel('LBL_Sold_Qty', $adminLangId),
	'grossSales' => Labels::getLabel('LBL_Gross_Sale', $adminLangId),
	'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $adminLangId),
	'inventoryValue' => Labels::getLabel('LBL_Inventory_Value', $adminLangId),

	'taxTotal' => Labels::getLabel('LBL_Tax_Charged', $adminLangId),
	'sellerTaxTotal' => Labels::getLabel('LBL_Tax_Charged_By_Seller', $adminLangId),
	'adminTaxTotal' => Labels::getLabel('LBL_Tax_Charged_by_Admin', $adminLangId),

	'shippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $adminLangId),
	'sellerShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_By_Seller', $adminLangId),
	'adminShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_by_Admin', $adminLangId),

	'couponDiscount' => Labels::getLabel('LBL_Coupon_Discount', $adminLangId),
	'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $adminLangId),
	'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $adminLangId),

	'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $adminLangId),
	'refundedShipping' => Labels::getLabel('LBL_Refunded_Shipping', $adminLangId),
	'refundedTax' => Labels::getLabel('LBL_Refunded_Tax', $adminLangId),

	'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $adminLangId),

	'commissionCharged' => Labels::getLabel('LBL_Commision_Charged', $adminLangId),
	'refundedCommission' => Labels::getLabel('LBL_Refunded_Commision', $adminLangId),
	'adminSalesEarnings' => Labels::getLabel('LBL_Sales_Earnings', $adminLangId)
);

$tbl = new HtmlElement(
	'table',
	array('width' => '100%', 'class' => 'table table-responsive table--hovered')
);

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arrFlds as $val) {
	$e = $th->appendElement('th', array(), $val, true);
}

$sr_no = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arr_listing as $sn => $row) {
	$sr_no++;
	$tr = $tbl->appendElement('tr');

	foreach ($arrFlds as $key => $val) {
		$td = $tr->appendElement('td');
		switch ($key) {
			case 'listserial':
				$td->appendElement('plaintext', array(), $sr_no);
				break;

			case 'title':
				$name = $row['product_name'];
				/* if( $row['selprod_title'] != '' ){
					$name .= '<br/><strong>'.Labels::getLabel('LBL_Custom_Title',$adminLangId).': </strong>'. $row['selprod_title'];
				}
				if( $row['grouped_option_name'] != '' ){
					$groupedOptionNameArr = explode(',', $row['grouped_option_name']);
					$groupedOptionValueArr = explode(',', $row['grouped_optionvalue_name']);
					if( !empty($groupedOptionNameArr) ){
						foreach( $groupedOptionNameArr as $key => $optionName ){
							$name .= '<br/><strong>' . $optionName.':</strong> '.$groupedOptionValueArr[$key];
						}
					}
				}
				
				
				*/
				if ($row['brand_name'] != '') {
					$name .= "<br/><strong>" . Labels::getLabel('LBL_Brand', $adminLangId) . ": </strong>" . $row['brand_name'];
				}
				$td->appendElement('plaintext', array(), $name, true);
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
				$td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key], true, true));
				break;

			default:
				$td->appendElement('plaintext', array(), $row[$key], true);
				break;
		}
	}
}
if (count($arr_listing) == 0) {
	$tbl->appendElement('tr')->appendElement(
		'td',
		array(
			'colspan' => count($arrFlds)
		),
		Labels::getLabel('LBL_No_Records_Found', $adminLangId)
	);
}
echo '<div class="overflow_auto">';
echo $tbl->getHtml();
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
	'name' => 'frmCatalogReportSearchPaging'
));
echo '</div>';
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
