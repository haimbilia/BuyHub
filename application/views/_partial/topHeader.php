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
                <li><a href="http://getie.com" target="_blank" rel="noopener noreferrer"><i class="icn internetexplorer"></i>
                        <p><strong>Internet Explorer</strong><br>
                            <span>Get the latest version</span>
                        </p>
                    </a></li>
            </ul>
        </div>
    </div>
</div>
<div class="wrapper">
    <?php if (FatApp::getConfig('CONF_LOADER', FatUtility::VAR_INT, 0)) { ?>
        <div id="loader-wrapper">
            <div class="yokart-loader"><img alt="" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/yokart-loader.svg">
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
                        <div class="nav-toggle"></div>
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
                        <div class="geo-location">
                            <div class="geo-location_inner">
                                <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) { ?>
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
                                            <i class="icn">
                                                <svg class="svg" width="18" height="18">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#location">
                                                    </use>
                                                </svg>
                                            </i>
                                            <div class="geo-location-selected">
                                                <?php echo $geoAddress; ?>
                                            </div>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-anim geo-location_dropdown-menu" aria-labelledby="location-dropdown">
                                            <div class="geo-location_body">
                                                <button onclick="loadGeoLocation()" class="btn btn-brand btn-block btn-detect">
                                                    <i class="icn">
                                                        <svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#gps">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                    <span class="txt">
                                                        <?php echo Labels::getLabel('LBL_DETECT_MY_CURRENT_LOCATION', $siteLangId); ?>
                                                    </span>
                                                </button>
                                                <div class="or">
                                                    <span>Or</span>
                                                </div>
                                                <input autocomplete="no" id="ga-autoComplete-header" class="form-control  geo-location_input pac-target-input" title="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" placeholder="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" type="text" name="location" value="<?php echo $geoAddress; ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="top-bar__right">
                        <ul class="quick-nav">
                            <li class="quick-nav-item">
                                <button type="button" class="quick-nav-link button-store">
                                    <i class="icn">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#store">
                                            </use>
                                        </svg>

                                    </i>
                                    <span class="txt">Open A Store</span>
                                </button>
                            </li>
                            <!-- <?php $this->includeTemplate('_partial/headerTopNavigation.php'); ?> -->

                            <?php $this->includeTemplate('_partial/headerUserArea.php'); ?>
                            <li class="quick-nav-item">
                                <div id="cartSummary">
                                    <?php if ($controllerName != 'Cart') { ?>
                                        <?php $this->includeTemplate('_partial/headerWishListAndCartSummary.php'); ?>

                                    <?php } ?>
                                </div>

                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="main-bar no-print">
            <div class="container">
                <div class="main-bar__inner">
                    <?php $this->includeTemplate('_partial/headerNavigation.php'); ?>
                    <?php $this->includeTemplate('_partial/headerSearchFormArea.php'); ?>
                </div>
            </div>
        </div>
    </header>
    <div class="offcanvas offcanvas-mega-search" id="mega-nav-search" aria-labelledby="mega-nav-searchLabel">
        <div class="mega-search">
            <form action="" class="form mega-search-form">
                <input class="mega-search-input search--keyword--js no--focus" placeholder="I Am Looking For..." id="header_search_keyword" data-field-caption="I Am Looking For..." data-fatreq="{&quot;required&quot;:false}" type="search" name="keyword" value="">
                <div class="search-suggestions" id="tagsSuggetionList">
                    <ul class="text-suggestions">
                        <li class="text-suggestions-item">
                            <a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone">
                                <span class="text-suggestions-span"><b>iph</b>one</span></a>
                        </li>
                        <li class="text-suggestions-item">
                            <a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone5s">
                                <span class="text-suggestions-span"><b>iph</b>one5s</span></a>
                        </li>
                        <li class="text-suggestions-item">
                            <a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone5"><span class="text-suggestions-span"><b>iph</b>one5</span></a>
                        </li>
                        <li class="text-suggestions-item"><a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone 6"><span class="text-suggestions-span"><b>iph</b>one 6</span></a></li>
                        <li class="text-suggestions-item"><a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone 6"><span class="text-suggestions-span"><b>iph</b>one 6</span></a></li>
                        <li class="text-suggestions-item"><a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone 6s"><span class="text-suggestions-span"><b>iph</b>one 6s</span></a></li>
                        <li class="text-suggestions-item"><a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone"><span class="text-suggestions-span"><b>iph</b>one</span></a></li>
                        <li class="text-suggestions-item"><a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone 6s plus"><span class="text-suggestions-span"><b>iph</b>one 6s plus</span></a></li>
                        <li class="text-suggestions-item"><a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone"><span class="text-suggestions-span"><b>iph</b>one</span></a></li>
                        <li class="text-suggestions-item"><a class="text-suggestions-link" href="javascript:void(0)" onclick="searchTags(this)" data-txt="iPhone 7"><span class="text-suggestions-span"><b>iph</b>one 7</span></a></li>
                    </ul>
                    <div class="matched">
                        <h6 class="suggestions-title">Matching Categories</h6>
                        <ul class="text-suggestions matched-category">
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/action-figures"><span class="text-suggestions-span">Action Figures</span></a></li>
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/men-sports-wear"><span class="text-suggestions-span">Sports Wear</span></a></li>
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/mobiles-mobile-cases"><span class="text-suggestions-span">Mobile Cases</span></a></li>
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/electronics"><span class="text-suggestions-span">Electronics</span></a></li>
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/gaming-consoles-ps4"><span class="text-suggestions-span">PS4</span></a></li>
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/mobiles"><span class="text-suggestions-span">Mobiles</span></a></li>
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/clothing"><span class="text-suggestions-span">Clothing</span></a></li>
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/puzzles"><span class="text-suggestions-span">Puzzles</span></a></li>
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/clothing-trousers"><span class="text-suggestions-span">Trousers</span></a></li>
                            <li class="text-suggestions-item"><a class="text-suggestions-link" href="/men-sports-wear-track-suits"><span class="text-suggestions-span">Track Suits</span></a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>