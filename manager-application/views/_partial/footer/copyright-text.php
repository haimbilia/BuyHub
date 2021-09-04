<?php if (CommonHelper::demoUrl()) {
    $replacements = array(
        '{YEAR}' => '&copy; ' . date("Y"),
        '{PRODUCT}' => '<a target="_blank" href="https://yo-kart.com">Yo!Kart</a>',
        '{OWNER}' => '<a target="_blank" href="https://www.fatbit.com/">FATbit Technologies</a>',
    );
    $str = CommonHelper::replaceStringData(Labels::getLabel('LBL_COPYRIGHT_TEXT', $adminLangId), $replacements);
} else {
    $str = FatApp::getConfig("CONF_WEBSITE_NAME_" . $adminLangId, FatUtility::VAR_STRING, 'Copyright &copy; ' . date('Y') . ' <a href="https://www.fatbit.com/">FATbit.com');
}
echo $str .= ' ' . CONF_WEB_APP_VERSION;
