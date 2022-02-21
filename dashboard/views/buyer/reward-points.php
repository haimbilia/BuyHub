<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit', 'searchRewardPoints(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form');
$frmSrch->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frmSrch->developerTags['fld_default_col'] = 12;
?> <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Reward_Points', $siteLangId),
        'siteLangId' => $siteLangId,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="card">
            <div class="card-head">
                <h5 class="card-title">
                    <?php echo Labels::getLabel('LBL_Current_Reward_Points', $siteLangId); ?> (<?php echo $totalRewardPoints; ?>) -
                    <?php echo CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($totalRewardPoints)); ?>
                </h5>
            </div>

            <div class="card-body">
                <!-- <h2><?php echo Labels::getLabel("LBL_Reward_Point_History", $siteLangId); ?></h2> -->
                <div id="rewardPointsListing"><?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?></div>
                <div class="total-balance" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>images/retina/rewards_graphic.svg);">
                    <div class="total-balance_inner"><span class="value">
                            2220
                        </span>
                        <p class="label">Reward Points Balance:</p>
                    </div>
                    <div class="total-balance_inner"><span class="value">
                            $444.00
                        </span>
                        <p class="label">Worth:</p>
                    </div>
                </div>
                <ul class="points-timeline">
                    <li class="earned">
                        <div block="" class="points-timeline__block dropdown-toggle collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10027null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/points-earned-for-product.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">440</span> Points earned from Order #10027</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin"></div>
                            </div>
                        </div>
                        <div id="accordion10027null" style="display: none;" class="collapse">
                            <ul class="points-list-group scroll-y">
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/132">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/132/132|119|/48-64?t=1595308258" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Charlie Carryall 40</div>
                                                <div class="options"><strong>240</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/314">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/314/314|61|/48-64?t=1616592468" data-yk="" alt=""></div>
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
                    <li class="earned">
                        <div block="" class="points-timeline__block dropdown-toggle collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10026null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/points-earned-for-product.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">85</span> Points earned from Order #10026</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin"></div>
                            </div>
                        </div>
                        <div id="accordion10026null" style="display: none;" class="collapse">
                            <ul class="points-list-group scroll-y">
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/39">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/39/39|11|/48-64?t=1617170897" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">High Waist Running Shorts</div>
                                                <div class="options"><strong>10</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/42">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/42/42|58|/48-64?t=1596107457" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Striped Wrap Midi Skirt</div>
                                                <div class="options"><strong>60</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/40">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/40/40|1|60|/48-64?t=1596105539" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Women's Ellison Textured Lace Skirt</div>
                                                <div class="options"><strong>15</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="redeemed">
                        <div block="" class="points-timeline__block collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10025null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/product-return-deduction-points.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-danger">-250</span> Points redeemed</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin">250 points used towards order #10025</div>
                            </div>
                        </div>
                        <div id="accordion10025null" class="collapse" style="display: none;"></div>
                    </li>
                    <li class="earned">
                        <div block="" class="points-timeline__block dropdown-toggle collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10020null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/points-earned-for-product.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">1175</span> Points earned from Order #10020</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin"></div>
                            </div>
                        </div>
                        <div id="accordion10020null" class="collapse" style="display: none;">
                            <ul class="points-list-group scroll-y">
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/225">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/225/0/48-64?t=1595498991" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Ocean Bleu by EFFY® Blue Topaz (7-1/10 ct. t.w.) and Diamond (1/8 ct. t.w.) Pendant Necklace in 14k White Gold</div>
                                                <div class="options"><strong>1175</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="earned">
                        <div block="" class="points-timeline__block dropdown-toggle collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10018null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/points-earned-for-product.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">370</span> Points earned from Order #10018</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin"></div>
                            </div>
                        </div>
                        <div id="accordion10018null" class="collapse" style="display: none;">
                            <ul class="points-list-group scroll-y">
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/70">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/70/70|74|280|/48-64?t=1596518670" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Women's Revolution 5 Running Sneakers from Finish Line</div>
                                                <div class="options"><strong>30</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/21">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/21/21|59|/48-64?t=1596021165" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Sequined Lace Gown</div>
                                                <div class="options"><strong>340</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="earned">
                        <div block="" class="points-timeline__block dropdown-toggle collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10017null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/points-earned-for-product.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">155</span> Points earned from Order #10017</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin"></div>
                            </div>
                        </div>
                        <div id="accordion10017null" class="collapse" style="display: none;">
                            <ul class="points-list-group scroll-y">
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/162">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/162/0/48-64?t=1595320912" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Sunglasses, HC8158</div>
                                                <div class="options"><strong>95</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/289">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/289/0/48-64?t=1595836343" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Dramatically Different Moisturizing Lotion+ with Pump, 4.2 oz</div>
                                                <div class="options"><strong>15</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/302">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/302/302|3|/48-64?t=1616572770" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Calvin Klein Printed Handheld Bag</div>
                                                <div class="options"><strong>45</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="birthday">
                        <div block="" class="points-timeline__block collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion0null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/birthday-points.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">200</span> Points earned from Order</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin">Happy Birthday! Here are 200 points from us to make your Birthday even more special!</div>
                            </div>
                        </div>
                        <div id="accordion0null" class="collapse" style="display: none;"></div>
                    </li>
                    <li class="earned">
                        <div block="" class="points-timeline__block dropdown-toggle collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10010null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/points-earned-for-product.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">300</span> Points earned from Order #10010</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin"></div>
                            </div>
                        </div>
                        <div id="accordion10010null" class="collapse" style="display: none;">
                            <ul class="points-list-group scroll-y">
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/294">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/294/0/48-64?t=1595843309" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Double Serum Complete Age Control Concentrate, 1.6-oz.</div>
                                                <div class="options"><strong>130</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/166">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/166/166|9|13|/48-64?t=1617171906" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Belted Water Resistant Trench Coat</div>
                                                <div class="options"><strong>130</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/46">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/46/46|11|/48-64?t=1594982081" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Argyle Pointelle Cotton Sweater</div>
                                                <div class="options"><strong>40</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="referral">
                        <div block="" class="points-timeline__block collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion0null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/signup-points.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">100</span> Points earned from Order</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin">Hurray! +966 026693320 joined Tribe by Yo!Kart</div>
                            </div>
                        </div>
                        <div id="accordion0null" class="collapse" style="display: none;"></div>
                    </li>
                    <li class="earned">
                        <div block="" class="points-timeline__block dropdown-toggle collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10003null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/points-earned-for-product.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">260</span> Points earned from Order #10003</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin"></div>
                            </div>
                        </div>
                        <div id="accordion10003null" class="collapse" style="display: none;">
                            <ul class="points-list-group scroll-y">
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/44">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/44/44|11|/48-64?t=1617170797" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Houndstooth Skirt Pants</div>
                                                <div class="options"><strong>60</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/278">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/278/278|145|/48-64?t=1595828639" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Mon Paris Eau de Parfum Spray, 1.6-oz</div>
                                                <div class="options"><strong>200</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="earned">
                        <div block="" class="points-timeline__block dropdown-toggle collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10002null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/points-earned-for-product.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">710</span> Points earned from Order #10002</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin"></div>
                            </div>
                        </div>
                        <div id="accordion10002null" class="collapse" style="display: none;">
                            <ul class="points-list-group scroll-y">
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/56">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/56/56|11|210|/48-64?t=1616568130" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">V-Neck Chiffon-Trim Top</div>
                                                <div class="options"><strong>40</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/7">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/7/7|60|/48-64?t=1596005208" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">High-Rise Stretch Skinny Jean, in Regular &amp; Petite Sizes</div>
                                                <div class="options"><strong>100</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/304">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/304/0/48-64?t=1616574169" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">ALDO Pink Textured Sling Bag</div>
                                                <div class="options"><strong>40</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/311">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/311/311|262|/48-64?t=1616590984" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">Gen 5E Darci Pavé Gold-Tone Smartwatch</div>
                                                <div class="options"><strong>530</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="earned">
                        <div block="" class="points-timeline__block dropdown-toggle collapsed" role="button" tabindex="0" aria-expanded="false" aria-controls="accordion10001null" style="overflow-anchor: none;">
                            <div class="points-timeline__block_media"><img data-yk="" src="https://demo.tribe-ecommerce.com/dashboard/media/retina/points-earned-for-product.svg" alt=""></div>
                            <div class="points-timeline__block_data">
                                <div class="points-timeline__block_title"><span class="text-success">900</span> Points earned from Order #10001</div>
                                <div class="points-timeline__block_date">31-03-2021</div>
                                <div class="points-timeline__block_origin"></div>
                            </div>
                        </div>
                        <div id="accordion10001null" class="collapse" style="display: none;">
                            <ul class="points-list-group scroll-y">
                                <li class="points-list-group-item"><a target="_blank" href="https://demo.tribe-ecommerce.com/product/316">
                                        <div class="product-profile">
                                            <div class="product-profile__thumbnail"><img src="https://demo.tribe-ecommerce.com/yokart/product/image/316/316|75|/48-64?t=1616592931" data-yk="" alt=""></div>
                                            <div class="product-profile__data">
                                                <div class="title">X Closed Narrow Ring</div>
                                                <div class="options"><strong>900</strong>
                                                    points earned for
                                                </div>
                                            </div>
                                        </div>
                                    </a></li>
                            </ul>
                        </div>
                    </li>
                    <div data-v-644ea9c9="" class="infinite-loading-container">
                        <div data-v-644ea9c9="" class="infinite-status-prompt" style="color: rgb(102, 102, 102); font-size: 14px; padding: 10px 0px; display: none;"><i data-v-46b20d22="" data-v-644ea9c9="" class="loading-spiral"></i></div>
                        <div data-v-644ea9c9="" class="infinite-status-prompt" style="color: rgb(102, 102, 102); font-size: 14px; padding: 10px 0px; display: none;"></div>
                        <div data-v-644ea9c9="" class="infinite-status-prompt" style="color: rgb(102, 102, 102); font-size: 14px; padding: 10px 0px;"></div>
                        <div data-v-644ea9c9="" class="infinite-status-prompt" style="color: rgb(102, 102, 102); font-size: 14px; padding: 10px 0px; display: none;">
                            Opps, something went wrong :(
                            <br data-v-644ea9c9=""> <button data-v-644ea9c9="" class="btn-try-infinite">Retry</button>
                        </div>
                    </div>
                </ul>

            </div>
        </div>
    </div>
</div>