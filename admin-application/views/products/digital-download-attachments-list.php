<?php
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    'afile_name' => Labels::getLabel('LBL_File', $adminLangId),
    'afile_lang_id' => Labels::getLabel('LBL_Language', $adminLangId),
    'action' => Labels::getLabel('LBL_Action', $adminLangId),
);

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table'));
$tr = $tbl->appendElement('tr', array('class' => ''));
$td = $tr->appendElement('td', array('colspan' => count($arr_flds)));
$td->appendElement('plaintext', array(), 'Attachments', true);
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
            case 'afile_lang_id':
                $lang_name = Labels::getLabel('LBL_All', $adminLangId);
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
                        'title' => Labels::getLabel('LBL_Edit', $adminLangId),
                        'onclick' => 'downloadsForm(' . $row['afile_record_id'] . ', ' . $row['afile_id'] . ')', 'href' => 'javascript:void(0);'
                    ),
                    '<i class="fa fa-edit  icon"></i>',
                    true
                );
                $td->appendElement(
                    "a",
                    array(
                        'class' => 'btn btn-clean btn-sm btn-icon',
                        'title' => Labels::getLabel('LBL_Delete', $adminLangId),
                        'onclick' => 'deleteDigitalFile(' . $row['afile_record_id'] . ', ' . $row['afile_id'] . ')', 'href' => 'javascript:void(0);'
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
?>
<div class="col-md-6">
    <?php echo $tbl->getHtml(); ?>
</div>
<?php
$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table'));
$tr = $tbl->appendElement('tr', array('class' => ''));
$td = $tr->appendElement('td', array('colspan' => count($arr_flds)));
$td->appendElement('plaintext', array(), 'Previews', true);
$th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
foreach ($previews as $sn => $row) {
    $sr_no++;
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no, true);
                break;
            case 'afile_lang_id':
                $lang_name = Labels::getLabel('LBL_All', $adminLangId);
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
                        'title' => Labels::getLabel('LBL_Delete', $adminLangId),
                        'onclick' => 'deleteDigitalFile(' . $row['afile_record_id'] . ', ' . $row['afile_id'] . ')', 'href' => 'javascript:void(0);'
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
?>
<div class="col-md-6">
    <?php echo $tbl->getHtml(); ?>
</div>