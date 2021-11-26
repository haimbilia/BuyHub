<sidebar class="sidebar" id="sidebar" data-close-on-click-outside="sidebar">
    <div class="sidebar-logo">
        <a href="#">
            <?php
            $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_ADMIN_LOGO, 0, 0, $siteLangId, false);
            $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
            $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
            ?>
            <img width="34" height="34" <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> title="<?php echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId); ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'siteAdminLogo', array($siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId); ?>">
        </a>
    </div>
    <div class="sidebar-menu sidebarMenuJs">
        <ul class="menu">
            <?php
            if (
                    $objPrivilege->canViewBrands(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShops(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_PRODUCT_CATALOG', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-catelog">
                            </use> 
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_PRODUCT_CATALOG', $siteLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewBrands(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('Brands'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_BRANDS', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewShops(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('Shops'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_SHOPS', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ProductCategories'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_CATEGORIES', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (
                    $objPrivilege->canViewBrandRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellerApprovalRequests(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewRatingTypes(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellerProducts(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_REQUESTS', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-buyer-orders">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_REQUESTS', $siteLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewBrandRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('brandRequests'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_BRAND_REQUEST', $siteLangId); ?><?php if ($brandReqCount) { ?>(<?php echo $brandReqCount; ?>)<?php } ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewProductCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ProductCategoriesRequest'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_CATEGORIES_REQUESTS', $siteLangId); ?> <?php if ($categoryReqCount) { ?>(<?php echo $categoryReqCount; ?>)<?php } ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewSellerApprovalRequests(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('sellerApprovalRequests'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_SELLER_APPROVAL_REQUESTS', $siteLangId); ?><?php if ($supReqCount) { ?>(<?php echo $supReqCount; ?>)<?php } ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewSellerProducts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('thresholdProducts'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_THRESHOLD_PRODUCTS', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewRatingTypes(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('RatingTypes'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_RATING_TYPES', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (
                    $objPrivilege->canViewOrderCancelReasons(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOrderReturnReasons(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewOrderStatus(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_ORDERS', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-buyer-orders">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_ORDERS', $siteLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewOrderCancelReasons(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('OrderCancelReasons'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_ORDER_CANCEL_REASONS', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewOrderReturnReasons(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('OrderReturnReasons'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_ORDER_RETURN_REASONS', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewOrderStatus(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('OrderStatus'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_ORDER_STATUSES', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (
                    $objPrivilege->canViewUsers(AdminAuthentication::getLoggedAdminId(), true) /* ||
              $objPrivilege->canViewSellerApprovalForm(AdminAuthentication::getLoggedAdminId(), true) ||
              $objPrivilege->canViewCustomCatalogProductRequests(AdminAuthentication::getLoggedAdminId(), true) ||
              $objPrivilege->canViewAdminUsers(AdminAuthentication::getLoggedAdminId(), true) ||
              $objPrivilege->canViewMessages(AdminAuthentication::getLoggedAdminId(), true) */
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_USERS', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-users">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_USERS', $siteLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewUsers(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('Users'); ?>">
                                        <?php echo Labels::getLabel('NAV_USERS', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('Rewards'); ?>">
                                        <?php echo Labels::getLabel('NAV_REWARDS', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('Transactions'); ?>">
                                        <?php echo Labels::getLabel('NAV_TRANSACTIONS', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('DeletedUsers'); ?>">
                                        <?php echo Labels::getLabel('NAV_DELETED_USERS', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('UsersAddresses'); ?>">
                                        <?php echo Labels::getLabel('NAV_USERS_ADDRESSES', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('userGdprRequests'); ?>">
                                        <?php echo Labels::getLabel('NAV_GDPR_REQUESTS', $siteLangId); ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php /* if ($objPrivilege->canViewAdminUsers(AdminAuthentication::getLoggedAdminId(), true) || $objPrivilege->canViewAdminUsers(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                              <li class="nav_item navItemJs">
                              <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('AdminUsers') ?>">
                              <?php echo Labels::getLabel('LBL_Admin_Sub_Users', $siteLangId); ?>
                              </a>
                              </li>
                              <?php } ?>
                              <?php if ($objPrivilege->canViewMessages(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                              <li class="nav_item navItemJs">
                              <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('Messages'); ?>">
                              <?php echo Labels::getLabel('LBL_Messages', $siteLangId); ?>
                              </a>
                              </li>
                              <?php } ?>
                              <?php if ($objPrivilege->canViewSellerApprovalForm(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                              <li class="nav_item navItemJs">
                              <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('Users', 'sellerForm'); ?>">
                              <?php echo Labels::getLabel('LBL_Seller_Approval_Form', $siteLangId); ?>
                              </a>
                              </li>
                              <?php } */ ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (
                    $objPrivilege->canViewProducts(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewPromotions(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewRewardsOnPurchase(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewRecomendedWeightages(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_PROMOTIONS', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-promotions">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_PROMOTIONS', $siteLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewProducts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('SpecialPrice'); ?>">
                                        <?php echo Labels::getLabel('NAV_SPECIAL_PRICE', $siteLangId); ?>
                                    </a>
                                </li>

                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('VolumeDiscount'); ?>">
                                        <?php echo Labels::getLabel('NAV_VOLUME_DISCOUNT', $siteLangId); ?>
                                    </a>
                                </li>

                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('RelatedProducts'); ?>">
                                        <?php echo Labels::getLabel('NAV_RELATED_PRODUCTS', $siteLangId); ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($objPrivilege->canViewPromotions(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('promotions'); ?>">
                                        <?php echo Labels::getLabel('NAV_PROMOTIONS', $siteLangId); ?>
                                    </a>
                                </li>
                            <?php } ?>


                            <?php if ($objPrivilege->canViewRewardsOnPurchase(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('RewardsOnPurchase'); ?>">
                                        <?php echo Labels::getLabel('NAV_REWARDS_ON_PURCHASE', $siteLangId); ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($objPrivilege->canViewRecomendedWeightages(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('SmartRecomendedWeightages'); ?>">
                                        <?php echo Labels::getLabel('NAV_MANAGE_WEIGHTAGES', $siteLangId); ?>
                                    </a>
                                </li>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('RecomendedTagProducts'); ?>">
                                        <?php echo Labels::getLabel('NAV_RECOMMENDED_TAG_PRODUCTS_WEIGHTAGES', $siteLangId); ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (
                    $objPrivilege->canViewBlogPostCategories(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBlogPosts(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBlogContributions(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBlogComments(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_BLOG', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-import-export">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_BLOG', $siteLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewBlogPostCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('BlogPostCategories'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_BLOG_POST_CATEGORIES', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewBlogPosts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('BlogPosts'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_BLOG_POSTS', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewBlogContributions(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('BlogContributions'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_BLOG_CONTRIBUTIONS', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewBlogComments(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('BlogComments'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_BLOG_COMMENTS', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (
                    $objPrivilege->canViewTax(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_TAX', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-buyer-orders">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_TAX', $siteLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewTax(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('TaxStructure'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_TAX_STRUCTURE', $siteLangId); ?></span>
                                    </a>
                                </li>

                                <li class="nav_item">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('TaxCategories'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_TAX_CATEGORIES', $siteLangId); ?></span>
                                    </a>
                                </li>
                                <li class="nav_item">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('TaxCategoriesRule'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_TAX_CATEGORIES_RULE', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (
                    $objPrivilege->canViewContentPages(AdminAuthentication::getLoggedAdminId(), true) || $objPrivilege->canViewContentBlocks(AdminAuthentication::getLoggedAdminId(), true) || $objPrivilege->canViewFaqCategories(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_CMS', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-buyer-orders">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_CMS', $siteLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewContentPages(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ContentPages'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_CONTENT_PAGES', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewContentBlocks(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ContentBlock'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_CONTENT_BLOCK', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewFaqCategories(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('FaqCategories'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_FAQS', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (
                    $objPrivilege->canViewSalesReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewUsersReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewProductsReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewCatalogReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShopsReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    /* $objPrivilege->canViewTaxReport(AdminAuthentication::getLoggedAdminId(), true) ||
                      $objPrivilege->canViewCommissionReport(AdminAuthentication::getLoggedAdminId(), true) || */
                    $objPrivilege->canViewPerformanceReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewAffiliatesReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSellersReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewAdvertisersReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewFinancialReport(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewSubscriptionReport(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_REPORTS', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-reports">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_REPORTS', $siteLangId); ?></h6>
                        <ul class="nav" id="reportsNav">
                            <?php
                            if (
                                    $objPrivilege->canViewSalesReport(AdminAuthentication::getLoggedAdminId(), true) ||
                                    $objPrivilege->canViewCatalogReport(AdminAuthentication::getLoggedAdminId(), true) ||
                                    $objPrivilege->canViewProductsReport(AdminAuthentication::getLoggedAdminId(), true) ||
                                    $objPrivilege->canViewShopsReport(AdminAuthentication::getLoggedAdminId(), true) ||
                                    $objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true)
                            ) {
                                ?>
                                <li class="nav_item hasNestedChildJs">
                                    <a class="nav_link navLinkJs" data-toggle="collapse" data-parent="#reportsNav" href="#salesReportNav" aria-expanded="true">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_SALES_REPORTS', $siteLangId); ?></span>
                                        <i class="nav_arrow"></i>
                                    </a>
                                    <div id="salesReportNav" class="panel-collapse collapse collapseJs">
                                        <ul class="nav">
                                            <?php if ($objPrivilege->canViewSalesReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                                <li class="nav_item navItemJs">
                                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('SalesReport'); ?>">
                                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_SALES_OVER_TIME', $siteLangId); ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($objPrivilege->canViewCatalogReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                                <li class="nav_item navItemJs">
                                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('CatalogReport'); ?>">
                                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_PRODUCTS', $siteLangId); ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($objPrivilege->canViewProductsReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                                <li class="nav_item navItemJs">
                                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ProductsReport'); ?>">
                                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_PRODUCT_VARIENTS', $siteLangId); ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($objPrivilege->canViewShopsReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                                <li class="nav_item navItemJs">
                                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ShopsReport'); ?>">
                                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_SHOPS', $siteLangId); ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                                <li class="nav_item navItemJs">
                                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('BuyersReport'); ?>">
                                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_CUSTOMERS', $siteLangId); ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php /* if (
                              $objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true) ||
                              $objPrivilege->canViewSellersReport(AdminAuthentication::getLoggedAdminId(), true) ||
                              $objPrivilege->canViewAffiliatesReport(AdminAuthentication::getLoggedAdminId(), true) ||
                              $objPrivilege->canViewAdvertisersReport(AdminAuthentication::getLoggedAdminId(), true)
                              ) { ?>
                              <li class="nav_item hasNestedChildJs">
                              <a class="nav_link navLinkJs" data-toggle="collapse" data-parent="#usersReportNav"
                              href="#usersReportNav" aria-expanded="true">
                              <span
                              class="nav_text"><?php echo Labels::getLabel('NAV_USERS_REPORT', $siteLangId); ?></span>
                              <i class="nav_arrow"></i>
                              </a>
                              <div id="usersReportNav" class="panel-collapse collapse collapseJs">
                              <ul class="nav">
                              <?php if ($objPrivilege->canViewBuyersReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                              <li class="nav_item navItemJs">
                              <a href="<?php echo UrlHelper::generateUrl('UsersReport', 'index', [User::USER_TYPE_BUYER]); ?>"
                              class="nav_link navLinkJs ">
                              <span
                              class="nav_text"><?php echo Labels::getLabel('NAV_BUYERS', $siteLangId); ?></span>
                              </a>
                              </li>
                              <?php } ?>
                              <?php if ($objPrivilege->canViewSellersReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                              <li class="nav_item navItemJs">
                              <a href="<?php echo UrlHelper::generateUrl('UsersReport', 'index', [User::USER_TYPE_SELLER]); ?>"
                              class="nav_link navLinkJs ">
                              <span
                              class="nav_text"><?php echo Labels::getLabel('NAV_SELLERS', $siteLangId); ?></span>
                              </a>
                              </li>
                              <?php } ?>
                              <?php if ($objPrivilege->canViewProductsReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                              <li class="nav_item navItemJs">
                              <a href="<?php echo UrlHelper::generateUrl('ProductsReport'); ?>"
                              class="nav_link navLinkJs ">
                              <span
                              class="nav_text"><?php echo Labels::getLabel('NAV_PRODUCT_VARIENTS', $siteLangId); ?></span>
                              </a>
                              </li>
                              <?php } ?>
                              <?php if ($objPrivilege->canViewAffiliatesReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                              <li class="nav_item navItemJs">
                              <a href="<?php echo UrlHelper::generateUrl('AffiliatesReport'); ?>"
                              class="nav_link navLinkJs ">
                              <span
                              class="nav_text"><?php echo Labels::getLabel('NAV_AFFILIATES', $siteLangId); ?></span>
                              </a>
                              </li>
                              <?php } ?>
                              <?php if ($objPrivilege->canViewAdvertisersReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                              <li class="nav_item navItemJs">
                              <a href="<?php echo UrlHelper::generateUrl('AdvertisersReport'); ?>"
                              class="nav_link navLinkJs ">
                              <span
                              class="nav_text"><?php echo Labels::getLabel('NAV_ADVERTISERS', $siteLangId); ?></span>
                              </a>
                              </li>
                              <?php } ?>
                              </ul>
                              </div>
                              </li>
                              <?php } */ ?>
                            <?php if ($objPrivilege->canViewFinancialReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item hasNestedChildJs">
                                    <a class="nav_link navLinkJs" data-toggle="collapse" data-parent="#financialReportNav" href="#financialReportNav" aria-expanded="true">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_FINANCIAL_REPORT', $siteLangId); ?></span>
                                        <i class="nav_arrow"></i>
                                    </a>
                                    <div id="financialReportNav" class="panel-collapse collapse collapseJs">
                                        <ul class="nav">
                                            <li class="nav_item navItemJs">
                                                <a href="<?php echo UrlHelper::generateUrl('EarningsReport'); ?>" class="nav_link navLinkJs ">
                                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_EARNINGS', $siteLangId); ?></span>
                                                </a>
                                            </li>
                                            <li class="nav_item navItemJs">
                                                <a href="<?php echo UrlHelper::generateUrl('ProductProfitReport'); ?>" class="nav_link navLinkJs ">
                                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_PROFIT_BY_PRODUCTS', $siteLangId); ?></span>
                                                </a>
                                            </li>
                                            <li class="nav_item navItemJs">
                                                <a href="<?php echo UrlHelper::generateUrl('PreferredPaymentMethod'); ?>" class="nav_link navLinkJs ">
                                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_PREFERRED_PAYMENT_METHOD', $siteLangId); ?></span>
                                                </a>
                                            </li>
                                            <li class="nav_item navItemJs">
                                                <a href="<?php echo UrlHelper::generateUrl('payoutReport'); ?>" class="nav_link navLinkJs ">
                                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_PAYOUT', $siteLangId); ?></span>
                                                </a>
                                            </li>
                                            <li class="nav_item navItemJs">
                                                <a href="<?php echo UrlHelper::generateUrl('TransactionReport'); ?>" class="nav_link navLinkJs ">
                                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_TRANSACTION_REPORT', $siteLangId); ?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if ($objPrivilege->canViewSubscriptionReport(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item hasNestedChildJs">
                                    <a class="nav_link navLinkJs" data-toggle="collapse" data-parent="#subscriptionReportNav" href="#subscriptionReportNav" aria-expanded="true">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_SUBSCRIPTION_REPORT', $siteLangId); ?></span>
                                        <i class="nav_arrow"></i>
                                    </a>
                                    <div id="subscriptionReportNav" class="panel-collapse collapse collapseJs">
                                        <ul class="nav">
                                            <li class="nav_item navItemJs">
                                                <a href="<?php echo UrlHelper::generateUrl('SubscriptionPlanReport'); ?>" class="nav_link navLinkJs ">
                                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_BY_PLAN', $siteLangId); ?></span>
                                                </a>
                                            </li>
                                            <li class="nav_item navItemJs">
                                                <a href="<?php echo UrlHelper::generateUrl('SubscriptionSellerReport'); ?>" class="nav_link navLinkJs ">
                                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_BY_SELLER', $siteLangId); ?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>
            <?php
            if (
                    $objPrivilege->canViewImportExport(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_IMPORT_EXPORT', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-import-export">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_IMPORT_EXPORT', $siteLangId); ?></h6>
                        <ul class="nav">
                            <li class="nav_item navItemJs">
                                <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ImportExport'); ?>">
                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_IMPORT_EXPORT', $siteLangId); ?></span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (
                    $objPrivilege->canViewShippingCompanyUsers(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShippingPackages(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewShippingManagement(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewPickupAddresses(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewTrackingRelationCode()
            ) {
                ?>
            <?php } ?>
            <li class="menu-item dropdown dropright">
                <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_IMPORT_EXPORT', $siteLangId); ?>">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-import-export">
                        </use>
                        </svg>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                    <h6 class=""><?php echo Labels::getLabel('NAV_Shipping/Pickup', $siteLangId); ?></h6>
                    <ul class="nav">
                        <?php if ($objPrivilege->canViewShippingCompanyUsers(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <li class="nav_item navItemJs">
                                <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ShippingCompanyUsers'); ?>">
                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_SHIPPING_COMPANY_USERS', $siteLangId); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (false && $objPrivilege->canViewShippingPackages(AdminAuthentication::getLoggedAdminId(), true) && FatApp::getConfig("CONF_PRODUCT_DIMENSIONS_ENABLE", FatUtility::VAR_INT, 1)) { ?>
                            <li class="nav_item navItemJs">
                                <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('shippingPackages'); ?>">
                                    <?php echo Labels::getLabel('NAV_SHIPPING_PACKAGES', $siteLangId); ?>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (false && $objPrivilege->canViewShippingManagement(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <li class="nav_item navItemJs">
                                <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('shippingProfile'); ?>">
                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_GENERATE_SITEMAP', $siteLangId); ?></span>
                                </a>
                            </li> 
                        <?php } ?>

                        <?php if (false && $objPrivilege->canViewPickupAddresses(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <li class="nav_item navItemJs">
                                <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('PickupAddresses'); ?>">
                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_PICKUP_ADDRESSES', $siteLangId); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (false && $objPrivilege->canViewShippedProducts(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <li class="nav_item navItemJs">
                                <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ShippedProducts'); ?>">
                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_SHIPPED_PRODUCTS', $siteLangId); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (false && $objPrivilege->canViewTrackingRelationCode(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                            <li class="nav_item navItemJs">
                                <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('TrackingCodeRelation'); ?>">
                                    <span class="nav_text"><?php echo Labels::getLabel('NAV_TRACKING_CODE_RELATION', $siteLangId); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
            <?php
            if (
                    $objPrivilege->canViewSitemap(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewUrlRewrite(AdminAuthentication::getLoggedAdminId(), true) ||
                    $objPrivilege->canViewMetaTags(AdminAuthentication::getLoggedAdminId(), true)
            ) {
                ?>
                <li class="menu-item dropdown dropright">
                    <button type="button" class="menu-link menuLinkJs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo Labels::getLabel('NAV_SEO', $siteLangId); ?>">
                        <span class="menu-icon">
                            <svg class="svg" width="24" height="24">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-sitemap">
                            </use>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-anim sidebar-dropdown-menu">
                        <h6 class=""><?php echo Labels::getLabel('NAV_SEO', $siteLangId); ?></h6>
                        <ul class="nav">
                            <?php if ($objPrivilege->canViewUrlRewrite(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('UrlRewriting'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_URL_REWRITING', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($objPrivilege->canViewImageAttributes(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('ImageAttributes'); ?>">
                                        <?php echo Labels::getLabel('NAV_IMAGE_ATTRIBUTES', $siteLangId); ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($objPrivilege->canViewUrlRewrite(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('sitemap', 'generate'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_GENERATE_SITEMAP', $siteLangId); ?></span>
                                    </a>
                                </li>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" target="_blank" href="<?php echo UrlHelper::generateFullUrl('custom', 'sitemap', array(), CONF_WEBROOT_FRONT_URL); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_VIEW_HTML', $siteLangId); ?></span>
                                    </a>
                                </li>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" target="_blank" href="<?php echo UrlHelper::generateFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL) . 'sitemap.xml'; ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_VIEW_XML', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($objPrivilege->canViewMetaTags(AdminAuthentication::getLoggedAdminId(), true)) { ?>
                                <li class="nav_item navItemJs">
                                    <a class="nav_link navLinkJs" href="<?php echo UrlHelper::generateUrl('MetaTags'); ?>">
                                        <span class="nav_text"><?php echo Labels::getLabel('NAV_META_TAGS_MANAGEMENT', $siteLangId); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="sidebar-foot">
        <ul class="menu">
            <li class="menu-item dropdown dropright">
                <button type="button" class="menu-link menuLinkJs" onclick="redirectFn('<?php echo UrlHelper::generateUrl('Settings'); ?>')">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-system-setting">
                        </use>
                        </svg>
                    </span>
                </button>

            </li>
        </ul>


    </div>
</sidebar>