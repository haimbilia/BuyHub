<?php

class RequestForQuoteSearch extends SearchBase
{
    private bool $joinSellerTable = false;
    private bool $joinOfferPostedByUser = false;
    private string $sellerTableJoinType = 'LEFT';
    private int $langId = 0;
    public array $langTables = [];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(RequestForQuote::DB_TBL, 'rfq');
    }

    /**
     * setDefaultJoins
     *
     * @param  int $langId
     * @return void
     */
    public function setDefaultJoins(int $langId = 0, string $defaultJoinType = 'INNER'): void
    {
        $this->joinSellers($defaultJoinType);
        $this->joinProduct((0 < $langId), $defaultJoinType);
        $this->joinBuyer();
        $this->joinSellerShop((0 < $langId));
        $this->joinSellerProduct((0 < $langId));
        $this->joinBuyerAddress($langId);
        $this->joinCountry((0 < $langId));
        $this->joinState((0 < $langId));
    }

    /**
     * joinProduct
     *
     * @param  bool $joinLangTable
     * @return void
     */
    public function joinProduct(bool $joinLangTable = false, string $joinType = 'INNER'): void
    {
        $this->joinTable(Product::DB_TBL, $joinType . ' JOIN', 'p.product_id = rfq_product_id', 'p');
        if ($joinLangTable) {
            array_push($this->langTables, __FUNCTION__);
        }
    }

    /**
     * joinProductLang
     *
     * @return void
     */
    public function joinProductLang(): void
    {
        $this->joinTable(Product::DB_TBL_LANG, 'LEFT JOIN', 'p_l.productlang_product_id = p.product_id and p_l.productlang_lang_id = ' . $this->langId, 'p_l');
    }

    /**
     * joinOfferPostedByUser
     *
     * @return void
     */
    public function joinOfferPostedByUser(): void
    {
        $this->joinOfferPostedByUser = true;
        $this->joinTable(User::DB_TBL, 'INNER JOIN', 'ou.user_id = ro.offer_user_id', 'ou');
        $this->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'ouc.credential_user_id = ro.offer_user_id', 'ouc');
    }

    /**
     * joinOfferLinkedSeller
     *
     * @return void
     */
    public function joinOfferLinkedSeller($joinLatestOffers = false): void
    {
        if ($joinLatestOffers) {
            $this->joinTable('tbl_rfq_latest_offers', 'LEFT JOIN', 'rlo.rlo_rfq_id = rfq.rfq_id and rlo.rlo_primary_offer_id = ro.offer_primary_offer_id', 'rlo');
        }
        $this->joinTable(User::DB_TBL, 'INNER JOIN', 'olu.user_id = rlo.rlo_seller_user_id', 'olu');
        $this->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'oluc.credential_user_id = rlo.rlo_seller_user_id', 'oluc');
    }

    /**
     * joinOfferPostedBySellerShop
     *
     * @param  bool $joinLangTable
     * @return void
     */
    public function joinOfferPostedBySellerShop(bool $joinLangTable = false): void
    {
        if (false === $this->joinOfferPostedByUser) {
            trigger_error('PLEASE CALL joinOfferPostedByUser FIRST', E_USER_ERROR);
        }
        $this->joinTable(Shop::DB_TBL, 'LEFT JOIN', 'ous.shop_user_id = ro.offer_user_id and ro.offer_user_type = ' . User::USER_TYPE_SELLER, 'ous');
        if ($joinLangTable) {
            array_push($this->langTables, __FUNCTION__);
        }
    }

    /**
     * joinOfferPostedBySellerShopLang
     *
     * @return void
     */
    public function joinOfferPostedBySellerShopLang(): void
    {
        $this->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'ous_l.shoplang_shop_id = ous.shop_id and ous_l.shoplang_lang_id = ' . $this->langId, 'ous_l');
    }


    /**
     * joinBuyer
     *
     * @return void
     */
    public function joinBuyer(): void
    {
        $this->joinTable(User::DB_TBL, 'INNER JOIN', 'bu.user_id = rfq.rfq_user_id', 'bu');
        $this->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'bu.user_id = buc.credential_user_id', 'buc');
    }

    /**
     * joinBuyerAddress
     *
     * @param  int $langId
     * @return void
     */
    public function joinBuyerAddress(int $langId = 0): void
    {
        $this->joinTable(Address::DB_TBL, 'LEFT JOIN', 'ba.addr_id = rfq_addr_id AND ba.addr_type = ' . Address::TYPE_USER /* . ' AND ba.addr_lang_id = ' . $langId */, 'ba');
    }

    /**
     * joinCountry
     *
     * @param  bool $joinLangTable
     * @return void
     */
    public function joinCountry(bool $joinLangTable = false): void
    {
        $this->joinTable(Countries::DB_TBL, 'LEFT JOIN', 'c.country_id = ba.addr_country_id', 'c');
        if ($joinLangTable) {
            array_push($this->langTables, __FUNCTION__);
        }
    }

    /**
     * joinCountryLang
     *
     * @return void
     */
    public function joinCountryLang(): void
    {
        $this->joinTable(Countries::DB_TBL_LANG, 'LEFT JOIN', 'c.country_id = c_l.countrylang_country_id AND countrylang_lang_id = ' . $this->langId, 'c_l');
    }

    /**
     * joinState
     *
     * @param  bool $joinLangTable
     * @return void
     */
    public function joinState(bool $joinLangTable = false)
    {
        $this->joinTable(States::DB_TBL, 'LEFT JOIN', 's.state_id = ba.addr_state_id', 's');
        if ($joinLangTable) {
            array_push($this->langTables, __FUNCTION__);
        }
    }

    /**
     * joinStateLang
     *
     * @return void
     */
    public function joinStateLang(): void
    {
        $this->joinTable(States::DB_TBL_LANG, 'LEFT JOIN', 's.state_id = s_l.statelang_state_id AND s_l.statelang_lang_id = ' . $this->langId, 's_l');
    }

    /**
     * joinSellers
     *
     * @param  mixed $joinType
     * @param  int $sellerId
     * @return void
     */
    public function joinSellers(string $joinType = 'LEFT', int $sellerId = 0): void
    {
        $this->joinSellerTable = true;
        $this->sellerTableJoinType = $joinType;
        $joinCondition = '';
        if (0 < $sellerId) {
            $joinCondition = ' AND rfqts_user_id = ' . $sellerId;
        }
        $this->joinTable(RequestForQuote::DB_RFQ_TO_SELLERS, $joinType . ' JOIN', 'rs.rfqts_rfq_id = rfq_id' . $joinCondition, 'rs');
    }

    /**
     * joinSellerUser
     *
     * @return void
     */
    public function joinSellerUser(): void
    {
        if (false === $this->joinSellerTable) {
            trigger_error(Labels::getLabel('ERR_PLEASE_CALL_joinSellers_FIRST.'), E_USER_ERROR);
        }
        $this->joinTable(User::DB_TBL, $this->sellerTableJoinType . ' JOIN', 'su.user_id = rs.rfqts_user_id', 'su');
        $this->joinTable(User::DB_TBL_CRED, $this->sellerTableJoinType . ' JOIN', 'su.user_id = suc.credential_user_id', 'suc');
    }

    /**
     * joinSellerShop
     *
     * @param  bool $joinLangTable
     * @return void
     */
    public function joinSellerShop(bool $joinLangTable = false): void
    {
        if (false === $this->joinSellerTable) {
            trigger_error(Labels::getLabel('ERR_PLEASE_CALL_joinSellers_FIRST.'), E_USER_ERROR);
        }
        $this->joinTable(Shop::DB_TBL, $this->sellerTableJoinType . ' JOIN', 'shp.shop_user_id = rs.rfqts_user_id', 'shp');
        if ($joinLangTable) {
            array_push($this->langTables, __FUNCTION__);
        }
    }

    /**
     * joinSellerShopLang
     *
     * @return void
     */
    public function joinSellerShopLang(): void
    {
        $this->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'shp_l.shoplang_shop_id = shp.shop_id and shp_l.shoplang_lang_id = ' . $this->langId, 'shp_l');
    }

    /**
     * joinSellerProduct
     *
     * @param  bool $joinLangTable
     * @return void
     */
    public function joinSellerProduct(bool $joinLangTable = false): void
    {
        if (false === $this->joinSellerTable) {
            trigger_error(Labels::getLabel('ERR_PLEASE_CALL_joinSellers_FIRST.'), E_USER_ERROR);
        }
        $this->joinTable(SellerProduct::DB_TBL, 'LEFT JOIN', 'sp.selprod_id = rfqts_selprod_id', 'sp');
        if ($joinLangTable) {
            array_push($this->langTables, __FUNCTION__);
        }
    }

    /**
     * joinSellerProductLang
     *
     * @return void
     */
    public function joinSellerProductLang(): void
    {
        $this->joinTable(SellerProduct::DB_TBL_LANG, 'LEFT JOIN', 'sp_l.selprodlang_selprod_id = sp.selprod_id and sp_l.selprodlang_lang_id = ' . $this->langId, 'sp_l');
    }


    /**
     * Joins the product category table to the RFQ query.
     *
     * @param bool $joinLangTable Whether to also join the language table for the product category.
     * @return void
     */
    public function joinRfqCategory(bool $joinLangTable = false): void
    {
        $this->joinTable(ProductCategory::DB_TBL, 'LEFT JOIN', 'pdc.prodcat_id = rfq_prodcat_id', 'pdc');
        if ($joinLangTable) {
            array_push($this->langTables, __FUNCTION__);
        }
    }

    /**
     * Joins the product category language table to the query.
     *
     * This method joins the `ProductCategory::DB_TBL_LANG` table to the query using a LEFT JOIN. The join condition matches the `prodcatlang_prodcat_id` column in the language table to the `prodcat_id` column in the main product category table, and also filters the language table to only the specified `$this->langId`.
     *
     * @return void
     */
    public function joinRfqCategoryLang(): void
    {
        $this->joinTable(ProductCategory::DB_TBL_LANG, 'LEFT JOIN', 'pdc_l.prodcatlang_prodcat_id = pdc.prodcat_id and pdc_l.prodcatlang_lang_id = ' . $this->langId, 'pdc_l');
    }

    /**
     * joinLangTables
     *
     * @param  int $langId
     * @return void
     */
    public function joinLangTables(int $langId): void
    {
        $this->langId = $langId;
        foreach ($this->langTables as $joinFunctions) {
            $functionName = $joinFunctions . 'Lang';
            $this->$functionName();
        }
    }

    /**
     * joinOffers
     *
     * @return void
     */
    public function joinOffers($latestOffer = false): void
    {
        if (true == $latestOffer) {
            $this->joinLatestOffers();
        } else {
            $this->joinTable(RfqOffers::DB_TBL, 'LEFT JOIN', 'ro.offer_rfq_id = rfq.rfq_id', 'ro');
        }
    }

    /**
     * joinLatestOffers
     *
     * @return void
     */
    public function joinLatestOffers(): void
    {
        $this->joinTable('tbl_rfq_latest_offers', 'LEFT JOIN', 'rlo.rlo_rfq_id = rfq.rfq_id', 'rlo');
        $this->joinTable(RfqOffers::DB_TBL, 'LEFT JOIN', 'ro.offer_id = rlo.rlo_seller_offer_id and ro.offer_deleted = ' . applicationConstants::NO, 'ro');
        $this->joinTable(RfqOffers::DB_TBL, 'LEFT JOIN', 'roc.offer_id = rlo.rlo_buyer_offer_id and roc.offer_deleted = ' . applicationConstants::NO, 'roc');
    }

    /**
     * getDataResultSet
     *
     * @return DatabaseStatement
     */
    public function getDataResultSet(int $langId = 0): DatabaseStatement
    {
        $langId = (1 > $langId) ? CommonHelper::getLangId() : $langId;
        $this->doNotCalculateRecords();
        $this->joinLangTables($langId);
        return $this->getResultSet();
    }
}
