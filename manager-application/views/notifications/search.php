<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$fields = array(
	'check' => '',
	'summary' => '',
	'notification_added_on' => '',
);

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn=>$row){
	$cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
	if($row['notification_marked_read']){
		$cls .=' read'; 
	}
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['notification_id']]);
	foreach ($fields as $key=>$val){
		$tdAttr = ('notification_added_on' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);	
		switch ($key){
			case 'check':
				if($canEdit){
					$td->appendElement('plaintext', [], '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="record_ids[]" value=' . $row['notification_id'] . '><i class="input-helper"></i></label>', true);
				}
			break;
			
			case 'summary':
				$div = $td->appendElement('div', array('class' => 'd-flex'));
				$div->appendElement('div', array('class' => 'avatar avatar--small'))
				->appendElement('img', array('src' => UrlHelper::generateFileUrl('Image', 'user', array($row['notification_user_id'], 'MINI', true), CONF_WEBROOT_FRONT_URL)));
				
				$url = UrlHelper::generateUrl($labelArr[$row['notification_label_key']][1]);
				$uname = ($row['user_name']) ? $row['user_name'] : Labels::getLabel('LBL_GUEST_USER', $siteLangId);
				$div->appendElement('div', array('class' => 'notifications__summary'), '<a href="javascript:void(0)" onclick=redirectfunc("' . $url . '","' . $row['notification_record_id'] . '","' . $row['notification_id'] . '") ><h6>' . $uname . '</h6>' . $labelArr[$row['notification_label_key']][0] . '</a>', true);
				
			break;
			default:
			$td->appendElement('plaintext', [], HtmlHelper::formatDateTime(
				$row[$key],
				true,
				true,
				FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
			), true);			
			break;
		}
	}
	$serialNo++;
}

if (count($arrListing) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
}

if ($printData) {
    echo $tbody->getHtml();
}