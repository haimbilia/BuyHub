<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$subcriptionPeriodArr = SellerPackagePlans::getSubscriptionPeriods($siteLangId);
$validTill = FatDate::format($orderDetail['ossubs_from_date']) . " - " . FatDate::format($orderDetail['ossubs_till_date']);

$str = '<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border:1px solid #ddd; border-collapse:collapse;">
<tr>
    <td width="30%" style="padding:10px;background:#eee;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;">' . Labels::getLabel('LBL_PACKAGE_NAME', $siteLangId) . '</td>
    <td width="15%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;">' . Labels::getLabel('LBL_FREQUENCY', $siteLangId) . '</td>
    <td width="20%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;" align="right">' . Labels::getLabel('LBL_Price', $siteLangId) . '</td>
    <td width="35%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;" align="right">' . Labels::getLabel('LBL_Subscription_Valid_till', $siteLangId) . '</td>
</tr>
<tr>
    <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;">' . $orderDetail['ossubs_subscription_name'] .'</td>
    <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;">' . $orderDetail['ossubs_interval'].$subcriptionPeriodArr[$orderDetail['ossubs_frequency']] . '</td>
    <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">' . CommonHelper::displayMoneyFormat($orderDetail['ossubs_price']) . '</td>
    <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">' . $validTill . '</td>    
</tr></table>';
echo $str;

