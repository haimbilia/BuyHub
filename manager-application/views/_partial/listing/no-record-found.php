<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (count($arrListing) == 0) {
    $img = $this->includeTemplate('_partial/no-record-found.php', [], false, true);
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => isset($fields) ? count($fields) :1,
            'class' => 'noRecordFoundJs'
        ),
        $img, true
    );
}