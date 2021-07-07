<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$title = $optionData['inv_option_name'];
$index = $optionData['inv_option_index'];
$optionId = $optionData['inv_option_id'];

$costFieldName = 'selprod_cost' . $optionId;
$sellPriceFieldName = 'selprod_price' . $optionId;
$stockFieldName = 'selprod_stock' . $optionId;
$skuFieldName = 'selprod_sku' . $optionId;

?>

<tr id="<?php echo $optionId; ?>">
    <td><?php echo $title; ?></td>
    <td data-val="<?php echo $optionData[$costFieldName]; ?>">
        <?php echo CommonHelper::displayMoneyFormat($optionData[$costFieldName], true, true); ?>
    </td>
    <td data-val="<?php echo $optionData[$sellPriceFieldName]; ?>">
        <?php echo CommonHelper::displayMoneyFormat($optionData[$sellPriceFieldName], true, true); ?>
    </td>
    <td data-val="<?php echo $optionData[$stockFieldName]; ?>">
        <?php echo $optionData[$stockFieldName]; ?>
    </td>
    <td data-val="<?php echo $optionData[$skuFieldName]; ?>">
        <?php echo $optionData[$skuFieldName]; ?>
    </td>
    <td>
        <ul class="actions">
            <li>
                <a href="javascript:void(0)" onclick="copyRowData(this)" title="<?php echo Labels::getLabel('LBL_COPY_TO_FORM', $siteLangId); ?>">
                    <i class="fas fa-paste"></i>
                </a>
            </li>
            <?php if (0 < $selprod_id) { ?>
                <li>
                    <a href="javascript:void(0)" onclick="copyRowData(this, <?php echo $selprod_id; ?>)" title="<?php echo Labels::getLabel('LBL_EDIT', $siteLangId); ?>">
                        <i class="fas fa-edit"></i>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="sellerProductDelete(this, <?php echo $selprod_id; ?>)" title="<?php echo Labels::getLabel('LBL_DELETE', $siteLangId); ?>">
                        <i class="fas fa-trash"></i>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </td>
</tr>