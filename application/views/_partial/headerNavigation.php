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
        <ul class="navigation <?php echo ($navLinkCount > 4) ? 'justify-content-between' : ''; ?>">
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
    <!-- Start Navigation Bar -->
    <div class="navigation-wrapper">
        <ul class="navigation">
            <li class="navchild">
                <a target="_self" href="javascript:void(0);">Women</a>
                <span class="link__mobilenav"></span>
                <div class="subnav">
                    <div class="subnav__wrapper">
                        <div class="container">
                            <div class="nav__sub-panels">
                                <div class="nav__panel"><a class="nav__panel-title" href="womens-new-arrivals">NEW IN</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-party-looks"><span>Party Looks</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-tommy-x-rossignol"><span>TOMMYXROSSIGNOL</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="tommy-x-zendaya"><span>TOMMYXZENDAYA</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="women-hilfiger-collection"><span>Hilfiger
                                                    Collection</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-sustainable-evolution"><span>Sustainable
                                                    style</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-explore"><span>Explore</span></a></li>
                                    </ul>
                                </div>
                                <div class="nav__panel nav__panel--two-column"><a class="nav__panel-title" href="womens-clothes">Clothing</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-coats-jackets"><span>Coats &amp;
                                                    Jackets</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-hoodies-sweatshirts"><span>Sweatshirts
                                                    &amp;
                                                    Hoodies</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="ladies-knitwear"><span>Knitwear</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-dresses-jumpsuits"><span>Dresses &amp;
                                                    Jumpsuits</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-blazers"><span>Blazers</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-t-shirts"><span>T-Shirts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-tops"><span>Tops</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-shirts-blouses"><span>Shirts &amp;
                                                    Blouses</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="ladies-polo-shirts"><span>Polo Shirts</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-jeans"><span>Jeans</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-trending"><span>Trending</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="ladies-trousers"><span>Trousers</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-skirts"><span>Skirts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="ladies-shorts"><span>Shorts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-basics"><span>Basics</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-swimwear"><span>Swimwear</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-lingerie"><span>Lingerie</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-lounge-sleepwear"><span>Lounge &amp;
                                                    Nightwear</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-socks-tights"><span>Socks &amp;
                                                    Hosiery</span></a></li>
                                    </ul>
                                </div>
                                <div class="nav__panel "><a class="nav__panel-title" href="womens-bags-accessories">Bags &amp; Accessories</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-bags"><span>Bags</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="ladies-watches"><span>Watches</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-hats-gloves-scarves"><span>Hats, Gloves
                                                    &amp;
                                                    Scarves</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-purses-keyrings"><span>Wallets &amp;
                                                    Keyrings</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-belts"><span>Belts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-jewelry"><span>Jewellery</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-sunglasses"><span>Sunglasses</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-fragrances"><span>Fragrances</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="nav__panel "><a class="nav__panel-title" href="womens-shoes">SHOES</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-new-arrivals-shoes"><span>NEW IN</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-boots"><span>Boots</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-trainers"><span>Trainers</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-flats"><span>Flat Shoes</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-pumps"><span>Pumps</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="womens-sandals"><span>Sandals</span></a></li>
                                    </ul>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="navchild"><a target="_self" href="javascript:void(0);">Men</a> <span class="link__mobilenav"></span>
                <div class="subnav">
                    <div class="subnav__wrapper ">
                        <div class="container">
                            <div class="nav__sub-panels">
                                <div class="nav__panel">


                                    <a class="nav__panel-title" href="mens-new-arrivals">NEW IN</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-what-to-wear"><span>What to wear:
                                                    parties</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="men-tommy-x-rossignol"><span>TOMMYXROSSIGNOL</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="tommy-x-mercedes-amg-petronas-f1"><span>TOMMYXMERCEDES-BENZ</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="tommy-x-lewis"><span>TOMMYXLEWIS</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-hilfiger-collection"><span>Hilfiger
                                                    Collection</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-sustainable-evolution"><span>Sustainable
                                                    style</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-explore"><span>Explore</span></a></li>
                                    </ul>
                                </div>
                                <div class="nav__panel nav__panel--two-column"><a class="nav__panel-title" href="mens-clothes">Clothing</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-coats-jackets"><span>Coats &amp;
                                                    Jackets</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-sweatshirts-hoodies"><span>Sweatshirts &amp;
                                                    Hoodies</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-knitwear"><span>Knitwear</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-t-shirts"><span>T-Shirts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-shirts"><span>Shirts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-polo-shirts"><span>Polo Shirts</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-rugby-shirts"><span>Rugby Shirts</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-jeans"><span>Jeans</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-trousers"><span>Trousers</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-tracksuits"><span>Tracksuits</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-tailored-clothing"><span>Tailored</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-suits"><span>Suits</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-blazers"><span>Blazers</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-shorts"><span>Shorts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-basics"><span>Basics</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-swimwear"><span>Swimwear</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-underwear"><span>Underwear</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-lounge-sleepwear"><span>Lounge &amp;
                                                    Nightwear</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-socks"><span>Socks</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-big-tall"><span>Big &amp; Tall</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="nav__panel "><a class="nav__panel-title" href="mens-bags-accessories">Bags &amp; Accessories</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-bags"><span>Bags</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-watches"><span>Watches</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-hats-gloves-scarves"><span>Hats, Gloves &amp;
                                                    Scarves</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-wallets-keyrings"><span>Wallets &amp;
                                                    Keyrings</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-belts"><span>Belts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-jewelry-cufflinks"><span>Jewellery &amp;
                                                    Cufflinks</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-sunglasses"><span>Sunglasses</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-ties-pocket-squares"><span>Ties &amp; Pocket
                                                    Squares</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-fragrances"><span>Fragrances</span></a></li>
                                    </ul>
                                </div>
                                <div class="nav__panel "><a class="nav__panel-title" href="mens-shoes">Shoes</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-new-arrivals-shoes"><span>NEW IN</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-trainers"><span>Trainers</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-casual-shoes"><span>Casual Shoes</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-formal-shoes"><span>Formal Shoes</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-boots"><span>Boots</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="mens-sandals"><span>Sandals &amp; Flip
                                                    Flops</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="navchild"><a target="_self" href="/baby-kids">Baby &amp; Kids</a> <span class="link__mobilenav"></span>
                <div class="subnav">
                    <div class="subnav__wrapper ">
                        <div class="container">
                            <div class="nav__sub-panels">
                                <div class="nav__panel "><a class="nav__panel-title" href="kids-new-arrivals">NEW IN</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="kids-tommy-jeans-capsule-collection"><span>Tommy
                                                    Jeans
                                                    Capsule</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="sports-capsule"><span>Sports Capsule</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="kids-unisex"><span>Unisex</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="kids-holiday-season"><span>Holiday
                                                    season</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="kids-sustainable-evolution"><span>Sustainable
                                                    style</span></a></li>
                                    </ul>
                                </div>
                                <div class="nav__panel "><a class="nav__panel-title" href="boys">Boys</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="boys-coats-jackets"><span>Coats &amp;
                                                    Jackets</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="boys-sweatshirts-hoodies"><span>Sweatshirts &amp;
                                                    Hoodies</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="boys-jumpers-cardigans"><span>Knitwear</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="boys-tshirts-polos"><span>T-shirts &amp;
                                                    Polos</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="boys-shirts"><span>Shirts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="boys-jeans"><span>Jeans</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="boys-trousers"><span>Trousers &amp;
                                                    Shorts</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="boys-underwear-sleepwear"><span>Underwear &amp;
                                                    Socks</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="boys-shoes-accessories"><span>Shoes &amp;
                                                    Accessories</span></a></li>
                                    </ul>
                                </div>
                                <div class="nav__panel "><a class="nav__panel-title" href="girls">Girls</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="girls-coats-jackets"><span>Coats &amp;
                                                    Jackets</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="girls-sweatshirts-hoodies"><span>Sweatshirts &amp;
                                                    Hoodies</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="girls-dresses"><span>Dresses</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="girls-jumpers-cardigans"><span>Knitwear</span></a>
                                        </li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="girls-tops-tshirts"><span>Tops &amp;
                                                    T-shirts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="girls-jeans"><span>Jeans</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="girls-bottoms"><span>Trousers, Shorts &amp;
                                                    Skirts</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="girls-underwear-sleepwear"><span>Underwear &amp;
                                                    Socks</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="girls-shoes-accessories"><span>Shoes &amp;
                                                    Accessories</span></a></li>
                                    </ul>
                                </div>
                                <div class="nav__panel "><a class="nav__panel-title" href="babies">Babies</a>
                                    <ul class="nav__list">
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="baby-boys"><span>Boys</span></a></li>
                                        <li class="nav__list-item"><a class="nav__list-item__link " href="baby-girls"><span>Girls</span></a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="navchild"><a target="_self" href="/womens-fashion">Tommy Jeans</a> <span class="link__mobilenav"></span>
                <div class="subnav">
                    <div class="subnav__wrapper ">
                        <div class="container">
                            <div class="nav__sub-panels">
                                <div class="nav__sub-panels">
                                    <div class="nav__panel "><a class="nav__panel-title" href="tommy-jeans-women">TOMMY JEANS WOMEN</a>
                                        <ul class="nav__list">
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="women-tommy-jeans-capsule-collection"><span>TOMMY
                                                        JEANS Capsules</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-coats-jackets-tommy-jeans"><span>Coats
                                                        &amp; Jackets</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-sweatshirts-hoodies-tommy-jeans"><span>Sweatshirts
                                                        &amp; Hoodies</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-jeans-tommy-jeans"><span>Jeans</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-dresses-tommy-jeans"><span>Dresses</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-tops-tommy-jeans"><span>Tops</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="ladies-knitwear-tommy-jeans"><span>Knitwear</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-trousers-skirts-tommy-jeans"><span>Trousers
                                                        &amp; Skirts</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-shoes-accessories-tommy-jeans"><span>Shoes
                                                        &amp; Accessories</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="nav__panel "><a class="nav__panel-title" href="tommy-jeans-men">TOMMY JEANS MEN</a>
                                        <ul class="nav__list">
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="men-tommy-jeans-capsule-collection"><span>TOMMY
                                                        JEANS Capsules</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-coats-jackets-tommy-jeans"><span>Coats
                                                        &amp;
                                                        Jackets</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-sweatshirts-hoodies-tommy-jeans"><span>Sweatshirts
                                                        &amp; Hoodies</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-jeans-tommy-jeans"><span>Jeans</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-t-shirts-and-polo-shirts-tommy-jeans"><span>T-Shirts
                                                        &amp; Polos</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-shirts-tommy-jeans"><span>Shirts</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-jumpers-tommy-jeans"><span>Knitwear</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-trousers-tommy-jeans"><span>Trousers
                                                        &amp;
                                                        Shorts</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-shoes-accessories-tommy-jeans"><span>Shoes
                                                        &amp; Accessories</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="navchild"><a target="_self" href="javascript:void(0)">Tommy Sport</a></li>
            <li class="navchild"><a target="_self" href="javascript:void(0)">Gifts </a></li>
            <li class="navchild more">
                <a target="_self" href="javascript:void(0)">
                    <span class="d-xl-none">
                        More
                    </span>
                    <span class="d-none d-xl-block">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="media/retina/sprite.svg#hemburger" href="media/retina/sprite.svg#hemburger">
                            </use>
                        </svg>
                    </span>
                </a>
                <span class="link__mobilenav"></span>
                <div class="subnav">
                    <div class="subnav__wrapper ">
                        <div class="container">
                            <div class="nav__sub-panels">
                                <div class="nav__sub-panels">
                                    <div class="nav__panel "><a class="nav__panel-title" href="tommy-jeans-women">TOMMY JEANS WOMEN</a>
                                        <ul class="nav__list">
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="women-tommy-jeans-capsule-collection"><span>TOMMY
                                                        JEANS Capsules</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-coats-jackets-tommy-jeans"><span>Coats
                                                        &amp; Jackets</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-sweatshirts-hoodies-tommy-jeans"><span>Sweatshirts
                                                        &amp; Hoodies</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-jeans-tommy-jeans"><span>Jeans</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-dresses-tommy-jeans"><span>Dresses</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-tops-tommy-jeans"><span>Tops</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="ladies-knitwear-tommy-jeans"><span>Knitwear</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-trousers-skirts-tommy-jeans"><span>Trousers
                                                        &amp; Skirts</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="womens-shoes-accessories-tommy-jeans"><span>Shoes
                                                        &amp; Accessories</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="nav__panel "><a class="nav__panel-title" href="tommy-jeans-men">TOMMY JEANS MEN</a>
                                        <ul class="nav__list">
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="men-tommy-jeans-capsule-collection"><span>TOMMY
                                                        JEANS Capsules</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-coats-jackets-tommy-jeans"><span>Coats
                                                        &amp;
                                                        Jackets</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-sweatshirts-hoodies-tommy-jeans"><span>Sweatshirts
                                                        &amp; Hoodies</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-jeans-tommy-jeans"><span>Jeans</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-t-shirts-and-polo-shirts-tommy-jeans"><span>T-Shirts
                                                        &amp; Polos</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-shirts-tommy-jeans"><span>Shirts</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-jumpers-tommy-jeans"><span>Knitwear</span></a>
                                            </li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-trousers-tommy-jeans"><span>Trousers
                                                        &amp;
                                                        Shorts</span></a></li>
                                            <li class="nav__list-item"><a class="nav__list-item__link " href="mens-shoes-accessories-tommy-jeans"><span>Shoes
                                                        &amp; Accessories</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <!-- End Navigation Bar -->





<?php } ?>