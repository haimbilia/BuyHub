<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$withouVariants = FatApp::getConfig('CONF_WITHOUT_PROD_VARIANTS', FatUtility::VAR_INT, 0);
?>
<nav class="nav nav-tabs navTabsJs">
    <?php if (FatApp::getConfig('CONF_SELLER_CAN_REQUEST_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0) && 1 > $withouVariants) { ?>
        <a class="nav-link active tabs_001 customCatalogReq--js" rel="tabs_001" href="javascript:void(0)" onclick="searchCustomCatalogProducts()">
            <?php echo Labels::getLabel('LBL_Marketplace_Products_Requests', $siteLangId);
            if (Extrapage::isActive(Extrapage::PRODUCT_REQUEST_INSTRUCTIONS)) {
            ?>
                <i class="fa fa-question-circle" onclick="productInstructions(<?php echo Extrapage::PRODUCT_REQUEST_INSTRUCTIONS; ?>)"></i>
            <?php } ?>
        </a>
    <?php } ?>
    <?php if (FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) { ?>
        <a class="nav-link tabs_002 brandReq--js <?php echo $withouVariants ? 'active': ''; ?>" rel="tabs_002" href="javascript:void(0)" onclick="searchBrandRequests()">
            <?php echo Labels::getLabel('LBL_Brand_Requests', $siteLangId); ?>
        </a>
    <?php } ?>
    <?php if (FatApp::getConfig('CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) { ?>
        <a class="nav-link tabs_003 catReq--js" rel="tabs_003" href="javascript:void(0)" onclick="searchProdCategoryRequests()">
            <?php echo Labels::getLabel('LBL_Category_Requests', $siteLangId); ?>
        </a>
    <?php } ?>

    <?php if ($canRequestBadge) { ?>
        <?php if (!empty($reqBadges)) { ?>
            <a class="nav-link tabs_003 badgeReq--js" rel="tabs_003" href="javascript:void(0)" onclick="searchBadgeRequests()">
                <?php echo Labels::getLabel('LBL_Badge_Requests', $siteLangId); ?>
            </a>
        <?php } else if (empty($reqBadges) && !empty($approvalRequiredBadges)) { ?>
            <a class="nav-link tabs_003 badgeReq--js" rel="tabs_003" href="javascript:void(0)" onclick="searchBadgeRequests()">
                <?php echo Labels::getLabel('LBL_Badge_Requests', $siteLangId); ?>
            </a>
        <?php } ?>
    <?php } ?>
</nav>