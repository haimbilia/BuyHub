<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) { 
    ?>
    <div class="upload__files">
        <ul class="upload__list">
            <li class="upload__list-item" id="<?php echo $image['afile_id']; ?>">
                <div class="media">
                    <?php $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']); ?>
                    <img src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', $imageFunction, array($image['afile_record_id'], $image['afile_lang_id'], "THUMB", $image['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" title="<?php echo $image['afile_name']; ?>" alt="<?php echo $image['afile_name']; ?>">
                </div>
                <div class="title"><?php echo $image['afile_name']; ?></div>
                <?php if ($canEdit) { ?>
                    <div class="action">
                        <a href="javascript:0;" onclick="deleteImage(<?php echo $image['afile_id']; ?>, <?php echo $image['afile_record_id']; ?>, '<?php echo $imageType; ?>', <?php echo $image['afile_lang_id']; ?>, <?php echo $image['afile_screen']; ?> );">
                        </a>
                    </div>
                <?php } ?>
            </li>
        </ul>
    </div>
<?php } ?>