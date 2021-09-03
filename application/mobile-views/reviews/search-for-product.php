<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

// CommonHelper::printArray($recordRatings);

if (!empty($reviewsList) && is_array($reviewsList)) {
    foreach ($reviewsList as &$review) {
        $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_ORDER_FEEDBACK, $review['spreview_id']);
                 
        foreach ($images as $image) { 
            $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
            $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($review['spreview_id'], 0, 'MINITHUMB', $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $largeImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($review['spreview_id'], 0, 'LARGE', $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $review['images'][] = [
                'imageUrl' => $imgUrl,
                'largeImageUrl' => $largeImgUrl
            ];
        }

        foreach ($recordRatings as $rating) {
            if ($review['spreview_id'] != $rating['sprating_spreview_id']) {
                continue;
            }
            $review['ratingAspects'][] = $rating;
        }
    }
}

$data = array(
    'reviewsList' => array_values($reviewsList),
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $totalRecords,
);

if (empty($reviewsList)) {
    $status = applicationConstants::OFF;
}
