<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$approvalFrm->setFormTagAttribute('onsubmit', 'setupSupplierApproval(this); return(false);');
$approvalFrm->setFormTagAttribute('class', 'form');
$approvalFrm->developerTags['colClassPrefix'] = 'col-md-';
$approvalFrm->developerTags['fld_default_col'] = '4';

$btn = $approvalFrm->getField('btn_submit');
$btn->setFieldTagAttribute('class', "btn btn-brand btn-wide");

$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<main id="main-area" class="main"   >
    <div class="content-wrapper content-space">
        <?php 
        $data = [
            'headingLabel' => Labels::getLabel('Lbl_Seller_Approval_Form', $siteLangId),
            'siteLangId' => $siteLangId,
        ];

        $this->includeTemplate('_partial/header/content-header.php', $data); ?>
        <div class="content-body">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo Labels::getLabel('Lbl_Seller_Approval_Form', $siteLangId);?></h5>
                </div>
                <div class="card-body ">
                    <?php echo $approvalFrm->getFormHtml(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
