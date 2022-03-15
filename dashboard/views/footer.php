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
                            <a class="mobile-actions-link" href="<?php echo $dashboardOrgUrl; ?>">
                                <svg class="svg" width="24" height="24">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#home">
                                    </use>
                                </svg>
                                <span class="txt"><?php echo Labels::getLabel("NAV_HOME", $siteLangId); ?></span>
                            </a>
                        </li>
                        <li class="mobile-actions-item active" role="none">
                            <button class="mobile-actions-link" type="button" data-trigger="sidebar">
                                <svg class="svg" width="24" height="24">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#menu">
                                    </use>
                                </svg>
                                <span class="txt"><?php echo Labels::getLabel("NAV_MENU", $siteLangId); ?></span>
                            </button>
                        </li>
                        <li class="mobile-actions-item dropdown" role="none">
                            <button class="mobile-actions-link" type="button" data-bs-toggle="dropdown">
                                <svg class="svg" width="24" height="24">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#account">
                                    </use>
                                </svg>
                                <span class="txt"><?php echo Labels::getLabel("NAV_ACCOUNT", $siteLangId); ?></span>
                            </button>
                            <div class="my-account-target dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
                                <div class="profile">
                                    <div class="profile-img">
                                        <?php
                                        $userImgUpdatedOn = User::getAttributesById(UserAuthentication::isUserLogged(), 'user_updated_on');
                                        $uploadedTime = AttachedFile::setTimeParam($userImgUpdatedOn); ?>
                                        <img alt="" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Account', 'userProfileImage', array(UserAuthentication::isUserLogged(), ImageDimension::VIEW_THUMB, true)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>">
                                    </div>
                                    <div class="profile-detail">
                                        <h6 class="h6"><?php echo Labels::getLabel('LBL_HI,', $siteLangId) . ' ' . $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_name']; ?> </h6>
                                        <span class="text-muted">
                                            <a href=""><?php echo $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_email']; ?></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <nav class="nav my-account-nav">
                                    <a class="my-account-nav-link" href="<?php echo $dashboardOrgUrl; ?>"> <svg class="svg" width="14" height="14">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                                        </svg><?php echo Labels::getLabel("NAV_DASHBOARD", $siteLangId); ?></a>
                                    <a class="my-account-nav-link" href="<?php echo UrlHelper::generateUrl('account', 'profileInfo', [], CONF_WEBROOT_DASHBOARD); ?>">
                                        <svg class="svg" width="14" height="14">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                                        </svg><?php echo Labels::getLabel("NAV_PROFILE", $siteLangId); ?></a>

                                    <a class="my-account-nav-link" href="<?php echo UrlHelper::generateUrl('Account', 'changeEmailPassword'); ?>"> <svg class="svg" width="14" height="14">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                                        </svg><?php echo Labels::getLabel('NAV_UPDATE_CREDENTIALS', $siteLangId); ?></a>
                                    <div class="divider"></div>
                                    <a class="my-account-nav-link" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND); ?>">
                                        <svg class="svg" width="14" height="14">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                                        </svg><?php echo Labels::getLabel('NAV_LOGOUT', $siteLangId); ?></a>
                                </nav>
                            </div>
                        </li>
                    </ul>
                </footer>
            </main>
        </div>
        <div class="modal fade" id="search-main">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-5">
                        <div class="quick-search">
                            <form method="get" class="form  quick-search-form">
                                <div class="quick-search-head">
                                    <input id="quickSearchJs" type="search" class="form-control" placeholder="Go To..">
                                </div>
                                <div class="quick-search-body">
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
                            </form>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <div class="search-native">
                            <label class="checkbox" for="">
                                <?php
                                $preferences = $_COOKIE['quickSearchCtrlJs'] ?? 0;
                                $str = Labels::getLabel('LBL_PRESS_{KEY}_KEY_FOR_BROWSER_SEARCH', $siteLangId);
                                echo CommonHelper::replaceStringData($str, ['{KEY}' => '<kbd>Ctrl-F</kbd>']); ?>
                                <input type="checkbox" id="quickSearchCtrlJs" <?php echo (0 < $preferences ? 'checked="checked"' : ''); ?> data-bs-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('MSG_MARK_AS_CHECKED_TO_USE_THE_ONLY_NATIVE_BROWSER_SEARCH', $siteLangId); ?>">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>