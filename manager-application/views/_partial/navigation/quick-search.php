<div class="quick-search">
    <form method="get" class="form form--quick-search">
        <div class="quick-search__form">
            <input id="quickSearch" type="search" class="form-control" placeholder="<?php echo Labels::getLabel('LBL_GO_TO..', $siteLangId); ?>">
        </div>
        <div class="quick-search__wrapper">
            <ul class="list list--search-result navMenuItems">
                <?php if (
                    $objPrivilege->canViewBrands(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShops(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_PRODUCT_CATALOG', $siteLangId); ?></h6>
                        <?php if ($objPrivilege->canViewBrands(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Brands'); ?>"><?php echo Labels::getLabel('NAV_BRANDS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewShops(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Shops'); ?>"><?php echo Labels::getLabel('NAV_SHOPS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ProductCategories'); ?>"><?php echo Labels::getLabel('NAV_CATEGORIES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewBrandRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellerApprovalRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewRatingTypes(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellerProducts(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_REQUESTS', $siteLangId); ?></h6>
                        <?php if ($objPrivilege->canViewBrandRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('brandRequests'); ?>"><?php echo Labels::getLabel('NAV_BRAND_REQUEST', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ProductCategoriesRequest'); ?>"><?php echo Labels::getLabel('NAV_CATEGORIES_REQUESTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewSellerApprovalRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('sellerApprovalRequests'); ?>"><?php echo Labels::getLabel('NAV_SELLER_APPROVAL_REQUESTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewSellerProducts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('thresholdProducts'); ?>"><?php echo Labels::getLabel('NAV_THRESHOLD_PRODUCTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewRatingTypes(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('RatingTypes'); ?>"><?php echo Labels::getLabel('NAV_RATING_TYPES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewOrderCancelReasons(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOrderReturnReasons(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOrderStatus(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_ORDERS', $siteLangId); ?></h6>
                        <?php if ($objPrivilege->canViewOrderCancelReasons(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('OrderCancelReasons'); ?>"><?php echo Labels::getLabel('NAV_ORDER_CANCEL_REASONS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewOrderReturnReasons(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('OrderReturnReasons'); ?>"><?php echo Labels::getLabel('NAV_ORDER_RETURN_REASONS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewOrderStatus(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('OrderStatus'); ?>"><?php echo Labels::getLabel('NAV_ORDER_STATUSES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewUsers(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_USERS', $siteLangId); ?></h6>
                        <?php if ($objPrivilege->canViewOrderCancelReasons(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Users'); ?>"><?php echo Labels::getLabel('NAV_USERS', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Rewards'); ?>"><?php echo Labels::getLabel('NAV_REWARDS', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Transactions'); ?>"><?php echo Labels::getLabel('NAV_TRANSACTIONS', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('DeletedUsers'); ?>"><?php echo Labels::getLabel('NAV_DELETED_USERS', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('UsersAddresses'); ?>"><?php echo Labels::getLabel('NAV_USERS_ADDRESSES', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('userGdprRequests'); ?>"><?php echo Labels::getLabel('NAV_GDPR_REQUESTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewProducts(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewPromotions(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewRewardsOnPurchase(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewRecomendedWeightages(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_PROMOTIONS', $siteLangId); ?></h6>
                        <?php if ($objPrivilege->canViewBlogPostCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SpecialPrice'); ?>"><?php echo Labels::getLabel('NAV_SPECIAL_PRICE', $siteLangId); ?></a>
                            </div>

                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('VolumeDiscount'); ?>"><?php echo Labels::getLabel('NAV_VOLUME_DISCOUNT', $siteLangId); ?></a>
                            </div>

                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('RelatedProducts'); ?>"><?php echo Labels::getLabel('NAV_RELATED_PRODUCTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewPromotions(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('promotions'); ?>"><?php echo Labels::getLabel('NAV_PROMOTIONS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewRewardsOnPurchase(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('RewardsOnPurchase'); ?>"><?php echo Labels::getLabel('NAV_REWARDS_ON_PURCHASE', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewRecomendedWeightages(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SmartRecomendedWeightages'); ?>"><?php echo Labels::getLabel('NAV_MANAGE_WEIGHTAGES', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('RecomendedTagProducts'); ?>"><?php echo Labels::getLabel('NAV_RECOMMENDED_TAG_PRODUCTS_WEIGHTAGES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewBlogPostCategories(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBlogPosts(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBlogContributions(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBlogComments(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_BLOG', $siteLangId); ?></h6>
                        <?php if ($objPrivilege->canViewBlogPostCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('BlogPostCategories'); ?>"><?php echo Labels::getLabel('NAV_BLOG_POST_CATEGORIES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewBlogPosts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('BlogPosts'); ?>"><?php echo Labels::getLabel('NAV_BLOG_POSTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewBlogContributions(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('BlogContributions'); ?>"><?php echo Labels::getLabel('NAV_BLOG_CONTRIBUTIONS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewBlogComments(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('BlogComments'); ?>"><?php echo Labels::getLabel('NAV_BLOG_COMMENTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewTax(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_TAX', $siteLangId); ?></h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('TaxCategories'); ?>"><?php echo Labels::getLabel('NAV_TAX_CATEGORIES', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('TaxCategoriesRule'); ?>"><?php echo Labels::getLabel('NAV_TAX_CATEGORIES_RULE', $siteLangId); ?></a>
                        </div>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewContentPages(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewContentBlocks(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_CMS', $siteLangId); ?></h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ContentPages'); ?>"><?php echo Labels::getLabel('NAV_CONTENT_PAGES', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ContentBlock'); ?>"><?php echo Labels::getLabel('NAV_CONTENT_BLOCK', $siteLangId); ?></a>
                        </div>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewSalesReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCatalogReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductsReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShopsReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_SALES_REPORTS', $siteLangId); ?></h6>
                        <?php if ($objPrivilege->canViewSalesReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SalesReport'); ?>"><?php echo Labels::getLabel('NAV_SALES_OVER_TIME', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewCatalogReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('CatalogReport'); ?>"><?php echo Labels::getLabel('NAV_PRODUCTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewProductsReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ProductsReport'); ?>"><?php echo Labels::getLabel('NAV_PRODUCT_VARIENTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewShopsReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ShopsReport'); ?>"><?php echo Labels::getLabel('NAV_SHOPS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewShopsReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('BuyersReport'); ?>"><?php echo Labels::getLabel('NAV_CUSTOMERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewFinancialReport(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_FINANCIAL_REPORT', $siteLangId); ?></h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('EarningsReport'); ?>"><?php echo Labels::getLabel('NAV_EARNINGS', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ProductProfitReport'); ?>"><?php echo Labels::getLabel('NAV_PROFIT_BY_PRODUCTS', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('PreferredPaymentMethod'); ?>"><?php echo Labels::getLabel('NAV_PREFERRED_PAYMENT_METHOD', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('payoutReport'); ?>"><?php echo Labels::getLabel('NAV_PAYOUT', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('TransactionReport'); ?>"><?php echo Labels::getLabel('NAV_TRANSACTION_REPORT', $siteLangId); ?></a>
                        </div>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewSubscriptionReport(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_SUBSCRIPTION_REPORT', $siteLangId); ?></h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SubscriptionPlanReport'); ?>"><?php echo Labels::getLabel('NAV_BY_PLAN', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SubscriptionSellerReport'); ?>"><?php echo Labels::getLabel('NAV_BY_SELLER', $siteLangId); ?></a>
                        </div>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewImportExport(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_IMPORT_EXPORT', $siteLangId); ?></h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ImportExport'); ?>"><?php echo Labels::getLabel('NAV_IMPORT_EXPORT', $siteLangId); ?></a>
                        </div>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewSitemap(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewUrlRewrite(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewMetaTags(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_SEO', $siteLangId); ?></h6>
                        <?php if ($objPrivilege->canViewUrlRewrite(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('UrlRewriting'); ?>"><?php echo Labels::getLabel('NAV_URL_REWRITING', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewImageAttributes(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ImageAttributes'); ?>"><?php echo Labels::getLabel('NAV_IMAGE_ATTRIBUTES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewUrlRewrite(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('sitemap', 'generate'); ?>"><?php echo Labels::getLabel('NAV_GENERATE_SITEMAP', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateFullUrl('custom', 'sitemap', array(), CONF_WEBROOT_FRONT_URL); ?>"><?php echo Labels::getLabel('NAV_VIEW_HTML', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL) . 'sitemap.xml'; ?>"><?php echo Labels::getLabel('NAV_VIEW_XML', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewMetaTags(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateFullUrl('MetaTags'); ?>"><?php echo Labels::getLabel('NAV_META_TAGS_MANAGEMENT', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewGeneralSettings(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewPlugins(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewPaymentMethods(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCurrencyManagement(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCommissionSettings(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewAffiliateCommissionSettings(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellerPackages(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewThemeColor(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewZones(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCountries(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewStates(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewEmptyCartItems(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewAbusiveWords(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li>
                        <h6 class="title"><?php echo Labels::getLabel('NAV_SETTINGS', $siteLangId); ?></h6>
                        <?php if ($objPrivilege->canViewGeneralSettings(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('configurations'); ?>"><?php echo Labels::getLabel('LBL_GENERAL_SETTINGS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewPlugins(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Plugins'); ?>"><?php echo Labels::getLabel('LBL_PLUGINS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewLanguageLabels(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Labels'); ?>"><?php echo Labels::getLabel('LBL_LABELS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewThemeColor(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ThemeColor'); ?>"><?php echo Labels::getLabel('LBL_THEME', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewCurrencyManagement(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('CurrencyManagement'); ?>"><?php echo Labels::getLabel('LBL_CURRENCIES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewCommissionSettings(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Commission'); ?>"><?php echo Labels::getLabel('LBL_SITE_COMMISSION', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewAffiliateCommissionSettings(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('AffiliateCommission'); ?>"><?php echo Labels::getLabel('LBL_AFFILIATE_COMMISSION', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewSellerPackages(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SellerPackages'); ?>"><?php echo Labels::getLabel('LBL_SELLER_PACKAGES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewZones(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Zones'); ?>"><?php echo Labels::getLabel('LBL_ZONES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewCountries(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Countries'); ?>"><?php echo Labels::getLabel('LBL_COUNTRIES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewStates(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('States'); ?>"><?php echo Labels::getLabel('LBL_STATES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewAbusiveWords(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('AbusiveWords'); ?>"><?php echo Labels::getLabel('LBL_ABUSIVE_KEYWORDS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewEmptyCartItems(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-link">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('emptyCartItems'); ?>"><?php echo Labels::getLabel('LBL_EMPTY_CART', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </form>
</div>