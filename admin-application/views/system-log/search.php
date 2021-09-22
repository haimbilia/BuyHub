<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'listSerial' => Labels::getLabel('LBL_#', $adminLangId),
    'slog_title' => Labels::getLabel('LBL_Title', $adminLangId),
    'slog_content' => Labels::getLabel('LBL_Content', $adminLangId),
    'slog_response' => Labels::getLabel('LBL_Response', $adminLangId),
    'slog_type'    => Labels::getLabel('LBL_Log_Type', $adminLangId),
    'slog_module_type' => Labels::getLabel('LBL_Module_Type', $adminLangId),
    'action' => '',
);

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive'));
$th = $tbl->appendElement('thead')->appendElement('tr');

foreach ($arr_flds as $key => $val) {
   $e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr', array());

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $sr_no);
                break;
            case 'slog_type':
                $td->appendElement('plaintext', array(), $types[$row['slog_type']], true);
                break;
            case 'slog_module_type':
                $td->appendElement('plaintext', array(), $moduleTypes[$row['slog_module_type']], true);
                break;
            case 'slog_content':
                $td->appendElement('plaintext', array(), CommonHelper::truncateCharacters($row['slog_content'], 40), true);
                break;
            case 'action':
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-clean btn-sm btn-icon', 'title' => Labels::getLabel('LBL_View_details', $adminLangId), "onclick" => "viewLog(" . $row['slog_id'] . ")"), "<i class='fa fa-eye icon'></i>", true);
                break;    
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $sr_no--;
}
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Records_Found', $adminLangId));
}
echo $tbl->getHtml(); ?>
</form>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmSyslogSearchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
