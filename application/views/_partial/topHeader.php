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
                <li><a href="https://www.google.com/chrome" target="_blank" rel="noopener noreferrer"><i
                            class="icn chrome"></i>
                        <p><strong>Chrome</strong><br>
                            <span>Get the latest version</span>
                        </p>
                    </a></li>
                <li><a href="https://getfirefox.com" target="_blank" rel="noopener noreferrer"><i
                            class="icn firefox"></i>
                        <p><strong>Firefox</strong><br>
                            <span>Get the latest version</span>
                        </p>
                    </a></li>
                <li><a href="http://support.apple.com/downloads/#safari" target="_blank" rel="noopener noreferrer"><i
                            class="icn safari"></i>
                        <p><strong>Safari</strong><br>
                            <span>Get the latest version</span>
                        </p>
                    </a></li>
                <li><a href="http://getie.com" target="_blank" rel="noopener noreferrer"><i
                            class="icn internetexplorer"></i>
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
                        <div class="location">
                            <div class="location_inner">
                                <div class="dropdown">
                                    <button class="location_trigger" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icn">
                                            <svg class="svg" width="18px" height="18px">
                                                <use
                                                    xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#location">
                                                </use>
                                            </svg>
                                        </i>
                                        <div class="location-selected">140301, Sahibzada Ajit Singh Nagar, Punjab, India
                                        </div>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-anim location_dropdown-menu"
                                        aria-labelledby="location-dropdown">
                                        <div class="location_body">
                                            <button onclick="loadGeoLocation()"
                                                class="btn btn-brand btn-block btn-detect">
                                                <i class="icn">
                                                    <svg class="svg" width="16px" height="16px">
                                                        <use
                                                            xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#gps">
                                                        </use>
                                                    </svg></i>
                                                <span>Detect My Current Location </span></button>
                                            <div class="or">
                                                <span>Or</span>
                                            </div>
                                            <input class="location_input form-control pac-target-input" type="text"
                                                name="location" placeholder="Search For ..." id="ga-autoComplete"
                                                autocomplete="no"
                                                value="140301, Sahibzada Ajit Singh Nagar, Punjab, India">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) { ?>
                        <div class="header-location">
                            <div class="header-location__field">
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
                                <input autocomplete="no" id="ga-autoComplete-header"
                                    class="form-control pac-target-input"
                                    title="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>"
                                    placeholder="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>"
                                    type="text" name="location" value="<?php echo $geoAddress; ?>">
                            </div>
                            <div class="header-location__icon" onclick="loadGeoLocation();">
                                <i class="icn">
                                    <svg class="svg" width="15px" height="15px">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#gps">
                                        </use>
                                    </svg>
                                </i>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="top-bar__right">
                        <div class="short-links">
                            <ul>
                                <?php $this->includeTemplate('_partial/headerTopNavigation.php'); ?>
                                <?php $this->includeTemplate('_partial/headerLanguageArea.php'); ?>
                                <?php $this->includeTemplate('_partial/headerUserArea.php'); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-bar no-print">
            <div class="container">
                <div class="logo-bar">
                    <a class="navs_toggle" href="javascript:void(0)"><span></span></a>
                    <div class="logo">
                        <a href="<?php echo UrlHelper::generateUrl(); ?>">
                            <?php
                            $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
                            $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                            $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                            $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                            ?>
                            <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?>
                                data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?>
                                src="<?php echo $siteLogo; ?>"
                                alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>"
                                title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>">
                        </a>
                    </div>
                    <?php $this->includeTemplate('_partial/headerSearchFormArea.php'); ?>
                    <?php if ($controllerName != 'Cart') { ?>
                    <div class="cart dropdown" id="cartSummary">
                        <?php $this->includeTemplate('_partial/headerWishListAndCartSummary.php'); ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div> <?php $this->includeTemplate('_partial/headerNavigation.php'); ?>
    </header>
    <div class="after-header no-print"></div>
    <!--header end here-->
    <!--body start here-->