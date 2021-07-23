<?php //if (array_key_exists('brand_id', $headerFormParamsAssocArr) && $headerFormParamsAssocArr['brand_id'] > 0) {
    ?>
<div class="brand-information">
    <div class="brand-logo">
        <?php
                $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_LOGO, $headerFormParamsAssocArr['brand_id'], 0, 0, false);
                $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                ?>
        <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?>
            data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?>
            src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'brand', array($headerFormParamsAssocArr['brand_id'], $siteLangId, 'COLLECTION_PAGE')), CONF_IMG_CACHE_TIME, '.jpg'); ?>"
            alt="<?php echo (!empty($fileData['afile_attribute_alt'])) ? $fileData['afile_attribute_alt'] : $pageTitle; ?>"
            title="<?php echo (!empty($fileData['afile_attribute_alt'])) ? $fileData['afile_attribute_alt'] : $pageTitle; ?>">
    </div>
</div> <?php// } ?>