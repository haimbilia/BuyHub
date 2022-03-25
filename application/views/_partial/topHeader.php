<div class="outdated">
    <div class="outdated-inner">
        <div class="outdated-messages">
            <div class="heading">The browser you are using is not supported. Some critical security features are not
                available for your
                browser version.</div>
            <div class="para">We want you to have the best possible experience with
                <?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, ''); ?>.
                For this you'll need to use a supported browser and upgrade to the latest version. </div>
            <ul class="list-browser">
                <li><a href="https://www.google.com/chrome" target="_blank" rel="noopener noreferrer"><i class="icn chrome"></i>
                        <p><strong>Chrome</strong><br>
                            <span>Get the latest version</span>
                        </p>
                    </a></li>
                <li><a href="https://getfirefox.com" target="_blank" rel="noopener noreferrer"><i class="icn firefox"></i>
                        <p><strong>Firefox</strong><br>
                            <span>Get the latest version</span>
                        </p>
                    </a></li>
                <li><a href="http://support.apple.com/downloads/#safari" target="_blank" rel="noopener noreferrer"><i class="icn safari"></i>
                        <p><strong>Safari</strong><br>
                            <span>Get the latest version</span>
                        </p>
                    </a></li>
                <li>
                    <a href="http://getie.com" target="_blank" rel="noopener noreferrer"><i class="icn internetexplorer"></i>
                        <p><strong>Internet Explorer</strong><br>
                            <span>Get the latest version</span>
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="wrapper">
    <?php if (FatApp::getConfig('CONF_LOADER', FatUtility::VAR_INT, 0)) { ?>
        <div id="loader-wrapper">
            <div class="yokart-loader">
                <img alt="" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/yokart-loader.svg">
            </div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
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
                                <img width="120" height="68" <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>">
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
                                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-anim geo-location_dropdown-menu" aria-labelledby="location-dropdown">
                                            <div class="geo-location_body">
                                                <input autocomplete="no" id="ga-autoComplete-header" class="geo-location_input pac-target-input" title="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" placeholder="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" type="text" name="location" value="<?php echo $geoAddress; ?>">

                                                <!-- <div class="or">
                                                    <span>Or</span>
                                                </div> -->
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
                            <!-- <?php $this->includeTemplate('_partial/headerTopNavigation.php'); ?> -->
                            <?php $this->includeTemplate('_partial/headerUserArea.php', ['layoutType' => applicationConstants::SCREEN_DESKTOP]); ?>
                            <li class="quick-nav-item item-desktop">
                                <button type="button" class="quick-nav-link button-store">

                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#wishlist">
                                        </use>
                                    </svg>

                                    <span class="txt" onclick="wishlistBox()"><?php echo Labels::getLabel('NAV_WISHLIST', $siteLangId); ?></span>
                                </button>
                            </li>
                            <li class="quick-nav-item item-mobile">
                                <button class="btn-mega-search" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#mega-nav-search" aria-controls="offcanvas-mega-search">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#magnifying">
                                        </use>
                                    </svg>

                                </button>
                            </li>
                            <?php if ($controllerName != 'Cart' && (User::isBuyer(true) || (!UserAuthentication::isUserLogged()))) { ?>
                                <li class="quick-nav-item">
                                    <button type="button" class="quick-nav-link button-cart" data-bs-toggle="offcanvas" data-bs-target="#side-cart" aria-controls="side-cart">

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
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-bar no-print">
            <div class="container">
                <div class="main-bar__inner">
                    <?php $this->includeTemplate('_partial/headerNavigation.php'); ?>
                    <div class="main-search">
                        <button class="btn-mega-search" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#mega-nav-search" aria-controls="offcanvas-mega-search">

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
    <!-- Mobile menu -->
    <ul class="mobile-actions">
        <li class="mobile-actions-item" role="none">
            <a class="mobile-actions-link" href="#">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-home">
                    </use>
                </svg>
                <span class="txt">Home</span>
            </a>
        </li>
        <li class="mobile-actions-item" role="none">
            <button type="button" class="mobile-actions-link btn-open first">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-category">
                    </use>
                </svg>
                <span class="txt">Open!</span>
            </button>



        </li>
        <li class="mobile-actions-item active" role="none">
            <button class="mobile-actions-link btn-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#categories-menu" aria-controls="categories-menu">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-category">
                    </use>
                </svg>
                <span class="txt">Category</span>
            </button>
        </li>
        <li class="mobile-actions-item" role="none">
            <button class="mobile-actions-link">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-wishlist">
                    </use>
                </svg>
                <span class="txt">Wishlist</span>
            </button>
        </li>
        <li class="mobile-actions-item" role="none">
            <button class="mobile-actions-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-account" aria-controls="offcanvas-account">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-account">
                    </use>
                </svg>
                <span class="txt">Account</span>
            </button>
        </li>
        <li class="mobile-actions-item" role="none">
            <button class="mobile-actions-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-gps-location" aria-controls="offcanvas-gps-location">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#mbl-location">
                    </use>
                </svg>
                <span class="txt">Location</span>
            </button>
        </li>
    </ul>