<?php defined('SYSTEM_INIT') or die('Invalid Usage'); 

$statusButtons = isset($statusButtons) ? $statusButtons : false; 
$deleteButton = isset($deleteButton) ? $deleteButton : false; 
$newRecord = isset($newRecord) ? $newRecord : false; 
$otherButtons = isset($otherButtons) ? $otherButtons : []; ?>

<div class="card-head">
    <h3 class="card-head-label">
        <?php if (isset($cardHeadTitle) && !empty($cardHeadTitle)) { ?>
            <span class="card-head-title"><?php echo $cardHeadTitle; ?></span>
        <?php } ?>
        <?php if (isset($recordsTitle) && !empty($recordsTitle)) { ?>
            <span class="text-muted"><?php echo $recordsTitle; ?></span>
        <?php } ?>
    </h3>
    <div class="card-toolbar">
        <?php if ($canEdit) {
                $data = [
                    'adminLangId' => $adminLangId,
                    'newRecord' => $newRecord,
                    'statusButtons' => $statusButtons,
                    'deleteButton' => $deleteButton,
                    'otherButtons' => $otherButtons
                ];

            $this->includeTemplate('_partial/listing/action-buttons.php', $data, false);
        } ?>
    </div>
</div>