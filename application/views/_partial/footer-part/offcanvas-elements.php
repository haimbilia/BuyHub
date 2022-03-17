<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if ($controllerName != 'Cart') {
    /* offcanvas-side-cart */
    $this->includeTemplate('_partial/footer-part/cart-summary.php');
} ?>

<!-- Header Search Form -->
<?php $this->includeTemplate('_partial/footer-part/headerSearchFormArea.php'); ?>

<!-- offcanvas-filters -->
<div class="offcanvas offcanvas-end  offcanvas-filters" tabindex="-1" id="filters-right" aria-labelledby="filters-right">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Offcanvas right</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body productFiltersJs">
    </div>
</div>

<!-- offcanvas-account -->
<div class="offcanvas offcanvas-account offcanvas-start" tabindex="-1" id="offcanvas-account">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Profile </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="profile">
            <div class="profile-image">
                <img class="profile-avatar" width="80" height="80" src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_2.jpg" alt="">
            </div>
            <div class="profile-data">
                <h6 class="profile-name">Hi, Michael Williams </h6>
                <p class="profile-email">pawan.kumar.dz@ablysoft.com</p>
                <p class="profile-phone">+91 9888881405</p>
            </div>

        </div>

        <ul class="account-nav">
            <li class="account-nav-item">
                <a class="account-nav-link" href="">Orders <i class="icon icon-arrow-right"></i></a>
            </li>
            <li class="account-nav-item">
                <a class="account-nav-link" href="">Offers & Rewards <i class="icon icon-arrow-right"></i></a>
            </li>
            <li class="account-nav-item">
                <a class="account-nav-link" href="">General <i class="icon icon-arrow-right"></i></a>
            </li>
            <li class="account-nav-item">
                <a class="account-nav-link" href="">Profile <i class="icon icon-arrow-right"></i></a>
            </li>
            <li class="account-nav-item">
                <a class="account-nav-link" href=""> Language <i class="icon icon-arrow-right"></i></a>
            </li>
            <li class="account-nav-item">
                <a class="account-nav-link" href=""> Currency <i class="icon icon-arrow-right"></i></a>
            </li>

        </ul>
    </div>
    <div class="offcanvas-foot">
        <button class="btn btn-logout" type="button">
            <i class="icn">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#logout">
                    </use>
                </svg>
            </i>
            logout</button>
    </div>
</div>

<!-- offcanvas-gps-location -->
<div class="offcanvas offcanvas-gps-location offcanvas-bottom" tabindex="-1" id="offcanvas-gps-location">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"> </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="geo-location">
            <div class="geo-location_inner">
                <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
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
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#location">
                                </use>
                            </svg>

                            <div class="geo-location-selected">
                                <?php echo $geoAddress; ?>
                            </div>
                        </button>
                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-anim geo-location_dropdown-menu" aria-labelledby="location-dropdown">
                            <div class="geo-location_body"> <input autocomplete="no" id="ga-autoComplete-header" class="geo-location_input pac-target-input" title="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" placeholder="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" type="text" name="location" value="<?php echo $geoAddress; ?>">
                                <!-- <div class="or">
                                        <span>Or</span>
                                    </div> -->
                                <button onclick="loadGeoLocation()" class="btn btn-brand btn-block btn-detect">

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
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Blog Search Form -->
<?php $this->includeTemplate('_partial/footer-part/blog-search-form.php'); ?>