<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$submitFld = $frm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand');
$submitFld->developerTags['noCaptionTag'] = true;

?>
<section class="section">
    <div class="sectionhead">
        <h4>
            <?php echo Labels::getLabel('LBL_BADGE_REQUEST', $adminLangId); ?>
        </h4>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>
</section>