<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$arr_flds = array(
    'listSerial' => Labels::getLabel('LBL_#', $adminLangId),
    'earch_subject' => Labels::getLabel('LBL_Subject', $adminLangId),
    'earch_to_email' => Labels::getLabel('LBL_Sent_To', $adminLangId),  
    'earch_sent_on' => Labels::getLabel('LBL_Sent_On', $adminLangId),
    'action' => 'Action'
);

$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'action':
                $ul = $td->appendElement("ul", array("class" => "actions"));
                $li = $ul->appendElement("li");
                $li->appendElement(
                    'a',
                    array('href' => UrlHelper::generateUrl(
                        'SentEmails',
                        'view',
                        array($row['earch_id'])
                    ), 'class' => 'button small green', 'title' => Labels::getLabel('LBL_View_Details', $adminLangId)),
                    '<i class="far fa-eye icon"></i>',
                    true
                );
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Records_Found', $adminLangId));
}
echo $tbl->getHtml();

echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmSentEmailSearchPaging'));

$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
