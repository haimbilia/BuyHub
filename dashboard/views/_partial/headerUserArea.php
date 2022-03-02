<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
global $dashboardOrgUrl;
$userActiveTab = false;
if (User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'S')) {
    $userActiveTab = true;
    $dashboardUrl = UrlHelper::generateUrl('Seller', '', [], CONF_WEBROOT_DASHBOARD);
    $dashboardOrgUrl = UrlHelper::generateUrl('Seller', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
} elseif (User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'B')) {
    $userActiveTab = true;
    $dashboardUrl = UrlHelper::generateUrl('Buyer', '', [], CONF_WEBROOT_DASHBOARD);
    $dashboardOrgUrl = UrlHelper::generateUrl('Buyer', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
} elseif (User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'Ad')) {
    $userActiveTab = true;
    $dashboardUrl = UrlHelper::generateUrl('Advertiser', '', [], CONF_WEBROOT_DASHBOARD);
    $dashboardOrgUrl = UrlHelper::generateUrl('Advertiser', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
} elseif (User::canViewAffiliateTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'AFFILIATE')) {
    $userActiveTab = true;
    $dashboardUrl = UrlHelper::generateUrl('Affiliate', '', [], CONF_WEBROOT_DASHBOARD);
    $dashboardOrgUrl = UrlHelper::generateUrl('Affiliate', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
}
if (!$userActiveTab) {
    $dashboardUrl = UrlHelper::generateUrl('Account', '', [], CONF_WEBROOT_DASHBOARD);
    $dashboardOrgUrl = UrlHelper::generateUrl('Account', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
} ?>
<li class="short-links-item">
    <div class="dropdown my-account">
        <button class="my-account-btn dropdown-toggle no-after" data-bs-toggle="dropdown">
            <img class="my-account-avatar" src="<?php echo $profilePicUrl; ?>" alt="<?php echo $userName; ?>">
        </button>
        <div class="my-account-target dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
            <div class="profile">
                <div class="profile-img">
                    <img alt="<?php echo $userName; ?>" src="<?php echo $profilePicUrl; ?>">
                </div>
                <div class="profile-detail">
                    <h6 class="h6"><?php echo Labels::getLabel('LBL_HI,', $siteLangId) . ' ' . $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_name']; ?></h6>
                    <span class="text-muted">
                        <a href=""><?php echo $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_email']; ?></a>
                    </span>
                </div>
            </div>
            <div class="divider"></div>
            <nav class="nav my-account-nav">
                <a class="my-account-nav-link" href="<?php echo $dashboardOrgUrl; ?>"> <svg class="svg" width="14" height="14">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-dashboard"></use>
                    </svg><?php echo Labels::getLabel("NAV_DASHBOARD", $siteLangId); ?></a>
                <a class="my-account-nav-link" href="<?php echo UrlHelper::generateUrl('account', 'profileInfo', [], CONF_WEBROOT_DASHBOARD); ?>">
                    <svg class="svg" width="14" height="14">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-user"></use>
                    </svg><?php echo Labels::getLabel("NAV_PROFILE", $siteLangId); ?></a>

                <a class="my-account-nav-link" href="<?php echo UrlHelper::generateUrl('Account', 'changeEmailPassword'); ?>"> <svg class="svg" width="14" height="14">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-update"></use>
                    </svg>
                    <?php echo Labels::getLabel('NAV_UPDATE_CREDENTIALS', $siteLangId); ?></a>
                <div class="divider"></div>
                <a class="my-account-nav-link" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND, null, false, false, true, $siteLangId); ?>">
                    <svg class="svg" width="14" height="14">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-logout"></use>
                    </svg>
                    <?php echo Labels::getLabel('NAV_LOGOUT', $siteLangId); ?></a>
            </nav>
        </div>
    </div>
</li>