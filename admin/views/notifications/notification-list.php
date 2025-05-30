<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (count($arrListing) > 0) {
	foreach ($arrListing as $key => $row) {
		$imageUserDimensions = ImageDimension::getData(ImageDimension::TYPE_USER, ImageDimension::VIEW_MINI);
		$mainDiv = new HtmlElement("div", array("class" => "notification"));
		$div = $mainDiv->appendElement("div", array("class" => "notification__img"));
		$div = $div->appendElement("div", array("class" => "icon"));
		$div->appendElement("img", ['data-aspect-ratio' => $imageUserDimensions[ImageDimension::VIEW_MINI]['aspectRatio'], 'class' => '', 'src' => UrlHelper::generateFullUrl('Image', 'user', array($row['notification_user_id'], ImageDimension::VIEW_MINI, true), CONF_WEBROOT_FRONT_URL)]);

		$uname = ($row['user_name']) ? $row['user_name'] : Labels::getLabel('LBL_GUEST_USER', $siteLangId);	
		$div = $mainDiv->appendElement("div", array("class" => "notification__detail"));

		$url = UrlHelper::generateUrl($labelArr[$row['notification_label_key']][1]);
		$onclick = 'redirectfunc("' . $url  . '",{recordId:' . $row['notification_record_id'] . '},'.$row['notification_id'].')';

		$div->appendElement("a", ['href' => 'javascript:void(0)', 'onclick'=> $onclick, 'class' => 'title', 'title' => $labelArr[$row['notification_label_key']][0]], $uname);
		$div->appendElement("div", ['class' => 'summary', 'title' => $labelArr[$row['notification_label_key']][0]], $labelArr[$row['notification_label_key']][0]);

		$mainDiv->appendElement("a", ['class' => 'notification__time'], HtmlHelper::getRelativeTime($row['notification_added_on'], $siteLangId));
		echo $mainDiv->getHtml();
	}
} else {
	$tbody = new HtmlElement("div");
	include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');
}
