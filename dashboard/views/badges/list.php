<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$badgeLbl = (Badge::TYPE_BADGE == $badgeType);
$headingLabel = $badgeLbl ? Labels::getLabel('LBL_MANAGE_BADGES', $siteLangId) : Labels::getLabel('LBL_MANAGE_RIBBONS', $siteLangId);
$listingLabel = $badgeLbl ? Labels::getLabel('LBL_BADGES_LIST', $siteLangId) : Labels::getLabel('LBL_RIBBONS_LIST', $siteLangId);

if (!empty($frmSearch)) {
    $frmSearch->setFormTagAttribute('onSubmit', 'searchRecords(this); return(false);');
    $frmSearch->setFormTagAttribute('class', 'form formSearch--js');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 4;
    
    $fld = $frmSearch->getField('keyword');
    $fld->setFieldTagAttribute('placeholder', $fld->getCaption());
    $fld->developerTags['noCaptionTag'] = true;
    if (Badge::TYPE_RIBBON == $badgeType){
        $fld->developerTags['col'] = $badgeLbl ? 4 : 8;
        $fld->setFieldTagAttribute('placeholder', $fld->getCaption());
        $fld->developerTags['noCaptionTag'] = true;  
    }

    $fld = $frmSearch->getField('btn_submit');
    if (null != $fld) {
        $fld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
        $fld->developerTags['col'] = 2;
        $fld->developerTags['noCaptionTag'] = true;
    }

    $fld = $frmSearch->getField('btn_clear');
    if (null != $fld) {
        $fld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
        $fld->setFieldTagAttribute('onClick', 'clearSearch()');
        $fld->developerTags['col'] = 2;
        $fld->developerTags['noCaptionTag'] = true;
    }
    $fld = $frmSearch->getField('badge_required_approval');
    if(null != $fld) {
        $fld->developerTags['noCaptionTag'] = true;
    }    
}

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');