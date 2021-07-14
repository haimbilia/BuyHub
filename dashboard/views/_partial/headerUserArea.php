<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
if (!UserAuthentication::isUserLogged()) {
    if (UserAuthentication::isGuestUserLogged()) { ?>
        <li>
            <div class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle no-after" data-toggle="dropdown"><span class="icn icn-txt"><?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name"); ?></span></a>
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
                ?> <li>
            <div class="dropdown dropdown--user"><a href="javascript:void(0)" class="sign-in sign-in-popup-js"><i class="icn icn--login"><svg class="svg">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
                        </svg></i> <span>
                        <strong><?php echo Labels::getLabel('LBL_Login_/_Sign_Up', $siteLangId); ?></strong></span></a></div>
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
    <li class="">
        <div class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle no-after" data-display="static" data-toggle="dropdown">
                <img class="my-account__avatar" src="<?php echo $profilePicUrl; ?>" alt="">
            </a>
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
                    <li class="nav__item "><a class="dropdown-item nav__link" data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard", $siteLangId); ?></a></li>
                    <li class="nav__item logout"><a class="dropdown-item nav__link" data-org-url="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', array(), CONF_WEBROOT_FRONTEND, null, false, $getOrgUrl); ?>" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND); ?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?>
                        </a></li>
                </ul>
            </div>
        </div>
    </li>
<?php } ?>