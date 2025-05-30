<?php
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_#', $siteLangId),
    'promotion_identifier' => Labels::getLabel('LBL_Promotion_name', $siteLangId),
    'promotion_type' => Labels::getLabel('LBL_Type', $siteLangId),
    'totChargedAmount' => Labels::getLabel('LBL_Charged_Amount', $siteLangId),
    'totClicks' => Labels::getLabel('LBL_Clicks', $siteLangId),
    'pcharge_date' => Labels::getLabel('LBL_Charge_Date', $siteLangId)
);
$tbl = new HtmlElement(
    'table',
    array('width' => '100%', 'class' => 'table', 'id' => 'promotions')
);

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}
$arrYesNo = applicationConstants::getYesNoArr($siteLangId);
$activeInactiveArr = applicationConstants::getActiveInactiveArr($siteLangId);
$sr_no = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
    $sr_no++;
    $tr = $tbl->appendElement('tr');
    $tr->setAttribute("id", $row['promotion_id']);

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no);
                break;
            case 'promotion_identifier':
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
            case 'promotion_type':
                $td->appendElement('plaintext', array(), $typeArr[$row[$key]], true);
                break;
            case 'totChargedAmount':
                $td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key]), true);
                break;
            case 'totClicks':
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
            case 'pcharge_date':
                $td->appendElement('plaintext', array(), FatDate::format($row[$key]), true);
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
?>

<div class="js-scrollable table-wrap table-responsive">
    <?php
    echo $tbl->getHtml();
    if (count($arrListing) == 0) {
        $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
    }
    $postedData['page'] = $page;
    echo FatUtility::createHiddenFormFromData($postedData, array(
        'name' => 'frmChargesSearchPaging'
    ));
    $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount);
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false);

    ?>
</div>