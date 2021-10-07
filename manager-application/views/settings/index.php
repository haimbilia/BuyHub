<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$controller = str_replace('Controller', '', FatApp::getController());
?>
<main class="main mainJs">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <?php if (
                    $objPrivilege->canViewGeneralSettings(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewPlugins(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewPaymentMethods(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCurrencyManagement(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCommissionSettings(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewAffiliateCommissionSettings(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellerPackages(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewThemeColor(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewZones(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCountries(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewStates(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewEmptyCartItems(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewAbusiveWords(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>


                    <div class="setting-search">
                        <form class="form">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <input type="search" id="settingsSearch" class="form-control omni-search" name="search" value="" placeholder="<?php echo Labels::getLabel('LBL_SEARCH', $adminLangId); ?>">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="settings settingListJs">
                        <?php /* if ($objPrivilege->canViewGeneralSettings(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('configurations'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_GENERAL_SETTINGS', $adminLangId); ?></h6>
                                    <span>Display, Sound, notifications, power</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewPlugins(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('Plugins'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_PLUGINS', $adminLangId); ?></h6>
                                    <span>Addons, Third party services</span>
                                </div>
                            </a>
                        <?php } */ ?>

                        <?php if ($objPrivilege->canViewLanguageLabels(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('Labels'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_LABELS', $adminLangId); ?></h6>
                                    <span>Manage application labels</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewThemeColor(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('ThemeColor'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_THEME', $adminLangId); ?></h6>
                                    <span>Fonts, color, styling</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewCurrencyManagement(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('CurrencyManagement'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_CURRENCIES', $adminLangId); ?></h6>
                                    <span>Currency, Symbol, conversions</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewCommissionSettings(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('Commission'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_SITE_COMMISSION', $adminLangId); ?></h6>
                                    <span>Category, Seller, product, commision fees</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewAffiliateCommissionSettings(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('AffiliateCommission'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_AFFILIATE_COMMISSION', $adminLangId); ?></h6>
                                    <span>Category, Users, Commision fees</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewSellerPackages(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('SellerPackages'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_SELLER_PACKAGES', $adminLangId); ?></h6>
                                    <span>Subscription, Packages for seller</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewZones(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('Zones'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_ZONES', $adminLangId); ?></h6>
                                    <span>Manage country zones</span>
                                </div>
                            </a>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewCountries(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('Countries'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_COUNTRIES', $adminLangId); ?></h6>
                                    <span>Addresses, Shipping Rates configuration and Tax rates</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewStates(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('States'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_STATES', $adminLangId); ?></h6>
                                    <span>Addresses, Shipping Rates configuration and Tax rates</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewAbusiveWords(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('AbusiveWords'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_ABUSIVE_KEYWORDS', $adminLangId); ?></h6>
                                    <span>Configure Abusive keywords</span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php if ($objPrivilege->canViewEmptyCartItems(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <a class="setting" href="<?php echo UrlHelper::generateUrl('emptyCartItems'); ?>">
                                <div class="setting__icon">
                                    <span class="icon">
                                        <svg class="icon" width="40" height="40">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-setting-1">
                                            </use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="setting__detail">
                                    <h6><?php echo Labels::getLabel('LBL_EMPTY_CART', $adminLangId); ?></h6>
                                    <span>Items for empty cart page</span>
                                </div>
                            </a>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<script>
    var controllerName = '<?php echo $controller; ?>';
    getHelpCenterContent(controllerName);

    function searhSettings(e) {
        var value = e.val().toLowerCase();
        if (value.length < 1) {
            $(this).show();
            $('.settingListJs').show();
            return;
        }
        $(".settingListJs a").each(function() {
            if ($(this).find('h6').text().toLowerCase().search(value) > -1 || $(this).find('span').text().toLowerCase().search(value) > -1) {
                $(this).show();
                $('.settingListJs').show();
            } else {
                $(this).hide();
                $('.settingListJs').show();
            }
        });
    };

    $(document).on("search", "#settingsSearch", function(e) {
        searhSettings($(this));
    });

    $(document).on("keyup", "#settingsSearch", function(e) {
        searhSettings($(this));
    });
</script>