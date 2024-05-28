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
                            <td width="90%"><?php echo $shippingInfo; ?></td>
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
        <tr>
            <td style="border-bottom: solid 1px #000; "><br>
                <strong style=" padding-bottom:10px; "><?php echo Labels::getLabel('LBL_SOLD_BY', $siteLangId); ?>: <?php echo $rfqData['shop_name']; ?></strong>
            </td>
        </tr>
        <tr>
            <td>
                <table class="tbl-border" width="100%" border="0" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="90%" style="padding:10px; ;text-align: left; border-bottom:1px solid #ddd; background-color:#ddd; "><?php echo Labels::getLabel('LBL_Item', $siteLangId); ?></th>
                            <th width="10%" style="padding:10px; ;text-align: left; border-bottom:1px solid #ddd; background-color:#ddd; "><?php echo Labels::getLabel('LBL_Qty', $siteLangId); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding:10px; ;text-align: left;"><?php echo $rfqData['rfq_title']; ?></td>
                            <td style="padding:10px; ;text-align: left;"><?php echo $rfqData['rfq_quantity']  . ' ' . applicationConstants::getWeightUnitName($siteLangId, $rfqData['rfq_quantity_unit'], true); ?></td>
                        </tr>
                        <tr>
                            <td style="padding:10px; ;text-align: left;font-weight:700;background-color: #ddd;" colspan="2"><?php echo Labels::getLabel('LBL_COMMENTS', $siteLangId) ?> </td>
                        </tr>
                        <tr>
                            <td style="padding:10px; ;text-align: left;" colspan="2"><?php echo $rfqData['rfq_description']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>