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
                <div class="card card-commerce card-commerce-bg" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/images/card-commerce-bg-1.png);">
                    <div class="card-head border-0">
                        <h5 class="card-title"><?php echo Labels::getLabel('LBL_CURRENT_REWARD_POINTS', $siteLangId); ?></h5>
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
                <?php /*  ?>
                <div class="card">
                    <div class="card-body">
                        <ul class="points-timeline" id="points-timeline">
                            <li class="earned">
                                <button class="points-timeline__block  collapsed dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="points-timeline__block_data">
                                        <div class="points-timeline__block_title">
                                            <span class="badge badge-success">440</span> Points earned from Order #10027
                                        </div>
                                        <div class="points-timeline__block_date">31-03-2021</div>

                                    </div>
                                    <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                                    </i>
                                </button>
                                <div id="collapseOne" class="collapse show">
                                    <ul class="points-list-group">
                                        <li class="points-list-group-item">
                                            <a target="_blank" href="#">
                                                <div class="product-profile">
                                                    <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/132/132|119|/48-64?t=1595308258" alt=""></div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Charlie Carryall 40</div>
                                                        <div class="options"><strong>240</strong>
                                                            points earned for
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/314">
                                                <div class="product-profile">
                                                    <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/314/314|61|/48-64?t=1616592468" alt=""></div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Tiffany Victoria® Ring</div>
                                                        <div class="options"><strong>200</strong>
                                                            points earned for
                                                        </div>
                                                    </div>
                                                </div>
                                            </a></li>
                                    </ul>
                                    <p class="date-expire">Expiry Date: <strong>25-08-2024</strong> </p>
                                </div>
                            </li>
                            <li class="redeemed">
                                <button class="points-timeline__block  collapsed dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <div class="points-timeline__block_data">
                                        <div class="points-timeline__block_title">
                                            <span class="badge badge-success">440</span> Points earned from Order #10027
                                        </div>
                                        <div class="points-timeline__block_date">31-03-2021</div>

                                    </div>
                                    <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                                    </i>
                                </button>
                                <div id="collapseTwo" class="collapse">
                                    <ul class="points-list-group">
                                        <li class="points-list-group-item">
                                            <a target="_blank" href="#">
                                                <div class="product-profile">
                                                    <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/132/132|119|/48-64?t=1595308258" alt=""></div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Charlie Carryall 40</div>
                                                        <div class="options"><strong>240</strong>
                                                            points earned for
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/314">
                                                <div class="product-profile">
                                                    <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/314/314|61|/48-64?t=1616592468" alt=""></div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Tiffany Victoria® Ring</div>
                                                        <div class="options"><strong>200</strong>
                                                            points earned for
                                                        </div>
                                                    </div>
                                                </div>
                                            </a></li>
                                    </ul>
                                    <p class="date-expire">25-08-2024</p>
                                </div>
                            </li>
                            <li class="redeemed">
                                <button class="points-timeline__block  collapsed dropdown-toggle-custom" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <div class="points-timeline__block_data">
                                        <div class="points-timeline__block_title">
                                            <span class="badge badge-success">440</span> Points earned from Order #10027
                                        </div>
                                        <div class="points-timeline__block_date">31-03-2021</div>

                                    </div>
                                    <i class="dashboard-menu-arrow dropdown-toggle-custom-arrow">
                                    </i>
                                </button>
                                <div id="collapseTwo" class="collapse">
                                    <ul class="points-list-group">
                                        <li class="points-list-group-item">
                                            <a target="_blank" href="#">
                                                <div class="product-profile">
                                                    <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/132/132|119|/48-64?t=1595308258" alt=""></div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Charlie Carryall 40</div>
                                                        <div class="options"><strong>240</strong>
                                                            points earned for
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/314">
                                                <div class="product-profile">
                                                    <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/314/314|61|/48-64?t=1616592468" alt=""></div>
                                                    <div class="product-profile__data">
                                                        <div class="title">Tiffany Victoria® Ring</div>
                                                        <div class="options"><strong>200</strong>
                                                            points earned for
                                                        </div>
                                                    </div>
                                                </div>
                                            </a></li>
                                    </ul>
                                </div>
                            </li>


                        </ul>
                    </div>

                </div>
                <?php    */?>
                <div class="card">
                    <div class="card-body">
                        <div id="rewardPointsListing"><?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>