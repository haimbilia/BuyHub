<?php
class RequestForQuote extends MyAppModel
{
    public const DB_TBL = 'tbl_rfq';
    public const DB_TBL_PREFIX = 'rfq_';

    public const DB_RFQ_TO_SELLERS = 'tbl_rfq_to_sellers';
    public const DB_RFQS_PREFIX = 'rfqts_';

    public const FIELDS = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'number',
        self::DB_TBL_PREFIX . 'selprod_id',
        self::DB_TBL_PREFIX . 'product_id',
        self::DB_TBL_PREFIX . 'title',
        self::DB_TBL_PREFIX . 'user_id',
        self::DB_TBL_PREFIX . 'type',
        self::DB_TBL_PREFIX . 'quantity',
        self::DB_TBL_PREFIX . 'quantity_unit',
        self::DB_TBL_PREFIX . 'delivery_date',
        self::DB_TBL_PREFIX . 'description',
        self::DB_TBL_PREFIX . 'addr_id',
        self::DB_TBL_PREFIX . 'lang_id',
        self::DB_TBL_PREFIX . 'status',
        self::DB_TBL_PREFIX . 'approved',
        self::DB_TBL_PREFIX . 'added_on',
        self::DB_TBL_PREFIX . 'deleted',
    ];

    public const RFQ_TO_SUPPLIER_FIELDS = [
        self::DB_RFQS_PREFIX . 'rfq_id',
        self::DB_RFQS_PREFIX . 'user_id',
    ];

    public const TYPE_INDIVIDUAL = 1;
    public const TYPE_VARIANT = 2;
    public const TYPE_CATALOG = 3;
    public const TYPE_CUSTOM = 4;

    public const PENDING = 0;
    public const APPROVED = 1;
    public const REJECTED = 2;

    public const STATUS_OPEN = 0;
    public const STATUS_OFFERED = 1;
    public const STATUS_ACCEPTED = 2;
    public const STATUS_CLOSED = 3;
    public const STATUS_COMPLETED = 4;

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
        if (1 > $this->getMainTableRecordId()) {
            $data['rfq_number'] = $this->generateRfqNo();
        }
        $this->assignValues($data);
        if (!$this->save()) {
            $msg = $this->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD.');
            }
            $this->error = $msg;
            return false;
        }
        return true;
    }

    /**
     * generateRfqNo
     *
     * @return string
     */
    private function generateRfqNo(): string
    {
        $rfqNo =  'RFQ' . mt_rand(1000000000, 9999999999);
        if ($this->checkUniqueRfqNo($rfqNo)) {
            return $rfqNo;
        }

        $this->generateRfqNo();
    }

    /**
     * checkUniqueRfqNo
     *
     * @param  string $rfqNo
     * @return bool
     */
    private function checkUniqueRfqNo(string $rfqNo): bool
    {
        $srch = new RequestForQuoteSearch();
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addFld('rfq_id');
        $srch->addCondition('rfq_number', '=', $rfqNo);
        $row = (array) FatApp::getDb()->fetch($srch->getResultSet());
        return empty($row);
    }

    /**
     * getRfqNo
     *
     * @return string
     */
    public function getRfqNo(): string
    {
        return (string)self::getAttributesById($this->getMainTableRecordId(), 'rfq_number');
    }

    /**
     * linkToSeller
     *
     * @param  array $data
     * @return bool
     */
    public function linkToSeller(array $data): bool
    {
        if (0 < $this->getMainTableRecordId()) {
            $data['rfqts_rfq_id'] = $this->getMainTableRecordId();
        }

        if (1 > $data['rfqts_rfq_id']) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST');
            return false;
        }

        if (!FatApp::getDb()->insertFromArray(self::DB_RFQ_TO_SELLERS, $data, true, array(), $data)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    /**
     * getSellersByRecordId
     *
     * @param int $recordId
     * @return array
     */
    public static function getSellersByRecordId(int $recordId): array
    {
        $srch = new SearchBase(self::DB_RFQ_TO_SELLERS);
        $srch->doNotCalculateRecords();
        $srch->addCondition('rfqts_rfq_id', '=', 'mysql_func_' . $recordId, 'AND', true);
        $srch->addMultipleFields(self::RFQ_TO_SUPPLIER_FIELDS);
        return (array)FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    /**
     * get
     *
     * @param  int $langId
     * @param  array $fields
     * @return array
     */
    public function get(int $langId, array $fields = []): array
    {
        if (1 > $this->getMainTableRecordId()) {
            return [];
        }

        $fields = !empty($fields) ? $fields : self::FIELDS;

        $srch = new RequestForQuoteSearch();
        $srch->setDefaultJoins($langId);
        $srch->addMultipleFields($fields);
        $srch->addCondition('rfq_id', '=', $this->getMainTableRecordId());

        return (array)FatApp::getDb()->fetch($srch->getDataResultSet());
    }

    /**
     * delete
     *
     * @return bool
     */
    public function delete(): bool
    {
        if (1 > $this->getMainTableRecordId()) {
            $this->error = Labels::getLabel('LBL_INVALID_REQUEST');
            return false;
        }

        if (false == $this->add([self::DB_TBL_PREFIX . 'deleted' => applicationConstants::YES])) {
            return false;
        }
        return true;
    }

    /**
     * getApprovalStatusArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getApprovalStatusArr(int $langId): array
    {
        return [
            self::PENDING => Labels::getLabel('LBL_PENDING', $langId),
            self::APPROVED => Labels::getLabel('LBL_APPROVED', $langId),
            self::REJECTED => Labels::getLabel('LBL_REJECTED', $langId),
        ];
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
            self::STATUS_OPEN => Labels::getLabel('LBL_OPEN', $langId),
            self::STATUS_OFFERED => Labels::getLabel('LBL_OFFERED', $langId),
            self::STATUS_ACCEPTED => Labels::getLabel('LBL_ACCEPTED', $langId),
            self::STATUS_CLOSED => Labels::getLabel('LBL_CLOSED', $langId),
            // self::STATUS_COMPLETED => Labels::getLabel('LBL_COMPLETED', $langId),
        ];
    }

    /**
     * getTypeArr
     *
     * @param  mixed $langId
     * @return array
     */
    public static function getTypeArr(int $langId): array
    {
        return [
            self::TYPE_INDIVIDUAL => Labels::getLabel('LBL_INDIVIDUAL', $langId),
            self::TYPE_VARIANT => Labels::getLabel('LBL_VARIANT', $langId),
            self::TYPE_CATALOG => Labels::getLabel('LBL_CATALOG', $langId),
            // self::TYPE_CUSTOM => Labels::getLabel('LBL_CUSTOM', $langId),
        ];
    }

    /**
     * getForm
     *
     * @return Form
     */
    public static function getForm($isUserLogged = true): Form
    {
        $frm = new Form('frm');
        // $frm->addHiddenField('', self::DB_TBL_PREFIX . 'id');
        if (!$isUserLogged) {
            $frm->addRequiredField(Labels::getLabel('FRM_NAME', CommonHelper::getLangId()), 'user_name', '', array('placeholder' => Labels::getLabel('LBL_Name', CommonHelper::getLangId())));
            $fld = $frm->addEmailField(Labels::getLabel('FRM_EMAIL', CommonHelper::getLangId()), 'user_email', '', array('placeholder' => Labels::getLabel('LBL_EMAIL_ADDRESS', CommonHelper::getLangId())));
            $fld->requirement->setRequired(true);
            $frm->addHiddenField('', 'user_phone_dcode');
            $frm->addRequiredField(Labels::getLabel('FRM_PHONE_NUMBER', CommonHelper::getLangId()), 'user_phone', '', array('placeholder' => Labels::getLabel('FRM_PHONE_NUMBER', CommonHelper::getLangId()), 'class' => 'phone-js'));
        }

        $frm->addHiddenField('', self::DB_TBL_PREFIX . 'product_id');
        $frm->addHiddenField('', self::DB_TBL_PREFIX . 'addr_id');

        $fld = $frm->addIntegerField(Labels::getLabel('FRM_QUANTITY'), self::DB_TBL_PREFIX . 'quantity');
        $fld->requirement->setRequired(true);
        $fld->requirement->setPositive();
        $fld->requirement->setRange(1, 9999999999);

        $weightUnitsArr = applicationConstants::getWeightUnitsArr(CommonHelper::getLangId());
        $frm->addSelectBox(Labels::getLabel('FRM_UNIT'), self::DB_TBL_PREFIX . 'quantity_unit', $weightUnitsArr, '', [], Labels::getLabel('FRM_SELECT'))->requirements()->setRequired();

        $frm->addDateField(Labels::getLabel('FRM_EXPECTED_DELIVERY_DATE'), self::DB_TBL_PREFIX . 'delivery_date', '', ['class' => 'field--calender', 'readonly' => 'readonly']);
        $fld = $frm->addTextArea(Labels::getLabel('FRM_COMMENTS_FOR_SELLER'), self::DB_TBL_PREFIX . 'description');
        $fld->addFieldTagAttribute('maxlength', 300);
        $fld->requirement->setRequired(true);

        return $frm;
    }

    /**
     * getSellerProductId
     *
     * @param  int $rfqId
     * @param  int $sellerId
     * @return int
     */
    public static function getSellerProductId(int $rfqId,  int $sellerId): int
    {
        if (1 > $rfqId || 1 > $sellerId) {
            return 0;
        }

        $srch = new SearchBase(self::DB_RFQ_TO_SELLERS);
        $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'sp.selprod_id = rfqts_selprod_id', 'sp');
        $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'sp.selprod_code = sp1.selprod_code AND sp1.selprod_user_id = ' . $sellerId, 'sp1');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('rfqts_rfq_id', '=', 'mysql_func_' . $rfqId, 'AND', true);
        $srch->addFld('sp1.selprod_id');
        return ((array)FatApp::getDb()->fetch($srch->getResultSet()))['selprod_id'] ?? 0;
    }

    private function getShippingAddress(): array
    {
        if (1 > $this->getMainTableRecordId()) {
            return [];
        }

        $srch = new RequestForQuoteSearch();
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->joinBuyer();
        $srch->joinBuyerAddress(CommonHelper::getLangId());
        $srch->joinCountry(true);
        $srch->joinState(true);

        $dbFlds = array_merge(array('ba.*', 'bu.user_id', 'state_code', 'country_code', 'country_code_alpha3', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name'));
        $srch->addMultipleFields($dbFlds);

        $srch->addCondition('rfq_id', '=', $this->getMainTableRecordId());
        return (array)FatApp::getDb()->fetch($srch->getDataResultSet(CommonHelper::getLangId()));
    }

    private function getProductInfo(int $sellerId): array
    {
        if (1 > $this->getMainTableRecordId() || 1 > $sellerId) {
            return [];
        }

        $prodSrch = new ProductSearch(CommonHelper::getLangId());
        $prodSrch->setDefinedCriteria(criteria: ['joinCredentials' => true]);
        $prodSrch->joinTable(RequestForQuote::DB_RFQ_TO_SELLERS, 'INNER JOIN', 'rfqts_selprod_id = selprod_id', 'rfqs');
        $prodSrch->joinTable(RequestForQuote::DB_TBL, 'INNER JOIN', 'rfqts_rfq_id = rfqts_rfq_id', 'rfq');
        $prodSrch->joinShopSpecifics();
        $prodSrch->joinSellerProductSpecifics();
        $prodSrch->joinProductSpecifics();
        $prodSrch->joinBrands();
        $prodSrch->joinSellerSubscription();
        $prodSrch->addSubscriptionValidCondition();
        $prodSrch->joinProductToCategory();
        $prodSrch->doNotCalculateRecords();
        $prodSrch->addCondition('selprod_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $prodSrch->addCondition('rfqts_rfq_id', '=', $this->getMainTableRecordId());
        $prodSrch->addCondition('selprod_user_id', '=', $sellerId);

        $fields = array(
            'rfq_quantity as quantity', 'rfq_quantity_unit', 'product_id', 'product_type', 'product_length', 'product_width', 'product_height',
            'product_dimension_unit', 'product_weight', 'product_weight_unit', 'product_model',
            'selprod_id', 'selprod_user_id', 'selprod_stock', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'selprod_sku',
            'selprod_condition', 'selprod_code',
            'special_price_found', 'theprice', 'shop_id', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'IFNULL(brand_name, brand_identifier) as brand_name', 'shop_name',
            'seller_user.user_name as shop_onwer_name', 'seller_user_cred.credential_username as shop_owner_username',
            'seller_user.user_phone_dcode as shop_owner_phone_dcode', 'seller_user.user_phone as shop_owner_phone', 'seller_user_cred.credential_email as shop_owner_email', 'selprod_download_validity_in_days', 'selprod_max_download_times', 'ps.product_warranty', 'COALESCE(sps.selprod_return_age, ss.shop_return_age) as return_age', 'COALESCE(sps.selprod_cancellation_age, ss.shop_cancellation_age) as cancellation_age',
            'prodcat_id', 'product_attachements_with_inventory', 'selprod_product_id'
        );
        $prodSrch->addMultipleFields($fields);
        return (array)FatApp::getDb()->fetchAll($prodSrch->getResultSet(), 'selprod_id');
    }

    public function getShippingCharges(int $sellerId, int $primaryOfferId = 0): array
    {
        $productInfo = $this->getProductInfo($sellerId);
        if (empty($productInfo)) {
            return [];
        }
        $selprodId = current($productInfo)['selprod_id'];
        $productInfo[$selprodId]['isProductShippedBySeller'] = ''; /* Cannot set by seller. Rates can be fetched from both. */

        /* Update primary offer id. This will help when multiple offers accpted for same seller product.*/
        $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['acceptedOffers'][$selprodId]['primary_offer_id'] = $primaryOfferId;
        $shippingAddressDetail =  $this->getShippingAddress();
        $shipping = new Shipping(CommonHelper::getLangId());
        $shipping->fetchCustomShippingRates = true;
        $response =  $shipping->calculateCharges([$selprodId => $selprodId], $shippingAddressDetail, $productInfo);
        return [$selprodId => $response['data']];
    }

    public static function getBadgeClass(int $status): string
    {
        switch ($status) {
            case self::STATUS_ACCEPTED:
                return 'badge badge-success';
                break;
            case self::STATUS_COMPLETED:
                return 'badge badge-brand';
                break;
            case self::STATUS_CLOSED:
                return 'badge badge-danger';
                break;
            case self::STATUS_OFFERED:
                return 'badge badge-warning';
                break;
            case self::STATUS_OPEN:
                return 'badge badge-info';
                break;
            default:
                return 'badge badge-info';
                break;
        }
    }

    /**
     * getApprovalStatusBadge
     *
     * @param  int $status
     * @return array
     */
    public static function getApprovalStatusBadge(int $status): string
    {
        switch ($status) {
            case self::PENDING:
                return 'badge badge-info';
                break;
            case self::APPROVED:
                return 'badge badge-success';
                break;
            case self::REJECTED:
                return 'badge badge-warning';
                break;
            default:
                return 'badge badge-info';
                break;
        }
    }

    /**
     * getSellersByProductId
     *
     * @param  int $langId
     * @return array
     */
    public static function getSellersByProductId(int $langId): array
    {
        $pagesize = 20;
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }

        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);

        $attr = [
            'tu.user_name',
            'tu.user_id',
            'credential_username',
            'credential_email',
            'COALESCE(s_l.shop_name, shp.shop_identifier) as shop_name'
        ];

        $srch = SellerProduct::getSearchObject();
        $srch->joinTable(Shop::DB_TBL, 'INNER JOIN', 'shp.shop_user_id = sp.selprod_user_id', 'shp');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'shp.shop_id = s_l.shoplang_shop_id AND shoplang_lang_id = ' . $langId, 's_l');
        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'tu.user_id = sp.selprod_user_id AND tu.user_is_supplier = ' . applicationConstants::YES, 'tu');
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'tuc.credential_user_id = tu.user_id and tuc.credential_active = ' . applicationConstants::ACTIVE . ' and tuc.credential_verified = ' . applicationConstants::YES, 'tuc');
        $srch->addCondition('shp.shop_supplier_display_status', '=', applicationConstants::YES);
        $srch->addCondition('shp.shop_active', '=', applicationConstants::YES);
        $srch->addCondition('tu.' . User::DB_TBL_PREFIX . 'is_supplier', '=', applicationConstants::YES);
        $srch->addCondition('tuc.credential_active', '=', applicationConstants::YES);
        $srch->addCondition('tuc.credential_verified', '=', applicationConstants::YES);

        $srch->addOrder('user_name', 'ASC');
        $srch->addMultipleFields($attr);

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cond = $srch->addCondition('tuc.credential_username', 'like', '%' . $keyword . '%');
            $cond->attachCondition('tuc.credential_email', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('tu.user_name', 'like', '%' . $keyword . '%');
            $cond->attachCondition('shp.shop_identifier', 'LIKE', '%' . $keyword . '%');
            $cond->attachCondition('s_l.shop_name', 'LIKE', '%' . $keyword . '%');
        }

        $rfqAssignedOnly = FatApp::getPostedData('rfq_assigned_only', FatUtility::VAR_INT, 0);
        $rfqId = FatApp::getPostedData('rfq_id', FatUtility::VAR_INT, 0);
        if (0 < $rfqId) {
            /* RVSI */
            /* $srch->joinTable(RequestForQuote::DB_TBL, 'INNER JOIN', 'rfq.rfq_selprod_code = sp.selprod_code AND rfq.rfq_id = ' . $rfqId, 'rfq'); */
        }

        if (0 < $rfqAssignedOnly) {
            $srch->joinTable(RequestForQuote::DB_RFQ_TO_SELLERS, 'INNER JOIN', 'rfqs.rfqts_user_id = sp.selprod_user_id AND rfqs.rfqts_rfq_id = ' . $rfqId, 'rfqs');
        }

        $excludeAssignedSeller = FatApp::getPostedData('exclude_assigned_seller', FatUtility::VAR_INT, 0);
        if (0 < $excludeAssignedSeller) {
            $srch->joinTable(RequestForQuote::DB_RFQ_TO_SELLERS, 'LEFT JOIN', 'rfqs.rfqts_user_id = sp.selprod_user_id AND rfqs.rfqts_rfq_id = ' . $rfqId, 'rfqs');
            $srch->addCondition('rfqs.rfqts_user_id', 'IS', 'mysql_func_null', 'AND', true);
        }

        if (0 < $productId) {
            $srch->addCondition('sp.selprod_product_id', '=', $productId);
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->addGroupBy('tu.user_id');
        $users = FatApp::getDb()->fetchAll($srch->getResultSet(), 'user_id');
        $json = array(
            'pageCount' => $srch->pages(),
            'results' => []
        );

        foreach ($users as $key => $user) {
            $name = !empty($user['user_name']) ? $user['user_name'] . ' (' . $user['shop_name'] . ')' : $user['credential_username'];
            $json['results'][] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($name, ENT_QUOTES, 'UTF-8'))
            );
        }

        return $json;
    }

    public static function getSelprodId(int $rfqId): int
    {
        $srch = new SearchBase(self::DB_RFQ_TO_SELLERS, 'rs');
        $srch->addFld('rfqts_selprod_id as selprod_id');
        $srch->addCondition('rfqts_rfq_id', '=', $rfqId);
        $srch->doNotCalculateRecords();
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        return is_array($row) && isset($row['selprod_id']) ? $row['selprod_id'] : 0;
    }

    public function bindRfqToSeller(int $selprodId, string $selprodCode, int $sellerId): bool
    {
        if (1 > $this->getMainTableRecordId()) {
            $this->error = Labels::getLabel('LBL_NO_RFQ_ID_GIVEN');
            return false;
        }

        $rfqType = FatApp::getConfig('CONF_RFQ_MODULE_TYPE', FatUtility::VAR_INT, self::TYPE_INDIVIDUAL);

        if (self::TYPE_INDIVIDUAL == $rfqType) {
            $data = [
                'rfqts_user_id' => $sellerId,
                'rfqts_selprod_id' => $selprodId,
            ];
            return $this->linkToSeller($data);
        }

        $srch = new ProductSearch();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addFld($this->getMainTableRecordId() . ', selprod_user_id');

        $criteria['doNotJoinSpecialPrice'] = true;
        if (self::TYPE_VARIANT == $rfqType) {
            $srch->addCondition('selprod_code', 'LIKE', $selprodCode);
            $srch->addFld("selprod_id as rfqts_selprod_id");
        } else if (self::TYPE_CATALOG == $rfqType) {
            $prodId = explode('_', $selprodCode)[0];
            $criteria['product_id'] = $prodId;
            $sp = SellerProduct::getSearchObject();
            $sp->addFld('sp.selprod_id');
            $sp->doNotCalculateRecords();
            $sp->doNotLimitRecords();
            $sp->addCondition('sp.selprod_user_id', '=', 'mysql_func_sprods.selprod_user_id', 'AND ', true);
            $sp->addCondition('sp.selprod_code', 'LIKE', $selprodCode);
            $srch->addFld("(" . $sp->getQuery() . ") as rfqts_selprod_id");
        }
        $srch->joinSellerProducts(criteria: $criteria);
        $srch->joinSellers();
        $srch->joinShops();
        $srch->addGroupBy('selprod_user_id');

        $moduleType = FatApp::getConfig('CONF_RFQ_MODULE_TYPE', FatUtility::VAR_INT, 0);
        if (RequestForQuote::TYPE_INDIVIDUAL == $moduleType) {
            $srch->addCondition('shop.shop_rfq_enabled', '=', applicationConstants::YES);
            $srch->addCondition('sp.selprod_rfq_enabled', '=', applicationConstants::YES);
        }

        $sql = 'INSERT INTO ' . self::DB_RFQ_TO_SELLERS . ' ' . $srch->getQuery();
        FatApp::getDb()->query($sql);
        return true;
    }

    public static function getOfferStatusByRfqStatus(int $rfqStatus): array
    {
        $arr = [
            self::STATUS_OFFERED => [
                RfqOffers::STATUS_OPEN
            ],
            self::STATUS_ACCEPTED => [
                RfqOffers::STATUS_ACCEPTED
            ],
            self::STATUS_CLOSED => [
                RfqOffers::STATUS_REJECTED
            ],
            self::STATUS_COMPLETED => [
                RfqOffers::STATUS_ACCEPTED
            ],
        ];

        return $arr[$rfqStatus] ?? [];
    }

    public static function isEnabled(int $shopRfqEnabled = 0, int $selProdRfqEnabled = 0): bool
    {
        if (1 > FatApp::getConfig('CONF_RFQ_MODULE', FatUtility::VAR_INT, 0)) {
            return false;
        }

        $moduleType = FatApp::getConfig('CONF_RFQ_MODULE_TYPE', FatUtility::VAR_INT, 0);

        if ($moduleType != RequestForQuote::TYPE_INDIVIDUAL) {
            return true;
        }

        if (applicationConstants::NO == $shopRfqEnabled) {
            return false;
        }

        if (applicationConstants::NO == $selProdRfqEnabled) {
            return false;
        }

        return true;
    }
}
