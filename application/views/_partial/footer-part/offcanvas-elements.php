<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if ($controllerName != 'Cart') {
    /* offcanvas-side-cart */
    $this->includeTemplate('_partial/footer-part/cart-summary.php');
} ?>

<!-- Header Search Form -->
<?php $this->includeTemplate('_partial/footer-part/headerSearchFormArea.php'); ?>

<!-- offcanvas-categories-menu -->
<div class="zeynep">
    <ul>
        <li>
            <a href="#">Home</a>
        </li>

        <li class="has-submenu">
            <a href="#" data-submenu="stores">Stores</a>

            <div id="stores" class="submenu">
                <div class="submenu-header" data-submenu-close="stores">
                    <a href="#">Main Menu</a>
                </div>

                <label>Stores</label>

                <ul>
                    <li>
                        <a href="#">Istanbul</a>
                    </li>

                    <li>
                        <a href="#">Mardin</a>
                    </li>

                    <li>
                        <a href="#">Amed</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="has-submenu">
            <a href="#" data-submenu="categories">Categories</a>

            <div id="categories" class="submenu">
                <div class="submenu-header" data-submenu-close="categories">
                    <a href="#">Main Menu</a>
                </div>

                <label>Categories</label>

                <ul>
                    <li class="has-submenu">
                        <a href="#" data-submenu="electronics">Electronics</a>

                        <div id="electronics" class="submenu">
                            <div class="submenu-header" data-submenu-close="electronics">
                                <a href="#">Categories</a>
                            </div>

                            <label>Electronics</label>

                            <ul>
                                <li>
                                    <a href="#">Camera & Photo</a>
                                </li>

                                <li>
                                    <a href="#">Home Audio</a>
                                </li>

                                <li>
                                    <a href="#">Tv & Video</a>
                                </li>

                                <li>
                                    <a href="#">Computers & Accessories</a>
                                </li>

                                <li>
                                    <a href="#">Car & Vehicle Electronics</a>
                                </li>

                                <li>
                                    <a href="#">Portable Audio & Video</a>
                                </li>

                                <li>
                                    <a href="#">Headphones</a>
                                </li>

                                <li>
                                    <a href="#">Accessories & Supplies</a>
                                </li>

                                <li>
                                    <a href="#">Video Projectors</a>
                                </li>

                                <li>
                                    <a href="#">Office Electronics</a>
                                </li>

                                <li>
                                    <a href="#">Wearable Technology</a>
                                </li>

                                <li>
                                    <a href="#">Service Plans</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#">Books</a>
                    </li>

                    <li>
                        <a href="#">Video Games</a>
                    </li>

                    <li>
                        <a href="#">Computers</a>
                    </li>
                </ul>
            </div>
        </li>

        <li>
            <a href="#">Contact</a>
        </li>

        <li>
            <a href="#">About</a>
        </li>
    </ul>
</div>
<div class="zeynep-overlay"></div>

<!-- offcanvas-filters -->
<div class="offcanvas offcanvas-end  offcanvas-filters" tabindex="-1" id="filters-right" aria-labelledby="filters-right">
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