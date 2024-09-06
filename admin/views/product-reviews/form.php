<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$displayLangTab =  false;
$includeTabs =  false;
$formTitle =  Labels::getLabel('LBL_PRODUCT_REVIEW_STATUS_UPDATE', $siteLangId);
HtmlHelper::formatFormFields($frm);
if (!$frm->getFormTagAttribute('data-onclear')) {
    $frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ')');
}

$frm->setFormTagAttribute('class', 'form modalFormJs ');
if (!$frm->getFormTagAttribute('onsubmit')) {
    $frm->setFormTagAttribute('onsubmit', 'saveRecord($("#' . $frm->getFormTagAttribute('id') . '")[0]); return(false);');
}

require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
<div class="form-edit-body loaderContainerJs">
    <ul class="list-stats list-stats-double">
        <li class="list-stats-item mb-4">
            <span class="lable">
                <?php echo Labels::getLabel('LBL_PRODUCT_NAME', $siteLangId); ?> :
            </span>
            <span class="value">
                <?php echo $data['product_name']; ?>
            </span>
        </li>
        <li class="list-stats-item mb-4">
            <span class="lable">
                <?php echo Labels::getLabel('LBL_REVIEWED_BY', $siteLangId); ?> :
            </span>
            <span class="value">
                <?php echo $data['reviewed_by']; ?>
            </span>
        </li>
        <li class="list-stats-item mb-4">
            <span class="lable">
                <?php echo Labels::getLabel('LBL_DATE', $siteLangId); ?> :
            </span>
            <span class="value">
                <?php echo HtmlHelper::formatDateTime($data['spreview_posted_on'], true); ?>
            </span>
        </li>

        <?php foreach ($ratingData as $rating) {
            $overallProductRating = round($rating['sprating_rating']);
            $avgProductRating =  round($avgRatingData['average_rating']);
        ?>
            <li class="list-stats-item mb-4">
                <span class="label"><?php echo $rating['ratingtype_name']; ?></span>
                <span class="value">
                    <?php for ($i = 1; $i <= 5; $i++) {
                        $fillcolor = ($overallProductRating >= $i) ? '#F5861F' : '#000';
                    ?>
                        <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 24 24" width="18px" fill="<?php echo $fillcolor; ?>">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    <?php } ?>
                </span>
            </li>
        <?php } ?>
        <li class="list-stats-item  mb-4">
            <span class="label"><?php echo Labels::getLabel('LBL_OVERALL_RATING', $siteLangId); ?></span>
            <span class="value">
                <?php for ($i = 1; $i <= 5; $i++) {
                    $fillcolor = ($avgProductRating >= $i) ? '#F5861F' : '#000';
                ?>
                    <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 24 24" width="18px" fill="<?php echo $fillcolor; ?>">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                    </svg>
                <?php } ?>
            </span>
        </li>        
    </ul>
    <div class='row pt-3 pb-3'>
        <div class="col-md 12">
            <?php
            $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_ORDER_FEEDBACK, $recordId);
            $i = 0;
            foreach ($images as $image) {
                $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                $imageReviewDimensions = ImageDimension::getData(ImageDimension::TYPE_REVIEW_IMAGE);

                $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($recordId, 0, ImageDimension::VIEW_MINI_THUMB, $image['afile_id']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                $largeImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($recordId, 0, ImageDimension::VIEW_LARGE, $image['afile_id']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                $largeImage = "displayImageInFacebox('" . $largeImgUrl . "');";
                $imageShow =  '<span class="m-2"><a class="uploaded-file " href="javascript:void(0)" onclick="' . $largeImage . '">';
                $imageShow .=  '<img data-aspect-ratio = "' . $imageReviewDimensions[ImageDimension::VIEW_LARGE]['aspectRatio'] . '" class="rounded my-2" src="' . $imgUrl . '">';
                $imageShow .=  '</a></span>';
                echo $imageShow;
            }
            ?>
        </div>
    </div>
    <?php echo $frm->getFormHtml(); ?>
</div>
<?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>