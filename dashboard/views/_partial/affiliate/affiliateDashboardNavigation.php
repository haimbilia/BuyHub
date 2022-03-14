<?php
$controller = strtolower($controller);
$action = strtolower($action);
?>

<ul class="dashboard-menu">
    <li class="dashboard-menu-item">
        <button class="dashboard-menu-btn menuLinkJs dropdown-toggle-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav-general" aria-expanded="true" aria-controls="collapseOne" title="">
            <span class="dashboard-menu-icon">
                <svg class="svg" width="18" height="18">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#saved-searches">
                    </use>
                </svg>
            </span>
            <span class="dashboard-menu-head">
                <?php echo Labels::getLabel('LBL_GENERAL', $siteLangId); ?>
            </span>
            <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
            </i>
        </button>
        <ul class="menu-sub menu-sub-accordion collapse" id="nav-general" aria-labelledby="" data-parent="#dashboard-menu">
            <?php if (User::canViewAffiliateTab()) { ?>
                <li class="menu-sub-item">
                    <a class="menu-sub-link navLinkJs <?php echo ($controller == 'affiliate' && $action == 'referredbyme') ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_Sharing", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Affiliate', 'ReferredByMe'); ?>">
                        <span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Referral", $siteLangId); ?></span>
                    </a>
                </li>
            <?php } ?>
            <li class="menu-sub-item">
                <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'ProfileInfo'); ?>">
                    <span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?></span>
                </a>
            </li>
            <li class="menu-sub-item">
                <a class="menu-sub-link navLinkJs <?php echo ($controller == 'Affiliate' && ($action == 'paymentInfoForm')) ? 'active' : ''; ?>" title="<?php echo Labels::getLabel('LBL_PAYMENT_INFO', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Affiliate', 'paymentInfoForm'); ?>">
                    <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_PAYMENT_INFO", $siteLangId); ?></span>
                </a>
            </li>
            <?php if (FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1)) { ?>
                <li class="menu-sub-item">
                    <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && ($action == 'cookiesPreferencesForm')) ? 'active' : ''; ?>" title="<?php echo Labels::getLabel('LBL_COOKIE_PREFERENCES', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('account', 'cookiesPreferencesForm'); ?>">
                        <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_COOKIE_PREFERENCES", $siteLangId); ?></span>
                    </a>
                </li>
            <?php } ?>
            <?php if (!User::canViewAffiliateTab()) { ?>
                <li class="menu-sub-item">
                    <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && $action == 'messages') ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_Messages", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'Messages'); ?>">
                        <span class="menu-item__title"><?php echo Labels::getLabel("LBL_Messages", $siteLangId); ?></span></a>
                </li>
            <?php } ?>
            <li class="menu-sub-item">
                <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_My_Credits", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'credits'); ?>">
                    <span class="menu-item__title"><?php echo Labels::getLabel('LBL_My_Credits', $siteLangId); ?></span>
                </a>
            </li>
            <?php if (!User::canViewAffiliateTab()) { ?>
                <li class="menu-sub-item">
                    <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && $action == 'wishlist') ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_Wishlist/Favorites", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'wishlist'); ?>">
                        <span class="menu-item__title"><?php echo Labels::getLabel('LBL_Wishlist/Favorites', $siteLangId); ?></span>
                    </a>
                </li>
            <?php } ?>
            <li class="menu-sub-item">
                <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && $action == 'changeemailpassword') ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel('LBL_UPDATE_CREDENTIALS', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'changeEmailPassword'); ?>">
                    <span class="menu-item__title"><?php echo Labels::getLabel('LBL_UPDATE_CREDENTIALS', $siteLangId); ?></span>
                </a>
            </li>
        </ul>
    </li>
    <?php $this->includeTemplate('_partial/dashboardLanguageArea.php'); ?>
</ul>