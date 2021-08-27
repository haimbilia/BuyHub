<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$inactive = (0 == $shop_id) ? 'fat-inactive' : '';
$formLangId = isset($formLangId) ? $formLangId : 0;
$splitPaymentMethodsPlugins = Plugin::getDataByType(Plugin::TYPE_SPLIT_PAYMENT_METHOD, $siteLangId);
?>
<div class="tabs">
    <ul class="arrowTabs" id="shopMainBlockTabsJs" data-shop_id="<?php echo $shop_id;?>">
        <li class="is-active">
            <a href="javascript:void(0)" onclick="shopForm()"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a>
        </li>
        <li id="langFormJs">
            <a class="<?php echo $formLangId?>" href="javascript:void(0);" onclick="shopLangForm(<?php echo $shop_id;?>,<?php echo FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1); ?>);">
                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="returnAddressForm()">
                <?php echo Labels::getLabel('LBL_Return_Address', $siteLangId);?>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="pickupAddress()"  >
                <?php echo Labels::getLabel('LBL_Pickup_Address', $siteLangId);?>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="shopMediaForm()"> 
                <?php echo Labels::getLabel('LBL_Media', $siteLangId); ?>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)"  onclick="shopCollections()" >
                <?php echo Labels::getLabel('LBL_COLLECTIONS', $siteLangId); ?>
            </a>
        </li>       
        <li>
            <a href="javascript:void(0)" onclick="socialPlatforms()">
                <?php echo Labels::getLabel('LBL_SOCIAL_PLATFORMS', $siteLangId); ?>
            </a>
        </li>

        <?php foreach ($splitPaymentMethodsPlugins as $plugin) { ?>
            <li>
                <a href="javascript:void(0)" class="pluginPlatform-js <?php echo $plugin['plugin_code']; ?>"  onclick="pluginPlatform(this)" data-platformurl="<?php echo UrlHelper::generateUrl($plugin['plugin_code'])?>">
                    <?php echo $plugin['plugin_name']; ?>
                </a>
            </li>
            <script>
                var keyName = "<?php echo $plugin['plugin_code']?>";
            </script>
        <?php } ?>
    </ul>
</div>