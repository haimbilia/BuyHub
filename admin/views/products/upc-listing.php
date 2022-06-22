<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<table class="table">
    <thead>
        <tr>
            <th><?php echo Labels::getLabel('LBL_Variants', $langId); ?></th>
            <th><?php echo Labels::getLabel('LBL_EAN/UPC_code', $langId); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($optionCombinations)) {
            foreach ($optionCombinations as $optionValueId => $optionValue) {
                $arr = explode('|', $optionValue);
                $key = str_replace('|', ',', $optionValueId);
                $variant = $optionValue;
        ?>
            <tr>
                <td><?php echo $variant; ?></td>
                <td><input class="form-control" type="text" name="product_upcs[<?php echo $key ?>]" value="<?php echo (isset($upcCodeData[$key]['upc_code'])) ? $upcCodeData[$key]['upc_code'] : ''; ?>" data-fatreq ='<?php echo json_encode(['required'=> false]); ?>'></td>
            </tr>
            <?php }
        } else { ?>
            <tr>
                <td><?php echo Labels::getLabel('LBL_ALL_Variants', $langId); ?></td>
                <td><input class="form-control" type="text" name="product_upcs[0]" value="<?php echo (isset($upcCodeData[0]['upc_code'])) ? $upcCodeData[0]['upc_code'] : ''; ?>" data-fatreq='<?php echo json_encode(['required'=> false]); ?>'></td>
            </tr>
        <?php } ?>
    </tbody>
</table>