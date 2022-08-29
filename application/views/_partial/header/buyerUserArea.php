<?php
if (User::USER_TYPE_BUYER != $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_is_buyer']) {
    return;
}

if (applicationConstants::YES != $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_preferred_dashboard']) {
    return;
}
$layoutType = $layoutType ?? '';
$liClass = ($layoutType == applicationConstants::SCREEN_MOBILE) ? 'account-nav-item' : 'dropdown-menu-item';
$aClass = ($layoutType == applicationConstants::SCREEN_MOBILE) ? 'account-nav-link' : 'dropdown-menu-link';

$html = ($layoutType == applicationConstants::SCREEN_MOBILE) ? '<i class="icon icon-arrow-right"></i>' : '';

?>
<li class="<?php echo $liClass; ?>">
    <a class="<?php echo $aClass; ?>" href="<?php echo UrlHelper::generateUrl('Buyer', 'Orders', [], CONF_WEBROOT_DASHBOARD, null, false, false, false); ?>"><?php echo Labels::getLabel("LBL_Orders", $siteLangId); ?>
        <?php echo $html; ?></a>
</li>
<li class="<?php echo $liClass; ?>">
    <a class="<?php echo $aClass; ?>" href="<?php echo UrlHelper::generateUrl('Account', 'credits', [], CONF_WEBROOT_DASHBOARD, null, false, false, false); ?>"><?php echo Labels::getLabel('LBL_My_Credits', $siteLangId); ?><?php echo $html; ?></a>
</li>
<li class="<?php echo $liClass; ?>">
    <a class="<?php echo $aClass; ?>" href="<?php echo UrlHelper::generateUrl('Account', 'myAddresses', [], CONF_WEBROOT_DASHBOARD, null, false, false, false); ?>"><?php echo Labels::getLabel("LBL_Manage_Addresses", $siteLangId); ?><?php echo $html; ?></a>
</li>