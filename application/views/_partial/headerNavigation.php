<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$isMegaMenuEnabled = FatApp::getConfig('CONF_LAYOUT_MEGA_MENU', FatUtility::VAR_INT, 1);
if ($headerNavigation || $isMegaMenuEnabled) {
    $getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;

    if (count($headerNavigation)) {
        $noOfCharAllowedInNav = 90;
        $rightNavCharCount = 5;
        if (!UserAuthentication::isUserLogged()) {
            $rightNavCharCount = $rightNavCharCount + mb_strlen(html_entity_decode(Labels::getLabel('LBL_Sign_In', $siteLangId), ENT_QUOTES, 'UTF-8'));
        } else {
            $rightNavCharCount = $rightNavCharCount + mb_strlen(html_entity_decode(Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . $userName, ENT_QUOTES, 'UTF-8'));
        }
        $rightNavCharCount = $rightNavCharCount + mb_strlen(html_entity_decode(Labels::getLabel("LBL_Cart", $siteLangId), ENT_QUOTES, 'UTF-8'));
        $noOfCharAllowedInNav = $noOfCharAllowedInNav - $rightNavCharCount;

        $navLinkCount = 0;
        foreach ($headerNavigation as $nav) {
            if (!$nav['pages']) {
                break;
            }
            foreach ($nav['pages'] as $link) {
                $noOfCharAllowedInNav = $noOfCharAllowedInNav - mb_strlen(html_entity_decode($link['nlink_caption'], ENT_QUOTES, 'UTF-8'));
                if ($noOfCharAllowedInNav < 0) {
                    break;
                }
                $navLinkCount++;
            }
        }
    } ?>
    <?php if ($layoutType == applicationConstants::SCREEN_DESKTOP) { ?>
        <!-- Start Navigation Bar -->
        <div class="navigation-wrapper">
            <ul class="navigation">
                <?php if ($isMegaMenuEnabled == Navigations::LAYOUT_MEGA_MENU) { ?>
                    <li>
                        <button class="hamburger-categories" type="button" onclick="openMobileMenu();">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#hamburger-menu">
                                </use>
                            </svg><?php echo Labels::getLabel('NAV_ALL_CATEGORIES', $siteLangId); ?></button>
                    </li>
                    <?php
                }
                if (count($headerNavigation)) {
                    foreach ($headerNavigation as $nav) {
                        if ($nav['pages']) {
                            $mainNavigation = array_slice($nav['pages'], 0, $navLinkCount);
                            foreach ($mainNavigation as $link) {
                                $catThumb = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_THUMB, $link['nlink_category_id'], 0, $siteLangId, false, 0);
                                $uploadedTime = AttachedFile::setTimeParam($catThumb['afile_updated_at']);
                                $navUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']);
                                $OrgnavUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'], $getOrgUrl);
                                $rootLinkUrl = UrlHelper::generateUrl('category', 'view', array($link['nlink_category_id']));
                                $href = $navUrl;
                                $navchild = '';
                                $target = $link['nlink_target'];
                                if (0 < count($link['children'])) {
                                    $navchild = 'navchild';
                                    $target = '_self';
                                } ?>
                                <li class="navigation-item <?php echo $navchild; ?>">
                                    <a class="navigation-link" target="<?php echo $target; ?>" data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $href; ?>"><?php echo $link['nlink_caption']; ?></a>
                                    <?php if (isset($link['children']) && count($link['children']) > 0) { ?>
                                        <span class="link__mobilenav"></span>
                                        <div class="subnav">
                                            <div class="subnav-inner">
                                                <div class="container categories-container">
                                                    <div class="categories-block">
                                                        <?php $subyChild = 0;
                                                        foreach ($link['children'] as $children) {
                                                            $subCatUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']));
                                                            $subCatOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                                        ?>
                                                            <div class="categories-cols">
                                                                <ul class="categories-list">
                                                                    <li class="categories-list-item">
                                                                        <a class="categories-list-link categories-list-head" data-org-url="<?php echo $subCatOrgUrl; ?>" href="<?php echo $subCatUrl; ?>"><?php echo $children['prodcat_name']; ?></a>
                                                                    </li>
                                                                    <?php $subChild = 0;
                                                                    foreach ($children['children'] as $childCat) {
                                                                        $catUrl = UrlHelper::generateUrl('category', 'view', array($childCat['prodcat_id']));
                                                                        $catOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                                                    ?>

                                                                        <li class="categories-list-item">
                                                                            <a class="categories-list-link" data-org-url="<?php echo $catOrgUrl; ?>" href="<?php echo $catUrl; ?>">
                                                                                <?php echo $childCat['prodcat_name']; ?></a>
                                                                        </li>
                                                                    <?php
                                                                        if ($subChild++ == 7) {
                                                                            break;
                                                                        }
                                                                    }

                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        <?php
                                                            if ($subyChild++ == 8) {
                                                                break;
                                                            }
                                                        } ?>
                                                    </div>

                                                    <a href="<?php echo $rootLinkUrl; ?>">
                                                        <figure class="category-media">
                                                            <img src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'thumb', array($link['nlink_category_id'], $siteLangId, ImageDimension::VIEW_ICON, 0), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $link['nlink_caption']; ?>" />
                                                            <figcaption><?php echo $link['nlink_caption']; ?></figcaption>
                                                        </figure>
                                                    </a>


                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?>
                                </li>
                <?php }
                        }
                    }
                } ?>
                <?php if ($navLinkCount < count($nav['pages'])) { ?>
                    <li class="seemore navigation-item ">
                        <a class="navigation-link" href="<?php echo UrlHelper::generateUrl('Category'); ?>">
                            <?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- End Navigation Bar -->
    <?php } ?>

    <?php if ($layoutType == applicationConstants::SCREEN_MOBILE) { ?>
        <!-- Start Mobile Navigation Bar -->
        <ul>
            <?php
            $headerCategories = CacheHelper::get('headerCategories_' . $siteLangId, CONF_HOME_PAGE_CACHE_TIME, '.txt');
            if ($headerCategories) {
                $headerCategories = unserialize($headerCategories);
            } else {
                $headerCategories = ProductCategory::getArray($siteLangId, 0, false, true, false, CONF_USE_FAT_CACHE);
                CacheHelper::create('headerCategories_' . $siteLangId, serialize($headerCategories), CacheHelper::TYPE_NAVIGATION);
            }
            if (count($headerNavigation)) {
                foreach ($headerNavigation as $nav) {
                    if ($nav['pages']) {
                        $mainNavigation = array_slice($nav['pages'], 0, $navLinkCount);
                        foreach ($mainNavigation as $link) {
                            $catThumb = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_THUMB, $link['nlink_category_id'], 0, $siteLangId, false, 0);
                            $uploadedTime = AttachedFile::setTimeParam($catThumb['afile_updated_at']);
                            $navUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']);
                            $OrgnavUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'], $getOrgUrl);
                            $rootLinkUrl = UrlHelper::generateUrl('category', 'view', array($link['nlink_category_id']));
                            $href = $navUrl;
                            $target = $link['nlink_target'];
                            if (0 < count($link['children'])) {
                                $href = '#';
                                $target = '_self';
                            } ?>
                            <li class="is-mobile <?php echo (isset($link['children']) && count($link['children']) > 0 ? 'has-submenu' : ''); ?>">
                                <?php if (!isset($link['children']) || 1 > count($link['children'])) { ?>
                                    <a target="<?php echo $target; ?>" href="<?php echo $href; ?>"><?php echo $link['nlink_caption']; ?></a>
                                <?php } else { ?>
                                    <a data-submenu="mobileHeadCat<?php echo $link['nlink_category_id']; ?>" target="<?php echo $target; ?>" data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $href; ?>"><?php echo $link['nlink_caption']; ?></a>
                                    <div id="mobileHeadCat<?php echo  $link['nlink_category_id']; ?>" class="submenu">
                                        <div class="submenu-header" data-submenu-close="mobileHeadCat<?php echo $link['nlink_category_id']; ?>">
                                            <a href="#"><?php echo Labels::getLabel('NAV_MAIN_MENU', $siteLangId); ?></a>
                                        </div>
                                        <label><?php echo $link['nlink_caption']; ?></label>
                                        <ul>
                                            <?php
                                            foreach ($link['children'] as $children) {
                                                $subCatUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']));
                                                $subCatOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                            ?>
                                                <li class="<?php echo (isset($children['children']) && count($children['children']) > 0 ? 'has-submenu' : ''); ?>">
                                                    <?php if (!isset($children['children']) || 1 > count($children['children'])) { ?>
                                                        <a href="<?php echo $subCatUrl; ?>"><?php echo $children['prodcat_name']; ?></a>
                                                    <?php } else { ?>
                                                        <a data-submenu="mobileHeadCatChild<?php echo $children['prodcat_id']; ?>" data-org-url="<?php echo $subCatOrgUrl; ?>" href="<?php echo $subCatUrl; ?>"><?php echo $children['prodcat_name']; ?></a>
                                                        <div id="mobileHeadCatChild<?php echo $children['prodcat_id']; ?>" class="submenu">
                                                            <div class="submenu-header" data-submenu-close="mobileHeadCatChild<?php echo $children['prodcat_id']; ?>">
                                                                <a href="#"><?php echo $link['nlink_caption'] ?></a>
                                                            </div>
                                                            <label><?php echo $children['prodcat_name']; ?></label>
                                                            <ul>
                                                                <?php
                                                                foreach ($children['children'] as $childCat) {
                                                                    $catUrl = UrlHelper::generateUrl('category', 'view', array($childCat['prodcat_id']));
                                                                    $catOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                                                ?>
                                                                    <li>
                                                                        <a data-org-url="<?php echo $catOrgUrl; ?>" href="<?php echo $catUrl; ?>">
                                                                            <span><?php echo $childCat['prodcat_name']; ?></span>
                                                                        </a>
                                                                    </li>
                                                                <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                <?php
                                }
                                ?>

                            </li>
                        <?php }
                    }

                    if ($navLinkCount < count($nav['pages'])) { ?>
                        <li class="seemore is-mobile ">
                            <a href="<?php echo UrlHelper::generateUrl('Category'); ?>">
                                <?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?>
                            </a>
                        </li>
                    <?php }
                }
            }

            if ($isMegaMenuEnabled == Navigations::LAYOUT_MEGA_MENU && !empty($headerCategories)) {
                foreach ($headerCategories as $link) {
                    $href = UrlHelper::generateUrl('category', 'view', array($link['prodcat_id']));
                    $OrgnavUrl = UrlHelper::generateUrl('category', 'view', array($link['prodcat_id']), '', false);
                    if (0 < count($link['children'])) {
                        $href = '#';
                    }
                    ?>
                    <li class="<?php echo (isset($link['children']) && count($link['children']) > 0 ? 'has-submenu' : ''); ?>">
                        <?php if (!isset($link['children']) || 1 > count($link['children'])) { ?>
                            <a href="<?php echo $href; ?>"><?php echo $link['prodcat_name']; ?></a>
                        <?php } else { ?>
                            <a data-submenu="mobileHeadCat<?php echo $link['prodcat_id']; ?>" data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $href; ?>"><?php echo $link['prodcat_name']; ?></a>
                            <div id="mobileHeadCat<?php echo  $link['prodcat_id']; ?>" class="submenu">
                                <div class="submenu-header" data-submenu-close="mobileHeadCat<?php echo $link['prodcat_id']; ?>">
                                    <a href="#"><?php echo Labels::getLabel('NAV_MAIN_MENU', $siteLangId); ?></a>
                                </div>
                                <label><?php echo $link['prodcat_name']; ?></label>
                                <ul>
                                    <?php
                                    foreach ($link['children'] as $children) {
                                        $subCatUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']));
                                        $subCatOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                    ?>
                                        <li class="<?php echo (isset($children['children']) && count($children['children']) > 0 ? 'has-submenu' : ''); ?>">
                                            <?php if (!isset($children['children']) || 1 > count($children['children'])) { ?>
                                                <a href="<?php echo $subCatUrl; ?>"><?php echo $children['prodcat_name']; ?></a>
                                            <?php } else { ?>
                                                <a data-submenu="mobileHeadCatChild<?php echo $children['prodcat_id']; ?>" data-org-url="<?php echo $subCatOrgUrl; ?>" href="<?php echo $subCatUrl; ?>"><?php echo $children['prodcat_name']; ?></a>
                                                <div id="mobileHeadCatChild<?php echo $children['prodcat_id']; ?>" class="submenu">
                                                    <div class="submenu-header" data-submenu-close="mobileHeadCatChild<?php echo $children['prodcat_id']; ?>">
                                                        <a href="#"><?php echo $link['prodcat_name'] ?></a>
                                                    </div>
                                                    <label><?php echo $children['prodcat_name']; ?></label>
                                                    <ul>
                                                        <?php
                                                        foreach ($children['children'] as $childCat) {
                                                            $catUrl = UrlHelper::generateUrl('category', 'view', array($childCat['prodcat_id']));
                                                            $catOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                                        ?>
                                                            <li>
                                                                <a data-org-url="<?php echo $catOrgUrl; ?>" href="<?php echo $catUrl; ?>">
                                                                    <span><?php echo $childCat['prodcat_name']; ?></span>
                                                                </a>
                                                            </li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <li class="seemore"><a href="<?php echo UrlHelper::generateUrl('Category'); ?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?></a></li>
            <?php } ?>
        </ul>
        <!-- End Mobile Navigation Bar -->
    <?php } ?>
<?php } ?>