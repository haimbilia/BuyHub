<?php $siteLangId = CommonHelper::getLangId(); ?>
<sidebar class="sidebar no-print" id="sidebar" data-close-on-click-outside="sidebar">
    <div class="sidebar-sticky"> <?php require CONF_THEME_PATH . '_partial/dashboardNavigationTop.php'; ?>
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
    </div>
</sidebar>
<main id="main-area" class="main">
    <?php $this->includeTemplate('_partial/topHeaderDashboard.php', ['siteLangId' => $siteLangId], false); ?>