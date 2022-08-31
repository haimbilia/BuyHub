<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Inventory_options', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="v-tabs v-tabs--js">
            <?php
            $i = 1;
            $ul = $content = '';

            foreach ($productOptions as $optionVal) {
                if (1 == $i) {
                    $ul .= '<ul class="v-tabs-list">';
                }

                $optionName = !empty($optionVal['option_name']) ? $optionVal['option_name'] : $optionVal['option_identifier'];
                $ul .= '<li class="' . ((1 == $i) ? 'is-active' : '') . '">
                        <a href="#opt' . $optionVal['option_id'] . '" class="v-tab--js">
                            ' . $optionName . '
                        </a>
                    </li>';

                if (count($productOptions) == $i) {
                    $ul .= '</ul>';
                }

                $content .= '<div id="opt' . $optionVal['option_id'] . '" class="v-tabs-data ' . ((1 == $i) ? 'is-active' : '') . '">
                            ' . implode(', ', $optionVal['optionValues']) . '
                        </div>';

                $i++;
            }
            echo $ul . $content;
            ?>
        </div>
    </div>
</div>