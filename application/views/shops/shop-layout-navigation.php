<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<ul class="shop-nav">
    <li class="shop-nav-item <?php echo $action == 'view' ? 'active' : '' ?>"><a class="shop-nav-link" href="<?php echo UrlHelper::generateUrl('shops', 'view', array($shop_id)); ?>"><?php echo Labels::getLabel('LBL_SHOP_STORE_HOME', $siteLangId); ?>
        </a></li>
    <?php /* if (!empty($collectionData)) { ?>
    <li class="<?php echo $action == 'collection' ? 'active' : '' ?>"><a href="<?php echo UrlHelper::generateUrl('shops', 'collections', array($shop_id));?>" ><?php echo $collectionData['collectionName']; ?></a></li>
    <?php } */ ?>
    <?php if (0 < FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
        <li class="shop-nav-item <?php echo $action == 'topProducts' ? 'active' : '' ?>">
            <a class="shop-nav-link" href="<?php echo UrlHelper::generateUrl('shops', 'topProducts', array($shop_id)); ?>">
                <?php echo Labels::getLabel('LBL_SHOP_TOP_PRODUCTS', $siteLangId); ?></a>
        </li>
        <li class="shop-nav-item  <?php echo $action == 'shop' ? 'active' : '' ?>">
            <a class="shop-nav-link " href="<?php echo UrlHelper::generateUrl('reviews', 'shop', array($shop_id)); ?>"><?php echo Labels::getLabel('LBL_SHOP_REVIEW', $siteLangId); ?></a>
        </li>
    <?php } ?>
    <?php if (!UserAuthentication::isUserLogged() || (UserAuthentication::isUserLogged() && ((User::isBuyer()) || (User::isSeller())) && (UserAuthentication::getLoggedUserId() != $shop_user_id))) { ?>
        <li class="shop-nav-item <?php echo $action == 'sendMessage' ? 'active' : '' ?>">
            <a class="shop-nav-link " href="<?php echo UrlHelper::generateUrl('shops', 'sendMessage', array($shop_id)); ?>"><?php echo Labels::getLabel('LBL_SHOP_CONTACT', $siteLangId); ?></a>
        </li>
    <?php } ?>
    <li class="shop-nav-item <?php echo $action == 'policy' ? 'active' : '' ?>">
        <a class="shop-nav-link " href="<?php echo UrlHelper::generateUrl('shops', 'policy', array($shop_id)); ?>">
            <?php echo Labels::getLabel('LBL_SHOP_DETAILS', $siteLangId); ?>
        </a>
    </li>
</ul>