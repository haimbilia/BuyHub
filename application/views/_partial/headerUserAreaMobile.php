<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
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
                    <h6 class="profile-name"><?php echo $userName; ?> </h6>
                    <p class="profile-email"><?php echo $userEmail; ?></p>
                    <?php
                    if (!empty($userPhone)) { ?>
                        <p class="profile-phone"><?php echo $userPhone; ?></p>
                    <?php } ?>
                </div>
            </div>
            <ul class="account-nav">
                <?php if (UserAuthentication::isUserLogged()) { ?>
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
