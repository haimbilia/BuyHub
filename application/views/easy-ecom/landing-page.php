<?php

use PhpParser\Node\Stmt\Label;

defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="content-body">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="cards">
                <div class="cards-content">
                    <?php echo CommonHelper::renderHtml($pluginDescription); ?>
                    <div class="row justify-content-center">
                    <div class="col-auto">
                    <div class="mt-4 text-center">
                        <?php if (!empty($easyEcomSellerToken)) { ?>
                            <?php
                            $status = User::getUserMeta($userId, 'easyEcomSyncingStatus');
                            $active = empty($status) || Plugin::INACTIVE == $status ? '' : 'checked';
                            $value = empty($status) ? 1 : 0;
                            ?>
                            <div class="d-flex justify-content-center mb-3">                                
                                <label class="toggle-switch mb-0 mx-2">
                                    <input <?php echo $active; ?> type="checkbox" value="<?php echo $value; ?>" onclick="syncStatusToggle(event, this)" />
                                    <div class="slider round"></div>
                                </label>
                                <p>
                                    <?php echo Labels::getLabel('LBL_AUTO_SYNC', $siteLangId); ?>
                                    <i class='fa fa-info-circle spn_must_field align-middle' data-toggle='tooltip' data-placement='top' title='<?php echo Labels::getLabel('MSG_YOU_CAN_TURN_OFF_AUTO_SYNC_FEATURE_TO_RESTRICT_SYNCING_PRODUCTS_AND_ORDERS_TO_EASYECOM.', $siteLangId); ?>'></i>
                                </p>
                            </div>
                            <a class="btn btn-primary btn-lg" href="javascript:void(0)" onClick="goToDashboard()" style="background-color: #27ae60; border-color: #27ae60;">
                                <?php echo Labels::getLabel('LBL_GO_TO_DASHBOARD', $siteLangId); ?>
                            </a>
                            <iframe id="easyEcomLogin" class='d-none' frameborder="5" width="500" height="300"></iframe>
                        <?php } else { ?>
                            <a class="btn btn-primary btn-lg" href="javascript:void(0)" onClick="register(this)" style="background-color: #27ae60; border-color: #27ae60;">
                                <?php echo Labels::getLabel('LBL_CONNECT', $siteLangId); ?>
                            </a>
                        <?php } ?>
                    </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>