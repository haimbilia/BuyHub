<?php
if (USER::USER_SELLER_DASHBOARD != $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_preferred_dashboard']) {
    return;
}

if (applicationConstants::YES != $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_is_supplier']) {
    return;
}

$layoutType = $layoutType ?? '';
$liClass = ($layoutType == applicationConstants::SCREEN_MOBILE) ? 'account-nav-item' : 'dropdown-menu-item';
$aClass = ($layoutType == applicationConstants::SCREEN_MOBILE) ? 'account-nav-link' : 'dropdown-menu-link';
$html = ($layoutType == applicationConstants::SCREEN_MOBILE) ? '<i class="icon icon-arrow-right"></i>' : '';

$userPrivilege = UserPrivilege::getInstance();
if ($userPrivilege->canViewSales(UserAuthentication::getLoggedUserId(), true)) {
?>
    <li class="<?php echo $liClass; ?>">
        <a class="<?php echo $aClass; ?>" href="<?php echo UrlHelper::generateUrl('Seller', 'Sales', [], CONF_WEBROOT_DASHBOARD, null, false, false, false); ?>"><?php echo Labels::getLabel("LBL_Sales", $siteLangId); ?><?php echo $html; ?></a>
    </li>
<?php
}
?>

<?php if ($userPrivilege->canViewProducts(UserAuthentication::getLoggedUserId(), true)) { 
    $prodUrl = UrlHelper::generateUrl('seller', 'products',[],CONF_WEBROOT_DASHBOARD);
    if (FatApp::getConfig('CONF_WITHOUT_PROD_VARIANTS', FatUtility::VAR_INT, 0)) {
        $prodUrl = UrlHelper::generateUrl('seller', 'catalog',[],CONF_WEBROOT_DASHBOARD);
    }
    ?>
    <li class="<?php echo $liClass; ?>">
        <a class="<?php echo $aClass; ?>" href="<?php echo $prodUrl; ?>"><?php echo Labels::getLabel('LBL_Shop_Inventory', $siteLangId); ?><?php echo $html; ?></a>
    </li>

<?php } ?>