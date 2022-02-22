<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

    <div class="content-wrapper content-space">
        <?php 
        $data = [
            'headingLabel' => $taxCategory,
            'siteLangId' => $siteLangId,
            'headingBackButton' => true           
        ];
        $this->includeTemplate('_partial/header/content-header.php', $data); ?>
        <div class="content-body">
            <div class="card">
                <?php echo $frmSearch->getFormHtml(); ?>
                <div class="card-body" id="listing">                   
                </div>
            </div>
        </div>
    </div>

