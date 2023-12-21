<?php

use Braintree\Test\Transaction;
use Google\Service\CloudBuild\UserCredential;

class GiftCards extends MyAppModel
{
    public const DB_TBL = 'tbl_order_gift_cards';
    public const DB_TBL_PREFIX = 'ogcards_';
    private $db;
    const STATUS_UNUSED = 0;
    const STATUS_USED = 1;
    const STATUS_CANCELLED = 2;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }


    public static function getSearchObject()
    {
        $srch = new SearchBase(static::DB_TBL, 'ogc');
        return $srch;
    }

    public static function getGiftCards(int $userId)
    {
        $srch = new SearchBase(static::DB_TBL, 'giftcard');
        $srch->joinTable(Orders::DB_TBL, 'INNER JOIN', 'giftcard.ogcards_order_id = orders.order_id', 'orders');

        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'sender.user_id = orders.order_user_id', 'sender');
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'sender.user_id = sendercred.credential_user_id', 'sendercred');
        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'receiver.user_id = giftcard.ogcards_receiver_id', 'receiver');
        $srch->addMultipleFields([
            'sender.user_name',
            'sendercred.credential_email',
            'sender.user_id as sender_id',
            'receiver.user_name',
            'ogcards_id', 'ogcards_code', 'order_net_amount'
        ]);
        $srch->addCondition('order_user_id', '!=', $userId);
        $srch->addCondition('ogcards_receiver_id', '=', $userId);
        $srch->addCondition('ogcards_status', '=', self::STATUS_UNUSED);
        $srch->addCondition('order_payment_status', '=', Orders::ORDER_PAYMENT_PAID);
        $srch->addCondition('order_type', '=', Orders::GIFT_CARD_TYPE);  // COmpleted
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }


    public function redeem(string $code, int $userId, $langId = 0): bool
    {
        if ($langId == 0) {
            $langId = $this->commonLangId;
        }
        if (!$card = $this->getCardForRedeem($code, $userId)) {
            $this->error = Labels::getLabel('LBL_INVALID_OR_EXPIRED_GIFTCARD');
            return false;
        }
        $db = FatApp::getDb();
        $db->startTransaction();
        $record = new GiftCards($card['ogcards_id']);
        $record->assignValues([
            "ogcards_id" => $card['ogcards_id'],
            "ogcards_status" => static::STATUS_USED,
            "ogcards_usedon" => date("Y-m-d H:i:s")
        ]);
        if (!$record->save()) {
            $db->rollbackTransaction();
            $this->error = $record->getError();
            return false;
        }
        $comment = Labels::getLabel('LBL_GIFTCARD_REDEEM_TO_WALLET_{amount}_BY_GIFT_CODE_{code}');
        $comment = str_replace(['{amount}', '{code}'], [CommonHelper::displayMoneyFormat($card['order_net_amount']), $card['ogcards_code']], $comment);
        if (!Transactions::creditWallet(UserAuthentication::getLoggedUserId(), Transactions::TYPE_GIFT_CARD, $card['order_net_amount'], $langId, $comment)) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError(Labels::getLabel('LBL_INVALID_OR_EXPIRED_GIFTCARD'));
        }

        $db->commitTransaction();
        $email = new EmailHandler();
        $email->sendRedeemGiftCardNotification($card);
        return true;
    }

    public function getCardForRedeem(string $code, int $userId)
    {
        $srch = new SearchBase(static::DB_TBL, 'giftcard');
        $srch->joinTable(Orders::DB_TBL, 'INNER JOIN', 'giftcard.ogcards_order_id = orders.order_id', 'orders');

        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'sender.user_id = orders.order_user_id', 'sender');
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'sender.user_id = sendercred.credential_user_id', 'sendercred');
        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'receiver.user_id = giftcard.ogcards_receiver_id', 'receiver');
        $srch->addMultipleFields([
            'sender.user_name',
            'sendercred.credential_email',
            'sender.user_id as sender_id',
            'receiver.user_name',
            'ogcards_id', 'ogcards_code', 'order_net_amount'
        ]);
        $srch->addCondition('order_user_id', '!=', $userId);
        $srch->addCondition('ogcards_receiver_id', '=', $userId);
        $srch->addCondition('ogcards_code', '=', $code);
        $srch->addCondition('ogcards_status', '=', static::STATUS_UNUSED);
        $srch->addCondition('order_payment_status', '=', Orders::ORDER_PAYMENT_PAID);
        $srch->addCondition('order_type', '=', Orders::GIFT_CARD_TYPE);  // COmpleted
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }
}
