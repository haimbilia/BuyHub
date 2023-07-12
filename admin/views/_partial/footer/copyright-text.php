<?php if (CommonHelper::demoUrl() || true == WHITE_LABELED) {
    $replacements = array(
        '{YEAR}' => '&copy; ' . date("Y"),
        '{PRODUCT}' => '<a target="_blank" href="https://yo-kart.com">Yo!Kart</a>',
        '{OWNER}' => '<a target="_blank" href="https://www.fatbit.com/">FATbit Technologies</a>',
    );
    $str = CommonHelper::replaceStringData(Labels::getLabel('LBL_COPYRIGHT_TEXT', $siteLangId), $replacements);
} else {
    $str = 'Copyright &copy; ' . date('Y') . ' ' . FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId, FatUtility::VAR_STRING, '') . '. Powered by <a target="_blank" href="https://yo-kart.com">Yo!Kart</a> and Developed by <a target="_blank" href="https://www.fatbit.com/">FATbit Technologies</a>';
}
echo $str .= ' ' . CONF_WEB_APP_VERSION;
