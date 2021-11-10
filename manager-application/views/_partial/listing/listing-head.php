<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$statusButtons = isset($statusButtons) ? $statusButtons : false;
$deleteButton = isset($deleteButton) ? $deleteButton : false;
$newRecordBtn = isset($newRecordBtn) ? $newRecordBtn : false;
$newRecordBtnAttrs = isset($newRecordBtnAttrs) ? $newRecordBtnAttrs : [];
$otherButtons = isset($otherButtons) ? $otherButtons : [];

$columnButtons = '';

if (isset($formColumns) && !empty($formColumns)) {
    $columnButtons = '<ul class="list-checkbox list-drag-drop ui-sortable" id="sortable">';
    foreach ($formColumns as $key => $label) {
        $disabled = '';
        $checked = '';
        if (in_array($key, $defaultColumns)) {
            $disabled = 'disabled';
            $checked = 'checked="checked"';
        }
        $columnButtons .= '<li>
            <svg class="svg" width="18" height="18">
                <use
                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#drag">
                </use>
            </svg>
            <label class="checkbox ' . $disabled . '">
                <input class="filterColumnJs" type="checkbox" name="listingColumns" value="' . $key . '" ' . $checked . $disabled . ' onClick=reloadList()>
                ' . $label . ' <span></span></label>
        </li>';
    }
    $columnButtons .= ' </ul>';
}
?>

<div class="card-head">
    <div class="card-head-label">
        <?php if (isset($cardHeadTitle) && !empty($cardHeadTitle)) { ?>
            <h3 class="card-head-title">
                <?php if(isset($cardHeadBackButtonHref)){ ?>
                    <a class="back" href="<?php echo $cardHeadBackButtonHref; ?>">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/admin/images/retina/sprite-actions.svg#back">
                            </use>
                        </svg>
                    </a>
                <?php } ?>   
                <?php echo $cardHeadTitle; ?>             
            </h3>
        <?php } ?>
        <?php if (isset($recordsTitle) && !empty($recordsTitle)) { ?>
            <span class="text-muted"><?php echo $recordsTitle; ?></span>
        <?php } ?>
    </div>
    <div class="card-toolbar">
        <?php
        $data = [
            'canEdit' => isset($canEdit) ? $canEdit : false,
            'siteLangId' => $siteLangId,
            'newRecordBtn' => $newRecordBtn,
            'newRecordBtnAttrs' => $newRecordBtnAttrs,
            'statusButtons' => $statusButtons,
            'deleteButton' => $deleteButton,
            'columnButtons' => $columnButtons,
            'otherButtons' => $otherButtons
        ];
        $this->includeTemplate('_partial/listing/action-buttons.php', $data, false);
        ?>
    </div>
</div>