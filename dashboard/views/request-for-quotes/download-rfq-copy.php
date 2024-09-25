<?php defined('SYSTEM_INIT') or die('Invalid Usage . '); ?>
<style type="text/css">
    * {
        padding: 0;
        margin: 0;
    }

    body {
        margin: 0;
        padding: 0;
    }

    table {
        color: #000;
        font-size: 10px;
        line-height: 1.4;
        padding: 0;
        margin: 0;


    }

    table th,
    table td {
        padding: 15px;
    }

    table tbody {
        padding: 0;
        margin: 0;
    }

    table tr td {
        margin: 0;
    }

    .tbl-border {
        border: solid 1px #000;


    }

    .tbl-border td,
    .tbl-border th {
        border: solid 1px #ddd;
    }

    .padding10 {
        padding: 10px;
    }
</style>
<?php
$shippingInfo = isset($rfqData['addr_name']) ? $rfqData['addr_name'] . '<br>' : '';
if (isset($rfqData['addr_address1']) && $rfqData['addr_address1'] != '') {
    $shippingInfo .= $rfqData['addr_address1'] . ', ';
}

if (isset($rfqData['addr_address2']) && $rfqData['addr_address2'] != '') {
    $shippingInfo .= $rfqData['addr_address2'] . '<br>';
}

if (isset($rfqData['addr_city']) && $rfqData['addr_city'] != '') {
    $shippingInfo .= $rfqData['addr_city'] . ', ';
}

if (isset($rfqData['state_name']) && $rfqData['state_name'] != '') {
    $shippingInfo .= $rfqData['state_name'] . ', ';
}

if (isset($rfqData['country_name']) &&  $rfqData['country_name'] != '') {
    $shippingInfo .= $rfqData['country_name'] . ', ';
}

if (isset($rfqData['addr_zip']) &&  $rfqData['addr_zip'] != '') {
    $shippingInfo .= $rfqData['addr_zip'];
}

$isGlobal = (RequestForQuote::VISIBILITY_TYPE_OPEN == $rfqData['rfq_visibility_type']);
$productTypeArr = Product::getProductTypes($siteLangId);
$rfqQtyUnit = applicationConstants::getWeightUnitName($siteLangId, $rfqData['rfq_quantity_unit'], true);
?>
<table width="100%" border="0" cellpadding="10" cellspacing="0" class="tbl-border">
    <tbody>
        <tr>
            <td style="border-bottom: solid 1px #000; text-align:center; line-height:1.5; ">
                <strong style="padding:10px;display:block;font-size: 20px;"><?php echo Labels::getlabel('LBL_QUOTE_INFORMATION', $siteLangId); ?></strong>
            </td>
        </tr>
        <tr>
            <td style="border-top: solid 1px #000;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td><strong><?php echo Labels::getLabel('LBL_RFQ_NO', $siteLangId); ?>:</strong> <?php echo $rfqData['rfq_number']; ?></td>
                            <td><strong><?php echo Labels::getLabel('LBL_REQUESTED_ON', $siteLangId); ?>:</strong> <?php echo FatDate::format($rfqData['rfq_added_on']); ?><?php if (0 < strtotime($rfqData['rfq_delivery_date'])) { ?><br><strong><?php echo Labels::getLabel('LBL_EXPECTED_DELIVERY_DATE', $siteLangId); ?>:</strong> <?php echo FatDate::format($rfqData['rfq_delivery_date']); ?><?php } ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td width="10%"><strong><?php echo Labels::getLabel('LBL_SHIP_TO', $siteLangId); ?>:</strong></td>
                            <td width="40%"><?php echo $shippingInfo; ?></td>
                        </tr>
                        <?php if (isset($rfqData['addr_phone']) &&  $rfqData['addr_phone'] != '') { ?>
                            <tr>
                                <td width="10%"><strong><?php echo Labels::getLabel('LBL_PHONE', $siteLangId); ?>:</strong></td>
                                <td width="90%"><?php echo ValidateElement::formatDialCode($rfqData['addr_phone_dcode']) . $rfqData['addr_phone']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </td>
        </tr>
        <?php if (false == $isGlobal) { ?>
            <tr>
                <td style="border-bottom: solid 1px #000; "><br>
                    <strong style=" padding-bottom:10px; "><?php echo Labels::getLabel('LBL_SOLD_BY', $siteLangId); ?>: <?php echo $rfqData['shop_name']; ?></strong>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td>
                <table class="tbl-border" width="100%" border="0" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="<?php echo $isGlobal ? '50%' : '90%'; ?>" style="padding:10px; ;text-align: left; border-bottom:1px solid #ddd; background-color:#ddd; "><?php echo Labels::getLabel('LBL_ITEM', $siteLangId); ?></th>
                            <?php if ($isGlobal) { ?>
                                <th width="20%" style="padding:10px; ;text-align: left; border-bottom:1px solid #ddd; background-color:#ddd; "><?php echo Labels::getLabel('LBL_PRODUCT_TYPE', $siteLangId); ?></th>
                                <th width="20%" style="padding:10px; ;text-align: left; border-bottom:1px solid #ddd; background-color:#ddd; "><?php echo Labels::getLabel('LBL_CATEGORY', $siteLangId); ?></th>
                            <?php } ?>
                            <th width="10%" style="padding:10px; ;text-align: left; border-bottom:1px solid #ddd; background-color:#ddd; "><?php echo Labels::getLabel('LBL_Qty', $siteLangId); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding:10px; ;text-align: left;"><?php echo $rfqData['rfq_title']; ?></td>
                            <?php if ($isGlobal) { ?>
                                <td style="padding:10px; ;text-align: left;"><?php echo $productTypeArr[$rfqData['rfq_product_type']]; ?></td>
                                <td style="padding:10px; ;text-align: left;">
                                    <?php echo !empty($rfqData['prodcat_name']) ? $rfqData['prodcat_name'] : Labels::getLabel('LBL_N/A', $siteLangId); ?>
                                </td>
                            <?php } ?>
                            <td style="padding:10px; ;text-align: left;"><?php echo $rfqData['rfq_quantity']  . ' ' . $rfqQtyUnit; ?></td>
                        </tr>
                        <tr>
                            <td style="padding:10px; ;text-align: left;font-weight:700;background-color: #ddd;" colspan="<?php echo ($isGlobal) ? 4 : 2; ?>"><?php echo Labels::getLabel('LBL_COMMENTS', $siteLangId) ?> </td>
                        </tr>
                        <tr>
                            <td style="padding:10px; ;text-align: left;" colspan="<?php echo ($isGlobal) ? 4 : 2; ?>"><?php echo $rfqData['rfq_description']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<?php if (!empty($acceptedOffers)) { ?>
    <table width="100%" border="0" cellpadding="10" cellspacing="0" class="tbl-border">
        <tbody>
            <tr>
                <td style="border-bottom: solid px #000; text-align:center; line-height:1.5; ">
                    <strong style="padding:10px;display:block;font-size: 20px;"><?php echo Labels::getlabel('LBL_ACCEPTED_OFFERS', $siteLangId); ?></strong>
                </td>
            </tr>
            <?php foreach ($acceptedOffers as $offer) { ?>
                <tr>
                    <td style="border-top: solid 1px #000;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td><strong><?php echo Labels::getLabel('LBL_SOLD_BY', $siteLangId); ?>:</strong> <?php echo $offer['shop_name']; ?></td>
                                    <td><strong><?php echo Labels::getLabel('LBL_EMAIL', $siteLangId); ?>:</strong> <?php echo $offer['seller_email']; ?></td>
                                    <?php if (!empty($offer['seller_phone_dcode']) && !empty($offer['seller_phone'])) { ?>
                                        <td>
                                            <strong><?php echo Labels::getLabel('LBL_PHONE', $siteLangId); ?>:</strong>
                                            <?php echo ValidateElement::formatDialCode($offer['seller_phone_dcode']) . $offer['seller_phone']; ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="tbl-border" width="100%" border="0" cellpadding="10" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="padding:10px; ;text-align: left; border-bottom:1px solid #ddd; background-color:#ddd; "><?php echo Labels::getLabel('LBL_OFFER_QUANTITY', $siteLangId); ?></th>
                                    <?php if (0 < $offer['rlo_shipping_charges']) { ?>
                                        <th style="padding:10px; ;text-align: left; border-bottom:1px solid #ddd; background-color:#ddd; "><?php echo Labels::getLabel('LBL_SHIPPING_RATE', $siteLangId); ?></th>
                                    <?php } ?>
                                    <th style="padding:10px; ;text-align: left; border-bottom:1px solid #ddd; background-color:#ddd; "><?php echo Labels::getLabel('LBL_OFFER_PRICE', $siteLangId); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding:10px; ;text-align: left;"><?php echo $offer['offer_quantity']  . ' ' . $rfqQtyUnit; ?></td>
                                    <?php if (0 < $offer['rlo_shipping_charges']) { ?>
                                        <td style="padding:10px; ;text-align: left;"><?php echo CommonHelper::displayMoneyFormat($offer['rlo_shipping_charges']); ?></td>
                                    <?php } ?>
                                    <td style="padding:10px; ;text-align: left;"><?php
                                                                                    $str = Labels::getLabel('LBL_{PRICE}_{UNIT}', $siteLangId);
                                                                                    echo CommonHelper::replaceStringData($str, [
                                                                                        '{PRICE}' => CommonHelper::displayMoneyFormat($offer['offer_price']),
                                                                                        '{UNIT}' => '<span class="per-unit">/ ' . $rfqQtyUnit . '</span>',
                                                                                    ]); ?></td>
                                </tr>
                                <?php if (!empty($offer['offer_comments'])) { ?>
                                    <tr>
                                        <td style="padding:10px; ;text-align: left;font-weight:700;background-color: #ddd;" colspan="<?php echo (0 < $offer['rlo_shipping_charges']) ? 3 : 2; ?>"><?php echo Labels::getLabel('LBL_COMMENTS', $siteLangId) ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px; ;text-align: left;" colspan="<?php echo (0 < $offer['rlo_shipping_charges']) ? 3 : 2; ?>"><?php echo $offer['offer_comments']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>