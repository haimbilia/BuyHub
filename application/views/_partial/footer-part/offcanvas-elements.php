<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$this->includeTemplate('_partial/footer-part/headerSearchFormArea.php'); ?>

<div class="zeynep">
    <?php
    $this->includeTemplate('_partial/headerNavigation.php', ['layoutType' => applicationConstants::SCREEN_MOBILE]); ?>
</div>
<div class="zeynep-overlay"></div>

<?php if (!in_array($controllerName, ['Cart', 'Checkout'])) { ?>
    <?php $this->includeTemplate('_partial/cart-summary.php', ['showHeaderButton' => false]); ?>
<?php } ?>

<?php
if (FatApp::getConfig('CONF_LAYOUT_MEGA_MENU', FatUtility::VAR_INT, 1) == Navigations::LAYOUT_MEGA_MENU) {
    $headerCategories = CacheHelper::get('headerCategories_' . $siteLangId, CONF_HOME_PAGE_CACHE_TIME, '.txt');
    if ($headerCategories) {
        $headerCategories = unserialize($headerCategories);
    } else {
        $headerCategories = ProductCategory::getArray($siteLangId, 0, false, true, false, CONF_USE_FAT_CACHE);
        CacheHelper::create('headerCategories_' . $siteLangId, serialize($headerCategories), CacheHelper::TYPE_NAVIGATION);
    }

    if (0 < count($headerCategories)) { ?>
        <div class="offcanvas offcanvas-start offcanvas-categories-menu" tabindex="-1" id="offcanvas-hamburger" aria-labelledby="offcanvas-hamburger-Label">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvas-hamburger-Label"><?php echo Labels::getLabel('NAV_ALL_CATEGORIES', $siteLangId); ?></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <nav id="stack-menu">
                    <ul>
                        <?php
                        $count = 0;
                        $getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
                        foreach ($headerCategories as $link) {
                            $count++;
                            if ($count > 9) {
                                break;
                            }

                            $navUrl = UrlHelper::generateUrl('category', 'view', array($link['prodcat_id']));
                            $OrgnavUrl = UrlHelper::generateUrl('category', 'view', array($link['prodcat_id']), '', null, false, $getOrgUrl);

                            $href = $navUrl;
                            $navchild = '';
                            $class = '';
                        ?>
                            <li>
                                <a href="<?php echo $href; ?>"><?php echo $link['prodcat_name']; ?></a>
                                <?php if (isset($link['children']) && count($link['children']) > 0) { ?>
                                    <ul>
                                        <?php $subyChild = 0;
                                        foreach ($link['children'] as $children) {
                                            $subCatUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']));
                                            $subCatOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                        ?>
                                            <li>
                                                <a href="<?php echo $subCatUrl; ?>"><?php echo $children['prodcat_name']; ?></a>
                                                <?php if (isset($children['children']) && count($children['children']) > 0) { ?>
                                                    <ul>
                                                        <?php $subChild = 0;
                                                        foreach ($children['children'] as $childCat) {
                                                            $catUrl = UrlHelper::generateUrl('category', 'view', array($childCat['prodcat_id']));
                                                            $catOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                                        ?>
                                                            <li><a href="<?php echo $catUrl; ?>"><?php echo $childCat['prodcat_name']; ?></a></li>
                                                            <?php
                                                            if ($subChild++ == 4) {
                                                                break;
                                                            }
                                                        }
                                                        if (count($children['children']) > 5) { ?>
                                                            <li class="seemore"><a href="<?php echo $subCatUrl; ?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?></a></li>
                                                        <?php }   ?>
                                                    </ul>
                                                <?php } ?>
                                            </li>
                                            <?php
                                            if ($subyChild++ == 7) {
                                                break;
                                            }
                                        }

                                        if (count($link['children']) > 6) { ?>
                                            <li class="seemore"><a href="<?php echo $navUrl; ?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?></a></li>
                                        <?php }   ?>
                                    </ul>
                                <?php  } ?>
                            </li>
                        <?php } ?>
                        <li class="seemore"><a href="<?php echo UrlHelper::generateUrl('Category'); ?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?></a></li>
                    </ul>
                </nav>

            </div>
        </div>
<?php }
} ?>
<script>
    $(document).ready(function() {
        $("#stack-menu").stackMenu()
    });
</script>

<div class="offcanvas offcanvas-end offcanvas-filters" tabindex="-1" id="filters-right">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body productFiltersJs">
    </div>
</div>

<?php if ((!UserAuthentication::isUserLogged() && UserAuthentication::isGuestUserLogged()) ||  UserAuthentication::isUserLogged()) {
    $this->includeTemplate('_partial/headerUserArea.php', ['layoutType' => applicationConstants::SCREEN_MOBILE]);
}

if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
    <div class="offcanvas offcanvas-bottom offcanvas-gps-location" tabindex="-1" id="offcanvas-gps-location">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><?php echo Labels::getLabel('LBL_CHANGE_LOCATION', $siteLangId); ?></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="geo-location-mobile">
                <div class="geo-location_inner">
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
                    <div class="geo-location_dropdown-menu">
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
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (in_array($controllerName, ['Supplier', 'GuestAffiliate', 'GuestAdvertiser']) && in_array($action, ['index', 'account'])) {
    $this->includeTemplate('_partial/footer-part/mobile-header-top-navigation.php', ['liClass' => 'seller-nav-item', 'aClass' => 'seller-nav-link']);
} ?>

<?php if ('Blog' == $controllerName) {
    $this->includeTemplate('_partial/footer-part/blog-search-form.php', ['siteLangId' => $siteLangId]);
    $this->includeTemplate('_partial/footer-part/blog-mobile-menu.php', ['siteLangId' => $siteLangId]);
} ?>