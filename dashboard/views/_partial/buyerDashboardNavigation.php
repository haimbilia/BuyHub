<?php
$controller = strtolower($controller);
$action = strtolower($action); ?>
<sidebar class="sidebar no-print">
    <div class="logo-wrapper">
        <?php
        $logoUrl = UrlHelper::generateUrl('', '', [], CONF_WEBROOT_FRONTEND); ?>
        <?php
        $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
        $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
        $uploadedTime = isset($fileData['afile_updated_at']) ? AttachedFile::setTimeParam($fileData['afile_updated_at']) : '';
        $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

        $ratio = '';
        if (isset($fileData['afile_aspect_ratio']) && $fileData['afile_aspect_ratio'] > 0 && isset($aspectRatioArr[$fileData['afile_aspect_ratio']])) {
            $ratio = $aspectRatioArr[$fileData['afile_aspect_ratio']];
        }
        ?>
        <div class="logo-dashboard">
            <a href="<?php echo $logoUrl; ?>">
                <img data-ratio="<?php echo $ratio; ?>" src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>">
            </a>
        </div>

        <?php
        $isOpened = '';
        if (isset($_COOKIE['openSidebar']) && !empty(FatUtility::int($_COOKIE['openSidebar'])) && isset($_COOKIE['screenWidth']) && applicationConstants::MOBILE_SCREEN_WIDTH < FatUtility::int($_COOKIE['screenWidth'])) {
            $isOpened = 'is-opened';
        }
        ?>
        <div class="js-hamburger hamburger-toggle <?php echo $isOpened; ?>"><span class="bar-top"></span><span class="bar-mid"></span><span class="bar-bot"></span></div>
    </div>
    <div class="sidebar__content custom-scrollbar scroll scroll-y" id="scrollElement-js">
        <ul class="dashboard-menu">
            <li class="dashboard-menu-item">
                <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-orders" aria-expanded="true" aria-controls="collapseOne" title="">
                    <span class="dashboard-menu-icon">
                        <svg class="svg" width="18" height="18">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#order-sales">
                            </use>
                        </svg>
                    </span>
                    <span class="dashboard-menu-head">
                        <?php echo Labels::getLabel('LBL_Orders', $siteLangId); ?>
                    </span>
                    <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                    </i>
                </button>
                <ul class="menu-sub menu-sub-accordion collapse" id="nav-orders" aria-labelledby="" data-parent="#dashboard-menu">
                    <li class="menu-sub-item <?php echo ($controller == 'buyer' && ($action == 'orders' || $action == 'vieworder')) ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Orders", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Buyer', 'Orders'); ?>">
                            <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Orders", $siteLangId); ?></span>
                        </a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'buyer' && ($action == 'mydownloads')) ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Downloads", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Buyer', 'MyDownloads'); ?>">
                            <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Downloads", $siteLangId); ?></span>
                        </a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'buyer' && $action == 'ordercancellationrequests') ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Order_Cancellation_Requests", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Buyer', 'orderCancellationRequests'); ?>">
                            <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Order_Cancellation_Requests", $siteLangId); ?></span>
                        </a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'buyer' && ($action == 'orderreturnrequests' || $action == 'vieworderreturnrequest')) ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Return_Requests", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Buyer', 'orderReturnRequests'); ?>">
                            <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Return_Requests", $siteLangId); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php if (User::canViewBuyerTab()) { ?>
                <li class="dashboard-menu-item">
                    <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-offers" aria-expanded="true" aria-controls="collapseOne" title="">
                        <span class="dashboard-menu-icon">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#my-offers">
                                </use>
                            </svg>
                        </span>
                        <span class="dashboard-menu-head">
                            <?php echo Labels::getLabel('LBL_Offers_&_Rewards', $siteLangId); ?>
                        </span>
                        <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                        </i>
                    </button>
                    <ul class="menu-sub menu-sub-accordion collapse" id="nav-offers" aria-labelledby="" data-parent="#dashboard-menu">
                        <li class="menu-sub-item <?php echo ($controller == 'buyer' && $action == 'offers') ? 'is-active' : ''; ?>">
                            <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_My_Offers", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Buyer', 'offers'); ?>">
                                <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_My_Offers", $siteLangId); ?></span>
                            </a>
                        </li>
                        <li class="menu-sub-item <?php echo ($controller == 'buyer' && $action == 'rewardpoints') ? 'is-active' : ''; ?>">
                            <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Reward_Points", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Buyer', 'rewardPoints'); ?>">
                                <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Reward_Points", $siteLangId); ?></span>
                            </a>
                        </li>
                        <?php if (FatApp::getConfig('CONF_ENABLE_REFERRER_MODULE', FatUtility::VAR_INT, 1)) { ?>
                            <li class="menu-sub-item <?php echo ($controller == 'buyer' && $action == 'shareearn') ? 'is-active' : ''; ?>">
                                <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Share_and_Earn", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Buyer', 'shareEarn'); ?>">
                                    <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Share_and_Earn", $siteLangId); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <li class="dashboard-menu-item">
                <button class="dashboard-menu-btn dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#nav-general" aria-expanded="true" aria-controls="collapseOne" title="">
                    <span class="dashboard-menu-icon">
                        <svg class="svg" width="18" height="18">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-sidebar.svg#saved-searches">
                            </use>
                        </svg>
                    </span>
                    <span class="dashboard-menu-head">
                        <?php echo Labels::getLabel('LBL_General', $siteLangId); ?>
                    </span>
                    <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                    </i>
                </button>
                <ul class="menu-sub menu-sub-accordion collapse" id="nav-general" aria-labelledby="" data-parent="#dashboard-menu">
                    <li class="menu-sub-item <?php echo ($controller == 'account' && ($action == 'messages' || strtolower($action) == 'viewmessages')) ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Messages", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'Messages'); ?>">
                            <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Messages", $siteLangId); ?>
                                <?php if ($todayUnreadMessageCount > 0) { ?>
                                    <span class="msg-count"><?php echo ($todayUnreadMessageCount < 9) ? $todayUnreadMessageCount : '9+'; ?></span>
                                <?php } ?></span>
                        </a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_My_Credits", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'credits'); ?>">
                            <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_My_Credits', $siteLangId); ?></span>
                        </a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'wishlist') ? 'is-active' : ''; ?>">

                        <?php
                        $label = Labels::getLabel("LBL_FAVORITES", $siteLangId);
                        if (0 < FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1)) {
                            $label = Labels::getLabel("LBL_WISHLIST", $siteLangId);
                        }
                        ?>
                        <a class="menu-sub-link" title="<?php echo $label; ?>" href="<?php echo UrlHelper::generateUrl('Account', 'wishlist'); ?>">
                            <span class="menu-sub-title"><?php echo $label; ?></span>
                        </a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'savedproductssearch' && $action == 'listing') ? 'is-active' : ''; ?>">

                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Saved_Searches", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('SavedProductsSearch', 'listing'); ?>">
                            <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_Saved_Searches', $siteLangId); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
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
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Account_Settings", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'ProfileInfo'); ?>">
                            <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Account_Settings", $siteLangId); ?></span>
                        </a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'myaddresses') ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_Manage_Addresses", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'myAddresses'); ?>">
                            <span class="menu-sub-title"><?php echo Labels::getLabel("LBL_Manage_Addresses", $siteLangId); ?></span>
                        </a>
                    </li>
                    <li class="menu-sub-item <?php echo ($controller == 'account' && $action == 'changeemailpassword') ? 'is-active' : ''; ?>">
                        <a class="menu-sub-link" title="<?php echo Labels::getLabel("LBL_UPDATE_CREDENTIALS", $siteLangId); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'changeEmailPassword'); ?>">

                            <span class="menu-sub-title"><?php echo Labels::getLabel('LBL_UPDATE_CREDENTIALS', $siteLangId); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php $this->includeTemplate('_partial/dashboardLanguageArea.php'); ?>
        </ul>
    </div>
</sidebar>