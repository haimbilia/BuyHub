<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmOrderCancel->setFormTagAttribute( 'class', 'form form--horizontal' );
$frmOrderCancel->setFormTagAttribute('onsubmit', 'setupOrderCancelRequest(this); return(false);');
$frmOrderCancel->developerTags['colClassPrefix'] = 'col-md-';
$frmOrderCancel->developerTags['fld_default_col'] = 12;
$btnSubmit = $frmOrderCancel->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main"   >
    <div class="content-wrapper content-space">
        <?php 
        $data = [
            'headingLabel' => Labels::getLabel('LBL_Order_Cancellation_Request',$siteLangId),
            'siteLangId' => $siteLangId,         
        ];
        $this->includeTemplate('_partial/header/content-header.php', $data); ?>
        <div class="content-body">
            <div class="card">
                
                <div class="card-body">
                    <?php echo $frmOrderCancel->getFormHtml(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
