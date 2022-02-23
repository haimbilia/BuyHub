<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('id', 'digitalDownloadFrm');
$frm->setFormTagAttribute('enctype', 'multipart/form-data');

$frm->setFormTagAttribute('onsubmit', "setupDigitalDownload($('#digitalDownloadFrm'))");
$frm->setFormTagAttribute('data-onclear', "digitalDownloadsForm($type)");

$fld = $frm->getField('option_comb_id');
if ($fld) {
    $fld->addFieldTagAttribute('id', "digitalFrmOptionId");
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('record_id');
$fld->addFieldTagAttribute('id', "digitalFrmRecordId");
$fld = $frm->getField('download_type');
$fld->addFieldTagAttribute('id', "digitalFrmdownloadType");

$fld = $frm->getField('attach_with_existing_orders');
if ($fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('lang_id');
if ($fld) {
    $fld->addFieldTagAttribute('id', "digitalFrmLangId");
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('downloadable_file');
if ($fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
    $fld->addWrapperAttribute('id', 'downloadableFileMainJs');
}

$fld = $frm->getField('preview_file');
if ($fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('product_downloadable_link');
if ($fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('product_preview_link');
if ($fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('product_preview_link');
if ($fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$includeTabs = false;
HtmlHelper::formatFormFields($frm);

require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
        <div id="digitalFrmListJs"></div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>