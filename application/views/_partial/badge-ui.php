<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$size = isset($size) ? $size : 'MINI';

$html = "";
if (is_array($badgesArr) && !empty($badgesArr)) {
    $html = '<div>';
        foreach ($badgesArr as $bdgRow) { 
            $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $bdgRow[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'], 0, $siteLangId);
            $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
            $url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $siteLangId, $size, $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

            $html .= '<img class="item__title_badge" src="' . $url . '" title="' . $bdgRow[Badge::DB_TBL_PREFIX . 'name'] . '">';
        }
    $html .= '</div>';
}

echo $html;