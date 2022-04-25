<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm, 6);
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('id', 'digitalDownloadFrm');
$fld = $frm->getField('option_comb_id');
if ($fld) {
    $fld->addFieldTagAttribute('id', "digitalFrmOptionId");    
}

$fld = $frm->getField('record_id');
$fld->addFieldTagAttribute('id', "digitalFrmRecordId");
$fld = $frm->getField('download_type');
$fld->addFieldTagAttribute('id', "digitalFrmdownloadType");

$fld = $frm->getField('lang_id');
$fld->addFieldTagAttribute('id', "digitalFrmLangId");  

$includeTabs = false;
require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
        <div id="digitalFrmListJs"></div>
    </div>    
</div>