<?php
$controller = strtolower($controller);
$action = strtolower($action);
?>
<sidebar class="sidebar no-print">
    <?php require CONF_THEME_PATH . '_partial/dashboardNavigationTop.php'; ?>
    <div class="sidebar-body sidebarMenuJs" id="scrollElement-js">
        <ul class="dashboard-menu">
            <?php if (User::canViewAdvertiserTab() && $userPrivilege->canViewPromotions(0, true)) { ?>
                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn menuLinkJs dropdown-toggle-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav-promotions" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#my-promotions">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel('LBL_Promotions', $siteLangId); ?>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>
                    <ul class="menu-sub menu-sub-accordion collapse" id="nav-promotions" aria-labelledby="" data-parent="#dashboard-menu">
                        <li class="menu-sub-item">
                            <a class="menu-sub-link navLinkJs <?php echo ($controller == 'advertiser' && ($action == 'promotions' || $action == 'viewpromotions')) ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_My_Promotions", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('advertiser', 'promotions'); ?>">
                                <span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Promotions", $siteLangId); ?></span></a>
                        </li>
                        <li class="menu-sub-item">
                            <a class="menu-sub-link navLinkJs <?php echo ($controller == 'advertiser' && ($action == 'promotioncharges' || $action == 'viewpromotions')) ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_Promotion_Charges", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('advertiser', 'promotionCharges'); ?>">
                                <span class="menu-item__title"><?php echo Labels::getLabel("LBL_Promotion_Charges", $siteLangId); ?></span></a>
                        </li>
                        <?php if ($userParentId == UserAuthentication::getLoggedUserId()) { ?>
                            <li class="menu-sub-item">
                                <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_My_Credits", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'credits'); ?>">
                                    <span class="menu-item__title"><?php echo Labels::getLabel('LBL_My_Credits', $siteLangId); ?></span></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <li class="dashboard-menu-item">
                <button class="dashboard-menu-btn menuLinkJs dropdown-toggle-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav-profile" aria-expanded="true" aria-controls="collapseOne" title="">
                    <span class="dashboard-menu-icon">
                        <svg class="svg" width="18" height="18">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#my-account">
                            </use>
                        </svg>
                    </span>
                    <span class="dashboard-menu-head">
                        <?php echo Labels::getLabel('LBL_Profile', $siteLangId); ?>
                    </span>
                    <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                    </i>
                </button>
                <ul class="menu-sub menu-sub-accordion collapse" id="nav-profile" aria-labelledby="" data-parent="#dashboard-menu">
                    <li class="menu-sub-item">
                        <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'ProfileInfo'); ?>">
                            <span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?></span></a>
                    </li>
                    <?php if (!User::isAffiliate()) { ?>
                        <li class="menu-sub-item">
                            <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && ($action == 'bankInfoForm')) ? 'active' : ''; ?>" title="<?php echo Labels::getLabel('LBL_BANK_ACCOUNT', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('account', 'bankInfoForm'); ?>">
                                <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_BANK_ACCOUNT", $siteLangId); ?></span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1)) { ?>
                        <li class="menu-sub-item">
                            <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && ($action == 'cookiesPreferencesForm')) ? 'active' : ''; ?>" title="<?php echo Labels::getLabel('LBL_COOKIE_PREFERENCES', $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('account', 'cookiesPreferencesForm'); ?>">
                                <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_COOKIE_PREFERENCES", $siteLangId); ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="menu-sub-item">
                        <a class="menu-sub-link navLinkJs <?php echo ($controller == 'account' && $action == 'changeemailpassword') ? 'is-active' : ''; ?>" title="<?php echo Labels::getLabel("LBL_UPDATE_CREDENTIALS", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'changeEmailPassword'); ?>">
                            <span class="menu-item__title"><?php echo Labels::getLabel('LBL_UPDATE_CREDENTIALS', $siteLangId); ?></span></a>
                    </li>
                </ul>
            </li>
            <?php $this->includeTemplate('_partial/dashboardLanguageArea.php'); ?>
        </ul>
    </div>
    <div class="sidebar-foot">
        <ul class="dashboard-menu">
            <li class="dashboard-menu-item">
                <button class="dashboard-menu-btn menuLinkJs" type="button" title="">
                    <span class="dashboard-menu-icon">
                        <svg class="svg" width="18" height="18">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#globe">
                            </use>
                        </svg>
                    </span>
                    <span class="dashboard-menu-head">
                        <?php echo Labels::getLabel('LBL_Localization', $siteLangId); ?>
                    </span>
                </button>
            </li>
        </ul>
    </div>
</sidebar>
<main id="main-area" class="main">
    <?php $this->includeTemplate('_partial/topHeaderDashboard.php', ['siteLangId' => $siteLangId], false); ?>