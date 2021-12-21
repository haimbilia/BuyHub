<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php if ($headerNavigation || $headerCategories) {
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
    }

?>
    <!-- <div class="navigation-wrapper">
        <ul class="navigations <?php echo ($navLinkCount > 4) ? 'justify-content-between' : ''; ?>">
            <?php if (count($headerCategories)) { ?>
                <li class="navchild categories">
                    <a class="categories-link" href="javascript:void(0)">
                        <i class="c-hamburger js-hamburger">
                            <span class="c-hamburger__line c-hamburger__line--top"></span>
                            <span class="c-hamburger__line c-hamburger__line--middle"></span>
                            <span class="c-hamburger__line c-hamburger__line--bottom"></span>
                        </i>

                        <?php echo Labels::getLabel('LBL_Shop_by_Categories', $siteLangId); ?>

                    </a>
                    <span class="link__mobilenav"></span>
                    <div class="vertical-menu">
                        <ul class="menu">
                            <?php
                            $count = 0;
                            foreach ($headerCategories as $link) {
                                $count++;
                                if ($count > 9) {
                                    break;
                                }
                                $navUrl = UrlHelper::generateUrl('category', 'view', array($link['prodcat_id']));
                                $OrgnavUrl = UrlHelper::generateUrl('category', 'view', array($link['prodcat_id']), '', null, false, $getOrgUrl);

                                $href = $navUrl;
                                $navchild = '';
                                $class = '';
                                if (0 < count($link['children'])) {
                                    // $href = 'javascript:void(0)';
                                    $navchild = 'navchild';
                                    $class = 'has-child';
                                } ?>
                                <li class="<?php echo $class; ?>"><a data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $href; ?>"><?php echo $link['prodcat_name']; ?></a>
                                    <?php if (isset($link['children']) && count($link['children']) > 0) { ?>
                                        <div class="megadrop">
                                            <ul class="sublinks">
                                                <?php $subyChild = 0;
                                                foreach ($link['children'] as $children) {
                                                    $subCatUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']));
                                                    $subCatOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                                ?>
                                                    <li class="head"><a class="level2" data-org-url="<?php echo $subCatOrgUrl; ?>" href="<?php echo $subCatUrl; ?>"><?php echo $children['prodcat_name']; ?></a>
                                                        <?php if (isset($children['children']) && count($children['children']) > 0) { ?>
                                                            <ul>
                                                                <?php $subChild = 0;
                                                                foreach ($children['children'] as $childCat) {
                                                                    $catUrl = UrlHelper::generateUrl('category', 'view', array($childCat['prodcat_id']));
                                                                    $catOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                                                ?>
                                                                    <li><a data-org-url="<?php echo $catOrgUrl; ?>" href="<?php echo $catUrl; ?>"><?php echo $childCat['prodcat_name']; ?></a>
                                                                    </li>
                                                                    <?php
                                                                    if ($subChild++ == 4) {
                                                                        break;
                                                                    }
                                                                }
                                                                if (count($children['children']) > 5) { ?>
                                                                    <li class="seemore"><a data-org-url="<?php echo $subCatOrgUrl; ?>" href="<?php echo $subCatUrl; ?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?></a>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        <?php } ?>
                                                    </li>
                                                <?php
                                                    if ($subyChild++ == 7) {
                                                        break;
                                                    }
                                                } ?>
                                            </ul>
                                            <?php if (count($link['children']) > 8) { ?>
                                                <a class="btn btn-sm btn--secondary ripplelink " data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $navUrl; ?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?></a>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                            <li class="all-categories"><a data-org-url="<?php echo UrlHelper::generateUrl('category', '', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo UrlHelper::generateUrl('category'); ?>" class=""><?php echo Labels::getLabel('LBL_View_All_Categories', $siteLangId); ?></a></li>
                        </ul>
                    </div>
                </li>
            <?php } ?>
            <?php
            if (count($headerNavigation)) {
                foreach ($headerNavigation as $nav) {
                    if ($nav['pages']) {
                        $mainNavigation = array_slice($nav['pages'], 0, $navLinkCount);
                        foreach ($mainNavigation as $link) {
                            $navUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']);
                            $OrgnavUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'], $getOrgUrl);

                            $href = $navUrl;
                            $navchild = '';
                            $target = $link['nlink_target'];
                            if (0 < count($link['children'])) {
                                $href = 'javascript:void(0)';
                                $navchild = 'navchild';
                                $target = '_self';
                            }
            ?>
                            <li class=" <?php echo $navchild; ?>">
                                <a target="<?php echo $target; ?>" data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $href; ?>"><?php echo $link['nlink_caption']; ?></a>
                                <?php if (isset($link['children']) && count($link['children']) > 0) { ?>
                                    <span class="link__mobilenav"></span>
                                    <div class="subnav">
                                        <div class="subnav__wrapper ">
                                            <div class="container">
                                                <div class="subnav_row">
                                                    <ul class="sublinks">
                                                        <?php $subyChild = 0;
                                                        foreach ($link['children'] as $children) {
                                                            $subCatUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']));
                                                            $subCatOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                                        ?>
                                                            <li class="head"><a class="level2" data-org-url="<?php echo $subCatOrgUrl; ?>" href="<?php echo $subCatUrl; ?>"><?php echo $children['prodcat_name']; ?></a>
                                                                <?php if (isset($children['children']) && count($children['children']) > 0) { ?>
                                                                    <ul>
                                                                        <?php $subChild = 0;
                                                                        foreach ($children['children'] as $childCat) {
                                                                            $catUrl = UrlHelper::generateUrl('category', 'view', array($childCat['prodcat_id']));
                                                                            $catOrgUrl = UrlHelper::generateUrl('category', 'view', array($children['prodcat_id']), '', null, false, $getOrgUrl);
                                                                        ?>
                                                                            <li><a data-org-url="<?php echo $catOrgUrl; ?>" href="<?php echo $catUrl; ?>"><?php echo $childCat['prodcat_name']; ?></a>
                                                                            </li>
                                                                            <?php
                                                                            if ($subChild++ == 4) {
                                                                                break;
                                                                            }
                                                                        }
                                                                        if (count($children['children']) > 5) { ?>
                                                                            <li class="seemore"><a data-org-url="<?php echo $subCatOrgUrl; ?>" href="<?php echo $subCatUrl; ?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?></a>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                <?php } ?>
                                                            </li>
                                                        <?php
                                                            if ($subyChild++ == 7) {
                                                                break;
                                                            }
                                                        } ?>
                                                    </ul>
                                                    <?php if (count($link['children']) > 8) { ?>
                                                        <a class="btn btn-sm btn--secondary ripplelink " data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $navUrl; ?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </li>
            <?php
                        }
                    }
                }
            } ?>






            <?php
            foreach ($headerNavigation as $nav) {
                $subMoreNavigation = (count($nav['pages']) > $navLinkCount) ? array_slice($nav['pages'], $navLinkCount) : array();

                if (count($subMoreNavigation)) {    ?>
                    <li class="navchild three-pin">
                        <a href="javascript:void(0)" class="more"><span><?php echo Labels::getLabel('L_More', $siteLangId); ?></span>
                        </a>
                        <span class="link__mobilenav"></span>
                        <div class="subnav">
                            <div class="subnav__wrapper ">
                                <div class="container">
                                    <div class="subnav_row">
                                        <ul class="sublinks">
                                            <?php
                                            foreach ($subMoreNavigation as $index => $link) {
                                                $url = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']);
                                                $OrgUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'], $getOrgUrl);
                                            ?>
                                                <li><a target="<?php echo $link['nlink_target']; ?>" data-org-url="<?php echo $OrgUrl; ?>" href="<?php echo $url; ?>"><?php echo $link['nlink_caption']; ?></a>
                                                    <?php
                                                    if (count($link['children']) > 0) { ?>
                                                        <ul>
                                                            <?php foreach ($link['children'] as $subCat) {
                                                                $catUrl = UrlHelper::generateUrl('category', 'view', array($subCat['prodcat_id']));
                                                                $catOrgUrl = UrlHelper::generateUrl('category', 'view', array($subCat['prodcat_id']), '', null, false, $getOrgUrl); ?>
                                                                <li><a data-org-url="<?php echo $catOrgUrl; ?>" href="<?php echo $catUrl; ?>"><?php echo $subCat['prodcat_name']; ?></a></li>
                                                                <?php /*if (isset($subCat['children'])) { ?>
                                            <ul>
                                                        <?php
                                                        $subChild = 0;
                                                        foreach ($subCat['children'] as $childCat) {
                                                            $childCatUrl = UrlHelper::generateUrl('category', 'view', array( $childCat['prodcat_id']));
                                                            $childCatOrgUrl = UrlHelper::generateUrl('category', 'view', array( $childCat['prodcat_id']), '', null, false, $getOrgUrl); ?>
                                                <li><a data-org-url="<?php echo $childCatOrgUrl; ?>" href="<?php echo $childCatUrl; ?>"><?php echo $childCat['prodcat_name'];?></a></li>
                                                            <?php
                                                            if ($subChild++ == 4) {
                                                                    break;
                                                            }
                                                        }
                                                        if (count($subCat['children']) > 5) {?>
                                                    <li class="seemore"><a data-org-url="<?php echo $catOrgUrl; ?>"
                                                            href="<?php echo $catUrl;?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId);?></a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                                <?php }*/ ?>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <?php /* <a data-org-url="<?php echo UrlHelper::generateUrl('category', '', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo UrlHelper::generateUrl('category');?>"
                                        class="btn btn-sm btn--secondary ripplelink "><?php Labels::getLabel('LBL_View_All_Categories', $siteLangId);?></a> */ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
            <?php }
            } ?>
            <?php if ($top_header_navigation && count($top_header_navigation)) { ?>
                <?php foreach ($top_header_navigation as $nav) {
                    if ($nav['pages']) {
                        $getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
                        foreach ($nav['pages'] as $link) {
                            $navUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']);
                            $OrgnavUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'], $getOrgUrl); ?>
                            <li class="d-xl-none"><a target="<?php echo $link['nlink_target']; ?>" data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $navUrl; ?>"><?php echo $link['nlink_caption']; ?></a></li>
                <?php }
                    }
                } ?>
            <?php } ?>
        </ul>

    </div> -->

     
        <div class="mega-nav mega-nav--desktop@md position-relative js-mega-nav mega-nav--desktop">
            <div class="mega-nav__container">
                <div class="mega-nav__icon-btns mega-nav__icon-btns--mobile">
                    
                <a href="#0" class="mega-nav__icon-btn">
                    <svg class="icon" viewBox="0 0 24 24">
                            <title>Go to account settings</title>
                            <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                                <circle cx="12" cy="6" r="4" />
                                <path d="M12 13a8 8 0 00-8 8h16a8 8 0 00-8-8z" />
                            </g>
                        </svg> </a><button class="reset mega-nav__icon-btn mega-nav__icon-btn--search js-tab-focus" aria-label="Toggle search" aria-controls="mega-nav-search"><svg class="icon" viewBox="0 0 24 24">
                            <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                                <path d="M4.222 4.222l15.556 15.556" />
                                <path d="M19.778 4.222L4.222 19.778" />
                                <circle cx="9.5" cy="9.5" r="6.5" />
                            </g>
                        </svg></button> <button class="reset mega-nav__icon-btn mega-nav__icon-btn--menu js-tab-focus" aria-label="Toggle menu" aria-controls="mega-nav-navigation"><svg class="icon" viewBox="0 0 24 24">
                            <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                                <path d="M1 6h22" />
                                <path d="M1 12h22" />
                                <path d="M1 18h22" />
                            </g>
                        </svg></button></div>
                <div class="mega-nav__nav js-mega-nav__nav" id="mega-nav-navigation" role="navigation" aria-label="Main">
                    <div class="mega-nav__nav-inner">
                        <ul class="mega-nav__items">
                            <li class="mega-nav__label">Menu</li>
                            <li class="mega-nav__item js-mega-nav__item"><button class="reset mega-nav__control js-mega-nav__control js-tab-focus">Products <i class="mega-nav__arrow-icon" aria-hidden="true"><svg class="icon" viewBox="0 0 16 16">
                                            <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                                                <path d="M2 2l12 12" />
                                                <path d="M14 2L2 14" />
                                            </g>
                                        </svg></i></button>
                                <div class="mega-nav__sub-nav-wrapper">
                                    <div class="mega-nav__sub-nav mega-nav__sub-nav--layout-1">
                                        <ul class="mega-nav__sub-items">
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link"><span class="flex items-center gap-xs"><img class="block width-lg height-lg radius-50% object-cover" src="../../../app/assets/img/mega-site-nav-img-1.jpg" alt="Image description"> <i>Product One</i></span></a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link"><span class="flex items-center gap-xs"><img class="block width-lg height-lg radius-50% object-cover" src="../../../app/assets/img/mega-site-nav-img-2.jpg" alt="Image description"> <i>Product Two</i></span></a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link"><span class="flex items-center gap-xs"><img class="block width-lg height-lg radius-50% object-cover" src="../../../app/assets/img/mega-site-nav-img-3.jpg" alt="Image description"> <i>Product Three</i></span></a></li>
                                        </ul>
                                        <div class="mega-nav__tabs grid gap-lg js-tabs" data-tabs-layout="vertical">
                                            <ul class="col-4 mega-nav__tabs-controls js-tabs__controls" aria-label="Select a product">
                                                <li><a href="#tabProduct1" class="mega-nav__tabs-control js-tab-focus" aria-selected="true"><span class="flex items-center gap-xs"><img class="block width-lg height-lg radius-50% object-cover" src="../../../app/assets/img/mega-site-nav-img-1.jpg" alt="Image description"> <i class="margin-right-xxxs">Product One</i> <svg class="icon icon--xs margin-left-auto" viewBox="0 0 16 16" aria-hidden="true">
                                                                <path d="M5,2l6,6L5,14" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1" />
                                                            </svg></span></a></li>
                                                <li><a href="#tabProduct2" class="mega-nav__tabs-control js-tab-focus" aria-selected="true"><span class="flex items-center gap-xs"><img class="block width-lg height-lg radius-50% object-cover" src="../../../app/assets/img/mega-site-nav-img-2.jpg" alt="Image description"> <i class="margin-right-xxxs">Product Two</i> <svg class="icon icon--xs margin-left-auto" viewBox="0 0 16 16" aria-hidden="true">
                                                                <path d="M5,2l6,6L5,14" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1" />
                                                            </svg></span></a></li>
                                                <li><a href="#tabProduct3" class="mega-nav__tabs-control js-tab-focus" aria-selected="true"><span class="flex items-center gap-xs"><img class="block width-lg height-lg radius-50% object-cover" src="../../../app/assets/img/mega-site-nav-img-3.jpg" alt="Image description"> <i class="margin-right-xxxs">Product Three</i> <svg class="icon icon--xs margin-left-auto" viewBox="0 0 16 16" aria-hidden="true">
                                                                <path d="M5,2l6,6L5,14" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1" />
                                                            </svg></span></a></li>
                                            </ul>
                                            <div class="col-8 js-tabs__panels">
                                                <section id="tabProduct1" class="mega-nav__tabs-panel js-tabs__panel"><a href="#0" class="mega-nav__tabs-img margin-bottom-md"><img class="block width-100%" src="../../../app/assets/img/mega-site-nav-img-1.jpg" alt="Image description"></a>
                                                    <div class="text-component">
                                                        <h1 class="text-xl">Product One</h1>
                                                        <p class="color-contrast-medium">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, quaerat.</p>
                                                        <p class="flex gap-xxs"><a href="#0" class="btn btn--subtle">Learn More</a> <a href="#0" class="btn btn--primary">Buy</a></p>
                                                    </div>
                                                </section>
                                                <section id="tabProduct2" class="mega-nav__tabs-panel js-tabs__panel"><a href="#0" class="mega-nav__tabs-img margin-bottom-md"><img class="block width-100%" src="../../../app/assets/img/mega-site-nav-img-2.jpg" alt="Image description"></a>
                                                    <div class="text-component">
                                                        <h1 class="text-xl">Product Two</h1>
                                                        <p class="color-contrast-medium">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, quaerat.</p>
                                                        <p class="flex gap-xxs"><a href="#0" class="btn btn--subtle">Learn More</a> <a href="#0" class="btn btn--primary">Buy</a></p>
                                                    </div>
                                                </section>
                                                <section id="tabProduct3" class="mega-nav__tabs-panel js-tabs__panel"><a href="#0" class="mega-nav__tabs-img margin-bottom-md"><img class="block width-100%" src="../../../app/assets/img/mega-site-nav-img-3.jpg" alt="Image description"></a>
                                                    <div class="text-component">
                                                        <h1 class="text-xl">Product Three</h1>
                                                        <p class="color-contrast-medium">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, quaerat.</p>
                                                        <p class="flex gap-xxs"><a href="#0" class="btn btn--subtle">Learn More</a> <a href="#0" class="btn btn--primary">Buy</a></p>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="mega-nav__item js-mega-nav__item"><button class="reset mega-nav__control js-mega-nav__control js-tab-focus">Lists <i class="mega-nav__arrow-icon" aria-hidden="true"><svg class="icon" viewBox="0 0 16 16">
                                            <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                                                <path d="M2 2l12 12" />
                                                <path d="M14 2L2 14" />
                                            </g>
                                        </svg></i></button>
                                <div class="mega-nav__sub-nav-wrapper">
                                    <div class="mega-nav__sub-nav mega-nav__sub-nav--layout-2">
                                        <ul class="mega-nav__sub-items">
                                            <li class="mega-nav__label">Clothing</li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">All Clothing</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Coats</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Dresses</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Jackets</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Jeans</a></li>
                                        </ul>
                                        <ul class="mega-nav__sub-items">
                                            <li class="mega-nav__label">Shoes</li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">All Shoes</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Trainers</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Heels</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Boots</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Ankle Boots</a></li>
                                        </ul>
                                        <ul class="mega-nav__sub-items">
                                            <li class="mega-nav__label">Sports</li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">All Sports</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Basketball</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Fitness</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Football</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Golf</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Running</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Swimming</a></li>
                                        </ul>
                                        <ul class="mega-nav__sub-items">
                                            <li class="mega-nav__label">Accessories</li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">All Accessories</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Bags</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Jewellery</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Watches</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Scarves</a></li>
                                        </ul>
                                        <div class="mega-nav__card width-100% max-width-xs margin-x-auto"><a href="#0" class="block radius-lg overflow-hidden">
                                                <figure class="aspect-ratio-4:3"><img class="block width-100%" src="../../../app/assets/img/mega-site-nav-img-1.jpg" alt="Image description"></figure>
                                            </a>
                                            <div class="margin-top-sm">
                                                <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Browse all →</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="mega-nav__item js-mega-nav__item"><button class="reset mega-nav__control js-mega-nav__control js-tab-focus">Gallery <i class="mega-nav__arrow-icon" aria-hidden="true"><svg class="icon" viewBox="0 0 16 16">
                                            <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                                                <path d="M2 2l12 12" />
                                                <path d="M14 2L2 14" />
                                            </g>
                                        </svg></i></button>
                                <div class="mega-nav__sub-nav-wrapper">
                                    <div class="mega-nav__sub-nav mega-nav__sub-nav--layout-3">
                                        <div class="mega-nav__card"><a href="#0" class="block radius-lg overflow-hidden">
                                                <figure class="aspect-ratio-4:3"><img class="block width-100%" src="../../../app/assets/img/mega-site-nav-img-4.jpg" alt="Image description"></figure>
                                            </a>
                                            <div class="margin-top-sm">
                                                <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Clothing</a></h3>
                                            </div>
                                        </div>
                                        <div class="mega-nav__card"><a href="#0" class="block radius-lg overflow-hidden">
                                                <figure class="aspect-ratio-4:3"><img class="block width-100%" src="../../../app/assets/img/mega-site-nav-img-5.jpg" alt="Image description"></figure>
                                            </a>
                                            <div class="margin-top-sm">
                                                <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Shoes</a></h3>
                                            </div>
                                        </div>
                                        <div class="mega-nav__card"><a href="#0" class="block radius-lg overflow-hidden">
                                                <figure class="aspect-ratio-4:3"><img class="block width-100%" src="../../../app/assets/img/mega-site-nav-img-6.jpg" alt="Image description"></figure>
                                            </a>
                                            <div class="margin-top-sm">
                                                <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Home</a></h3>
                                            </div>
                                        </div>
                                        <div class="mega-nav__card"><a href="#0" class="block radius-lg overflow-hidden">
                                                <figure class="aspect-ratio-4:3"><img class="block width-100%" src="../../../app/assets/img/mega-site-nav-img-7.jpg" alt="Image description"></figure>
                                            </a>
                                            <div class="margin-top-sm">
                                                <h3 class="text-base"><a href="#0" class="mega-nav__card-title">Accessories</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="mega-nav__item js-mega-nav__item"><button class="reset mega-nav__control js-mega-nav__control js-tab-focus">Support <i class="mega-nav__arrow-icon" aria-hidden="true"><svg class="icon" viewBox="0 0 16 16">
                                            <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                                                <path d="M2 2l12 12" />
                                                <path d="M14 2L2 14" />
                                            </g>
                                        </svg></i></button>
                                <div class="mega-nav__sub-nav-wrapper">
                                    <div class="mega-nav__sub-nav mega-nav__sub-nav--layout-4">
                                        <ul class="mega-nav__sub-items">
                                            <li class="mega-nav__label">Help &amp; Support</li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Documentation</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Questions &amp; Answers</a></li>
                                            <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">Contact us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="mega-nav__label">Other</li>
                            <li class="mega-nav__item"><a href="#0" class="mega-nav__control">Link</a></li>
                        </ul>                        
                    </div>
                </div>
                
            </div>
        </div>
     

<?php } ?>