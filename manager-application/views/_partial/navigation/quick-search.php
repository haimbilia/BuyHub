<div class="quick-search">
    <form method="get" class="form form--quick-search">
        <div class="quick-search__form">
            <input id="quickSearch" type="search" class="form-control" placeholder="<?php echo Labels::getLabel('LBL_GO_TO..', $siteLangId); ?>">
        </div>
        <div class="quick-search__wrapper">
            <ul class="list list--search-result navMenuItems" style="display: none;">
                <?php if ($objPrivilege->canViewBrands(AdminAuthentication::getLoggedAdminId(), true)) { ?>
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
                <?php if ($objPrivilege->canViewSitemap(AdminAuthentication::getLoggedAdminId(), true)) { ?>
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