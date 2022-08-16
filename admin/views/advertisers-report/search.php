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
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'name':
                $td->appendElement('plaintext', $tdAttr, $row['name'] . '<br/>(' . $row['email'] . ')', true);
                break;
            case 'user_regdate':
                $date = HtmlHelper::formatDateTime(
                    $row[$key],
                    true,
                    true,
                    FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
                );
                $td->appendElement('plaintext', $tdAttr, $date, true);
                break;
            case 'affiliateLink':
                $url = UrlHelper::generateFullUrl('Home', 'referral', [$row['user_referral_code']], CONF_WEBROOT_FRONTEND);
                $td->appendElement('plaintext', $tdAttr, '<a href="' . $url . '" target="_blank">' . $url, '</a>', true);
                break;
            case 'user_is_supplier':
                $val = applicationConstants::YES == $row[$key] ? Labels::getLabel('LBL_YES') : Labels::getLabel('LBL_NO');
                $td->appendElement('plaintext', $tdAttr, $val, true);
                break;
            case 'availableBalance':
            case 'totAffilateRevenue':
            case 'totAffilateSignupRevenue':
            case 'totAffilateOrdersRevenue':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;
            case 'promotionCharged':
            case 'activePromotions':
            case 'promotionsCount':
                $td->appendElement('plaintext', $tdAttr, FatUtility::int($row[$key], FatUtility::VAR_INT, 0), true);
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
