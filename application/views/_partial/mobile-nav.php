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
                foreach ($nav['pages'] as $link) {
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