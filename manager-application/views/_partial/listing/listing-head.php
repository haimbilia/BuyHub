<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$statusButtons = isset($statusButtons) ? $statusButtons : false;
$deleteButton = isset($deleteButton) ? $deleteButton : false;
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

<div class="card-toolbar">
    <?php
    $data = [
        'canEdit' => isset($canEdit) ? $canEdit : false,
        'siteLangId' => $siteLangId,        
        'statusButtons' => $statusButtons,
        'deleteButton' => $deleteButton,
        'columnButtons' => $columnButtons,
        'otherButtons' => $otherButtons
    ];
    $this->includeTemplate('_partial/listing/action-buttons.php', $data, false);
    ?>
</div>