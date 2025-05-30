<?php
class RfqOffers extends MyAppModel
{
    public const DB_TBL = 'tbl_rfq_offers';
    public const DB_TBL_PREFIX = 'offer_';

    public const DB_RFQ_LATEST_OFFER = 'tbl_rfq_latest_offers';
    public const DB_RLO_PREFIX = 'rlo_';
    public const DB_RO_MESSAGES = 'tbl_rfq_offer_messages';

    public const SELLER_ACCEPTANCE = 1;
    public const BUYER_ACCEPTANCE = 2;
    public int $messageId;

    public const FIELDS = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'primary_offer_id',
        self::DB_TBL_PREFIX . 'rfq_id',
        self::DB_TBL_PREFIX . 'user_id',
        self::DB_TBL_PREFIX . 'user_type',
        self::DB_TBL_PREFIX . 'counter_offer_id',
        self::DB_TBL_PREFIX . 'quantity',
        self::DB_TBL_PREFIX . 'cost',
        self::DB_TBL_PREFIX . 'price',
        self::DB_TBL_PREFIX . 'shiprate_id',
        self::DB_TBL_PREFIX . 'negotiable',
        self::DB_TBL_PREFIX . 'status',
        self::DB_TBL_PREFIX . 'comments',
        self::DB_TBL_PREFIX . 'expired_on',
        self::DB_TBL_PREFIX . 'added_on',
        self::DB_TBL_PREFIX . 'deleted',
    ];

    public const DB_RLO_FIELDS = [
        self::DB_RLO_PREFIX . 'primary_offer_id',
        self::DB_RLO_PREFIX . 'rfq_id',
        self::DB_RLO_PREFIX . 'seller_user_id',
        self::DB_RLO_PREFIX . 'seller_offer_id',
        self::DB_RLO_PREFIX . 'buyer_offer_id',
        self::DB_RLO_PREFIX . 'selprod_id',
        self::DB_RLO_PREFIX . 'shipping_charges',
        self::DB_RLO_PREFIX . 'accepted_offer_id',
        self::DB_RLO_PREFIX . 'status',
        self::DB_RLO_PREFIX . 'deleted',
    ];

    public const STATUS_OPEN = 0;
    public const STATUS_COUNTERED = 1;
    public const STATUS_REJECTED = 2;
    public const STATUS_ACCEPTED = 3;

    /**
     * __construct
     *
     * @param  mixed $id
     * @return void
     */
    public function __construct(int $id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->objMainTableRecord->setSensitiveFields([static::DB_TBL_PREFIX . 'id']);
    }

    /**
     * add
     *
     * @param  array $data
     * @return bool
     */
    public function add(array $data): bool
    {
        $this->assignValues($data);
        if (!$this->save()) {
            $msg = $this->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_OFFER_WITH_SAME_QUANTITY.');
            }
            $this->error = $msg;
            return false;
        }
        return true;
    }

    /**
     * updateLatestOffer
     *
     * @param  array $data
     * @return bool
     */
    public function updateLatestOffer(array $data): bool
    {
        if (empty($data)) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST');
            return false;
        }

        if (!FatApp::getDb()->insertFromArray(self::DB_RFQ_LATEST_OFFER, $data, true, array(), $data)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    /**
     * getStatusArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getStatusArr(int $langId): array
    {
        return [
            self::STATUS_OPEN => Labels::getLabel('LBL_OFFERED', $langId),
            self::STATUS_COUNTERED => Labels::getLabel('LBL_COUNTERED', $langId),
            self::STATUS_REJECTED => Labels::getLabel('LBL_REJECTED', $langId),
            self::STATUS_ACCEPTED => Labels::getLabel('LBL_ACCEPTED', $langId),
        ];
    }

    /**
     * getForm
     *
     * @return Form
     */
    public static function getBuyerForm(): Form
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', self::DB_TBL_PREFIX . 'id');
        $frm->addHiddenField('', self::DB_TBL_PREFIX . 'rfq_id');
        $frm->addHiddenField('', self::DB_TBL_PREFIX . 'counter_offer_id');

        $fld = $frm->addTextBox(Labels::getLabel('FRM_REQUEST_QUANTITY'), self::DB_TBL_PREFIX . 'quantity');
        $fld->requirement->setRequired(true);
        $fld->requirement->setPositive();
        $fld->requirement->setRange(1, 9999999999);

        $fld = $frm->addFloatField(Labels::getLabel('FRM_REQUEST_PRICE_PER_ITEM') . '[' . CommonHelper::getCurrencySymbol() . ']', self::DB_TBL_PREFIX . 'price');
        $fld->requirement->setRequired(true);
        $fld->htmlAfterField = '<span class="form-text text-muted opPerUnitJs">' . Labels::getLabel('LBL_TOTAL') . ': 0.00</span>';

        $fld = $frm->addTextArea(Labels::getLabel('FRM_COMMENTS_FOR_SELLER'), self::DB_TBL_PREFIX . 'comments');
        $fld->setFieldTagAttribute('maxlength', 300);
        return $frm;
    }

    public static function getSellerForm(): Form
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', self::DB_TBL_PREFIX . 'id');
        $frm->addHiddenField('', self::DB_TBL_PREFIX . 'rfq_id');
        $frm->addHiddenField('', self::DB_TBL_PREFIX . 'counter_offer_id');

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_SELLER'), 'offer_user_id', []);
        $fld->requirement->setRequired(true);

        $fld = $frm->addTextBox(Labels::getLabel('FRM_OFFER_QUANTITY'), self::DB_TBL_PREFIX . 'quantity');
        $fld->requirement->setRequired(true);
        $fld->requirement->setPositive();
        $fld->requirement->setRange(1, 9999999999);

        $fld = $frm->addFloatField(Labels::getLabel('FRM_OFFER_PRICE_PER_ITEM') . '[' . CommonHelper::getCurrencySymbol() . ']', self::DB_TBL_PREFIX . 'price');
        $fld->requirement->setRequired(true);
        $fld->htmlAfterField = '<span class="form-text text-muted opPerUnitJs">' . Labels::getLabel('LBL_TOTAL') . ': 0.00</span>';

        $fld = $frm->addFloatField(Labels::getLabel('FRM_OFFER_COST_PER_ITEM') . '[' . CommonHelper::getCurrencySymbol() . ']', self::DB_TBL_PREFIX . 'cost');
        $fld->requirement->setRequired(true);
        $fld->htmlAfterField = '<span class="form-text text-muted ocPerUnitJs">' . Labels::getLabel('LBL_TOTAL') . ': 0.00</span>';

        $fld = $frm->addTextBox(Labels::getLabel('FRM_CUSTOM_SHIPPING_CHARGES') . '[' . CommonHelper::getCurrencySymbol() . ']', 'rlo_shipping_charges');
        $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('LBL_THIS_WILL_OVERWRITE_SYSTEM_SHIPPING_CHARGES.') . '</span>';

        $frm->addDateField(Labels::getLabel('FRM_EXPIRED_ON'), RfqOffers::DB_TBL_PREFIX . 'expired_on', '', ['class' => 'field--calender', 'readonly' => 'readonly']);

        $fld = $frm->addTextArea(Labels::getLabel('FRM_COMMENTS_FOR_BUYER'), self::DB_TBL_PREFIX . 'comments');
        $fld->setFieldTagAttribute('maxlength', 300);

        $fld = $frm->addCheckBox(Labels::getLabel('FRM_BUYER_CAN_NEGOTIATE_THE_OFFER'), self::DB_TBL_PREFIX . 'negotiable', applicationConstants::ACTIVE, [], true, applicationConstants::INACTIVE);
        HtmlHelper::configureSwitchForCheckbox($fld);
        return $frm;
    }

    /**
     * isOfferPosted
     *
     * @param  int $rfqId
     * @param  int $sellerId
     * @return bool
     */
    public static function isPosted(int $rfqId, int $sellerId = 0, int $offerId = 0): bool
    {
        $srch = new RequestForQuoteSearch();
        $srch->joinOffers();
        $srch->addCondition('offer_deleted', '=', applicationConstants::NO);
        $srch->addCondition('rfq_deleted', '=', applicationConstants::NO);
        $srch->addCondition('offer_rfq_id', '=', $rfqId);
        if (0 < $sellerId) {
            $srch->addCondition('offer_user_id', '=', $sellerId);
        }
        if (0 < $offerId) {
            $srch->addCondition('offer_id', '!=', $offerId);
        }
        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();
        $srch->addFld('count(1) as totalRecords');
        $results = FatApp::getDb()->fetch($srch->getResultSet());
        $recordCount =  !empty($results['totalRecords']) ? $results['totalRecords'] : 0;
        return (0 < $recordCount) ? true : false;
    }

    /**
     * getPrimaryOfferId1
     *
     * @param  int $rfqId
     * @param  int $sellerOfferId
     * @param  int $buyerOfferId
     * @return int
     */
    public static function getPrimaryOfferId(int $rfqId, int $sellerOfferId = 0, int $buyerOfferId = 0): int
    {
        if (1 > $sellerOfferId && 1 > $buyerOfferId) {
            return 0;
        }
        $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('rlo_rfq_id', '=', 'mysql_func_' . $rfqId, 'AND', true);
        if (0 < $sellerOfferId) {
            $srch->addCondition('rlo_seller_offer_id', '=', 'mysql_func_' . $sellerOfferId, 'AND', true);
        }
        if (0 < $buyerOfferId) {
            $srch->addCondition('rlo_buyer_offer_id', '=', 'mysql_func_' . $buyerOfferId, 'AND', true);
        }
        $srch->addFld('rlo_primary_offer_id');
        return ((array)FatApp::getDb()->fetch($srch->getResultSet()))['rlo_primary_offer_id'] ?? 0;
    }

    /**
     * canDeleteSellerOffer
     *
     * @param int $rfqId
     * @param int $offerId
     * @return bool
     */
    public function getAllowedOfferIdToDelete($rfqId): int
    {
        $srch = new RequestForQuoteSearch();
        $srch->joinOffers(true);
        $srch->addCondition('ro.offer_id', '=', $this->mainTableRecordId);
        $srch->addCondition('rfq_deleted', '=', applicationConstants::NO);
        $srch->addCondition('rfq_id', '=', $rfqId);
        $srch->addMultipleFields(['ro.offer_id', 'ro.offer_counter_offer_id', 'rlo_primary_offer_id', 'rlo_seller_offer_id', 'rlo_buyer_offer_id']);
        $offersData = FatApp::getDb()->fetch($srch->getDataResultSet());

        if (0 < $offersData['offer_counter_offer_id']) {
            return 0;
        }

        if ($this->mainTableRecordId != $offersData['rlo_seller_offer_id']) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST');
            return 0;
        }

        if ($offersData['rlo_primary_offer_id'] == $offersData['rlo_seller_offer_id'] && 1 > $offersData['rlo_buyer_offer_id']) {
            return $offersData['rlo_seller_offer_id'];
        } else {
            $this->error = Labels::getLabel('ERR_NOT_ALLOWED!_COUNTERED_OFFER_ALREADY_PLACED');
        }

        return 0;
    }

    /**
     * canModify
     *
     * @param int $rfqId
     * @param int $offerId
     * @return bool
     */
    public static function canModify(int $rfqId, int $offerId): bool
    {
        $srch = new SearchBase(static::DB_TBL);
        $srch->joinTable(RfqOffers::DB_RFQ_LATEST_OFFER, 'INNER JOIN', 'rlo_primary_offer_id = offer_primary_offer_id', 'rlo');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition(static::tblFld('id'), '=', 'mysql_func_' . $offerId, 'AND', true);
        $srch->addCondition(static::tblFld('rfq_id'), '=', 'mysql_func_' . $rfqId, 'AND', true);
        $srch->addCondition(static::tblFld('deleted'), '=', 'mysql_func_0', 'AND', true);
        $srch->addCondition('rlo_status', '<', self::STATUS_ACCEPTED);
        // $srch->addCondition(static::tblFld('status'), 'IN', [self::STATUS_OPEN, self::STATUS_COUNTERED]);
        $srch->addFld('count(1) as totalRecords');
        $results = FatApp::getDb()->fetch($srch->getResultSet());
        $recordCount = !empty($results['totalRecords']) ? $results['totalRecords'] : 0;
        return (0 < $recordCount);
    }

    /**
     * canBuyerReply
     *
     * @param  int $offerId
     * @return bool
     */
    public static function canBuyerReply(int $offerId): bool
    {
        $offerInfo = RfqOffers::getAttributesById($offerId, ['offer_primary_offer_id', 'offer_negotiable', 'offer_status', 'offer_expired_on', 'offer_user_type']);
        if (false == $offerInfo || $offerInfo['offer_negotiable'] == applicationConstants::NO) {
            return false;
        }

        if (!in_array($offerInfo['offer_status'], [RfqOffers::STATUS_OPEN])) {
            if (RfqOffers::STATUS_COUNTERED == $offerInfo['offer_status']) {
                $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER, 'rlo');
                $srch->addCondition('rlo_primary_offer_id', '=', $offerInfo['offer_primary_offer_id']);
                $srch->doNotCalculateRecords();
                $srch->addMultipleFields(['rlo_seller_offer_id', 'rlo_buyer_offer_id']);
                $result = FatApp::getDb()->fetch($srch->getResultSet());
                if (User::USER_TYPE_SELLER == $offerInfo['offer_user_type']) {
                    return ($result['rlo_buyer_offer_id'] < $offerId);
                } else {
                    return ($result['rlo_seller_offer_id'] > $offerId);
                }
            }

            return false;
        }

        $expiredOn = strtotime($offerInfo['offer_expired_on']);
        if (0 < $expiredOn && strtotime(date('Y-m-d')) > $expiredOn) {
            return false;
        }

        return true;
    }

    /**
     * getOffersCountArr
     *
     * @param  array $offerPrimaryIds
     * @return array
     */
    public static function getOffersCountArr(array $offerPrimaryIds): array
    {
        $srch =  new RequestForQuoteSearch();
        $srch->joinOffers();
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(['offer_primary_offer_id', 'sum(if(ro.`offer_user_type` = ' . User::USER_TYPE_SELLER . ',1,0)) as sellerOffersCount', 'sum(if(ro.`offer_user_type` = ' . User::USER_TYPE_BUYER . ',1,0)) as buyerOffersCount']);
        $srch->addCondition('offer_primary_offer_id', 'IN', $offerPrimaryIds);
        $srch->addGroupBy('offer_primary_offer_id');
        return FatApp::getDb()->fetchAll($srch->getResultSet(), 'offer_primary_offer_id');
    }

    /**
     * getOfferIdByProdId
     *
     * @param  int $productId
     * @return int
     */
    public static function getOfferIdByProdId(int $productId): int
    {
        $srch = new SearchBase(static::DB_TBL);
        $srch->joinTable(RequestForQuote::DB_TBL, 'INNER JOIN', 'rfq_id = offer_rfq_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('rfq_product_id', '=', 'mysql_func_' . $productId, 'AND', true);
        $srch->addCondition('offer_status', '=', self::STATUS_ACCEPTED);
        $srch->addFld('offer_id');
        return ((array)FatApp::getDb()->fetch($srch->getResultSet()))['offer_id'] ?? 0;
    }

    /**
     * getUserRfqOfferObj
     *
     * @param  int $selprodId
     * @param  int $buyerId
     * @param  int $primaryOfferId
     * @return SearchBase
     */
    private static function getUserRfqOfferObj(int $selprodId, int $buyerId, int $primaryOfferId, bool $isAccepted = false): SearchBase
    {
        $srch = new SearchBase(RequestForQuote::DB_TBL, 'rfq');
        $srch->addCondition('rfq_user_id', '=', 'mysql_func_' . $buyerId, 'AND', true);
        $srch->addOrder('rfq_id', 'DESC');

        $rloCond = 'rlo_rfq_id = rfq_id';
        if (0 < $primaryOfferId) {
            $rloCond .= ' AND rlo_primary_offer_id = ' . $primaryOfferId;
        }

        if ($isAccepted) {
            $srch->joinTable(self::DB_RFQ_LATEST_OFFER, 'INNER JOIN', $rloCond . ' AND rlo_status = ' . self::STATUS_ACCEPTED, 'rlo');
        } else {
            $srch->joinTable(self::DB_RFQ_LATEST_OFFER, 'INNER JOIN', $rloCond, 'rlo');
        }

        $srch->joinTable(RequestForQuote::DB_RFQ_TO_SELLERS, 'INNER JOIN', 'rfqts_rfq_id = rfq_id', 'rfqs');
        $srch->addCondition('rfqts_selprod_id', '=', 'mysql_func_' . $selprodId, 'AND', true);
        $srch->joinTable(self::DB_TBL, 'INNER JOIN', 'ofr.offer_primary_offer_id = rlo_primary_offer_id', 'ofr');

        $srch->joinTable(OrderProduct::DB_TBL, 'LEFT JOIN', 'op_offer_id = rlo_accepted_offer_id', 'op');
        $srch->joinTable(Orders::DB_TBL_ORDER_PAYMENTS, 'LEFT JOIN', 'opayment_order_id = op.op_order_id', 'opay');

        if ($isAccepted) {
            $srch->addCondition('opayment_id', 'IS', 'mysql_func_NULL', 'AND', true);
        }

        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);

        $srch->addMultipleFields(['rfq_number', 'rlo_primary_offer_id', 'rlo_rfq_id', 'rlo_shipping_charges', 'ofr.offer_id', 'opayment_order_id as order_id', 'IFNULL(opayment_txn_status, 0) as order_payment_status']);
        return $srch;
    }

    /**
     * getPrimaryOfferDetail
     *
     * @param  int $selprodId
     * @param  int $buyerId
     * @param  int $primaryOfferId
     * @return array
     */
    public static function getPrimaryOfferDetail(int $selprodId, int $buyerId, int $primaryOfferId): array
    {
        $srch = self::getUserRfqOfferObj($selprodId, $buyerId, $primaryOfferId);
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        return is_array($row) ? $row : [];
    }

    /**
     * getAcceptedOfferBySelProdId
     *
     * @param  int $selprodId
     * @param  int $buyerId
     * @param  int $primaryOfferId
     * @return array
     */
    public static function getAcceptedOfferBySelProdId(int $selprodId, int $buyerId, int $primaryOfferId = 0): array
    {
        $srch = self::getUserRfqOfferObj($selprodId, $buyerId, $primaryOfferId, true);
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        return is_array($row) ? $row : [];
    }

    /**
     * getAllAcceptedOffers
     *
     * @param  int $loggedUserId
     * @return array
     */
    public static function getAllAcceptedOffers(int $loggedUserId, int $rfqId = 0, bool $getFullDetail = false, int $langId = 0): array
    {
        $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER, 'rlo');
        $srch->addCondition('rlo_status', '=', self::STATUS_ACCEPTED);
        $srch->joinTable(self::DB_TBL, 'INNER JOIN', 'offer_id = rlo_seller_offer_id', 'ro');
        $srch->joinTable(RequestForQuote::DB_TBL, 'INNER JOIN', 'rfq_id = rlo_rfq_id AND rfq_user_id = ' . $loggedUserId, 'rfq');

        $paidStatus = FatApp::getConfig('CONF_DEFAULT_PAID_ORDER_STATUS', FatUtility::VAR_INT, 0);
        $srch->joinTable(OrderProduct::DB_TBL, 'LEFT JOIN', 'op.op_offer_id = rlo_accepted_offer_id AND op.op_selprod_id = rlo.rlo_selprod_id AND op.op_status_id = ' . $paidStatus, 'op');
        $srch->joinTable(Orders::DB_TBL_ORDER_PAYMENTS, 'LEFT JOIN', 'opayment_order_id = op.op_order_id', 'opay');

        if (0 < $rfqId) {
            $srch->addCondition('rlo_rfq_id', '=', $rfqId);
        }

        $srch->doNotCalculateRecords();
        if ($getFullDetail) {
            $langId = 0 < $langId ? $langId : CommonHelper::getLangId();
            $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'rlo_seller_user_id = su.user_id', 'su');
            $srch->joinTable(Shop::DB_TBL, 'INNER JOIN', 'shop_user_id = rlo_seller_user_id', 'shp');
            $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'shoplang_shop_id = shop_id AND shoplang_lang_id = ' . $langId, 'shp_l');
            $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'rlo_seller_user_id = scred.credential_user_id', 'scred');

            $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'rfq_user_id = bu.user_id', 'bu');
            $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'rfq_user_id = bcred.credential_user_id', 'bcred');
            $srch->joinTable(RfqOffers::DB_TBL, 'INNER JOIN', 'rlo_accepted_offer_id = ao.offer_id', 'ao');
            $srch->addMultipleFields([
                'su.user_name as seller_name',
                'COALESCE(shop_name, shop_identifier) as shop_name',
                'scred.credential_email as seller_email',
                'shop_phone_dcode as seller_phone_dcode',
                'shop_phone as seller_phone',
                'bu.user_name as buyer_name',
                'bcred.credential_email as buyer_email',
                'bu.user_phone_dcode as buyer_phone_dcode',
                'bu.user_phone as buyer_phone',
                'rlo_shipping_charges',
                'ao.offer_quantity',
                'ao.offer_price',
                'ao.offer_comments',
                'rlo_selprod_id as selprod_id',
                'rlo_primary_offer_id as primary_offer_id',
                'rlo_accepted_offer_id as accepted_offer_id'
            ]);
            return FatApp::getDb()->fetchAll($srch->getResultSet());
        }

        $srch->addCondition('opayment_id', 'IS', 'mysql_func_NULL', 'AND', true);
        $srch->addMultipleFields(['rlo_selprod_id as selprod_id', 'rlo_primary_offer_id as primary_offer_id', 'rlo_accepted_offer_id as accepted_offer_id']);
        return FatApp::getDb()->fetchAll($srch->getResultSet(), 'selprod_id');
    }

    /**
     * Checks if the order with the given accepted offer ID has been paid for. 
     * Joins with order payments table to check for non-null payment records.
     * Returns true if a paid payment record exists for the order, false otherwise.
     */
    public static function isBought(int $acceptedOfferId): bool
    {
        $srch = OrderProduct::getSearchObject();
        $srch->joinTable(Orders::DB_TBL, 'LEFT JOIN', 'op_order_id = order_id', 'o');
        $srch->joinTable(Plugin::DB_TBL, 'LEFT JOIN', 'order_pmethod_id = plugin_id', 'p');
        $srch->joinTable(Orders::DB_TBL_ORDER_PAYMENTS, 'LEFT JOIN', 'opayment_order_id = op_order_id', 'opay');
        $srch->addDirectCondition("(
            (
                `opayment_id` IS NOT NULL
                AND (
                    `opayment_txn_status` = '" . Orders::ORDER_PAYMENT_PAID . "'
                    OR `opayment_method` LIKE 'CashOnDelivery'
                )
            ) OR `plugin_code` LIKE 'TransferBank'
        )");
        $srch->addCondition('op_offer_id', '=', $acceptedOfferId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addFld('opayment_order_id');
        $result = FatApp::getDb()->fetch($srch->getResultSet());
        return (is_array($result) && !empty($result));
    }

    public static function getStatus($offerStatus, $counterOfferStatus)
    {
        return ($offerStatus > $counterOfferStatus) ? $offerStatus : $counterOfferStatus;
    }

    /**
     * getBadgeClass
     *
     * @param  int $status
     * @return string
     */
    public static function getBadgeClass(int $status): string
    {
        $cls = '';
        switch ($status) {
            case self::STATUS_OPEN:
                $cls = 'badge badge-info';
                break;
            case self::STATUS_COUNTERED:
                $cls = 'badge badge-warning';
                break;
            case self::STATUS_REJECTED:
                $cls = 'badge badge-danger';
                break;
            case self::STATUS_ACCEPTED:
                $cls = 'badge badge-success';
                break;
            default:
                $cls = 'badge badge-info';
                break;
        }
        return $cls;
    }

    /**
     * getAttachmentForm
     *
     * @param  bool $isBuyer
     * @return Form
     */
    public static function getAttachmentForm(bool $isBuyer = false): Form
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'rom_primary_offer_id');

        $fld = $frm->addTextArea(Labels::getLabel('LBL_MESSAGE'), 'rom_message', '', ['placeholder' => Labels::getLabel('LBL_TYPE_YOUR_MESSAGE..')]);
        $fld->requirements()->setRequired(true);

        $fld = $frm->addFileUpload(Labels::getLabel('FRM_ATTACHMENT_FILE'), 'attachment_file');

        if (false === $isBuyer) {
            $frm->addCheckBox(Labels::getLabel('FRM_BUYER_ACCESS'), 'rom_buyer_access', applicationConstants::ACTIVE, array(), true, applicationConstants::INACTIVE);
        }
        return $frm;
    }

    /**
     * addMessage
     *
     * @param  array $data
     * @return bool
     */
    public function addMessage(array $data): bool
    {
        if (empty($data)) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST');
            return false;
        }

        $db = FatApp::getDb();
        if (!$db->insertFromArray(self::DB_RO_MESSAGES, $data, true, array(), $data)) {
            $this->error = $db->getError();
            return false;
        }

        $this->messageId = $db->getInsertId();
        return true;
    }

    /**
     * getMessageId
     *
     * @return int
     */
    public function getMessageId(): int
    {
        return (int)$this->messageId;
    }

    /**
     * getMessages
     *
     * @param  int $primaryOfferId
     * @param  int $page
     * @param  int $pageSize
     * @return array
     */
    public static function getMessages(int $primaryOfferId, int $page = 1, int $pageSize = 5, bool $hideForBuyer = false, bool $onlyWithAttachments = false): array
    {
        if (1 > $primaryOfferId) {
            return [];
        }
        $srch = new SearchBase(self::DB_RO_MESSAGES, 'rom');
        $join = $onlyWithAttachments ? 'INNER' : 'LEFT';
        $srch->joinTable(AttachedFile::DB_TBL, $join . ' JOIN', 'afile_record_id = rom_id AND afile_record_subid = rom_primary_offer_id AND afile_type = ' . AttachedFile::FILETYPE_RFQ_OFFER_FILE);
        $srch->addCondition('rom_primary_offer_id', '=', $primaryOfferId);
        if (true == $hideForBuyer) {
            $srch->addDirectCondition("(CASE WHEN rom_user_type = " . User::USER_TYPE_SELLER . " THEN rom_buyer_access = 1 ELSE TRUE END)");
        }
        $srch->addMultipleFields(['rom_id', 'rom_primary_offer_id', 'rom_user_type', 'rom_message', 'rom_added_on', 'rom_buyer_access', 'afile_id', 'afile_name']);
        $srch->addOrder('rom_id', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $data = FatApp::getDb()->fetchAll($srch->getResultSet());

        return [
            'pageCount' => $srch->pages(),
            'data' => $data
        ];
    }

    public static function getSellers(int $langId): array
    {
        $srch = User::getSearchObject(true);
        $srch->addCondition('user_is_supplier', '=', applicationConstants::YES);
        $srch->addCondition('credential_active', '=', applicationConstants::YES);
        $srch->addCondition('credential_verified', '=', applicationConstants::YES);
        $srch->joinTable(RequestForQuote::DB_RFQ_TO_SELLERS, 'INNER JOIN', 'rfqts_user_id = user_id', 'rfqts');
        $srch->joinTable(RequestForQuote::DB_TBL, 'INNER JOIN', 'rfqts_rfq_id = rfq_id', 'rfq');
        $srch->joinTable(SellerProduct::DB_TBL, 'LEFT JOIN', 'selprod_user_id = rfqts_user_id AND selprod_code LIKE rfq_selprod_code', 'sp');
        $srch->joinTable(Shop::DB_TBL, 'INNER JOIN', 'shop_user_id = selprod_user_id', 'shop');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'shoplang_shop_id = shop_id AND shoplang_lang_id = ' . $langId, 'shop_l');
        $srch->addCondition('shop_active', '=', applicationConstants::ACTIVE);

        $attr = [
            'user_name',
            'user_id',
            'credential_email',
            'selprod_code',
            'COALESCE(shop_name, shop_identifier) AS shop_name',
        ];
        $srch->addOrder('user_name', 'ASC');
        $srch->addMultipleFields($attr);

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cond = $srch->addCondition('uc.credential_username', 'like', '%' . $keyword . '%');
            $cond->attachCondition('uc.credential_email', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('u.user_name', 'like', '%' . $keyword . '%');
        }

        $rfqId = FatApp::getPostedData('rfq_id', FatUtility::VAR_INT, 0);
        if (0 < $rfqId) {
            $srch->addCondition('rfqts_rfq_id', '=', $rfqId);
        }
        $srch->addCondition('selprod_code', 'IS NOT', 'mysql_func_NULL', 'AND', true);
        $srch->doNotCalculateRecords();
        $users = FatApp::getDb()->fetchAll($srch->getResultSet(), 'user_id');
        $json = array(
            'pageCount' => $srch->pages(),
            'results' => []
        );

        foreach ($users as $key => $user) {
            $name = $user['user_name'] . ' (' . $user['shop_name'] . ')';
            $json['results'][] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($name, ENT_QUOTES, 'UTF-8'))
            );
        }

        return $json;
    }

    public static function validateOfferRequest($rfqId, $qty, $sellerId): bool
    {
        $srch = new SearchBase(self::DB_TBL);
        $srch->joinTable(self::DB_RFQ_LATEST_OFFER, 'INNER JOIN', 'offer_rfq_id = rlo.rlo_rfq_id AND offer_primary_offer_id = rlo.rlo_primary_offer_id', 'rlo');
        $srch->addCondition('offer_rfq_id', '=', $rfqId);
        $srch->addCondition('offer_quantity', '=', $qty);
        $srch->addCondition('offer_deleted', '=', applicationConstants::NO);
        $srch->addCondition('offer_user_id', '=', $sellerId);
        $srch->addCondition('rlo_deleted', '=', applicationConstants::NO);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addFld('offer_id');
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        return empty($row);
    }

    public static function getMessageRow(int $messageId, $langId): array
    {
        if (1 > $messageId) {
            return [];
        }
        $srch = new SearchBase(self::DB_RO_MESSAGES, 'rom');
        $srch->joinTable(AttachedFile::DB_TBL, 'LEFT JOIN', 'afile_record_id = rom_id AND afile_record_subid = rom_primary_offer_id AND afile_type = ' . AttachedFile::FILETYPE_RFQ_OFFER_FILE);
        $srch->addCondition('rom_id', '=', $messageId);
        $srch->addMultipleFields(['rom_id', 'rom_message', 'rom_primary_offer_id', 'rom_added_on', 'rom_user_type', 'rom_buyer_access', 'afile_id', 'afile_name']);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $data = FatApp::getDb()->fetch($srch->getResultSet());
        return (is_array($data) ? $data : []);
    }

    public static function getShippingCharges(int $primaryOfferId): float
    {
        if (1 > $primaryOfferId) {
            return 0;
        }
        $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER, 'rlo');
        $srch->addCondition('rlo_primary_offer_id', '=', $primaryOfferId);
        $srch->doNotCalculateRecords();
        $srch->addFld('rlo_shipping_charges');
        $result = FatApp::getDb()->fetch($srch->getResultSet());
        $charges = !is_array($result) || empty($result) ? 0 : $result['rlo_shipping_charges'];
        return FatUtility::float($charges);
    }

    public static function getSubmittedOffersCount(int $sellerId, string $fromDate = ''): int
    {
        $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER, 'rlo');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        if (!empty($fromDate)) {
            $srch->addCondition('rlo_added_on', '>=', $fromDate);
        }
        $srch->addCondition('rlo_seller_user_id', '=', $sellerId);
        $srch->addFld('IFNULL(COUNT(rlo_primary_offer_id), 0) as submitted_offers_count');
        $result = FatApp::getDb()->fetch($srch->getResultSet());
        return $result['submitted_offers_count'] ?? 0;
    }

    public static function hasValidSubscription(int $sellerId, int $langId): bool
    {
        if (1 > FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE', FatUtility::VAR_INT, 0)) {
            return true;
        }
        $plan = OrderSubscription::getUserCurrentActivePlanDetails($langId, $sellerId, ['order_date_added', 'ossubs_rfq_offers_allowed']);
        $allowedLimit = (int) ($plan['ossubs_rfq_offers_allowed'] ?? 0);

        $submittedOffersCount = self::getSubmittedOffersCount($sellerId, $plan['order_date_added']);
        return ($submittedOffersCount < $allowedLimit);
    }

    public static function getSellerIdByOfferId(int $offerId): int
    {
        $srch = new SearchBase(self::DB_TBL, 'ro');
        $srch->joinTable(self::DB_RFQ_LATEST_OFFER, 'INNER JOIN', 'rlo_primary_offer_id = offer_primary_offer_id', 'rlo');
        $srch->addCondition('offer_id', '=', $offerId);
        $srch->addFld('rlo_seller_user_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $result = FatApp::getDb()->fetch($srch->getResultSet());
        return $result['rlo_seller_user_id'] ?? 0;
    }

    public static function hasAnyBuyerAcceptedOffer(int $sellerId, int $rfqId)
    {
        $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER, 'rlo');
        $srch->doNotCalculateRecords();
        $srch->addCondition('rlo_seller_user_id', '=', $sellerId);
        $srch->addCondition('rlo_rfq_id', '=', $rfqId);
        $srch->addCondition('rlo_buyer_acceptance', '=', applicationConstants::YES);
        $srch->addFld('rlo_primary_offer_id');
        $srch->setPageSize(1);
        $result = FatApp::getDb()->fetch($srch->getResultSet());
        return !empty($result);
    }

    public static function isAnySellerOfferAccepted(int $sellerId, int $rfqId)
    {
        $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER, 'rlo');
        $srch->doNotCalculateRecords();
        $srch->addCondition('rlo_seller_user_id', '=', $sellerId);
        $srch->addCondition('rlo_rfq_id', '=', $rfqId);
        $srch->addCondition('rlo_buyer_acceptance', '=', applicationConstants::YES);
        $srch->addCondition('rlo_seller_acceptance', '=', applicationConstants::YES);
        $srch->addCondition('rlo_status', '=', self::STATUS_ACCEPTED);
        $srch->addFld('rlo_primary_offer_id');
        $srch->setPageSize(1);
        $result = FatApp::getDb()->fetch($srch->getResultSet());
        return !empty($result);
    }

    public static function unreadMessagesForBuyer(int $buyerId, int $primaryOfferId): array
    {
        $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER, 'rlo');
        $srch->doNotCalculateRecords();
        $srch->joinTable(self::DB_RO_MESSAGES, 'INNER JOIN', 'rom.rom_primary_offer_id = rlo.rlo_primary_offer_id', 'rom');
        $srch->joinTable(RequestForQuote::DB_TBL, 'INNER JOIN', 'rfq.rfq_id = rlo.rlo_rfq_id', 'rfq');
        $srch->joinTable(AttachedFile::DB_TBL, 'LEFT JOIN', 'afile_record_id = rom_id AND afile_record_subid = rom_primary_offer_id AND afile_type = ' . AttachedFile::FILETYPE_RFQ_OFFER_FILE);
        $srch->addCondition('rlo.rlo_primary_offer_id', '=', $primaryOfferId);
        $srch->addCondition('rom_user_type', '=', User::USER_TYPE_SELLER); // Sent by seller.
        $srch->addCondition('rom_buyer_access', '=', applicationConstants::YES);
        $srch->addCondition('rfq_user_id', '=', $buyerId);
        $srch->addCondition('rom_read', '=', applicationConstants::NO);
        $srch->addMultipleFields([
            'SUM((CASE WHEN afile_id IS NULL THEN 0 ELSE 1 END)) as attachmentCount',
            'SUM(1) as totalUnread'
        ]);
        $srch->setPageSize(1);
        $result = FatApp::getDb()->fetch($srch->getResultSet());
        if (!is_array($result)) {
            return [
                'attachmentCount' => 0,
                'totalUnread' => 0,
            ];
        }
        return FatUtility::convertToType($result, FatUtility::VAR_INT);
    }

    public static function unreadMessagesForSeller(int $sellerId, int $primaryOfferId): array
    {
        $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER, 'rlo');
        $srch->joinTable(self::DB_RO_MESSAGES, 'INNER JOIN', 'rom.rom_primary_offer_id = rlo.rlo_primary_offer_id', 'rom');
        $srch->joinTable(AttachedFile::DB_TBL, 'LEFT JOIN', 'afile_record_id = rom_id AND afile_record_subid = rom_primary_offer_id AND afile_type = ' . AttachedFile::FILETYPE_RFQ_OFFER_FILE);
        $srch->addCondition('rlo.rlo_primary_offer_id', '=', $primaryOfferId);
        $srch->addCondition('rom_user_type', '=', User::USER_TYPE_BUYER); // Sent by buyer.
        $srch->addCondition('rlo_seller_user_id', '=', $sellerId);
        $srch->addCondition('rom_read', '=', applicationConstants::NO);
        $srch->addMultipleFields([
            'SUM((CASE WHEN afile_id IS NULL THEN 0 ELSE 1 END)) as attachmentCount',
            'SUM(1) as totalUnread'
        ]);
        $srch->setPageSize(1);
        $result = FatApp::getDb()->fetch($srch->getResultSet());
        if (!is_array($result)) {
            return [
                'attachmentCount' => 0,
                'totalUnread' => 0,
            ];
        }
        return FatUtility::convertToType($result, FatUtility::VAR_INT);
    }

    public static function markMessagesAsRead(int $primaryOfferId, array $messageIdArr): bool
    {
        $qry = "UPDATE " . self::DB_RO_MESSAGES . " SET rom_read = " . applicationConstants::YES . " WHERE rom_id IN (" . implode(',', $messageIdArr) . ") AND rom_primary_offer_id = " . $primaryOfferId;
        return FatApp::getDb()->query($qry);
    }

    public static function hasAnySellerAcceptance(int $rfqId, int $sellerId): bool
    {
        $srch = new SearchBase(self::DB_RFQ_LATEST_OFFER, 'rlo');
        $srch->addCondition('rlo_seller_acceptance', '=', applicationConstants::YES);
        $srch->addCondition('rlo_rfq_id', '=', $rfqId);
        $srch->addCondition('rlo_seller_user_id', '=', $sellerId);
        $srch->addFld('rlo_primary_offer_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $result = FatApp::getDb()->fetch($srch->getResultSet());
        return (!is_array($result) || empty($result));
    }
}
