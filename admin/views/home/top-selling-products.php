<table width="100%" class="table">
    <thead>
        <tr>
            <th><?php echo Labels::getLabel('LBL_IMAGE', $siteLangId); ?> </th>
            <th width="60%"><?php echo Labels::getLabel('LBL_NAME', $siteLangId); ?> </th>
            <th><?php echo Labels::getLabel('LBL_QTY', $siteLangId); ?> </th>
            <th><?php echo Labels::getLabel('LBL_SELLER', $siteLangId); ?> </th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($productsList) > 0) {
            foreach ($productsList as $product) { ?>
                <tr>
                    <td>
                        <div class="media-group">
                            <a href="#" class="media media-sm media-circle" data-bs-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="<?php echo $product['op_selprod_title']; ?>">
                                <img data-aspect-ratio="1:1" src="<?php echo UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . '?t=' . time(); ?>" alt="image">
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="user-profile">
                            <div class="user-profile_data">
                                <span class="user-profile_title" href="javascript::void(0)"><?php echo $product['product_name']; ?></span>
                                <span class="text-muted"><?php echo $product['op_selprod_title']; ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="stock"><?php echo $product['totSoldQty']; ?> </p>
                    </td>
                    <td>
                        <div class="user">
                            <a href="javascript::void(0)" onClick="redirectToShop(<?php echo $product['shop_id']; ?>)" class="link-text text-nowrap"><?php echo $product['op_shop_name']; ?></a>
                        </div>
                    </td>

                </tr>
        <?php }
        } ?>
    </tbody>
</table>