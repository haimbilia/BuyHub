<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->setFormTagAttribute('id', 'badgeRequestForm--js');
$frm->setFormTagAttribute('onsubmit', 'setupBadgeReq(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$submitFld = $frm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand');
$submitFld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('breq_file');
if (null != $fld) {
	$fld->addFieldTagAttribute('class', 'btn btn-brand btn-sm fileUpload--js');
	$fld->htmlAfterField = '<small class="form-text text-muted">' . Labels::getLabel('LBL_BADGE_REQUEST_REFERENCE_FILE', $siteLangId) . '</small>';
}

?>
<div class="box__head">
    <h4><?php echo Labels::getLabel('LBL_REQUEST_TO_BIND_BADGE', $siteLangId); ?></h4>
</div>
<div class="box__body">
    <div class="row">
        <div class="col-md-12">
            <div class="form__subcontent">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>
</div>