<?php
$fields = array(
    'listSerial' => Labels::getLabel('LBL_#', $siteLangId),
    'pdl_preview_link' => Labels::getLabel('LBL_Preview_Link', $siteLangId),
   // 'pdl_lang_id' => Labels::getLabel('LBL_Link_language', $siteLangId)
);

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-justified'));
$th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
foreach ($fields as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$tbody = $tbl->appendElement('tbody', ['class' => 'listingRecordJs']);
$serialNo = 0;
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $tr = $tbody->appendElement('tr', array('id' => $row['pdl_id'] . '_' . $row['pdl_record_id']));

    foreach ($fields as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo, true);
                break;
            case 'pdl_lang_id':
                if (array_key_exists($row['pdl_lang_id'], $languages)) {
                    $val = $languages[$row['pdl_lang_id']];
                } else {
                    $val = 'Invalid language link-' . $row['pdl_lang_id'];
                }
                $td->appendElement('plaintext', array(), $val, true);
                break;
            case 'pddr_options_code':
                if (array_key_exists($row['pddr_options_code'], $options)) {
                    $val = $options[$row['pddr_options_code']];
                } else {
                    $val = 'Invalid option link - ' . $row['pddr_options_code'];
                }
                $td->appendElement('plaintext', array(), $val, true);
                break;
            case 'pdl_download_link':
                if ('' != $row[$key]) {
                    $td->appendElement('div', array("class"=>"clipboard"), '<input class="form-control copy-input" value="'.$row[$key].'" id="copymain_'. $row['pdl_id'] .'" readonly> <button class="btn btn-light btn-sm copy-btn" id="copyButton_'. $row['pdl_id'] .'" onclick="fcom.copyToClipboard(\'copymain_'. $row['pdl_id'] .'\')"><i class="far fa-copy"></i></button>', true);
                } else {
                    $td->appendElement('p', array(), Labels::getLabel('LBL_NA', $siteLangId), true);
                }
                break;
            case 'pdl_preview_link':
                if ('' != $row[$key]) {
                    $td->appendElement('div', [], $row[$key], true);
                } else {
                    $td->appendElement('p', array(), Labels::getLabel('LBL_NA', $siteLangId), true);
                }
                break;
            case 'action':
                $td->appendElement(
                    "a",
                    array(
                        'class' => 'btn btn-clean btn-sm btn-icon',
                        'title' => Labels::getLabel('LBL_Delete', $siteLangId),
                        'onclick' => 'deleteDigitallink(' . $row['pdl_id'] . ',' . $row['pdl_record_id'] . ')', 'href' => 'javascript:void(0);'
                    ),
                    '<i class="fa fa-trash  icon"></i>',
                    true
                );

                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}


include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');   

?>
<div class="col-md-12">
    <?php echo $tbl->getHtml(); ?>
</div>