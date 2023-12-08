<?php
require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
<div class="js-scrollable table-wrap table-responsive">
    <?php $arr_flds = array(
        'ogcards_order_id'    =>    Labels::getLabel('LBL_ORDER_ID', $siteLangId),
        'ogcards_code'    =>    Labels::getLabel('LBL_CODE', $siteLangId),
        'ogcards_receiver_name' =>    Labels::getLabel('LBL_RECEIVER_NAME', $siteLangId),
        'ogcards_receiver_email'    =>    Labels::getLabel('LBL_RECEIVER_EMAIL', $siteLangId),
        'ogcards_status'    =>    Labels::getLabel('LBL_STATUS', $siteLangId),
    );

    $tbl = new HtmlElement('table', array('class' => 'table'));
    $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => ''));
    foreach ($arr_flds as $key => $val) {
        $class = 'utxn_id' == $key ? ['class' => 'text-nowrap'] : [];
        $e = $th->appendElement('th', $class, $val);
    }

    $sr_no = 0;
    foreach ($giftCards as $sn => $row) {
        $sr_no++;
        $tr = $tbl->appendElement('tr');

        foreach ($arr_flds as $key => $val) {
            $td = $tr->appendElement('td');
            switch ($key) {
                case 'ordgift_order_id':
                    $td->appendElement('plaintext', array(),  '<div class="text-nowrap">' . $row[$key] . '</div>', true);
                    break;
                default:
                    $td->appendElement('plaintext', array(), $row[$key], true);
                    break;
            }
        }
    }

    echo $tbl->getHtml();
    if (count($giftCards) == 0) {
        $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
    } ?>
</div>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmRecordSearchPaging'));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
?>
<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>