<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<table class="table table--hovered table--striped">
	 <thead>
			<tr>
			  <th><?php echo Labels::getLabel('LBL_Date',$siteLangId); ?></th>
			  <th><?php echo Labels::getLabel('LBL_Order_ID',$siteLangId); ?></th>
			  <th><?php echo Labels::getLabel('LBL_Customer',$siteLangId); ?></th>
			  <th><?php echo Labels::getLabel('LBL_Order_Total',$siteLangId); ?></th>
			  <th><?php echo Labels::getLabel('LBL_Status',$siteLangId); ?></th>
			</tr>
		</thead>  
		<tbody>
			 <?php foreach ($dashboardInfo["recentOrders"] as $sn=>$row) {  
			  ?>
			<tr>
			  <td><?php echo FatDate::format($row['order_date_added']);?></td>
			  <td><?php echo $row['order_id'];?></td>
			  <td><?php echo $row['buyer_user_name'];?></td>
			  <td><?php echo CommonHelper::displayMoneyFormat($row['order_net_amount'], true, true) ; ?></td>
			  <td><span ><?php echo $dashboardInfo['orderPaymentStatusArr'][$row['order_payment_status']]?></span></td>
			</tr>
		   <?php }?>
		</tbody>    
</table>