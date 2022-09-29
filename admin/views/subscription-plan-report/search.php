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
            case 'spplan_price':
            case 'amountPaid':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;
            case 'spackage_name':
                $name = $row['spackage_name'] . ' ';
                $name .= ($row['spackage_type'] == SellerPackages::PAID_TYPE) ? " /" . " " . Labels::getLabel("LBL_Per", $siteLangId) : Labels::getLabel("LBL_For", $siteLangId);

                $name .= " " . (($row['spplan_interval'] > 0) ? $row['spplan_interval'] : '')
                    . "  " . $subcriptionPeriodArr[$row['spplan_frequency']];
                $td->appendElement('plaintext', $tdAttr, $name);
                break;
            case 'spackageSold':
            case 'activeSubscribers':
            case 'spRenewalPendings':
            case 'spRenewals':
            case 'spackageCancelled':
                $td->appendElement('plaintext', $tdAttr, FatUtility::int($row[$key]), true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
    $serialNo++;
}

include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
