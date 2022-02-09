<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn=>$row){
	$cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
	if($row['notification_marked_read']){
		$cls .=' read'; 
	}
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['notification_id']]);
	foreach ($fields as $key=>$val){	
        $td = $tr->appendElement('td', []);	
		switch ($key){
			case 'select_all':
                $td->appendElement('plaintext', [], '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="record_ids[]" value=' . $row['notification_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', [], $serialNo);
                break;
			case 'user_name':
				$href = "javascript:void(0)";
				$url = UrlHelper::generateUrl($labelArr[$row['notification_label_key']][1]);

				$onclick = 'redirectfunc("' . $url  . '",{recordId:' . $row['notification_record_id'] . '},'.$row['notification_id'].')';
				$array = [
					'user' => $row,
					'siteLangId' => $siteLangId,
					'href' => $href,
					'onclick' => $onclick,
				];
				if(1 > $row['user_id']){
					$array['onclick'] = false;
					$array['user']['credential_username'] = Labels::getLabel('LBL_GUEST_USER', $siteLangId);
				}
				$str = $this->includeTemplate('_partial/user/user-info-card.php', $array, false, true);				
				$td->appendElement('plaintext', [], $str , true);
				break;
			case 'notification':
				$div = $td->appendElement('div', array('class' => 'd-flex'));
				$url = UrlHelper::generateUrl($labelArr[$row['notification_label_key']][1]);
				$onclick = 'redirectfunc("' . $url  . '",{recordId:' . $row['notification_record_id'] . '},'.$row['notification_id'].')';
				$div->appendElement('div', array('class' => 'notifications__summary'), '<a href="javascript:void(0)" onclick="'.$onclick.'" >' . $labelArr[$row['notification_label_key']][0] . '</a>', true);
				
			break;
			case 'notification_added_on':
				$td->appendElement('plaintext', [], HtmlHelper::formatDateTime(
					$row[$key],
					true,
					true,
					FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
				), true);
			break;
			default:			
		}
	}
	$serialNo++;
}

include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');


if ($printData) {
    echo $tbody->getHtml();
}