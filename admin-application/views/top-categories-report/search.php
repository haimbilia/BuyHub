<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arrFlds = array(
	'prodcat_name'	=>	Labels::getLabel('LBL_Category',$adminLangId),
	'totSoldQty'	=>	Labels::getLabel('LBL_Sold_Quantity',$adminLangId),
	'wishlistUserCounts'	=>	Labels::getLabel('LBL_WishList_User_Counts',$adminLangId)
);

$tbl = new HtmlElement('table', 
array('width'=>'100%', 'class'=>'table table-responsive table--hovered'));

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arrFlds as $val) {
	$e = $th->appendElement('th', array(), $val, true);
}

$serialNo = 0;
foreach ($arrListing as $sn=>$row){
	$serialNo++;
	$tr = $tbl->appendElement('tr', array('class' => ($row['prodcat_active'] != applicationConstants::ACTIVE || $row['prodcat_deleted'] == applicationConstants::YES) ? 'fat-inactive' : '', 'title' => ($row['prodcat_active'] != applicationConstants::ACTIVE || $row['prodcat_deleted'] == applicationConstants::YES) ? 'In-Active Or Record Deleted' : '' ));
		
	foreach ($arrFlds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listSerial':
				$td->appendElement('plaintext', array(), $serialNo);
			break;
			
			case 'prodcat_name':
				$td->appendElement('plaintext', array(), $catTreeAssocArr[$row['prodcat_id']], true);
			break;
			
			case 'followers':
				$td->appendElement('plaintext', array(), $row[$key], true);
			break;
			
			case 'totSoldQty':
				$td->appendElement('plaintext', array(), $row[$key], true);
			break;
			
			default:
				$td->appendElement('plaintext', array(), $row[$key], true);
			break;
		}
	}
}
if (count($arrListing) == 0){
	$tbl->appendElement('tr')->appendElement('td', array(
	'colspan'=>count($arrFlds)), 
	Labels::getLabel('LBL_No_Records_Found',$adminLangId)
	);
}
echo $tbl->getHtml();