<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}
$subcriptionPeriodArr = SellerPackagePlans::getSubscriptionPeriods($siteLangId);
$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'subscriptionCharges':
            case 'amountPaid':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;
            case 'user_name':
                $name = $row['user_name'];
                $td->appendElement('plaintext', $tdAttr, $name);
                break;
            case 'ossubs_from_date':
                $td->appendElement('plaintext', $tdAttr, HtmlHelper::formatDateTime($row[$key]), true);
                break;
            case 'ossubs_till_date':
                if(SellerPackagePlans::SUBSCRIPTION_PERIOD_UNLIMITED == $row['ossubs_frequency']) {
                    $td->appendElement('plaintext', $tdAttr, Labels::getLabel("LBL_N/A", $siteLangId), true);
                } else {
                    $td->appendElement('plaintext', $tdAttr, HtmlHelper::formatDateTime($row[$key]), true);
                }
                break;
            case 'ossubs_subscription_name':
                $name = $row['ossubs_subscription_name'] . ' ';
                $name .= ($row['ossubs_type'] == SellerPackages::PAID_TYPE) ? " /" . " " . Labels::getLabel("LBL_Per", $siteLangId) : Labels::getLabel("LBL_For", $siteLangId);

                $name .= " " . (($row['ossubs_interval'] > 0) ? $row['ossubs_interval'] : '')
                    . "  " . $subcriptionPeriodArr[$row['ossubs_frequency']];
                $td->appendElement('plaintext', $tdAttr, $name);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
    $serialNo++;
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
