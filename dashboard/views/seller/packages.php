<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="section-head section-head-center my-4">
                    <div class="section__heading">
                        <?php echo html_entity_decode($pageData['epage_content']); ?>
                    </div>
                </div>
                <ul class="packages-box">
                    <?php
                    $packageArrClass = SellerPackages::getPackageClass();
                    $totalPackages = count($packagesArr);
                    if ($totalPackages > 0) {
                        $inc = 1;
                        foreach ($packagesArr as $package) {
                            $planIds = array_column($package['plans'], SellerPackagePlans::DB_TBL_PREFIX . 'id');
                            $selectedClass = '';
                            if (in_array($currentActivePlanId, $planIds)) {
                                $selectedClass = 'is-active';
                            } ?>
                            <li class="packages-box-item packagesBoxJs box <?php echo $packageArrClass[$inc] . " " . $selectedClass ?>">
                                <div class="packages-box-head">
                                    <div class="name"><?php echo $package['spackage_name']; ?>
                                        <span><?php echo $package['spackage_text']; ?></span>
                                    </div>
                                    <div class="valid">
                                        <?php echo SellerPackagePlans::getCheapPlanPriceWithPeriod($package['cheapPlan'], $package['cheapPlan'][SellerPackagePlans::DB_TBL_PREFIX . 'price']); ?>
                                    </div>
                                </div>
                                <div class="packages-box-body">
                                    <div class="trial">
                                        <ul class="features">
                                            <li class="features-item">
                                                <span><?php echo CommonHelper::displayComissionPercentage($package[SellerPackages::DB_TBL_PREFIX . 'commission_rate']); ?>%</span>
                                                <?php echo Labels::getLabel('LBL_Commision_rate', $siteLangId); ?>
                                            </li>
                                            <li class="features-item">
                                                <span><?php echo $package[SellerPackages::DB_TBL_PREFIX . 'products_allowed']; ?></span>
                                                <?php echo ($package[SellerPackages::DB_TBL_PREFIX . 'products_allowed'] == 1) ? Labels::getlabel('LBL_active_product', $siteLangId) : Labels::getlabel('LBL_active_products', $siteLangId); ?>
                                            </li>
                                            <li class="features-item">
                                                <span><?php echo $package[SellerPackages::DB_TBL_PREFIX . 'inventory_allowed']; ?></span>
                                                <?php echo  Labels::getlabel('LBL_Product_Inventory', $siteLangId) ?>
                                            </li>
                                            <li class="features-item">
                                                <span><?php echo $package[SellerPackages::DB_TBL_PREFIX . 'images_per_product']; ?></span>
                                                <?php echo ($package[SellerPackages::DB_TBL_PREFIX . 'images_per_product'] == 1) ? Labels::getlabel('LBL_image_per_product', $siteLangId) : Labels::getlabel('LBL_images_per_product', $siteLangId); ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php /* if($package[SellerPackages::DB_TBL_PREFIX.'free_trial_days']>0 && $includeFreeSubscription){
                                    ?>
                                <a class="btn btn-secondary ripplelink buyFreeSubscription"
                                    data-id="<?php echo $package[SellerPackages::DB_TBL_PREFIX.'id'];?>"
                                    href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Free_Trial',$siteLangId);?></a> <?php
                                } */ ?>
                                    <h3><?php echo sprintf(Labels::getLabel('Lbl_Select_Your_%s_Price', $siteLangId), $package['spackage_name']); ?>
                                    </h3>
                                    <ul class="price-list">
                                        <?php foreach ($package['plans'] as $plan) {
                                        ?>
                                            <li class="price-list-item">
                                                <label class="radio">
                                                    <input value="<?php echo $plan[SellerPackagePlans::DB_TBL_PREFIX . 'id']; ?>" name="packages" <?php if ($currentActivePlanId == $plan[SellerPackagePlans::DB_TBL_PREFIX . 'id']) {
                                                                                                                                                        echo 'checked=checked ';
                                                                                                                                                    } ?> type="radio">

                                                    <?php echo SellerPackagePlans::getPlanPriceWithPeriod($plan, $plan[SellerPackagePlans::DB_TBL_PREFIX . 'price']); ?></label>
                                            </li>
                                        <?php
                                        } ?>

                                    </ul>
                                </div>
                                <div class="packages-box-foot">
                                    <?php if ($currentActivePlanId) {
                                        $buyPlanText = Labels::getLabel('LBL_Change_Plan', $siteLangId);
                                    } else {
                                        $buyPlanText = Labels::getLabel('LBL_Buy_Plan', $siteLangId);
                                    } ?>
                                    <button type="button" data-id="<?php echo $package[SellerPackages::DB_TBL_PREFIX . 'id']; ?>" class="btn btn-brand btn-wide buySubscription--js "><?php echo $buyPlanText; ?>
                                    </button>

                                </div>





                            </li>
                    <?php

                            $inc++;
                        }
                        //						}
                    }      ?>
                </ul>

            </div>
        </div>
    </div>

    <script>
        var currentActivePlanId = <?php echo ($currentActivePlanId) ? $currentActivePlanId : 0; ?>
    </script>