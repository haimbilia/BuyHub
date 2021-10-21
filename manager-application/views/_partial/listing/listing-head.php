<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$statusButtons = isset($statusButtons) ? $statusButtons : false;
$deleteButton = isset($deleteButton) ? $deleteButton : false;
$newRecordBtn = isset($newRecordBtn) ? $newRecordBtn : false;
$otherButtons = isset($otherButtons) ? $otherButtons : []; ?>

<div class="card-head">
    <div class="card-head-label">
        <?php if (isset($cardHeadTitle) && !empty($cardHeadTitle)) { ?>
        <h3 class="card-head-title"><?php echo $cardHeadTitle; ?></h3>
        <?php } ?>
        <?php if (isset($recordsTitle) && !empty($recordsTitle)) { ?>
        <span class="text-muted"><?php echo $recordsTitle; ?></span>
        <?php } ?>
    </div>
    <div class="card-toolbar">
        <?php
        $data = [
            'canEdit' => $canEdit,
            'siteLangId' => $siteLangId,
            'newRecordBtn' => $newRecordBtn,
            'statusButtons' => $statusButtons,
            'deleteButton' => $deleteButton,
            'otherButtons' => $otherButtons
        ];
        $this->includeTemplate('_partial/listing/action-buttons.php', $data, false);
        ?>
    </div>
</div>