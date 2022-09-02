<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit', 'searchRewardPoints(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form');
$frmSrch->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frmSrch->developerTags['fld_default_col'] = 12;
?> <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <?php
            $data = [
                'headingLabel' => Labels::getLabel('LBL_Reward_Points', $siteLangId),
                'siteLangId' => $siteLangId,
            ];
            $this->includeTemplate('_partial/header/content-header.php', $data); ?>
            <div class="content-body">
                <div class="card card-commerce card-commerce-bg" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/images/card-commerce-bg-3.png);">
                    <div class="card-head border-0">
                        <div class="card-head-label">
                            <h5 class="card-title"><?php echo Labels::getLabel('LBL_CURRENT_REWARD_POINTS', $siteLangId); ?></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="stats">
                            <div class="stats-number">
                                <ul>
                                    <li><span class="total"><?php echo Labels::getLabel('LBL_REWARD_POINT_BALANCE', $siteLangId); ?>:</span>
                                        <span class="total-numbers"> <?php echo $totalRewardPoints; ?> </span>
                                    </li>
                                    <li>
                                        <span class="total"><?php echo Labels::getLabel('LBL_WORTH', $siteLangId); ?>:</span>
                                        <span class="total-numbers"><?php echo CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($totalRewardPoints)); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-table">
                        <div id="rewardPointsListing"><?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>