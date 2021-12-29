<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'check' => '',
	'profile' => '',
	'summary' => '',
	'notification_added_on' => '',
);
if (!$canEdit) {
	unset($arr_flds['check']);
}

$mainDiv = new HtmlElement('div', array('class' => 'listingRecordJs'));

foreach ($arrListing as $sn => $row) {
	if ($row['notification_marked_read']) {
		$rowDiv = $mainDiv->appendElement('div', array('class' => 'notifications__item read'));
	} else {
		$rowDiv = $mainDiv->appendElement('div', array('class' => 'notifications__item'));
	}
	foreach ($arr_flds as $key => $val) {
		switch ($key) {
			case 'check':
				$rowDiv->appendElement('plaintext', [], '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="record_ids[]" value=' . $row['notification_id'] . '><i class="input-helper"></i></label>', true);
				break;
			case 'profile':
				$div = $rowDiv->appendElement('div', array('class' => 'avatar avatar--small'));
				$div->appendElement('img', array('src' => UrlHelper::generateFileUrl('Image', 'user', array($row['notification_user_id'], 'MINI', true), CONF_WEBROOT_FRONT_URL)));
				break;
			case 'summary':
				$url = UrlHelper::generateUrl($labelArr[$row['notification_label_key']][1]);
				$uname = ($row['user_name']) ? $row['user_name'] : Labels::getLabel('LBL_GUEST_USER', $siteLangId);
				$rowDiv->appendElement('div', array('class' => 'notifications__summary'), '<a href="javascript:void(0)" onclick=redirectfunc("' . $url . '","' . $row['notification_record_id'] . '","' . $row['notification_id'] . '") ><h6>' . $uname . '</h6>' . $labelArr[$row['notification_label_key']][0] . '</a>', true);
				break;
			default:
				$rowDiv->appendElement('plaintext', [], HtmlHelper::formatDateTime(
					$row[$key],
					true,
					true,
					FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
				), true);
				break;
		}
	}
}

echo $mainDiv->getHtml();
