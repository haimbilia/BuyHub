<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$shippingInfo = isset($data['addr_name']) ? $data['addr_name'] . ', ' : '';
if (isset($data['addr_address1']) && $data['addr_address1'] != '') {
    $shippingInfo .= $data['addr_address1'] . ', ';
}

if (isset($data['addr_address2']) && $data['addr_address2'] != '') {
    $shippingInfo .= $data['addr_address2'] . ', ';
}

if (isset($data['addr_city']) && $data['addr_city'] != '') {
    $shippingInfo .= $data['addr_city'] . ', ';
}

if (isset($data['state_name']) && $data['state_name'] != '') {
    $shippingInfo .= $data['state_name'] . ', ';
}

if (isset($data['country_name']) &&  $data['country_name'] != '') {
    $shippingInfo .= $data['country_name'] . ', ';
}

if (isset($data['addr_zip']) &&  $data['addr_zip'] != '') {
    $shippingInfo .= Labels::getLabel('LBL_Zip:', $siteLangId) . $data['addr_zip'] . ', ';
}

if (isset($data['addr_phone']) &&  $data['addr_phone'] != '') {
    $shippingInfo .=  Labels::getLabel('LBL_Phone:', $siteLangId) . ValidateElement::formatDialCode($data['addr_phone_dcode']) . $data['addr_phone'];
}
$uploadedTime = AttachedFile::setTimeParam($data['selprod_updated_on']);
$prodUrl = UrlHelper::generateFullUrl('Products', 'view', array($data['selprod_id']), CONF_WEBROOT_FRONTEND);
$imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($data['selprod_product_id'], ImageDimension::VIEW_SMALL, $data['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

$str = '<table width="100%" cellspacing="0" cellpadding="20" border="0" style="font-size: 14px;background: #f2f2f2;font-family: Arial, sans-serif;">
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="text-align:left">
                        <tr>
                            <td style="background-color: #' . FatApp::getConfig('CONF_EMAIL_TEMPLATE_COLOR_CODE' . $siteLangId, FatUtility::VAR_STRING, 'ff3a59') . ';padding: 10px 25px;">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">                                                             
                                    <tr>
                                        <td style="font-size: 14px;font-weight: $font-weight-boldest;color: #fff;"></td>
                                        <td style="font-size: 14px;font-weight: $font-weight-boldest;color: #fff; text-align: right;">' . Labels::getLabel('LBL_REQUEST_DATE.', $siteLangId) . ' ' . FatDate::format($data['rfq_added_on']) . '</td>
                                    </tr>
                                </table>                                                          
                            </td>
                        </tr> 
                        <tr>
                            <td>
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #fff;padding: 10px 0;">
                                                <tr>
                                                    <td style="border-bottom:1px solid #ecf0f1;">
                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tr>
                                                                <td style="width: 70px; padding: 10px;">
                                                                    <a href=""' . $prodUrl . '""><img src="' . $imgSrc . '" alt="" title="" ' . HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_MINI) . ' /></a>
                                                                </td>
                                                                <td style="padding: 10px;">
                                                                    <a href="' . $prodUrl . '" style="color: #555555;font-size: 14px;font-weight: $font-weight-bold;text-decoration: none;">' . $data['rfq_title'] . '</a>
                                                                    <div style="color: #555555;font-size: 14px;font-weight: $font-weight-bold;">' . Labels::getLabel('Lbl_By', $siteLangId) . ':' . $data["shop_name"] . '</div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #f2f2f2;padding: 20px 25px;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_RFQ_NO') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . $data['rfq_number'] . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_REQUESTED_QTY') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . $data['rfq_quantity']  . ' ' . applicationConstants::getWeightUnitName($siteLangId, $data['rfq_quantity_unit'], true) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_EXPECTED_DELIVERY_DATE') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . FatDate::format($data['rfq_delivery_date']) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_DELIVERY_ADDRESS') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . $shippingInfo . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_COMMENTS') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . $data['rfq_description'] . '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';

echo $str;
