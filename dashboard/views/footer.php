<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
$dashboardOrgUrl = 'javascript:void(0);';
$userActiveTab = false;
if (User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'S')) {
    $userActiveTab = true;
    $dashboardOrgUrl = UrlHelper::generateUrl('Seller', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
} elseif (User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'B')) {
    $userActiveTab = true;
    $dashboardOrgUrl = UrlHelper::generateUrl('Buyer', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
} elseif (User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'Ad')) {
    $userActiveTab = true;
    $dashboardOrgUrl = UrlHelper::generateUrl('Advertiser', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
} elseif (User::canViewAffiliateTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'AFFILIATE')) {
    $userActiveTab = true;
    $dashboardOrgUrl = UrlHelper::generateUrl('Affiliate', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
}

if (!$userActiveTab) {
    $dashboardOrgUrl = UrlHelper::generateUrl('Account', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
}
?>
<footer class="footer">
    <div class="copyright">
        <p class="copyright-txt">
            <?php if (CommonHelper::demoUrl()) {
                $replacements = array(
                    '{YEAR}' => '&copy; ' . date("Y"),
                    '{PRODUCT}' => '<a target="_blank" href="https://yo-kart.com">Yo!Kart</a>',
                    '{OWNER}' => '<a target="_blank" href="https://www.fatbit.com/">FATbit Technologies</a>',
                );
                echo CommonHelper::replaceStringData(Labels::getLabel('LBL_COPYRIGHT_TEXT', $siteLangId), $replacements);
            } else {
                echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId, FatUtility::VAR_STRING, 'Copyright &copy; ' . date('Y') . ' <a href="https://www.fatbit.com/">FATbit.com');
            } ?>
        </p>
        <p class="version"><?php echo CONF_WEB_APP_VERSION; ?></p>
    </div>
    <ul class="mobile-actions">
        <li class="mobile-actions-item" role="none">
            <a class="mobile-actions-link" href="<?php echo UrlHelper::generateUrl('', '', [], CONF_WEBROOT_FRONTEND, null, false, false, true, $siteLangId); ?>">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#home">
                    </use>
                </svg>
                <span class="txt"><?php echo Labels::getLabel("NAV_HOME", $siteLangId); ?></span>
            </a>
        </li>
        <li class="mobile-actions-item" role="none">
            <button class="mobile-actions-link" type="button" data-trigger="sidebar">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#menu">
                    </use>
                </svg>
                <span class="txt"><?php echo Labels::getLabel("NAV_MENU", $siteLangId); ?></span>
            </button>
        </li>

        <li class="mobile-actions-item" role="none">
            <button class="mobile-actions-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-account" aria-controls="offcanvas-account">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_FRONT_URL; ?>images/retina/sprite-header.svg#mbl-account">
                    </use>
                </svg>
                <span class="txt"><?php echo Labels::getLabel("LBL_Account", $siteLangId); ?></span>
            </button>
        </li>
    </ul>
</footer>
</main>
</div>
<div class="modal fade" id="search-main">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <div class="quick-search">
                    <form method="get" class="form  quick-search-form">
                        <div class="quick-search-head">
                            <input id="quickSearchJs" type="search" class="form-control" placeholder="Go To..">
                        </div>
                        <div class="quick-search-body">
                            <?php
                            if (User::canViewSupplierTab() && isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) &&  $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'S') {
                                $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php', ['quickSearch' => true]);
                            } elseif (User::canViewAdvertiserTab() && isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'])  && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'Ad') {
                                $this->includeTemplate('_partial/advertiser/advertiserDashboardNavigation.php', ['quickSearch' => true]);
                            } elseif (User::canViewAffiliateTab() && isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'AFFILIATE') {
                                $this->includeTemplate('_partial/affiliate/affiliateDashboardNavigation.php', ['quickSearch' => true]);
                            } else {
                                $this->includeTemplate('_partial/buyerDashboardNavigation.php', ['quickSearch' => true]);
                            } ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="search-native">
                    <label class="checkbox" for="">
                        <?php echo CommonHelper::replaceStringData(Labels::getLabel('LBL_PRESS_{KEY}_AGAIN_TO_USE_NATIVE_BROWSER_SEARCH', $siteLangId), ['{KEY}' => '<kbd>Ctrl-F</kbd>']); ?>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(CONF_THEME_PATH . '_partial/footer-part/offcanvas-elements.php'); ?>
</body>

</html>