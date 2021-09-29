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
                    $objPrivilege->canViewThemeColor(AdminAuthentication::getLoggedAdminId(), true)
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
                        <?php if ($objPrivilege->canViewGeneralSettings(AdminAuthentication::getLoggedAdminId(), true)) { ?>
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
                                    <span>Display, Sound, notifications, power</span>
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
                                    <h6><?php echo Labels::getLabel('LBL_THEME_SETTINGS', $adminLangId); ?></h6>
                                    <span>Display, Sound, notifications, power</span>
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
                                    <h6><?php echo Labels::getLabel('LBL_CURRENCY_MANAGEMENT', $adminLangId); ?></h6>
                                    <span>Display, Sound, notifications, power</span>
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
                                    <h6><?php echo Labels::getLabel('LBL_COMMISSION_SETTINGS', $adminLangId); ?></h6>
                                    <span>Display, Sound, notifications, power</span>
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
                                    <h6><?php echo Labels::getLabel('LBL_AFFILIATE_COMMISSION_SETTINGS', $adminLangId); ?></h6>
                                    <span>Display, Sound, notifications, power</span>
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
                                    <h6><?php echo Labels::getLabel('LBL_SELLER_PACKAGES_MANAGEMENT', $adminLangId); ?></h6>
                                    <span>Display, Sound, notifications, power</span>
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