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
    <script>
        <?php
        if (Message::getInfoCount() > 0 || Message::getDialogCount() > 0) { ?>
            $.ykmsg.info('<?php echo html_entity_decode(Message::getHtml()); ?>');
        <?php } else if (Message::getErrorCount() > 0) { ?>
            $.ykmsg.error('<?php echo html_entity_decode(Message::getHtml()); ?>');
        <?php } else if (Message::getMessageCount() > 0) { ?>
            $.ykmsg.success('<?php echo html_entity_decode(Message::getHtml()); ?>');
        <?php } ?>
    </script>

    <?php
    if (FatApp::getConfig("CONF_GOOGLE_TAG_MANAGER_BODY_SCRIPT", FatUtility::VAR_STRING, '') /* && User::checkStatisticalCookiesEnabled() == true */) {
        echo FatApp::getConfig("CONF_GOOGLE_TAG_MANAGER_BODY_SCRIPT", FatUtility::VAR_STRING, '');
    }
