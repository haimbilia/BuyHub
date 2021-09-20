<?php defined('SYSTEM_INIT') or die('Invalid Usage'); 

$recordCount = isset($recordCount) ? $recordCount : 0; 

$statusButtons = isset($statusButtons) ? $statusButtons : false; 
$deleteButton = isset($deleteButton) ? $deleteButton : false; 
$newRecord = isset($newRecord) ? $newRecord : false; 
$otherButtons = isset($otherButtons) ? $otherButtons : []; ?>

<div class="card-head">
    <h3 class="card-head-label">
        <span class="card-head-title"><?php echo Labels::getLabel('LBL_NEW_PRODUCTS', $adminLangId); ?></span>
        <span class="text-muted"><?php echo sprintf(Labels::getLabel('LBL_OVER_%S_NEW_PRODUCTS', $adminLangId), $recordCount); ?></span>
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