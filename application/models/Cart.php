<?php

class Cart extends FatModel
{
    private $products = array();
    private $basketProducts = [];
    private $SYSTEM_ARR = array();
    private $warning;
    private $shippingService;
    private $cartCache;
    private $valdateCheckoutType;
    private $fulfilmentType = 0;
    private $includeTax = true;
    private $pageType = 0;
    private $discounts = 0;
    private $selectedShippingService = [];
    private static $cartData = [];
    private $shipmentItemsCount = 0;

    private $hasPhysicalProduct = -1;
    private $hasDigitalProduct = -1;
    private $hasServiceProduct = -1;
    private $isAnyOutOfStock = -1;
    private array $removedItems = [];
    public int $singleCartSellerId = 0;

    public const DB_TBL = 'tbl_user_cart';
    public const DB_TBL_PREFIX = 'usercart_';

    public const CART_KEY_PREFIX_PRODUCT = 'SP_'; /* SP stands for Seller Product */
    public const CART_KEY_PREFIX_BATCH = 'SB_'; /* SB stands for Seller Batch/Combo Product */
    public const TYPE_PRODUCT = 1;
    public const TYPE_SUBSCRIPTION = 2;

    public const PAGE_TYPE_CART = 1;
    public const PAGE_TYPE_CHECKOUT = 2;

    public const CART_MAX_DISPLAY_QTY = 9;
    public $cart_lang_id = 0;
    public $cart_user_id = 0;
    public $cart_id = 0;
    public $cartSameSessionUser = 0;

    public function __construct($user_id = 0, $langId = 0, $tempCartUserId = 0, $pageType = 0)
    {
        parent::__construct();
        $this->valdateCheckoutType = true;
        $this->includeTax = true;
        $user_id = FatUtility::int($user_id);

        $langId = FatUtility::int($langId);

        $this->cart_lang_id = $langId;
        if (1 > $langId) {
            $this->cart_lang_id = CommonHelper::getLangId();
        }

        if (empty($tempCartUserId)) {
            $user_id = (0 < $user_id) ? $user_id : UserAuthentication::getLoggedUserId(true);
            $tempCartUserId = (0 < $user_id) ? $user_id : session_id();
        }

        $this->cart_user_id = $tempCartUserId;
        $this->cart_id = $tempCartUserId;

        if (UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged() || ($user_id > 0)) {
            if ($user_id > 0) {
                $this->cart_user_id = $user_id;
            } else {
                $this->cart_user_id = UserAuthentication::getLoggedUserId();
            }
        }

        $srch = new SearchBase('tbl_user_cart');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('usercart_user_id', '=', $this->cart_user_id);
        $srch->addCondition('usercart_type', '=', 'mysql_func_' . CART::TYPE_PRODUCT, 'AND', true);
        $srch->addMultipleFields(['usercart_user_id', 'usercart_type', 'usercart_details', 'usercart_added_date', 'usercart_sent_reminder', 'usercart_reminder_date', 'usercart_last_used_date', 'usercart_last_session_id']);
        $rs = $srch->getResultSet();
        $this->cartSameSessionUser = true;
        if ($row = FatApp::getDb()->fetch($rs)) {
            self::$cartData = $row;
            if ($row['usercart_last_session_id'] != $this->cart_id) {
                $this->cartSameSessionUser = false;
            }

            $this->SYSTEM_ARR['cart'] = json_decode($row["usercart_details"], true);
            if (isset($this->SYSTEM_ARR['cart']['shopping_cart'])) {
                $this->SYSTEM_ARR['shopping_cart'] = $this->SYSTEM_ARR['cart']['shopping_cart'];
                unset($this->SYSTEM_ARR['cart']['shopping_cart']);
            }
        }

        if (!$this->cartSameSessionUser) {
            $this->removeUsedRewardPoints();
        }

        if (!isset($this->SYSTEM_ARR['cart']) || !is_array($this->SYSTEM_ARR['cart'])) {
            $this->SYSTEM_ARR['cart'] = array();
        }
        if (!isset($this->SYSTEM_ARR['shopping_cart']) || !is_array($this->SYSTEM_ARR['shopping_cart'])) {
            $this->SYSTEM_ARR['shopping_cart'] = array();
        }

        $this->cartCache = true;
        $this->pageType = $pageType;
        $this->discounts = [];
    }

    public static function getCartKeyPrefixArr()
    {
        return array(
            static::CART_KEY_PREFIX_PRODUCT => static::CART_KEY_PREFIX_PRODUCT,
            static::CART_KEY_PREFIX_BATCH => static::CART_KEY_PREFIX_BATCH,
        );
    }

    public static function getCartUserId($tempUserId = 0)
    {
        $cart_user_id = session_id();
        if ($tempUserId != 0) {
            $cart_user_id = $tempUserId;
        }
        if (UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged()) {
            $cart_user_id = UserAuthentication::getLoggedUserId();
        }
        return $cart_user_id;
    }

    public static function getCartData($userId)
    {
        $cartData = self::$cartData;
        if (!empty($cartData) && array_key_exists('usercart_details', $cartData)) {
            return $cartData['usercart_details'];
        }

        $srch = new SearchBase('tbl_user_cart');
        $srch->addCondition('usercart_user_id', 'LIKE', $userId);
        $srch->addCondition('usercart_type', '=', 'mysql_func_' . CART::TYPE_PRODUCT, 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addMultipleFields(['usercart_user_id', 'usercart_type', 'usercart_details', 'usercart_added_date', 'usercart_sent_reminder', 'usercart_reminder_date', 'usercart_last_used_date', 'usercart_last_session_id']);
        $rs = $srch->getResultSet();
        if ($row = FatApp::getDb()->fetch($rs)) {
            self::$cartData = $row;
            return $row["usercart_details"];
        }

        return [];
    }

    public function add($selprod_id, $qty = 1, $prodgroup_id = 0, $returnUserId = false)
    {
        $this->products = array();
        $this->basketProducts = [];
        $selprod_id = FatUtility::int($selprod_id);
        $prodgroup_id = FatUtility::int($prodgroup_id);
        $qty = FatUtility::int($qty);
        if ($selprod_id < 1 || $qty < 1) {
            return false;
        }

        if (isset($_SESSION['offer_checkout']) && $_SESSION['offer_checkout']['selprod_id'] == $selprod_id) {
            $this->error = Labels::getLabel('ERR_ALREADY_ADDED_FROM_OFFER');
            return false;
        }
        $selProdData = SellerProduct::getAttributesById($selprod_id, ['selprod_user_id', 'selprod_track_inventory']);
        if ($this->hasProducts() > 0 && FatApp::getConfig('CONF_SINGLE_SELLER_CART', FatUtility::VAR_INT, 0)) {
            $this->getBasketProducts($this->cart_lang_id);
            $sellerUserId = $selProdData['selprod_user_id'];
            if ($this->singleCartSellerId > 0 && $sellerUserId != $this->singleCartSellerId) {
                $this->clear();
            }
        }

        if ($qty > 0) {
            $key = static::CART_KEY_PREFIX_PRODUCT . $selprod_id;
            if ($prodgroup_id) {
                $key = static::CART_KEY_PREFIX_BATCH . $prodgroup_id;
            }

            $key = base64_encode(json_encode($key));
            if (!isset($this->SYSTEM_ARR['cart'][$key])) {
                $this->SYSTEM_ARR['cart'][$key] = FatUtility::int($qty);
            } else {
                $this->SYSTEM_ARR['cart'][$key] += FatUtility::int($qty);
            }
        }

        if ($prodgroup_id > 0) {
            $products = $this->getBasketProducts($this->cart_lang_id);
            if ($products) {
                foreach ($products as $cartKey => $product) {
                    if ($product['is_batch'] && $prodgroup_id == $product['prodgroup_id']) {
                        foreach ($product['products'] as $pgProduct) {
                            if (1 > $pgProduct['selprod_track_inventory']) {
                                continue;
                            }
                            $this->updateTempStockHold($pgProduct['selprod_id'], $this->SYSTEM_ARR['cart'][$key], $product['prodgroup_id']);
                        }
                    }
                }
            }
        } else {
            if (0 < $selProdData['selprod_track_inventory']) {
                $this->updateTempStockHold($selprod_id, $this->SYSTEM_ARR['cart'][$key]);
            }
        }
        $this->removeCartDiscountCoupon();
        $this->updateUserCart();
        if (is_numeric($this->cart_user_id) && $this->cart_user_id > 0) {
            AbandonedCart::saveAbandonedCart($this->cart_user_id, $selprod_id, $this->SYSTEM_ARR['cart'][$key], AbandonedCart::ACTION_ADDED);
        }

        if ($returnUserId) {
            return $this->cart_user_id;
        }
        return true;
    }

    public function countProducts()
    {
        return count($this->SYSTEM_ARR['cart']);
    }

    public function hasProducts()
    {
        return count($this->SYSTEM_ARR['cart']);
    }

    public function hasStock()
    {
        if (-1 != $this->isAnyOutOfStock) {
            return $this->isAnyOutOfStock;
        }

        foreach ($this->getBasketProducts($this->cart_lang_id) as $product) {
            if (-1 != $this->isAnyOutOfStock) {
                return $this->isAnyOutOfStock;
            }

            if (!$product['in_stock']) {
                return false;
            }
        }
        return true;
    }

    public function hasDigitalProduct()
    {
        if (-1 !== $this->hasDigitalProduct) {
            return $this->hasDigitalProduct;
        }

        foreach ($this->getBasketProducts($this->cart_lang_id) as $product) {
            if (-1 !== $this->hasDigitalProduct) {
                return $this->hasDigitalProduct;
            }
            if (isset($product['is_digital_product']) && $product['is_digital_product']) {
                return true;
            }

            if ($product['is_batch'] && !empty($product['products'])) {
                foreach ($product['products'] as $pgproduct) {
                    if ($pgproduct['is_digital_product']) {
                        return true;
                    }
                }
            }
        }

        $this->products = [];
        $this->basketProducts = [];
        return false;
    }

    public function hasServiceProduct()
    {
        if (-1 !== $this->hasServiceProduct) {
            return $this->hasServiceProduct;
        }

        foreach ($this->getBasketProducts($this->cart_lang_id) as $product) {
            if (-1 !== $this->hasServiceProduct) {
                return $this->hasServiceProduct;
            }
            if (isset($product['is_service_product']) && $product['is_service_product']) {
                return true;
            }

            if ($product['is_batch'] && !empty($product['products'])) {
                foreach ($product['products'] as $pgproduct) {
                    if ($pgproduct['is_service_product']) {
                        return true;
                    }
                }
            }
        }

        $this->products = [];
        $this->basketProducts = [];
        return false;
    }

    public function hasPhysicalProduct()
    {
        if (-1 !== $this->hasPhysicalProduct) {
            return $this->hasPhysicalProduct;
        }

        foreach ($this->getBasketProducts($this->cart_lang_id) as $product) {
            if (-1 !== $this->hasPhysicalProduct) {
                return $this->hasPhysicalProduct;
            }

            if (isset($product['is_physical_product']) && !empty($product['is_physical_product'])) {
                return true;
            }

            if ($product['is_batch'] && !empty($product['products'])) {
                foreach ($product['products'] as $pgproduct) {
                    if ($pgproduct['is_physical_product']) {
                        return true;
                    }
                }
            }
        }
        $this->products = [];
        $this->basketProducts = [];
        return false;
    }

    public function getBasketProducts($siteLangId = 0)
    {
        if (!$this->basketProducts) {
            $this->isAnyOutOfStock = true;
            $this->hasDigitalProduct = false;
            $this->hasPhysicalProduct = false;
            $this->hasServiceProduct = false;

            $loggedUserId = 0;
            if (UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged()) {
                $loggedUserId = UserAuthentication::getLoggedUserId();
            }

            $cartData = [];
            $cartProdsData = [];

            foreach ($this->SYSTEM_ARR['cart'] as $key => $quantity) {
                $keyDecoded = json_decode(base64_decode($key), true);
                if (strpos($keyDecoded, static::CART_KEY_PREFIX_PRODUCT) !== false) {
                    $selProdId = FatUtility::int(str_replace(static::CART_KEY_PREFIX_PRODUCT, '', $keyDecoded));
                    $cartData[$selProdId] = $quantity;
                }
            }
            if (!empty($cartData)) {
                $cartProdsData = $this->getSellerProductsData($cartData, $siteLangId, $loggedUserId);
            }

            foreach ($this->SYSTEM_ARR['cart'] as $key => $quantity) {
                $selprod_id = 0;

                $keyDecoded = json_decode(base64_decode($key), true);
                if (strpos($keyDecoded, static::CART_KEY_PREFIX_PRODUCT) !== false) {
                    $selprod_id = FatUtility::int(str_replace(static::CART_KEY_PREFIX_PRODUCT, '', $keyDecoded));
                }

                if (1 > $selprod_id) {
                    unset($this->SYSTEM_ARR['cart'][$key]);
                    continue;
                }

                $sellerProductRow = $cartProdsData[$selprod_id] ?? [];
                if (!$sellerProductRow) {
                    Message::addErrorMessage(Labels::getLabel('ERR_PRODUCT_NOT_AVAILABLE_OR_OUT_OF_STOCK_SO_REMOVED_FROM_CART_LISTING', $siteLangId));
                    $this->removeCartKey($key, $selprod_id, $quantity);
                    continue;
                }

                if (FatApp::getConfig('CONF_SINGLE_SELLER_CART', FatUtility::VAR_INT, 0)) {
                    if ($this->singleCartSellerId > 0 && $this->singleCartSellerId != $sellerProductRow['selprod_user_id']) {
                        $this->removeCartKey($key, $selprod_id, $quantity);
                        continue;
                    } else {
                        $this->singleCartSellerId = $sellerProductRow['selprod_user_id'];
                    }
                }

                $quantity = $sellerProductRow['quantity'];
                $fulfilmentType = $this->fulfilmentType;
                if (isset($this->SYSTEM_ARR['shopping_cart']['checkout_type'])) {
                    $fulfilmentType =  $this->SYSTEM_ARR['shopping_cart']['checkout_type'];
                }

                if ($this->valdateCheckoutType && isset($fulfilmentType) && $fulfilmentType > 0 && $sellerProductRow['selprod_fulfillment_type'] != Shipping::FULFILMENT_ALL && $sellerProductRow['selprod_fulfillment_type'] != $fulfilmentType && !in_array($sellerProductRow['product_type'], [Product::PRODUCT_TYPE_DIGITAL, Product::PRODUCT_TYPE_SERVICE])) {
                    unset($this->basketProducts[$key]);
                    continue;
                }

                $this->basketProducts[$key] = [
                    'shipping_cost' => 0,
                    'opshipping_rate_id' => 0,
                    'commission_percentage' => '',
                    'commission' => 0,
                    'tax' => 0,
                    'taxOptions' => [],
                    'reward_point' => 0,
                    'volume_discount' => 0,
                    'volume_discount_total' => 0,
                    'is_shipping_selected' => false,
                    'volume_discount_total' => 0
                ];

                /* Has Stock */
                if (!$sellerProductRow['in_stock'] && true === $this->isAnyOutOfStock) {
                    $this->isAnyOutOfStock = false;
                }
                /* Has Stock */

                /* Has Digital Product */
                if (isset($sellerProductRow['is_digital_product']) && $sellerProductRow['is_digital_product'] && false === $this->hasDigitalProduct) {
                    $this->hasDigitalProduct = true;
                }
                /* Has Digital Product */

                /* Has Service Product */
                if (isset($sellerProductRow['is_service_product']) && $sellerProductRow['is_service_product'] && false === $this->hasServiceProduct) {
                    $this->hasServiceProduct = true;
                }
                /* Has Service Product */

                /* Has Physical Product */
                if (isset($sellerProductRow['is_physical_product']) && !empty($sellerProductRow['is_physical_product']) && false === $this->hasPhysicalProduct) {
                    $this->hasPhysicalProduct = true;
                }
                /* Has Physical Product */

                if (isset($sellerProductRow['is_batch']) && !empty($sellerProductRow['products']) && (false === $this->hasDigitalProduct || false === $this->hasPhysicalProduct || false === $this->hasServiceProduct)) {
                    foreach ($sellerProductRow['products'] as $pgproduct) {
                        if ($pgproduct['is_digital_product'] && false === $this->hasDigitalProduct) {
                            $this->hasDigitalProduct = true;
                        }

                        if ($pgproduct['is_service_product'] && false === $this->hasServiceProduct) {
                            $this->hasServiceProduct = true;
                        }

                        if ($pgproduct['is_physical_product'] && false === $this->hasPhysicalProduct) {
                            $this->hasPhysicalProduct = true;
                        }
                    }
                }

                $this->basketProducts[$key] = $sellerProductRow;
                $this->basketProducts[$key]['key'] = $key;
                $this->basketProducts[$key]['is_batch'] = 0;
                $this->basketProducts[$key]['selprod_id'] = $selprod_id;
                $this->basketProducts[$key]['quantity'] = $quantity;
                $this->basketProducts[$key]['has_physical_product'] = 0;
                $this->basketProducts[$key]['has_digital_product'] = 0;
                $this->basketProducts[$key]['is_cod_enabled'] = 0;
            }
        }

        uasort($this->basketProducts, function ($a, $b) {
            return $a['shop_id'] - $b['shop_id'];
        });
        return $this->basketProducts;
    }

    /**
     * getShipmentItemsCount: This function works after Calling getProducts
     *
     * @return int
     */
    public function getShipmentItemsCount(): int
    {
        return (int) $this->shipmentItemsCount;
    }

    public function getProducts($siteLangId = 0, $checkFulfilmentType = true)
    {
        if (!$this->products) {
            $this->isAnyOutOfStock = true;
            $this->hasDigitalProduct = false;
            $this->hasPhysicalProduct = false;
            $this->hasServiceProduct = false;
            //$this->getBasketProducts($siteLangId);

            $productSelectedShippingMethodsArr = $this->getProductShippingMethod();

            $maxConfiguredCommissionVal = FatApp::getConfig("CONF_MAX_COMMISSION", FatUtility::VAR_INT, 0);

            /* $db = FatApp::getDb();
            $prodGroupQtyArr = array();
            $prodGroupPriceArr = array(); */

            $associatedAffiliateUserId = 0;
            /* detect current logged user has associated affiliate user[ */
            $loggedUserId = 0;
            if (UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged()) {
                $loggedUserId = UserAuthentication::getLoggedUserId();
                $associatedAffiliateUserId = User::getAttributesById($loggedUserId, 'user_affiliate_referrer_user_id');
                if ($associatedAffiliateUserId > 0) {
                    $prodObj = new Product();
                }
            }
            /* ] */

            $is_cod_enabled = true;
            if (FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0)) {
                $cartDiscounts = $this->getCouponDiscounts();
            }

            $cartData = [];
            $cartProdsData = [];
            foreach ($this->SYSTEM_ARR['cart'] as $key => $quantity) {
                $keyDecoded = json_decode(base64_decode($key), true);
                if (strpos($keyDecoded, static::CART_KEY_PREFIX_PRODUCT) !== false) {
                    $selProdId = FatUtility::int(str_replace(static::CART_KEY_PREFIX_PRODUCT, '', $keyDecoded));
                    $cartData[$selProdId] = $quantity;
                }
            }
            if (!empty($cartData)) {
                $cartProdsData = $this->getSellerProductsData($cartData, $siteLangId, $loggedUserId);
            }

            foreach ($this->SYSTEM_ARR['cart'] as $key => $quantity) {
                $selprod_id = 0;
                // $prodgroup_id = 0;
                $sellerProductRow = array();

                $affiliateCommissionPercentage = '';
                $affiliateCommission = 0;

                $keyDecoded = json_decode(base64_decode($key), true);
                if (strpos($keyDecoded, static::CART_KEY_PREFIX_PRODUCT) !== false) {
                    $selprod_id = FatUtility::int(str_replace(static::CART_KEY_PREFIX_PRODUCT, '', $keyDecoded));
                }

                //To rid of from invalid product detail in listing.
                if (1 > $selprod_id) {
                    unset($this->SYSTEM_ARR['cart'][$key]);
                    continue;
                }

                $this->products[$key]['shipping_cost'] = 0;
                $this->products[$key]['opshipping_rate_id'] = 0;
                $this->products[$key]['commission_percentage'] = '';
                $this->products[$key]['commission'] = 0;
                $this->products[$key]['tax'] = 0;
                $this->products[$key]['taxOptions'] = [];
                $this->products[$key]['reward_point'] = 0;
                $this->products[$key]['volume_discount'] = 0;
                $this->products[$key]['volume_discount_total'] = 0;
                $this->products[$key]['is_shipping_selected'] = false;
                $selProdCost = $shopId = '';
                /* seller products[ */
                if ($selprod_id > 0) {
                    $sellerProductRow =  $cartProdsData[$selprod_id] ?? [];
                    if (!$sellerProductRow) {
                        Message::addErrorMessage(Labels::getLabel('ERR_PRODUCT_NOT_AVAILABLE_OR_OUT_OF_STOCK_SO_REMOVED_FROM_CART_LISTING', $siteLangId));
                        $this->removeCartKey($key, $selprod_id, $quantity);
                        continue;
                    }

                    $ofrSelprodId = $_SESSION['offer_checkout']['selprod_id'] ?? 0;
                    $rfqOfferProd = (isset($_SESSION['offer_checkout']) && $ofrSelprodId == $sellerProductRow['selprod_id']);

                    $quantity = $sellerProductRow['quantity'];
                    $fulfilmentType = $this->fulfilmentType;
                    if (isset($this->SYSTEM_ARR['shopping_cart']['checkout_type'])) {
                        $fulfilmentType =  $this->SYSTEM_ARR['shopping_cart']['checkout_type'];
                    }

                    if ($this->valdateCheckoutType && isset($fulfilmentType) && $fulfilmentType > 0 && $sellerProductRow['selprod_fulfillment_type'] != Shipping::FULFILMENT_ALL && $sellerProductRow['selprod_fulfillment_type'] != $fulfilmentType && !in_array($sellerProductRow['product_type'], [Product::PRODUCT_TYPE_DIGITAL, Product::PRODUCT_TYPE_SERVICE]) && $checkFulfilmentType) {
                        unset($this->products[$key]);
                        continue;
                    }

                    $tempHoldStock = Product::tempHoldStockCount($sellerProductRow['selprod_id']);
                    $availableStock = $sellerProductRow['selprod_stock'] - $tempHoldStock;
                    $isOutOfMinOrderQty = ((int)($sellerProductRow['selprod_min_order_qty'] > $availableStock));

                    /* Has Stock */
                    if (!$rfqOfferProd && ((!$sellerProductRow['in_stock'] && true === $this->isAnyOutOfStock) || 0 < $isOutOfMinOrderQty)) {
                        $this->isAnyOutOfStock = false;
                    }
                    /* Has Stock */

                    /* Has Digital Product */
                    if (isset($sellerProductRow['is_digital_product']) && $sellerProductRow['is_digital_product'] && false === $this->hasDigitalProduct) {
                        $this->hasDigitalProduct = true;
                    }
                    /* Has Digital Product */

                    /* Has Service Product */
                    if (isset($sellerProductRow['is_service_product']) && $sellerProductRow['is_service_product'] && false === $this->hasServiceProduct) {
                        $this->hasServiceProduct = true;
                    }
                    /* Has Digital Product */

                    /* Has Physical Product */
                    if (isset($sellerProductRow['is_physical_product']) && !empty($sellerProductRow['is_physical_product']) && false === $this->hasPhysicalProduct) {
                        $this->hasPhysicalProduct = true;
                    }
                    /* Has Physical Product */

                    if (isset($sellerProductRow['is_batch']) && !empty($sellerProductRow['products']) && (false === $this->hasDigitalProduct || false === $this->hasPhysicalProduct || false === $this->hasServiceProduct)) {
                        foreach ($sellerProductRow['products'] as $pgproduct) {
                            if ($pgproduct['is_digital_product'] && false === $this->hasDigitalProduct) {
                                $this->hasDigitalProduct = true;
                            }

                            if ($pgproduct['is_service_product'] && false === $this->hasServiceProduct) {
                                $this->hasServiceProduct = true;
                            }

                            if ($pgproduct['is_physical_product'] && false === $this->hasPhysicalProduct) {
                                $this->hasPhysicalProduct = true;
                            }
                        }
                    }

                    $this->products[$key] = $sellerProductRow;

                    /*[COD available*/
                    $codEnabled = false;
                    // $isProductShippedBySeller = Product::isProductShippedBySeller($sellerProductRow['product_id'], $sellerProductRow['product_seller_id'], $sellerProductRow['selprod_user_id']);
                    $isProductShippedBySeller = $sellerProductRow['isProductShippedBySeller'];

                    if ($is_cod_enabled && $isProductShippedBySeller) {
                        $walletBalance = User::getUserBalance($sellerProductRow['selprod_user_id']);
                        if ($sellerProductRow['selprod_cod_enabled'] == 1 && $sellerProductRow['product_cod_enabled'] == 1) {
                            $codEnabled = true;
                        }
                        $codMinWalletBalance = -1;
                        $shop_cod_min_wallet_balance = Shop::getAttributesByUserId($sellerProductRow['selprod_user_id'], 'shop_cod_min_wallet_balance');
                        if ($shop_cod_min_wallet_balance > -1) {
                            $codMinWalletBalance = $shop_cod_min_wallet_balance;
                        } elseif (FatApp::getConfig('CONF_COD_MIN_WALLET_BALANCE', FatUtility::VAR_FLOAT, -1) > -1) {
                            $codMinWalletBalance = FatApp::getConfig('CONF_COD_MIN_WALLET_BALANCE', FatUtility::VAR_FLOAT, -1);
                        }
                        if ($codMinWalletBalance > -1 && $codMinWalletBalance > $walletBalance) {
                            $codEnabled = false;
                        }
                    } else {
                        if ($sellerProductRow['product_cod_enabled']) {
                            $codEnabled = true;
                        }
                    }
                    $is_cod_enabled = $codEnabled;
                    /* ]*/

                    /*[ Product shipping cost */
                    $shippingCost = 0;

                    if (!empty($productSelectedShippingMethodsArr['product']) && isset($productSelectedShippingMethodsArr['product'][$sellerProductRow['selprod_id']])) {
                        $shippingDurationRow = $productSelectedShippingMethodsArr['product'][$sellerProductRow['selprod_id']];
                        $this->products[$key]['opshipping_rate_id'] = isset($shippingDurationRow['mshipapi_id']) ? $shippingDurationRow['mshipapi_id'] : '';
                        $shippingCost = ROUND(($shippingDurationRow['mshipapi_cost']), 2);
                        $this->products[$key]['shipping_cost'] = $shippingCost;
                    }

                    if (UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged()) {
                        $address = new Address($this->getCartShippingAddress(), $siteLangId);
                        $this->products[$key]['shipping_address'] = $address->getData(Address::TYPE_USER, UserAuthentication::getLoggedUserId());
                    }
                    /*]*/
                    if (in_array($this->products[$key]['product_type'], [Product::PRODUCT_TYPE_DIGITAL, Product::PRODUCT_TYPE_SERVICE])) {
                        if (UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged()) {
                            $addressBilling = new Address($this->getCartBillingAddress(), $siteLangId);
                            $this->products[$key]['billing_address'] = $addressBilling->getData(Address::TYPE_USER, UserAuthentication::getLoggedUserId());
                        }
                        $shipingAddress = isset($this->products[$key]['billing_address']) ? $this->products[$key]['billing_address'] : '';
                    } else {
                        $shipingAddress = isset($this->products[$key]['shipping_address']) ? $this->products[$key]['shipping_address'] : '';
                    }
                    $extraData = array(
                        'billingAddress' => isset($this->products[$key]['billing_address']) ? $this->products[$key]['billing_address'] : '',
                        'shippingAddress' => $shipingAddress,
                        'shippedBySeller' => $isProductShippedBySeller,
                        'shippingCost' => $shippingCost,
                        'buyerId' => $this->cart_user_id
                    );

                    /*[ Product Tax */
                    $taxableProdPrice = $sellerProductRow['theprice'] - $sellerProductRow['volume_discount'];
                    if (isset($cartDiscounts['discountedSelProdIds']) && array_key_exists($sellerProductRow['selprod_id'], $cartDiscounts['discountedSelProdIds'])) {
                        $taxableProdPrice = $taxableProdPrice - ($cartDiscounts['discountedSelProdIds'][$sellerProductRow['selprod_id']]) / $quantity;
                    }

                    $taxObj = new Tax();
                    $taxData = $taxObj->calculateTaxRates($sellerProductRow['product_id'], $taxableProdPrice, $sellerProductRow['selprod_user_id'], $siteLangId, $quantity, $extraData, $this->cartCache);
                    if (false == $taxData['status'] && $taxData['msg'] != '') {
                        $this->error = $taxData['msg'];
                    }

                    $taxOptions = [];
                    if (array_key_exists('options', $taxData)) {
                        /* foreach ($taxData['options'] as $optionId => $optionval) {
                            if (0 < $optionval['value']) {
                                $taxOptions[$optionval['name']] = isset($taxOptions[$optionval['name']]) ? ($taxOptions[$optionval['name']] + $optionval['value']) : $optionval['value'];
                            }
                        } */
                        if (array_key_exists('options', $taxData)) {
                            foreach ($taxData['options'] as $optionId => $optionval) {
                                $prodTaxOptions[$sellerProductRow['selprod_id']][$optionId] = $optionval;
                                if (isset($optionval['value']) && 0 < $optionval['value']) {
                                    $taxOptions[$optionval['name']]['value'] = isset($taxOptions[$optionval['name']]['value']) ? ($taxOptions[$optionval['name']]['value'] + $optionval['value']) : $optionval['value'];
                                    $taxOptions[$optionval['name']]['title'] = CommonHelper::displayTaxPercantage($optionval);
                                }
                            }
                        }
                    }

                    $tax = $taxData['tax'];

                    $this->products[$key]['tax'] = $tax;
                    $this->products[$key]['taxCode'] = $taxData['taxCode'];
                    $this->products[$key]['taxOptions'] = $taxOptions;
                    /*]*/

                    /*[ Product Commission */
                    $commissionPercentage = SellerProduct::getProductCommission($sellerProductRow['selprod_id']);
                    $commissionCostValue = $sellerProductRow['theprice'];

                    if (FatApp::getConfig('CONF_COMMISSION_INCLUDING_TAX', FatUtility::VAR_INT, 0) && $tax) {
                        $commissionCostValue = $commissionCostValue + ($tax / $quantity);
                    }

                    if (FatApp::getConfig('CONF_COMMISSION_INCLUDING_SHIPPING', FatUtility::VAR_INT, 0) && $shippingCost) {
                        $commissionCostValue = $commissionCostValue + ($shippingCost / $quantity);
                    }

                    $commissionCostValue = ROUND(($commissionCostValue * $quantity), 2);
                    $commission = ROUND(($commissionCostValue * $commissionPercentage / 100), 2);
                    $commission = MIN($commission, $maxConfiguredCommissionVal);

                    $this->products[$key]['commission_percentage'] = $commissionPercentage;
                    $this->products[$key]['commission'] = ROUND($commission, 2);
                    /*]*/

                    /* Affiliate Commission[ */
                    if ($associatedAffiliateUserId > 0) {
                        $affiliateCommissionPercentage = AffiliateCommission::getAffiliateCommission($associatedAffiliateUserId, $sellerProductRow['product_id'], $prodObj);
                        $affiliateCommissionCostValue = ROUND($sellerProductRow['theprice'] * $quantity, 2);
                        $affiliateCommission = ROUND($affiliateCommissionCostValue * $affiliateCommissionPercentage / 100, 2);
                    }
                    /* ] */
                    $selProdCost = $sellerProductRow['selprod_cost'];
                    $shopId = $sellerProductRow['shop_id'];
                } else {
                    $is_cod_enabled = false;
                    if (UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged()) {
                        $address = new Address($this->getCartShippingAddress(), $siteLangId);
                        $this->products[$key]['shipping_address'] =  $address->getData(Address::TYPE_USER, UserAuthentication::getLoggedUserId());
                    }
                }
                /* ] */

                $this->products[$key]['key'] = $key;
                $this->products[$key]['is_batch'] = 0;
                $this->products[$key]['is_cod_enabled'] = $is_cod_enabled;
                $this->products[$key]['selprod_id'] = $selprod_id;
                $this->products[$key]['quantity'] = $quantity;
                $this->products[$key]['has_physical_product'] = 0;
                $this->products[$key]['has_digital_product'] = 0;
                $this->products[$key]['selprod_cost'] = $selProdCost;
                $this->products[$key]['affiliate_commission_percentage'] = $affiliateCommissionPercentage;
                $this->products[$key]['affiliate_commission'] = $affiliateCommission;
                $this->products[$key]['affiliate_user_id'] = $associatedAffiliateUserId;
                if (UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged()) {
                    $this->products[$key]['seller_address'] = Shop::getShopAddress($shopId, true, $siteLangId);
                }
                $this->products[$key]['fulfillment_type'] = $sellerProductRow['fulfillment_type'];
                $this->products[$key]['rounding_off'] = $sellerProductRow['rounding_off'];

                $this->shipmentItemsCount += ($sellerProductRow['fulfillment_type'] != Shipping::FULFILMENT_PICKUP) ? 1 : 0;
            }
        }
        return $this->products;
    }

    public function getSellerProductsData($cartData, $siteLangId, $loggedUserId = 0)
    {
        $selProdIds = array_keys($cartData);

        $prodSrch = new ProductSearch($siteLangId);
        $prodSrch->setDefinedCriteria(0, 0, ['selProdIds' => $selProdIds, 'doNotJoinSellers' => true]);
        $prodSrch->joinShops(0, true, true, 0, true);
        $prodSrch->joinProductToCategory();
        $prodSrch->joinSellerSubscription();
        $prodSrch->addSubscriptionValidCondition();
        $prodSrch->joinProductShippedBy();
        $prodSrch->joinProductFreeShipping();
        // $prodSrch->joinSellers();        
        $prodSrch->doNotCalculateRecords();
        $prodSrch->doNotLimitRecords();
        $prodSrch->addDirectCondition('selprod_id IN (' . implode(',', $selProdIds) . ')');
        $prodSrch->addMultipleFields(array(
            'product_id', 'product_type', 'product_length', 'product_width', 'product_height', 'product_ship_free',
            'product_dimension_unit', 'product_weight', 'product_weight_unit', 'product_fulfillment_type',
            'selprod_id', 'selprod_code', 'selprod_stock', 'selprod_user_id', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'selprod_min_order_qty',
            'special_price_found', 'theprice', 'shop_id', 'shop_free_ship_upto', 'shop_state_id', 'shop_country_id',
            'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type', 'selprod_price', 'selprod_cost', 'case when product_seller_id=0 then IFNULL(psbs_user_id,0)   else product_seller_id end  as psbs_user_id', 'product_seller_id', 'product_cod_enabled', 'shop_fulfillment_type', 'selprod_fulfillment_type', 'selprod_cod_enabled', 'shippack_length', 'shippack_width', 'shippack_height', 'shippack_units',
            'COALESCE(prodcat_name, prodcat_identifier) as prodcat_name', 'product_updated_on', 'selprod_track_inventory'
        ));

        if ($siteLangId) {
            $prodSrch->joinBrands();
            $prodSrch->addFld(array('IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'IFNULL(brand_name, brand_identifier) as brand_name', 'IFNULL(shop_name, shop_identifier) as shop_name', 'brand_id'));
        }

        if (0 < $loggedUserId) {
            if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
                $prodSrch->joinFavouriteProducts($loggedUserId);
                $prodSrch->addFld('IFNULL(ufp_id, 0) as ufp_id');
            } else {
                $prodSrch->joinUserWishListProducts($loggedUserId);
                $prodSrch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist, IFNULL(uwlp.uwlp_uwlist_id, 0) as uwlp_uwlist_id');
            }
        }

        $sellerProductRows = FatApp::getDb()->fetchAll($prodSrch->getResultSet(), 'selprod_id');
        if (empty($sellerProductRows)) {
            return $sellerProductRows;
        }

        $productSelectedShippingMethodsArr = $this->getProductShippingMethod();
        foreach ($sellerProductRows as $key => $sellerProductRow) {
            $rfqOfferProd = (isset($_SESSION['offer_checkout']) && $_SESSION['offer_checkout']['selprod_id'] == $sellerProductRow['selprod_id']);
            if ($rfqOfferProd) {
                $ofrTheprice = $_SESSION['offer_checkout']['offer_price'] ?? $sellerProductRow['theprice'];
                $selprodPrice = $_SESSION['offer_checkout']['offer_price'] ?? $sellerProductRow['selprod_price'];
                $ofrQuantity = $_SESSION['offer_checkout']['offer_quantity'] ?? $sellerProductRow['selprod_stock'];
                $sellerProductRows[$key]['selprod_stock'] = $sellerProductRow['selprod_stock'] = $ofrQuantity;
                $sellerProductRows[$key]['theprice'] =  $sellerProductRow['theprice'] = $ofrTheprice / $ofrQuantity;
                $sellerProductRows[$key]['selprod_price'] = $sellerProductRow['selprod_price'] = $selprodPrice / $ofrQuantity;
                $sellerProductRows[$key]['volume_discount'] = $sellerProductRow['volume_discount'] = 0;
                $sellerProductRows[$key]['splprice_price'] = $sellerProductRow['splprice_price'] = 0;
            }

            $quantity = ($cartData[$key] > $sellerProductRow['selprod_stock']) ? $sellerProductRow['selprod_stock'] : $cartData[$key];
            $quantity = (1 > $quantity) ? 1 : $quantity;
            $sellerProductRows[$key]['actualPrice'] = $sellerProductRow['theprice'];

            $extraData = [];
            if ($this->includeTax == true) {
                $shipFromStateId = $sellerProductRow['shop_state_id'];
                $shipFromCountryId = $sellerProductRow['shop_country_id'];
                $shipToStateId = 0;
                $shipToCountryId = 0;
                if (in_array($sellerProductRow['product_type'], [Product::PRODUCT_TYPE_DIGITAL, Product::PRODUCT_TYPE_SERVICE])) {
                    $shippingAddressId = $this->getCartBillingAddress();
                } else {
                    $shippingAddressId = $this->getCartShippingAddress();
                }

                $shippingAddressDetail = [];
                if (0 < $shippingAddressId) {
                    $address = new Address($shippingAddressId, $this->cart_lang_id);
                    $shippingAddressDetail =  $address->getData(Address::TYPE_USER, $this->cart_user_id);

                    if (isset($shippingAddressDetail['addr_country_id'])) {
                        $shipToCountryId = FatUtility::int($shippingAddressDetail['addr_country_id']);
                    }

                    if (isset($shippingAddressDetail['addr_state_id'])) {
                        $shipToStateId = FatUtility::int($shippingAddressDetail['addr_state_id']);
                    }
                }

                $shippingCost = 0;
                if (!empty($productSelectedShippingMethodsArr['product']) && isset($productSelectedShippingMethodsArr['product'][$sellerProductRow['selprod_id']])) {
                    $shippingDurationRow = $productSelectedShippingMethodsArr['product'][$sellerProductRow['selprod_id']];
                    $shippingCost = ROUND(($shippingDurationRow['mshipapi_cost']), 2);
                }

                $isProductShippedBySeller = Product::isProductShippedBySeller($sellerProductRow['product_id'], $sellerProductRow['product_seller_id'], $sellerProductRow['selprod_user_id']);

                if (!$isProductShippedBySeller) {
                    $shipFromCountryId = FatApp::getConfig('CONF_COUNTRY', FatUtility::VAR_INT, 0);
                    $shipFromStateId = FatApp::getConfig('CONF_STATE', FatUtility::VAR_INT, 0);
                }

                $extraData = array(
                    'billingAddress' => isset($sellerProductRow['billing_address']) ? $sellerProductRow['billing_address'] : '',
                    'shippingAddress' => $shippingAddressDetail,
                    'shippedBySeller' => $isProductShippedBySeller,
                    'shippingCost' => $shippingCost,
                    'buyerId' => $this->cart_user_id
                );
            }

            if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0) && $this->includeTax == true) {
                $tax = new Tax();
                $tax->setFromCountryId($shipFromCountryId);
                $tax->setFromStateId($shipFromStateId);
                $tax->setToCountryId($shipToCountryId);
                $tax->setToStateId($shipToStateId);
                $taxCategoryRow = $tax->getTaxRates($sellerProductRow['product_id'], $sellerProductRow['selprod_user_id'], $siteLangId);
                if (array_key_exists('trr_rate', $taxCategoryRow) && 0 == Tax::getActivatedServiceId()) {
                    $sellerProductRows[$key]['theprice'] = round($sellerProductRow['theprice'] / (1 + ($taxCategoryRow['trr_rate'] / 100)), 2);
                } else {
                    $taxObj = new Tax();
                    $taxData = $taxObj->calculateTaxRates($sellerProductRow['product_id'], $sellerProductRow['theprice'], $sellerProductRow['selprod_user_id'], $siteLangId, $quantity, $extraData, $this->cartCache);
                    if (isset($taxData['rate'])) {
                        $ruleRate = ($taxData['tax'] * 100) / ($sellerProductRow['theprice'] * $quantity);
                        $sellerProductRows[$key]['theprice'] = round((($sellerProductRow['theprice'] * $quantity) / (1 + ($ruleRate / 100))) / $quantity, 2);
                    }
                }
            }
            /* update/fetch/apply theprice, according to volume discount module[ */
            $sellerProductRows[$key]['volume_discount'] = 0;
            $sellerProductRows[$key]['volume_discount_percentage'] = 0;
            $sellerProductRows[$key]['volume_discount_total'] = 0;
            if (!$rfqOfferProd) {
                $srch = new SellerProductVolumeDiscountSearch();
                $srch->doNotCalculateRecords();
                $srch->addCondition('voldiscount_selprod_id', '=', 'mysql_func_' . $sellerProductRow['selprod_id'], 'AND', true);
                $srch->addCondition('voldiscount_min_qty', '<=', 'mysql_func_' . $quantity, 'AND', true);
                $srch->addOrder('voldiscount_min_qty', 'DESC');
                $srch->setPageSize(1);
                $srch->addMultipleFields(array('voldiscount_percentage'));
                $rs = $srch->getResultSet();
                $volumeDiscountRow = FatApp::getDb()->fetch($rs);
                if ($volumeDiscountRow) {
                    $volumeDiscount = $sellerProductRows[$key]['theprice'] * ($volumeDiscountRow['voldiscount_percentage'] / 100);
                    $sellerProductRows[$key]['volume_discount_percentage'] = $volumeDiscountRow['voldiscount_percentage'];
                    $sellerProductRows[$key]['volume_discount'] = $volumeDiscount;
                    $sellerProductRows[$key]['volume_discount_total'] = $volumeDiscount * $quantity;
                }
            }
            /* ] */

            /* set variable of shipping cost of the product, if shipping already selected[ */
            $sellerProductRows[$key]['shipping_cost'] = 0;
            $sellerProductRows[$key]['opshipping_rate_id'] = 0;
            if (!empty($productSelectedShippingMethodsArr) && isset($productSelectedShippingMethodsArr['product'][$sellerProductRow['selprod_id']])) {
                $shippingDurationRow = $productSelectedShippingMethodsArr['product'][$sellerProductRow['selprod_id']];
                $sellerProductRows[$key]['opshipping_rate_id'] = $shippingDurationRow['mshipapi_id'];
                $sellerProductRows[$key]['shipping_cost'] = ROUND(($shippingDurationRow['mshipapi_cost'] * $quantity), 2);
            }
            /* ] */

            /* calculation of commission and tax against each product[ */
            $commission = 0;
            $tax = 0;
            $maxConfiguredCommissionVal = FatApp::getConfig("CONF_MAX_COMMISSION");

            $commissionPercentage = SellerProduct::getProductCommission($sellerProductRow['selprod_id']);
            $commission = MIN(ROUND($sellerProductRows[$key]['theprice'] * $commissionPercentage / 100, 2), $maxConfiguredCommissionVal);
            $sellerProductRows[$key]['commission_percentage'] = $commissionPercentage;
            $sellerProductRows[$key]['commission'] = ROUND($commission * $quantity, 2);

            $totalPrice = $sellerProductRows[$key]['theprice'] * $quantity;

            $taxableProdPrice = $sellerProductRows[$key]['theprice'] - $sellerProductRows[$key]['volume_discount'];
            $discountedPrice = 0;

            if (FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0)) {
                if (!empty($this->discounts) && isset($this->discounts['discountedSelProdIds'][$sellerProductRow['selprod_id']])) {
                    $discountedPrice = $this->discounts['discountedSelProdIds'][$sellerProductRow['selprod_id']];
                    $taxableProdPrice = $taxableProdPrice - $discountedPrice;
                }
            }

            $taxObj = new Tax();
            $taxData = $taxObj->calculateTaxRates($sellerProductRow['product_id'], $taxableProdPrice, $sellerProductRow['selprod_user_id'], $siteLangId, $quantity, $extraData);

            if (false == $taxData['status'] && $taxData['msg'] != '') {
                //$this->error = $taxData['msg'];
            }

            $tax = $taxData['tax'];
            $roundingOff = 0;
            if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0)) {
                $originalTotalPrice = ($sellerProductRow['theprice'] * $quantity);
                $thePriceincludingTax = $taxData['tax'] + $totalPrice;
                if (0 < $sellerProductRows[$key]['volume_discount_total'] && array_key_exists('rate', $taxData)) {
                    $thePriceincludingTax = $thePriceincludingTax + (($sellerProductRows[$key]['volume_discount_total'] * $taxData['rate']) / 100);
                }

                if (0 < $discountedPrice) {
                    $thePriceincludingTax = $thePriceincludingTax + (($discountedPrice * $taxData['rate']) / 100);
                }

                if ($originalTotalPrice != $thePriceincludingTax && 0 < $taxableProdPrice && 0 < $taxData['rate']) {
                    $roundingOff = round($originalTotalPrice - $thePriceincludingTax, 2);
                }
            } else {
                if (array_key_exists('optionsSum', $taxData) && $taxData['tax'] != $taxData['optionsSum']) {
                    $roundingOff = round($taxData['tax'] - $taxData['optionsSum'], 2);
                }
            }


            $sellerProductRows[$key]['rounding_off'] = $roundingOff;

            $sellerProductRows[$key]['tax'] = $tax;
            $sellerProductRows[$key]['optionsTaxSum'] = isset($taxData['optionsSum']) ? $taxData['optionsSum'] : 0;
            $sellerProductRows[$key]['taxCode'] = $taxData['taxCode'];
            /* ] */

            $sellerProductRows[$key]['total'] = $totalPrice;
            $sellerProductRows[$key]['netTotal'] = $totalPrice + $sellerProductRows[$key]['shipping_cost'] + $roundingOff;

            $sellerProductRows[$key]['is_digital_product'] = ($sellerProductRow['product_type'] == Product::PRODUCT_TYPE_DIGITAL) ? 1 : 0;
            $sellerProductRows[$key]['is_physical_product'] = ($sellerProductRow['product_type'] == Product::PRODUCT_TYPE_PHYSICAL) ? 1 : 0;
            $sellerProductRows[$key]['is_service_product'] = ($sellerProductRow['product_type'] == Product::PRODUCT_TYPE_SERVICE) ? 1 : 0;


            if ($siteLangId) {
                $sellerProductRows[$key]['options'] = SellerProduct::getSellerProductOptions($sellerProductRow['selprod_id'], true, $siteLangId);
            } else {
                $sellerProductRows[$key]['options'] = SellerProduct::getSellerProductOptions($sellerProductRow['selprod_id'], false);
            }

            $isProductShippedBySeller = Product::isProductShippedBySeller($sellerProductRow['product_id'], $sellerProductRow['product_seller_id'], $sellerProductRow['selprod_user_id']);
            $sellerProductRows[$key]['isProductShippedBySeller'] = $isProductShippedBySeller;

            $fulfillmentType = $sellerProductRow['selprod_fulfillment_type'];
            if (true == $isProductShippedBySeller) {
                if ($sellerProductRow['shop_fulfillment_type'] != Shipping::FULFILMENT_ALL) {
                    $fulfillmentType = $sellerProductRow['shop_fulfillment_type'];
                    $sellerProductRows[$key]['selprod_fulfillment_type'] = $fulfillmentType;
                }
            } else {
                $fulfillmentType = isset($sellerProductRow['product_fulfillment_type']) ? $sellerProductRow['product_fulfillment_type'] : Shipping::FULFILMENT_SHIP;
                $sellerProductRows[$key]['selprod_fulfillment_type'] = $fulfillmentType;
                if (FatApp::getConfig('CONF_FULFILLMENT_TYPE', FatUtility::VAR_INT, -1) != Shipping::FULFILMENT_ALL) {
                    $fulfillmentType = FatApp::getConfig('CONF_FULFILLMENT_TYPE', FatUtility::VAR_INT, -1);
                    $sellerProductRows[$key]['selprod_fulfillment_type'] = $fulfillmentType;
                }
            }

            if (in_array($sellerProductRow['product_type'], [Product::PRODUCT_TYPE_DIGITAL, Product::PRODUCT_TYPE_SERVICE])) {
                $fulfillmentType = Shipping::FULFILMENT_ALL;
            }
            $sellerProductRows[$key]['fulfillment_type'] = $fulfillmentType;
            $sellerProductRows[$key]['quantity'] = $quantity;
        }
        return $sellerProductRows;
    }

    public function removeCartKey($key, $selProdId, $quantity)
    {
        if (is_numeric($this->cart_user_id) && $this->cart_user_id > 0) {
            AbandonedCart::saveAbandonedCart($this->cart_user_id, $selProdId, $quantity, AbandonedCart::ACTION_DELETED);
        }
        unset($this->products[$key]);
        unset($this->basketProducts[$key]);
        unset($this->SYSTEM_ARR['cart'][$key]);
        $this->updateUserCart();
        return true;
    }

    public function remove($key)
    {
        $this->products = array();
        $this->basketProducts = [];
        $this->invalidateCheckoutType();
        $cartProducts = $this->getProducts($this->cart_lang_id);
        $found = false;
        if (is_array($cartProducts)) {
            $advanceEcommerce = FatApp::getConfig('CONF_ANALYTICS_ADVANCE_ECOMMERCE', FatUtility::VAR_INT, 0);
            $ga4 = FatApp::getConfig('CONF_GOOGLE_ANALYTICS_4', FatUtility::VAR_INT, 0);
            foreach ($cartProducts as $cartKey => $product) {
                if (($key == 'all' || (md5($product['key']) == $key) && !$product['is_batch'])) {
                    $found = true;
                    unset($this->SYSTEM_ARR['cart'][$cartKey]);
                    $this->updateTempStockHold($product['selprod_id'], 0, 0);
                    if (($key == 'all' || md5($product['key']) == $key) && !$product['is_batch']) {
                        if ($advanceEcommerce) {
                            if (0 == $ga4) {
                                $et = new EcommerceTracking(Labels::getLabel('LBL_PRODUCT_DETAIL', commonHelper::getLangId()), $this->cart_user_id);
                                $et->addProductAction(EcommerceTracking::PROD_ACTION_TYPE_REMOVE_FROM_CART);
                                $et->addProduct($product['selprod_id'], $product['selprod_title'], $product['prodcat_name'], $product['brand_name'], 0);
                                $et->sendRequest();
                            } else if (false === MOBILE_APP_API_CALL) {
                                $this->removedItems[] = $product;
                            }
                        }
                        if (is_numeric($this->cart_user_id) && $this->cart_user_id > 0) {
                            AbandonedCart::saveAbandonedCart($this->cart_user_id, $product['selprod_id'], $product['quantity'], AbandonedCart::ACTION_DELETED);
                        }
                        break;
                    }
                }
            }
        }
        $this->updateUserCart();
        if (false === $found) {
            $this->error = Labels::getLabel('ERR_INVALID_PRODUCT', $this->cart_lang_id);
        }
        unset($_SESSION['offer_checkout']);
        return $found;
    }

    public function getRemovedItems(): array
    {
        return $this->removedItems;
    }

    public function getSingleCartSellerId(): array
    {
        return $this->singleCartSellerId;
    }

    public function removeGroup($prodgroup_id)
    {
        $prodgroup_id = FatUtility::int($prodgroup_id);
        $this->products = array();
        $this->basketProducts = [];
        $cartProducts = $this->getProducts($this->cart_lang_id);
        if (is_array($cartProducts)) {
            foreach ($cartProducts as $cartKey => $product) {
                if ($product['is_batch'] && $product['prodgroup_id'] == $prodgroup_id) {
                    unset($this->SYSTEM_ARR['cart'][$cartKey]);

                    /* to keep track of temporary hold the product stock[ */
                    foreach ($product['products'] as $pgproduct) {
                        $this->updateTempStockHold($pgproduct['selprod_id'], 0, $prodgroup_id);
                    }
                    /* ] */
                    break;
                }
            }
        }
        $this->updateUserCart();
        return true;
    }

    public function getWarning()
    {
        return $this->warning;
    }

    public function update($key, $quantity)
    {
        $quantity = FatUtility::int($quantity);
        $found = false;
        if ($quantity > 0) {
            $cartProducts = $this->getBasketProducts($this->cart_lang_id);
            $cart_user_id = $this->cart_user_id;

            if (is_array($cartProducts)) {
                foreach ($cartProducts as $cartKey => $product) {
                    if (md5($product['key']) == $key) {
                        if (isset($_SESSION['offer_checkout']) && $_SESSION['offer_checkout']['selprod_id'] == $product['selprod_id']) {
                            continue;
                        }
                        $found = true;
                        /* minimum quantity check[ */
                        $minimum_quantity = ($product['selprod_min_order_qty']) ? $product['selprod_min_order_qty'] : 1;
                        if ($quantity < $minimum_quantity) {
                            $str = Labels::getLabel('MSG_PLEASE_ADD_MINIMUM_{minimumquantity}', $this->cart_lang_id);
                            $str = str_replace("{minimumquantity}", $minimum_quantity, $str);
                            $this->warning = $str . " " . FatUtility::decodeHtmlEntities($product['product_name']);
                            break;
                        }
                        /* ] */


                        $tempHoldStock = Product::tempHoldStockCount($product['selprod_id']);
                        $availableStock = $cartProducts[$cartKey]['selprod_stock'] - $tempHoldStock;
                        $userTempHoldStock = Product::tempHoldStockCount($product['selprod_id'], $cart_user_id, 0, true);

                        if ($quantity > $userTempHoldStock) {
                            if ($availableStock == 0 || ($availableStock < ($quantity - $userTempHoldStock))) {
                                $this->warning = Labels::getLabel('MSG_REQUESTED_QUANTITY_MORE_THAN_STOCK_AVAILABLE', $this->cart_lang_id);
                                $quantity = $userTempHoldStock + $availableStock;
                            }
                        }

                        if ($quantity) {
                            $this->SYSTEM_ARR['cart'][$cartKey] = $quantity;
                            /* to keep track of temporary hold the product stock[ */
                            if (0 < $product['selprod_track_inventory']) {
                                $this->updateTempStockHold($product['selprod_id'], $quantity);
                            }
                            /* ] */
                            if (is_numeric($this->cart_user_id) && $this->cart_user_id > 0) {
                                AbandonedCart::saveAbandonedCart($this->cart_user_id, $product['selprod_id'], $quantity, AbandonedCart::ACTION_ADDED);
                            }
                            break;
                        } else {
                            $this->remove($key);
                        }
                    }
                }
            }
            $this->updateUserCart();
        } else {
            $this->error = Labels::getLabel('ERR_QUANTITY_SHOULD_BE_GREATER_THAN_0', $this->cart_lang_id);
            return false;
        }
        if (false === $found) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->cart_lang_id);
        }
        return $found;
    }

    public function updateGroup($prodgroup_id, $quantity)
    {
        $prodgroup_id = FatUtility::int($prodgroup_id);
        $quantity = FatUtility::int($quantity);

        $cart_user_id = $this->cart_user_id;
        /* not handled the case, if any product from the group is added separately, stock sum from that product and product in group is not checked, need to handle the same. */

        if ($quantity > 0) {
            $cartProducts = $this->getBasketProducts($this->cart_lang_id);
            if (is_array($cartProducts)) {
                $prodGroupQtyArr = array();
                $inStock = true;
                foreach ($cartProducts as $cartKey => $product) {
                    if ($product['is_batch'] && $product['prodgroup_id'] == $prodgroup_id) {
                        foreach ($product['products'] as $pgproduct) {
                            $tempHoldStock = Product::tempHoldStockCount($pgproduct['selprod_id']);
                            $availableStock = $pgproduct['selprod_stock'] - $tempHoldStock;
                            $userTempHoldStock = Product::tempHoldStockCount($pgproduct['selprod_id'], $cart_user_id, $product['prodgroup_id'], true);

                            if ($availableStock == 0 || ($availableStock < ($quantity - $userTempHoldStock))) {
                                $this->warning = Labels::getLabel('MSG_REQUESTED_QUANTITY_MORE_THAN_STOCK_AVAILABLE', $this->cart_lang_id);
                                $quantity = $userTempHoldStock + $availableStock;
                                $inStock = false;
                                break;
                            }
                            $prodGroupQtyArr[$pgproduct['selprod_id']] = $quantity;
                        }

                        if (!$inStock) {
                            break;
                        }
                    }
                }

                if (!empty($prodGroupQtyArr)) {
                    $maxAvailableQty = min($prodGroupQtyArr);
                    if ($quantity > $maxAvailableQty) {
                        /* $msgString = str_replace("{n}", $maxAvailableQty, "MSG_One_of_the_product_in_combo_is_not_available_in_requested_quantity,_you_can_buy_upto_max_{n}_quantity."); */
                        $this->warning = Labels::getLabel("MSG_ONE_OF_THE_PRODUCT_IN_COMBO_IS_NOT_AVAILABLE_IN_REQUESTED_QUANTITY,_YOU_CAN_BUY_UPTO_MAX_{n}_QUANTITY.", $this->cart_lang_id);
                        $this->warning = str_replace("{n}", $maxAvailableQty, $this->warning);
                        return true;
                    }
                }

                if ($inStock) {
                    foreach ($cartProducts as $cartKey => $product) {
                        if ($product['is_batch'] && $product['prodgroup_id'] == $prodgroup_id) {
                            $this->SYSTEM_ARR['cart'][$cartKey] = $quantity;
                            foreach ($product['products'] as $pgproduct) {
                                if (0 < $pgproduct['selprod_track_inventory']) {
                                    $this->updateTempStockHold($pgproduct['selprod_id'], $quantity, $prodgroup_id);
                                }
                            }
                        }
                    }
                }
            }
            $this->updateUserCart();
        }
        return true;
    }

    public function setCartBillingAddress($address_id = 0)
    {
        $address_id = FatUtility::int($address_id);
        if (1 > $address_id) {
            $address = Address::getDefaultByRecordId(Address::TYPE_USER, $this->cart_user_id);
            if (!empty($address)) {
                $address_id = $address['addr_id'];
            }
        }
        $this->SYSTEM_ARR['shopping_cart']['billing_address_id'] = $address_id;
        $this->updateUserCart();
        return true;
    }

    public function setCartShippingAddress($address_id)
    {
        $this->SYSTEM_ARR['shopping_cart']['shipping_address_id'] = $address_id;
        $this->updateUserCart();
        return true;
    }

    public function unsetCartShippingAddress()
    {
        unset($this->SYSTEM_ARR['shopping_cart']['shipping_address_id']);
        $this->updateUserCart();
        return true;
    }

    public function setShippingAddressSameAsBilling()
    {
        $billing_address_id = $this->getCartBillingAddress();
        if ($billing_address_id) {
            $this->setCartShippingAddress($billing_address_id);
            $this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling'] = true;
        }
    }

    public function unSetShippingAddressSameAsBilling()
    {
        if (isset($this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling'])) {
            unset($this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling']);
        }
    }

    public function setCartShippingApi($shippingapi_id)
    {
        $this->SYSTEM_ARR['shopping_cart']['shippingapi_id'] = FatUtility::int($shippingapi_id);
        $this->updateUserCart();
        return true;
    }

    public function getCartBillingAddress()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['billing_address_id']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['billing_address_id']) : 0;
    }

    public function getCartShippingAddress()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['shipping_address_id']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['shipping_address_id']) : 0;
    }

    public function getCartShippingApi()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['shippingapi_id']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['shippingapi_id']) : 0;
    }

    public function getShippingAddressSameAsBilling()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling']) : 0;
    }

    public function setProductShippingMethod($arr)
    {
        $this->SYSTEM_ARR['shopping_cart']['product_shipping_methods'] = $arr;
        $this->updateUserCart();
        return true;
    }

    public function removeProductShippingMethod()
    {
        unset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']);
        $this->updateUserCart();
        return true;
    }

    public function getProductShippingMethod()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']) ? $this->SYSTEM_ARR['shopping_cart']['product_shipping_methods'] : array();
    }

    public function isProductShippingMethodSet()
    {
        foreach ($this->getProducts($this->cart_lang_id) as $product) {
            if ($product['is_batch']) {
                if ($product['has_physical_product'] && !isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['group'][$product['prodgroup_id']])) {
                    return false;
                }
                if (isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['group'][$product['prodgroup_id']]['mshipapi_id'])) {
                    $mshipapi_id = $this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['group'][$product['prodgroup_id']]['mshipapi_id'];
                    $manualShipingApiRow = ManualShippingApi::getAttributesById($mshipapi_id, 'mshipapi_id');
                    if (!$manualShipingApiRow) {
                        return false;
                    }
                }
            } else {
                if ($product['is_physical_product'] && !isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['product'][$product['selprod_id']])) {
                    return false;
                }
            }
        }
        return true;
    }

    public function getSubTotal()
    {
        $cartTotal = 0;
        $products = $this->getBasketProducts($this->cart_lang_id);
        if (is_array($products) && count($products) > 0) {
            foreach ($products as $product) {
                $cartTotal += $product['total'];
            }
        }
        return $cartTotal;
    }

    public function getCartFinancialSummary($langId)
    {
        $products = $this->getProducts($langId);
        $cartTotal = 0;
        $shippingTotal = 0;
        $originalShipping = 0;
        $orderPaymentGatewayCharges = 0;
        $cartTaxTotal = 0;
        $cartDiscounts = $this->getCouponDiscounts();

        $totalSiteCommission = 0;
        $orderNetAmount = 0;
        $cartRewardPoints = $this->getCartRewardPoint();
        $cartVolumeDiscount = 0;

        $isCodEnabled = true;
        $taxOptions = [];
        $prodTaxOptions = [];
        $roundingOff = 0;
        $originalTotalPrice = 0;
        $selProdTotalPrice = 0;
        $productSelectedShippingMethodsArr = $this->getProductShippingMethod();
        if (is_array($products) && count($products)) {
            foreach ($products as $product) {
                $codEnabled = false;
                if ($isCodEnabled && $product['is_cod_enabled']) {
                    $codEnabled = true;
                }
                $isCodEnabled = $codEnabled;
                if ($product['is_batch']) {
                    $cartTotal += $product['prodgroup_total'];
                } else {
                    $cartTotal += (float) ($product['total'] ?? 0);
                }

                $cartVolumeDiscount += $product['volume_discount_total'];

                $taxableProdPrice = $product['theprice'] - $product['volume_discount'];

                if (FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0)) {
                    if (isset($cartDiscounts['discountedSelProdIds']) && array_key_exists($product['selprod_id'], $cartDiscounts['discountedSelProdIds'])) {
                        $taxableProdPrice = $taxableProdPrice - ($cartDiscounts['discountedSelProdIds'][$product['selprod_id']]) / $product['quantity'];
                    }
                }

                $isProductShippedBySeller = Product::isProductShippedBySeller($product['product_id'], $product['product_seller_id'], $product['selprod_user_id']);

                $shippingCost = 0;
                if (!empty($productSelectedShippingMethodsArr['product']) && isset($productSelectedShippingMethodsArr['product'][$product['selprod_id']])) {
                    $shippingDurationRow = $productSelectedShippingMethodsArr['product'][$product['selprod_id']];
                    $shippingCost = ROUND(($shippingDurationRow['mshipapi_cost']), 2);
                }

                $taxObj = new Tax();
                if ($product['product_type'] == Product::PRODUCT_TYPE_DIGITAL) {
                    $shippingAddressId = $this->getCartBillingAddress();
                } else {
                    $shippingAddressId = $this->getCartShippingAddress();
                }

                $address = new Address($shippingAddressId, $this->cart_lang_id);
                $shippingAddressDetail =  $address->getData(Address::TYPE_USER, $this->cart_user_id);
                $extraData = array(
                    'billingAddress' => isset($product['billing_address']) ? $product['billing_address'] : '',
                    'shippingAddress' => $shippingAddressDetail,
                    'shippedBySeller' => $isProductShippedBySeller,
                    'shippingCost' => $shippingCost,
                    'buyerId' => $this->cart_user_id
                );

                if (self::PAGE_TYPE_CART != $this->pageType) {
                    $taxData = $taxObj->calculateTaxRates($product['product_id'], $taxableProdPrice, $product['selprod_user_id'], $langId, $product['quantity'], $extraData, $this->cartCache);

                    if (false == $taxData['status'] && $taxData['msg'] != '') {
                        $this->error = $taxData['msg'];
                    }
                    if (array_key_exists('options', $taxData)) {
                        foreach ($taxData['options'] as $optionId => $optionval) {
                            $prodTaxOptions[$product['selprod_id']][$optionId] = $optionval;
                            if (isset($optionval['value']) && 0 < $optionval['value']) {
                                $taxOptions[$optionval['name']]['value'] = isset($taxOptions[$optionval['name']]['value']) ? ($taxOptions[$optionval['name']]['value'] + $optionval['value']) : $optionval['value'];
                                $taxOptions[$optionval['name']]['title'] = CommonHelper::displayTaxPercantage($optionval);
                            }
                        }
                    }

                    $tax = $taxData['tax'];
                    $cartTaxTotal += $tax;
                }

                $originalShipping += $product['shipping_cost'];
                $totalSiteCommission += $product['commission'];
                $shippingTotal += $product['shipping_cost'];

                $roundingOff += $product['rounding_off'];
                $originalTotalPrice += ($product['actualPrice'] * $product['quantity']);
                $selProdTotalPrice += ($product['selprod_price'] * $product['quantity']);
            }
        }

        $userWalletBalance = User::getUserBalance($this->cart_user_id);

        $totalDiscountAmount = (isset($cartDiscounts['coupon_discount_total'])) ? $cartDiscounts['coupon_discount_total'] : 0;
        $orderNetAmount = (max($cartTotal - $cartVolumeDiscount - $totalDiscountAmount, 0) + $shippingTotal + $cartTaxTotal + $roundingOff);

        $orderNetAmount = $orderNetAmount - CommonHelper::rewardPointDiscount($orderNetAmount, $cartRewardPoints);

        $WalletAmountCharge = ($this->isCartUserWalletSelected()) ? min($orderNetAmount, $userWalletBalance) : 0;

        $orderPaymentGatewayCharges = $orderNetAmount - $WalletAmountCharge;

        $isCodValidForNetAmt = true;
        if (FatApp::getConfig("CONF_MAX_COD_ORDER_LIMIT", FatUtility::VAR_INT, 0) > 0) {
            if (($orderPaymentGatewayCharges >= FatApp::getConfig("CONF_MIN_COD_ORDER_LIMIT", FatUtility::VAR_INT, 0)) && ($orderPaymentGatewayCharges <= FatApp::getConfig("CONF_MAX_COD_ORDER_LIMIT", FatUtility::VAR_INT, 0)) && ($isCodEnabled)) {
                $isCodValidForNetAmt = true;
            } else {
                $isCodValidForNetAmt = false;
            }
        }

        $netChargeAmt = $cartTotal + $cartTaxTotal - ((0 < $cartVolumeDiscount) ? $cartVolumeDiscount : 0);

        $cartSummary = array(
            'cartTotal' => $cartTotal,
            'shippingTotal' => $shippingTotal,
            'originalShipping' => $originalShipping,
            'cartTaxTotal' => $cartTaxTotal,
            'cartDiscounts' => $cartDiscounts,
            'cartVolumeDiscount' => $cartVolumeDiscount,
            'cartRewardPoints' => $cartRewardPoints,
            'cartWalletSelected' => $this->isCartUserWalletSelected(),
            'siteCommission' => $totalSiteCommission,
            'orderNetAmount' => $orderNetAmount,
            'WalletAmountCharge' => $WalletAmountCharge,
            'isCodEnabled' => $isCodEnabled,
            'isCodValidForNetAmt' => (int)$isCodValidForNetAmt,
            'min_cod_order_limit' => CommonHelper::displayMoneyFormat(FatApp::getConfig("CONF_MIN_COD_ORDER_LIMIT")),
            'max_cod_order_limit' => CommonHelper::displayMoneyFormat(FatApp::getConfig("CONF_MAX_COD_ORDER_LIMIT")),
            'orderPaymentGatewayCharges' => $orderPaymentGatewayCharges,
            'netChargeAmount' => $netChargeAmt,
            'taxOptions' => $taxOptions,
            'prodTaxOptions' => $prodTaxOptions,
            'roundingOff' => $roundingOff,
            'totalSaving' => ($selProdTotalPrice - $originalTotalPrice) /* special price */ + $cartVolumeDiscount + ($cartDiscounts['coupon_discount_total'] ?? 0),
        );
        return $cartSummary;
    }


    public function getCartGiftFinancialSummary($langId, $order_id)
    {

        $cartTotal = 0;
        $orderPaymentGatewayCharges = 0;
        $orderNetAmount = 0;
        $cartRewardPoints = $this->getCartRewardPoint();
        $userWalletBalance = User::getUserBalance(UserAuthentication::getLoggedUserId());
        $srch = Orders::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('order_id', '=', $order_id);
        $srch->addCondition('order_payment_status', '=', 'mysql_func_' . Orders::ORDER_PAYMENT_PENDING, 'AND', true);
        $rs = $srch->getResultSet();
        $orderInfo = FatApp::getDb()->fetch($rs);
        if (!$orderInfo) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId));
        }
        $orderNetAmount = $orderInfo['order_net_amount'];
        $WalletAmountCharge = ($this->isCartUserGiftWalletSelected()) ? min($orderNetAmount, $userWalletBalance) : 0;
        $orderPaymentGatewayCharges = $orderNetAmount - $WalletAmountCharge;
        $netChargeAmt = $cartTotal;
        $cartSummary = array(
            'cartTotal' => $cartTotal,
            'cartRewardPoints' => $cartRewardPoints,
            'cartWalletSelected' => $this->isCartUserGiftWalletSelected(),
            'orderNetAmount' => $orderNetAmount,
            'WalletAmountCharge' => $WalletAmountCharge,
            'orderPaymentGatewayCharges' => $orderPaymentGatewayCharges,
            'netChargeAmount' => $netChargeAmt,
        );
        return $cartSummary;
    }


    public function getCouponDiscounts()
    {
        $couponObj = new DiscountCoupons();
        if (!$this->getCartDiscountCoupon()) {
            return false;
        }

        $orderId = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : '';
        $couponInfo = $couponObj->getValidCoupons($this->cart_user_id, $this->cart_lang_id, $this->getCartDiscountCoupon(), $orderId);
        $cartSubTotal = $this->getSubTotal();

        $couponData = array();

        if ($couponInfo) {
            $discountTotal = 0;
            $cartProducts = $this->getBasketProducts($this->cart_lang_id);

            $prodObj = new Product();

            /* binded product_ids are not in array, are in string, so converting the same to array[ */

            if (!empty($couponInfo['grouped_coupon_products'])) {
                $couponInfo['grouped_coupon_products'] = explode(",", $couponInfo['grouped_coupon_products']);
            } else {
                $couponInfo['grouped_coupon_products'] = array();
            }

            if (!empty($couponInfo['grouped_coupon_users'])) {
                $couponInfo['grouped_coupon_users'] = explode(",", $couponInfo['grouped_coupon_users']);
            } else {
                $couponInfo['grouped_coupon_users'] = array();
            }

            if (!empty($couponInfo['grouped_coupon_categories'])) {
                $couponInfo['grouped_coupon_categories'] = explode(",", $couponInfo['grouped_coupon_categories']);
                $productIdsArr = array();

                foreach ($cartProducts as $cartProduct) {
                    $cartProdCategoriesArr = $prodObj->getProductCategories($cartProduct['product_id']);
                    if ($cartProdCategoriesArr == false || empty($cartProdCategoriesArr)) {
                        continue;
                    }

                    foreach ($cartProdCategoriesArr as $cartProdCategory) {
                        if (in_array($cartProdCategory['prodcat_id'], $couponInfo['grouped_coupon_categories'])) {
                            $productIdsArr[] = $cartProduct['product_id'];
                        }
                    }
                }

                if (!empty($productIdsArr)) {
                    $couponInfo['grouped_coupon_products'] = array_merge($couponInfo['grouped_coupon_products'], $productIdsArr);
                }
            }
            /* ] */

            if (!empty($couponInfo['grouped_coupon_shops'])) {
                $couponInfo['grouped_coupon_shops'] = explode(",", $couponInfo['grouped_coupon_shops']);
                $productIdsArr = array();
                foreach ($cartProducts as $cartProduct) {
                    if (in_array($cartProduct['shop_id'], $couponInfo['grouped_coupon_shops'])) {
                        $productIdsArr[] = $cartProduct['product_id'];
                    }
                }
                if (!empty($productIdsArr)) {
                    $couponInfo['grouped_coupon_products'] = array_merge($couponInfo['grouped_coupon_products'], $productIdsArr);
                }
            }
            if (!empty($couponInfo['grouped_coupon_brands'])) {
                $couponInfo['grouped_coupon_brands'] = explode(",", $couponInfo['grouped_coupon_brands']);

                $productIdsArr = array();
                foreach ($cartProducts as $cartProduct) {
                    if (in_array($cartProduct['brand_id'], $couponInfo['grouped_coupon_brands'])) {
                        $productIdsArr[] = $cartProduct['product_id'];
                    }
                }
                if (!empty($productIdsArr)) {
                    $couponInfo['grouped_coupon_products'] = array_merge($couponInfo['grouped_coupon_products'], $productIdsArr);
                }
            }

            if ((empty($couponInfo['grouped_coupon_products']) && in_array($this->cart_user_id, $couponInfo['grouped_coupon_users'])) or empty($couponInfo['grouped_coupon_products'])) {
                $subTotal = $cartSubTotal;
            } else {
                $subTotal = 0;
                foreach ($cartProducts as $cartProduct) {
                    if ($cartProduct['is_batch']) {
                        /* if ( in_array($product['prodgroup_id'], $couponInfo['groups']) ){
                            $subTotal += $product['prodgroup_total'];
                        } */
                    } else {
                        if (in_array($cartProduct['product_id'], $couponInfo['grouped_coupon_products'])) {
                            $subTotal += $cartProduct['total'];
                        }
                    }
                }
            }

            if ($couponInfo['coupon_discount_in_percent'] == applicationConstants::FLAT) {
                $couponInfo['coupon_discount_value'] = min($couponInfo['coupon_discount_value'], $subTotal);
            }

            $cartVolumeDiscount = 0;
            foreach ($cartProducts as $cartProduct) {
                $discount = 0;
                $cartVolumeDiscount += $cartProduct['volume_discount_total'];
                if ((empty($couponInfo['grouped_coupon_products']) && in_array($this->cart_user_id, $couponInfo['grouped_coupon_users'])) || empty($couponInfo['grouped_coupon_products'])) {
                    $status = true;
                } else {
                    if ($cartProduct['is_batch']) {
                        /* if (in_array($cartProduct['prodgroup_id'], $couponInfo['groups'])) {
                            $status = true;
                        } else {
                            $status = false;
                        } */
                    } else {
                        if (in_array($cartProduct['product_id'], $couponInfo['grouped_coupon_products'])) {
                            $status = true;
                        } else {
                            $status = false;
                        }
                    }
                }

                if ($status) {
                    if ($cartProduct['is_batch']) {
                        /* if (!$couponInfo['coupon_discount_in_percent']) {
                            $discount = $couponInfo['coupon_discount_value'] * ($cartProduct['prodgroup_total'] / $subTotal);
                        }else{
                            $discount = ( $cartProduct['prodgroup_total'] / 100 ) * $couponInfo['coupon_discount_value'];
                        } */
                    } else {
                        if ($couponInfo['coupon_discount_in_percent'] == applicationConstants::FLAT) {
                            $discount = $couponInfo['coupon_discount_value'] * (($cartProduct['total'] - $cartProduct['volume_discount_total']) / $subTotal);
                        } else {
                            $discount = (($cartProduct['total'] - $cartProduct['volume_discount_total']) / 100) * $couponInfo['coupon_discount_value'];
                        }
                    }
                }
                $discountTotal += $discount;
            }

            if ($discountTotal > $couponInfo['coupon_max_discount_value'] && $couponInfo['coupon_discount_in_percent'] == applicationConstants::PERCENTAGE) {
                $discountTotal = $couponInfo['coupon_max_discount_value'];
            }

            $selProdDiscountTotal = 0;
            $discountTypeArr = DiscountCoupons::getTypeArr($this->cart_lang_id);

            /*[ Calculate discounts for each Seller Products*/
            $discountedSelProdIds = array();
            $discountedProdGroupIds = array();
            if ((empty($couponInfo['grouped_coupon_products']) && in_array($this->cart_user_id, $couponInfo['grouped_coupon_users'])) or empty($couponInfo['grouped_coupon_products'])) {
                foreach ($cartProducts as $cartProduct) {
                    if ($cartProduct['is_batch']) {
                        /* $totalSelProdDiscount = round(($discountTotal*$cartProduct['prodgroup_total'])/$subTotal,2);
                        $selProdDiscountTotal += $totalSelProdDiscount;
                        $discountedProdGroupIds[$cartProduct['prodgroup_id']] = round($totalSelProdDiscount,2); */
                    } else {
                        $balTotal = ($subTotal - $cartVolumeDiscount);
                        $balTotal = 1 > $balTotal ? 1 : $balTotal;

                        $totalSelProdDiscount = (0.001 > $discountTotal) ? 0 : round(($discountTotal * ($cartProduct['total'] - $cartProduct['volume_discount_total'])) / $balTotal, 2);

                        $selProdDiscountTotal += $totalSelProdDiscount;
                        $discountedSelProdIds[$cartProduct['selprod_id']] = round($totalSelProdDiscount, 2);
                    }
                }
            } else {
                foreach ($cartProducts as $cartProduct) {
                    if ($cartProduct['is_batch']) {
                        /* if (in_array($cartProduct['prodgroup_id'], $couponInfo['groups'])) {
                            $totalSelProdDiscount = round(($discountTotal*$cartProduct['prodgroup_total'])/$subTotal,2);
                            $selProdDiscountTotal += $totalSelProdDiscount;
                            $discountedProdGroupIds[$cartProduct['prodgroup_id']] = round($totalSelProdDiscount,2);
                        } */
                    } else {
                        if (in_array($cartProduct['product_id'], $couponInfo['grouped_coupon_products'])) {
                            $balTotal = ($subTotal - $cartVolumeDiscount);
                            $balTotal = 1 > $balTotal ? 1 : $balTotal;

                            $totalSelProdDiscount = (0.001 > $discountTotal) ? 0 : round(($discountTotal * ($cartProduct['total'] - $cartProduct['volume_discount_total'])) / $balTotal, 2);
                            $selProdDiscountTotal += $totalSelProdDiscount;
                            $discountedSelProdIds[$cartProduct['selprod_id']] = round($totalSelProdDiscount, 2);
                        }
                    }
                }
            }
            /*]*/
            $selProdDiscountTotal = $selProdDiscountTotal /*- $cartVolumeDiscount*/;
            $labelArr = array(
                'coupon_label' => $couponInfo["coupon_title"],
                'coupon_id' => $couponInfo["coupon_id"],
                'coupon_discount_in_percent' => $couponInfo["coupon_discount_in_percent"],
                'max_discount_value' => $couponInfo["coupon_max_discount_value"]
            );

            if ($couponInfo['coupon_discount_in_percent'] == applicationConstants::PERCENTAGE) {
                if ($selProdDiscountTotal > $couponInfo['coupon_max_discount_value']) {
                    $selProdDiscountTotal = $couponInfo['coupon_max_discount_value'];
                }
            } elseif ($couponInfo['coupon_discount_in_percent'] == applicationConstants::FLAT) {
                if ($selProdDiscountTotal > $couponInfo["coupon_discount_value"]) {
                    $selProdDiscountTotal = $couponInfo["coupon_discount_value"];
                }
            }

            $couponData = array(
                'coupon_discount_type' => $couponInfo["coupon_type"],
                'coupon_code' => $couponInfo["coupon_code"],
                'coupon_discount_value' => $couponInfo["coupon_discount_value"],
                'coupon_discount_total' => ($selProdDiscountTotal < 0) ? 0 : $selProdDiscountTotal,
                'coupon_info' => json_encode($labelArr),
                'discountedSelProdIds' => $discountedSelProdIds,
                'discountedProdGroupIds' => $discountedProdGroupIds,
            );
        }

        if (empty($couponData)) {
            return false;
        }
        $this->discounts = $couponData;
        return $couponData;
    }

    public function updateCartWalletOption($val)
    {
        $this->SYSTEM_ARR['shopping_cart']['Pay_from_wallet'] = $val;
        $this->updateUserCart();
        return true;
    }

    public function updateCartGiftWalletOption($val)
    {
        $this->SYSTEM_ARR['shopping_cart']['gift_Pay_from_wallet'] = $val;
        $this->updateUserCart();
        return true;
    }
    public function updateCartDiscountCoupon($val)
    {
        $this->SYSTEM_ARR['shopping_cart']['discount_coupon'] = $val;
        $this->updateUserCart();
        return true;
    }

    public function removeCartDiscountCoupon()
    {
        $couponCode = array_key_exists('discount_coupon', $this->SYSTEM_ARR['shopping_cart']) ? $this->SYSTEM_ARR['shopping_cart']['discount_coupon'] : '';
        unset($this->SYSTEM_ARR['shopping_cart']['discount_coupon']);

        /* Removing from temp hold[ */
        if ((UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged()) && $couponCode != '') {
            $loggedUserId = UserAuthentication::getLoggedUserId();

            $srch = DiscountCoupons::getSearchObject(0, false, false);
            $srch->addCondition('coupon_code', '=', $couponCode);
            $srch->setPageSize(1);
            $srch->doNotCalculateRecords();
            $srch->addMultipleFields(array('coupon_id'));
            $rs = $srch->getResultSet();
            $couponRow = FatApp::getDb()->fetch($rs);

            if ($couponRow && $loggedUserId) {
                FatApp::getDb()->deleteRecords(DiscountCoupons::DB_TBL_COUPON_HOLD, array('smt' => 'couponhold_coupon_id = ? AND couponhold_user_id = ?', 'vals' => array($couponRow['coupon_id'], $loggedUserId)));
            }
        }

        $orderId = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : '';
        if ($orderId != '') {
            FatApp::getDb()->deleteRecords(DiscountCoupons::DB_TBL_COUPON_HOLD_PENDING_ORDER, array('smt' => 'ochold_order_id = ?', 'vals' => array($orderId)));
        }

        /* ] */

        $this->updateUserCart();
        return true;
    }

    public function updateCartUseRewardPoints($val)
    {
        $this->SYSTEM_ARR['shopping_cart']['reward_points'] = $val;
        $this->updateUserCart();
        return true;
    }

    public function removeUsedRewardPoints()
    {
        if (isset($this->SYSTEM_ARR['shopping_cart']) && array_key_exists('reward_points', $this->SYSTEM_ARR['shopping_cart'])) {
            unset($this->SYSTEM_ARR['shopping_cart']['reward_points']);
            $this->updateUserCart();
        }
        return true;
    }

    public function getCartRewardPoint()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['reward_points']) ? $this->SYSTEM_ARR['shopping_cart']['reward_points'] : 0;
    }

    public function getCartDiscountCoupon()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['discount_coupon']) ? $this->SYSTEM_ARR['shopping_cart']['discount_coupon'] : '';
    }

    public function isDiscountCouponSet()
    {
        return !empty($this->SYSTEM_ARR['shopping_cart']['discount_coupon']);
    }

    public function isCartUserWalletSelected()
    {
        return (isset($this->SYSTEM_ARR['shopping_cart']['Pay_from_wallet']) && intval($this->SYSTEM_ARR['shopping_cart']['Pay_from_wallet']) == 1) ? 1 : 0;
    }

    public function isCartUserGiftWalletSelected()
    {
        return (isset($this->SYSTEM_ARR['shopping_cart']['gift_Pay_from_wallet']) && intval($this->SYSTEM_ARR['shopping_cart']['gift_Pay_from_wallet']) == 1) ? 1 : 0;
    }

    public function updateUserCart()
    {
        if (isset($this->cart_user_id)) {
            $record = new TableRecord('tbl_user_cart');
            $cart_arr = $this->SYSTEM_ARR['cart'];
            if (isset($this->SYSTEM_ARR['shopping_cart']) && is_array($this->SYSTEM_ARR['shopping_cart']) && (!empty($this->SYSTEM_ARR['shopping_cart']))) {
                $cart_arr["shopping_cart"] = $this->SYSTEM_ARR['shopping_cart'];
            }
            $cart_arr = json_encode($cart_arr);
            $record->assignValues(array("usercart_user_id" => $this->cart_user_id, "usercart_type" => CART::TYPE_PRODUCT, "usercart_details" => $cart_arr, "usercart_added_date" => date('Y-m-d H:i:s'), "usercart_last_used_date" => date('Y-m-d H:i:s'), "usercart_last_session_id" => $this->cart_id));
            if (!$record->addNew(array(), array('usercart_details' => $cart_arr, "usercart_added_date" => date('Y-m-d H:i:s'), "usercart_last_used_date" => date('Y-m-d H:i:s'), "usercart_last_session_id" => $this->cart_id, "usercart_sent_reminder" => 0))) {
                Message::addErrorMessage($record->getError());
                throw new Exception('');
            }
        }
    }

    /* to keep track of temporary hold the product stock[ */
    public function updateTempStockHold($selprod_id, $quantity = 0, $prodgroup_id = 0)
    {
        if (isset($_SESSION['offer_checkout']['selprod_id']) && $_SESSION['offer_checkout']['selprod_id'] == $selprod_id) {
            $quantity = 0;
        }

        $selprod_id = FatUtility::int($selprod_id);
        $quantity = FatUtility::int($quantity);
        $prodgroup_id = FatUtility::int($prodgroup_id);
        if (!$selprod_id) {
            return;
        }
        $db = FatApp::getDb();

        if ($quantity <= 0) {
            $db->deleteRecords('tbl_product_stock_hold', array('smt' => 'pshold_selprod_id = ? AND pshold_user_id = ? AND pshold_prodgroup_id = ?', 'vals' => array($selprod_id, $this->cart_user_id, $prodgroup_id)));
            return;
        }

        $dataArrToSave = array(
            'pshold_selprod_id' => $selprod_id,
            'pshold_user_id' => $this->cart_user_id,
            'pshold_prodgroup_id' => $prodgroup_id,
            'pshold_selprod_stock' => $quantity,
            'pshold_added_on' => date('Y-m-d H:i:s')
        );
        if (!$db->insertFromArray('tbl_product_stock_hold', $dataArrToSave, true, array(), $dataArrToSave)) {
            Message::addErrorMessage($db->getError());
            throw new Exception('');
        }

        /* delete old records[ */
        $this->deleteProductStockHold();
        /* ] */
    }
    /* ] */

    public function clear($includeAbandonedCart = false)
    {
        $advanceEcommerce = FatApp::getConfig('CONF_ANALYTICS_ADVANCE_ECOMMERCE', FatUtility::VAR_INT, 0);
        $ga4 = FatApp::getConfig('CONF_GOOGLE_ANALYTICS_4', FatUtility::VAR_INT, 0);

        $cartProducts = $this->getProducts($this->cart_lang_id);
        if (is_array($cartProducts)) {
            foreach ($cartProducts as $cartKey => $product) {
                if ($advanceEcommerce) {
                    if (0 == $ga4) {
                        $et = new EcommerceTracking(Labels::getLabel('LBL_PRODUCT_DETAIL', commonHelper::getLangId()), $this->cart_user_id);
                        $et->addProductAction(EcommerceTracking::PROD_ACTION_TYPE_REMOVE_FROM_CART);
                        $et->addProduct($product['selprod_id'], $product['selprod_title'], $product['prodcat_name'], $product['brand_name'], 0);
                        $et->sendRequest();
                    } else if (false === MOBILE_APP_API_CALL) {
                        $this->removedItems[] = $product;
                    }
                }
                $this->updateTempStockHold($product['selprod_id'], 0, 0);
                if (is_numeric($this->cart_user_id) && $this->cart_user_id > 0) {
                    if ($includeAbandonedCart == true) {
                        AbandonedCart::saveAbandonedCart($this->cart_user_id, $product['selprod_id'], $product['quantity'], AbandonedCart::ACTION_DELETED);
                    }
                }
            }
        }
        
        $this->products = array();
        $this->basketProducts = [];
        $this->SYSTEM_ARR['cart'] = array();
        $this->SYSTEM_ARR['shopping_cart'] = array();
        unset($_SESSION['shopping_cart']["order_id"]);
        unset($_SESSION['wallet_recharge_cart']["order_id"]);
        unset($_SESSION["order_id"]);
        unset($_SESSION['offer_checkout']);
    }

    public static function setCartAttributes($userId = 0, $tempUserId = 0)
    {
        $db = FatApp::getDb();

        $cart_user_id = static::getCartUserId($tempUserId);

        if (empty($tempUserId)) {
            $tempUserId = session_id();
        }

        if (!UserAuthentication::isUserLogged() && !UserAuthentication::isGuestUserLogged() && $userId > 0) {
            $cart_user_id = $userId;
        }

        /* to keep track of temporary hold the product stock[ */
        $db->updateFromArray('tbl_product_stock_hold', array('pshold_user_id' => $cart_user_id), array('smt' => 'pshold_user_id = ?', 'vals' => array($tempUserId)));
        /* ] */

        $userId = FatUtility::int($userId);
        if ($userId == 0 && $tempUserId == 0) {
            return false;
        }

        $srch = new SearchBase('tbl_user_cart');
        $srch->addCondition('usercart_user_id', '=', $tempUserId);
        $srch->addCondition('usercart_type', '=', 'mysql_func_' . CART::TYPE_PRODUCT, 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();

        if (!$row = FatApp::getDb()->fetch($rs)) {
            return false;
        }

        $cartInfo = json_decode($row["usercart_details"], true);

        $cartObj = new Cart($userId, 0, $tempUserId);

        foreach ($cartInfo as $key => $quantity) {
            if (false === $keyDecoded = base64_decode($key, true)) {
                continue;
            }
            $keyDecoded = json_decode($keyDecoded, true);

            $selprod_id = 0;
            $prodgroup_id = 0;
            if (strpos($keyDecoded, static::CART_KEY_PREFIX_PRODUCT) !== false) {
                $str = filter_var(str_replace(static::CART_KEY_PREFIX_PRODUCT, '', $keyDecoded), FILTER_SANITIZE_NUMBER_INT);
                $selprod_id = FatUtility::int($str);
            }
            if (strpos($keyDecoded, static::CART_KEY_PREFIX_BATCH) !== false) {
                $str = filter_var(str_replace(static::CART_KEY_PREFIX_BATCH, '', $keyDecoded), FILTER_SANITIZE_NUMBER_INT);
                $prodgroup_id = FatUtility::int($str);
            }

            $cartObj->add($selprod_id, $quantity, $prodgroup_id);

            $db->deleteRecords('tbl_user_cart', array('smt' => '`usercart_user_id`=? and usercart_type=?', 'vals' => array($tempUserId, CART::TYPE_PRODUCT)));
        }
        $cartObj->updateUserCart();
    }

    public function getCache($key)
    {
        require_once(CONF_INSTALLATION_PATH . 'library/phpfastcache.php');
        phpFastCache::setup("storage", "files");

        phpFastCache::setup("path", CONF_UPLOADS_PATH . "caching");

        $cache = phpFastCache();
        return $cache->get($key);
    }

    private function setCache($key, $value)
    {
        require_once(CONF_INSTALLATION_PATH . 'library/phpfastcache.php');
        phpFastCache::setup("storage", "files");
        phpFastCache::setup("path", CONF_UPLOADS_PATH . "caching");
        $cache = phpFastCache();
        return $cache->set($key, $value, 60 * 60);
    }

    public function getProductByKey($find_key)
    {
        if (!$this->hasPhysicalProduct()) {
            return false;
        }

        foreach ($this->SYSTEM_ARR['cart'] as $key => $cart) {
            if ($find_key == md5($key)) {
                return $key;
            }
        }
        return false;
    }

    public function setselectedShipping(array $selectedShippingService)
    {
        $this->selectedShippingService = $selectedShippingService; /* Selected Shipping Service */
    }

    public function getShippingRates()
    {
        $shippingOptions = $this->getShippingOptions();
        if (false == $shippingOptions) {
            return false;
        }

        $shippedByArr = array_keys($shippingOptions);
        $shippingRates = [];
        foreach ($shippedByArr as $shippedBy) {
            foreach ($shippingOptions[$shippedBy] as $level => $levelItems) {
                $rates = isset($levelItems['rates']) ? $levelItems['rates'] : [];
                if (count($rates) <= 0) {
                    continue;
                }
                if ($level != Shipping::LEVEL_PRODUCT) {
                    $name = current($rates)['code'];
                    $shippingRates[$name] =  $rates;
                } else if (isset($levelItems['products'])) {
                    foreach ($levelItems['products'] as $product) {
                        if (!array_key_exists($product['selprod_id'], $rates) || count($rates[$product['selprod_id']]) <= 0) {
                            continue;
                        }
                        $name = current($rates[$product['selprod_id']])['code'];
                        $shippingRates[$name] =  $rates[$product['selprod_id']];
                    }
                }
            }
        }
        return $shippingRates;
    }

    public function getPickupOptions($cartProducts)
    {
        $shippedByArr = [];
        $address = new Address();
        $pickupAddress = [];
        $selectedPickUpAddresses = [];
        $pickUpData = $this->getProductPickUpAddresses();
        if (empty($cartProducts)) {
            $cartProducts =  $this->getProducts($this->cart_lang_id);
        }

        foreach ($cartProducts as $product) {
            $selProdId = $product['selprod_id'];
            $pickUpBy = 0;
            $pickUpType = Address::TYPE_ADMIN_PICKUP;

            if ($product['isProductShippedBySeller']) {
                $pickUpBy = $product['shop_id'];
                $pickUpType = Address::TYPE_SHOP_PICKUP;
            }

            if ($product['is_physical_product']) {
                $shippedByArr[$pickUpBy]['products'][$selProdId] = $product;

                if (!in_array($pickUpBy, $pickupAddress)) {
                    $addresses = $address->getData($pickUpType, $pickUpBy);
                    $shippedByArr[$pickUpBy]['pickup_options'] = $addresses;
                }
                $pickupAddress[] = $pickUpBy;

                if (!in_array($pickUpBy, $selectedPickUpAddresses) && !empty($pickUpData[$product['selprod_id']])) {
                    $addressObj = new Address($pickUpData[$selProdId]['time_slot_addr_id']);
                    $pickUpAddr = $addressObj->getData($pickUpType, $pickUpBy);
                    $shippedByArr[$pickUpBy]['pickup_address'] = $pickUpAddr;
                    $shippedByArr[$pickUpBy]['pickup_address']['time_slot_id'] = $pickUpData[$selProdId]['time_slot_id'];
                    $shippedByArr[$pickUpBy]['pickup_address']['time_slot_date'] = $pickUpData[$selProdId]['time_slot_date'];
                    $shippedByArr[$pickUpBy]['pickup_address']['time_slot_from'] = $pickUpData[$selProdId]['time_slot_from_time'];
                    $shippedByArr[$pickUpBy]['pickup_address']['time_slot_to'] = $pickUpData[$selProdId]['time_slot_to_time'];
                }
                $selectedPickUpAddresses[] = $pickUpBy;
            } else {
                $shippedByArr[$pickUpBy]['digital_products'][$selProdId] = $product;
            }
        }
        return $shippedByArr;
    }

    public function getShippingOptions()
    {
        $shippedByArr = [];
        $physicalSelProdIdArr = [];
        $digitalSelProdIdArr = [];
        $productInfo = [];
        $cartProducts = $this->getBasketProducts($this->cart_lang_id);

        foreach ($cartProducts as $val) {
            if (0 < $val['is_physical_product'] && isset($this->SYSTEM_ARR['shopping_cart']['checkout_type']) && $val['selprod_fulfillment_type'] != Shipping::FULFILMENT_ALL && $val['selprod_fulfillment_type'] != $this->SYSTEM_ARR['shopping_cart']['checkout_type']) {
                continue;
            }

            $productInfo[$val['selprod_id']] = $val;
            if (0 < $val['is_physical_product']) {
                $physicalSelProdIdArr[$val['selprod_id']] = $val['selprod_id'];
            } else {
                $digitalSelProdIdArr[$val['selprod_id']] = $val['selprod_id'];
            }
        }

        if (!empty($physicalSelProdIdArr)) {
            $address = new Address($this->getCartShippingAddress(), $this->cart_lang_id);
            $shippingAddressDetail =  $address->getData(Address::TYPE_USER, $this->cart_user_id);
            $shipping = new Shipping($this->cart_lang_id);

            if (is_array($this->selectedShippingService) && 0 < count($this->selectedShippingService)) {
                $shipping->setSelectedShipping($this->selectedShippingService);
            }

            $response =  $shipping->calculateCharges($physicalSelProdIdArr, $shippingAddressDetail, $productInfo, true);
            $shippedByArr = $response['data'];
        }
        /*Include digital products */
        if (!empty($digitalSelProdIdArr)) {
            foreach ($digitalSelProdIdArr as $selProdId) {
                $shippedByArr[$productInfo[$selProdId]['shop_id']][Shipping::LEVEL_PRODUCT]['digital_products'][$selProdId] = $productInfo[$selProdId];
                $shippedByArr[$productInfo[$selProdId]['shop_id']][Shipping::LEVEL_PRODUCT]['shipping_options'][$selProdId] = [];
                $shippedByArr[$productInfo[$selProdId]['shop_id']][Shipping::LEVEL_PRODUCT]['rates'][$selProdId] = [];
            }
        }
        return $shippedByArr;
    }

    public function getSellersProductItemsPrice($cartProducts)
    {
        $sellerPrice = array();
        if (is_array($cartProducts) && count($cartProducts)) {
            foreach ($cartProducts as $selprod) {
                $shipBy = 0;
                if (!empty($selprod['psbs_user_id'])) {
                    $shipBy = $selprod['psbs_user_id'];
                }

                if (!empty($selprod['selprod_user_id']) && (!array_key_exists($selprod['selprod_user_id'], $sellerPrice) || $shipBy == 0)) {
                    $sellerPrice[$selprod['selprod_user_id']]['totalPrice'] = 0;
                }

                if ($shipBy) {
                    $sellerPrice[$selprod['selprod_user_id']]['totalPrice'] += $selprod['theprice'] * $selprod['quantity'];
                }
            }
        }
        return $sellerPrice;
    }

    public function getSelprodIdByKey($key)
    {
        $keyDecoded = json_decode(base64_decode($key), true);
        if (strpos($keyDecoded, static::CART_KEY_PREFIX_PRODUCT) !== false) {
            $selprod_id = FatUtility::int(str_replace(static::CART_KEY_PREFIX_PRODUCT, '', $keyDecoded));
            return $selprod_id;
        }
    }

    public function deleteProductStockHold()
    {
        $intervalInMinutes = FatApp::getConfig('cart_stock_hold_minutes', FatUtility::VAR_INT, 15);
        $deleteQuery = "DELETE FROM tbl_product_stock_hold WHERE pshold_added_on < DATE_SUB(NOW(), INTERVAL " . $intervalInMinutes . " MINUTE)";
        FatApp::getDb()->query($deleteQuery);
        return true;
    }

    public function getError()
    {
        return $this->error;
    }

    public function enableCache()
    {
        $this->cartCache = true;
    }

    public function disableCache()
    {
        $this->cartCache = false;
    }

    public function removePickupOnlyProducts()
    {
        $cartProducts = $this->getProducts($this->cart_lang_id, false);
        foreach ($cartProducts as $cartKey => $product) {
            if ($product['fulfillment_type'] != Shipping::FULFILMENT_PICKUP) {
                continue;
            }

            unset($this->SYSTEM_ARR['cart'][$cartKey]);
            $this->updateTempStockHold($product['selprod_id'], 0, 0);
            if (is_numeric($this->cart_user_id) && $this->cart_user_id > 0) {
                AbandonedCart::saveAbandonedCart($this->cart_user_id, $product['selprod_id'], $product['quantity'], AbandonedCart::ACTION_DELETED);
            }
        }
        $this->updateUserCart();
        return true;
    }

    public function removeShippedOnlyProducts()
    {
        $this->invalidateCheckoutType();
        $cartProducts = $this->getProducts($this->cart_lang_id, false);
        foreach ($cartProducts as $cartKey => $product) {
            if ($product['fulfillment_type'] != Shipping::FULFILMENT_SHIP) {
                continue;
            }

            unset($this->SYSTEM_ARR['cart'][$cartKey]);
            $this->updateTempStockHold($product['selprod_id'], 0, 0);
            if (is_numeric($this->cart_user_id) && $this->cart_user_id > 0) {
                AbandonedCart::saveAbandonedCart($this->cart_user_id, $product['selprod_id'], $product['quantity'], AbandonedCart::ACTION_DELETED);
            }
        }
        $this->updateUserCart();
        return true;
    }

    public function setCartCheckoutType($type)
    {
        $type = FatUtility::int($type);
        $this->SYSTEM_ARR['shopping_cart']['checkout_type'] = $type;
        $this->updateUserCart();
        return true;
    }

    public function setFulfilmentType(int $type)
    {
        $this->fulfilmentType = $type;
    }

    public function getCartCheckoutType()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['checkout_type']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['checkout_type']) : Shipping::FULFILMENT_SHIP;
    }

    public function unsetCartCheckoutType()
    {
        unset($this->SYSTEM_ARR['shopping_cart']['checkout_type']);
        $this->updateUserCart();
        return true;
    }

    public function checkCartCheckoutType()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['checkout_type']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['checkout_type']) : 0;
    }

    public function setProductPickUpAddresses($arr)
    {
        $this->SYSTEM_ARR['shopping_cart']['product_pickup_Addresses'] = $arr;
        $this->updateUserCart();
        return true;
    }

    public function getProductPickUpAddresses()
    {
        return isset($this->SYSTEM_ARR['shopping_cart']['product_pickup_Addresses']) ? $this->SYSTEM_ARR['shopping_cart']['product_pickup_Addresses'] : array();
    }

    public function removeProductPickUpAddresses()
    {
        unset($this->SYSTEM_ARR['shopping_cart']['product_pickup_Addresses']);
        $this->updateUserCart();
        return true;
    }

    public function isProductPickUpAddrSet()
    {
        foreach ($this->getProducts($this->cart_lang_id) as $product) {
            if (!isset($this->SYSTEM_ARR['shopping_cart']['product_pickup_Addresses'][$product['selprod_id']]) && $product['product_type'] == Product::PRODUCT_TYPE_PHYSICAL) {
                return false;
            }
        }
        return true;
    }

    public function validateCheckoutType()
    {
        $this->valdateCheckoutType = true;
    }

    public function invalidateCheckoutType()
    {
        $this->valdateCheckoutType = false;
    }

    public function excludeTax()
    {
        $this->includeTax = false;
    }

    public function resetProducts()
    {
        $this->products = [];
    }

    public function getQtyBySelProdId($selprod_id)
    {
        $key = static::CART_KEY_PREFIX_PRODUCT . $selprod_id;
        $key = base64_encode(json_encode($key));
        return $this->SYSTEM_ARR['cart'][$key] ?? 0;
    }

    public function excludeOfferCheckoutItems()
    {
        /* Excluding offer checkout items from cart listing. */
        if (isset($_SESSION['offer_checkout'])) {
            $offerSelprodId = $_SESSION['offer_checkout']['selprod_id'] ?? 0;
            if (0 < $offerSelprodId) {
                $key = static::CART_KEY_PREFIX_PRODUCT . $offerSelprodId;
                $key = base64_encode(json_encode($key));
                unset($this->SYSTEM_ARR['cart'][$key]);
            }
        }
    }
}
