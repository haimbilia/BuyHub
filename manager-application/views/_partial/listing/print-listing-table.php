<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$defaultFormWithActionBtns = isset($defaultFormWithActionBtns) ? $defaultFormWithActionBtns : true;
$formFields = isset($formFields) ? $formFields : [];

if (false === $defaultFormWithActionBtns) {
    echo $tbl->getHtml();
} else if (empty($formFields) && isset($controller)) {
    $attr = [
        'class' => 'actionButtons-js',
        'onsubmit' => 'formAction(this, reloadList); return(false);',
        'action' => UrlHelper::generateUrl($controller, 'toggleBulkStatuses'),
    ];
    $frm = new Form('listingForm', $attr);
    $frm->addHiddenField('', 'status');

    echo $frm->getFormTag();
    echo $frm->getFieldHtml('status');
    echo $tbl->getHtml(); 
    echo '</form>';
} else if (!empty($formFields)) {
    $formName = isset($formFields['name']) ? $formFields['name'] : 'listingForm';
    $formAttr = isset($formFields['attr']) ? $formFields['attr'] : [];
    $hiddenFields = isset($hiddenFields['hiddenFields']) ? $hiddenFields['hiddenFields'] : [];

    $frm = new Form($formName, $formAttr);

    echo $frm->getFormTag();
    foreach ($hiddenFields as $fldName) {
        $frm->addHiddenField('', $fldName);
        echo $frm->getFieldHtml($fldName);
    }
    echo $tbl->getHtml();
    echo '</form>';
}