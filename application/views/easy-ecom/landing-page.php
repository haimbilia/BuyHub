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
                        <a class="btn btn-outline-primary btn--sm" href="javascript:void(0)" onClick="login('<?php echo $userTempToken; ?>')">
                            <?php echo Labels::getLabel('LBL_GO_TO_DASHBOARD', $siteLangId); ?>
                        </a>
                        <iframe id="easyEcomLogin" class='d-none' frameborder="5" width="500" height="300"></iframe>
                    <?php } else { ?>
                        <a class="btn btn-primary btn--sm" href="javascript:void(0)" onClick="register(this)">
                            <?php echo Labels::getLabel('LBL_CONNECT', $siteLangId); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>