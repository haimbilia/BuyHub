<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Inventory_options', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
            <?php
            $i = 1;
            $ul = '';
            foreach ($productOptions as $optionVal) {
                if (1 == $i) {
                    $ul .= '<ul class="list-stats list-stats-double inventory-options">';
                }

                $optionName = !empty($optionVal['option_name']) ? $optionVal['option_name'] : $optionVal['option_identifier'];
                $ul .= '<li class="list-stats-item">
                        <span class="lable">
                            ' . $optionName . '
                        </span>
                        <span class="value">
                        ' . implode(', ', $optionVal['optionValues']) . '
                        </span>
                    </li>';

                if (count($productOptions) == $i) {
                    $ul .= '</ul>';
                } 

                $i++;
            }
            echo $ul;
            ?>
    </div>
</div>