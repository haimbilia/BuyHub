<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
if ($layoutType == applicationConstants::SCREEN_DESKTOP) {
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
                            <li class="nav__item">
                                <a class="dropdown-item nav__link" href="<?php echo UrlHelper::generateUrl('account', 'profileInfo', [], CONF_WEBROOT_DASHBOARD, null, false, false, false); ?>">
                                    <?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . $userName; ?>
                                </a>
                            </li>
                            <li class="nav__item logout"><a class="dropdown-item nav__link" data-org-url="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND, null, false, $getOrgUrl, false); ?>" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], 'CONF_WEBROOT_FRONTEND'); ?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </li>
        <?php
        } else {
        ?>
            <li class="quick-nav-item">
                <div class="dropdown">
                    <button type="button" class="quick-nav-link button-account sign-in sign-in-popup-js">
                        <svg class="svg" width="20" height="20">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#login"></use>
                        </svg>
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
                    $dashboardUrl = UrlHelper::generateUrl('Seller', '', [], CONF_WEBROOT_DASHBOARD, null, false, false, false);
                    $dashboardOrgUrl = UrlHelper::generateUrl('Seller', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl, false);
                } elseif (User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'B')) {
                    $userActiveTab = true;
                    $dashboardUrl = UrlHelper::generateUrl('Buyer', '', [], CONF_WEBROOT_DASHBOARD, null, false, false, false);
                    $dashboardOrgUrl = UrlHelper::generateUrl('Buyer', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl, false);
                } elseif (User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'Ad')) {
                    $userActiveTab = true;
                    $dashboardUrl = UrlHelper::generateUrl('Advertiser', '', [], CONF_WEBROOT_DASHBOARD, null, false, false, false);
                    $dashboardOrgUrl = UrlHelper::generateUrl('Advertiser', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl, false);
                } elseif (User::canViewAffiliateTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'AFFILIATE')) {
                    $userActiveTab = true;
                    $dashboardUrl = UrlHelper::generateUrl('Affiliate', '', [], CONF_WEBROOT_DASHBOARD, null, false, false, false);
                    $dashboardOrgUrl = UrlHelper::generateUrl('Affiliate', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl, false);
                }
                if (!$userActiveTab) {
                    $dashboardUrl = UrlHelper::generateUrl('Account', '', [], CONF_WEBROOT_DASHBOARD, null, false, false, false);
                    $dashboardOrgUrl = UrlHelper::generateUrl('Account', '', [], CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl, false);
                } ?>
        <li class="quick-nav-item item-desktop">
            <div class="dropdown">
                <button type="button" class="quick-nav-link button-account dropdown-toggle no-after" data-bs-toggle="dropdown">
                    <svg class="svg" width="20" height="20">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#login"></use>
                    </svg>
                    <span class="txt">
                        <?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name"); ?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim" aria-labelledby="dropdownMenuButton">
                    <ul class="nav nav-block">                       
                        <li class="nav__item">
                            <a class="dropdown-item nav__link" href="<?php echo UrlHelper::generateUrl('account', 'profileInfo', [], CONF_WEBROOT_DASHBOARD, null, false, false, false); ?>">
                                <?php echo Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . $userName; ?>
                            </a>
                        </li>
                        <li class="nav__item"><a class="dropdown-item nav__link" data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard", $siteLangId); ?></a>
                        </li>
                        <li class="nav__item logout"><a class="dropdown-item nav__link" data-org-url="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', array(), CONF_WEBROOT_FRONTEND, null, false, $getOrgUrl); ?>" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND); ?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?>
                            </a></li>
                    </ul>
                </div>
            </div>
        </li>
    <?php }
        } elseif ($layoutType == applicationConstants::SCREEN_MOBILE) { ?>
<div class="offcanvas offcanvas-account offcanvas-start" tabindex="-1" id="offcanvas-account">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Profile </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="profile">
            <div class="profile-image">
                <img class="profile-avatar" width="80" height="80" src="<?php echo $profilePicUrl; ?>" alt="">
            </div>
            <div class="profile-data">  
                <h6 class="profile-name"><?php echo $userName;?> </h6>
                <p class="profile-email"><?php echo $userEmail;?></p>
                <?php
                    if(!empty($userPhone)) { ?>
                        <p class="profile-phone"><?php echo $userPhone;?></p>
                    <?php } ?>
            </div>
        </div>      
        <ul class="account-nav">
            <?php if( UserAuthentication::isUserLogged()){ ?>
                <li class="account-nav-item">
                    <a class="account-nav-link" href="">Orders <i class="icon icon-arrow-right"></i></a>
                </li>
                <li class="account-nav-item">
                    <a class="account-nav-link" href="">Offers & Rewards <i class="icon icon-arrow-right"></i></a>
                </li>
                <li class="account-nav-item">
                    <a class="account-nav-link" href="">General <i class="icon icon-arrow-right"></i></a>
                </li>
                <li class="account-nav-item">
                    <a class="account-nav-link" href="">Profile <i class="icon icon-arrow-right"></i></a>
                </li>
            <?php } ?>
            <li class="account-nav-item">
                <a class="account-nav-link" href=""> Language <i class="icon icon-arrow-right"></i></a>
            </li>
            <li class="account-nav-item">
                <a class="account-nav-link" href=""> Currency <i class="icon icon-arrow-right"></i></a>
            </li>
        </ul>
      
    </div>
    <div class="offcanvas-foot">
        <a class="btn btn-logout" href="<?php echo UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND); ?>">
            <i class="icn">
                <svg class="svg" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#logout">
                    </use>
                </svg>
            </i>
            <?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?>
        </a>
    </div>
</div>


<?php } ?>