<?php
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $siteLangId),
    'mainfile' => Labels::getLabel('LBL_File', $siteLangId),
    'preview' => Labels::getLabel('LBL_Preview_Link', $siteLangId),
    'pddr_options_code' => Labels::getLabel('LBL_Link_Option', $siteLangId),
    'afile_lang_id' => Labels::getLabel('LBL_Language', $siteLangId),
    'action' => Labels::getLabel('LBL_Action', $siteLangId),
);

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table'));
$th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}
$requestType = Product::CATALOG_TYPE_PRIMARY;
if (true == $isProductRequest) {
    $requestType = Product::CATALOG_TYPE_REQUEST;
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
                $td->appendElement('plaintext', array(), $row[$key], true);
                $td->appendElement(
                    "a",
                    array(
                        'class' => 'btn btn-clean btn-sm btn-icon',
                        'title' => Labels::getLabel('LBL_Delete', $siteLangId),
                        'href' => UrlHelper::generateUrl('Seller', 'downloadAttachment', array($row['afile_id'], $recordId, $requestType, 0, $row['mainfile'])),
                        'target' => '_blank'
                    ),
                    '<i class="fa fa-download  icon"></i>',
                    true
                );
                break;
            case 'preview':
                $td->appendElement('plaintext', array(), $row[$key], true);
                $td->appendElement(
                    "a",
                    array(
                        'class' => 'btn btn-clean btn-sm btn-icon',
                        'title' => Labels::getLabel('LBL_download', $siteLangId),
                        'href' => UrlHelper::generateUrl('Seller', 'downloadAttachment', array($row['prev_afile_id'], $recordId, $requestType, 1, $row['preview'])),
                        'target' => '_blank'
                    ),
                    '<i class="fa fa-download  icon"></i>',
                    true
                );
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
                
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
?>
<div class="col-md-12">
    <?php echo $tbl->getHtml(); ?>
</div>
