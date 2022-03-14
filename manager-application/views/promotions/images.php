<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (!empty($bannerImgArr)) { ?>
    <?php
    foreach ($bannerImgArr as $afile_id => $bannerImg) {
        $imgUrl =  '';
        $uploadedTime = AttachedFile::setTimeParam($bannerImg['afile_updated_at']);
        switch ($promotionType) {
            case Promotion::TYPE_BANNER:
                $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_BANNER, ImageDimension::VIEW_THUMB);

                $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Banner', 'BannerImage', array($bannerImg['afile_record_id'], $bannerImg['afile_lang_id'], $bannerImg['afile_screen'],  ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                break;
            case Promotion::TYPE_SLIDES:
                $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_SLIDE, ImageDimension::VIEW_THUMB);
                $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Image', 'Slide', array($bannerImg['afile_record_id'], $bannerImg['afile_screen'], $bannerImg['afile_lang_id'],  ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                break;
        }
    ?>
        <div class="dropzone-uploaded dropzoneUploadedJs">
            <img data-aspect-ratio = "<?php echo $imageDimensions[ImageDimension::VIEW_THUMB]['aspectRatio']; ?>" src="<?php echo $imgUrl; ?>" title="<?php echo $bannerImg['afile_name']; ?>" alt="<?php echo $bannerImg['afile_name']; ?>">
            <?php if ($canEdit) { ?>
                <div class="dropzone-uploaded-action">
                    <ul class="actions">
                        <li>
                            <a href="javascript:void(0)" onclick="editDropZoneImages(this)" data-bs-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('FRM_CLICK_HERE_TO_EDIT', $siteLangId); ?>">
                                <svg class="svg" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                    </use>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="removeMedia(<?php echo  $promotionId; ?>, <?php echo $bannerImg['afile_record_id']; ?>, <?php echo $bannerImg['afile_lang_id']; ?>,<?php echo $bannerImg['afile_screen']; ?>);" data-bs-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('FRM_CLICK_HERE_TO_REMOVE', $siteLangId); ?>">
                                <svg class="svg" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                    </use>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
<?php }
} ?>