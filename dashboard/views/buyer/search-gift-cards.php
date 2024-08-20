<?php
?>
<div class="js-scrollable table-wrap table-responsive">
    <?php $arr_flds = array(
        'ogcards_order_id'    =>    Labels::getLabel('LBL_ORDER_ID', $siteLangId),
        'ogcards_code'    =>    Labels::getLabel('LBL_CODE', $siteLangId),
        'ogcards_receiver_name' =>    Labels::getLabel('LBL_RECEIVER_NAME', $siteLangId),
        'ogcards_receiver_email'    =>    Labels::getLabel('LBL_RECEIVER_EMAIL', $siteLangId),
        'order_payment_status' =>  Labels::getLabel('LBL_PAYMENT_STATUS', $siteLangId),
        'ogcards_status'    =>    Labels::getLabel('LBL_STATUS', $siteLangId),
    );

    $tbl = new HtmlElement('table', array('class' => 'table'));
    $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => ''));
    foreach ($arr_flds as $key => $val) {
        $class = 'utxn_id' == $key ? ['class' => 'text-nowrap'] : [];
        $e = $th->appendElement('th', $class, $val);
    }

    $sr_no = 0;
    foreach ($arrListing as $sn => $row) {
        $sr_no++;
        $tr = $tbl->appendElement('tr');

        foreach ($arr_flds as $key => $val) {
            $td = $tr->appendElement('td');
            switch ($key) {
                case 'ogcards_order_id':
                    $td->appendElement('plaintext', array(),  '<div class="text-nowrap">' . $row[$key] . '</div>', true);
                    break;
                case 'ogcards_status':
                    $statusclass = (GiftCards::STATUS_USED == $row[$key]) ? 'success' : 'warning';
                    $statusTxt = (GiftCards::STATUS_USED == $row[$key]) ?  Labels::getLabel('LBL_USED', $siteLangId) : Labels::getLabel('LBL_UN_USED', $siteLangId);
                    $txt = '<span class="badge badge-inline badge-' . $statusclass . '">' . $statusTxt . '</span>';
                    $td->appendElement('plaintext', array(),  $txt, true);
                    break;
                case 'order_payment_status':
                    $statusclass = (OrderPayment::ORDER_PAYMENT_PAID == $row[$key]) ? 'success' : 'warning';
                    $statusTxt = (OrderPayment::ORDER_PAYMENT_PAID == $row[$key]) ?  Labels::getLabel('LBL_PAID', $siteLangId) : Labels::getLabel('LBL_UNPAID', $siteLangId);
                    $txt = '<span class="badge badge-inline badge-' . $statusclass . '">' . $statusTxt . '</span>';
                    $td->appendElement('plaintext', array(),  $txt, true);
                    break;
                default:
                    $td->appendElement('plaintext', array(), $row[$key], true);
                    break;
            }
        }
    }

    echo $tbl->getHtml();
    if (count($arrListing) == 0) {
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