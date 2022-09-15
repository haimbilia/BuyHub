<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!$notEligible) { ?>
    <div class="mt-5 no-print cancelReason-js">
        <h5><?php echo Labels::getLabel('LBL_REASON_FOR_CANCELLATION', $siteLangId); ?></h5>
        <?php
        $cancelForm->setFormTagAttribute('onsubmit', 'cancelReason(this); return(false);');
        $cancelForm->setFormTagAttribute('class', 'form');
        $cancelForm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
        $cancelForm->developerTags['fld_default_col'] = 12;

        $btnSubmit = $cancelForm->getField('btn_submit');
        $btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
        echo $cancelForm->getFormHtml(); ?>
    </div>
<?php } ?>