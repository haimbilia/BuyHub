<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$dateFromFld = $frmSearch->getField('date_from');
$dateFromFld->setFieldTagAttribute('class', 'field--calender');
$dateFromFld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_FROM_DATE', $siteLangId));

$dateToFld = $frmSearch->getField('date_to');
$dateToFld->setFieldTagAttribute('class', 'field--calender');
$dateToFld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_TO_DATE', $siteLangId));

$showTotalBalanceAvailableDiv = ($userTotalWalletBalance != $userWalletBalance || ($promotionWalletToBeCharged) || ($withdrawlRequestAmount));

$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_MY_CREDITS', $siteLangId),
        'siteLangId' => $siteLangId
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="row mb-4">
            <div class="col-lg-12">
                <?php if ($codMinWalletBalance > -1) { ?>
                    <p class="note">
                        <?php echo Labels::getLabel('MSG_MINIMUM_BALANCE_REQUIRED_FOR_COD', $siteLangId) . ' : ' . CommonHelper::displaymoneyformat($codMinWalletBalance); ?>
                    </p>
                <?php } ?>
                <div class="row">
                    <?php 
                    if ($showTotalBalanceAvailableDiv) {
                        if ($promotionWalletToBeCharged) { ?>
                            <div class="col-md-auto">
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
                            </div>
                        <?php }

                        if ($withdrawlRequestAmount) { ?>
                            <div class="col-md-auto">
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
                            </div>
                    <?php }
                    } ?>
                    <div class="col-md-auto">
                        <div class="card card-commerce form">
                            <div class="card-head border-0">
                                <h6>
                                    <p><?php echo Labels::getLabel('LBL_AVAILABLE_BALANCE', $siteLangId); ?>: </p>
                                </h6>
                            </div>
                            <div class="card-body">
                                <h3><?php echo CommonHelper::displayMoneyFormat($userWalletBalance); ?></h3>
                                <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                                    <small class="d-block">
                                        <?php echo Labels::getLabel('LBL_Approx.', $siteLangId); ?>
                                        <?php echo CommonHelper::displayMoneyFormat($userWalletBalance, true, true); ?>
                                    </small>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-lg-7">
                                        <select name='payout_type' class='custom-select payout_type'>
                                            <?php
                                            foreach ($payouts as $type => $name) { ?>
                                                <option value='<?php echo $type; ?>'><?php echo $name; ?></option>
                                            <?php }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-lg-5">
                                        <a href="javascript:void(0)" onclick="withdrawalReqForm()" class="btn btn-brand btn-block">
                                            <?php echo Labels::getLabel('LBL_Withdraw', $siteLangId); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($canAddMoneyToWallet) { ?>
                        <div class="col-md-auto">
                            <div class="card card-commerce">
                                <div class="card-head border-0">
                                    <h6>
                                        <?php
                                        $str = Labels::getLabel('LBL_Add_Wallet_Credits_[{CURRENCY-SYMBOL}]', $siteLangId);
                                        echo CommonHelper::replaceStringData($str, ['{CURRENCY-SYMBOL}' => CommonHelper::getDefaultCurrencySymbol()]); ?>
                                    </h6>

                                </div>
                                <div class="card-body">
                                    <div id="rechargeWalletDiv" class="">
                                        <?php
                                        $frmRechargeWallet->setFormTagAttribute('onSubmit', 'setUpWalletRecharge(this); return false;');
                                        $frmRechargeWallet->setFormTagAttribute('class', 'form');
                                        $frmRechargeWallet->developerTags['colClassPrefix'] = 'col-md-';
                                        $frmRechargeWallet->developerTags['fld_default_col'] = 12;
                                        $frmRechargeWallet->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_WITH_NONE);

                                        $amountFld = $frmRechargeWallet->getField('amount');
                                        $amountFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Enter_Amount', $siteLangId));
                                        $amountFld->developerTags['noCaptionTag'] = true;
                                        $amountFld->developerTags['col'] = 7;
                                        $buttonFld = $frmRechargeWallet->getField('btn_submit');
                                        $buttonFld->setFieldTagAttribute('class', 'btn-block block-on-mobile');
                                        $buttonFld->developerTags['noCaptionTag'] = true;
                                        $buttonFld->developerTags['col'] = 5;
                                        $buttonFld->setFieldTagAttribute('class', "btn btn-brand btn-block");
                                        echo $frmRechargeWallet->getFormHtml(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                                    <div class="card-body">
                                        <div id="creditListing"><?php echo Labels::getLabel('LBL_LOADING..', $siteLangId); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>