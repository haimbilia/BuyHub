<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_PAYMENT_GATEWAY_RESPONSE', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body">
    <div class="form-edit-body">
        <?php
        if (!empty($response)) {
            header('Content-Type: application/json');
            echo '<pre style="max-height: 400px;">';
            echo json_encode($response, JSON_PRETTY_PRINT);
            echo '</pre>';
        }
        ?>
    </div>
</div>