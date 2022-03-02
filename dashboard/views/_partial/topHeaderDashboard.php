<?php if (FatApp::getConfig('CONF_AUTO_RESTORE_ON', FatUtility::VAR_INT, 1) && CommonHelper::demoUrl() && 'subscriptioncheckout' != strtolower($controllerName)) {
    $this->includeTemplate('restore-system/top-header.php');
} ?>

<header id="header-dashboard" class="header-dashboard no-print">
    <?php if ((User::canViewSupplierTab() && User::canViewBuyerTab()) || (User::canViewSupplierTab() && User::canViewAdvertiserTab() && $userPrivilege->canViewPromotions(0, true)) || (User::canViewBuyerTab() && User::canViewAdvertiserTab())) { ?>
        <div class="dropdown dashboard-user">
            <button class="btn dropdown-toggle-custom dropdown-toggle collapsed no-after" type="button" id="dashboardDropdown" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                <?php
                $dashboardArr = [
                    'S' => Labels::getLabel('NAV_SELLER_DASHBOARD', $siteLangId),
                    'B' => Labels::getLabel('NAV_BUYER_DASHBOARD', $siteLangId),
                    'Ad' => Labels::getLabel('NAV_ADVERTISER_DASHBOARD', $siteLangId),
                    'AFFILIATE' => Labels::getLabel('NAV_AFFILIATE_DASHBOARD', $siteLangId),
                ];
                ?>
                <span class="meta"><?php echo HtmlHelper::displayWordsFirstLetter($dashboardArr[$activeTab]); ?></span>
                <?php echo $dashboardArr[$activeTab]; ?>
                <i class="dropdown-toggle-custom-arrow"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-fit dropdown-menu-anim choose-dashboard" aria-labelledby="dashboardDropdown">
                <?php if (User::canViewSupplierTab()) { ?>
                    <li class="dropdown-menu-item <?php echo ($activeTab == 'S') ? 'is-active' : ''; ?>">
                        <a class="dropdown-menu-link" href="<?php echo UrlHelper::generateUrl('Seller'); ?>">
                            <div class="meta-block">
                                <span class="meta-img"><?php echo HtmlHelper::displayWordsFirstLetter($dashboardArr['S']); ?></span>
                                <?php echo $dashboardArr['S']; ?>
                            </div>

                        </a>
                    </li>
                <?php } ?>
                <?php if (User::canViewBuyerTab()) { ?>
                    <li class="dropdown-menu-item <?php echo ($activeTab == 'B') ? 'is-active' : ''; ?>">
                        <a class="dropdown-menu-link" href="<?php echo UrlHelper::generateUrl('Buyer'); ?>">
                            <div class="meta-block">
                                <span class="meta-img"><?php echo HtmlHelper::displayWordsFirstLetter($dashboardArr['B']); ?></span>
                                <?php echo $dashboardArr['B']; ?>
                            </div>
                        </a>
                    </li>
                <?php } ?>
                <?php if (User::canViewAdvertiserTab() && $userPrivilege->canViewPromotions(0, true)) { ?>
                    <li class="dropdown-menu-item <?php echo ($activeTab == 'Ad') ? 'is-active' : ''; ?>">
                        <a class="dropdown-menu-link" href="<?php echo UrlHelper::generateUrl('Advertiser'); ?>">
                            <div class="meta-block">
                                <span class="meta-img"><?php echo HtmlHelper::displayWordsFirstLetter($dashboardArr['Ad']); ?></span>
                                <?php echo $dashboardArr['Ad']; ?>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <div class="header-icons-group">
        <?php
        $getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
        $userActiveTab = false;
        if (User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'S')) {
            $userActiveTab = true;
            $dashboardUrl = UrlHelper::generateUrl('Seller', '', [], CONF_WEBROOT_DASHBOARD);
            $dashboardOrgUrl = UrlHelper::generateUrl('Seller', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
        } elseif (User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'B')) {
            $userActiveTab = true;
            $dashboardUrl = UrlHelper::generateUrl('Buyer', '', [], CONF_WEBROOT_DASHBOARD);
            $dashboardOrgUrl = UrlHelper::generateUrl('Buyer', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
        } elseif (User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'Ad')) {
            $userActiveTab = true;
            $dashboardUrl = UrlHelper::generateUrl('Advertiser', '', [], CONF_WEBROOT_DASHBOARD);
            $dashboardOrgUrl = UrlHelper::generateUrl('Advertiser', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
        } elseif (User::canViewAffiliateTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'AFFILIATE')) {
            $userActiveTab = true;
            $dashboardUrl = UrlHelper::generateUrl('Affiliate', '', [], CONF_WEBROOT_DASHBOARD);
            $dashboardOrgUrl = UrlHelper::generateUrl('Affiliate', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
        }

        if (!$userActiveTab) {
            $dashboardUrl = UrlHelper::generateUrl('Account', '', [], CONF_WEBROOT_DASHBOARD);
            $dashboardOrgUrl = UrlHelper::generateUrl('Account', '', array(), CONF_WEBROOT_DASHBOARD, null, false, $getOrgUrl);
        }
        ?>
        <?php /*  <ul class="c-header-links">
            <li>
                <a title="<?php echo Labels::getLabel('LBL_Dashboard', $siteLangId); ?>" data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>">
                    <i class="icn icn--dashboard">
                        <svg class="svg" width="20" height="20">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#dashboard">
                            </use>
                        </svg>
                    </i>
                </a>
            </li>
            <li><a title="<?php echo Labels::getLabel('LBL_Home', $siteLangId); ?>" target="_blank" href="<?php echo UrlHelper::generateUrl('', '', [], CONF_WEBROOT_FRONTEND); ?>"><i class="icn icn--home">
                        <svg class="svg" width="20" height="20">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#back-home">
                            </use>
                        </svg>
                    </i>
                </a>
            </li>
            <?php if ($isShopActive && $shop_id > 0 && $activeTab == 'S') { ?>
                <li>
                    <a title="<?php echo Labels::getLabel('LBL_Shop', $siteLangId); ?>" data-org-url="<?php echo UrlHelper::generateUrl('Shops', 'view', array($shop_id), CONF_WEBROOT_FRONTEND, null, false, $getOrgUrl); ?>" target="_blank" href="<?php echo UrlHelper::generateUrl('Shops', 'view', array($shop_id), CONF_WEBROOT_FRONTEND); ?>"><i class="icn icn--home">
                            <svg class="svg" width="20" height="20">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#manage-shop">
                                </use>
                            </svg>
                        </i>
                    </a>
                </li>
            <?php } ?>
        </ul> <?php */ ?>
        <button class="c-header-icon btn quick-search" data-bs-toggle="modal" data-bs-target="#search-main">
            <svg class="svg" width="20" height="20">
                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#icon-search">
                </use>
            </svg>
        </button>
        <?php if ($userPrivilege->canViewMessages(0, true) && $activeTab != 'Ad') { ?>
            <a class="c-header-icon bell" data-org-url="<?php echo UrlHelper::generateUrl('Account', 'Messages', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo UrlHelper::generateUrl('Account', 'Messages'); ?>" title="<?php echo Labels::getLabel('LBL_Messages', $siteLangId); ?>">
                <svg class="svg bell-shake-delay" width="20" height="20">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#notification">
                    </use>
                </svg>

                <span class="h-badge">
                    <?php echo CommonHelper::displayBadgeCount($todayUnreadMessageCount, 9); ?></span></a>
        <?php } ?>
        <?php $this->includeTemplate('_partial/headerUserArea.php'); ?>
    </div>
</header>
<div class="display-in-print text-center">
    <?php
    $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_INVOICE_LOGO, 0, 0, $siteLangId, false);
    $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
    ?>
    <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> src="<?php echo UrlHelper::generateFullUrl('Image', 'invoiceLogo', array($siteLangId), CONF_WEBROOT_FRONTEND); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>">
</div>