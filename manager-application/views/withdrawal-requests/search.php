<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}
foreach ($arrListing as $sn => $row) {
    
    $cls = (($row["withdrawal_id"] % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $row["withdrawal_id"]]);
    if ($row['withdrawal_payment_method'] == 0) {
        $row['withdrawal_payment_method'] = User::AFFILIATE_PAYMENT_METHOD_BANK;
    }
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr,  '#' . str_pad($row["withdrawal_id"], 6, '0', STR_PAD_LEFT));
                break;
            case 'user_details':
                $href = "javascript:void(0)";
                $onclick = ($canViewUsers ? 'redirectUser('. $row['user_id'] . ')' : '');
                $arr = User::getUserTypesArr($siteLangId);
                $userType = [];
                if ($row['user_is_buyer']) {
                    $userType[] = $arr[User::USER_TYPE_BUYER];
                }
                if ($row['user_is_supplier']) {
                    $userType[] = $arr[User::USER_TYPE_SELLER];
                }
                if ($row['user_is_advertiser']) {
                    $userType[] = $arr[User::USER_TYPE_ADVERTISER];
                }
                if ($row['user_is_affiliate']) {
                    $userType[] = $arr[User::USER_TYPE_AFFILIATE] ;
                }

                $str = $this->includeTemplate('_partial/user/user-info-card.php', [
                    'user' => $row,
                    'siteLangId' => $siteLangId,
                    'href' => $href,
                    'onclick' => $onclick,
                    'userType' => implode('/',$userType)
                ], false, true);

                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                break;
            case 'user_balance':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;
            case 'withdrawal_amount':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;
            case 'withdrawal_payment_method':
                $methodType = $paymentMethods + $payoutPlugins;
                $methodName = (isset($row[$key]) && isset($methodType[$row[$key]]) ? $methodType[$row[$key]] : Labels::getLabel('LBL_N/A', $siteLangId));
                $td->appendElement('plaintext', $tdAttr, $methodName);
                break;
            case 'withdrawal_request_date':
                $td->appendElement('plaintext', $tdAttr, HtmlHelper::formatDateTime($row[$key]), true);
                break;
            case 'withdrawal_status':
                $statusHtml = Transactions::getWithdrawlStatusHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtml, true);
                break;
            case 'action':
                $data = [   
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['withdrawal_id']
                ];

                if ($canEdit && $row['withdrawal_status'] == Transactions::STATUS_PENDING) {
                    $data['editButton'] = ['onclick'=>'editRecord(' . $row['withdrawal_id'] . ', false)'];
                }

                $data['otherButtons'] = [
                    [
                        'attr' => [
                            'href' =>  'javascript:void(0);',
                            'onclick' => 'viewDetails('.$row['withdrawal_id'].','.$siteLangId.')' ,
                            'title' => Labels::getLabel('LBL_VIEW_DETAILS', $siteLangId),
                        ],
                        'label' => "<i class='far fa-eye icon'></i>"
                    ]
                ];	                    

                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}