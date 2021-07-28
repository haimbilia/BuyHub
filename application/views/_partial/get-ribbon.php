<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$viewDirPath = isset($isFront) ? CONF_VIEW_DIR_PATH : CONF_FRONT_END_THEME_PATH;

$html = "";
if (isset($ribbRow) && !empty($ribbRow)) {
    include $viewDirPath . '_partial/ribbon-ui.php';
} else {
    $ribSelProdId = isset($ribSelProdId) ? $ribSelProdId : 0;
    $ribProdId = isset($ribProdId) ? $ribProdId : 0;
    $ribShopId = isset($ribShopId) ? $ribShopId : 0;
    $frontReturn = isset($frontReturn) ? $frontReturn : false;

    $obj = new Badge();
    $ribbonDetail = $obj->setRecordId($ribSelProdId, $ribProdId, $ribShopId)
                        ->getRibbonOrBadge($siteLangId);

    if (is_array($ribbonDetail) && !empty($ribbonDetail)) {
        foreach ($ribbonDetail as $ribbRow) {
            $position = $ribbRow['blinkcond_position'];
            include $viewDirPath . '_partial/ribbon-ui.php';
            $html .= $ribbon;
        }
        $ribbRow = '';
    }
    
    if (false === $frontReturn) {
        echo $html;
    }
    
}