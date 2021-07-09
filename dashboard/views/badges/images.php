<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (!empty($icon)) { ?>
    <div class="uploaded-img ml-2 uploadedImage--js">
        <div class="logothumb">
            <?php $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']); ?>
            <img src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], "THUMB", $icon['afile_screen']), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" title="<?php echo $icon['afile_name']; ?>" alt="<?php echo $icon['afile_name']; ?>">

            <?php if ($canEdit) { ?>
                <a class="deleteLink white" href="javascript:void(0);" title="Delete <?php echo $icon['afile_name']; ?>" onclick="deleteImage(<?php echo $icon['afile_id']; ?>, <?php echo $icon['afile_record_id']; ?>, '<?php echo $imageType; ?>', <?php echo $icon['afile_lang_id']; ?>, <?php echo $icon['afile_screen']; ?> );" class="delete"><i class="ion-close-round"></i></a>
            <?php } ?>

        </div>
        <?php
        $lang_name = Labels::getLabel('LBL_All', $siteLangId);
        if ($icon['afile_lang_id'] > 0) {
            $lang_name = $languages[$icon['afile_lang_id']]; ?>
        <?php
        } ?>
        <small class="text--small"><?php echo $lang_name; ?></small>
    </div>
<?php } ?>