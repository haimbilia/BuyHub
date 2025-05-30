<div class="bg-brand-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 align-center">
                <div class="width--narrow">
                    <h2><?php echo Labels::getLabel('LBL_Batch_Details', $siteLangId); ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="panel clearfix">
        <div class="section clearfix">
            <div class="section-body">
                <div class="box box--white box--rounded">
                    <div class="box__head">
                        <h4><?php echo ($batch['prodgroup_name']) ? $batch['prodgroup_name'] : $batch['prodgroup_identifier']; ?>
                        </h4>
                        <span class="text--normal"><?php echo Labels::getLabel('LBL_Sold_By', $siteLangId); ?>: <a
                                href="<?php echo UrlHelper::generateUrl('Shops', 'view', array($batch['shop_id'])); ?>"><?php echo $batch['shop_name']; ?></a></span>
                    </div>
                    <div class="box__body">
                        <div class="wrap--repeated">
                            <?php if (!empty($batch)) { ?>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <ul class="slides--combo">
                                    <?php
                                        $productsTotalPrice = 0;
                                        $batchInStock = true;
                                        foreach ($pg_products as $product) {
                                            $productUrl = UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']));
                                            $imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_SMALL, $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
                                            $productsTotalPrice += $product['theprice'];
                                        ?>
                                    <li>
                                        <div class="items-group">
                                            <div
                                                class="item item--small item--hovered <?php echo (!$product['in_stock']) ? 'out-of-stock' : ''; ?>">
                                                <?php if (!$product['in_stock']) {
                                                            $batchInStock = false;
                                                        ?>
                                                <span
                                                    class="out-of-stock-txt"><?php echo Labels::getLabel('LBL_Sold_Out', $siteLangId); ?></span>
                                                <?php } ?>
                                                <figure class=" item__pic"> <a href="<?php echo $productUrl; ?>"><img
                                                            src="<?php echo $imgSrc; ?>"
                                                            alt="<?php echo $product['product_identifier']; ?>"></a>
                                                </figure>
                                                <!--<label class="checkbox"><input type="checkbox" checked> </label>-->
                                                <span class="title"><a title="<?php echo $product['selprod_title']; ?>"
                                                        href="<?php echo $productUrl; ?>"><?php echo ($product['selprod_title'] != '') ? $product['selprod_title'] : '&nbsp;'; ?></a></span>
                                                <span
                                                    class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="items-group">
                                    <div class="item__total">
                                        <h3><?php echo Labels::getLabel('LBL_Total_Price', $siteLangId); ?></h3>
                                        <span
                                            class="item__price"><?php echo CommonHelper::displayMoneyFormat($batch['prodgroup_price']); ?></span>
                                        <span
                                            class="item__price--old"><?php echo CommonHelper::displayMoneyFormat($productsTotalPrice); ?></span>
                                        <?php if ($batchInStock) { ?>
                                        <?php /* <a href="javascript:void(0)" onclick="cart.addGroup('<?php echo $batch['prodgroup_id']; ?>',true);"
                                        class="btn
                                        btn-secondary"><?php echo Labels::getLabel('LBL_Buy_Now', $siteLangId); ?></a>
                                        */ ?>
                                        <a href="javascript:void(0)"
                                            onclick="cart.addGroup('<?php echo $batch['prodgroup_id']; ?>');"
                                            class="btn btn-brand btn--h-large"><?php echo Labels::getLabel('LBL_Add_to_Cart', $siteLangId); ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } else {
                                echo Labels::getLabel('LBL_No_record_found!', $siteLangId);
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>