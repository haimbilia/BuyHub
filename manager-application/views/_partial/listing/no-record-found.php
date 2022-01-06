<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (count($arrListing) == 0) {
    $img = '<div class="not-found">
                <img width="100" src="' . CONF_WEBROOT_URL . 'images/retina/no-data-cuate.svg" alt="">
                <h3>' . Labels::getLabel('MSG_SORRY,_NO_RESULT_FOUND_:(') . '</h3>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae amet </p>
            </div>';
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => isset($fields) ? count($fields) :1,
            'class' => 'noRecordFoundJs'
        ),
        $img, true
    );
}