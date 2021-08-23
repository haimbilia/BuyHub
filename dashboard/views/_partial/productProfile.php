<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

if (isset($order)) {
    if ($order['op_is_batch']) {
        $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'BatchProduct', array($order['op_selprod_id'], $siteLangId, "SMALL"), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
    } else {
        $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($order['selprod_product_id'], "SMALL", $order['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
    }
    ?>
    <div class="item">
        <figure class="item__pic">
            <img src="<?php echo $imgUrl ?>" title="<?php echo $product['product_name']; ?>" alt="<?php echo $order['op_product_name']; ?>">
        </figure>
        <div class="item__description">
            <div class="item__title">
    <?php echo wordwrap($order['op_product_name'], 150, "<br>\n"); ?>
            </div>
                <?php if (!empty($order['op_selprod_title'])) { ?>  
                <div class="item__sub_title">
                <?php echo wordwrap($order['op_selprod_title'], 150, "<br>\n"); ?>
                </div>    
                <?php } ?>
            <?php if (!empty($order['op_brand_name'])) { ?>  
                <div class="item__sub_title">
                <?php echo Labels::getLabel('LBL_Brand', $siteLangId) . ': ' . $order['op_brand_name']; ?>
                </div>    
                <?php } ?>
            <?php if (!empty($order['op_selprod_options'])) {
                ?>  
                <div class="item__options">
                <?php
                echo $order['op_selprod_options']
                ?>
                </div>    
                <?php } ?>   
        </div>
    </div>
<?php
} else {
  
    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
    ?>
    <div class="item">
        <figure class="item__pic">
            <img src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['selprod_product_id'], "SMALL", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') ?>" title="<?php echo $product['product_name']; ?>" alt="<?php echo$product['product_name']; ?>">
        </figure>
        <div class="item__description">
            <div class="item__title prodNameJs">
                <?php echo wordwrap($product['product_name'], 150, "<br>\n"); ?>
            </div>
            <?php if (!empty($product['selprod_title'])) { ?>  
                <div class="item__sub_title prodNameJs">
                    <?php echo wordwrap($product['selprod_title'], 150, "<br>\n"); ?>
                </div>    
            <?php } ?>
            <?php if (is_array($product['options']) && count($product['options'])) {
                ?>  
                <div class="item__options prodOptionsJs">
                    <?php
                    $count = count($product['options']);
                    foreach ($product['options'] as $op) {
                        echo $op['option_name'] . ': ' . wordwrap($op['optionvalue_name'], 150, "<br>\n");
                        if ($count != 1) {
                            echo ' | ';
                        }
                        $count--;
                    }
                    ?>
                </div>    
            <?php } ?>   
        </div>
    </div>
<?php } ?>


