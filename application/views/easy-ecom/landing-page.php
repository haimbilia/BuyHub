<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="content-body">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="cards">
                <div class="cards-content">
                    <?php echo CommonHelper::renderHtml($pluginDescription); ?>
                    <div class="mt-4 text-center">
                        <?php if (!empty($easyEcomSellerToken)) { ?>
                            <a 
                                class="btn btn-primary btn-lg"
                                href="javascript:void(0)"
                                onClick="login('<?php echo $userTempToken; ?>')"
                                style="background-color: #27ae60; border-color: #27ae60;">
                                <?php echo Labels::getLabel('LBL_GO_TO_DASHBOARD', $siteLangId); ?>
                            </a>
                            <iframe id="easyEcomLogin" class='d-none' frameborder="5" width="500" height="300"></iframe>
                        <?php } else { ?>
                            <a
                                class="btn btn-primary btn-lg"
                                href="javascript:void(0)"
                                onClick="register(this)"
                                style="background-color: #27ae60; border-color: #27ae60;">
                                <?php echo Labels::getLabel('LBL_CONNECT', $siteLangId); ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>