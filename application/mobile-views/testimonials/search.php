<?php

foreach ($list as $key => $listItem) {
    $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_TESTIMONIAL_IMAGE, $listItem['testimonial_id']);
    $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
    $list[$key]['imageUrl'] = UrlHelper::generateFullFileUrl('Image', 'testimonial', array($listItem['testimonial_id'], $siteLangId, ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime;
}

$data = array(
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'testimonials' => $list
);
