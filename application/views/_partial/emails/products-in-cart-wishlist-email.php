<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$productHtml = '<table width="100%" cellspacing="0" cellpadding="0" style="background: #f6f6f6; padding: 10px 20px; border-radius: 4px">';
$abandonedCartIds = array();
foreach ($products as $key => $data) {
    $prodImage = UrlHelper::generateFullUrl('image', 'product', array($data['selprod_product_id'], ImageDimension::VIEW_MINI, $data['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND);
    $productHtml .= '<tr>
                        <td style="vertical-align: middle; width: 70px; padding: 15px 0; border-bottom: 1px solid #e2e2e2">
                            <a href="javascript:void(0);" style="width: 50px; height: 50px; background: #ffffff; display: block; border: 1px solid rgba(112, 112, 112, 0.2)">
                            <img src="' . $prodImage . '"  ' . HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_THUMB) .' alt="product-image" /></a>
                        </td>
                        <td style="text-align:left;vertical-align: middle; padding: 15px 0; border-bottom: 1px solid #e2e2e2">
                            <a href="javascript:void(0);" style="color: #212529; font-size: 14px; line-height: 24px; letter-spacing: -0.2px; text-decoration: none">' . $data['selprod_title'] . '</a>
                        </td>
                        <td style="font-size: 14px;line-height: 24px;letter-spacing: -0.2px;color: #212529;text-align: right;vertical-align: middle;padding: 15px 0;border-bottom: 1px solid #e2e2e2;">
                            ' . CommonHelper::displayMoneyFormat($data['selprod_price']) . '
                        </td>
                    </tr>';
}
$productHtml .= '</table>';
echo $productHtml;
