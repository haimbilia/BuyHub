<?php
$fields = array(
    'listSerial' => Labels::getLabel('LBL_#', $siteLangId),
    'mainfile' => Labels::getLabel('LBL_DD_File', $siteLangId),
    'preview' => Labels::getLabel('LBL_DD_Preview', $siteLangId),
    //'afile_lang_id' => Labels::getLabel('LBL_DDLanguage', $siteLangId),
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
    $tr = $tbody->appendElement('tr');

    foreach ($fields as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo, true);
                break;
            case 'mainfile':
                $dvElem = $td->appendElement('div', array('class' => 'actions-downloads'));
                $dvElem->appendElement('div', array('class' => 'file-name'), $row[$key], true);
                break;
            case 'preview':
                $dvElem = $td->appendElement('div', array('class' => 'actions-downloads'));
                $dvElem->appendElement('div', array('class' => 'file-name'), $row[$key], true);
                if (0 < $row['prev_afile_id']) {
                    $dvElem->appendElement(
                        "a",
                        array(
                            'class' => 'btn btn-sm',
                            'title' => Labels::getLabel('LBL_download', $siteLangId),
                            'href' => UrlHelper::generateUrl('SellerProducts', 'downloadAttachment', array($row['prev_afile_id'], $recordId, $downloadrefType, 1, $row['preview'])),
                            'target' => '_blank'
                        ),
                        '<i class="fa fa-download  icon"></i>',
                        true
                    );
                } else {
                    $dvElem->appendElement('p', array(), Labels::getLabel('LBL_NA', $siteLangId), true);
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
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}

include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');
?>
<div class="col-md-12">
    <div class="js-scrollable table-wrap table-responsive">
        <?php echo $tbl->getHtml(); ?>
    </div>
</div>