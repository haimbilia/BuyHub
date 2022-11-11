<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<table class="table">
	<thead>
		<tr>
			<th><?php echo Labels::getLabel('LBL_ORDER_ID', $siteLangId); ?></th>
			<th><?php echo Labels::getLabel('LBL_CUSTOMER', $siteLangId); ?></th>
			<th><?php echo Labels::getLabel('LBL_DATE', $siteLangId); ?></th>
			<th><?php echo Labels::getLabel('LBL_ORDER_TOTAL', $siteLangId); ?></th>
			<th><?php echo Labels::getLabel('LBL_PAYMENT_STATUS', $siteLangId); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($dashboardInfo["recentOrders"] as $sn => $row) {
		?>
			<tr>
				<td><a href="<?php echo UrlHelper::generateUrl('Orders', 'view', array($row['order_id'])) ?>"> <?php echo $row['order_number']; ?></a></td>
				<td><?php
					$href = "javascript:void(0)";
					$onclick = ($canViewUsers ? 'redirectUser(' . $row['order_user_id'] . ')' : '');
					$str = $this->includeTemplate('_partial/user/user-info-card.php', [
						'user' => ['user_updated_on' => $row['buyer_updated_on'], 'user_id' => $row['order_user_id'], 'user_name' => $row['buyer_user_name'], 'credential_username' => $row['buyer_credential_username'], 'credential_email' => $row['buyer_credential_email']],
						'siteLangId' => $siteLangId,
						'href' => $href,
						'onclick' => $onclick,
					], false, true);

					echo '<div class="user-profile">' . $str . '</div>'; ?></td>
				<td><?php echo HtmlHelper::formatDateTime(
						$row['order_date_added'],
						true,
						true,
						FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
					); ?></td>
				<td><?php echo CommonHelper::displayMoneyFormat($row['order_net_amount'], true, true); ?></td>
				<td><?php echo Orders::getPaymentStatusHtml($siteLangId, $row['order_payment_status']); ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>