<!-- wallet balance[ -->
<?php
$showTotalBalanceAvailableDiv = false;
if ($userTotalWalletBalance != $userWalletBalance || ($promotionWalletToBeCharged) || ($withdrawlRequestAmount)) {
    $showTotalBalanceAvailableDiv = true;
} ?>
<?php if ($showTotalBalanceAvailableDiv) { ?>

    <div class="credits-number">
        <?php if ($userTotalWalletBalance != $userWalletBalance) { ?>
            <div class="card card-commerce card-commerce-bg" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/images/card-commerce-bg-1.png);">
                <div class="card-head border-0">
                    <h6> <?php echo Labels::getLabel('LBL_Wallet_Balance', $siteLangId); ?>: </h6>
                    <i class="icn"> </i>
                </div>
                <div class="card-body">
                    <h3 class="h3">
                        <?php echo CommonHelper::displayMoneyFormat($userTotalWalletBalance); ?>
                    </h3>
                    <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>

                        <small>
                            <?php echo Labels::getLabel('LBL_Approx.', $siteLangId); ?>
                            <?php echo CommonHelper::displayMoneyFormat($userTotalWalletBalance, true, true); ?>
                        </small>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if ($promotionWalletToBeCharged) { ?>
            <div class="card card-commerce card-commerce-bg" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/images/card-commerce-bg-2.png);">
                <div class="card-head border-0">
                    <h6> <?php echo Labels::getLabel('LBL_Pending_Promotions_Charges', $siteLangId); ?>: </h6>
                    <i class="icn"> </i>
                </div>

                <div class="card-body ">
                    <h3 class="h3">
                        <?php echo CommonHelper::displayMoneyFormat($promotionWalletToBeCharged); ?> </h3>
                    <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                        <small>
                            <?php echo Labels::getLabel('LBL_Approx.', $siteLangId);
                            echo CommonHelper::displayMoneyFormat($promotionWalletToBeCharged, true, true); ?>
                        </small>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if ($withdrawlRequestAmount) { ?>
            <div class="card card-commerce card-commerce-bg" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/images/card-commerce-bg-3.png);">
                <div class="card-head border-0">
                    <h6> <?php echo Labels::getLabel('LBL_Pending_Withdrawl_Requests', $siteLangId); ?>: </h6>
                    <i class="icn"> </i>
                </div>
                <div class="card-body">
                    <h3 class="h3">
                        <?php echo CommonHelper::displayMoneyFormat($withdrawlRequestAmount); ?> </h3>

                    <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                        <small><?php echo Labels::getLabel('LBL_Approx.', $siteLangId); ?> <?php echo CommonHelper::displayMoneyFormat($withdrawlRequestAmount, true, true); ?></small>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>