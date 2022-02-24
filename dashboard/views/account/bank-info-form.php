<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php');

$frm->setFormTagAttribute('id', 'bankInfoFrm');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 6;
$frm->setFormTagAttribute('onsubmit', 'setBankInfo(this); return(false);');

$fld = $frm->getField('ub_bank_address');
$fld->developerTags['col'] = 12;

$fld = $frm->getField('btn_submit');
$fld->setFieldTagAttribute('class', "btn btn-brand");

$fld = $frm->getField('bank_info_safety_text');
$fld->developerTags['col'] = 12;
?>
<div class="content-wrapper content-space">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <?php
            $data = [
                'headingLabel' => Labels::getLabel('LBL_BANK_ACCOUNT', $siteLangId),
                'siteLangId' => $siteLangId,
            ];

            $this->includeTemplate('_partial/header/content-header.php', $data); ?>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <?php echo $frm->getFormHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>