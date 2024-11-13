<?php

use Curl\Curl;

class Shopify extends DataMigrationBase
{

    public const KEY_NAME = __CLASS__;

    public $requiredKeys;

    private const API_VERSION = '2021-01';

    private $nextLink;
    private $prevLink;
    public $langId;

    public const MULTIVENDOR_API_URL = 'https://mvmapi.webkul.com';
    public const MULTIVENDOR_API_VERSION = 'v2';

    /**
     * init
     *
     * @return void
     */
    public function __construct(int $langId, int $userId = 0)
    {

        $this->langId = $langId;
        $this->userId = $userId;
        if (1 > $this->langId) {
            $this->langId = CommonHelper::getLangId();
        }
    }

    public function init()
    {
        if ($this->vendorType === DataMigration::SINGLE_VENDOR && 1 > $this->userId) {
            $this->error = 'User id is not set';
            return false;
        }
        $this->requiredKeys = ['shop_url', 'password', 'multivendor_access_token'];
        if ($this->vendorType === DataMigration::SINGLE_VENDOR) {
            $this->requiredKeys = ['shop_url', 'password'];
        }

        return $this->validateSettings();
    }

    public function getUsers()
    {
        $paginationSavedString = $this->getPaginationStringName(DataMigration::TYPE_USER);

        $paginationParam = $this->getData($paginationSavedString);
        if ($this->isSyncCompleted($paginationParam)) {
            return [];
        }

        $paginationParam = $paginationParam === null ? ['limit' => 150] : $paginationParam;

        $users = $this->fetchCustomers($paginationParam);
        $mappedUsers = [];

        foreach ($users as $key => $user) {
            $mappedUser = array(
                'user_name' => $user->first_name . " " . $user->last_name,
                'user_phone' => $user->phone,
                'credential_email' => $user->email,
                'user_preferred_dashboard' => User::USER_BUYER_DASHBOARD,
                'user_registered_initially_for' => User::USER_TYPE_BUYER,
                'user_verify' => 1,
                'user_active' => 1,
                'user_is_buyer' => 1,
                'user_is_supplier' => 0,
                'user_is_advertiser' => 0,
                'credential_username' => '',
                'id' => $user->id /* shopify customer id */
            );
            $mappedAddress = [];

            foreach ($user->addresses as $address) {
                $mappedAddress[] = array(
                    'addr_title' => $address->name,
                    'addr_name' => $address->name,
                    'addr_address1' => $address->address1 ?? '',
                    'addr_address2' => $address->address2 ?? '',
                    'addr_city' => $address->city ?? '',
                    'addr_zip' => $address->zip ?? '',
                    'addr_phone' => $address->phone ?? '',
                    'addr_is_default' => $user->default_address->id == $address->id ? 1 : 0,
                    'country_code' => $address->country_code ?? '',
                    'country_name' => $address->country_name ?? '',
                    'state_code' => $address->province_code ?? '',
                    'state_name' => $address->province ?? '',
                );
            }
            $mappedUsers[] = $mappedUser + array('addresses' => $mappedAddress);
        }

        return $mappedUsers;
    }

    public function getSellers()
    {
        $paginationSavedString = $this->getPaginationStringName(DataMigration::TYPE_SELLER);
        $paginationParam = $this->getData($paginationSavedString);
        if ($this->isSyncCompleted($paginationParam)) {
            return [];
        }

        $paginationParam = $paginationParam === null ? ['page' => 1, 'limit' => 50, 'sort_by' => 'date_add', 'sort_order' => 'asc'] : $paginationParam;

        $sellers = $this->fetchSellers($paginationParam);
        if (1 > count($sellers)) {
            $this->nextLink = NULL;
        }

        $mappedSellers = [];

        foreach ($sellers as $key => $seller) {
            $mappedSeller = array(
                'user_name' => $seller->full_name,
                'user_phone' => '',
                'credential_email' => $seller->email,
                'user_preferred_dashboard' => User::USER_SELLER_DASHBOARD,
                'user_registered_initially_for' => User::USER_TYPE_SELLER,
                'user_verify' => 1,
                'user_active' => 1,
                'user_is_buyer' => 1,
                'user_is_supplier' => 1,
                'user_is_advertiser' => 1,
                'credential_username' => '',
                'profile_photo' => $seller->store_logo,
                'id' => $seller->id, /* shopify multivendor customer id */
            );

            $shop = array(
                'shop_identifier' => $seller->sp_store_name,
                'shop_name' => $seller->sp_store_name,
                'urlrewrite_custom' => $seller->store_name_handle,
                'shop_contact_person' => $seller->contact ?? '',
                'shop_phone' => '',
                'shop_city' => $seller->city ?? '',
                'shop_country_code' => '',
                'shop_country_name' => '',
                'shop_state_code' => '',
                'shop_state_name' => '',
                'shop_postalcode' => $seller->zipcode ?? '',
                'shop_active' => 1,
                'shop_cod_min_wallet_balance' => 0,
                'shop_fulfillment_type' => Shipping::FULFILMENT_ALL,
                'shop_return_age' => 0,
                'shop_cancellation_age' => 0,
                'shop_seller_info' => $seller->description ?? '',
                'shop_description' => $seller->short_desc ?? '',
                'shop_payment_policy' => $seller->policy ?? '',
                'shop_banner' => $seller->store_banner,
                'shop_logo' => $seller->shop_logo,
                'shop_supplier_display_status' => 1
            );

            if (!empty($seller->id_country)) {
                $shop['shop_country_code'] = $seller->id_country->iso_code;
                $shop['shop_country_name'] = $seller->id_country->name;
            }

            if (!empty($seller->id_state)) {
                $shop['shop_state_code'] = $seller->id_state->iso_code;
                $shop['shop_state_name'] = $seller->id_state->name;
            }

            $mappedSellers[] = $mappedSeller + array('shop' => $shop);
        }

        return $mappedSellers;
    }

    public function getProducts()
    {

        $paginationSavedString = $this->getPaginationStringName(DataMigration::TYPE_PRODUCT);
        $paginationParam = $this->getData($paginationSavedString);

        if ($this->isSyncCompleted($paginationParam)) {
            return [];
        }

        if ($this->vendorType == DataMigration::SINGLE_VENDOR) {
            $paginationParam = $paginationParam === null ? ['limit' => 30] : $paginationParam;
            $products = $this->fetchSingleVendorProducts($paginationParam);
            return $this->mappedProducts($products);
        }

        $paginationParam = $paginationParam === null ? ['page' => 1, 'limit' => 30] : $paginationParam;
        $products = $this->fetchMultiVendorProducts($paginationParam);
        return $this->mappedProducts($products);
    }

    public function getOrders()
    {
        $paginationSavedString = $this->getPaginationStringName(DataMigration::TYPE_ORDER);
        $paginationParam = $this->getData($paginationSavedString);

        if ($this->isSyncCompleted($paginationParam)) {
            return [];
        }
        $paginationParam = $paginationParam === null ? ['limit' => 100, 'status' => 'any'] : $paginationParam;
        $orders = $this->fetchOrders($paginationParam);
        $mappedOrders = [];

        foreach ($orders as $order) {

            $discountValue = 0;
            $discountCouponCode = "";
            if (0 < $order->total_discounts && count($order->discount_codes)) {
                foreach ($order->discount_applications as $disApp) {
                    $discountValue += $disApp->value;
                    $discountCouponCode .= $disApp->code . ", ";
                }
            }

            if (!isset($order->customer)) {
                continue;
            }

            $mappedOrder = [
                'id' => $order->id,
                'created_at' => $order->created_at,
                'buyer_id' => $order->customer->id,
                'currency_code' => $order->currency,
                'total_price' => $order->total_price,
                'subtotal_price' => $order->subtotal_price,
                'total_weight' => $order->total_weight,
                'total_tax' => $order->total_tax,
                'currency' => $order->currency, // total_price_usd  need to check
                'total_tax' => $order->total_tax,
                'payment_status' => in_array($order->financial_status, ['paid', 'partially_refunded', 'refunded']) ? 1 : 0, /// need to update  or confirmed
                'discount_total' => $order->total_discounts,
                'discount_value' => $discountValue,
                'discount_coupon_code' => $discountCouponCode
                //shiping charges needd to check
            ];

            $billingAddress = [];
            if (!empty($order->billing_address)) {
                $billingAddress = array(
                    "name" => $order->billing_address->name,
                    "address1" => $order->billing_address->address1,
                    "address2" => $order->billing_address->address2 ?? '',
                    "phone" => $order->billing_address->phone ?? '',
                    "city" => $order->billing_address->city ?? '',
                    "zip" => $order->billing_address->zip ?? '',
                    "state" => $order->billing_address->province ?? '',
                    "country" => $order->billing_address->country ?? '',
                    "country_code" => $order->billing_address->country_code ?? '',
                    "state_code" => $order->billing_address->province_code ?? '',
                    "latitude" => $order->billing_address->latitude ?? '',
                    "longitude" => $order->billing_address->longitude ?? '',
                );
            }

            $shippingAddress = [];
            if (!empty($order->shipping_address)) {
                $shippingAddress = array(
                    "name" => $order->shipping_address->name,
                    "address1" => $order->shipping_address->address1,
                    "address2" => $order->shipping_address->address2 ?? '',
                    "phone" => $order->shipping_address->phone ?? '',
                    "city" => $order->shipping_address->city ?? '',
                    "zip" => $order->shipping_address->zip ?? '',
                    "state" => $order->shipping_address->province ?? '',
                    "country" => $order->shipping_address->country ?? '',
                    "country_code" => $order->shipping_address->country_code ?? '',
                    "state_code" => $order->shipping_address->province_code ?? '',
                    "latitude" => $order->shipping_address->latitude ?? '',
                    "longitude" => $order->shipping_address->longitude ?? '',
                );
            }

            $tProdAmt = 0;
            $tProdAmtEligibleForShip = 0;
            $lastShipEligibleProductId = 0;
            $lastProductId = 0;
            foreach ($order->line_items as $lineItem) {
                if ($lineItem->requires_shipping) {
                    $tProdAmtEligibleForShip += $lineItem->price;
                    $lastShipEligibleProductId = $lineItem->variant_id;
                }
                $tProdAmt += $lineItem->price;
            }

            $totalShippingAmount = 0;
            foreach ($order->shipping_lines as $shipItem) {
                $totalShippingAmount += $shipItem->price;
                foreach ($shipItem->tax_lines as $taxItem) {
                    /* Added shipping tax as shipping cost */
                    $totalShippingAmount += $taxItem->price;
                }
            }

            $products = [];
            foreach ($order->line_items as $lineItemKey => $lineItem) {
                $taxLines = [];
                foreach ($lineItem->tax_lines as $ptax) {
                    $taxLines[] = array(
                        'title' => $ptax->title,
                        'price' => $ptax->price,
                        'rate' => $ptax->rate,
                    );
                }
                $shippingCost = 0;
                if ($lastShipEligibleProductId == $lineItem->variant_id) {
                    $shippingCost = $totalShippingAmount - array_sum(array_column($products, 'shipping_cost'));
                } elseif ($lineItem->requires_shipping) {
                    $shippingCost = ($lineItem->price / $tProdAmtEligibleForShip) * $totalShippingAmount;
                }

                $totalDiscount = 0;
                if (0 < $order->total_discounts) {
                    if ($lastProductId == $lineItem->variant_id) {
                        $totalDiscount = $order->total_discounts - array_sum(array_column($products, 'total_discount'));
                    } elseif ($lineItem->requires_shipping) {
                        $totalDiscount = ($lineItem->price / $tProdAmt) * $order->total_discounts;
                    }
                }

                $products[$lineItem->variant_id] = array(
                    'id' => $lineItem->variant_id ?? 0,
                    'title' => $lineItem->title,
                    'quantity' => $lineItem->quantity,
                    'price' => $lineItem->price,
                    'total_discount' => $totalDiscount,
                    'volume_discount' => 0,
                    'shipping_cost' => $shippingCost,
                    'tax_lines' => $taxLines,
                    'refund_amount' => 0,
                    'refund_quantity' => 0,
                    'refund_shipping' => 0,
                    'status' => FatApp::getConfig("CONF_DEFAULT_ORDER_STATUS"),
                );
            }

            foreach ($order->fulfillments as $fulfillment) {
                foreach ($fulfillment->line_items as $lineItem) {
                    $products[$lineItem->variant_id]['status'] = FatApp::getConfig("CONF_DEFAULT_COMPLETED_ORDER_STATUS");
                }
            }

            foreach ($order->refunds as $refund) {

                $refundAmount = 0;
                $alreadyAllocatedRefundAmount = 0;
                foreach ($refund->transactions as $refTrans) {
                    $refundAmount += $refTrans->amount;
                }

                if (1 > count($refund->refund_line_items)) {
                    $type = FatApp::getConfig("CONF_RETURN_REQUEST_ORDER_STATUS");
                    /* if refund array didnt contain product info the including amount as refund shipping */
                    foreach ($products as &$product) {
                        if (0 < $product['shipping_cost']) {
                            if ($product['id'] == $lastShipEligibleProductId) {
                                $refundShipping = $refundAmount - $alreadyAllocatedRefundAmount;
                            } else {
                                $refundShipping = ($product['price'] / $tProdAmtEligibleForShip) * $refundAmount;
                            }
                            $product['refund_shipping'] += $refundShipping;
                            $product['status'] = $type;
                            $alreadyAllocatedRefundAmount += $refundShipping;
                        }
                    }
                } else {
                    foreach ($refund->refund_line_items as $refundItemKey => $refundItem) {
                        $type = FatApp::getConfig("CONF_RETURN_REQUEST_ORDER_STATUS");

                        /*
                          $type = FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS");
                          if ($products[$refundItem->line_item->variant_id]["quantity"] == $refundItem->line_item->quantity) {
                          $type = FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS");
                          } elseif ($order->financial_status == "partially_refunded") {
                          $type = FatApp::getConfig("CONF_RETURN_REQUEST_ORDER_STATUS");
                          }
                         * 
                         */

                        $products[$refundItem->line_item->variant_id]['status'] = $type;
                        $products[$refundItem->line_item->variant_id]['refund_quantity'] += $refundItem->line_item->quantity;

                        if ($lastProductId == $refundItem->line_item->variant_id) {
                            $refundAmount = $refundAmount - $alreadyAllocatedRefundAmount;
                        } else {
                            $refundAmount = ($products[$refundItem->line_item->variant_id]['price'] / $tProdAmt) * $refundAmount;
                        }
                        $products[$refundItem->line_item->variant_id]['refund_amount'] += $refundAmount;
                        $alreadyAllocatedRefundAmount += $refundAmount;
                    }
                }
            }

            $mappedOrders[] = $mappedOrder + ["products" => $products, "billingAddress" => $billingAddress, "shippingAddress" => $shippingAddress];
        }

        return $mappedOrders;
    }

    public function savePaginationData($type, $userId = 0)
    {
        $paginationSavedString = $this->getPaginationStringName($type);
        $this->saveData([$paginationSavedString => $this->getNextPageParams()], $userId);
    }

    public function isSyncCompleted($paginationParam)
    {
        if (is_array($paginationParam) && 1 > count($paginationParam)) {
            return true;
        }
        return false;
    }

    private function fetchCustomers($params = [])
    {
        /* include both seller and buyer but no paramter to differentiate whether buyer is also a seller */
        $url = $this->generateUrl(DataMigration::TYPE_USER, $params);
        $response = $this->sendSingleVendorGetRequest($url);
        return $response->customers;
    }

    private function fetchSellers($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_SELLER, $params);
        $response = $this->sendMultiVendorGetRequest($url);
        $sellers = $response->sellers;
        $this->nextLink = '';
        if (0 < count($sellers)) {
            $params['page']++;
            $this->nextLink = $this->generateUrl(DataMigration::TYPE_SELLER, $params);
        }

        return $sellers;
    }

    private function fetchMultiVendorProducts($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_PRODUCT, $params);
        $response = $this->sendMultiVendorGetRequest($url);
        $products = $response->products;
        $this->nextLink = '';
        if (0 < count($products)) {
            $params['page']++;
            $this->nextLink = $this->generateUrl(DataMigration::TYPE_PRODUCT, $params);
        }

        return $products;
    }

    private function fetchSingleVendorProducts($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_PRODUCT, $params);
        $response = $this->sendSingleVendorGetRequest($url);

        return $response->products;
    }

    private function mappedProducts($products)
    {

        $isSingleVendor = $this->vendorType === DataMigration::SINGLE_VENDOR;
        $collectionArr = [];
        if (!$isSingleVendor) {
            $collectionsCache = FatCache::get('ShopifyCollectionsCache', CONF_IMG_CACHE_TIME, '.txt');
            if ($collectionsCache) {
                $collectionArr = json_decode($collectionsCache, true);
            } else {
                $collectionArr = [];
                $collections = $this->fetchCollections();
                foreach ($collections as $collection) {
                    $collectionArr[$collection->main_id_category] = $collection->category_name;
                }
                FatCache::set('ShopifyCollectionsCache', json_encode($collectionArr), '.txt');
            }
        }


        $mappedProducts = [];

        foreach ($products as $product) {
            $product_type = Product::PRODUCT_TYPE_DIGITAL;
            foreach ($product->variants as $variant) {
                if ($variant->requires_shipping == 1) {
                    $product_type = Product::PRODUCT_TYPE_PHYSICAL;
                    break;
                }
            }
            $weightUnit = 0;
            $weight = 0;
            if ($isSingleVendor) {
                $firstVariant = current($product->variants);
                if (!empty($firstVariant)) {
                    $weight = $firstVariant->weight;
                    switch ($firstVariant->weight_unit) {
                        case 'kg':
                            $weightUnit = applicationConstants::WEIGHT_KILOGRAM;
                            break;
                        case 'lb':
                            $weightUnit = applicationConstants::WEIGHT_POUND;
                            break;
                        case 'oz':
                            $weightUnit = applicationConstants::WEIGHT_GRAM;
                            $weight = $weight * 28.3495;
                            break;
                        case 'g':
                            $weightUnit = applicationConstants::WEIGHT_GRAM;
                            break;
                    }
                }
            }

            $catalog = [
                'id' => $isSingleVendor ? $product->id : $product->shopify_product_id,
                'product_identifier' => $product->handle,
                'product_type' => $product_type,
                'brand_name' => '',
                'category_name' => $product->product_type ?? '',
                'product_min_selling_price' => 0.01,
                'product_approved' => 1,
                'product_active' => ($isSingleVendor ? ($product->status == 'active' ? 1 : 0) : $product->active),
                'product_fulfillment_type' => '',
                'product_name' => ($isSingleVendor ? $product->title : $product->product_name) ?? '',
                'product_description' => ($isSingleVendor ? $product->body_html : $product->product_description) ?? '',
                'product_category' => $product->product_type,
                'user_id' => ($isSingleVendor ? $this->userId : $product->seller_id),
                'product_weight_unit' => $weightUnit,
                'product_weight' => $weight, /* shopify has different weight for each variants */
                'product_youtube_video' => ''
            ];


            if ($isSingleVendor) {
                $tags = explode(", ", $product->tags);
            } else {
                $tags = json_decode($product->product_tag, true);
            }

            if (empty($tags)) {
                $tags = [];
            }
            if (!$isSingleVendor) {
                foreach ($product->collections as $collection) {
                    $tags[] = (string) $collectionArr[$collection->shopify_category_id];
                }
            }

            $mappedOptions = [];

            /* To get option except default one which is created by on every product, named Title  */
            if (!(count((array) $product->variants) == 1 && 1 == count($product->options) && isset($product->options[0]->name) && $product->options[0]->name == 'Title')) {
                foreach ($product->options as $option) {
                    $values = [];
                    if ($isSingleVendor) {
                        $values = $option->values;
                    } else {
                        foreach ($option->values as $value) {
                            $values[] = $value->value;
                        }
                    }
                    $mappedOptions[$option->name] = array('option_name' => $option->name, 'option_is_color' => 0, 'option_is_separate_images' => 0, 'option_display_in_filter' => 1, 'values' => $values);
                }
            }


            $sellerProducts = [];
            $productImages = [];

            if (!$isSingleVendor) {
                foreach ($product->images as $image) {
                    $productImages[$image->id] = ['url' => $image->img_url, 'option' => '', 'optionValue' => ''];
                }
            }

            foreach ($product->variants as $variant) {
                $inventory = [
                    'id' => $isSingleVendor ? $variant->id : $variant->shopify_variant_id,
                    'selprod_title' => $catalog['product_name'],
                    'selprod_url_keyword' => $product->handle ?? '',
                    'selprod_subtract_stock' => ($isSingleVendor ? ($product->status == 'active' ? 1 : 0) : $variant->track_inventory),
                    'selprod_active' => ($isSingleVendor ? ($product->status == 'active' ? 1 : 0) : $product->active),
                    'selprod_available_from' => date('Y-m-d'),
                    'selprod_condition' => Product::CONDITION_NEW,
                    'selprod_fulfillment_type' => 0,
                    'selprod_cost' => $variant->price,
                    'selprod_price' => $variant->price,
                    'selprod_stock' => ($isSingleVendor ? $variant->inventory_quantity : $variant->quantity) ?? 0,
                    'selprod_sku' => $variant->sku ?? '',
                    'selprod_min_order_qty' => 1,
                    'selprod_comments' => '',
                    'user_id' => ($isSingleVendor ? $this->userId : $product->seller_id), /* shopify user id */
                ];
                $combination = [];
                if (0 < count($mappedOptions)) {
                    foreach ($product->options as $key => $option) {
                        if ($isSingleVendor) {
                            $optionValue = $variant->{"option" . ($key + 1)};
                        } else {
                            $optionValue = $variant->combinations[$key]->option_value;
                        }

                        $combination[$option->name] = $optionValue;

                        /* issue in mutivendor api some option values are not present in $product->options */
                        if (isset($mappedOptions[$option->name]['values'])) {
                            if (!in_array($optionValue, $mappedOptions[$option->name]['values'])) {
                                $mappedOptions[$option->name]['values'][] = $optionValue;
                            }
                        }
                    }
                }

                if (!$isSingleVendor) {
                    if (isset($productImages[$variant->image_id])) {
                        $optionName = '';
                        $optionValue = '';
                        if (count($combination) == 1) {
                            $optionName = array_key_first($combination);
                            $optionValue = current($combination);
                        } elseif (isset($combination['Color'])) {
                            $optionName = 'Color';
                            $optionValue = $combination['Color'];
                            if (0 < count($mappedOptions)) {
                                $mappedOptions[$optionName]['option_is_color'] = 1;
                            }
                        } elseif (count($combination) > 1) {
                            foreach ($combination as $key => $val) {
                                if ($key !== 'Size') {
                                    $optionName = $key;
                                    $optionValue = $val;
                                    break;
                                }
                            }
                        }
                        if (0 < count($mappedOptions)) {
                            $mappedOptions[$optionName]['option_is_separate_images'] = 1;
                        }
                        $productImages[$variant->image_id]['option'] = $optionName;
                        $productImages[$variant->image_id]['optionValue'] = $optionValue;
                    }
                }
                $sellerProducts[$inventory['id']] = $inventory + ['combination' => $combination];
            }

            if ($isSingleVendor) {
                foreach ($product->images as $image) {
                    $productImage = ['url' => $image->src, 'option' => '', 'optionValue' => ''];
                    $optionName = '';
                    $optionValue = '';
                    foreach ($mappedOptions as $op => $opV) {
                        if (0 < count($image->variant_ids)) {
                            $optionName = $op;
                            $sellerProduct = $sellerProducts[current($image->variant_ids)];

                            $sellerProdCombination = $sellerProduct['combination'];
                            $optionValue = $sellerProdCombination[$op];
                            if ($op == 'Color') {
                                break;
                            }
                        }
                    }
                    $productImage['option'] = $optionName;
                    $productImage['optionValue'] = $optionValue;
                    $productImages[] = $productImage;
                }
            }

            $mappedProducts[] = ['catalog' => $catalog, 'options' => $mappedOptions, 'images' => $productImages, 'sellerProducts' => $sellerProducts, 'tags' => $tags];
        }

        return $mappedProducts;
    }

    private function fetchOrders($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_ORDER, $params);
        $response = $this->sendSingleVendorGetRequest($url);
        return $response->orders;
    }

    private function fetchCollections($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_PRODUCT_TAG, $params);
        $response = $this->sendMultiVendorGetRequest($url);
        return $response->collections;
    }

    private function sendSingleVendorGetRequest($url)
    {
        $curl = new Curl();
        $curl->setHeader('X-Shopify-Access-Token', $this->settings['password']);
        $curl->get($url);
        if ($curl->error) {
            if (isset($curl->response->errors)) {
                $message = $this->castString($curl->response->errors);
                throw new Exception($message, $curl->errorCode);
            }
            throw new Exception($curl->errorMessage, $curl->errorCode);
        } else {
            $responseHeaders = $curl->getResponseHeaders();
            $this->getLinks($responseHeaders);
            return $curl->response;
        }
    }

    private function sendMultiVendorGetRequest($url)
    {
        $curl = new Curl();
        $curl->setHeader('Authorization', 'Bearer' . ' ' . $this->settings['multivendor_access_token']);
        $curl->get($url);
        if ($curl->error) {
            if (isset($curl->response->error)) {
                $message = $this->castString($curl->response->error_description);
                throw new Exception($message, $curl->errorCode);
            }
            throw new Exception($curl->errorMessage, $curl->errorCode);
        } else {
            $this->currentLink = $url;
            return $curl->response;
        }
    }

    private function castString($array)
    {
        if (!is_object($array))
            return (string) $array;

        $string = '';
        $i = 0;
        foreach ($array as $key => $val) {
            //Add values separated by comma
            //prepend the key string, if it's an associative key
            //Check if the value itself is another array to be converted to string
            $string .= ($i === $key ? '' : "$key - ") . $this->castString($val) . ', ';
            $i++;
        }

        //Remove trailing comma and space
        $string = rtrim($string, ', ');

        return $string;
    }

    private function generateUrl($type, $urlParams = array())
    {
        switch ($type) {
            case DataMigration::TYPE_PRODUCT:
                $urlType = 'products';
                break;
            case DataMigration::TYPE_USER:
                $urlType = 'customers';
                break;
            case DataMigration::TYPE_SELLER:
                $urlType = 'sellers';
                break;
            case DataMigration::TYPE_PRODUCT_TAG:
                $urlType = 'collections';
                break;
            case DataMigration::TYPE_ORDER:
                $urlType = 'orders';
                break;
        }

        if ($this->vendorType === DataMigration::MULTIVENDOR_VENDOR && in_array($type, [DataMigration::TYPE_SELLER, DataMigration::TYPE_PRODUCT, DataMigration::TYPE_PRODUCT_TAG])) {
            return self::MULTIVENDOR_API_URL . DIRECTORY_SEPARATOR . 'api/' . self::MULTIVENDOR_API_VERSION . DIRECTORY_SEPARATOR . $urlType . '.json' . (!empty($urlParams) ? '?' . http_build_query($urlParams) : '');
        }

        return $this->settings['shop_url'] . DIRECTORY_SEPARATOR . 'admin/api/' . self::API_VERSION . DIRECTORY_SEPARATOR . $urlType . '.json' . (!empty($urlParams) ? '?' . http_build_query($urlParams) : '');
    }

    private function getLinks($responseHeaders)
    {
        $this->nextLink = $this->getLink($responseHeaders, 'next');
        $this->prevLink = $this->getLink($responseHeaders, 'previous');
    }

    private function getLink($responseHeaders, $type = 'next')
    {
        if (!empty($responseHeaders['link'])) {
            if (stristr($responseHeaders['link'], '; rel="' . $type . '"') !== false) {
                $headerLinks = explode(',', $responseHeaders['link']);
                foreach ($headerLinks as $headerLink) {
                    if (stristr($headerLink, '; rel="' . $type . '"') === false) {
                        continue;
                    }
                    $pattern = '#<(.*?)>; rel="' . $type . '"#m';
                    preg_match($pattern, $headerLink, $linkResponseHeaders);
                    if ($linkResponseHeaders) {
                        return $linkResponseHeaders[1];
                    }
                }
            }
        }
        return null;
    }

    private function getPaginationStringName($type)
    {
        $stringName = 'PaginationParam';
        switch ($type) {
            case DataMigration::TYPE_PRODUCT:
                $stringName = 'product' . $stringName;
                break;
            case DataMigration::TYPE_USER:
                $stringName = 'user' . $stringName;
                break;
            case DataMigration::TYPE_SELLER:
                $stringName = 'seller' . $stringName;
                break;
            case DataMigration::TYPE_PRODUCT_TAG:
                $stringName = 'tags' . $stringName;
                break;
            case DataMigration::TYPE_ORDER:
                $stringName = 'order' . $stringName;
                break;
        }

        return $stringName;
    }

    private function getUrlParams($url)
    {
        if ($url) {
            $parts = parse_url($url);
            return $parts['query'];
        }
        return '';
    }

    private function getNextPageParams()
    {
        $nextPageParams = [];
        parse_str($this->getUrlParams($this->getNextLink()), $nextPageParams);
        return $nextPageParams;
    }

    private function getPrevPageParams()
    {
        $nextPageParams = [];
        parse_str($this->getUrlParams($this->getPrevLink()), $nextPageParams);
        return $nextPageParams;
    }

    private function getPrevLink()
    {
        return $this->prevLink;
    }

    private function getNextLink()
    {
        return $this->nextLink;
    }

    /**
     * validateKeys
     *
     * @param  array $keys
     * @return bool
     */
    public function validateKeys(array $keys): bool
    {
        $keys['plugin_active'] = Plugin::ACTIVE;
        $this->settings = $keys;
        try {
            $this->fetchSellers(['page' => 1, 'limit' => 1]);
        } catch (Exception $e) {
            SystemLog::system($e->getMessage(), self::KEY_NAME);
            return false;
        }
    }
}
