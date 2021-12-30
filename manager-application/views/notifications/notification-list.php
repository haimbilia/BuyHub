<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if(count($arrListing) > 0){
	foreach($arrListing as $key=>$row){
		$mainDiv = new HtmlElement("div",array("class"=>"notification"));
		$div = $mainDiv->appendElement("div",array("class"=>"notification__img"));
		$div = $div->appendElement("div",array("class"=>"icon"));
		$div->appendElement("img",['class'=>'','href'=>UrlHelper::generateFullUrl('Image','user',array($row['notification_user_id'],'MINI',true),CONF_WEBROOT_FRONT_URL)]);
	
		$uname = ($row['user_name'])?$row['user_name']:Labels::getLabel('LBL_GUEST_USER', $siteLangId);
		$url = UrlHelper::generateUrl($labelArr[$row['notification_label_key']][1]);
		$div = $mainDiv->appendElement("div",array("class"=>"notification__detail"));
		$div->appendElement("a",['href'=>$url,'class'=>'title'],$uname);
		$div->appendElement("div",['class'=>'summary'],$labelArr[$row['notification_label_key']][0]);

		$mainDiv->appendElement("a",['class'=>'notification__time'],'1 hr');
		echo $mainDiv->getHtml();
	}
}
else{	
	$tbody = new HtmlElement("div");
	include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');
}
