<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>

<div id="body" class="body template-<?php echo $template_id; ?>">
    <?php
    $this->includeTemplate('shops/_breadcrumb.php');
    $userParentId = (isset($userParentId)) ? $userParentId : 0;
    $variables = array('shop' => $shop, 'siteLangId' => $siteLangId, 'frmProductSearch' => $frmProductSearch, 'template_id' => $template_id, 'action' => $action, 'shopTotalReviews' => $shopTotalReviews, 'shopRating' => $shopRating, 'socialPlatforms' => $socialPlatforms, 'userParentId' => $userParentId);
    $this->includeTemplate('shops/templates/' . $template_id . '.php', $variables, false);

    $description = isset($shop['description']) && !empty(array_filter((array) $shop['description'])) ? $shop['description'] : [];
    $paymentPolicy = isset($shop['shop_payment_policy']) && !empty(array_filter((array) $shop['shop_payment_policy'])) ? $shop['shop_payment_policy'] : [];
    $deliveryPolicy = isset($shop['shop_delivery_policy']) && !empty(array_filter((array) $shop['shop_delivery_policy'])) ? $shop['shop_delivery_policy'] : [];
    $refundPolicy = isset($shop['shop_refund_policy']) && !empty(array_filter((array) $shop['shop_refund_policy'])) ? $shop['shop_refund_policy'] : [];
    $additionalInfo = isset($shop['shop_additional_info']) && !empty(array_filter((array) $shop['shop_additional_info'])) ? $shop['shop_additional_info'] : [];
    $sellerInfo = isset($shop['shop_seller_info']) && !empty(array_filter((array) $shop['shop_seller_info'])) ? $shop['shop_seller_info'] : [];
    ?>
    <?php if (!empty($description) || !empty($paymentPolicy) || !empty($deliveryPolicy) || !empty($refundPolicy) || !empty($additionalInfo) || !empty($sellerInfo)) { ?>
        <section class="section" data-section="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <?php if (!empty($description)) { ?>
                            <div class="cms">
                                <h4><?php echo $description['title']; ?></h4>
                                <p><?php echo !empty($description['description']) ? nl2br($description['description']) : ''; ?>
                                </p>
                            </div>
                        <?php } ?>
                        <div class="gap"></div>
                        <?php if (!empty($paymentPolicy)) { ?>
                            <div class="cms">
                                <h4><?php echo $paymentPolicy['title']; ?></h4>
                                <p><?php echo !empty($paymentPolicy['description']) ? nl2br($paymentPolicy['description']) : ''; ?>
                                </p>
                            </div>
                        <?php } ?>
                        <div class="gap"></div>

                        <?php if (!empty($deliveryPolicy)) { ?>
                            <div class="cms">
                                <h4><?php echo $deliveryPolicy['title']; ?></h4>
                                <p> <?php echo !empty($deliveryPolicy['description']) ? nl2br($deliveryPolicy['description']) : ''; ?>
                                </p>
                            </div>
                        <?php } ?>

                        <?php if (!empty($refundPolicy)) { ?>
                            <div class="cms">
                                <h4> <?php echo $refundPolicy['title']; ?></h4>
                                <p> <?php echo !empty($refundPolicy['description']) ? nl2br($refundPolicy['description']) : ''; ?>
                                </p>
                            </div>
                        <?php } ?>

                        <?php if (!empty($additionalInfo)) { ?>
                            <div class="cms">
                                <h4> <?php echo $additionalInfo['title']; ?></h4>
                                <p> <?php echo !empty($additionalInfo['description']) ? nl2br($additionalInfo['description']) : ''; ?>
                                </p>
                            </div>
                        <?php } ?>

                        <?php if (!empty($sellerInfo)) { ?>
                            <div class="cms">
                                <h4> <?php echo $sellerInfo['title']; ?></h4>
                                <p> <?php echo !empty($sellerInfo['description']) ? nl2br($sellerInfo['description']) : ''; ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } else {
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => Labels::getLabel('LBL_NO_POLICY/SHOP_DETAIL_FOUND')), false);
    } ?>
    <div class="gap"></div>
</div>
<?php echo $this->includeTemplate('_partial/shareThisScript.php'); ?>