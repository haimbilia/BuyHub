<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (!empty($images)) { 
     $uploadedTime = AttachedFile::setTimeParam($images['afile_updated_at']);?>
<ul class="uploaded-media-list">
    <li>
        <div class="uploaded-img">
             <a class="close-layer" href="javascript:void(0);" onClick="removeCollectionImage(<?php echo $scollection_id; ?>,<?php echo $lang_id; ?>)"><?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?></a>
            <img src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'shopCollectionImage', array($images['afile_record_id'], $images['afile_lang_id'], 'THUMB'), CONF_WEBROOT_FRONTEND). $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo Labels::getLabel('LBL_Collection_Image', $siteLangId); ?>">
        </div>
        <small class="form-text text-muted"><?php echo $languages[$images['afile_lang_id']]; ?></small>
      
    </li>
</ul>
<?php } ?>