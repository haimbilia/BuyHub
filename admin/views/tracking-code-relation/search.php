<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fields = array(
    'listSerial' => Labels::getLabel('LBL_SR._NO', $siteLangId),
    'shipapi_courier' => Labels::getLabel('LBL_Ship_Api_Courier', $siteLangId),
    'tracking_courier' => Labels::getLabel('LBL_Tracking_Courier', $siteLangId),
);
$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-dashed', 'id' => 'listingTableJs'));
$th = $tbl->appendElement('thead', ['class' => 'tableHeadJs'])->appendElement('tr');

foreach ($fields as $key => $val) {

    $attr = [];
    if($key == 'listSerial'){
        $attr['class'] = 'col-sr';
    }
    $e = $th->appendElement('th', $attr, $val);
}

$serialNo = 0;
foreach ($carriers as $sn => $row) {
    $serialNo++;
    $tr = $tbl->appendElement('tr', array());   

    foreach ($fields as $key => $val) {  

        //$tdAttr = ('tracking_courier' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', []);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'shipapi_courier':
                $td->appendElement('plaintext', array(), $row['name']);
                break;

            case 'tracking_courier':
                $trackingApiCode = '';
                foreach ($records as $data) {
                    if ($row['code'] == $data['tccr_shipapi_courier_code']) {
                        $trackingApiCode = $data['tccr_tracking_courier_code'];
                        break;
                    }
                }

                $selectBox = "<select id=" . $row['code'] . " onChange='setUpCourierRelation(this)'><option value=''>" . Labels::getLabel('LBL_Select', $siteLangId) . "</option>";
                foreach ($trackingCourier as $code => $courier) {
                    $selected = ($trackingApiCode == $code) ? 'selected=selected' : '';
                    $selectBox .= "<option " . $selected . " value=" . $code . ">" . $courier . "</option>";
                }
                $selectBox .= "</select>";
                $td->appendElement('plaintext', array(), $selectBox, true);
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}

if (count($carriers) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds)), Labels::getLabel('LBL_No_Records_Found', $siteLangId));
}
echo $tbl->getHtml();
