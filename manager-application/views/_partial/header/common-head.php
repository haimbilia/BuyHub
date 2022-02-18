<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$additionalAttributes = (CommonHelper::getLayoutDirection() == 'rtl') ? 'style="direction: rtl;"' : '';
?>
<!doctype html>
<html <?php echo $additionalAttributes; ?> class="<?php if (CommonHelper::demoUrl()) {
                                                        echo "sticky-demo-header";
                                                    } ?>" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">

<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if (isset($includeEditor) && $includeEditor == true) {
        $extendEditorJs    = 'true';
    } else {
        $extendEditorJs    = 'false';
    }
    echo '<script type="text/javascript">
		var SITE_ROOT_URL = "' . UrlHelper::generateFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL) . '" ;
		var langLbl = ' . json_encode($jsVariables) . ';
		var CONF_AUTO_CLOSE_SYSTEM_MESSAGES = ' . FatApp::getConfig("CONF_AUTO_CLOSE_SYSTEM_MESSAGES", FatUtility::VAR_INT, 0) . ';
		var layoutDirection ="' . CommonHelper::getLayoutDirection() . '";
		var CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES = ' . FatApp::getConfig("CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES", FatUtility::VAR_INT, 3) . ';
		var extendEditorJs = ' . $extendEditorJs . ';
		if( CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES <= 0  ){
			CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES = 3;
		}
        var controllerName = "' . LibHelper::getControllerName() . '";
		</script>' . "\r\n";


    if (AttachedFile::getAttachment(AttachedFile::FILETYPE_FAVICON, 0, 0, $siteLangId)) { ?>
        <link rel="shortcut icon" href="<?php echo UrlHelper::generateUrl('image', 'favicon', array($siteLangId), CONF_WEBROOT_FRONT_URL) ?>">
    <?php } ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">