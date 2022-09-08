<?php

if (1 > count($links)) {
    return;
}
$arr_flds = [
    'pdl_download_link' => Labels::getLabel('LBL_DOWNLOAD_LINK', $siteLangId),
    'pdl_preview_link' => Labels::getLabel('LBL_PREVIEW_LINK', $siteLangId),
    'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $siteLangId),
];

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table listingTableJs'));
$th = $tbl->appendElement('thead', ['class' => 'tableHeadJs'])->appendElement('tr', array('class' => 'hide--mobile'));
foreach ($arr_flds as $key => $val) {
    $tdAttr = ('action' == $key) ? ['class' => 'align-right', 'width' => '20%'] : ['width' => '40%'];
    $e = $th->appendElement('th', $tdAttr, $val);
}

$serialNo = 0;
foreach ($links as $sn => $row) {
    $serialNo++;
    $tr = $tbl->appendElement('tr', array('id' => $row['pdl_id'] . '_' . $row['pdl_record_id']));

    foreach ($arr_flds as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo, true);
                break;
            case 'pdl_lang_id':
                if (array_key_exists($row['pdl_lang_id'], $languages)) {
                    $val = $languages[$row['pdl_lang_id']];
                } else {
                    $val = 'Invalid language link-' . $row['pdl_lang_id'];
                }
                $td->appendElement('plaintext', $tdAttr, $val, true);
                break;
            case 'pddr_options_code':
                if (array_key_exists($row['pddr_options_code'], $options)) {
                    $val = $options[$row['pddr_options_code']];
                } else {
                    $val = 'Invalid option link - ' . $row['pddr_options_code'];
                }
                $td->appendElement('plaintext', $tdAttr, $val, true);
                break;
            case 'pdl_download_link':
                if ('' != $row['pdl_download_link']) {
                    $td->appendElement('div', array("class" => "clipboard"), '<input  name ="copy" class="form-control copy-input"  title="' . $row[$key] . '"  value="' . $row[$key] . '" readonly> <button type="button" data-bs-toggle="tooltip"  data-bs-toggle="tooltip" data-title="' . $row[$key]  . '" title="' . Labels::getLabel('LBL_CLICK_TO_COPY', $siteLangId) . ': ' . $row[$key] . '" class="copy-btn"  onclick="copyText(this,true)"><i class="far fa-copy"></i></button>', true);
                } else {
                    $td->appendElement('p', $tdAttr, Labels::getLabel('LBL_NA', $siteLangId), true);
                }

                break;
            case 'pdl_preview_link':
                if ('' != $row['pdl_preview_link']) {
                    $td->appendElement('div', array("class" => "clipboard"), '<input name ="copy" class="form-control copy-input"  title="' . $row[$key] . '" value="' . $row[$key] . '"  readonly> <button type="button" data-bs-toggle="tooltip"  data-bs-toggle="tooltip" data-title="' . $row[$key]  . '" title="' . Labels::getLabel('LBL_CLICK_TO_COPY', $siteLangId) . ': ' . $row[$key] . '" class="copy-btn" data-toggle="tooltip" onclick="copyText(this,true)"><i class="far fa-copy"></i></button>', true);
                } else {
                    $td->appendElement('p', $tdAttr, Labels::getLabel('LBL_NA', $siteLangId), true);
                }
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['pdl_id']
                ];
                $data['deleteButton'] = [
                    'onclick' => 'deleteDigitallink(' . $row['pdl_id'] . ',' . $row['pdl_record_id'] . ')'
                ];

                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
}

if (empty($links)) {
    $tr = $tbl->appendElement('tr')->appendElement('td', ['colspan' => count($arr_flds)]);
    $tr->appendElement('plaintext', array(), Labels::getLabel('LBL_NO_RECORDS', $siteLangId), true);
}
?>
<div class="table-responsive table-scrollable js-scrollable">
    <?php echo $tbl->getHtml(); ?>
</div>