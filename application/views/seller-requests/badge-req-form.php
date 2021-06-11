<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->setFormTagAttribute('onsubmit', 'setupBadgeReq(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$submitFld = $frm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand');
$submitFld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('breq_image');
if (null != $fld) {
	$fld->addFieldTagAttribute('class', 'btn btn-brand btn-sm');
	$fld->addFieldTagAttribute('onChange', 'badgeReqPopupImage(this)');
	$fld->htmlAfterField = '<small class="form-text text-muted">' . Labels::getLabel('LBL_BADGE_REQUEST_REFERENCE_IMAGE', $siteLangId) . '</small>';
}

?>
<div class="box__head">
    <h4>
        <?php echo Labels::getLabel('LBL_REQUEST_TO_BIND_BADGE', $siteLangId); ?>
    </h4>
    <div class="section__toolbar">
        <a href="javascript:void(0);" onclick="backToListing();" title="Back" class="btn-clean btn-sm btn-icon btn-secondary "><i class="fas fa-arrow-left"></i></a>
    </div>
</div>
<div class="box__body">
    <div class="row">
        <div class="col-md-12">
            <div class="form__subcontent">
                <?php echo $frm->getFormHtml(); ?>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="uploaded-img ml-2 uploadedImage--js"></div>
                </div>
            </div>
        </div>
    </div>
</div>