<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'order_number':
                $ctrl = (Orders::ORDER_SUBSCRIPTION == $row['order_type'] ? 'SubscriptionOrders' : 'Orders');
                $td->appendElement('a', array('target' => '_blank', 'href' => UrlHelper::generateUrl($ctrl, 'view', array($row['order_id']))), $row[$key], true);
                break;
            case 'couponhistory_amount':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row[$key]));
                break;
            case 'couponhistory_added_on':
                $td->appendElement('plaintext', $tdAttr, FatDate::format($row[$key]), true);
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
