<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($reviewsImages)) {
    foreach ($reviewsImages as $image) {
        $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
        $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($image['spreview_id'], 0, ImageDimension::VIEW_THUMB, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        $largeImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($image['spreview_id'], 0, ImageDimension::VIEW_LARGE, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
?>
        <div class="image">
            <a class="thumbnail" href="<?php echo $largeImgUrl; ?>" data-fancybox="gallery">
                <img src="<?php echo $imgUrl; ?>" data-altimg="<?php echo $largeImgUrl; ?>">
            </a>
        </div>
    <?php
    }

    if ($page < $pageCount && count($reviewsImages) == $pageSize) { ?>
        <div class="image revsMoreImagesJs txt-over">9+</div>
<?php }
}
