<?php $siteLangId = CommonHelper::getLangId(); ?>
<sidebar class="sidebar no-print" id="sidebar" data-close-on-click-outside="sidebar">
    <div class=""> <?php require CONF_THEME_PATH . '_partial/dashboardNavigationTop.php'; ?>
        <div class="sidebar-body sidebarMenuJs" id="scrollElement-js">
            <?php
            if (User::canViewSupplierTab() && isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) &&  $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'S') {
                $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php');
            } elseif (User::canViewAdvertiserTab() && isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'])  && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'Ad') {
                $this->includeTemplate('_partial/advertiser/advertiserDashboardNavigation.php');
            } elseif (User::canViewAffiliateTab() && isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'AFFILIATE') {
                $this->includeTemplate('_partial/affiliate/affiliateDashboardNavigation.php');
            } else {
                $this->includeTemplate('_partial/buyerDashboardNavigation.php');
            } ?>
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
    </div>

</sidebar>

<main id="main-area" class="main">
    <?php $this->includeTemplate('_partial/topHeaderDashboard.php', ['siteLangId' => $siteLangId], false); ?>