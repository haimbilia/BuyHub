<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <div class="content-body">
        <div class="">
            <div class="">
                <?php if (!empty($pageData)) { ?>
                    <div class="section-head section-head-center my-4">
                        <div class="section-heading">
                            <?php echo html_entity_decode($pageData['epage_content']); ?>
                        </div>
                    </div>
                <?php
                }
                if (1 > $currentActivePlanId && $parentUserId != UserAuthentication::getLoggedUserId()) {
                    echo HtmlHelper::getErrorMessageHtml(Labels::getLabel('ERR_PARENT_MERCHANT_MUST_NEED_TO_BUY_A_VALID_SUBSCRIPTION.', $siteLangId));
                }
                ?>
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
                                    <div class="name">
                                        <?php echo $package['spackage_name']; ?>
                                        <span><?php echo $package['spackage_text']; ?></span>
                                    </div>
                                    <div class="valid">
                                        <?php
                                        if (in_array($currentActivePlanId, $planIds)) {
                                            echo SellerPackagePlans::getCheapPlanPriceWithPeriod($currentPlanData, $currentPlanData[SellerPackagePlans::DB_TBL_PREFIX . 'price']);
                                        } else {
                                            echo SellerPackagePlans::getCheapPlanPriceWithPeriod($package['cheapPlan'], $package['cheapPlan'][SellerPackagePlans::DB_TBL_PREFIX . 'price']);
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="packages-box-body">
                                    <div class="trial">
                                        <ul class="features p-0">
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
                                            <li class="features-item">
                                                <span><?php echo CommonHelper::replaceStringData(Labels::getLabel('LBL_{LIMIT}_RFQ_OFFERS', $siteLangId), ['{LIMIT}' => $package[SellerPackages::DB_TBL_PREFIX . 'rfq_offers_allowed']]); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php if (UserAuthentication::getLoggedUserId(true) == $parentUserId) { ?>
                                    <div class="packages-box-foot">
                                        <p>
                                            <?php
                                            echo CommonHelper::replaceStringData(Labels::getLabel('LBL_SELECT_YOUR_{PACKAGE-NAME}_PRICE', $siteLangId), ['{PACKAGE-NAME}' => $package['spackage_name']]);
                                            ?>
                                        </p>
                                        <?php $disabled = ($parentUserId != UserAuthentication::getLoggedUserId(true)) ? 'disabled=disabled' : ''; ?>
                                        <select name="packages" class="form-select packagesJS" <?php echo $disabled; ?>>
                                            <?php foreach ($package['plans'] as $plan) {
                                                $isActive = ($currentActivePlanId == $plan[SellerPackagePlans::DB_TBL_PREFIX . 'id']) ? 'selected=selected' : '';
                                            ?>
                                                <option value="<?php echo $plan[SellerPackagePlans::DB_TBL_PREFIX . 'id']; ?>" <?php echo $isActive; ?>>
                                                    <?php echo SellerPackagePlans::getPlanPriceWithPeriod($plan, $plan[SellerPackagePlans::DB_TBL_PREFIX . 'price']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                        <?php if ($currentActivePlanId) {
                                            $buyPlanText = Labels::getLabel('LBL_Change_Plan', $siteLangId);
                                        } else {
                                            $buyPlanText = Labels::getLabel('LBL_Buy_Plan', $siteLangId);
                                        } ?>
                                        <button class="btn btn-brand btn-block buySubscription--js " type="button" data-id="<?php echo $package[SellerPackages::DB_TBL_PREFIX . 'id']; ?>"><?php echo $buyPlanText; ?>
                                        </button>
                                    </div>
                                <?php } ?>
                            </li>
                    <?php
                            $inc++;
                        }
                    }      ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    var currentActivePlanId = <?php echo ($currentActivePlanId) ? $currentActivePlanId : 0; ?>
</script>