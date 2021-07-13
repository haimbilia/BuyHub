</head>
<?php
$bodyClass = ($controllerName == 'Home') ? 'home' : 'inner';
if ($controllerName == 'Blog') {
    $bodyClass = 'is--blog';
}
if ($controllerName == 'Checkout' || $controllerName == 'SubscriptionCheckout') {
    $bodyClass = 'is-checkout';
}

if (CommonHelper::demoUrl()) {
    $bodyClass .= ' have-fixed-btn';
}
?>

<body class="<?php echo $bodyClass; ?> ">
    <?php
    $alertClass = '';
    if (Message::getInfoCount() > 0) {
        $alertClass = 'alert--info';
    } elseif (Message::getErrorCount() > 0) {
        $alertClass = 'alert--danger';
    } elseif (Message::getMessageCount() > 0) {
        $alertClass = 'alert--success';
    }
    ?>
    <?php
    if (FatApp::getConfig("CONF_GOOGLE_TAG_MANAGER_BODY_SCRIPT", FatUtility::VAR_STRING, '') && User::checkStatisticalCookiesEnabled() == true) {
        echo FatApp::getConfig("CONF_GOOGLE_TAG_MANAGER_BODY_SCRIPT", FatUtility::VAR_STRING, '');
    }
    ?>
    <div class="system_message alert alert--positioned-top-full <?php echo $alertClass; ?>" style="display:none">
        <div class="close"></div>
        <div class="content">
            <?php
            $haveMsg = false;
            if (Message::getMessageCount() || Message::getErrorCount() || Message::getDialogCount() || Message::getInfoCount()) {
                $haveMsg = true;
                echo html_entity_decode(Message::getHtml());
            } ?>
        </div>
    </div>
    <?php /*?> <div id="quick-view-section" class="quick-view"></div>    <?php */ ?>