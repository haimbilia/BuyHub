<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="content-body">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="cards">
                <div class="cards-content d-flex justify-content-between align-items-center">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="cards">
                <div class="cards-content">
                    <?php if (!empty($easyEcomSellerToken)) { ?>
                        <a class="btn btn-outline-primary btn--sm" target="_blank" href="javascript:void(0)">
                            <?php echo Labels::getLabel('LBL_GO_TO_DASHBOARD', $siteLangId); ?>
                        </a>
                    <?php } else { ?>
                        <a class="btn btn--primary btn--sm" href="javascript:void(0)" onClick="register(this)" href="javascript:void(0)">
                            <?php echo Labels::getLabel('LBL_CONNECT', $siteLangId); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>