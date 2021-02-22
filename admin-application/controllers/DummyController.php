<?php

class DummyController extends AdminBaseController
{
    public function index()
    {
       /*  $langId = 1;
        $type = 1;
        $srch = Labels::getSearchObject($langId, ['LEFT(label_key, 3) as keyfilename']);
        $srch->addCondition('label_type', '=', $type);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('keyfilename');
        $rs = $srch->getResultSet();
        echo $srch->getQuery(); exit; */



        $blogPostCategoryObj = new BlogPostCategory();
        echo "d".$blogPostCategoryObj->getParentTreeStructure(9, 0, 'test');
        die;
         

        $orderObj = new Orders();
        $orderDetail = $orderObj->getOrderById('O1605086396', 1);
        CommonHelper::printArray($orderDetail, true); exit;

        $countryId = '223';
        $stateId = '2998';
        $langId = 1;

        $srch = ShippingProfileZone::getSearchObject();
        $srch->joinTable(ShippingZone::DB_SHIP_LOC_TBL, 'INNER JOIN', 'spzone.shipprozone_shipzone_id = sloc.shiploc_shipzone_id and sloc.shiploc_country_id = ' . $countryId, 'sloc');
        // $srch->joinTable(ShippingZone::DB_SHIP_LOC_TBL, 'LEFT JOIN', 'spzone.shipprozone_shipzone_id = sloc.shiploc_shipzone_id and sloc.shiploc_shipzone_id != sloc_temp.shiploc_shipzone_id and sloc_temp.shiploc_country_id = -1', 'sloc_temp');
        $srch->joinTable(Countries::DB_TBL, 'LEFT OUTER JOIN', 'sc.country_id = sloc.shiploc_country_id', 'sc');
        //$srch->addDirectCondition("(sloc_temp.shiploc_country_id = '-1' or (sloc.shiploc_country_id = '" . $countryId . "' and (sloc.shiploc_state_id = '-1' or sloc.shiploc_state_id = '" . $stateId . "')) )");

        echo $srch->getQuery();
        exit;


        $srch = ShippingZone::getZoneLocationSearchObject($langId);
        // $srch->joinTable(ShippingProfileZone::DB_TBL, 'INNER JOIN', 'spz.shipprozone_shipzone_id = sloc.shiploc_shipzone_id', 'spz');
        $srch->addDirectCondition("(sloc.shiploc_country_id = '-1' or (sloc.shiploc_country_id = '" . $countryId . "' and (sloc.shiploc_state_id = '-1' or sloc.shiploc_state_id = '" . $stateId . "')) )");
        $srch->addFld('spz.*');
        // $srch->addFld('CASE WHEN country_id IS NULL THEN 0 ELSE 1 END');
        $srch->addCondition('spz.shipprozone_shipprofile_id', '=', 4);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        //echo $srch->getQuery();

        $obj = clone $srch;
        //$obj->joinTable('(' . $srch->getQuery() . ')', 'INNER JOIN', 'tmp.shipprozone_shipprofile_id = spz.shipprozone_shipprofile_id and sc.country_id > 0', 'tmp');
        $obj->joinTable('(' . $srch->getQuery() . ')', 'INNER JOIN', 'tmp.shipprozone_shipprofile_id = spz.shipprozone_shipprofile_id and sc.country_id > 0', 'tmp');
        $obj->joinTable('(' . $srch->getQuery() . ')', 'INNER JOIN', 'tmp1.shipprozone_shipprofile_id = spz.shipprozone_shipprofile_id and sc.country_id > 0', 'tmp1');
        echo $obj->getQuery();
        /* $obj = clone $srch;
        $obj->addOrder('country_id', 'dsc');
        $obj->setPageSize(1);
        $obj->addCondition('') */

        /*  $obj = clone $srch;
        $obj->addMultipleFields(array('tmp.*'));
        $obj->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'tmp.shipprozone_shipprofile_id = spz.shipprozone_shipprofile_id and (sloc.shiploc_country_id = null or (sloc.shiploc_country_id = tmp.shiploc_country_id))', 'tmp');
        $obj->addGroupBy('spz.shipprozone_shipprofile_id');
        $obj->addOrder('spz.shipprozone_shipprofile_id'); */
        //$obj->addDirectCondition('sloc.shiploc_shipzone_id is null');
        //echo $obj->getQuery();
    }

    public function test123()
    {
        $criteria = array('max_price' => true);
        $srch = new ProductSearch();
        $srch->setDefinedCriteria(1, 0, $criteria, true, false);
        $srch->joinProductToCategory();
        $srch->joinSellerSubscription(0, false, true);
        $srch->addSubscriptionValidCondition();
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addMultipleFields(array('product_id', 'selprod_id', 'theprice', 'maxprice', 'IFNULL(splprice_id, 0) as splprice_id'));
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addGroupBy('product_id');
        if (!empty($shop) && array_key_exists('shop_id', $shop)) {
            $srch->addCondition('shop_id', '=', $shop['shop_id']);
        }

        if (0 < $productId) {
            $srch->addCondition('product_id', '=', $productId);
        }

        $tmpQry = $srch->getQuery();

        $tmpQry = $srch->getQuery();

        echo $qry = "INSERT INTO " . static::DB_PRODUCT_MIN_PRICE . " (pmp_product_id, pmp_selprod_id, pmp_min_price, pmp_splprice_id) SELECT * FROM (" . $tmpQry . ") AS t ON DUPLICATE KEY UPDATE pmp_selprod_id = t.selprod_id, pmp_min_price = t.theprice, pmp_splprice_id = t.splprice_id";

        echo "<br>";
        //FatApp::getDb()->query($qry);
        echo $query = "DELETE m FROM " . static::DB_PRODUCT_MIN_PRICE . " m LEFT OUTER JOIN (" . $tmpQry . ") ON pmp_product_id = selprod_product_id WHERE m.pmp_product_id IS NULL";

        die('dsdsdsdsdsd');

        $langId = 1;
        $spreviewId = 1;
        $schObj = new SelProdReviewSearch($langId);
        $schObj->joinUser();
        $schObj->joinProducts($langId);
        $schObj->joinSellerProducts($langId);
        $schObj->addCondition('spreview_id', '=', $spreviewId);
        $schObj->addCondition('spreview_status', '!=', SelProdReview::STATUS_PENDING);
        $schObj->addMultipleFields(array('spreview_selprod_id', 'spreview_status', 'product_name', 'selprod_title', 'user_name', 'credential_email',));
        $spreviewData = FatApp::getDb()->fetch($schObj->getResultSet());
        $productUrl = UrlHelper::generateFullUrl('Products', 'View', array($spreviewData["spreview_selprod_id"]), CONF_WEBROOT_FRONT_URL);
        echo $prodTitleAnchor = "<a href='" . $productUrl . "'>" . $spreviewData['selprod_title'] . "</a>";
        CommonHelper::printArray($prodTitleAnchor);
        die;
    }

    public function query()
    {
        $query = PaymentMethods::getSearchObject();
        echo $query->getQuery();
    }

    public function buyerEmail()
    {
        $this->_template->render(true, true);
    }
    
    public function dataMigration()
    {
        $dataMigration = new DataMigration();
        $dataMigration->sync();
    }   
    
    public function testCreateOrder(){
        
        $order_id = false;
        $userId = 2497;
        $orderData['order_id'] = $order_id;
        $orderData['order_user_id'] = $userId; // customer.id
        $orderData['order_payment_status'] = Orders::ORDER_PAYMENT_PENDING;
        $orderData['order_date_added'] = date('Y-m-d H:i:s'); //created_at
        
        /* addresses[ */
        $userAddresses[0] = array(
            'oua_order_id' => $order_id,
            'oua_type' => Orders::BILLING_ADDRESS_TYPE,
            'oua_name' => 'Shannon', //billing_address.first_name
            'oua_address1' => '586 Forbes Road',//billing_address.address1
            'oua_address2' => '',//billing_address.address2
            'oua_city' => 'Winnipeg',//billing_address.city
            'oua_state' => 'Manitoba',//billing_address.province
            'oua_country' => "Canada",
            'oua_country_code' => "CA",
            'oua_country_code_alpha3' => "",
            'oua_state_code' => "MB",
            'oua_phone' =>"+1 431 336 1424",
            'oua_zip' => "R2N 4B1",
        );

        if (!empty($shippingAddressArr) && $fulfillmentType == Shipping::FULFILMENT_SHIP) {
            $userAddresses[1] = array(
                'oua_order_id' => $order_id,
                'oua_type' => Orders::SHIPPING_ADDRESS_TYPE,
                'oua_name' => 'Shannon', //shipping_address.first_name
                'oua_address1' => '586 Forbes Road',//shipping_address.address1
                'oua_address2' => '',//shipping_address.address2
                'oua_city' => 'Winnipeg',//shipping_address.city
                'oua_state' => 'Manitoba',//shipping_address.province
                'oua_country' => "Canada",
                'oua_country_code' => "CA",
                'oua_country_code_alpha3' => "",
                'oua_state_code' => "MB",
                'oua_phone' =>"+1 431 336 1424",
                'oua_zip' => "R2N 4B1",
            );
        }
        
        $orderData['userAddresses'] = $userAddresses;
        
     
        $orderData['extra'] = array(
            'oextra_order_id' => $order_id,
            'order_ip_address' => "209.142.96.232" //client_details.browser_ip
        );
        
        //$orderData['order_language_id'] = $languageRow['language_id'];
        //$orderData['order_language_code'] = $languageRow['language_code'];
        
        $orderData['order_currency_id'] = 1;
        $orderData['order_currency_code'] = 'USD'; //currency
        $orderData['order_currency_value'] = 1;  //currency
        
        //cartDiscounts
        
        //if(total_discounts > 0)
        
        // need to check again
//        $orderData['order_discount_coupon_code'] = "";
//        $orderData['order_discount_type'] = DiscountCoupons::TYPE_DISCOUNT;
//        $orderData['order_discount_value'] = 0;
//        $orderData['order_discount_total'] = 0;
//        $orderData['order_discount_info'] = "";
        
//        $orderData['order_reward_point_used'] = $cartSummary["cartRewardPoints"];
//        $orderData['order_reward_point_value'] = CommonHelper::convertRewardPointToCurrency($cartSummary["cartRewardPoints"]);
        
        $orderData['order_tax_charged'] =  1.44;//total_tax;
        $orderData['order_site_commission'] = 0;
        $orderData['order_volume_discount_total'] = 0; 
        
        $orderData['order_net_amount'] = 58.44; //total_price
        $orderData['order_is_wallet_selected'] = 0;
        $orderData['order_wallet_amount_charge'] = 0;
        $orderData['order_type'] = Orders::ORDER_PRODUCT;
        
//        $orderData['order_referrer_user_id'] = 0;
//        $orderData['order_referrer_reward_points'] = 0;
//        $orderData['order_referral_reward_points'] = 0;
//        $orderData['order_cart_data'] = '';
       
        $orderData['orderLangData'] = []; // no use only using in  newOrderBuyerAdmin email
        
        
        $productTaxChargesData[1] = array(
            'opchargelog_type' => OrderProduct::CHARGE_TYPE_TAX,
            'opchargelog_identifier' => 'GST',
            'opchargelog_value' => 0.60, //rate
            'opchargelog_is_percent' => 1,
            'opchargelog_percentvalue' => 0.05,
        );        
        $productTaxChargesData[1]['langData'][1] = array(
            'opchargeloglang_lang_id' => 1,
            'opchargelog_name' => 'GST'
        );
        
        $productTaxChargesData[2] = array(
            'opchargelog_type' => OrderProduct::CHARGE_TYPE_TAX,
            'opchargelog_identifier' => 'RST',
            'opchargelog_value' => 0.84, //rate
            'opchargelog_is_percent' => 1,
            'opchargelog_percentvalue' => 0.07,
        );        
        $productTaxChargesData[2]['langData'][1] = array(
            'opchargeloglang_lang_id' => 1,
            'opchargelog_name' => 'RST'
        );
        
        $productShippingLangData[1] = array(
            'opshipping_title' => "winnipeg delivery",
            'opshipping_duration' => '',
            'opshipping_duration_name' =>   'winnipeg delivery-' . 0,
            'opshippinglang_lang_id' => 1
        );
        
        $label = Labels::getLabel('LBL_Tax', 1);
        $op_product_tax_options["GST"]['name'] = "GST";
        $op_product_tax_options["GST"]['value'] = 0.60;
        $op_product_tax_options["GST"]['percentageValue'] = 0.05;
        $op_product_tax_options["GST"]['inPercentage'] = 1;
        
        $op_product_tax_options["RST"]['name'] = "RST";
        $op_product_tax_options["RST"]['value'] = 0.84;
        $op_product_tax_options["RST"]['percentageValue'] = 0.07;
        $op_product_tax_options["RST"]['inPercentage'] = 1;
        
        
        $productsLangData[1] = array(
            'oplang_lang_id' => 1,
            'op_product_name' => "Hello Sunshine Plant Pot", //need to check
            'op_selprod_title' => "Hello Sunshine Plant Pot",
            'op_selprod_options' => "Tiramisu / Milk chocolate / Pistachio",
            'op_brand_name' => !empty($langSpecificProductInfo['brand_name']) ? $langSpecificProductInfo['brand_name'] : '',
            'op_shop_name' => $langSpecificProductInfo['shop_name'],
            'op_shipping_duration_name' => "",
            'op_shipping_durations' => "",
            'op_products_dimension_unit_name' => "", // no dimensions
            'op_product_weight_unit_name' => "grams",
            'op_product_tax_options' => json_encode($op_product_tax_options),
        );
        
        
                $orderData['products'][34674379587628] = array(
                    'op_selprod_id' => 290,
                    'op_is_batch' => 0,
                    'op_selprod_user_id' => $productInfo['selprod_user_id'],
                    'op_selprod_code' => $productInfo['selprod_code'],
                    'op_qty' => $cartProduct['quantity'],
                    'op_unit_price' => $cartProduct['theprice'],
                    'op_unit_cost' => $cartProduct['selprod_cost'],
                    'op_selprod_sku' => $productInfo['selprod_sku'],
                    'op_selprod_condition' => $productInfo['selprod_condition'],
                    'op_product_model' => $productInfo['product_model'],
                    'op_product_type' => $productInfo['product_type'],
                    'op_product_length' => $productInfo['product_length'],
                    'op_product_width' => $productInfo['product_width'],
                    'op_product_height' => $productInfo['product_height'],
                    'op_product_dimension_unit' => $productInfo['product_dimension_unit'],
                    'op_product_weight' => $productInfo['product_weight'],
                    'op_product_weight_unit' => $productInfo['product_weight_unit'],
                    'op_shop_id' => $productInfo['shop_id'],
                    'op_shop_owner_username' => $productInfo['shop_owner_username'],
                    'op_shop_owner_name' => $productInfo['shop_onwer_name'],
                    'op_shop_owner_email' => $productInfo['shop_owner_email'],
                    'op_shop_owner_phone' => isset($productInfo['shop_owner_phone']) && !empty($productInfo['shop_owner_phone']) ? $productInfo['shop_owner_phone'] : '',
                    'op_selprod_max_download_times' => ($productInfo['selprod_max_download_times'] != '-1') ? $cartProduct['quantity'] * $productInfo['selprod_max_download_times'] : $productInfo['selprod_max_download_times'],
                    'op_selprod_download_validity_in_days' => $productInfo['selprod_download_validity_in_days'],
                    'opshipping_rate_id' => $cartProduct['opshipping_rate_id'],           
                    'op_commission_charged' => $cartProduct['commission'],
                    'op_commission_percentage' => $cartProduct['commission_percentage'],
                    'op_affiliate_commission_percentage' => $cartProduct['affiliate_commission_percentage'],
                    'op_affiliate_commission_charged' => $cartProduct['affiliate_commission'],
                    'op_status_id' => FatApp::getConfig("CONF_DEFAULT_ORDER_STATUS"),           
                    'productsLangData' => $productsLangData,
                    'productShippingData' => $productShippingData,
                    'productPickUpData' => $productPickUpData,
                    'productPickupAddress' => $productPickupAddress,
                    'productShippingLangData' => $productShippingLangData,
                    'productChargesLogData' => $productTaxChargesData,
                    'op_actual_shipping_charges' => $cartProduct['shipping_cost'],
                    'op_tax_code' => $cartProduct['taxCode'],
                    'productSpecifics' => [
                        'op_selprod_return_age' => $productInfo['return_age'],
                        'op_selprod_cancellation_age' => $productInfo['cancellation_age'],
                        'op_product_warranty' => $productInfo['product_warranty']
                    ],
                    'op_rounding_off' => $cartProduct['rounding_off'],
                );

                $order_affiliate_user_id = isset($cartProduct['affiliate_user_id']) ? $cartProduct['affiliate_user_id'] : '';
                $order_affiliate_total_commission += isset($cartProduct['affiliate_commission']) ? $cartProduct['affiliate_commission'] : '';

                $discount = 0;
                if (!empty($cartSummary["cartDiscounts"]["discountedSelProdIds"])) {
                    if (array_key_exists($productInfo['selprod_id'], $cartSummary["cartDiscounts"]["discountedSelProdIds"])) {
                        $discount = $cartSummary["cartDiscounts"]["discountedSelProdIds"][$productInfo['selprod_id']];
                    }
                }

                $shippingCost = $cartProduct['shipping_cost'];
                $rewardPoints = 0;
                $rewardPoints = $orderData['order_reward_point_value'];
                $usedRewardPoint = 0;
                if ($rewardPoints > 0) {
                    $selProdAmount = ($cartProduct['quantity'] * $cartProduct['theprice']) + $shippingCost + $cartProduct['tax'] - $discount - $cartProduct['volume_discount_total'];
                    $usedRewardPoint = round((($rewardPoints * $selProdAmount) / ($orderData['order_net_amount'] + $rewardPoints)), 2);
                }

                $orderData['prodCharges'][CART::CART_KEY_PREFIX_PRODUCT . $productInfo['selprod_id']] = array(
                    OrderProduct::CHARGE_TYPE_SHIPPING => array(
                        'amount' => $shippingCost
                    ),
                    OrderProduct::CHARGE_TYPE_TAX => array(
                        'amount' => $cartProduct['tax']
                    ),
                    OrderProduct::CHARGE_TYPE_DISCOUNT => array(
                        'amount' => -$discount /*[Should be negative value]*/
                    ),
                    OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT => array(
                        'amount' => -$usedRewardPoint
                    ),
                    /* OrderProduct::CHARGE_TYPE_BATCH_DISCOUNT => array(
                'amount' => -$cartProduct['batch_discount_single_product'] */
                    OrderProduct::CHARGE_TYPE_VOLUME_DISCOUNT => array(
                        'amount' => -$cartProduct['volume_discount_total']
                    ),

        );
        $totalRoundingOff += $cartProduct['rounding_off'];
     
        
        
    }

}
