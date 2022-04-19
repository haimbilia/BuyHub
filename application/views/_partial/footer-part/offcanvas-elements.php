<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<!-- Header Search Form -->
<?php $this->includeTemplate('_partial/footer-part/headerSearchFormArea.php'); ?>


<div class="zeynep">
    <?php $this->includeTemplate('_partial/headerNavigation.php', ['layoutType' => applicationConstants::SCREEN_MOBILE]); ?>

</div>
<div class="zeynep-overlay"></div>



<!-- offcanvas-filters -->
<div class="offcanvas offcanvas-end offcanvas-filters" tabindex="-1" id="filters-right" aria-labelledby="filters-right">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body productFiltersJs">
    </div>
</div>
<!-- offcanvas-account -->
<?php
if ((!UserAuthentication::isUserLogged() && UserAuthentication::isGuestUserLogged()) ||  UserAuthentication::isUserLogged()) {
    $this->includeTemplate('_partial/headerUserArea.php', ['layoutType' => applicationConstants::SCREEN_MOBILE]);
}
?>
<!-- offcanvas-gps-location -->
<div class="offcanvas offcanvas-bottom offcanvas-gps-location" tabindex="-1" id="offcanvas-gps-location">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"><?php echo Labels::getLabel('LBL_CHANGE_LOCATION', $siteLangId); ?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="geo-location-mobile">
            <div class="geo-location_inner">
                <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>

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
                    <button class="button-geo-location geo-location_trigger" type="button" data-bs-toggle="collapse" data-bs-target="#geo-location-mobile" aria-expanded="false" aria-controls="geo-location-mobile">

                        <svg class="svg" width="18" height="18">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#gps">
                            </use>
                        </svg>

                        <div class="geo-location-selected">
                            <?php echo $geoAddress; ?>
                        </div>
                    </button>
                    <div class="collapse geo-location_dropdown-menu" id="geo-location-mobile">
                        <div class="geo-location_body"> <input autocomplete="no" id="ga-autoComplete-mobile" class="geo-location_input pac-target-input" title="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" placeholder="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" type="text" name="location" value="<?php echo $geoAddress; ?>">
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

                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- offcanvas-seller-nav -->
<div class="offcanvas offcanvas-start offcanvas-seller-nav" tabindex="-1" id="offcanvas-seller-nav" aria-labelledby="offcanvas-seller-nav">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="seller-nav">
            <li class="seller-nav-item">
                <a class="seller-nav-link" href="#">About Us </a>
            </li>
            <li class="seller-nav-item">
                <a class="seller-nav-link" href="#">Privacy Policy</a>
            </li>
            <li class="seller-nav-item">
                <a class="seller-nav-link" href="#">Terms and Conditions</a>
            </li>
            <li class="seller-nav-item">
                <a class="seller-nav-link" href="#">4th Tab</a>
            </li>
            <li class="seller-nav-item">
                <a class="seller-nav-link" href="#">Seller Nav 1</a>
            </li>
            <li class="seller-nav-item">
                <a class="seller-nav-link" href="#">Seller Nav 1</a>
            </li>

        </ul>

    </div>
</div>


<!-- Blog Search Form -->
<?php $this->includeTemplate('_partial/footer-part/blog-search-form.php'); ?>