<?php

$arr_flds['listserial'] = Labels::getLabel('LBL_#', $siteLangId);
if (true === $canDoDigDownload) {
    $arr_flds['pdl_download_link'] = Labels::getLabel('LBL_Download_Link', $siteLangId);
}
$arr_flds['pdl_preview_link'] = Labels::getLabel('LBL_Preview_Link', $siteLangId);

if (true === $canDoDigDownload) {
    $arr_flds['action'] = Labels::getLabel('LBL_Action', $siteLangId);
}

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
                if ('' != $row[$key] && true === $canDoDigDownload) {
                    $td->appendElement('div', array("class" => "clipboard"), '<input class="copy-input" value="' . $row[$key] . '" id="copymain_' . $row['pdl_id'] . '" readonly> <button class="copy-btn" id="copyButton_' . $row['pdl_id'] . '" onclick="fcom.copyToClipboard(\'copymain_' . $row['pdl_id'] . '\')"><i class="far fa-copy"></i></button>', true);
                } else {
                    $td->appendElement('p', array(), Labels::getLabel('LBL_NA', $siteLangId), true);
                }
                break;
            case 'pdl_preview_link':
                if ('' != $row[$key]) {
                    $td->appendElement('div', array("class" => "clipboard"), '<input class="copy-input" value="' . $row[$key] . '" id="copypreview_' . $row['pdl_id'] . '" readonly> <button class="copy-btn" id="copyButton_' . $row['pdl_id'] . '" onclick="fcom.copyToClipboard(\'copypreview_' . $row['pdl_id'] . '\')"><i class="far fa-copy"></i></button>', true);
                } else {
                    $td->appendElement('p', array(), Labels::getLabel('LBL_NO_PREVIEW_AVAILABLE', $siteLangId), true);
                }
                break;
            case 'action':
                if (true === $canDoDigDownload) {
                    $td->appendElement(
                        "a",
                        array(
                            'class' => '',
                            'title' => Labels::getLabel('LBL_Delete', $siteLangId),
                            'onclick' => 'deleteDigitallink(' . $row['pdl_id'] . ',' . $row['pdl_record_id'] . ')', 'href' => 'javascript:void(0);'
                        ),
                        '<i class="fa fa-trash  icon"></i>',
                        true
                    );
                }

                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}

?>
<div class="col-md-12">
    <?php
    if (empty($records)) {
        echo $tbl->getHtml();
        $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
    } else {
        echo $tbl->getHtml();
    } ?>
</div>