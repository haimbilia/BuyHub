<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header row">
            <div class="col">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Seller_Options', $siteLangId); ?></h2>
            </div>           
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="Listing"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    searchPlugin(<?php echo $type;?>);

</script>
