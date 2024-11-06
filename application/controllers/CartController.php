<?php

class CartController extends MyAppController
{
    public function __construct($action)
    {
        parent::__construct($action);

        /* For API Use */
        $this->set('cartPage', true);
        /* For API Use */
    }

    public function index()
    {
        $cartObj = new Cart();
        if (!isset($_SESSION['offer_checkout']) && FatApp::getConfig('CONF_HIDE_PRICES', FatUtility::VAR_INT, 0)) {
            $cartObj->clear();
            $cartObj->updateUserCart();
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_CHECKOUT_WITH_ACCEPTED_OFFER_ONLY.'), redirect: true);
            CommonHelper::redirectUserReferer();
        }

        $loggedUserId = UserAuthentication::getLoggedUserId(true);
        if (0 < $loggedUserId) {
            $user_is_buyer = User::getAttributesById($loggedUserId, 'user_is_buyer');
            if (!$user_is_buyer) {
                $cartObj->clear(true);
                $cartObj->updateUserCart();
                $errMsg = Labels::getLabel('ERR_PLEASE_LOGIN_WITH_BUYER_ACCOUNT_TO_ADD_PRODUCTS_TO_CART', $this->siteLangId);
                LibHelper::exitWithError($errMsg, false, true);
                FatApp::redirectUser(UrlHelper::generateUrl());
            }
        }

        $cartObj->unsetCartCheckoutType();
        $cartObj->invalidateCheckoutType();
        $cartObj->removeProductShippingMethod();
        $cartObj->removeProductPickUpAddresses();
        $removeCartType = !isset($_SESSION['offer_checkout']) ? SellerProduct::CART_TYPE_RFQ_ONLY : -1;
        $productsArr = $cartObj->getProducts($this->siteLangId, removeCartType: $removeCartType);
        $fulfillmentProdArr = [
            Shipping::FULFILMENT_SHIP => [],
            Shipping::FULFILMENT_PICKUP => [],
        ];
        foreach ($productsArr as $product) {
            switch ($product['fulfillment_type']) {
                case Shipping::FULFILMENT_SHIP:
                    $fulfillmentProdArr[Shipping::FULFILMENT_SHIP][] = $product['selprod_id'];
                    break;
                case Shipping::FULFILMENT_PICKUP:
                    $fulfillmentProdArr[Shipping::FULFILMENT_PICKUP][] = $product['selprod_id'];
                    break;
                default:
                    $fulfillmentProdArr[Shipping::FULFILMENT_SHIP][] = $product['selprod_id'];
                    $fulfillmentProdArr[Shipping::FULFILMENT_PICKUP][] = $product['selprod_id'];
                    break;
            }
        }

        $this->set('shipProductsCount', count($fulfillmentProdArr[Shipping::FULFILMENT_SHIP]));
        $this->set('pickUpProductsCount', count($fulfillmentProdArr[Shipping::FULFILMENT_PICKUP]));
        $this->set('total', $cartObj->countProducts());
        $this->set('hasPhysicalProduct', $cartObj->hasPhysicalProduct());
        $this->set('cartItemsCount', $cartObj->countProducts());
        $this->_template->render();
    }

    public function listing($fulfilmentType = Shipping::FULFILMENT_SHIP)
    {
        $products['groups'] = array();
        $products['single'] = array();
        $loggedUserId = UserAuthentication::getLoggedUserId(true);
        $cartObj = new Cart($loggedUserId, $this->siteLangId, $this->app_user['temp_user_id'], Cart::PAGE_TYPE_CART);
        if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0)) {
            $cartObj->excludeTax();
        }
        $cartObj->unsetCartCheckoutType();
        $cartObj->invalidateCheckoutType();
        if (MOBILE_APP_API_CALL) {
            $cartObj->setFulfilmentType($fulfilmentType);
        }

        $productsArr = $cartObj->getProducts($this->siteLangId, false);
        $prodGroupIds = array();
        $fulfillmentProdArr = [
            Shipping::FULFILMENT_SHIP => [],
            Shipping::FULFILMENT_PICKUP => [],
        ];

        $saveForLaterProducts = UserWishList::savedForLaterItems($loggedUserId, $this->siteLangId);

        $availableProductsArr = [
            'notAvailable' => [],
            'available' => [],
            'saveForLater' => [],
        ];

        if (count($saveForLaterProducts)) {
            foreach ($saveForLaterProducts as &$arr) {
                $arr['options'] = SellerProduct::getSellerProductOptions($arr['selprod_id'], true, $this->siteLangId);

                if (true === MOBILE_APP_API_CALL) {
                    $arr['discount'] = ($arr['selprod_price'] > $arr['theprice']) ? CommonHelper::showProductDiscountedText($arr, $this->siteLangId) : '';
                    $arr['productUrl'] = UrlHelper::generateFullUrl('Products', 'View', array($arr['selprod_id']));
                    $arr['imageUrl'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($arr['product_id'], ImageDimension::VIEW_THUMB, $arr['selprod_id'], 0, $this->siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
                    $arr['theprice'] = CommonHelper::displayMoneyFormat($arr['theprice']);
                    $arr['selprod_price'] = CommonHelper::displayMoneyFormat($arr['selprod_price']);
                    $availableProductsArr['saveForLater'][] = $arr;
                }
            }
        }
        /* ] */

        if (0 < count($productsArr) || true === MOBILE_APP_API_CALL || 0 < count($saveForLaterProducts)) {
            foreach ($productsArr as &$product) {
                switch ($product['fulfillment_type']) {
                    case Shipping::FULFILMENT_SHIP:
                        $fulfillmentProdArr[Shipping::FULFILMENT_SHIP][] = $product['selprod_id'];
                        break;
                    case Shipping::FULFILMENT_PICKUP:
                        $fulfillmentProdArr[Shipping::FULFILMENT_PICKUP][] = $product['selprod_id'];
                        break;
                    default:
                        $fulfillmentProdArr[Shipping::FULFILMENT_SHIP][] = $product['selprod_id'];
                        $fulfillmentProdArr[Shipping::FULFILMENT_PICKUP][] = $product['selprod_id'];
                        break;
                }

                if (true === MOBILE_APP_API_CALL) {
                    $product['productUrl'] = UrlHelper::generateFullUrl('Products', 'View', array($product['selprod_id']));
                    $product['shopUrl'] = UrlHelper::generateFullUrl('Shops', 'View', array($product['shop_id']));
                    $product['imageUrl'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $this->siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
                    $product['discount'] = ($product['selprod_price'] > $product['theprice']) ? CommonHelper::showProductDiscountedText($product, $this->siteLangId) : '';
                    $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice']);
                    $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price']);

                    $type = '';

                    /* Cart Page tab selection. */
                    if ($fulfilmentType == Shipping::FULFILMENT_SHIP) {
                        $type = $product['fulfillment_type'] != Shipping::FULFILMENT_PICKUP ? 'available' : 'notAvailable';
                    } else {
                        $type = $product['fulfillment_type'] != Shipping::FULFILMENT_SHIP ? 'available' : 'notAvailable';
                    }

                    $availableProductsArr[$type][] = $product;
                }
            }

            if (true === MOBILE_APP_API_CALL) {
                $cartObj->removeProductShippingMethod();
                $cartObj->removeUsedRewardPoints();

                $billingAddressDetail = array();
                $billingAddressId = $cartObj->getCartBillingAddress();
                if ($billingAddressId > 0) {
                    $address = new Address($billingAddressId);
                    $billingAddressDetail = $address->getData(Address::TYPE_USER, $loggedUserId);
                }

                $shippingddressDetail = array();
                $shippingAddressId = $cartObj->getCartShippingAddress();
                if ($shippingAddressId > 0) {
                    $address = new Address($shippingAddressId);
                    $shippingddressDetail = $address->getData(Address::TYPE_USER, $loggedUserId);
                }
                $cartObj->resetProducts();
                $cartObj->validateCheckoutType();
                $cartObj->setCartCheckoutType($fulfilmentType);

                $this->set('cartSelectedBillingAddress', $billingAddressDetail);
                $this->set('cartSelectedShippingAddress', $shippingddressDetail);
                $this->set('isShippingSameAsBilling', $cartObj->getShippingAddressSameAsBilling());
                $this->set('selectedBillingAddressId', $billingAddressId);
                $this->set('selectedShippingAddressId', $shippingAddressId);

                $this->set('cartProductsCount', count($productsArr));
                $this->set('shipProductsCount', count($fulfillmentProdArr[Shipping::FULFILMENT_SHIP]));
                $this->set('pickUpProductsCount', count($fulfillmentProdArr[Shipping::FULFILMENT_PICKUP]));
                $this->set('availableProductsArr', $availableProductsArr);
            }

            $cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
            $this->set('cartSummary', $cartSummary);

            $fulFillmentArr = Shipping::getFulFillmentArr($this->siteLangId);
            if (!array_key_exists($fulfilmentType, $fulFillmentArr)) {
                $fulfilmentType = Shipping::FULFILMENT_SHIP;
            }

            $this->set('saveForLaterProducts', $saveForLaterProducts);
            $this->set('products', $productsArr);
            $this->set('prodGroupIds', $prodGroupIds);
            $this->set('fulfilmentType', $fulfilmentType);
            $this->set('fulfillmentProdArr', $fulfillmentProdArr);
            $this->set('hasPhysicalProduct', $cartObj->hasPhysicalProduct());

            $templateName = 'cart/ship-listing.php';
            if ($fulfilmentType == Shipping::FULFILMENT_PICKUP) {
                $templateName = 'cart/pickup-listing.php';
            }
        } else {
            $srch = EmptyCartItems::getSearchObject($this->siteLangId);
            $srch->doNotCalculateRecords();
            $srch->addMultipleFields(array('COALESCE(emptycartitem_title, emptycartitem_identifier) as emptycartitem_title', 'emptycartitem_url', 'emptycartitem_url_is_newtab'));
            $rs = $srch->getResultSet();
            $EmptyCartItems = FatApp::getDb()->fetchAll($rs);
            $this->set('EmptyCartItems', $EmptyCartItems);
            $templateName = 'cart/empty-cart.php';
        }

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render(true, true, $templateName);
        }

        $json['html'] = $this->_template->render(false, false, $templateName, true, false);
        $json['cartProductsCount'] = count($productsArr);
        $json['hasPhysicalProduct'] = $cartObj->hasPhysicalProduct();
        $json['shipProductsCount'] = count($fulfillmentProdArr[Shipping::FULFILMENT_SHIP]);
        $json['pickUpProductsCount'] = count($fulfillmentProdArr[Shipping::FULFILMENT_PICKUP]);
        FatUtility::dieJsonSuccess($json);
    }

    public function add()
    {
        $post = FatApp::getPostedData();
        if (empty($post)) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            LibHelper::exitWithError($message, true, true);
            FatApp::redirectUser(UrlHelper::generateUrl());
        }
        $loggedUserId = UserAuthentication::getLoggedUserId(true);
        if (UserAuthentication::isUserLogged()) {
            $user_is_buyer = User::getAttributesById($loggedUserId, 'user_is_buyer');
            if (!$user_is_buyer) {
                $errMsg = Labels::getLabel('ERR_PLEASE_LOGIN_WITH_BUYER_ACCOUNT_TO_ADD_PRODUCTS_TO_CART', $this->siteLangId);
                LibHelper::exitWithError($errMsg, true, true);
                FatApp::redirectUser(UrlHelper::generateUrl());
            }
        }

        if (isset($_SESSION['offer_checkout'])) {
            $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id']);
            $cartObj->clear(true);
            $cartObj->updateUserCart();
            unset($_SESSION['offer_checkout']);
        }

        $selprod_id = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $quantity = FatApp::getPostedData('quantity', FatUtility::VAR_INT, 1);

        if (true === MOBILE_APP_API_CALL) {
            $productsToAdd = isset($post['addons']) ? json_decode($post['addons'], true) : array();
        } else {
            $productsToAdd = isset($post['addons']) ? $post['addons'] : array();
        }
        $productsToAdd[$selprod_id] = $quantity;

        $this->addProductToCart($productsToAdd, $selprod_id);

        $db = FatApp::getDb();
        $wishlistId = FatApp::getPostedData('uwlist_id', FatUtility::VAR_INT, 0);
        $rowAction = FatApp::getPostedData('rowAction', FatUtility::VAR_INT, 0); // 1 = Remove From Wishlist / 0 = Add To Wishlist
        if (0 < $wishlistId) {
            $srch = UserWishList::getSearchObject($loggedUserId);
            $srch->addMultipleFields(array('uwlist_id'));
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $srch->addCondition('uwlist_id', '=', 'mysql_func_' . $wishlistId, 'AND', true);
            $rs = $srch->getResultSet();
            $row = $db->fetch($rs);
            if (!is_array($row) || empty($row)) {
                $msg = Labels::getLabel('ERR_INVALID_WISHLIST_ID', $this->siteLangId);
                LibHelper::exitWithError($msg, true, true);
                FatApp::redirectUser(UrlHelper::generateUrl());
            }

            if (0 < $rowAction) {
                if (!$db->deleteRecords(UserWishList::DB_TBL_LIST_PRODUCTS, array('smt' => 'uwlp_uwlist_id = ? AND uwlp_selprod_id = ?', 'vals' => array($wishlistId, $selprod_id)))) {
                    LibHelper::exitWithError($db->getError(), true, true);
                    FatApp::redirectUser(UrlHelper::generateUrl());
                }
            } else {
                $wListObj = new UserWishList();
                if (!$wListObj->addUpdateListProducts($wishlistId, $selprod_id)) {
                    LibHelper::exitWithError($wListObj->getError(), true, true);
                    FatApp::redirectUser(UrlHelper::generateUrl());
                }
            }
        }

        $ufpId  = FatApp::getPostedData('ufp_id', FatUtility::VAR_INT, 0);
        if (0 < $ufpId) {
            if (0 < $rowAction) {
                if (!$db->deleteRecords(Product::DB_TBL_PRODUCT_FAVORITE, array('smt' => 'ufp_user_id = ? AND ufp_id = ?', 'vals' => array($loggedUserId, $ufpId)))) {
                    LibHelper::exitWithError($db->getError(), true, true);
                    FatApp::redirectUser(UrlHelper::generateUrl());
                }
            } else {
                $productObj = new product();
                if (!$productObj->addUpdateUserFavoriteProduct($loggedUserId, $selprod_id)) {
                    LibHelper::exitWithError($productObj->getError(), true, true);
                    FatApp::redirectUser(UrlHelper::generateUrl());
                }
            }
        }

        LibHelper::sendAsyncRequest('POST', UrlHelper::generateFullUrl('Cart', 'loadRates'), ['sessionId' => LibHelper::getSessionId()]);

        if (true === MOBILE_APP_API_CALL) {
            $msg = $this->get('msg');
            $cartObj = new Cart();
            $this->set('cartItemsCount', $cartObj->countProducts());
            $this->set('msg', !empty($msg) ? $msg : Labels::getLabel('MSG_ADDED_SUCCESSFULLY', $this->siteLangId));
            $this->_template->render();
        }

        $this->set('success_msg', CommonHelper::renderHtml(Message::getHtml()));
        $this->_template->render(false, false, 'json-success.php', false, false);
    }

    public function loadRates()
    {
        $sessionId = FatApp::getPostedData('sessionId', FatUtility::VAR_STRING, '');
        if (empty($sessionId)) {
            return;
        }
        session_destroy();
        session_id($sessionId);
        session_start();

        $userId = UserAuthentication::getLoggedUserId(true);
        $addrData = Address::getDefaultByRecordId(Address::TYPE_USER, $userId, $this->siteLangId);
        if (empty($addrData)) {
            return;
        }

        $cartObj = new Cart($userId, $this->siteLangId, $this->app_user['temp_user_id']);
        $cartObj->setCartShippingAddress($addrData['addr_id']);
        $cartObj->getShippingOptions();
        return;
    }

    public function addSelectedToCart()
    {
        if (0 < FatApp::getConfig('CONF_HIDE_PRICES', FatUtility::VAR_INT, 0)) {
            $message = Labels::getLabel('ERR_ITEM`S_ARE_NOT_AVAILALE_FOR_THE_CART', $this->siteLangId);
            LibHelper::exitWithError($message, true);
        }
        $selprod_id_arr = FatApp::getPostedData('selprod_id');
        $selprod_id_arr = !empty($selprod_id_arr) ? array_filter($selprod_id_arr) : array();
        if (!empty($selprod_id_arr) && is_array($selprod_id_arr)) {
            $successCount = 0;
            $hasError = false;
            foreach ($selprod_id_arr as $selprod_id) {
                $sellerProductRow = SellerProduct::getAttributesById($selprod_id, ['selprod_stock', 'selprod_min_order_qty', 'selprod_user_id', 'selprod_cart_type'], false);
                if (empty($sellerProductRow)) {
                    $hasError = true;
                    continue;
                }

                $shopRfqEnabled = $shopRfqEnabledArr[$sellerProductRow['selprod_user_id']] ?? null;
                if (null == $shopRfqEnabled) {
                    $shopRfqEnabled = Shop::getAttributesByUserId($sellerProductRow['selprod_user_id'], 'shop_rfq_enabled');
                    $shopRfqEnabledArr[$sellerProductRow['selprod_user_id']] = $shopRfqEnabled;
                }

                if (RequestForQuote::isCartTypeRfqOnly($shopRfqEnabled, $sellerProductRow['selprod_cart_type'])) {
                    $rfqOnly = $hasError = true;
                    continue;
                }

                $minQty = $sellerProductRow['selprod_min_order_qty'];

                $tempHoldStock = Product::tempHoldStockCount($selprod_id);
                $availableStock = $sellerProductRow['selprod_stock'] - $tempHoldStock;
                $isOutOfMinOrderQty = ((int)($minQty > $availableStock));
                if (0 < $isOutOfMinOrderQty) {
                    $hasError = true;
                    continue;
                }

                $productsToAdd = [$selprod_id => $minQty];
                $this->addProductToCart($productsToAdd, $selprod_id, false);
                $successCount++;
            }

            if (true === $hasError) {
                if ($rfqOnly) {
                    if (0 < $successCount) {
                        $msg = Labels::getLabel('ERR_SOME_OF_THE_ITEMS_ARE_RFQ_ONLY_SO_CANNOT_BE_ADDED_TO_CART');
                    } else {
                        $msg = Labels::getLabel('ERR_RFQ_ONLY_ITEMS_CANNOT_BE_ADDED_TO_CART');
                    }
                } else {
                    $msg = Labels::getLabel('ERR_INVALID_PRODUCTS/_PRODUCT`S_MIN_ORDER_QUANTITY_IS_HIGHER_THAN_STOCK_LIMIT._CANNOT_BE_ADDED');
                    if (0 < $successCount) {
                        $msg = Labels::getLabel('ERR_SOME_OF_THE_PRODUCTS_ARE_INVALID/_PRODUCT`S_MIN_ORDER_QUANTITY_IS_HIGHER_THAN_STOCK_LIMIT._CANNOT_BE_ADDED');
                    }
                }
                $error = [
                    'successCount' => $successCount,
                    'msg' => $msg
                ];
                LibHelper::exitWithError($error, true);
            }

            if (0 < $successCount) {
                $msg = Labels::getLabel('MSG_{ITEMS}_ITEMS_ADDED_TO_CART', $this->siteLangId);
                $msg = CommonHelper::replaceStringData($msg, ['{ITEMS}' => $successCount]);
                $this->set('msg', $msg);
            }

            LibHelper::sendAsyncRequest('POST', UrlHelper::generateFullUrl('Cart', 'loadRates'), ['sessionId' => LibHelper::getSessionId()]);

            if (true === MOBILE_APP_API_CALL) {
                $this->_template->render();
            }
            $this->_template->render(false, false, 'json-success.php', false, false);
        } else {
            $message = Labels::getLabel('ERR_INVALID_REQUEST_PARAMETERS', $this->siteLangId);
            LibHelper::exitWithError($message, true);
        }
    }

    private function addProductToCart($productsToAdd, $selprod_id, $logMessage = true)
    {
        $productAdd = true;
        $selprod_id = FatUtility::int($selprod_id);
        if ($selprod_id < 1) {
            $message = Labels::getLabel('ERR_INVALID_PRODUCT', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            $productErr['product'] = $message;
        }

        $advanceEcommerce = FatApp::getConfig('CONF_ANALYTICS_ADVANCE_ECOMMERCE', FatUtility::VAR_INT, 0);
        $ga4 = FatApp::getConfig('CONF_GOOGLE_ANALYTICS_4', FatUtility::VAR_INT, 0);
        $loggedUserId = UserAuthentication::getLoggedUserId(true);

        $cartItems = [];
        $shopRfqEnabledArr = [];
        foreach ($productsToAdd as $productId => $quantity) {
            if ($quantity == 0) {
                $quantity = 1;
            }
            $selprodProducData = SellerProduct::getAttributesById($productId, ['selprod_product_id', 'selprod_user_id', 'selprod_cart_type']);
            $selprodProductId = $selprodProducData['selprod_product_id'];
            $cartType = $selprodProducData['selprod_cart_type'];
            $shopRfqEnabled = $shopRfqEnabledArr[$selprodProducData['selprod_user_id']] ?? null;
            if (null == $shopRfqEnabled) {
                $shopRfqEnabled = Shop::getAttributesByUserId($selprodProducData['selprod_user_id'], 'shop_rfq_enabled');
                $shopRfqEnabledArr[$selprodProducData['selprod_user_id']] = $shopRfqEnabled;
            }

            if (RequestForQuote::isCartTypeRfqOnly($shopRfqEnabled, $cartType) && 1 > FatApp::getPostedData('isAddToQuote', FatUtility::VAR_INT, 0)) {
                $message = Labels::getLabel('ERR_SOME_OF_THE_ITEMS_ARE_RFQ_ONLY_SO_CANNOT_BE_ADDED_TO_CART', $this->siteLangId);
                if ($productId != $selprod_id) {
                    $productErr['addon'][$productId] = $message;
                } else {
                    $productErr['product'] = $message;
                }
                continue;
            }

            if ($productId <= 0) {
                $productAdd = false;
                $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                }
                if ($productId != $selprod_id) {
                    $productErr['addon'][$productId] = $message;
                } else {
                    $productErr['product'] = $message;
                }
            }
            $srch = new ProductSearch($this->siteLangId);
            $srch->setDefinedCriteria(0, 0, ['product_id' => $selprodProductId]);
            $srch->joinBrands();
            $srch->joinSellerSubscription();
            $srch->addSubscriptionValidCondition();
            $srch->joinProductToCategory();
            $srch->addCondition('pricetbl.selprod_id', '=', 'mysql_func_' . $productId, 'AND', true);
            $srch->addCondition('selprod_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
            $srch->addMultipleFields(array('selprod_id', 'selprod_code', 'selprod_min_order_qty', 'selprod_cart_type', 'selprod_hide_price', 'selprod_stock', 'COALESCE(product_name, product_identifier) as product_name', 'prodcat_name', 'brand_name', 'selprod_title', 'selprod_price', 'COALESCE(splprice_price, selprod_price) as theprice', 'shop_rfq_enabled'));
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $db = FatApp::getDb();
            $sellerProductRow = $db->fetch($rs);
            if (!$sellerProductRow || $sellerProductRow['selprod_id'] != $productId) {
                $productAdd = false;
                $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                }
                if ($productId != $selprod_id) {
                    $productErr['addon'][$productId] = $message;
                } else {
                    $productErr['product'] = $message;
                }
            }
            $productId = $sellerProductRow['selprod_id'];
            /* cannot add, out of stock products in cart[ */
            if ($sellerProductRow['selprod_stock'] <= 0) {
                $productAdd = false;
                $message = Labels::getLabel('MSG_OUT_OF_STOCK_PRODUCTS_CANNOT_BE_ADDED_TO_CART_{PRODUCT-NAME}', $this->siteLangId);
                $message = CommonHelper::replaceStringData($message, ['{PRODUCT-NAME}' => FatUtility::decodeHtmlEntities($sellerProductRow['product_name'])]);
                /* if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                } */
                if ($productId != $selprod_id) {
                    $productErr['addon'][$productId] = $message;
                } else {
                    $productErr['product'] = $message;
                }
            }
            /* ] */

            $tempHoldStock = Product::tempHoldStockCount($sellerProductRow['selprod_id']);
            $availableStock = $sellerProductRow['selprod_stock'] - $tempHoldStock;
            $isOutOfMinOrderQty = ((int)($sellerProductRow['selprod_min_order_qty'] > $availableStock));
            if (0 < $isOutOfMinOrderQty) {
                $productAdd = false;
                $message = Labels::getLabel('MSG_MIN_ORDER_QUANTITY_OF_{PRODUCT-NAME}_IS_HIGHER_THAN_AVAILABLE_STOCK._CANNOT_BE_ADDED_TO_CART', $this->siteLangId);
                $message = CommonHelper::replaceStringData($message, ['{PRODUCT-NAME}' => FatUtility::decodeHtmlEntities($sellerProductRow['product_name'])]);
                /* if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                } */
                if ($productId != $selprod_id) {
                    $productErr['addon'][$productId] = $message;
                } else {
                    $productErr['product'] = $message;
                }
            }

            /* minimum quantity check[ */
            $minimum_quantity = ($sellerProductRow['selprod_min_order_qty']) ? $sellerProductRow['selprod_min_order_qty'] : 1;
            if ($quantity < $minimum_quantity) {
                $productAdd = false;
                $str = Labels::getLabel('MSG_PLEASE_ADD_MINIMUM_{MINIMUMQUANTITY}_FOR_{PRODUCT-NAME}', $this->siteLangId);
                $str = CommonHelper::replaceStringData($str, ["{MINIMUMQUANTITY}" => $minimum_quantity, '{PRODUCT-NAME}' => strip_tags($sellerProductRow['product_name'])]);
                /* if (true === MOBILE_APP_API_CALL) {
                    LibHelper::dieJsonError($str);
                } */
                if ($productId != $selprod_id) {
                    $productErr['addon'][$productId] = $str;
                } else {
                    $productErr['product'] = $str;
                }
            }
            /* ] */
            

            /* cannot add quantity more than stock of the product[ */
            $selprod_stock = $sellerProductRow['selprod_stock'] - Product::tempHoldStockCount($productId);
            if ($quantity > $selprod_stock) {
                $productAdd = false;
                $message = Labels::getLabel('MSG_REQUESTED_QUANTITY_MORE_THAN_STOCK_AVAILABLE_{STOCK}_FOR_{PRODUCT-NAME}._SO_CANNOT_BE_ADDED.', $this->siteLangId);
                $message = CommonHelper::replaceStringData($message, ['{STOCK}' => $selprod_stock, '{PRODUCT-NAME}' => strip_tags($sellerProductRow['product_name'])]);
                /* if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                } */
                if ($productId != $selprod_id) {
                    $productErr['addon'][$productId] = $message;
                } else {
                    $productErr['product'] = $message;
                }
            }
            /* ] */

            $cartObj = new Cart($loggedUserId, $this->siteLangId, $this->app_user['temp_user_id']);
            
            if ($productAdd) {
                $cObj = clone $cartObj;
                $returnUserId = (true === MOBILE_APP_API_CALL) ? true : false;
                $cartUserId = $cObj->add($productId, $quantity, 0, $returnUserId);
                if ($advanceEcommerce) {
                    if (0 == $ga4) {
                        $et = new EcommerceTracking(Labels::getLabel('MSG_PRODUCT_DETAIL', $this->siteLangId), UserAuthentication::getLoggedUserId(true));
                        $et->addProductAction(EcommerceTracking::PROD_ACTION_TYPE_ADD_TO_CART);
                        $et->addProduct($sellerProductRow['selprod_id'], $sellerProductRow['selprod_title'], $sellerProductRow['prodcat_name'], $sellerProductRow['brand_name'], $quantity, $sellerProductRow['selprod_price']);
                        $et->sendRequest();
                    } else if (false === MOBILE_APP_API_CALL) {
                        $sellerProductRow['addedQty'] = $quantity;
                        $cartItems[] = $sellerProductRow;
                    }
                }

                if (true === MOBILE_APP_API_CALL) {
                    $this->set('tempUserId', $cartUserId);
                }
            }
            $productAdd = true;
        }

        if ($advanceEcommerce && $ga4 && false === MOBILE_APP_API_CALL) {
            $this->set('cartItems', $cartItems);
        }

        if (isset($productErr)) {
            $addons = $productErr['addon'] ?? [];
            unset($productErr['addon']);
            $lineSeparator = MOBILE_APP_API_CALL ? '\n' : '<br>';
            $msg = $productErr['product'] ?? '';
            $msg .= !empty($msg) ? $lineSeparator : '';
            $msg = !empty($addons) ? $msg . implode($lineSeparator, $addons) : $msg;
            $this->set('msg', $msg);
        } else {
            $strProduct = '<a href="' . UrlHelper::generateUrl('Products', 'view', array($selprod_id)) . '">' . strip_tags(html_entity_decode($sellerProductRow['product_name'], ENT_QUOTES, 'UTF-8')) . '</a>';
            $strCart = '<a href="' . UrlHelper::generateUrl('Cart') . '">' . Labels::getLabel('MSG_SHOPPING_CART', $this->siteLangId) . '</a>';
            if ($logMessage) {
                Message::addMessage(sprintf(Labels::getLabel('MSG_SUCCESS_CART_ADD', $this->siteLangId), $strProduct, $strCart));
            }

            $this->set('msg', Labels::getLabel("MSG_ADDED_TO_CART", $this->siteLangId));
        }

        $this->set('total', $cartObj->countProducts());
    }

    public function remove()
    {
        $post = FatApp::getPostedData();
        if (empty($post)) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatApp::redirectUser(UrlHelper::generateUrl());
        }

        if (!isset($post['key'])) {
            $message = Labels::getLabel('MSG_PRODUCT_KEY_REQUIRED', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id']);
        $key = $post['key'];

        if ('all' == $key) {
            $cartObj->clear(true);
            $cartObj->updateUserCart();
        } else {
            if (true === MOBILE_APP_API_CALL) {
                $key = md5($key);
            }
            if (!$cartObj->remove($key)) {
                if (true === MOBILE_APP_API_CALL) {
                    LibHelper::dieJsonError($cartObj->getError());
                }
                Message::addMessage($cartObj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $cartObj->removeUsedRewardPoints();
            $cartObj->removeProductShippingMethod();
            $cartObj->removeCartDiscountCoupon();
        }
        $total = $cartObj->countProducts();

        LibHelper::sendAsyncRequest('POST', UrlHelper::generateFullUrl('Cart', 'loadRates'), ['sessionId' => LibHelper::getSessionId()]);

        $this->set('msg', Labels::getLabel("MSG_ITEM_REMOVED_FROM_CART", $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $fulfilmentType = FatApp::getPostedData('fulfilmentType', FatUtility::VAR_INT, Shipping::FULFILMENT_SHIP);
            $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id'], Cart::PAGE_TYPE_CART);
            $cartObj->setFulfilmentType($fulfilmentType);
            $cartObj->setCartCheckoutType($fulfilmentType);
            $productsArr = $cartObj->getProducts($this->siteLangId);
            $cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
            $this->set('products', $productsArr);
            $this->set('cartSummary', $cartSummary);
            $this->_template->render();
        }
        $this->set('cartItems', $cartObj->getRemovedItems());
        $this->set('total', $total);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeGroup()
    {
        $post = FatApp::getPostedData();

        if (empty($post)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl());
        }

        $prodgroup_id = FatApp::getPostedData('prodgroup_id', FatUtility::VAR_INT, 0);
        if ($prodgroup_id <= 0) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $cartObj = new Cart();
        if (!$cartObj->removeGroup($prodgroup_id)) {
            Message::addMessage($cartObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        $this->set('msg', Labels::getLabel("MSG_PRODUCT_COMBO_REMOVED_SUCCESSFULLY", $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function update()
    {
        $post = FatApp::getPostedData();
        if (empty($post)) {
            $message = Labels::getLabel('LBL_Invalid_Request', $this->siteLangId);
            LibHelper::exitWithError($message, true, true);
            FatApp::redirectUser(UrlHelper::generateUrl());
        }
        if (empty($post['key'])) {
            $message = Labels::getLabel('ERR_INVALID_PRODUCT', $this->siteLangId);
            LibHelper::exitWithError($message);
        }
        $key = $post['key'];
        if (true === MOBILE_APP_API_CALL) {
            $key = md5($key);
        }
        $quantity = isset($post['quantity']) ? FatUtility::int($post['quantity']) : 1;
        $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id'], Cart::PAGE_TYPE_CART);
        if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0)) {
            $cartObj->excludeTax();
        }
        if (!$cartObj->update($key, $quantity)) {
            LibHelper::exitWithError($cartObj->getError());
        }
        $cartObj->removeUsedRewardPoints();
        $cartObj->removeProductShippingMethod();

        if (!empty($cartObj->getWarning())) {
            LibHelper::exitWithError($cartObj->getWarning());
        } else {
            $this->set('msg', Labels::getLabel("MSG_CART_UPDATED_SUCCESSFULLY", $this->siteLangId));
        }
        if (true === MOBILE_APP_API_CALL) {
            $fulfilmentType = FatApp::getPostedData('fulfilmentType', FatUtility::VAR_INT, Shipping::FULFILMENT_SHIP);
            $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id'], Cart::PAGE_TYPE_CART);
            if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0)) {
                $cartObj->excludeTax();
            }
            $cartObj->setFulfilmentType($fulfilmentType);
            $cartObj->setCartCheckoutType($fulfilmentType);
            $productsArr = $cartObj->getProducts($this->siteLangId);
            $cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
            $this->set('products', $productsArr);
            $this->set('cartSummary', $cartSummary);
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateGroup()
    {
        $post = FatApp::getPostedData();
        if (empty($post)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl());
        }
        $prodgroup_id = FatApp::getPostedData('prodgroup_id', FatUtility::VAR_INT, 0);
        $quantity = FatApp::getPostedData('quantity', FatUtility::VAR_INT, 1);
        if ($prodgroup_id <= 0) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $cartObj = new Cart();
        if (!$cartObj->updateGroup($prodgroup_id, $quantity)) {
            Message::addMessage($cartObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        if (!empty($cartObj->getWarning())) {

            $this->set('msg', $cartObj->getWarning());
        } else {
            $this->set('msg', Labels::getLabel("MSG_CART_UPDATED_SUCCESSFULLY", $this->siteLangId));
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function applyPromoCode()
    {
        UserAuthentication::checkLogin();

        $post = FatApp::getPostedData();
        $loggedUserId = UserAuthentication::getLoggedUserId();
        if (empty($post['coupon_code'])) {
            FatUtility::dieWithError(Labels::getLabel('ERR_PLEASE_ENTER_VALID_COUPON_CODE', $this->siteLangId));
        }

        $couponCode = $post['coupon_code'];

        $orderId = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : '';
        $couponInfo = DiscountCoupons::getValidCoupons($loggedUserId, $this->siteLangId, $couponCode, $orderId);
        if ($couponInfo == false) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_COUPON_CODE', $this->siteLangId));
        }

        $cartObj = new Cart();
        if (!$cartObj->updateCartDiscountCoupon($couponInfo['coupon_code'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_ACTION_TRYING_PERFORM_NOT_VALID', $this->siteLangId));
        }

        $holdCouponData = array(
            'couponhold_coupon_id' => $couponInfo['coupon_id'],
            'couponhold_user_id' => UserAuthentication::getLoggedUserId(),
            'couponhold_added_on' => date('Y-m-d H:i:s'),
        );

        if (!FatApp::getDb()->insertFromArray(DiscountCoupons::DB_TBL_COUPON_HOLD, $holdCouponData, true, array(), $holdCouponData)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_ACTION_TRYING_PERFORM_NOT_VALID', $this->siteLangId));
        }
        $cartObj->removeUsedRewardPoints();
        if (true === MOBILE_APP_API_CALL) {
            $fulfilmentType = FatApp::getPostedData('fulfilmentType', FatUtility::VAR_INT, Shipping::FULFILMENT_SHIP);
            $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id'], Cart::PAGE_TYPE_CART);
            $cartObj->setFulfilmentType($fulfilmentType);
            $cartObj->setCartCheckoutType($fulfilmentType);
            $cartObj->getProducts($this->siteLangId);
            $shipmentAvailableItemsCount = $cartObj->getShipmentItemsCount();
            $cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
            $this->set('productsCount', $shipmentAvailableItemsCount);
            $this->set('cartSummary', $cartSummary);
            $this->_template->render();
        }
        $this->set('msg', Labels::getLabel("MSG_CART_DISCOUNT_COUPON_APPLIED", $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removePromoCode()
    {
        $cartObj = new Cart();
        if (!$cartObj->removeCartDiscountCoupon()) {
            $message = Labels::getLabel('ERR_ACTION_TRYING_PERFORM_NOT_VALID', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }
        $cartObj->removeUsedRewardPoints();
        if (true === MOBILE_APP_API_CALL) {
            $fulfilmentType = FatApp::getPostedData('fulfilmentType', FatUtility::VAR_INT, Shipping::FULFILMENT_SHIP);
            $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id'], Cart::PAGE_TYPE_CART);
            $cartObj->setFulfilmentType($fulfilmentType);
            $cartObj->setCartCheckoutType($fulfilmentType);
            $cartObj->getProducts($this->siteLangId);
            $shipmentAvailableItemsCount = $cartObj->getShipmentItemsCount();
            $cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
            $this->set('productsCount', $shipmentAvailableItemsCount);
            $this->set('cartSummary', $cartSummary);
            $this->_template->render();
        }
        $this->set('msg', Labels::getLabel("MSG_CART_DISCOUNT_COUPON_REMOVED", $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getCartSummary()
    {
        $cartObj = new Cart();
        if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0)) {
            $cartObj->excludeTax();
        }
        $cartObj->invalidateCheckoutType();
        $productsArr = $cartObj->getProducts($this->siteLangId);
        $cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('products', $productsArr);
        $this->set('cartSummary', $cartSummary);
        $this->set('totalCartItems', $cartObj->countProducts());
        $this->set('showHeaderButton', true);
        $saveForLaterProducts = [];
        if (UserAuthentication::isUserLogged()) {
            $saveForLaterProducts = UserWishList::savedForLaterItems(UserAuthentication::getLoggedUserId(), $this->siteLangId);
        }
        $this->set('saveForLaterProducts', $saveForLaterProducts);

        $buttonHtml = $this->_template->render(false, false, '_partial/cart-summary.php', true);
        $this->set('showHeaderButton', false);
        $offCanvasHtml = $this->_template->render(false, false, '_partial/cart-summary.php', true);
        $jsonData = [
            'buttonHtml' => $buttonHtml,
            'offCanvasHtml' => $offCanvasHtml,
            'onlyRfqItemsLeft' => ($cartObj->countProducts() == $cartObj->countRfqOnlyProducts()),
            'itemsCount' => $cartObj->countProducts()
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function removePickupOnlyProducts()
    {
        $cart = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id']);
        if (!$cart->removePickupOnlyProducts()) {
            LibHelper::exitWithError($cart->getError(), true);
        }

        $this->set('msg', Labels::getLabel("MSG_PICKUP_ONLY_ITEMS_REMOVED_FROM_CART", $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->set('data', ['cartItemsCount' => $cart->countProducts()]);
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeShippedOnlyProducts()
    {
        $cart = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id']);
        if (!$cart->removeShippedOnlyProducts()) {
            LibHelper::exitWithError($cart->getError(), true);
        }

        $this->set('msg', Labels::getLabel("MSG_SHIPPED_ONLY_ITEMS_REMOVED_FROM_CART", $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->set('data', ['cartItemsCount' => $cart->countProducts()]);
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function setCartCheckoutType()
    {
        $loggedUserId = UserAuthentication::getLoggedUserId(true);
        $cart = new Cart($loggedUserId, $this->siteLangId, $this->app_user['temp_user_id']);
        if (!$cart->hasPhysicalProduct()) {
            $type = Shipping::FULFILMENT_SHIP;
        } else {
            $type = FatApp::getPostedData('type', FatUtility::VAR_INT, 0);
        }
        $cart = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id']);
        $cart->setCartCheckoutType($type);
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }


    private function getPromoCouponsForm($langId)
    {
        $langId = FatUtility::int($langId);
        $frm = new Form('frmPromoCoupons');
        $frm->addTextBox(Labels::getLabel('FRM_COUPON_CODE', $langId), 'coupon_code', '', array('placeholder' => Labels::getLabel('FRM_ENTER_YOUR_CODE', $langId)));

        $frm->addHtml('', 'btn_submit', HtmlHelper::addButtonHtml(Labels::getLabel('BTN_APPLY', $langId), 'submit', 'btn_submit', 'btn-apply'));
        return $frm;
    }

    public function getCartFinancialSummary($fulfilmentType = 0)
    {
        $fulfilmentType = FatUtility::int($fulfilmentType);
        $cart = new Cart();
        if (0 < $fulfilmentType) {
            $cart->setFulfilmentType($fulfilmentType);
            $cart->setCartCheckoutType($fulfilmentType);
        }
        if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0)) {
            $cart->excludeTax();
        }

        $this->set('PromoCouponsFrm', $this->getPromoCouponsForm($this->siteLangId));

        $cartSummary = $cart->getCartFinancialSummary($this->siteLangId);
        $this->set('cartSummary', $cartSummary);

        $couponsList = UserAuthentication::isUserLogged() ? DiscountCoupons::getValidCoupons(UserAuthentication::getLoggedUserId(true), $this->siteLangId) : [];
        $this->set('couponsList', $couponsList);
        $this->_template->render(false, false, 'cart/_partial/cartSummary.php');
    }

    public function clear()
    {
        $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id']);
        $cartObj->clear(true);
        $cartObj->updateUserCart();
        $this->set('cartItems', $cartObj->getRemovedItems());
        $this->_template->render(false, false, 'json-success.php');
    }
}
