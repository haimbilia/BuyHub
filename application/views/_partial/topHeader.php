<div class="wrapper">
    <?php if (FatApp::getConfig('CONF_LOADER', FatUtility::VAR_INT, 0)) { ?>
        <div class="page-loader">
            <span><?php echo Labels::getLabel('LBL_Loading...'); ?><i class="loader-line"></i></span>
        </div>
    <?php } ?>
    <!--header start here-->
    <header id="header" class="header no-print">
        <?php if (FatApp::getConfig('CONF_AUTO_RESTORE_ON', FatUtility::VAR_INT, 1) && CommonHelper::demoUrl()) {
            $this->includeTemplate('restore-system/top-header.php');
        } ?>
        <div class="top-bar no-print">
            <div class="container">
                <div class="top-bar__inner">
                    <div class="top-bar__left">
                        <div class="logo">
                            <a href="<?php echo UrlHelper::generateUrl(); ?>">
                                <?php
                                $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
                                $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                                $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                                $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                ?>
                                <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>">
                            </a>
                        </div>
                        <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
                            <div class="geo-location">
                                <div class="geo-location_inner">
                                    <div class="dropdown">
                                        <?php
                                        $geoAddress = '';
                                        if ((!isset($_COOKIE['_ykGeoLat']) || !isset($_COOKIE['_ykGeoLng']) || !isset($_COOKIE['_ykGeoCountryCode'])) && FatApp::getConfig('CONF_DEFAULT_GEO_LOCATION', FatUtility::VAR_INT, 0)) {
                                            $geoAddress = FatApp::getConfig('CONF_GEO_DEFAULT_ADDR', FatUtility::VAR_STRING, '');
                                            if (empty($address)) {
                                                $address = FatApp::getConfig('CONF_GEO_DEFAULT_ZIPCODE', FatUtility::VAR_INT, 0) . '-' . FatApp::getConfig('CONF_GEO_DEFAULT_STATE', FatUtility::VAR_STRING, '');
                                            }
                                        }
                                        if (empty($geoAddress)) {
                                            $geoAddress = Labels::getLabel("LBL_Location", $siteLangId);
                                        }
                                        $geoAddress =  isset($_COOKIE["_ykGeoAddress"]) ? $_COOKIE["_ykGeoAddress"] : $geoAddress;
                                        ?>
                                        <button class="button-geo-location geo-location_trigger" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            <svg class="svg" width="18" height="18">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#gps">
                                                </use>
                                            </svg>

                                            <div class="geo-location-selected">
                                                <?php echo $geoAddress; ?>
                                            </div>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-anim geo-location_dropdown-menu">
                                            <div class="geo-location_body">
                                                <?php $value = ($geoAddress == Labels::getLabel("LBL_LOCATION", $siteLangId)) ? "" : $geoAddress; ?>
                                                <input autocomplete="no" id="ga-autoComplete-header" class="geo-location_input pac-target-input" title="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" placeholder="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" type="search" name="location" value="<?php echo $value; ?>">

                                                <button onclick="loadGeoLocation()" class="btn btn-outline-gray btn-block btn-detect">
                                                    <svg class="svg" width="18" height="18">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#gps">
                                                        </use>
                                                    </svg>
                                                    <span class="txt">
                                                        <?php echo Labels::getLabel('LBL_DETECT_MY_CURRENT_LOCATION', $siteLangId); ?>
                                                    </span>
                                                </button>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="top-bar__right">
                        <ul class="quick-nav">
                            <?php $this->includeTemplate('_partial/headerUserArea.php', ['layoutType' => applicationConstants::SCREEN_DESKTOP]); ?>
                            <li class="quick-nav-item item-desktop wishListJs">
                                <button class="quick-nav-link button-store" type="button">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#wishlist">
                                        </use>
                                    </svg>
                                    <span class="txt"><?php echo FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) ? Labels::getLabel('NAV_WISHLIST', $siteLangId) : Labels::getLabel('LBL_FAVORITES', $siteLangId); ?></span>
                                </button>
                            </li>
                            <li class="quick-nav-item item-mobile">
                                <button class="quick-nav-link btn-mega-search toggle--search" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#mega-nav-search" aria-label="mega-nav-search">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#magnifying">
                                        </use>
                                    </svg>
                                </button>
                            </li>
                            <?php if ($controllerName != 'Cart' && (User::isBuyer(true) || (!UserAuthentication::isUserLogged()))) { ?>
                                <li class="quick-nav-item" id="cartSummaryJs">
                                    <button class="quick-nav-link button-cart" type="button" data-bs-toggle="offcanvas" data-bs-target="#sideCartJs">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#cart"></use>
                                        </svg>
                                        <span class="cart-qty">
                                            <?php
                                            $cartObj = new Cart();
                                            echo (Cart::CART_MAX_DISPLAY_QTY < $cartObj->countProducts()) ? Cart::CART_MAX_DISPLAY_QTY . '+' : $cartObj->countProducts(); ?>
                                        </span>
                                        <span class="txt">
                                            <?php echo Labels::getLabel("LBL_MY_BAG", $siteLangId); ?>
                                        </span>
                                    </button>
                                </li>
                            <?php }
                            if (CommonHelper::demoUrl()) { ?>
                                <li class="quick-nav-item item-desktop quick-nav-pipe">
                                    <a class="quick-nav-link btn-cta-outline" href="https://www.yo-kart.com/request-demo.html" rel="noopener" title="Get a Free demo of Yo!Kart system by an expert"> Request a Demo </a>
                                </li>
                                <li class="quick-nav-item item-desktop">
                                    <a class="quick-nav-link btn-cta" href="https://www.yo-kart.com/contact-us.html?demo-cta" rel="noopener" target="_blank" title="Connect with Yo!Kart team to build a Multivendor Marketplace">Start Your Marketplace</a>
                                </li>

                            <?php } ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-bar no-print">
            <div class="container">
                <div class="main-bar__inner">
                    <?php $this->includeTemplate('_partial/headerNavigation.php', ['layoutType' => applicationConstants::SCREEN_DESKTOP]); ?>
                    <div class="main-search">
                        <button class="btn-mega-search toggle--search" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#mega-nav-search">
                            <svg class="svg" width="20" height="20">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#magnifying">
                                </use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>