<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
echo '<div class="datatable datatable-sticky scroll scroll-x">';
$tbl = new HtmlElement(
    'table',
    array('width' => '100%', 'class' => 'datatable__table')
);

$th = $tbl->appendElement('thead', ['class' => 'datatable__head'])->appendElement('tr', ['class' => 'datatable__row']);
$count = 0;
$staticFlds = [];
foreach ($fields as $key => $val) {
    $cls = 'datatable_cell datatable_cell-sort datatable_cell_top headerColumnJs';
    if (0 == $count) {
        $staticFlds = [$key];
        $cls .= ' datatable_cell_left';
    }

    $cls .= ($key == $sortBy) ? ' datatable_cell-sorted' : '';

    $td = $th->appendElement('th', ['class' => $cls, 'data-field' => $key]);
    $span = $td->appendElement('span');
    $span->appendElement('plaintext', array(), $val);
    if ($key == $sortBy) {
        $arrow = ($sortOrder == applicationConstants::SORT_ASC) ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>';
        $span->appendElement('plaintext', array(), $arrow, true);
    }
    $count++;
}

$tbody = $tbl->appendElement('tbody', ['class' => 'datatable__body']);
$sr_no = $page == 1 ? 0 : $pageSize * ($page - 1);
$statusArr = Transactions::getStatusArr($siteLangId);
foreach ($arrListing as $sn => $row) {
    $cls = (($sr_no % 2) == 0) ? 'datatable__row datatable__row--even' : 'datatable__row';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $sr_no]);

    foreach ($fields as $key => $val) {
        if (in_array($key, $staticFlds)) {
            $td = $tr->appendElement('th', ['class' => 'datatable_cell datatable_cell_left']);
            $span = $td->appendElement('span');
        } else {
            $td = $tr->appendElement('td', ['class' => 'datatable_cell']);
            $span = $td->appendElement('span');
        }
        switch ($key) {
            case 'listserial':
                $span->appendElement('plaintext', array(), $sr_no);
                break;
            case 'date':
                $span->appendElement('plaintext', array(), FatDate::format($row[$key]));
                break;

            case 'utxn_date':
                $span->appendElement('plaintext', array(), FatDate::format($row[$key], true), true);
                break;
            case 'utxn_id':
                $span->appendElement('plaintext', array(), Transactions::formatTransactionNumber($row[$key]), true);
                break;
            case 'user_name':
                $name = $row[$key];
                $name .= !empty($row['credential_email']) ? ' (' . $row['credential_email'] . ')' : '';
                $span->appendElement('plaintext', array(), $name, true);
                break;
            case 'utxn_status':
                $span->appendElement('plaintext', array(), $statusArr[$row[$key]], true);
                break;
            case 'utxn_credit':
            case 'utxn_debit':
            case 'transactionAmount':
                $span->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;

            default:
                $span->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }

    $sr_no++;
}
echo $tbl->getHtml();
if (count($arrListing) == 0) {

    $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
} ?>
</div>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmReportSrchPaging', 'method' => 'post'));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'callBackJsFunc' => 'goToReportSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false); ?>
<script>
    var x = $(".card-body").width();
    var actualWidth = x / 7;
    $('.datatable_cell_left').children('span').css('width', actualWidth + 'px');
    $('.datatable_cell_left').children('span').css('display', 'block');
    $('.datatable_cell_left').children('span').css('white-space', 'normal');
</script>