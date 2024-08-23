<?php defined('SYSTEM_INIT') or die('Invalid Usage.');


$txnStatusArr = $statusArr;


foreach ($arrListing as $key => &$value) {
    $value['utxn_statusLabel'] = $txnStatusArr[$value['utxn_status']];
    $value['utxn_id'] = Transactions::formatTransactionNumber($value['utxn_id']);
    $value['balance'] = CommonHelper::displayMoneyFormat($value['balance']);
    $value['utxn_credit'] = CommonHelper::displayMoneyFormat($value['utxn_credit']);
    $value['utxn_debit'] = CommonHelper::displayMoneyFormat($value['utxn_debit']);
}

$data = array(
    'creditsListing' => array_values($arrListing),
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'canRedeemGiftCard' => $canRedeemGiftCard ? 1 : 0,
    'userWalletBalance' => CommonHelper::displayMoneyFormat($userWalletBalance, false, false, false),
    'displayUserWalletBalance' => CommonHelper::displayMoneyFormat($userWalletBalance),    
    'userTotalWalletBalance' => CommonHelper::displayMoneyFormat($userTotalWalletBalance),
    'promotionWalletToBeCharged' => $promotionWalletToBeCharged,
    'withdrawlRequestAmount' => CommonHelper::displayMoneyFormat($withdrawlRequestAmount),
    'txnStatusArr' => $txnStatusArr,
);

if (1 > $recordCount) {
    $status = applicationConstants::OFF;
}
