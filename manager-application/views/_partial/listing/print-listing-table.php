<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$formFields = isset($formFields) ? $formFields : [];

if (isset($defaultFormWithActionBtns) && false === $defaultFormWithActionBtns) {
    echo $tbl->getHtml();
} else if (empty($formFields) && isset($controller)) {
    $attr = [
        'class' => 'actionButtonsJs',
        'onsubmit' => 'formAction(this, reloadList); return(false);',
        'action' => UrlHelper::generateUrl($controller, 'toggleBulkStatuses'),
    ];
    $frm = new Form('listingForm', $attr);
    $frm->addHiddenField('', 'status');

    echo $frm->getFormTag();
    echo $frm->getFieldHtml('status');
    echo $tbl->getHtml(); 
    echo '</form>';
} 
/* Not in use right now. */
/* else if (!empty($formFields)) {
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
} */