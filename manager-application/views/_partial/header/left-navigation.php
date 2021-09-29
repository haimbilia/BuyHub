<sidebar class="sidebar">
    <div class="sidebar-logo">
        <a href="#">
            <?php
            $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_ADMIN_LOGO, 0, 0, $adminLangId, false);
            $aspectRatioArr = AttachedFile::getRatioTypeArray($adminLangId);
            $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
            ?>
            <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> title="<?php echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $adminLangId); ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'siteAdminLogo', array($adminLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $adminLangId); ?>">
        </a>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <?php if (
                $objPrivilege->canViewZones(AdminAuthentication::getLoggedAdminId(), true) ||
                $objPrivilege->canViewCountries(AdminAuthentication::getLoggedAdminId(), true) ||
                $objPrivilege->canViewStates(AdminAuthentication::getLoggedAdminId(), true)
            ) {    ?>
                <li class="menu-item dropdown">
                    <button type="button" class="menu-link" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('LBL_CMS', $adminLangId); ?>">
                        <span class="menu-icon" >
                            <svg class="svg" width="24" height="24" >
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-store">
                                </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('LBL_CMS', $adminLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewZones(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item">
                                    <a href="<?php echo UrlHelper::generateUrl('Zones'); ?>" class="nav_link ">
                                        <span class="nav_text"><?php echo Labels::getLabel('LBL_COUNTRY_ZONES', $adminLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewCountries(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item">
                                    <a href="<?php echo UrlHelper::generateUrl('Countries'); ?>" class="nav_link ">
                                        <span class="nav_text"><?php echo Labels::getLabel('LBL_COUNTRIES', $adminLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewStates(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item">
                                    <a href="<?php echo UrlHelper::generateUrl('States'); ?>" class="nav_link ">
                                        <span class="nav_text"><?php echo Labels::getLabel('LBL_STATES', $adminLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php if (
                $objPrivilege->canViewBrands(AdminAuthentication::getLoggedAdminId(), true)
            ) {    ?>
                <li class="menu-item dropdown">
                    <button type="button" class="menu-link" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('LBL_PRODUCT_CATALOG', $adminLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-catelog">
                                </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('LBL_PRODUCT_CATALOG', $adminLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewBrands(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item">
                                    <a href="<?php echo UrlHelper::generateUrl('Brands'); ?>" class="nav_link ">
                                        <span class="nav_text"><?php echo Labels::getLabel('LBL_Brands', $adminLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php if ($objPrivilege->canViewSitemap(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                <li class="menu-item dropdown">
                    <button type="button" class="menu-link" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('LBL_SITEMAP', $adminLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-sitemap">
                                </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('LBL_SITEMAP', $adminLangId); ?></h6>
                        <ul class="nav">
                            <li class="nav_item">
                                <a href="<?php echo UrlHelper::generateUrl('sitemap', 'generate'); ?>" class="nav_link ">
                                    <span class="nav_text"><?php echo Labels::getLabel('LBL_UPDATE_SITEMAP', $adminLangId); ?></span>
                                </a>
                            </li>
                            <li class="nav_item">
                                <a href="<?php echo UrlHelper::generateFullUrl('custom', 'sitemap', array(), CONF_WEBROOT_FRONT_URL); ?>" class="nav_link ">
                                    <span class="nav_text"><?php echo Labels::getLabel('LBL_VIEW_HTML', $adminLangId); ?></span>
                                </a>
                            </li>
                            <li class="nav_item">
                                <a href="<?php echo UrlHelper::generateFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL) . 'sitemap.xml'; ?>" class="nav_link ">
                                    <span class="nav_text"><?php echo Labels::getLabel('LBL_View_XML', $adminLangId); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="sidebar-foot">
        <a href="">
            <span class="menu-icon">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                    </use>
                </svg>
            </span>
        </a>
    </div>
</sidebar>