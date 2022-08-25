<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$prodImage = UrlHelper::generateFullUrl('image', 'product', array($data['selprod_product_id'], ImageDimension::VIEW_MINI, $data['selprod_id'], 0, $langId), CONF_WEBROOT_FRONTEND);
?>
<tr>
    <td style="vertical-align: middle; width: 70px; padding: 15px 0; border-bottom: 1px solid #e2e2e2">
        <a href="javascript:void(0);" style="width: 50px; height: 50px; background: #ffffff; display: block; border: 1px solid rgba(112, 112, 112, 0.2)">
        <img src="<?php echo $prodImage; ?>"  <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_THUMB);?> alt="product-image" /></a>
    </td>
    <td style="vertical-align: middle; padding: 15px 0; border-bottom: 1px solid #e2e2e2">
        <a href="javascript:void(0);" style="color: #212529; font-size: 14px; line-height: 24px; letter-spacing: -0.2px; text-decoration: none"><?php echo $data['selprod_title'];?> X <?php echo $data['abandonedcart_qty'];?></a>
    </td>
    <td style="font-size: 14px;line-height: 24px;letter-spacing: -0.2px;color: #212529;text-align: right;vertical-align: middle;padding: 15px 0;border-bottom: 1px solid #e2e2e2;">
        <?php echo CommonHelper::displayMoneyFormat($data['selprod_price'] * $data['abandonedcart_qty']);?>
    </td>
</tr>
