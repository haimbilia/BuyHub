<?php
$controller = strtolower($controller);
$action = strtolower($action);
$plugin = new Plugin();

?> <sidebar class="sidebar no-print">
    <div class="logo-wrapper">
        <?php
        $logoUrl = UrlHelper::generateUrl('', '', [], CONF_WEBROOT_FRONTEND);
        ?>
        <?php
        $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
        $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
        $uploadedTime = isset($fileData['afile_updated_at']) ? AttachedFile::setTimeParam($fileData['afile_updated_at']) : '';
        $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

        $ratio = '';
        if (isset($fileData['afile_aspect_ratio']) && $fileData['afile_aspect_ratio'] > 0 && isset($aspectRatioArr[$fileData['afile_aspect_ratio']])) {
            $ratio = $aspectRatioArr[$fileData['afile_aspect_ratio']];
        }

        ?>
        <div class="logo-dashboard">
            <a href="<?php echo $logoUrl; ?>">
                <img data-ratio="<?php echo $ratio; ?>" src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>">
            </a>
        </div>

        <?php $isOpened = '';
        if (array_key_exists('openSidebar', $_COOKIE) && !empty(FatUtility::int($_COOKIE['openSidebar'])) && array_key_exists('screenWidth', $_COOKIE) && applicationConstants::MOBILE_SCREEN_WIDTH < FatUtility::int($_COOKIE['screenWidth'])) {
            $isOpened = 'is-opened';
        } ?>
        <div class="js-hamburger hamburger-toggle <?php echo $isOpened; ?>"><span class="bar-top"></span><span class="bar-mid"></span>
            <span class="bar-bot">
            </span>
        </div>
    </div>
    <div class="sidebar__content custom-scrollbar" id="scrollElement-js">
        <ul class="dashboard-menu">
            <?php
            if (
                $userPrivilege->canViewShop(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewProducts(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewProductTags(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewProductOptions(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewTaxCategory(UserAuthentication::getLoggedUserId(), true)
            ) { ?>
                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel('LBL_Shop', $siteLangId); ?>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>
                    <ul class="menu-sub menu-sub-accordion collapse show" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                        <?php if ($userPrivilege->canViewShop(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'shop') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Manage_Shop', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'shop'); ?>">
                                    <span class="menu-sub-title">
                                        <?php echo Labels::getLabel('LBL_Manage_Shop', $siteLangId); ?>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                        <!-- <li class="dashboard-menu-item"><div class="dashboard-menu-inner"> <a class="menu-sub-link"  title="<?php echo Labels::getLabel('LBL_View_Shop', $siteLangId); ?>" target="_blank" href="<?php echo UrlHelper::generateUrl('Shops', 'view', array($shop_id)); ?>"> <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_View_Shop', $siteLangId); ?></span></a></div></li> -->
                        <?php if ($userPrivilege->canViewProducts(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && ($action == 'customcatalogproductform' || $action == 'customproductform' || $action == 'catalog' || $action == 'products' || $action == 'customcatalogproducts')) ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Products', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('seller', 'products'); //echo UrlHelper::generateUrl('seller', 'catalog');                                                                                                                                     
                                                                                                                                    ?>">
                                    <span class="menu-sub-title">
                                        <?php echo Labels::getLabel('LBL_Shop_Inventory', $siteLangId); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (User::canAddCustomProduct() && $userPrivilege->canViewProductTags(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'producttags') ? 'is-active' : ''; ?>">

                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Product_Tags', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'productTags'); ?>">
                                    <span class="menu-sub-title">
                                        <?php echo Labels::getLabel('LBL_Product_Tags', $siteLangId); ?>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php $canAddCustomProd = FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0);
                        if (0 < $canAddCustomProd && $userPrivilege->canViewProductOptions(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'options') ? 'is-active' : ''; ?>">

                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Product_Options', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'options'); ?>">
                                    <span class="menu-sub-title">
                                        <?php echo Labels::getLabel('LBL_Product_Options', $siteLangId); ?>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0) && $userPrivilege->canViewTaxCategory(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && ($action == 'taxcategories' || $action == 'taxrules')) ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Tax_Categories', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'taxCategories'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Tax_Categories', $siteLangId); ?>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($userPrivilege->canViewSellerRequests(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'sellerrequests' && $action == 'index') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Requests', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('SellerRequests'); ?>">
                                    <span class="menu-sub-title">
                                        <?php echo Labels::getLabel('LBL_Requests', $siteLangId); ?>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

            <?php } ?>
            <?php if (
                $userPrivilege->canViewShippingProfiles(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewShippingPackages(UserAuthentication::getLoggedUserId(), true)
            ) { ?>

                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel('LBL_Shipping', $siteLangId); ?>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>

                    <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                        <?php
                        $shippingObj = new Shipping($siteLangId);
                        if ($userPrivilege->canViewShippingProfiles(UserAuthentication::getLoggedUserId(), true) && !FatApp::getConfig('CONF_SHIPPED_BY_ADMIN_ONLY', FatUtility::VAR_INT, 0) && (!$shippingObj->getShippingApiObj($userParentId) || Shop::getAttributesByUserId($userParentId, 'shop_use_manual_shipping_rates'))) {
                        ?>
                            <li class="menu-sub-item <?php echo ($controller == 'shippingprofile') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Shipping_Profiles', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('shippingProfile'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Shipping_Profiles', $siteLangId); ?>
                                    </span>
                                </a>

                            </li>
                        <?php } ?>
                        <?php if ($userPrivilege->canViewShippingPackages(UserAuthentication::getLoggedUserId(), true) && FatApp::getConfig("CONF_PRODUCT_DIMENSIONS_ENABLE", FatUtility::VAR_INT, 1) && FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'shippingpackages') ? 'is-active' : ''; ?>">

                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Shipping_Packages', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('shippingPackages'); ?>">
                                    <i class="fas fa-box icn"></i>
                                    <span class="menu-sub-title">
                                        <?php echo Labels::getLabel('LBL_Shipping_Packages', $siteLangId); ?></span>
                                </a>

                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if (
                $userPrivilege->canViewSales(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewCancellationRequests(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewReturnRequests(UserAuthentication::getLoggedUserId(), true)
            ) { ?>
                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel('LBL_Sales', $siteLangId); ?>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>
                    <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                        <?php if ($userPrivilege->canViewSales(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'sales') ? 'is-active' : ''; ?>">

                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Orders', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'Sales'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Orders', $siteLangId); ?></span></a>

                            </li>
                        <?php } ?>
                        <?php if ($userPrivilege->canViewCancellationRequests(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'ordercancellationrequests') ? 'is-active' : '' ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Order_Cancellation_Requests', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'orderCancellationRequests'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Order_Cancellation_Requests", $siteLangId); ?>
                                    </span>
                                </a>

                            </li>
                        <?php } ?>
                        <?php if ($userPrivilege->canViewReturnRequests(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && ($action == 'orderreturnrequests' || $action == 'vieworderreturnrequest')) ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Order_Return_Requests', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'orderReturnRequests'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Order_Return_Requests", $siteLangId); ?></span></a>

                            </li>

                        <?php } ?>
                    </ul>
                </li>

            <?php } ?>
            <?php if (
                $userPrivilege->canViewSpecialPrice(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewVolumeDiscount(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewBuyTogetherProducts(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewRelatedProducts(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewAdvertisementFeed(UserAuthentication::getLoggedUserId(), true) ||
                $userPrivilege->canViewBadgeLinks(UserAuthentication::getLoggedUserId(), true)
            ) { ?>
                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel('LBL_Promotions', $siteLangId); ?></span>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>
                    <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                        <?php if ($userPrivilege->canViewSpecialPrice(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'specialprice') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Special_Price', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'specialPrice'); ?>">

                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Special_Price', $siteLangId); ?></span>
                                </a>

                            </li>
                        <?php } ?>
                        <?php if ($userPrivilege->canViewVolumeDiscount(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'volumediscount') ? 'is-active' : ''; ?>">

                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Volume_Discount', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'volumeDiscount'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Volume_Discount', $siteLangId); ?></span></a>

                            </li>
                        <?php } ?>
                        <?php if ($userPrivilege->canViewBuyTogetherProducts(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'upsellproducts') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Buy_Together_Products', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'upsellProducts'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Buy_Together_Products', $siteLangId); ?></span></a>

                            </li>
                        <?php } ?>
                        <?php if ($userPrivilege->canViewRelatedProducts(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'relatedproducts') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Related_Products', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'RelatedProducts'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Related_Products', $siteLangId); ?></span></a>

                            </li>
                        <?php } ?>
                        <?php
                        $pluginData = $plugin->getDefaultPluginData(Plugin::TYPE_ADVERTISEMENT_FEED, null, $siteLangId);
                        if ($userPrivilege->canViewAdvertisementFeed(UserAuthentication::getLoggedUserId(), true) && false !== $pluginData && !empty($pluginData) && 0 < $pluginData['plugin_active'] && $userPrivilege->canViewAdvertisementFeed(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == strtolower($pluginData['plugin_code'])) ? 'is-active' : ''; ?>">

                                <a class="menu-sub-link" title="<?php echo $pluginData['plugin_name']; ?>" href="<?php echo UrlHelper::generateUrl($pluginData['plugin_code']); ?>">

                                    <span class="menu-sub-title"><?php echo $pluginData['plugin_name']; ?></span>
                                </a>

                            </li>
                        <?php } ?>
                        <?php if ($userPrivilege->canViewBadgeLinks(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'badges' && current($_GET) == 'badges/list/1') ? 'is-active' : ''; ?>">

                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_BADGES_LINKING', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Badges', 'list', [Badge::TYPE_BADGE]); ?>">

                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_BADGES', $siteLangId); ?></span>
                                </a>

                            </li>
                            <li class="menu-sub-item <?php echo ($controller == 'badges' && current($_GET) == 'badges/list/2') ? 'is-active' : ''; ?>">

                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_RIBBONS_LINKING', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Badges', 'list', [Badge::TYPE_RIBBON]); ?>">

                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_RIBBONS', $siteLangId); ?></span>
                                </a>

                            </li>
                        <?php } ?>

                    <?php } ?>
                    </ul>
                </li>

                <?php
                $marketPlaceChannels = (array) Plugin::getDataByType(Plugin::TYPE_MARKETPLACE_CHANNELS, $siteLangId);
                if ($userPrivilege->canViewMarketplaceChannel(UserAuthentication::getLoggedUserId(), true) && 0 < count($marketPlaceChannels)) { ?>
                    <li class="dashboard-menu-item">
                        <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                            <span class="dashboard-menu-icon">
                                <svg class="svg" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                    </use>
                                </svg>
                            </span>
                            <span class="dashboard-menu-head">
                                <?php echo Labels::getLabel('LBL_OMNI_CHANNEL_MANAGEMENT', $siteLangId); ?>
                            </span>
                            <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                            </i>
                        </button>


                        <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">

                            <?php
                            foreach ($marketPlaceChannels as $channel) {
                                $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_PLUGIN_LOGO, $channel['plugin_id']);
                                $uploadedTime = '';
                                $aspectRatio = '';
                                if (!empty($fileData)) {
                                    $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                                    $aspectRatio = ($fileData['afile_aspect_ratio'] > 0 && isset($aspectRatioArr[$fileData['afile_aspect_ratio']])) ? $aspectRatioArr[$fileData['afile_aspect_ratio']] : '';
                                }
                            ?>
                                <li class="menu-sub-item <?php echo ($controller == strtolower($channel['plugin_code'])) ? 'is-active' : ''; ?>">

                                    <a class="menu-sub-link" title="<?php echo $channel['plugin_name']; ?>" href="<?php echo UrlHelper::generateUrl($channel['plugin_code']); ?>">

                                        <span class="menu-sub-title"><?php echo $channel['plugin_name']; ?></span>
                                    </a>

                                </li>
                            <?php  } ?>

                        </ul>
                    </li>
                <?php } ?>
                <?php if (
                    $userPrivilege->canViewMetaTags(UserAuthentication::getLoggedUserId(), true) ||
                    $userPrivilege->canViewUrlRewriting(UserAuthentication::getLoggedUserId(), true)
                ) { ?>
                    <li class="dashboard-menu-item">
                        <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                            <span class="dashboard-menu-icon">
                                <svg class="svg" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                    </use>
                                </svg>
                            </span>
                            <span class="dashboard-menu-head">
                                <?php echo Labels::getLabel('LBL_SEO', $siteLangId); ?>
                            </span>
                            <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                            </i>
                        </button>

                        <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                            <?php if ($userPrivilege->canViewMetaTags(UserAuthentication::getLoggedUserId(), true)) { ?>
                                <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'productseo') ? 'is-active' : ''; ?>">

                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Meta_Tags', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'productSeo'); ?>">

                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Meta_Tags', $siteLangId); ?></span>
                                    </a>

                                </li>
                            <?php } ?>
                            <?php if ($userPrivilege->canViewUrlRewriting(UserAuthentication::getLoggedUserId(), true)) { ?>
                                <li class="menu-sub-item <?php echo ($controller == 'seller' && $action == 'producturlrewriting') ? 'is-active' : ''; ?>">
                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_URL_Rewriting', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'productUrlRewriting'); ?>">
                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_URL_Rewriting', $siteLangId); ?></span></a>

                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>
                <?php if (FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE') && $userPrivilege->canViewSubscription(UserAuthentication::getLoggedUserId(), true)) { ?>
                    <li class="dashboard-menu-item">
                        <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                            <span class="dashboard-menu-icon">
                                <svg class="svg" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                    </use>
                                </svg>
                            </span>
                            <span class="dashboard-menu-head">
                                <?php echo Labels::getLabel('LBL_Subscription', $siteLangId); ?>
                            </span>
                            <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                            </i>
                        </button>
                        <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && ($action == 'subscriptions' || $action == 'viewsubscriptionorder')) ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_My_Subscriptions', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'subscriptions'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_My_Subscriptions", $siteLangId); ?></span></a>

                            </li>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && ($action == 'packages')) ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Subscription_Packages', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('seller', 'Packages'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Subscription_Packages', $siteLangId); ?></span></a>

                            </li>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && ($action == 'selleroffers')) ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Subscription_Offers', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('seller', 'SellerOffers'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Subscription_Offers', $siteLangId); ?></span></a>

                            </li>

                        </ul>
                    </li>
                <?php } ?>
                <?php if (
                    $userPrivilege->canViewSalesReport(UserAuthentication::getLoggedUserId(), true) ||
                    $userPrivilege->canViewCatalogReport(UserAuthentication::getLoggedUserId(), true) ||
                    $userPrivilege->canViewPerformanceReport(UserAuthentication::getLoggedUserId(), true) ||
                    $userPrivilege->canViewInventoryReport(UserAuthentication::getLoggedUserId(), true)
                ) { ?>
                    <li class="dashboard-menu-item">
                        <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                            <span class="dashboard-menu-icon">
                                <svg class="svg" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                    </use>
                                </svg>
                            </span>
                            <span class="dashboard-menu-head">
                                <?php echo Labels::getLabel("LBL_Sales_Report", $siteLangId); ?>
                            </span>
                            <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                            </i>
                        </button>
                        <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                            <?php if ($userPrivilege->canViewSalesReport(UserAuthentication::getLoggedUserId(), true)) { ?>
                                <li class="menu-sub-item <?php echo ($controller == 'reports' && $action == 'salesreport') ? 'is-active' : ''; ?>">
                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Sales_Over_Time', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Reports', 'SalesReport'); ?>">
                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Sales_Over_Time', $siteLangId); ?></span></a>

                                </li>
                            <?php } ?>
                            <?php if ($userPrivilege->canViewCatalogReport(UserAuthentication::getLoggedUserId(), true)) { ?>
                                <li class="menu-sub-item <?php echo ($controller == 'catalogreport' && $action == 'index') ? 'is-active' : ''; ?>">
                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Products', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('CatalogReport', 'index'); ?>">
                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Products', $siteLangId); ?></span></a>

                                </li>
                            <?php } ?>
                            <?php if ($userPrivilege->canViewFinancialReport(UserAuthentication::getLoggedUserId(), true)) { ?>
                                <li class="dashboard-menu-item">
                                    <span class="menu-head"><?php echo Labels::getLabel("LBL_Financial_Report", $siteLangId); ?></span>

                                </li>
                                <li class="menu-sub-item <?php echo ($controller == 'productprofitreport' && $action == 'index') ? 'is-active' : ''; ?>">
                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Profit_by_products', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('ProductProfitReport'); ?>">
                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Profit_by_products', $siteLangId); ?></span></a>

                                </li>
                                <li class="menu-sub-item <?php echo ($controller == 'payoutreport' && $action == 'index') ? 'is-active' : ''; ?>">
                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Payout', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('PayoutReport'); ?>">
                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Payout', $siteLangId); ?></span></a>

                                </li>
                                <li class="menu-sub-item <?php echo ($controller == 'transactionreport' && $action == 'index') ? 'is-active' : ''; ?>">
                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Transaction_Report', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('TransactionReport'); ?>">
                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Transaction_Report', $siteLangId); ?></span></a>

                                </li>
                            <?php } ?>

                            <li class="dashboard-menu-item">
                                <span class="menu-head"><?php echo Labels::getLabel("LBL_INVENTORY_Reports", $siteLangId); ?></span>

                            </li>
                            <?php if ($userPrivilege->canViewInventoryReport(UserAuthentication::getLoggedUserId(), true)) { ?>
                                <li class="menu-sub-item <?php echo ($controller == 'reports' && $action == 'productsinventory') ? 'is-active' : ''; ?>">
                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Products_Inventory', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Reports', 'productsInventory'); ?>">
                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Products_Inventory', $siteLangId); ?></span></a>

                                </li>
                                <li class="menu-sub-item <?php echo ($controller == 'reports' && $action == 'productsinventorystockstatus') ? 'is-active' : ''; ?>">
                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Products_Inventory_Stock_Status', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Reports', 'productsInventoryStockStatus'); ?>">
                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Products_Inventory_Stock_Status', $siteLangId); ?></span></a>

                                </li>
                            <?php } ?>

                            <?php if ($userPrivilege->canViewPerformanceReport(UserAuthentication::getLoggedUserId(), true)) { ?>
                                <li class="menu-sub-item <?php echo ($controller == 'reports' && $action == 'productsperformance') ? 'is-active' : ''; ?>">
                                    <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Products_Performance', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Reports', 'ProductsPerformance'); ?>">
                                        <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Products_Performance', $siteLangId); ?></span></a>

                                </li>
                            <?php } ?>

                            <li class="divider"></li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel("LBL_Profile", $siteLangId); ?>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>
                    <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                        <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>">
                            <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_My_Account', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'ProfileInfo'); ?>">
                                <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?></span></a>

                        </li>
                        <?php if ($userParentId == UserAuthentication::getLoggedUserId()) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'seller' && ($action == 'users' || $action == 'userpermissions')) ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Sub_Users', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'Users'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Sub_Users", $siteLangId); ?></span></a>

                            </li>
                        <?php } ?>
                        <?php if ($userPrivilege->canViewMessages(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'account' && ($action == 'messages' || strtolower($action) == 'viewmessages')) ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Messages', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'Messages'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Messages", $siteLangId); ?>
                                        <?php if ($todayUnreadMessageCount > 0) { ?>
                                            <span class="msg-count"><?php echo ($todayUnreadMessageCount < 9) ? $todayUnreadMessageCount : '9+'; ?></span>
                                        <?php } ?></span></a>
                            </li>
                        <?php } ?>
                        <?php if ($userParentId == UserAuthentication::getLoggedUserId()) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_My_Credits', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'credits'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_My_Credits', $siteLangId); ?></span></a>

                            </li>
                        <?php } ?>
                        <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'changeemailpassword') ? 'is-active' : ''; ?>">
                            <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_UPDATE_CREDENTIALS', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'changeEmailPassword'); ?>">
                                <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_UPDATE_CREDENTIALS', $siteLangId); ?></span></a>

                        </li>

                        <?php if ($userPrivilege->canViewSellerPlugins(UserAuthentication::getLoggedUserId(), true)) { ?>

                    </ul>
                </li>

                <li class="dashboard-menu-item">

                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel('LBL_Plugins', $siteLangId); ?>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>
                    <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                        <?php foreach (SellerPlugin::getAllowedTypeArr($siteLangId) as $type => $name) {
                                $canUseShippingApi = Shipping::canUseShippingApi(UserAuthentication::getLoggedUserId(0));
                                if (false === $canUseShippingApi && Plugin::TYPE_SHIPPING_SERVICES == $type) {
                                    continue;
                                }
                        ?>
                            <li class="menu-sub-item <?php echo ($controller == 'sellerplugins' && $action == 'index' && is_array($params) && current($params) == $type) ? 'is-active' : ''; ?>">

                                <a class="menu-sub-link" title="<?php echo $name; ?>" href="<?php echo UrlHelper::generateUrl('sellerPlugins', 'index', [$type]); ?>">

                                    <span class="menu-sub-title"><?php echo $name; ?></span>
                                </a>

                            </li>
                    <?php }
                        } ?>
                    <?php if ($userPrivilege->canViewImportExport(UserAuthentication::getLoggedUserId(), true)) { ?>
                    </ul>
                </li>

                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-shop" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#manage-shop">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel('LBL_Import_Export', $siteLangId); ?>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>
                    <ul class="menu-sub menu-sub-accordion collapse" id="nav-shop" aria-labelledby="" data-parent="#nav-shop">
                        <?php if (FatApp::getConfig('CONF_ENABLE_IMPORT_EXPORT', FatUtility::VAR_INT, 0)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'importexport' && ($action == 'index')) ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel('LBL_Import_Export', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('ImportExport', 'index'); ?>"> <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Import_Export', $siteLangId); ?></span></a>

                            </li>
                    </ul>
                </li>
            <?php } ?>
        <?php } ?>
        <?php $this->includeTemplate('_partial/dashboardLanguageArea.php'); ?>
        </ul>

    </div>
</sidebar>