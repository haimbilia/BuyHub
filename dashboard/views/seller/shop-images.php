<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($images as &$img) {
    $uploadedTime = AttachedFile::setTimeParam($img['afile_updated_at']);
    $img['imageUrl'] = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', $imageFunction, array($img['afile_record_id'], $img['afile_lang_id'], 'PREVIEW', $img['afile_id']), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $img['removeFunction'] = "removeShopImage(" . $img['afile_id'] . "," . $img['afile_lang_id'] . ",'" . $imageType . "'," . $img['afile_screen'] . ")";
}
$this->includeTemplate('_partial/imageTemplate.php', ['images' => $images]);
?>