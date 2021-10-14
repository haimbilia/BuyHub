<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="form-edit-foot">
    <div class="row">
        <div class="col">
            <?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_RESET', $siteLangId), 'button', 'btn_reset_form', 'btn btn-outline-brand resetModalFormJs'); ?>
        </div>
        <div class="col-auto">
            <?php
            echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_SAVE', $siteLangId), 'button', 'btn_save', 'btn btn-brand gb-btn gb-btn-primary submitBtnJs');
            ?>
        </div>
    </div>
</div>