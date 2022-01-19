<?php
$controller = strtolower($controller);
$action = strtolower($action);
?> 
<sidebar class="sidebar no-print">
    <?php require CONF_THEME_PATH . '_partial/dashboardNavigationTop.php'; ?>
    <div class="sidebar__content custom-scrollbar scroll scroll-y" id="scrollElement-js">
        <ul class="dashboard-menu">
            <?php if (User::canViewAdvertiserTab() && $userPrivilege->canViewPromotions(0, true)) { ?>
                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-promotions" aria-expanded="true" aria-controls="collapseOne" title="">
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
                        <li class="menu-sub-item <?php echo ($controller == 'advertiser' && ($action == 'promotions' || $action == 'viewpromotions')) ? 'is-active' : ''; ?>">
                            <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_My_Promotions", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('advertiser', 'promotions'); ?>">
                                <span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Promotions", $siteLangId); ?></span></a>
                        </li>
                        <li class="menu-sub-item <?php echo ($controller == 'advertiser' && ($action == 'promotioncharges' || $action == 'viewpromotions')) ? 'is-active' : ''; ?>">
                            <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Promotion_Charges", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('advertiser', 'promotionCharges'); ?>">
                                <span class="menu-item__title"><?php echo Labels::getLabel("LBL_Promotion_Charges", $siteLangId); ?></span></a>
                        </li>
                        <?php if ($userParentId == UserAuthentication::getLoggedUserId()) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_My_Credits", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'credits'); ?>">
                                    <span class="menu-item__title"><?php echo Labels::getLabel('LBL_My_Credits', $siteLangId); ?></span></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <li class="dashboard-menu-item">
                <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-profile" aria-expanded="true" aria-controls="collapseOne" title="">
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
                    <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'ProfileInfo'); ?>">
                            <span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?></span></a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'changeemailpassword') ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_UPDATE_CREDENTIALS", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'changeEmailPassword'); ?>">
                            <span class="menu-item__title"><?php echo Labels::getLabel('LBL_UPDATE_CREDENTIALS', $siteLangId); ?></span></a>
                    </li>
                </ul>
            </li>
            <?php $this->includeTemplate('_partial/dashboardLanguageArea.php'); ?>
        </ul>
    </div>
</sidebar>