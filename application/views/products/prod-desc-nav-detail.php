<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$youtube_embed_code = UrlHelper::parseYoutubeUrl($product["product_youtube_video"]);
?>



<?php if (Product::PRODUCT_TYPE_DIGITAL == $product['product_type'] && (0 < count($product['preview_attachments']) || 0 < count($product['preview_links']))) { ?>
    <?php $this->includeTemplate('_partial/product/dd-preview-list.php', array('siteLangId' => $siteLangId, 'product' => $product), false); ?>
<?php } ?>
<?php if (count($productSpecifications) > 0) { ?>
    <div class="detail-content">
        <h2 class="h2"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?></h2>
        <div class="">
            <ul class="list-specification">
                <?php foreach ($productSpecifications as $key => $specification) { ?>
                    <li class="list-specification-item">
                        <span class="label"><?php echo $specification['prodspec_name'] . ":"; ?></span>
                        <span class="value"><?php echo html_entity_decode($specification['prodspec_value'], ENT_QUOTES, 'utf-8'); ?>
                        </span>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
<?php if (trim($product['product_description']) != '') { ?>
    <div class="detail-content">
        <h2 class="h2"><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?></h2>
        <div class="cms">
            <p><?php echo CommonHelper::renderHtml($product['product_description']); ?></p>
        </div>
    </div>
<?php } ?>
<?php if ($youtube_embed_code) { ?>
    <div class="detail-content">
        <h2 class="h2"><?php echo Labels::getLabel('LBL_Video', $siteLangId); ?></h2>
        <?php if ($youtube_embed_code != "") { ?>
            <div class="mb-4 video-wrapper">
                <iframe width="100%" height="315" src="//www.youtube.com/embed/<?php echo $youtube_embed_code ?>" allowfullscreen></iframe>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<?php if ($shop['shop_payment_policy'] != '' || !empty($shop["shop_delivery_policy"] != "") || !empty($shop["shop_delivery_policy"] != "")) { ?>
    <div class="detail-content">
        <h2 class="h2"><?php echo Labels::getLabel('LBL_Shop_Policies', $siteLangId); ?></h2>
        <div class="cms">
            <?php if ($shop['shop_payment_policy'] != '') { ?>
                <h6><?php echo Labels::getLabel('LBL_Payment_Policy', $siteLangId) ?></h6>
                <p><?php echo nl2br($shop['shop_payment_policy']); ?></p>
                <br>
            <?php } ?>
            <?php if ($shop['shop_delivery_policy'] != '') { ?>
                <h6><?php echo Labels::getLabel('LBL_Delivery_Policy', $siteLangId) ?></h6>
                <p><?php echo nl2br($shop['shop_delivery_policy']); ?></p>
                <br>
            <?php } ?>
            <?php if ($shop['shop_refund_policy'] != '') { ?>
                <h6><?php echo Labels::getLabel('LBL_Refund_Policy', $siteLangId) ?></h6>
                <p><?php echo nl2br($shop['shop_refund_policy']); ?></p>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<?php if (!empty($product['selprodComments'])) { ?>
    <div class="detail-content">
        <h2 class="h2"><?php echo Labels::getLabel('LBL_Extra_comments', $siteLangId); ?></h2>
        <div class="cms">
            <p>
                <?php echo CommonHelper::displayNotApplicable($siteLangId, nl2br($product['selprodComments'])); ?>
            </p>
        </div>
    </div>
<?php } ?>