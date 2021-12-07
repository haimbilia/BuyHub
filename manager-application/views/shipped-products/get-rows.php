<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'listSerial' => Labels::getLabel('LBL_#', $siteLangId),
    'user_name' => Labels::getLabel('LBL_Seller_name', $siteLangId),
    'shop_identifier' => Labels::getLabel('LBL_shop_name', $siteLangId),
);
$tbl = new HtmlElement('tr', array('width' => '100%', 'class' => ''));
$th = $tbl->appendElement('thead')->appendElement('tr'); 
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
            case 'user_name':
                $td->appendElement('a', array('href' => 'javascript:void(0)', 'onClick' => 'redirectUser(' . $row['user_id'] . ')'), $row[$key]);
                break;
            case 'shop_identifier':
                $td->appendElement('a', array('href' => 'javascript:void(0)', 'onClick' => 'redirectToShop(' . $row['shop_id'] . ')'), $row[$key]);
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Records_Found', $siteLangId));
}
echo $tbl->getHtml();
?>
