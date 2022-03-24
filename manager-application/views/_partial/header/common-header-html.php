<?php if (isset($includeEditor) && $includeEditor) { ?>
    <script language="javascript" type="text/javascript" src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/innovaeditor.js"></script>
    <script src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/common/webfont.js" type="text/javascript"></script>
<?php  } ?>

<?php if (isset($includeDropZone) && $includeDropZone) {
    $cssFiles = ['dropzone.min.css'];
    echo HtmlHelper::getCssStyleHtml($cssFiles);

    $jsFiles = [
        'dropzone.min.js',
        'yk-dropzone.js',
    ];

    echo HtmlHelper::getJsScriptHtml($jsFiles);
} ?>

</head>
<?php $adminSidebar = $_COOKIE['adminSidebar'] ?? 0;
$adminSidebar = (in_array(FatApp::getController(), ['ProductsController','CustomProductsController']) &&  FatApp::getAction() == 'form') ? 0 : $adminSidebar;
?>

<body class="<?php echo $bodyClass; ?>" data-sidebar-minimize="<?php echo (0 < $adminSidebar) ? 'off' : 'on' ?>">
    <?php if (FatApp::getConfig('CONF_AUTO_RESTORE_ON', FatUtility::VAR_INT, 1) && CommonHelper::demoUrl()) {
        $tplFile = str_replace(CONF_APPLICATION_PATH, CONF_INSTALLATION_PATH . CONF_FRONT_END_APPLICATION_DIR, CONF_THEME_PATH);
        $tplFile .= 'restore-system/top-header.php';
        include_once $tplFile;
    } ?>