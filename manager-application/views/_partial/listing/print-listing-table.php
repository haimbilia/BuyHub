<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$formFields = isset($formFields) ? $formFields : [];
$performBulkAction = $performBulkAction ?? false;

$bulkActionFormHiddenFields = $bulkActionFormHiddenFields ?? ['status' => ''];

if (false === $performBulkAction) {
    echo $tbl->getHtml();
} else if (empty($formFields) && true === $performBulkAction) {
    $formAction = isset($formAction) ? $formAction : 'toggleBulkStatuses';
    $attr = [
        'class' => 'actionButtonsJs',
        'onsubmit' => 'formAction(this, reloadList); return(false);',
        'action' => UrlHelper::generateUrl(LibHelper::getControllerName(), $formAction),
    ];
    $frm = new Form('listingForm', $attr);
    echo $frm->getFormTag();

    foreach ($bulkActionFormHiddenFields as $fldName => $fldValue) {
        $frm->addHiddenField('', $fldName, $fldValue);
        echo $frm->getFieldHtml($fldName);
    }
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