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

    $tagId = $row['tpr_tag_id'];
    $editListingFrm = new Form('editListingFrm-' . $tagId, array('id' => 'editListingFrm-' . $tagId));
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
                $editable = $canEdit ? 'true' : 'false';
                $td->appendElement('div', [
                    "class" => 'click-to-edit',
                    'name' => $key,
                    'data-id' => $tagId,
                    'data-product-id' => $row['tpr_product_id'],
                    'data-value' => $row[$key],
                    'data-formated-value' => $row[$key],
                    'contentEditable' => $editable,
                    'data-bs-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'onblur' => 'updateValues(this)',
                    'onfocus' => 'showOrignal(this)',
                    'title' => Labels::getLabel('LBL_CLICK_TO_EDIT', $siteLangId)
                ], $row[$key], true);
                break;
            case 'tpr_custom_weightage_valid_till':      
                $date = 0 < strtotime($row[$key]) ? date('Y-m-d', strtotime($row[$key])) : '0000-00-00';
                $fldAttr = array(
                    'placeholder' => $val,
                    'readonly' => 'readonly',
                    'class' => 'field--calender inputDateJs hide',
                    'name' => $key,
                    'data-product-id' => $row['tpr_product_id'],
                    'data-id' => $tagId,
                    'data-value' => $date,
                    'data-formated-value' => $date,
                );

                $attr = ['class' => 'dateJs contenteditable click-to-edit', 'data-bs-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Labels::getLabel('LBL_CLICK_TO_EDIT', $siteLangId)];
                $td->appendElement('div', $attr, $date, true);
                $editListingFrm->addDateField($val, $key, $date, $fldAttr);
                $td->appendElement('plaintext', array(), $editListingFrm->getFieldHtml($key), true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key]);
                break;
        }
    }
    $serialNo++;
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
