<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-lg-6 col-md-6 col-sm-';
$frm->developerTags['fld_default_col'] = 6;
$frm->setFormTagAttribute('onsubmit', 'setupUser(this);  return(false);');

$fldSubmit = $frm->getField('btn_submit');
$fldSubmit->addFieldTagAttribute('class', 'btn btn--primary btn--sm');

$fldCancel = $frm->getField('btn_cancel');
$fldCancel->addFieldTagAttribute('class', 'btn btn-outline-primary btn--sm'); 
$fldCancel->addFieldTagAttribute('onclick', 'landingPage()'); 
?>
<div class="content-body">
    <div class="cards">
        <div class="cards-content">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <h6 class="content-header-title"><?php echo Labels::getLabel("LBL_REGISTER", $siteLangId); ?></h6>
                </div>
                <div class="col-lg-12">
                    <?php echo $frm->getFormHtml(); ?>
                </div>
            </div>
        </div>
    </div>
</div>