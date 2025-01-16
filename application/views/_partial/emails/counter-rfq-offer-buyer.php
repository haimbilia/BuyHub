<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$prodUrl = 'javascript:void(0)';
$productId = 0;
$selProdId = 0;
$uploadedTime = '';
$shopName = '';
if (isset($data['selprod_id']) && 0 < $data['selprod_id']) {
    $uploadedTime = AttachedFile::setTimeParam($data['selprod_updated_on']);
    $prodUrl = UrlHelper::generateFullUrl('Products', 'view', array($data['selprod_id']), CONF_WEBROOT_FRONTEND);
    $productId = $data['selprod_product_id'];
    $selProdId = $data['selprod_id'];
    $shopName = $data["shop_name"];
}
$imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($productId, ImageDimension::VIEW_SMALL, $selProdId, 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

$visibility = $data['rfq_visibility_type'] ?? RequestForQuote::VISIBILITY_TYPE_CLOSED;
$isGlobal = (RequestForQuote::VISIBILITY_TYPE_OPEN == $visibility);

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
                                                            <tr>';
                                                            if (!$isGlobal) {
                                                                $str .= '<td style="width: 70px; padding: 10px;">
                                                                        <a href=""' . $prodUrl . '""><img src="' . $imgSrc . '" ' . HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_MINI) . ' /></a>
                                                                    </td>';
                                                            }
                                                                $str .= '<td style="padding: 10px;">
                                                                    <a href="' . $prodUrl . '" style="color: #555555;font-size: 14px;font-weight: $font-weight-bold;text-decoration: none;">' . $data['rfq_title'] . '</a>';

                                                                    if (RequestForQuote::TYPE_INDIVIDUAL == FatApp::getConfig('CONF_RFQ_MODULE_TYPE', FatUtility::VAR_INT, 0) && false == $isGlobal && !empty($shopName)) {
                                                                        $str .= '<div style="color: #555555;font-size: 14px;font-weight: $font-weight-bold;">' . Labels::getLabel('Lbl_By', $siteLangId) . ':' . $shopName . '</div>';
                                                                    }
                                                        $str .= '</td>
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
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_OFFERED_QTY') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . $data['offer_quantity'] . ' ' . applicationConstants::getWeightUnitName($siteLangId, $data['rfq_quantity_unit'], true) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_OFFERED_PRICE_PER_' . applicationConstants::getWeightUnitName($siteLangId, $data['rfq_quantity_unit'])) . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . CommonHelper::displayMoneyFormat($data['offer_price']) . '</td>
                                    </tr>

                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_COMMENTS') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . $data['offer_comments'] . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_OFFERED_ON') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . FatDate::format($data['offer_added_on']) . '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #f2f2f2;padding: 20px 25px;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_REQUESTED_QTY') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . $data['counter_offer_quantity'] . ' ' . applicationConstants::getWeightUnitName($siteLangId, $data['rfq_quantity_unit'], true) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_REQUESTED_PRICE_PER_' . applicationConstants::getWeightUnitName($siteLangId, $data['rfq_quantity_unit'])) . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . CommonHelper::displayMoneyFormat($data['counter_offer_price']) . '</td>
                                    </tr>

                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_COMMENTS') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . $data['counter_offer_comments'] . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_REQUESTED_ON') . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . FatDate::format($data['counter_offer_added_on']) . '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';

echo $str;