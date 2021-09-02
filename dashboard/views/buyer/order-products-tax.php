<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_TAX_DETAIL', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body">
    <table class="table table-justified">
        <thead>
            <tr>
                <th>#</td>
                <th><?php echo Labels::getLabel('LBL_Product', $siteLangId); ?></th>
                <th><?php echo Labels::getLabel('LBL_TAX_AMOUNT', $siteLangId); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $k = 1;
            $totalTax = 0;
            foreach ($opsShippingDetail as $op) {
                $taxCost = CommonHelper::orderProductAmount($op, 'TAX');
                $totalTax += $taxCost;
                $opId = FatUtility::int($op['op_id']);
                $prodOrBatchUrl = 'javascript:void(0)';
                if ($op['op_is_batch']) {
                    $prodOrBatchUrl = UrlHelper::generateUrl('Products', 'batch', array($op['op_selprod_id']), CONF_WEBROOT_FRONTEND);
                    $prodOrBatchImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'BatchProduct', array($op['op_selprod_id'], $siteLangId, "SMALL"), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                } else {
                    if (Product::verifyProductIsValid($op['op_selprod_id']) == true) {
                        $prodOrBatchUrl = UrlHelper::generateUrl('Products', 'view', array($op['op_selprod_id']), CONF_WEBROOT_FRONTEND);
                    }
                    $prodOrBatchImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($op['selprod_product_id'], "SMALL", $op['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                }
            ?>
                <tr>
                    <td><?php echo $k; ?></td>
                    <td>
                        <div class="item">
                            <figure class="item__pic">
                                <a href="<?php echo $prodOrBatchUrl; ?>">
                                    <img src="<?php echo $prodOrBatchImgUrl; ?>" title="<?php echo $op['op_product_name']; ?>" alt="<?php echo $op['op_product_name']; ?>">
                                </a>
                            </figure>
                            <div class="item__description">
                                <?php if ($op['op_selprod_title'] != '') { ?>
                                    <div class="item__title">
                                        <a title="<?php echo $op['op_selprod_title']; ?>" href="<?php echo $prodOrBatchUrl; ?>">
                                            <?php echo $op['op_selprod_title'] . '<br>'; ?>
                                        </a>
                                    </div>
                                    <div class="item__category">
                                        <?php echo $op['op_product_name']; ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="item__category">
                                        <a title="<?php echo $op['op_product_name']; ?>" href="<?php echo UrlHelper::generateUrl('Products', 'view', array($op['op_selprod_id']), CONF_WEBROOT_FRONTEND); ?>">
                                            <?php echo $op['op_product_name']; ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="item__brand">
                                    <?php echo Labels::getLabel('Lbl_Brand', $siteLangId) ?>:
                                    <?php echo CommonHelper::displayNotApplicable($siteLangId, $op['op_brand_name']); ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php echo CommonHelper::displayMoneyFormat($taxCost, true, true); ?>
                    </td>
                </tr>
            <?php $k++;
            } ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td><?php echo Labels::getLabel('LBL_TOTAL_TAX', $siteLangId); ?></td>
                <td><?php echo CommonHelper::displayMoneyFormat($totalTax, true, true); ?></td>
            </tr>
        </tfoot>
    </table>
</div>