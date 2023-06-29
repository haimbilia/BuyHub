<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fontKey = FatApp::getConfig('CONF_GOOGLE_FONTS_API_KEY', FatUtility::VAR_STRING, '');
$googleFontFamily = "'Montserrat', sans-serif !important";
$googleFontFamilyUrl = FatApp::getConfig('CONF_THEME_FONT_FAMILY_URL', FatUtility::VAR_STRING, '');
if (!empty($fontKey) && !empty($googleFontFamilyUrl)) {
    $googleFontFamily = FatApp::getConfig('CONF_THEME_FONT_FAMILY', FatUtility::VAR_STRING, '');
    $googleFontFamily =  '"' . str_replace("+", " ", explode('-', $googleFontFamily)[0]) . '" !important';
?>
    <link href="<?php echo $googleFontFamilyUrl; ?>" rel="stylesheet">
<?php
} else { ?>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<?php } ?>