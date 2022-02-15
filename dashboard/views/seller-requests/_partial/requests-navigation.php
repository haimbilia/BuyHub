<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<nav class="nav nav-tabs tabsNavJs">
    <?php if (FatApp::getConfig('CONF_SELLER_CAN_REQUEST_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0)) { ?>
        <a class="nav-link active tabs_001 customCatalogReq--js" rel="tabs_001" href="javascript:void(0)" onClick="searchCustomCatalogProducts()">
            <?php echo Labels::getLabel('LBL_Marketplace_Products_Requests', $siteLangId); ?> 
            <i class="fa fa-question-circle" onClick="productInstructions(<?php echo Extrapage::PRODUCT_REQUEST_INSTRUCTIONS; ?>)"></i>
        </a>
    <?php } ?>
    <?php if (FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) { ?>
        <a class="nav-link tabs_002 brandReq--js" rel="tabs_002" href="javascript:void(0)" onClick="searchBrandRequests()">
            <?php echo Labels::getLabel('LBL_Brand_Requests', $siteLangId); ?>
        </a>
    <?php } ?>
    <?php if (FatApp::getConfig('CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) { ?>
        <a class="nav-link tabs_003 catReq--js" rel="tabs_003" href="javascript:void(0)" onClick="searchProdCategoryRequests()">
            <?php echo Labels::getLabel('LBL_Category_Requests', $siteLangId); ?>
        </a>
    <?php } ?>
    <?php if ($canRequestBadge) { ?>
        <a class="nav-link tabs_003 badgeReq--js" rel="tabs_003" href="javascript:void(0)" onClick="searchBadgeRequests()">
            <?php echo Labels::getLabel('LBL_Badge_Requests', $siteLangId); ?>
        </a>

    <?php } ?>
</nav>