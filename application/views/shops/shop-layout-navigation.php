<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<ul class="shop-nav">
    <li class="shop-nav-item">
        <a class="shop-nav-link <?php echo $action == 'view' ? 'active' : '' ?>" href="<?php echo UrlHelper::generateUrl('shops', 'view', array($shop_id)); ?>">
            <?php echo Labels::getLabel('LBL_SHOP_STORE_HOME', $siteLangId); ?>
        </a>
    </li>
    <?php if (0 < FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
        <li class="shop-nav-item">
            <a class="shop-nav-link <?php echo $action == 'topProducts' ? 'active' : '' ?>" href="<?php echo UrlHelper::generateUrl('shops', 'topProducts', array($shop_id)); ?>">
                <?php echo Labels::getLabel('LBL_SHOP_TOP_PRODUCTS', $siteLangId); ?></a>
        </li>
        <li class="shop-nav-item">
            <a class="shop-nav-link <?php echo $action == 'shop' ? 'active' : '' ?>" href="<?php echo UrlHelper::generateUrl('reviews', 'shop', array($shop_id)); ?>"><?php echo Labels::getLabel('LBL_SHOP_REVIEW', $siteLangId); ?></a>
        </li>
    <?php } ?>
    <?php if (!UserAuthentication::isUserLogged() || (UserAuthentication::isUserLogged() && ((User::isBuyer()) || (User::isSeller())) && (UserAuthentication::getLoggedUserId() != $shop_user_id))) { ?>
        <li class="shop-nav-item">
            <a class="shop-nav-link <?php echo $action == 'sendMessage' ? 'active' : '' ?>" href="<?php echo UrlHelper::generateUrl('shops', 'sendMessage', array($shop_id)); ?>"><?php echo Labels::getLabel('LBL_SHOP_CONTACT', $siteLangId); ?></a>
        </li>
    <?php } ?>
    <li class="shop-nav-item">
        <a class="shop-nav-link <?php echo $action == 'policy' ? 'active' : '' ?>" href="<?php echo UrlHelper::generateUrl('shops', 'policy', array($shop_id)); ?>">
            <?php echo Labels::getLabel('LBL_SHOP_DETAILS', $siteLangId); ?>
        </a>
    </li>
</ul>