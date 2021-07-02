<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="tabs">
	<ul class="tabs_nav-js">
		<?php if (FatApp::getConfig('CONF_SELLER_CAN_REQUEST_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0)) { ?>
			<li class="is-active">
				<a class="tabs_001 customCatalogReq--js" rel="tabs_001" href="javascript:void(0)" onClick="searchCustomCatalogProducts()">
					<?php echo Labels::getLabel('LBL_Marketplace_Products_Requests', $siteLangId); ?> <i class="fa fa-question-circle" onClick="productInstructions(<?php echo Extrapage::PRODUCT_REQUEST_INSTRUCTIONS; ?>)"></i></a>
			</li>
		<?php } ?>
		<?php if (FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) { ?>
			<li>
				<a class="tabs_002 brandReq--js" rel="tabs_002" href="javascript:void(0)" onClick="searchBrandRequests()">
					<?php echo Labels::getLabel('LBL_Brand_Requests', $siteLangId); ?></a>
			</li>
		<?php } ?>
		<?php if (FatApp::getConfig('CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) { ?>
			<li>
				<a class="tabs_003 catReq--js" rel="tabs_003" href="javascript:void(0)" onClick="searchProdCategoryRequests()">
					<?php echo Labels::getLabel('LBL_Category_Requests', $siteLangId); ?></a>
			</li>
		<?php } ?>
		<?php if ($canRequestBadge) { ?>
			<li>
				<a class="tabs_003 badgeReq--js" rel="tabs_003" href="javascript:void(0)" onClick="searchBadgeRequests()">
					<?php echo Labels::getLabel('LBL_Badge_Requests', $siteLangId); ?></a>
			</li>
		<?php } ?>
	</ul>
</div>