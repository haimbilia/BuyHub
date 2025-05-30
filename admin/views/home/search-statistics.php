<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
switch(strtolower($type)){
case 'statistics': ?>
	<table class="table table-striped">
		<thead>
			<tr>
			 <th width="2%"></th>
				<th><?php echo Labels::getLabel("LBL_Today", $siteLangId); ?></th>
				<th><?php echo Labels::getLabel("LBL_This_Week", $siteLangId); ?></th>
				<th><?php echo Labels::getLabel("LBL_This_Month", $siteLangId); ?></th>
				<th><?php echo Labels::getLabel("LBL_Last_3_Months", $siteLangId); ?></th>
				<th><?php echo Labels::getLabel("LBL_Total", $siteLangId); ?></th>
			</tr>
		</thead>  
		<tbody>
		<?php if($dashboardInfo["stats"]["totalUsers"]!==false): ?>
			<tr>
			<th width="20%"><?php echo Labels::getLabel( "LBL_Buyer/Seller_Registered", $siteLangId); ?></th>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['buyer_seller_1']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['buyer_seller_7']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['buyer_seller_30']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['buyer_seller_90']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['buyer_seller_all']; ?></td>
		   </tr>
		<?php endif; ?>
		<?php if($dashboardInfo["stats"]["totalUsers"]!==false): ?>
			<tr>
			<th width="25%"><?php echo Labels::getLabel("LBL_Advertisers_Registered", $siteLangId); ?></th>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['advertiser_1']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['advertiser_7']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['advertiser_30']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['advertiser_90']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['advertiser_all']; ?></td>
		   </tr>
		<?php endif;  ?>
		<?php if($dashboardInfo["stats"]["totalUsers"]!==false): ?>
			<tr>
			<th width="25%"><?php echo Labels::getLabel("LBL_Affiliates_Registered", $siteLangId); ?></th>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['affiliate_1']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['affiliate_7']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['affiliate_30']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['affiliate_90']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalUsers"]['affiliate_all']; ?></td>
		   </tr>
		<?php endif;  ?>
		<?php if($dashboardInfo["stats"]["totalSellerProducts"]!==false): ?>
			<tr>
			<th><?php echo Labels::getLabel("LBL_Products_Published", $siteLangId); ?></th>
			<td><?php echo $dashboardInfo["stats"]["totalSellerProducts"]['1']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalSellerProducts"]['7']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalSellerProducts"]['30']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalSellerProducts"]['90']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalSellerProducts"]['-1']; ?></td>
		   </tr>
		<?php endif; 
			if( $dashboardInfo["stats"]["totalShops"] !== false ): ?>
			<tr>
			<th><?php echo Labels::getLabel("LBL_Number_of_Shops", $siteLangId); ?></th>
			<td><?php echo $dashboardInfo["stats"]["totalShops"]['1']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalShops"]['7']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalShops"]['30']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalShops"]['90']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalShops"]['-1']; ?></td>
		   </tr>
		<?php endif; 
			if($dashboardInfo["stats"]["totalOrders"]!==false): ?>
		   <tr>
			<th><?php echo Labels::getLabel("LBL_Orders_Placed_Count", $siteLangId); ?></th>
			<td><?php echo ($dashboardInfo["stats"]["totalOrders"][0]["totalorders"]); ?></td>
			<td><?php echo ($dashboardInfo["stats"]["totalOrders"][1]["totalorders"]); ?></td>
			<td><?php echo ($dashboardInfo["stats"]["totalOrders"][2]["totalorders"]); ?></td>
			<td><?php echo ($dashboardInfo["stats"]["totalOrders"][3]["totalorders"]); ?></td>
			<td><?php echo ($dashboardInfo["stats"]["totalOrders"][4]["totalorders"]); ?></td>
		   </tr>
			<tr>
			<th><?php echo Labels::getLabel("LBL_Orders_Palced_Value", $siteLangId); ?></th>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][0]["totalsales"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][1]["totalsales"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][2]["totalsales"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][3]["totalsales"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][4]["totalsales"])?></td>
		   </tr>
		   <?php ?>
		   <tr>
			<th><?php echo Labels::getLabel("LBL_Average_Order_Value", $siteLangId); ?></th>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][0]["avgorder"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][1]["avgorder"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][2]["avgorder"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][3]["avgorder"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalOrders"][4]["avgorder"])?></td>
		   </tr>
		   <tr>
		   <th><?php echo Labels::getLabel("LBL_Sales", $siteLangId); ?></th>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][0]["totalsales"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][1]["totalsales"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][2]["totalsales"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][3]["totalsales"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][4]["totalsales"])?></td>
		   </tr>
		   <th><?php echo Labels::getLabel("LBL_Sales_Earnings", $siteLangId); ?></th>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][0]["totalcommission"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][1]["totalcommission"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][2]["totalcommission"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][3]["totalcommission"])?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalSales"][4]["totalcommission"])?></td>
		   </tr>
		<?php endif; ?>
		<?php if($dashboardInfo["stats"]["totalWithdrawalRequests"]!==false): ?>
			<tr>
			<th><?php echo Labels::getLabel("LBL_Withdrawal_Requests", $siteLangId); ?></th>
			<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['1']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['7']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['30']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['90']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['-1']; ?></td>
		   </tr>
		<?php endif; ?>
		<?php /* if($dashboardInfo["stats"]["totalWithdrawalRequests"]!==false): ?>
			<tr>
				<th><?php echo Labels::getLabel("LBL_Affiliate_Withdrawal_Requests", $siteLangId); ?></th>
				<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['affiliate_1']; ?></td>
				<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['affiliate_7']; ?></td>
				<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['affiliate_30']; ?></td>
				<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['affiliate_90']; ?></td>
				<td><?php echo $dashboardInfo["stats"]["totalWithdrawalRequests"]['affiliate_all']; ?></td>
			</tr>
		<?php endif; */ ?>

		<?php if( $dashboardInfo["stats"]['totalAffiliateCommission'] != false ): 
			
		?>
			<tr>
				<th><?php echo Labels::getLabel("LBL_Commission_to_Affiliate_Users", $siteLangId); ?></th>
				<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalAffiliateCommission"]['1']); ?></td>
				<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalAffiliateCommission"]['7']); ?></td>
				<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalAffiliateCommission"]['30']); ?></td>
				<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalAffiliateCommission"]['90']); ?></td>
				<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalAffiliateCommission"]['-1']); ?></td>
			</tr>
		<?php endif; 
			if( $dashboardInfo["stats"]["totalPpc"] !== false ): ?>
			<tr>
			<th><?php echo Labels::getLabel("LBL_PPC_Earnings", $siteLangId); ?></th>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalPpc"]['1']); ?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalPpc"]['7']); ?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalPpc"]['30']); ?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalPpc"]['90']); ?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["totalPpc"]['-1']); ?></td>
		   </tr>
		<?php endif; 
			if( $dashboardInfo["stats"]["subscriptionEarnings"] !== false ): ?>
			<tr>
			<th><?php echo Labels::getLabel("LBL_Subscription_Earnings", $siteLangId); ?></th>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["subscriptionEarnings"]['1']); ?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["subscriptionEarnings"]['7']); ?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["subscriptionEarnings"]['30']); ?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["subscriptionEarnings"]['90']); ?></td>
			<td><?php echo CommonHelper::displayMoneyFormat($dashboardInfo["stats"]["subscriptionEarnings"]['-1']); ?></td>
		   </tr>
		   <?php endif; ?>
		<?php /* if($dashboardInfo["stats"]["affiliateWithdrawalRequest"]!==false): ?>
			<tr>
			<th><?php echo Labels::getLabel("LBL_Affiliate_Withdrawal_Requests", $siteLangId); ?></th>
			<td><?php echo $dashboardInfo["stats"]["affiliateWithdrawalRequest"]['1']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["affiliateWithdrawalRequest"]['7']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["affiliateWithdrawalRequest"]['30']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["affiliateWithdrawalRequest"]['90']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["affiliateWithdrawalRequest"]['-1']; ?></td>
		   </tr>
		<?php endif;  */?>
		<?php if($dashboardInfo["stats"]["productReviews"]!==false): ?>
			<tr>
			<th><?php echo Labels::getLabel("LBL_Product_Reviews", $siteLangId); ?></th>
			<td><?php echo $dashboardInfo["stats"]["productReviews"]['1']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["productReviews"]['7']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["productReviews"]['30']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["productReviews"]['90']; ?></td>
			<td><?php echo $dashboardInfo["stats"]["productReviews"]['-1']; ?></td>
		   </tr>
		<?php endif; ?>
		</tbody>    
	</table>
<?php break;
case 'sellerproducts': ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th width="30%"><?php echo Labels::getLabel("LBL_Name", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Brand", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Shop", $siteLangId); ?></th>
				<th width="5%"><?php echo Labels::getLabel("LBL_Available", $siteLangId); ?></th>
				<th width="20%"><?php echo Labels::getLabel("LBL_Price", $siteLangId); ?></th>
			</tr>
		</thead>
		<tbody>											
			<?php $counter = 0; 
			foreach( $dashboardInfo['sellerProductsList'] as $sp ){ $counter++; ?>
			<tr>
				<td><?php echo $counter; ?></td>
				<td><?php echo $sp['product_name']; echo ( $sp['selprod_title'] != "" ) ? '<br/><small>'.$sp['selprod_title'].'</small>' : ''; ?></td>
				<td><?php echo isset($sp['brand_name']) && !empty($sp['brand_name']) ? $sp['brand_name'] : 'N/A'; ?></td>
				<td><?php echo $sp['shop_name']; ?></td>
				<td><?php echo $sp['selprod_stock']; ?></td>
				<td><?php echo CommonHelper::displayMoneyFormat($sp['theprice']); ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<?php break;
case 'shops': ?>
	<table class="table table-striped">
		<thead>
			<tr>
			<th width="3%">#</th>
			<th width="12%"><?php echo Labels::getLabel("LBL_Shop_Owner", $siteLangId); ?></th>
			<th width="12%"><?php echo Labels::getLabel("LBL_Name", $siteLangId); ?></th>
			<th width="15%"><?php echo Labels::getLabel("LBL_Created_On", $siteLangId); ?></th>
			<th width="15%"><?php echo Labels::getLabel("LBL_Status", $siteLangId); ?></th>
			</tr>
		</thead>  
		<tbody>
			<?php $shopCounter=0; 
			foreach ( $dashboardInfo['shopsList'] as $shop ) { $shopCounter++; ?>
			<tr>
			<td><?php echo $shopCounter; ?></td>
			<td><?php echo $shop["shop_owner_username"]?></td>
			<td><?php echo $shop["shop_name"]; ?></td>
			<td><?php echo FatDate::format($shop['shop_created_on']); ?></td>
			<td><?php echo $shop["shop_active"] == applicationConstants::ACTIVE ? "<span class='label label-success'>" . applicationConstants::getActiveInactiveArr($siteLangId)[$shop["shop_active"]] . "</span>":"<span class='label label-danger'>In-active</span>"?></td>
			</tr>
			<?php } ?>
		</tbody>    
	</table>
<?php break;
case 'signups': ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="3%">#</th>
				<th width="12%"><?php echo Labels::getLabel("LBL_Name", $siteLangId); ?></th>
				<th width="12%"><?php echo Labels::getLabel("LBL_Username", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Email", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Type", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Phone", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Added_On", $siteLangId); ?></th>
			</tr>
		</thead>  
		<tbody>
		<?php $counter=0; 
		foreach ( $dashboardInfo['buyerSellerList'] as $user ) { 
		$counter++; 
		$userTypeStr = '';
		$arr = User::getUserTypesArr($siteLangId);
		if( $user['user_is_buyer'] ){
			$userTypeStr .= $arr[User::USER_TYPE_BUYER].'<br/>';
		}
		if( $user['user_is_supplier'] ){
			$userTypeStr .= $arr[User::USER_TYPE_SELLER].'<br/>';
		}

		if (0 < $user['user_parent'] && $user['user_is_supplier'] ) {
			$userTypeStr = Labels::getLabel('LBL_Sub_Seller', $siteLangId);
		}
		?>
		<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $user["user_name"]; ?></td>
			<td><?php echo $user["credential_username"]; ?></td>
			<td><?php echo $user["credential_email"]; ?></td>
			<td><?php echo $userTypeStr; ?></td>
			<td><span class="default-ltr"><?php echo ValidateElement::formatDialCode($user["user_phone_dcode"]) . $user["user_phone"]; ?></span></td>
			<td><?php echo FatDate::format($user['user_regdate']); ?></td>
		</tr>
		<?php } ?>
		</tbody>    
	</table>
<?php break;
case 'advertisers': ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="3%">#</th>
				<th width="12%"><?php echo Labels::getLabel("LBL_Name", $siteLangId); ?></th>
				<th width="12%"><?php echo Labels::getLabel("LBL_Username", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Email", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Phone", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Added_On", $siteLangId); ?></th>
			</tr>
		</thead>  
		<tbody>
		<?php $counter=0; 
		foreach ( $dashboardInfo['advertisersList'] as $user ) { 
		$counter++; 
		?>
		<tr>
			<td><?php echo $counter; ?></td>
			<td><?php echo $user["user_name"]; ?></td>
			<td><?php echo $user["credential_username"]; ?></td>
			<td><?php echo $user["credential_email"]; ?></td>
			<td><span class="default-ltr"><?php echo ValidateElement::formatDialCode($user["user_phone_dcode"]) . $user["user_phone"]; ?></span></td>
			<td><?php echo FatDate::format($user['user_regdate']); ?></td>
		</tr>
		<?php } ?>
		</tbody>    
	</table>
<?php break;
case 'affiliates': ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="3%">#</th>
				<th width="12%"><?php echo Labels::getLabel("LBL_Name", $siteLangId); ?></th>
				<th width="12%"><?php echo Labels::getLabel("LBL_Username", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Email", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Phone", $siteLangId); ?></th>
				<th width="15%"><?php echo Labels::getLabel("LBL_Added_On", $siteLangId); ?></th>
			</tr>
		</thead>  
		<tbody>
			<?php $counter=0; 
			foreach ( $dashboardInfo['affiliatesList'] as $user ) { 
			$counter++; 
			?>
			<tr>
				<td><?php echo $counter; ?></td>
				<td><?php echo $user["user_name"]; ?></td>
				<td><?php echo $user["credential_username"]; ?></td>
				<td><?php echo $user["credential_email"]; ?></td>
				<td><span class="default-ltr"><?php echo ValidateElement::formatDialCode($user["user_phone_dcode"]) . $user["user_phone"]; ?></span></td>
				<td><?php echo FatDate::format($user['user_regdate']); ?></td>
			</tr>
			<?php } ?>
		</tbody>    
	</table>
<?php break; } ?>