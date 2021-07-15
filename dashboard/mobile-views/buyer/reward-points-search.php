<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$rewardPoints = UserRewardBreakup::rewardPointBalance(UserAuthentication::getLoggedUserId(true));

$rewardPointsDetail = array(
    'balance' => $rewardPoints,
    'convertedValue' => CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($rewardPoints)),
);

$data = array(
    'rewardPointsDetail' => $rewardPointsDetail,
    'rewardPointsStatement' => $arrListing,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'page' => $page,
    'pageSize' => $pageSize,
    'convertReward' => $convertReward,
);

if (empty($arrListing)) {
    $status = applicationConstants::OFF;
}
