<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($list)) {
    if (1 >= $page) { ?>
        <div class="row testimonialRowJs">
        <?php }

    foreach ($list as $listItem) { ?>
            <div class="col-md-4 mb-4">
                <div class="testimonials-item">
                    <div class="user">
                        <?php $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_TESTIMONIAL_IMAGE, $listItem['testimonial_id']);
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']); ?>
                        <img alt="<?php echo $listItem['testimonial_user_name']; ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'testimonial', array($listItem['testimonial_id'], $siteLangId, ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>">
                        <h3 class="user-name"><?php echo $listItem['testimonial_user_name']; ?></h3>
                    </div>
                    <div class="testimonials-content">

                        <p> <?php echo $listItem['testimonial_text']; ?></p>

                    </div>
                </div>
            </div>
        <?php }

    if (1 >= $page) { ?>
        </div>
<?php }
} else {
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId), false);
}
