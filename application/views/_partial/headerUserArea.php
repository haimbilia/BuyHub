<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
if (!UserAuthentication::isUserLogged()) {
    if (UserAuthentication::isGuestUserLogged()) { ?>
        <li class="quick-nav-item">
            <div class="dropdown">
                <button type="button" class="button-account dropdown-toggle no-after" data-bs-toggle="dropdown">
                    <span class="txt">
                        <?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name"); ?>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim" aria-labelledby="dropdownMenuButton">
                    <ul class="nav nav-block">
                        <?php $userName = User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name"); ?>
                        <li class="nav__item">
                            <a class="dropdown-item nav__link" href="<?php echo UrlHelper::generateUrl('account', 'profileInfo', [], CONF_WEBROOT_DASHBOARD); ?>">
                                <?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . $userName; ?>
                            </a>
                        </li>
                        <li class="nav__item logout"><a class="dropdown-item nav__link" data-org-url="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND, null, false, $getOrgUrl); ?>" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], 'CONF_WEBROOT_FRONTEND'); ?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?>
                            </a></li>
                    </ul>
                </div>
            </div>
        </li><?php
            } else {
                ?>
        <li class="quick-nav-item">
            <div class="dropdown">
                <button type="button" class="quick-nav-link button-account sign-in sign-in-popup-js">
                    <i class="icn">
                        <svg class="svg" width="18" height="18">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#login"></use>
                        </svg>
                    </i>
                    <span class="txt">
                        <?php echo Labels::getLabel('LBL_Account', $siteLangId); ?> </span>
                </button>
            </div>
        </li> <?php
            }
        } else {
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
    <li class="quick-nav-item">
        <div class="dropdown">
            <button type="button" class="quick-nav-link button-account dropdown-toggle no-after" data-bs-toggle="dropdown">
                <i class="icn">
                    <svg class="svg" width="18" height="18">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#login"></use>
                    </svg>
                </i>
                <span class="txt">
                    <?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name"); ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim" aria-labelledby="dropdownMenuButton">
                <ul class="nav nav-block">
                    <?php
                    $userName = User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name");
                    ?>
                    <li class="nav__item">
                        <a class="dropdown-item nav__link" href="<?php echo UrlHelper::generateUrl('account', 'profileInfo', [], CONF_WEBROOT_DASHBOARD); ?>">
                            <?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . $userName; ?>
                        </a>
                    </li>
                    <li class="nav__item "><a class="dropdown-item nav__link" data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard", $siteLangId); ?></a>
                    </li>
                    <li class="nav__item logout"><a class="dropdown-item nav__link" data-org-url="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', array(), CONF_WEBROOT_FRONTEND, null, false, $getOrgUrl); ?>" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND); ?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?>
                        </a></li>
                </ul>
            </div>
        </div>
    </li>
<?php } ?>