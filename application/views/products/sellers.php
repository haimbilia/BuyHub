<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$displayProductNotAvailableLable = false;
if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) {
    $displayProductNotAvailableLable = true;
}
?>
<div id="body" class="body">

    <section class="section">
        <div class="container">
            <div class="grid-layout">
                <div class="grid-layout-start">
                    <div class="sticky-lg-top">
                        <div class="product-card">
                            <div class="product-card-start">
                                <div class="product-card-img">
                                    <a title="<?php echo $product['selprod_title']; ?>" href="<?php echo UrlHelper::generateUrl('products', 'view', array(
                                                                                                    $product['selprod_id']
                                                                                                )); ?>">
                                        <img width="300" height="300" alt="" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array(
                                                                                        $product['product_id'],
                                                                                        ImageDimension::VIEW_SMALL,
                                                                                        $product['selprod_id'],
                                                                                        0,
                                                                                        $siteLangId
                                                                                    ), CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="product-card-end">
                                <div class="product-card-data">
                                    <a class="title" title="<?php echo $product['selprod_title']; ?>" href="<?php echo UrlHelper::generateUrl('products', 'view', array(
                                                                                                                $product['selprod_id']
                                                                                                            )); ?>"><?php echo $product['selprod_title']; ?></a>
                                    <?php if (round($product['prod_rating']) > 0 && FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) {
                                    ?> <div class="product-ratings">
                                            <svg class="svg" width="14" height="14">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                            <span class="rate">
                                                <?php echo round($product['prod_rating'], 1); ?>
                                            </span>
                                        </div>
                                    <?php } ?>

                                    <div class="rating-block">
                                        <div class="average-rating">
                                            <span class="rate">4.5 <svg class="svg" width="16" height="16">
                                                    <use xlink:href="/yokart/images/retina/sprite.svg#star-yellow">
                                                    </use>
                                                </svg>
                                            </span>
                                            <span class="totals">2 Reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid-layout-end">
                    <div class="seller-lists">
                        <div class="seller-card">
                            <div class="seller-card-head">
                                <picture class="seller-logo">
                                    <source type="image/webp" srcset="/yokart/image/shop-logo/1/1/WEBPTHUMB/0?t=1646915318" media="(max-width: 767px),(max-width: 1024px)">
                                    <source type="image/jpeg" srcset="/yokart/image/shop-logo/1/1/THUMB/0?t=1646915318" media="(max-width: 767px),(max-width: 1024px)">
                                    <img loading="lazy" data-ratio="" src="/yokart/image/shop-logo/1/1/THUMB/0?t=1646915318" alt="Kanwar's Shop" title="Kanwar's Shop">
                                </picture>


                            </div>
                            <div class="seller-card-body">
                                <a class="title" title="Chromium Gallery" href="/yokart/chromium-gallery">
                                    Chromium Gallery
                                </a>


                                <a class="location" href="/yokart/chromium-gallery">
                                    Punjab,India
                                </a>
                                <span class="price">
                                    ₹21,990.00
                                </span>
                                <span class="payment-mode">
                                    Cash On Delivery Available
                                </span>
                            </div>
                            <div class="seller-card-foot">
                                <a class="link-underline" href="/yokart/apple-iphone-12-211" title="View Details">View Details</a>
                                <button class="btn btn-outline-black btn-sm" type="button">Add to Cart</button>
                            </div>
                        </div>
                        <div class="seller-card">
                            <div class="seller-card-head">
                                <picture class="seller-logo">
                                    <source type="image/webp" srcset="/yokart/image/shop-logo/1/1/WEBPTHUMB/0?t=1646915318" media="(max-width: 767px),(max-width: 1024px)">
                                    <source type="image/jpeg" srcset="/yokart/image/shop-logo/1/1/THUMB/0?t=1646915318" media="(max-width: 767px),(max-width: 1024px)">
                                    <img loading="lazy" data-ratio="" src="/yokart/image/shop-logo/1/1/THUMB/0?t=1646915318" alt="Kanwar's Shop" title="Kanwar's Shop">
                                </picture>


                            </div>
                            <div class="seller-card-body">
                                <a class="title" title="Chromium Gallery" href="/yokart/chromium-gallery">
                                    Chromium Gallery
                                </a>


                                <a class="location" href="/yokart/chromium-gallery">
                                    Punjab,India
                                </a>
                                <span class="price">
                                    ₹21,990.00
                                </span>
                                <span class="payment-mode">
                                    Cash On Delivery Available
                                </span>
                            </div>
                            <div class="seller-card-foot">
                                <a class="link-underline" href="/yokart/apple-iphone-12-211" title="View Details">View Details</a>
                                <button class="btn btn-outline-black btn-sm" type="button">Add to Cart</button>
                            </div>
                        </div>
                        <div class="seller-card">
                            <div class="seller-card-head">
                                <picture class="seller-logo">
                                    <source type="image/webp" srcset="/yokart/image/shop-logo/1/1/WEBPTHUMB/0?t=1646915318" media="(max-width: 767px),(max-width: 1024px)">
                                    <source type="image/jpeg" srcset="/yokart/image/shop-logo/1/1/THUMB/0?t=1646915318" media="(max-width: 767px),(max-width: 1024px)">
                                    <img loading="lazy" data-ratio="" src="/yokart/image/shop-logo/1/1/THUMB/0?t=1646915318" alt="Kanwar's Shop" title="Kanwar's Shop">
                                </picture>


                            </div>
                            <div class="seller-card-body">
                                <a class="title" title="Chromium Gallery" href="/yokart/chromium-gallery">
                                    Chromium Gallery
                                </a>


                                <a class="location" href="/yokart/chromium-gallery">
                                    Punjab,India
                                </a>
                                <span class="price">
                                    ₹21,990.00
                                </span>
                                <span class="payment-mode">
                                    Cash On Delivery Available
                                </span>
                            </div>
                            <div class="seller-card-foot">
                                <a class="link-underline" href="/yokart/apple-iphone-12-211" title="View Details">View Details</a>
                                <button class="btn btn-outline-black btn-sm" type="button">Add to Cart</button>
                            </div>
                        </div>
                        <div class="seller-card">
                            <div class="seller-card-head">
                                <picture class="seller-logo">
                                    <source type="image/webp" srcset="/yokart/image/shop-logo/1/1/WEBPTHUMB/0?t=1646915318" media="(max-width: 767px),(max-width: 1024px)">
                                    <source type="image/jpeg" srcset="/yokart/image/shop-logo/1/1/THUMB/0?t=1646915318" media="(max-width: 767px),(max-width: 1024px)">
                                    <img loading="lazy" data-ratio="" src="/yokart/image/shop-logo/1/1/THUMB/0?t=1646915318" alt="Kanwar's Shop" title="Kanwar's Shop">
                                </picture>


                            </div>
                            <div class="seller-card-body">
                                <a class="title" title="Chromium Gallery" href="/yokart/chromium-gallery">
                                    Chromium Gallery
                                </a>


                                <a class="location" href="/yokart/chromium-gallery">
                                    Punjab,India
                                </a>
                                <span class="price">
                                    ₹21,990.00
                                </span>
                                <span class="payment-mode">
                                    Cash On Delivery Available
                                </span>
                            </div>
                            <div class="seller-card-foot">
                                <a class="link-underline" href="/yokart/apple-iphone-12-211" title="View Details">View Details</a>
                                <button class="btn btn-outline-black btn-sm" type="button">Add to Cart</button>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div class="card-table">
                            <div class="">
                                <?php
                                $arr_flds = array(
                                    'shop_name' => Labels::getLabel('LBL_Seller', $siteLangId),
                                    'theprice' => Labels::getLabel('LBL_Price', $siteLangId),
                                    'COD' => Labels::getLabel('LBL_COD_AVAILABLE', $siteLangId),
                                    'viewDetails' => '',
                                    'Action' => '',

                                );
                                $tbl = new HtmlElement('table', array(
                                    'class' => 'table table-justified'
                                ));
                                $th = $tbl->appendElement('thead')
                                    ->appendElement('tr', array(
                                        'class' => ''
                                    ));
                                foreach ($arr_flds as $val) {
                                    $e = $th->appendElement('th', array(), $val);
                                }

                                $sr_no = 0;
                                foreach ($product['moreSellersArr'] as $sn => $moresellers) {
                                    $sr_no++;

                                    $tr = $tbl->appendElement('tr', array(
                                        'class' => ''
                                    ));

                                    foreach ($arr_flds as $key => $val) {
                                        $td = $tr->appendElement('td');
                                        switch ($key) {
                                            case 'shop_name':
                                                $txt = '<div class="item">
                                                        <figure class="item__pic item__pic-seller">
                                                            <a title="' . $moresellers[$key] . '" href="' . UrlHelper::generateUrl('shops', 'view', array(
                                                    $moresellers['shop_id']
                                                )) . '">
                                                                <img data-ratio="1:1 (150x150)" src="' . UrlHelper::generateFileUrl('image', 'shopLogo', array(
                                                    $moresellers['shop_id'],
                                                    $siteLangId,
                                                    ImageDimension::VIEW_THUMB
                                                )) . '" alt="' . $moresellers['shop_name'] . '">
                                                            </a>
                                                        </figure>
                                                         <div class="product-profile-data">
                                                            <div class="title" >
                                                                <a title="' . $moresellers[$key] . '" href="' . UrlHelper::generateUrl('shops', 'view', array(
                                                    $moresellers['shop_id']
                                                )) . '">
                                                                    ' . $moresellers[$key] . '
                                                                </a>
                                                            </div>
                                                            <div class="item__brand">
                                                                <a href="' . UrlHelper::generateUrl('shops', 'view', array(
                                                    $moresellers['shop_id']
                                                )) . '">
                                                                    ' . $moresellers['shop_state_name'] . "," . $moresellers['shop_country_name'] . '
                                                                </a>
                                                            </div>';
                                                if (isset($product['rating'][$moresellers['selprod_user_id']]) && $product['rating'][$moresellers['selprod_user_id']] > 0) {
                                                    $txt .= '<div class="product-ratings">
                                                                            
                                                                                <svg class="svg" width="14" height="14">
                                                                                    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.svg#star-yellow" >
                                                                                    </use>
                                                                                </svg>
                                                                            
                                                                            <span class="rate">
                                                                                ' . round($product['rating'][$moresellers['selprod_user_id']], 1) . '
                                                                            </span>
                                                                        </div>';
                                                }
                                                $txt .= '</div>
                                                    </div>';
                                                $td->appendElement('plaintext', array(), $txt, true);
                                                break;

                                            case 'theprice':
                                                $txt = ' <div class=""><div class="item__price">' . CommonHelper::displayMoneyFormat($moresellers['theprice']);
                                                if ($moresellers['special_price_found'] && $moresellers['selprod_price'] > $moresellers['theprice']) {
                                                    $txt .= '  <span class="item__price_old">' . CommonHelper::displayMoneyFormat($moresellers['selprod_price']) . '</span>
                                                    <div class="item__price_off">' . CommonHelper::showProductDiscountedText($moresellers, $siteLangId) . '</div>';
                                                }
                                                $txt .= '</div></div>';
                                                $td->appendElement('plaintext', array(), $txt, true);
                                                break;
                                            case 'COD':
                                                $codAvailableTxt = Labels::getLabel('LBL_N/A', $siteLangId);;
                                                if (!empty($product['cod'][$moresellers['selprod_user_id']]) && $product['cod'][$moresellers['selprod_user_id']]) {
                                                    $codAvailableTxt = Labels::getLabel('LBL_Cash_on_delivery_available', $siteLangId);
                                                }
                                                $td->appendElement('plaintext', array(), $codAvailableTxt, true);
                                                break;
                                            case 'viewDetails':
                                                $td->appendElement('a', array(
                                                    'href' => UrlHelper::generateUrl('products', 'view', array(
                                                        $moresellers['selprod_id']
                                                    )),
                                                    'class' => 'link--arrow',
                                                    'title' => Labels::getLabel('LBL_View_Details', $siteLangId),
                                                    true
                                                ), Labels::getLabel('LBL_View_Details', $siteLangId), true);
                                                break;

                                            case 'Action':
                                                if (true == $displayProductNotAvailableLable && array_key_exists('availableInLocation', $product) && 0 == $product['availableInLocation']) {
                                                    $txt = '<span class="text-danger">' . Labels::getLabel('LBL_NOT_AVAILABLE', $siteLangId) . '</span>';
                                                } else {
                                                    if (date('Y-m-d', strtotime($moresellers['selprod_available_from'])) <= FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d')) {

                                                        //$txt ='<div> <a data-id="'.$moresellers['selprod_id'].'" data-min-qty="'.$moresellers['selprod_min_order_qty'].'"  href="javascript:void(0)" class="btn btn-brand btn-sm ripplelink block-on-mobile btnProductBuy--js">  '.Labels::getLabel('LBL_Buy_Now', $siteLangId).'</a> <a data-id="'.$moresellers['selprod_id'].'" data-min-qty="'.$moresellers['selprod_min_order_qty'].'"  href="javascript:void(0)" class="btn btn-outline-brand btn-sm ripplelink block-on-mobile btnAddToCart--js">  '.Labels::getLabel('LBL_Add_To_Cart', $siteLangId).'</a> </div>';
                                                        $txt = '<div> <a data-id="' . $moresellers['selprod_id'] . '" data-min-qty="' . $moresellers['selprod_min_order_qty'] . '"  href="javascript:void(0)" class="btn btn-outline-brand btn-sm btnAddToCart--js">  ' . Labels::getLabel('LBL_Add_To_Cart', $siteLangId) . '</a> </div>';
                                                    } else {
                                                        $txt = str_replace('{available-date}', FatDate::Format($moresellers['selprod_available_from']), Labels::getLabel('LBL_This_item_will_be_available_from_{available-date}', $siteLangId));
                                                    }
                                                }
                                                $td->appendElement('plaintext', array(), $txt, true);

                                                break;

                                            default:
                                                $td->appendElement('plaintext', array(), $moresellers[$key], true);
                                                break;
                                        }
                                    }
                                }
                                echo $tbl->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>