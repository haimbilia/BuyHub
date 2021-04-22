<?php

class SelProdReviewSearch extends SearchBase
{
    private $langId;
    private $commonLangId;
    private $joinOrderProd = false;
    public function __construct($langId = 0)
    {
        $langId = FatUtility::int($langId);
        $this->langId = $langId;
        parent::__construct(SelProdReview::DB_TBL, 'spr');
    }

    public function joinSeller($langId = 0)
    {
        $langId = FatUtility::int($langId);
        $this->commonLangId = CommonHelper::getLangId();
        if ($this->langId) {
            $langId = $this->langId;
        }

        $this->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'us.user_id = spr.spreview_seller_user_id', 'us');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'usc.credential_user_id = us.user_id', 'usc');
    }

    public function joinShops($langId = 0, $isActive = true)
    {
        $langId = FatUtility::int($langId);
        if ($this->langId) {
            $langId = $this->langId;
        }
        $this->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'us.user_id = shop.shop_user_id', 'shop');

        if ($isActive) {
            $this->addCondition('shop.shop_active', '=', applicationConstants::ACTIVE);
        }

        if ($langId) {
            $this->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'shop.shop_id = s_l.shoplang_shop_id AND shoplang_lang_id = ' . $langId, 's_l');
        }
    }

    public function joinUser()
    {
        $this->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'u.user_id = spr.spreview_postedby_user_id', 'u');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'uc.credential_user_id = u.user_id', 'uc');
    }

    public function joinProducts($langId = 0, $isProductActive = true, $isProductApproved = true, $isProductDeleted = true)
    {
        $langId = FatUtility::int($langId);
        if ($this->langId) {
            $langId = $this->langId;
        }

        $this->joinTable(Product::DB_TBL, 'LEFT OUTER JOIN', 'p.product_id = spr. 	spreview_product_id', 'p');

        if ($langId > 0) {
            $this->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p_l.productlang_product_id = p.product_id and p_l.productlang_lang_id = ' . $langId, 'p_l');
        }

        if ($isProductActive) {
            $this->addCondition('product_active', '=', applicationConstants::ACTIVE);
        }

        if ($isProductApproved) {
            $this->addCondition('product_approved', '=', Product::APPROVED);
        }

        if ($isProductDeleted) {
            $this->addCondition('product_deleted', '=', applicationConstants::NO);
        }
    }

    public function joinSellerProducts($langId = 0, $active = true, $deleted = false)
    {
        $langId = FatUtility::int($langId);
        if ($this->langId) {
            $langId = $this->langId;
        }

        $this->joinTable(SellerProduct::DB_TBL, 'LEFT OUTER JOIN', 'sp.selprod_code = spr.spreview_selprod_code and sp.selprod_user_id = spr.spreview_seller_user_id', 'sp');
        if ($langId > 0) {
            $this->joinTable(SellerProduct::DB_TBL_LANG, 'LEFT OUTER JOIN', 'sp_l.selprodlang_selprod_id = sp.selprod_id and sp_l.selprodlang_lang_id = ' . $langId, 'sp_l');
        }
        if ($active == true) {
            $this->addCondition('sp.selprod_active', '=', applicationConstants::YES);
        }
        if ($deleted == false) {
            $this->addCondition('sp.selprod_deleted', '=', applicationConstants::NO);
        }
    }

    public function joinSelProdRating(int $langId = 0)
    {
        $this->joinTable(SelProdRating::DB_TBL, 'LEFT OUTER JOIN', 'sprating.sprating_spreview_id = spr.spreview_id', 'sprating');
        $this->joinTable(
            RatingType::DB_TBL,
            'INNER JOIN',
            'rt.ratingtype_id = sprating_ratingtype_id',
            'rt'
        );
        if (0 < $langId) {
            $this->joinTable(
                RatingType::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'rt_l.ratingtypelang_ratingtype_id = rt.ratingtype_id AND rt_l.ratingtypelang_lang_id = ' . $langId,
                'rt_l'
            );
        }
    }

    public function joinSelProdRatingByType($ratingType, $obj = 'sprt')
    {
        if (!$ratingType) {
            trigger_error(Labels::getLabel('ERR_Please_supply_rating_type_argument.', $this->commonLangId), E_USER_ERROR);
        }
        if (!is_array($ratingType)) {
            $ratingType = FatUtility::int($ratingType);
            $this->joinTable(SelProdRating::DB_TBL, 'LEFT OUTER JOIN', $obj . '.sprating_spreview_id = spr.spreview_id and ' . $obj . '.sprating_ratingtype_id = ' . $ratingType, $obj);
        } else {
            if (count($ratingType)) {
                $this->joinTable(SelProdRating::DB_TBL, 'LEFT OUTER JOIN', $obj . '.sprating_spreview_id = spr.spreview_id and ' . $obj . '.sprating_ratingtype_id in (' . implode(',', $ratingType) . ')', $obj);
            } else {
                trigger_error(Labels::getLabel('ERR_Please_supply_non_empty_rating_types_array', $this->commonLangId), E_USER_ERROR);
            }
        }
    }

    public function joinSelProdReviewHelpful()
    {
        $this->joinTable(SelProdReviewHelpful::DB_TBL, 'LEFT OUTER JOIN', 'sprh.sprh_spreview_id = spr.spreview_id', 'sprh');
    }

    public function joinOrderProduct()
    {
        $this->joinOrderProd = true;
        $this->joinTable(OrderProduct::DB_TBL, 'INNER JOIN', 'op.op_order_id = spr.spreview_order_id AND op.op_selprod_id = spr.spreview_selprod_id', 'op');
    }
    
    public function joinOrderProductShipping()
    {
        if (false === $this->joinOrderProd) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_ORDER_PRODUCT.', $this->commonLangId), E_USER_ERROR);
        }
        $this->joinTable(Orders::DB_TBL_ORDER_PRODUCTS_SHIPPING, 'LEFT JOIN', 'ops.opshipping_op_id = op.op_id', 'ops');
    }
    
    public function joinOrderProductSpecifics()
    {
        if (false === $this->joinOrderProd) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_ORDER_PRODUCT.', $this->commonLangId), E_USER_ERROR);
        }
        $this->joinTable(OrderProductSpecifics::DB_TBL, 'LEFT JOIN', 'opspec.ops_op_id = op.op_id', 'opspec');
    }

}
