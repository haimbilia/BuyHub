<?php
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    'pdl_download_link' => Labels::getLabel('LBL_Download_Link', $adminLangId),
    'pdl_preview_link' => Labels::getLabel('LBL_Preview_Link', $adminLangId),
    // 'pddr_options_code' => Labels::getLabel('LBL_Link_Option', $adminLangId),
    'pdl_lang_id' => Labels::getLabel('LBL_Link_language', $adminLangId),
    'action' => Labels::getLabel('LBL_Action', $adminLangId),
);

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table'));
$th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}
$sr_no = 0;
foreach ($records as $sn => $row) {
    $sr_no++;
    $tr = $tbl->appendElement('tr', array('id' => $row['pdl_id'] . '_' . $row['pdl_record_id']));

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no, true);
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
                $td->appendElement('div', array("class"=>"clipboard"), '<input class="copy-input" value="'.$row[$key].'" id="copymain_'. $row['pdl_id'] .'" readonly> <button class="copy-btn" id="copyButton_'. $row['pdl_id'] .'" onclick="fcom.copyToClipboard(\'copymain_'. $row['pdl_id'] .'\')"><i class="far fa-copy"></i></button>', true);
                break;
            case 'pdl_preview_link':
                $td->appendElement('div', array("class"=>"clipboard"), '<input class="copy-input" value="'.$row[$key].'" id="copypreview_'. $row['pdl_id'] .'" readonly> <button class="copy-btn" id="copyButton_'. $row['pdl_id'] .'" onclick="fcom.copyToClipboard(\'copypreview_'. $row['pdl_id'] .'\')"><i class="far fa-copy"></i></button>', true);
                break;
            case 'action':
                /* $td->appendElement(
                    "a",
                    array(
                        'class' => 'btn btn-clean btn-sm btn-icon',
                        'title' => Labels::getLabel('LBL_Edit', $adminLangId),
                        'onclick' => 'downloadsForm(' . $row['pddr_record_id'] . ', ' . $row['pdl_id'] . ')', 'href' => 'javascript:void(0);'
                    ),
                    '<i class="fa fa-edit  icon"></i>',
                    true
                ); */

                $td->appendElement(
                    "a",
                    array(
                        'class' => 'btn btn-clean btn-sm btn-icon',
                        'title' => Labels::getLabel('LBL_Delete', $adminLangId),
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

if (empty($records)) {
    $tr = $tbl->appendElement('tr')->appendElement('td', ['colspan' => count($arr_flds)]);
    $tr->appendElement('plaintext', array(), Labels::getLabel('LBL_No_Records', $adminLangId), true);
}
?>
<div class="col-md-12">
    <?php echo $tbl->getHtml(); ?>
</div>