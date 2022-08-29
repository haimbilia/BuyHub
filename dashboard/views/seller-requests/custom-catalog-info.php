<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_Requested_product_info', $siteLangId); ?>
    </h5>
</div>
<main class="mainJs">
    <div class="modal-body form-edit pd-0">
        <div class="form-edit-body loaderContainerJs">
            <form class="form pd-0">
                <h3 class="h3 mb-3"><?php echo Labels::getLabel('LBL_Product_Information', $siteLangId); ?></h3>
                <img src="<?php echo UrlHelper::generateFileUrl('Image', 'customProduct', array($product['preq_id'], ImageDimension::VIEW_EXTRA_SMALL, 0, 0, $siteLangId), CONF_WEBROOT_FRONTEND) ?>" />
                <div class="my-4"></div>
                <ul class="list-stats list-stats-double">
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_Product_name', $siteLangId); ?></span>
                        <span class="value"><?php echo $product['product_name']; ?></span>

                    </li>
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_Category', $siteLangId); ?></span>
                        <span class="value"><?php echo $product['prodcat_name']; ?></span>

                    </li>
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_Brand', $siteLangId); ?></span>
                        <span class="value"><?php echo ($product['brand_name']) ? $product['brand_name'] : Labels::getLabel('LBL_N/A', $siteLangId); ?></span>

                    </li>
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_Product_Model', $siteLangId); ?></span>
                        <span class="value"><?php echo $product['product_model']; ?></span>

                    </li>
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_Minimum_Selling_Price', $siteLangId); ?></span>
                        <span class="value"><?php echo CommonHelper::displayMoneyFormat($product['product_min_selling_price']); ?></span>
                    </li>
                    <?php $saleTaxArr = Tax::getSaleTaxCatArr($siteLangId);
                    if (array_key_exists($product['ptt_taxcat_id'], $saleTaxArr)) { ?>
                        <li class="list-stats-item">

                            <span class="lable"><?php echo Labels::getLabel('LBL_Tax_Category', $siteLangId); ?></span>
                            <span class="value"><?php echo $saleTaxArr[$product['ptt_taxcat_id']]; ?></span>

                        </li>
                    <?php } ?>
                </ul>
                <?php if (!empty($product['preq_comment'])) { ?>
                    <div class="separator separator-dashed my-4"></div>
                    <h3 class="h3 mb-3"><?php echo Labels::getLabel('LBL_Comments', $siteLangId); ?></h3>
                    <ul class="list-stats list-stats-double">
                        <li class="list-stats-item list-stats-item-full">
                            <span class="lable"><?php echo $product['preq_comment']; ?></span>
                        </li>
                    </ul>
                <?php } ?>
            </form>
        </div>
    </div>
</main>