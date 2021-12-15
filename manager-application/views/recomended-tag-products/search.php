<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);

    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'product_name':
                $product_name = $row['product_name'];

                $td->appendElement('plaintext', $tdAttr, $product_name, true);
                break;
            case 'tpr_custom_weightage':
                $editable = $canEdit ? 'contentEditable="true"' : '';
                $onblur = 'onblur="saveData(' . $row['tpr_tag_id'] . ', ' . $row['tpr_product_id'] . ', \'' . "tpr_custom_weightage" . '\', this.textContent)"';
                $element = "<div " . $editable . " data-bs-toggle='tooltip' data-placement='top' title='" . Labels::getLabel('LBL_CLICK_HERE_TO_EDIT', $siteLangId) . "' " . $onblur . ">" . $row[$key] . "</div>";

                $td->appendElement('plaintext', $tdAttr, $element, true);
                break;
            case 'tpr_custom_weightage_valid_till':
                $tillDateFrm = new Form('tillDateFrm');
                $tillDateFrm->setFormTagAttribute('onSubmit', 'return false;');
                $tillDateFrm->addDateField('', 'tpr_custom_weightage_valid_till', $row[$key], array('onchange' => 'saveData(' . $row['tpr_tag_id'] . ', ' . $row['tpr_product_id'] . ', "tpr_custom_weightage_valid_till", this.value)', 'readonly' => 'readonly'));
                if (!$canEdit) {
                    $fld = $tillDateFrm->getField('tpr_custom_weightage_valid_till');
                    $fld->setFieldTagAttribute('disabled', 'disabled');
                }
                $td->appendElement('plaintext', $tdAttr, $tillDateFrm->getFormHtml(), true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key]);
                break;
        }
    }
    $serialNo++;
}

if (count($arrListing) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
}

if ($printData) {
    echo $tbody->getHtml();
}
