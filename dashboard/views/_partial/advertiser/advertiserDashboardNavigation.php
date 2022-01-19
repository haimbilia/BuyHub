<?php
$controller = strtolower($controller);
$action = strtolower($action);
?> <sidebar class="sidebar no-print">
    <div class="logo-wrapper"> <?php
                                $logoUrl = UrlHelper::generateUrl('', '', [], CONF_WEBROOT_FRONTEND);
                                ?>
        <?php
        $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
        $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
        $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        ?>
        <div class="logo-dashboard">
            <a href="<?php echo $logoUrl; ?>">
                <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>">
            </a>
        </div>
        <?php
        $isOpened = '';
        if (isset($_COOKIE['openSidebar']) && !empty(FatUtility::int($_COOKIE['openSidebar'])) && array_key_exists('screenWidth', $_COOKIE) && applicationConstants::MOBILE_SCREEN_WIDTH < FatUtility::int($_COOKIE['screenWidth'])) {
            $isOpened = 'is-opened';
        }
        ?>
        <div class="js-hamburger hamburger-toggle <?php echo $isOpened; ?>"><span class="bar-top"></span><span class="bar-mid"></span><span class="bar-bot"></span></div>
    </div>
    <div class="sidebar__content custom-scrollbar scroll scroll-y" id="scrollElement-js">

        <ul class="dashboard-menu">
            <?php if (User::canViewAdvertiserTab() && $userPrivilege->canViewPromotions(0, true)) { ?>
                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-promotions" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#my-promotions">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel('LBL_Promotions', $siteLangId); ?>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>
                    <ul class="menu-sub menu-sub-accordion collapse" id="nav-promotions" aria-labelledby="" data-parent="#dashboard-menu">
                        <li class="menu-sub-item <?php echo ($controller == 'advertiser' && ($action == 'promotions' || $action == 'viewpromotions')) ? 'is-active' : ''; ?>">
                            <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_My_Promotions", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('advertiser', 'promotions'); ?>">
                                <span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Promotions", $siteLangId); ?></span></a>
                        </li>
                        <li class="menu-sub-item <?php echo ($controller == 'advertiser' && ($action == 'promotioncharges' || $action == 'viewpromotions')) ? 'is-active' : ''; ?>">
                            <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Promotion_Charges", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('advertiser', 'promotionCharges'); ?>">
                                <span class="menu-item__title"><?php echo Labels::getLabel("LBL_Promotion_Charges", $siteLangId); ?></span></a>
                        </li>
                        <?php if ($userParentId == UserAuthentication::getLoggedUserId()) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_My_Credits", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'credits'); ?>">
                                    <span class="menu-item__title"><?php echo Labels::getLabel('LBL_My_Credits', $siteLangId); ?></span></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <li class="dashboard-menu-item">
                <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-profile" aria-expanded="true" aria-controls="collapseOne" title="">
                    <span class="dashboard-menu-icon">
                        <svg class="svg" width="18" height="18">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#my-account">
                            </use>
                        </svg>
                    </span>
                    <span class="dashboard-menu-head">
                        <?php echo Labels::getLabel('LBL_Profile', $siteLangId); ?>
                    </span>
                    <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                    </i>
                </button>
                <ul class="menu-sub menu-sub-accordion collapse" id="nav-profile" aria-labelledby="" data-parent="#dashboard-menu">
                    <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'ProfileInfo'); ?>">
                            <span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?></span></a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'changeemailpassword') ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_UPDATE_CREDENTIALS", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'changeEmailPassword'); ?>">
                            <span class="menu-item__title"><?php echo Labels::getLabel('LBL_UPDATE_CREDENTIALS', $siteLangId); ?></span></a>
                    </li>
                </ul>
            </li>
            <?php $this->includeTemplate('_partial/dashboardLanguageArea.php'); ?>
        </ul>
    </div>
</sidebar>