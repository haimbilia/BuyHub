<?php
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
        return new SearchBase(static::DB_TBL, 'ogc');
    }

    public static function getStatusArr(int $langId)
    {
        return [
            self::STATUS_UNUSED => Labels::getLabel('FRM_UNUSED', $langId),
            self::STATUS_USED => Labels::getLabel('FRM_USED', $langId),
        ];
    }

    public static function getGiftCards(int $userId, string $code = '')
    {
        $srch = self::getSearchObject();
        $srch->joinTable(Orders::DB_TBL, 'INNER JOIN', 'ogc.ogcards_order_id = orders.order_id', 'orders');

        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'sender.user_id = orders.order_user_id', 'sender');
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'sender.user_id = sendercred.credential_user_id', 'sendercred');
        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'receiver.user_id = ogc.ogcards_receiver_id', 'receiver');
        $srch->addMultipleFields([
            'sender.user_name',
            'sendercred.credential_email',
            'sender.user_id as sender_id',
            'receiver.user_name',
            'ogcards_id',
            'ogcards_code',
            'order_net_amount'
        ]);
        $srch->addCondition('order_user_id', '!=', $userId);
        $srch->addCondition('ogcards_receiver_id', '=', $userId);
        $srch->addCondition('ogcards_status', '=', self::STATUS_UNUSED);
        $srch->addCondition('order_payment_status', '=', Orders::ORDER_PAYMENT_PAID);
        $srch->addCondition('order_type', '=', Orders::GIFT_CARD_TYPE);

        if (!empty($code)) {
            $srch->addCondition('ogcards_code', '=', $code);
        }

        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

    public function redeem(string $code, int $userId, int $langId = 0): bool
    {
        if ($langId == 0) {
            $langId = $this->commonLangId;
        }
        if (!$card = $this->getGiftCards($userId, $code)) {
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
        $comment = Labels::getLabel('LBL_GIFTCARD_REDEEMED_TO_WALLET_{AMOUNT}_BY_GIFT_CODE_{CODE}');
        $comment = CommonHelper::replaceStringData($comment, ['{AMOUNT}' => CommonHelper::displayMoneyFormat($card['order_net_amount']), '{CODE}' => $card['ogcards_code']]);
        if (!Transactions::creditWallet($userId, Transactions::TYPE_GIFT_CARD, $card['order_net_amount'], $langId, $comment)) {
            $db->rollbackTransaction();
            $this->error = Labels::getLabel('LBL_UNABLE_TO_REDEEM');
            return false;
        }

        $db->commitTransaction();
        $email = new EmailHandler();
        $email->sendRedeemGiftCardNotification($card);
        return true;
    }
}
