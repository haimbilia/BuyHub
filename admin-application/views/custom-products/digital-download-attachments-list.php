<?php
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    'mainfile' => Labels::getLabel('LBL_File', $adminLangId),
    'preview' => Labels::getLabel('LBL_Preview_Link', $adminLangId),
    'pddr_options_code' => Labels::getLabel('LBL_Link_Option', $adminLangId),
    'afile_lang_id' => Labels::getLabel('LBL_Language', $adminLangId),
    'action' => Labels::getLabel('LBL_Action', $adminLangId),
);

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table'));
$th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
foreach ($attachments as $sn => $row) {
    $sr_no++;
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no, true);
                break;
            case 'mainfile':
                $dvElem = $td->appendElement('div', array('class' => 'd-flex align-items-center'));
                $dvElem->appendElement('div', array('class' => 'text-break'), $row[$key], true);
                if (0 < $row['afile_id']) {
                    $dvElem->appendElement(
                        "a",
                        array(
                            'class' => 'btn btn-sm',
                            'title' => Labels::getLabel('LBL_download', $adminLangId),
                            'href' => UrlHelper::generateUrl('CustomProducts', 'downloadAttachment', array($row['afile_id'], $recordId, $downloadrefType, 0, $row['mainfile'])),
                            'target' => '_blank'
                        ),
                        '<i class="fa fa-download  icon"></i>',
                        true
                    );
                    $dvElem->appendElement(
                        "a",
                        array(
                            'class' => 'btn btn-light btn-sm',
                            'title' => Labels::getLabel('LBL_Delete', $adminLangId),
                            'onclick' => 'deleteDigitalFile(' . $row['afile_id'] . ', ' . $row['afile_record_id'] . ')', 'href' => 'javascript:void(0);'
                        ),
                        '<i class="fa fa-trash  icon"></i>',
                        true
                    );
                } else {
                    $dvElem->appendElement('p', array(), Labels::getLabel('LBL_NA', $adminLangId), true);
                }
                break;
            case 'preview':
                $dvElem = $td->appendElement('div', array('class' => 'd-flex align-items-center'));
                $dvElem->appendElement('div', array('class' => 'text-break'), $row[$key], true);
                if (0 < $row['prev_afile_id']) {
                    $dvElem->appendElement(
                        "a",
                        array(
                            'class' => 'btn btn-sm',
                            'title' => Labels::getLabel('LBL_download', $adminLangId),
                            'href' => UrlHelper::generateUrl('CustomProducts', 'downloadAttachment', array($row['prev_afile_id'], $recordId, $downloadrefType, 1, $row['preview'])),
                            'target' => '_blank'
                        ),
                        '<i class="fa fa-download  icon"></i>',
                        true
                    );
                    $dvElem->appendElement(
                        "a",
                        array(
                            'class' => 'btn btn-light btn-sm',
                            'title' => Labels::getLabel('LBL_Delete', $adminLangId),
                            'onclick' => 'deleteDigitalFile(' . $row['prev_afile_id'] . ', ' . $row['afile_record_id'] . ', 1)', 'href' => 'javascript:void(0);'
                        ),
                        '<i class="fa fa-trash  icon"></i>',
                        true
                    );
                } else {
                    $dvElem->appendElement('p', array(), Labels::getLabel('LBL_NA', $adminLangId), true);
                    $dvElem->appendElement(
                        "a",
                        array(
                            'class' => 'btn btn-light btn-sm',
                            'title' => Labels::getLabel('LBL_Add', $adminLangId),
                            'href' => 'javascript:void(0);',
                            'onclick' => 'attachDigitalPreviewFile(\'' . $row['pddr_options_code'] . '\', ' . $row['afile_lang_id'] . ', ' . $row['pddr_id'] . ', ' .  $row['afile_id'] . '); return false;', 'href' => 'javascript:void(0);'
                        ),
                        '<i class="fa fa-plus  icon"></i>',
                        true
                    );
                }
                break;
            case 'pddr_options_code':
                if (array_key_exists($row['pddr_options_code'], $options)) {
                    $val = $options[$row['pddr_options_code']];
                } else {
                    $val = 'Invalid option link - ' . $row['pddr_options_code'];
                }
                $td->appendElement('plaintext', array(), $val, true);
                break;
            case 'afile_lang_id':
                $lang_name = Labels::getLabel('LBL_All', $adminLangId);
                if ($row['afile_lang_id'] > 0) {
                    $lang_name = $languages[$row['afile_lang_id']];
                }
                $td->appendElement('plaintext', array(), $lang_name, true);
                break;
            case 'action':
                if (1 < $row['afile_id'] || 1 < $row['prev_afile_id']) {
                    $fileId = $row['afile_id'];
                    $isPreview = 0;
                    if (1 > $row['afile_id']) {
                        $fileId = $row['prev_afile_id'];
                        $isPreview = 1;
                    }
                    $td->appendElement(
                        "a",
                        array(
                            'class' => 'btn btn-clean btn-sm btn-icon',
                            'title' => Labels::getLabel('LBL_Delete', $adminLangId),
                            'onclick' => 'deleteDigitalFile(' . $fileId . ', ' . $row['afile_record_id'] . ', ' . $isPreview . ', 1)',
                            'href' => 'javascript:void(0);'
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

if (empty($attachments)) {
    $tr = $tbl->appendElement('tr')->appendElement('td', ['colspan' => count($arr_flds)]);
    $tr->appendElement('plaintext', array(), Labels::getLabel('LBL_No_Records', $adminLangId), true);
}
?>
<div class="col-md-12">
    <?php echo $tbl->getHtml(); ?>
</div>
