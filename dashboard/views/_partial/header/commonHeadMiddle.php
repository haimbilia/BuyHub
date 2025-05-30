<link rel="shortcut icon" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'favicon', array($siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId, '57-57'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId, '60-60'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId, '72-72'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId, '76-76'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId, '114-114'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId, '120-120'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId, '144-144'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId, '152-152'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'appleTouchIcon', array($siteLangId, '180-180'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="icon" type="image/png" sizes="192x192" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'favicon', array($siteLangId, '192-192'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'favicon', array($siteLangId, '32-32'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'favicon', array($siteLangId, '96-96'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'favicon', array($siteLangId, '16-16'), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.png'); ?>">
<link rel="manifest" href="<?php echo UrlHelper::generateUrl('Home', 'pwaManifest',[],CONF_WEBROOT_FRONTEND); ?>">
<?php
if ($canonicalUrl == '') {
    if (empty(FatApp::getParameters()) && FatApp::getAction() == 'index') {
        $cName = ($controllerName == 'Home') ? '' : $controllerName;
        $canonicalUrl = UrlHelper::generateFullUrl($cName);
    } else {
        $action = empty(FatApp::getAction()) ? 'index' : FatApp::getAction();
        $params = empty(FatApp::getParameters()) ? [] : FatApp::getParameters();
        $canonicalUrl = UrlHelper::generateFullUrl($controllerName, $action, $params);
    }
} ?>

<link rel="canonical" href="<?php echo $canonicalUrl; ?>" />
<?php $googleFontFamily = "'Poppins', sans-serif !important";
$fontKey = FatApp::getConfig('CONF_GOOGLE_FONTS_API_KEY', FatUtility::VAR_STRING, '');
$googleFontFamilyUrl = FatApp::getConfig('CONF_THEME_FONT_FAMILY_URL', FatUtility::VAR_STRING, '');
$themeColor = FatApp::getConfig('CONF_THEME_COLOR_RGB', FatUtility::VAR_STRING, "rgb(255,58,89)");
$themeColor = (false === strpos($themeColor, 'rgb') ? 'rgb(' . $themeColor . ')' : $themeColor);
$themeColorInverse = FatApp::getConfig('CONF_THEME_COLOR_INVERSE_RGB', FatUtility::VAR_STRING, "rgb(255,255,255)");
$themeColorInverse = (false === strpos($themeColorInverse, 'rgb') ? 'rgb(' . $themeColorInverse . ')' : $themeColorInverse);
if (!empty($fontKey) && !empty($googleFontFamilyUrl)) {
    $googleFontFamily = FatApp::getConfig('CONF_THEME_FONT_FAMILY', FatUtility::VAR_STRING, '');
    $googleFontFamily =  '"' . str_replace("+", " ", explode('-', $googleFontFamily)[0]) . '" !important';
?>
    <link href="<?php echo $googleFontFamilyUrl; ?>" rel="stylesheet">
<?php
} else { ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<?php } ?>

<style>
    body {
        font-family: <?php echo $googleFontFamily; ?>;
    }

    :root {
        <?php if (CommonHelper::isAppUser()) { ?>
            --brand-color: #<?php echo FatApp::getConfig('CONF_PRIMARY_APP_THEME_COLOR', FatUtility::VAR_STRING, ''); ?>;
            --brand-color-inverse: #<?php echo FatApp::getConfig('CONF_PRIMARY_INVERSE_APP_THEME_COLOR', FatUtility::VAR_STRING, ''); ?>;
            --secondary-color: #<?php echo FatApp::getConfig('CONF_SECONDARY_APP_THEME_COLOR', FatUtility::VAR_STRING, ''); ?>;
            --secondary-color-inverse: #<?php echo FatApp::getConfig('CONF_SECONDARY_INVERSE_APP_THEME_COLOR', FatUtility::VAR_STRING, ''); ?>;
        <?php } else { ?>
            --brand-color: <?php echo $themeColor; ?>;
            --brand-color-alpha: <?php echo strtr($themeColor, ["rgb(" => "", ")" => ""]); ?>;
            --brand-color-inverse: <?php echo $themeColorInverse; ?>;
        <?php } ?>
    }
</style>
<script>
    <?php    
    echo $str = 'var langLbl = ' . FatUtility::convertToJson($jsVariables, JSON_UNESCAPED_UNICODE) . ';
    var CONF_AUTO_CLOSE_SYSTEM_MESSAGES = ' . FatApp::getConfig("CONF_AUTO_CLOSE_SYSTEM_MESSAGES", FatUtility::VAR_INT, 0) . ';
    var CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES = ' . FatApp::getConfig("CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES", FatUtility::VAR_INT, 3) . ';
    var CONF_ENABLE_GEO_LOCATION = ' . (FatApp::getConfig("CONF_ENABLE_GEO_LOCATION", FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '')) ? 1 : 0 ). ';
    var CONF_MAINTENANCE = ' . FatApp::getConfig("CONF_MAINTENANCE", FatUtility::VAR_INT, 0) . ';
    var extendEditorJs = ' . $extendEditorJs . ';   
    var currencySymbolLeft = "' . CommonHelper::getCurrencySymbolLeft() . '";
    var currencySymbolRight = "' . CommonHelper::getCurrencySymbolRight() . '";   
    var controllerName = "' . LibHelper::getControllerName() . '";
    var className = "' . FatApp::getController() . '";
    var actionName = "' . FatApp::getAction() . '";
    if( CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES <= 0  ){
        CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES = 3;
    }';   
  

    if (Message::getMessageCount() || Message::getErrorCount() || Message::getDialogCount() || Message::getInfoCount()) { ?>
            (function() {
                if (CONF_AUTO_CLOSE_SYSTEM_MESSAGES == 1) {
                    var time = CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES * 1000;
                    setTimeout(function() {
                        $.ykmsg.close();
                    }, time);
                }
            })();
    <?php }
    $pixelId = FatApp::getConfig("CONF_FACEBOOK_PIXEL_ID", FatUtility::VAR_STRING, '');
    if ('' != $pixelId /* && User::checkStatisticalCookiesEnabled() == true */) { ?>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo $pixelId; ?>');
        fbq('track', 'PageView');
        var fbPixel = true;
    <?php } ?>
</script>
<?php

if (FatApp::getConfig("CONF_GOOGLE_TAG_MANAGER_HEAD_SCRIPT", FatUtility::VAR_STRING, '') /* && User::checkStatisticalCookiesEnabled() == true */) {
    echo FatApp::getConfig("CONF_GOOGLE_TAG_MANAGER_HEAD_SCRIPT", FatUtility::VAR_STRING, '');
}
if (FatApp::getConfig("CONF_HOTJAR_HEAD_SCRIPT", FatUtility::VAR_STRING, '') /* && User::checkStatisticalCookiesEnabled() == true */) {
    echo FatApp::getConfig("CONF_HOTJAR_HEAD_SCRIPT", FatUtility::VAR_STRING, '');
}
if (FatApp::getConfig("CONF_DEFAULT_SCHEMA_CODES_SCRIPT", FatUtility::VAR_STRING, '')) {
    echo FatApp::getConfig("CONF_DEFAULT_SCHEMA_CODES_SCRIPT", FatUtility::VAR_STRING, '');
}

