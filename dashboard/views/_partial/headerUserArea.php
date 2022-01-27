<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
if (!UserAuthentication::isUserLogged()) {
    if (UserAuthentication::isGuestUserLogged()) { ?>
        <li class="short-links-item">
            <div class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle no-after" data-bs-toggle="dropdown"><span class="icn icn-txt"><?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name"); ?></span></a>
                <ul class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim" aria-labelledby="dropdownMenuButton">
                    <?php $userName = User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name"); ?>
                    <li class="dropdown-menu-item">
                        <a class="dropdown-menu-link" href="<?php echo UrlHelper::generateUrl('account', 'profileInfo', [], CONF_WEBROOT_DASHBOARD); ?>">
                            <?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . $userName; ?>
                        </a>
                    </li>
                    <li class="dropdown-menu-item logout">
                        <a class="dropdown-menu-link" data-org-url="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND, null, false, $getOrgUrl); ?>" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], 'CONF_WEBROOT_FRONTEND'); ?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    <?php
    } else {
    ?>
        <li class="short-links-item">
            <div class="dropdown dropdown--user">
                <a href="javascript:void(0)" class="sign-in sign-in-popup-js">
                    <i class="icn icn--login">
                        <svg class="svg" width="" height="">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                        </svg>
                    </i>
                    <span>

                        <?php echo Labels::getLabel('LBL_Login_/_Sign_Up', $siteLangId); ?>

                    </span>
                </a>
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
    <li class="short-links-item">
        <div class="dropdown my-account">
            <button class="my-account-btn dropdown-toggle no-after" data-bs-toggle="dropdown">
                <img class="my-account-avatar" src="<?php echo $profilePicUrl; ?>" alt="">
            </button>
            <div class="my-account-target dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
                <div class="profile">
                    <div class="profile-img">
                        <img alt="" src="<?php echo $profilePicUrl; ?>">
                    </div>
                    <div class="profile-detail">
                        <h6 class="h6"> Hi, Jack Doe </h6>
                        <span class="text-muted">
                            <a href="">yokartv8@dummyid.com</a>
                        </span>
                    </div>
                </div>
                <div class="divider"></div>
                <nav class="nav my-account-nav">
                    <a class="my-account-nav-link" href=""> <svg class="svg" width="14" height="14">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                        </svg> My Store</a>
                    <a class="my-account-nav-link" href="">
                        <svg class="svg" width="14" height="14">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                        </svg>
                        Messages</a>
                    <a class="my-account-nav-link" href="">
                        <svg class="svg" width="14" height="14">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                        </svg>My Profile</a>

                    <a class="my-account-nav-link" href=""> <svg class="svg" width="14" height="14">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                        </svg>
                        Change Password</a>
                    <div class="divider"></div>
                    <a class="my-account-nav-link" href="">
                        <svg class="svg" width="14" height="14">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                        </svg>
                        log out</a>
                </nav>
            </div>
            <ul class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim" aria-labelledby="dropdownMenuButton">
                <?php
                $userName = User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name");
                ?>
                <li class="dropdown-menu-item">
                    <a class="dropdown-menu-link" href="<?php echo UrlHelper::generateUrl('account', 'profileInfo', [], CONF_WEBROOT_DASHBOARD); ?>">
                        <?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . $userName; ?>
                    </a>
                </li>
                <li class="dropdown-menu-item">
                    <a class="dropdown-menu-link" data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard", $siteLangId); ?></a>
                </li>
                <li class="dropdown-menu-item logout">
                    <a class="dropdown-menu-link" data-org-url="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', array(), CONF_WEBROOT_FRONTEND, null, false, $getOrgUrl); ?>" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND); ?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?>
                    </a>
                </li>
            </ul>

        </div>
    </li>
<?php } ?>