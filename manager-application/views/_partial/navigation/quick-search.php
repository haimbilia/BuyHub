<div class="quick-search">
    <form method="get" class="form  quick-search-form">
        <div class="quick-search-head">
            <input id="quickSearchJs" type="search" class="form-control" placeholder="<?php echo Labels::getLabel('LBL_GO_TO..', $siteLangId); ?>">
        </div>
        <div class="quick-search-body">
            <ul class="quick-search-list navMenuItems">
                <?php if (
                    $objPrivilege->canViewBrands(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShops(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProducts(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellerProducts(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOptions(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-dashboard">
                                    </use>
                                </svg>
                            </i>

                            <?php echo Labels::getLabel('NAV_PRODUCT_CATALOG', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewBrands(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ProductCategories'); ?>"><?php echo Labels::getLabel('NAV_CATEGORIES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewProducts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Products'); ?>"><?php echo Labels::getLabel('NAV_PRODUCTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewSellerProducts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('sellerProducts'); ?>"><?php echo Labels::getLabel('NAV_SELLER_INVENTORY', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewOptions(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Options'); ?>"><?php echo Labels::getLabel('NAV_OPTIONS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewBrandRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellerApprovalRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellerProducts(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewWithdrawRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOrderCancellationRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOrderReturnRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCustomProductRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBadgeRequests(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-requests">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_REQUESTS', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewBrandRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ProductCategoriesRequest'); ?>"><?php echo Labels::getLabel('NAV_CATEGORIES_REQUESTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewCustomProductRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('CustomProducts'); ?>"><?php echo Labels::getLabel('NAV_CUSTOM_PRODUCT_CATALOG_REQUESTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewSellerApprovalRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('thresholdProducts'); ?>"><?php echo Labels::getLabel('NAV_THRESHOLD_PRODUCTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewWithdrawRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('WithdrawalRequests'); ?>"><?php echo Labels::getLabel('NAV_WITHDRAWL_REQUESTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewOrderCancellationRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('OrderCancellationRequests'); ?>"><?php echo Labels::getLabel('NAV_CANCELLATION_REQUESTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewOrderReturnRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('OrderReturnRequests'); ?>"><?php echo Labels::getLabel('NAV_ORDER_RETURN_REQUESTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewBadgeRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('BadgeRequests'); ?>"><?php echo Labels::getLabel('NAV_BADGE_REQUEST', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewOrders(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSubscriptionOrders(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOrderCancelReasons(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOrderReturnReasons(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOrderStatus(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductReviews(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewAbandonedCart(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-orders">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_ORDERS', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewOrders(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Orders'); ?>"><?php echo Labels::getLabel('NAV_ORDERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewSubscriptionOrders(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SubscriptionOrders'); ?>"><?php echo Labels::getLabel('NAV_SUBSCRIPTION_ORDERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewOrderCancelReasons(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('OrderStatus'); ?>"><?php echo Labels::getLabel('NAV_ORDER_STATUSES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewProductReviews(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ProductReviews'); ?>"><?php echo Labels::getLabel('NAV_PRODUCT_REVIEWS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewAbandonedCart(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('AbandonedCart'); ?>"><?php echo Labels::getLabel('NAV_ABANDONED_CART', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewAdminUsers(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewUsers(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-users">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_USERS', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewAdminUsers(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('AdminUsers'); ?>"><?php echo Labels::getLabel('NAV_ADMIN_USERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewUsers(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Users'); ?>"><?php echo Labels::getLabel('NAV_USERS', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Rewards'); ?>"><?php echo Labels::getLabel('NAV_REWARDS', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Transactions'); ?>"><?php echo Labels::getLabel('NAV_TRANSACTIONS', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('DeletedUsers'); ?>"><?php echo Labels::getLabel('NAV_DELETED_USERS', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('UsersAddresses'); ?>"><?php echo Labels::getLabel('NAV_USERS_ADDRESSES', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                    $objPrivilege->canViewRecomendedWeightages(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewDiscountCoupons(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewPushNotification(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBadgesAndRibbons(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-promotions">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_PROMOTIONS', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewProducts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SpecialPrice'); ?>"><?php echo Labels::getLabel('NAV_SPECIAL_PRICE', $siteLangId); ?></a>
                            </div>

                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('VolumeDiscount'); ?>"><?php echo Labels::getLabel('NAV_VOLUME_DISCOUNT', $siteLangId); ?></a>
                            </div>

                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('RelatedProducts'); ?>"><?php echo Labels::getLabel('NAV_RELATED_PRODUCTS', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('BuyTogetherProducts'); ?>"><?php echo Labels::getLabel('NAV_BUY_TOGETHER_PRODUCTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewPromotions(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SmartRecomendedWeightages'); ?>"><?php echo Labels::getLabel('NAV_MANAGE_WEIGHTAGES', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('RecomendedTagProducts'); ?>"><?php echo Labels::getLabel('NAV_RECOMMENDED_TAG_PRODUCTS_WEIGHTAGES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewDiscountCoupons(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('DiscountCoupons'); ?>"><?php echo Labels::getLabel('NAV_DISCOUNT_COUPONS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewPushNotification(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('PushNotifications'); ?>"><?php echo Labels::getLabel('NAV_PUSH_NOTIFICATIONS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewBadgesAndRibbons(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Badges'); ?>"><?php echo Labels::getLabel('NAV_BADGES', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Ribbons'); ?>"><?php echo Labels::getLabel('NAV_RIBBONS', $siteLangId); ?></a>
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
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-blog">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_BLOG', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewBlogPostCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-sales-tax">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_TAX', $siteLangId); ?>
                        </h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('TaxStructure'); ?>"><?php echo Labels::getLabel('NAV_TAX_STRUCTURE', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('TaxCategories'); ?>"><?php echo Labels::getLabel('NAV_TAX_CATEGORIES', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('TaxCategoriesRule'); ?>"><?php echo Labels::getLabel('NAV_TAX_CATEGORIES_RULE', $siteLangId); ?></a>
                        </div>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewSlides(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBanners(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewContentPages(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewContentBlocks(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewFaqCategories(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewTestimonial(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewNavigationManagement(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-CMS">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_CMS', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewSlides(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Slides'); ?>"><?php echo Labels::getLabel('NAV_HOME_PAGE_SLIDES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewBanners(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('BannerLocation'); ?>"><?php echo Labels::getLabel('NAV_BANNERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewContentPages(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ContentPages'); ?>"><?php echo Labels::getLabel('NAV_CONTENT_PAGES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewContentBlocks(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ContentBlock'); ?>"><?php echo Labels::getLabel('NAV_CONTENT_BLOCK', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewFaqCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('FaqCategories'); ?>"><?php echo Labels::getLabel('NAV_FAQS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewTestimonial(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Testimonials'); ?>"><?php echo Labels::getLabel('NAV_TESTIMONIALS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewNavigationManagement(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('Navigations'); ?>"><?php echo Labels::getLabel('NAV_NAVIGATIONS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>

                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewSalesReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCatalogReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductsReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShopsReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#test">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_SALES_REPORTS', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewSalesReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ShopsReport'); ?>"><?php echo Labels::getLabel('NAV_SHOPS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('BuyersReport'); ?>"><?php echo Labels::getLabel('NAV_CUSTOMERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellersReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewAffiliatesReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewAdvertisersReport(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#test">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_BUYERS_REPORTS', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('UsersReport', 'index', [User::USER_TYPE_BUYER]); ?>"><?php echo Labels::getLabel('NAV_BUYERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewSellersReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('UsersReport', 'index', [User::USER_TYPE_SELLER]); ?>"><?php echo Labels::getLabel('NAV_SELLERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewAffiliatesReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('AffiliatesReport'); ?>"><?php echo Labels::getLabel('NAV_AFFILIATES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewAdvertisersReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('AdvertisersReport'); ?>"><?php echo Labels::getLabel('NAV_ADVERTISERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewFinancialReport(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#test">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_FINANCIAL_REPORT', $siteLangId); ?>
                        </h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('EarningsReport'); ?>"><?php echo Labels::getLabel('NAV_EARNINGS', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ProductProfitReport'); ?>"><?php echo Labels::getLabel('NAV_PROFIT_BY_PRODUCTS', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('PreferredPaymentMethod'); ?>"><?php echo Labels::getLabel('NAV_PREFERRED_PAYMENT_METHOD', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('payoutReport'); ?>"><?php echo Labels::getLabel('NAV_PAYOUT', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#test">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_SUBSCRIPTION_REPORT', $siteLangId); ?>
                        </h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SubscriptionPlanReport'); ?>"><?php echo Labels::getLabel('NAV_BY_PLAN', $siteLangId); ?></a>
                        </div>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('SubscriptionSellerReport'); ?>"><?php echo Labels::getLabel('NAV_BY_SELLER', $siteLangId); ?></a>
                        </div>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewDiscountCoupons(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#test">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_DISCOUNT_COUPONS', $siteLangId); ?>
                        </h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('DiscountCouponsReport'); ?>"><?php echo Labels::getLabel('NAV_DISCOUNT_COUPONS', $siteLangId); ?></a>
                        </div>
                    </li>
                <?php } ?>

                <?php if (
                    $objPrivilege->canViewImportExport(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-import-export">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_IMPORT_EXPORT', $siteLangId); ?>
                        </h6>
                        <div class="search-result">
                            <span class="search-result__icon">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                    </use>
                                </svg>
                            </span>
                            <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ImportExport'); ?>"><?php echo Labels::getLabel('NAV_IMPORT_EXPORT', $siteLangId); ?></a>
                        </div>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewShippingCompanyUsers(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShippingPackages(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShippingManagement(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewPickupAddresses(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewTrackingRelationCode(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-import-export">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_SHIPPING/PICKUP', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewShippingCompanyUsers(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ShippingCompanyUsers'); ?>"><?php echo Labels::getLabel('NAV_SHIPPING_COMPANY_USERS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewShippingPackages(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('shippingPackages'); ?>"><?php echo Labels::getLabel('NAV_SHIPPING_PACKAGES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewShippingManagement(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('shippingProfile'); ?>"><?php echo Labels::getLabel('NAV_SHIPPING_PROFILE', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewPickupAddresses(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('PickupAddresses'); ?>"><?php echo Labels::getLabel('NAV_PICKUP_ADDRESSES', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewShippedProducts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('ShippedProducts'); ?>"><?php echo Labels::getLabel('NAV_SHIPPED_PRODUCTS', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                        <?php if ($objPrivilege->canViewTrackingRelationCode(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('TrackingCodeRelation'); ?>"><?php echo Labels::getLabel('NAV_TRACKING_CODE_RELATION', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <?php if (
                    $objPrivilege->canViewSitemap(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewUrlRewrite(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewMetaTags(AdminAuthentication::getLoggedAdminId(), true)
                ) { ?>
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-SEO">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_SEO', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewUrlRewrite(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('sitemap', 'generate'); ?>"><?php echo Labels::getLabel('NAV_GENERATE_SITEMAP', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateFullUrl('custom', 'sitemap', array(), CONF_WEBROOT_FRONT_URL); ?>"><?php echo Labels::getLabel('NAV_VIEW_HTML', $siteLangId); ?></a>
                            </div>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                    <li class="quick-search-list-item">
                        <h6 class="title">
                            <i class="title-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-aside-menu.svg#icon-system-settings">
                                    </use>
                                </svg>
                            </i>
                            <?php echo Labels::getLabel('NAV_SETTINGS', $siteLangId); ?>
                        </h6>
                        <?php if ($objPrivilege->canViewGeneralSettings(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <div class="search-result">
                                <span class="search-result__icon">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
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
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-goto">
                                        </use>
                                    </svg>
                                </span>
                                <a class="search-result__link" href="<?php echo UrlHelper::generateUrl('emptyCartItems'); ?>"><?php echo Labels::getLabel('LBL_EMPTY_CART', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                <li class="noResultsFoundJs" style="display: none;">
                    <h6 class="title">
                        <?php echo Labels::getLabel('NAV_NO_RESULTS_FOUND', $siteLangId); ?>
                    </h6>
                </li>
            </ul>
        </div>
    </form>
</div>