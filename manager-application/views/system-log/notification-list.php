<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (count($arrListing) > 0) {
	foreach ($arrListing as $key => $row) {
		$mainDiv = new HtmlElement("div", array("class" => "notification"));
		$div = $mainDiv->appendElement("div", array("class" => "notification__img"));
		$div = $div->appendElement("div", array("class" => "icon"));		

		$div = $mainDiv->appendElement("div", array("class" => "notification__detail"));
		$div->appendElement("a", ['href' => 'javascript:void(0)', 'onclick' => "redirectfunc(fcom.makeUrl('SystemLog'), {slog_id:" . $row['slog_id'] . "}, 0, false);", 'class' => 'title'], $types[$row['slog_type']]);
		$div->appendElement("div", ['class' => 'summary'], $row['slog_title']);

		$mainDiv->appendElement("a", ['class' => 'notification__time'], HtmlHelper::getRelativeTime($row['slog_created_at'], $siteLangId));
		echo $mainDiv->getHtml();
	}
} else {
	$tbody = new HtmlElement("div");
	include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');
	echo $tbody->getHtml();
}
