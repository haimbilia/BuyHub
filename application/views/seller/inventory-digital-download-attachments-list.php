<?php
$arr_flds['listserial'] = Labels::getLabel('LBL_#', $siteLangId);
if (true === $canDoDigDownload) {
    $arr_flds['mainfile'] = Labels::getLabel('LBL_File', $siteLangId);
}

$arr_flds['preview'] = Labels::getLabel('LBL_Preview_Link', $siteLangId);
/* $arr_flds['pddr_options_code'] = Labels::getLabel('LBL_Link_Option', $siteLangId); */
$arr_flds['afile_lang_id'] = Labels::getLabel('LBL_Language', $siteLangId);

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
                $dvElem->appendElement(
                    "a",
                    array(
                        'class' => 'btn',
                        'title' => Labels::getLabel('LBL_download', $siteLangId),
                        'href' => UrlHelper::generateUrl('Seller', 'downloadAttachment', array($row['afile_id'], $selProdId, Product::CATALOG_TYPE_INVENTORY, 0, $row['mainfile'])),
                        'target' => '_blank'
                    ),
                    '<i class="fa fa-download  icon"></i>',
                    true
                );
                break;
            case 'preview':
                if (0 < $row['prev_afile_id']) {
                    $dvElem = $td->appendElement('div', array('class' => 'd-flex align-items-center'));
                    $dvElem->appendElement('div', array('class' => 'text-break'), $row[$key], true);
                    $dvElem->appendElement(
                        "a",
                        array(
                            'class' => 'btn',
                            'title' => Labels::getLabel('LBL_download', $siteLangId),
                            'href' => UrlHelper::generateUrl('Seller', 'downloadAttachment', array($row['prev_afile_id'], $selProdId, Product::CATALOG_TYPE_INVENTORY, 1, $row['preview'])),
                            'target' => '_blank'
                        ),
                        '<i class="fa fa-download  icon"></i>',
                        true
                    );
                } else {
                    $td->appendElement('plaintext', array(), Labels::getLabel('LBL_NA', $siteLangId), true);
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
                $lang_name = Labels::getLabel('LBL_All', $siteLangId);
                if ($row['afile_lang_id'] > 0) {
                    $lang_name = $languages[$row['afile_lang_id']];
                }
                $td->appendElement('plaintext', array(), $lang_name, true);
                break;
            case 'action':
                if (true === $canDelete) {
                    $td->appendElement(
                        "a",
                        array(
                            'class' => 'btn btn-clean btn-sm btn-icon',
                            'title' => Labels::getLabel('LBL_Delete', $siteLangId),
                            'onclick' => 'deleteDigitalFile(' . $row['afile_id'] . ', ' . $row['afile_record_id'] . ')', 'href' => 'javascript:void(0);'
                        ),
                        '<i class="fa fa-trash  icon"></i>',
                        true
                    );
                }
                if (true === $canDoDigDownload) {
                    if (empty($row['preview'])) {
                        $td->appendElement(
                            "a",
                            array(
                                'class' => 'btn btn-clean btn-sm btn-icon',
                                'title' => Labels::getLabel('LBL_Preview', $siteLangId),
                                'onclick' => 'attachDigitalPreviewFile(\'' . $row['pddr_options_code'] . '\', ' . $row['afile_lang_id'] . ', ' . $row['pddr_id'] . ', ' .  $row['afile_id'] . '); return false;', 'href' => 'javascript:void(0);'
                            ),
                            '<i class="fa fa-caret-square-right icon"></i>',
                            true
                        );
                    }
                }
                    
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}

if (empty($records)) {
    $tr = $tbl->appendElement('tr')->appendElement('td', ['colspan' => count($arr_flds)]);
    $tr->appendElement('plaintext', array(), Labels::getLabel('LBL_No_Records', $siteLangId), true);
}
?>
<div class="col-md-12">
    <?php echo $tbl->getHtml(); ?>
</div>
