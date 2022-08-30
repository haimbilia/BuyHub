<?php

class UserRewards extends MyAppModel
{
    public const DB_TBL = 'tbl_user_reward_points';
    public const DB_TBL_PREFIX = 'urp_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject()
    {
        $srch = new SearchBase(static::DB_TBL, 'urp');
        return $srch;
    }

    public function save(bool $updateBreakpoints = true)
    {
        if (!($this->mainTableRecordId > 0)) {
            $this->setFldValue('urp_date_added', date('Y-m-d H:i:s'));
        }
        $output = parent::save();
        if (true === $updateBreakpoints) {
            static::getAndSetRewardsPointBreakup($this->getMainTableRecordId());
        }
        return $output;
    }

    public static function debit($userId, $rewardPointUsed, $orderId, $langId = 0)
    {
        $orderNo = Orders::getAttributesById($orderId, 'order_number');
        $rewardsRecord = new UserRewards();
        $rewarPointArr = array(
            'urp_user_id' => $userId,
            'urp_points' => '-' . $rewardPointUsed,
            'urp_used_order_id' => $orderId,
            'urp_comments' => Labels::getLabel('LBL_REWARD_POINT_USED_IN_CHECKOUT_WITH_ORDERID', $langId) . $orderNo,
        );
        $rewardsRecord->assignValues($rewarPointArr);
        if (!$rewardsRecord->save()) {
            return false;
        }

        $urpId = $rewardsRecord->getMainTableRecordId();
        $emailObj = new EmailHandler();
        if ($emailObj->sendRewardPointsNotification($langId, $urpId)) {
            return true;
        }

        return false;
    }

    public static function getAndSetRewardsPointBreakup($urpId)
    {
        $urpId = FatUtility::int($urpId);
        if (1 > $urpId) {
            trigger_error(Labels::getLabel('ERR_Invalid_Request', CommonHelper::getLangId()), E_USER_ERROR);
        }

        $srch = static::getSearchObject();
        $srch->addCondition('urp.urp_id', '=', 'mysql_func_' . $urpId, 'AND', true);
        $srch->doNotCalculateRecords();
        $result = FatApp::getDb()->fetch($srch->getResultSet());

        if (empty($result)) {
            return;
        }

        if ($result['urp_points'] > 0) {
            $assignValues = array(
                'urpbreakup_urp_id' => $result['urp_id'],
                'urpbreakup_referral_user_id' => $result['urp_referral_user_id'],
                'urpbreakup_points' => $result['urp_points'],
                'urpbreakup_expiry' => $result['urp_date_expiry'],
                'urpbreakup_used_order_id' => $result['urp_used_order_id'],
                'urpbreakup_used' => 0,
            );

            $obj = new UserRewardBreakup();
            $obj->assignValues($assignValues);
            if (!$obj->save()) {
                Message::addErrorMessage($obj->getError());
            }
        }

        if ($result['urp_points'] < 0) {
            $userRewardPoints = abs($result['urp_points']);

            $srch = new UserRewardSearch();
            $srch->joinUserRewardBreakup();
            $srch->addCondition('urpbreakup_used', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
            $srch->addCondition('urp_user_id', '=', $result['urp_user_id']);
            $cnd = $srch->addCondition('urp_date_expiry', '>=', date('Y-m-d'));
            $cnd->attachCondition('urp_date_expiry', '=', '0000-00-00');
            $srch->addOrder('urp_date_added', 'asc');
            $srch->addOrder('urp_date_expiry', 'asc');
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $unUsedRewardsPointsArr = FatApp::getDb()->fetchAll($srch->getResultSet());
            foreach ($unUsedRewardsPointsArr as $val) {
                if ($userRewardPoints == 0) {
                    break;
                }

                if ($val['urpbreakup_points'] > 0) {
                    if ($val['urpbreakup_points'] <= $userRewardPoints) {
                        $userRewardPoints = $userRewardPoints - $val['urpbreakup_points'];
                        $updateValues = array('urpbreakup_used' => 1, 'urpbreakup_used_order_id' => $result['urp_used_order_id'], 'urpbreakup_used_date' => date('Y-m-d H:i:s'));
                        $whr = array('smt' => 'urpbreakup_id = ?', 'vals' => array($val['urpbreakup_id']));
                        FatApp::getDb()->updateFromArray(UserRewardBreakup::DB_TBL, $updateValues, $whr);
                    } else {
                        $difference = $val['urpbreakup_points'] - $userRewardPoints;
                        $updateValues = array('urpbreakup_used' => 1, 'urpbreakup_used_order_id' => $result['urp_used_order_id'], 'urpbreakup_points' => $userRewardPoints);
                        $whr = array('smt' => 'urpbreakup_id = ?', 'vals' => array($val['urpbreakup_id']));
                        FatApp::getDb()->updateFromArray(UserRewardBreakup::DB_TBL, $updateValues, $whr);

                        $insertValuesArr = array(
                            'urpbreakup_urp_id' => $val['urpbreakup_urp_id'],
                            'urpbreakup_points' => $difference,
                            'urpbreakup_expiry' => $val['urpbreakup_expiry'],
                            'urpbreakup_used' => 0,
                            'urpbreakup_referral_user_id' => $val['urpbreakup_referral_user_id']
                        );
                        FatApp::getDb()->insertFromArray(UserRewardBreakup::DB_TBL, $insertValuesArr);
                        $userRewardPoints = 0;
                    }
                }
            }
        }
    }

    public static function isRewardPointUsed(int $rewardId)
    {
        $srch = new SearchBase(UserRewardBreakup::DB_TBL, 'urb');
        $srch->addCondition('urpbreakup_urp_id', '=', $rewardId);
        $srch->addCondition('urpbreakup_used', '=', applicationConstants::YES);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }
}
