<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$headingLabel = Labels::getLabel('LBL_MANAGE_BADGE_REQUESTS', $adminLangId);
$listingLabel = Labels::getLabel('LBL_BADGE_REQUEST_LIST', $adminLangId);

if (!empty($frmSearch)) {
    $frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
    $frmSearch->setFormTagAttribute('class', 'web_form formSearch--js');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 4;

    $fld = $frmSearch->getField('btn_clear');
    if (null != $fld) {
        $fld->setFieldTagAttribute('onClick', 'clearSearch()');
    }
}

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');