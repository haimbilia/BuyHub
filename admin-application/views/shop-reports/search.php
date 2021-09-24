<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arr_flds = array(
        'listSerial' => Labels::getLabel('LBL_#', $adminLangId),
        'shop_name' => Labels::getLabel('LBL_SHOP', $adminLangId),
        'user_name' => Labels::getLabel('LBL_Reported_by', $adminLangId),
        'reportreason_title' => Labels::getLabel('LBL_Report_Reason', $adminLangId),
        'sreport_message' => Labels::getLabel('LBL_Message', $adminLangId),
        'sreport_added_on' => Labels::getLabel('LBL_Date_Time', $adminLangId),
        /* 'action' => Labels::getLabel('LBL_Action',$adminLangId), */
    );
$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$serialNo = 0;
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $tr = $tbl->appendElement('tr');
    $tr->setAttribute("id", $row['sreport_id']);

    foreach ($arr_flds as $key => $val) {
        $arr = array();
        if ($key == 'sreport_message') {
            $arr['width'] = '40%';
        }
        $td = $tr->appendElement('td', $arr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'sreport_added_on':
                $td->appendElement('plaintext', array(), FatDate::format($row[$key], true));
                break;
            case 'sreport_message':
                $td->appendElement('plaintext', array(), nl2br($row[$key]), true);
                break;
            /* case 'action':
                $ul = $td->appendElement("ul",array("class"=>"actions"));
                if($canEdit){
                    $li = $ul->appendElement("li");
                    $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green',
                    'title'=>Labels::getLabel('LBL_Delete',$adminLangId),"onclick"=>"deleteRecord(".$row['sreport_id'].")"),'<i class="fa fa-trash  icon"></i>',
                    true);
                }
                break; */
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
