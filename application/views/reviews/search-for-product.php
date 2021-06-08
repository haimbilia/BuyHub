<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if ($reviewsList) { ?>
    <ul class="reviews-list mt-4">
        <?php foreach ($reviewsList as $review) { ?>
            <li>
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <div class="profile-avatar">
                            <div class="profile__dp">
                                <img src="<?php echo UrlHelper::generateUrl('Image', 'user', array($review['spreview_postedby_user_id'], 'thumb', true)); ?>" alt="<?php echo $review['user_name']; ?>">
                            </div>
                            <div class="profile__bio">
                                <div class="title"><?php echo Labels::getLabel('Lbl_By', $siteLangId); ?> <?php echo CommonHelper::displayName($review['user_name']); ?>
                                    <span class="dated"><?php echo Labels::getLabel('Lbl_On_Date', $siteLangId), ' ', FatDate::format($review['spreview_posted_on']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="yes-no">
                            <ul>
                                <li>
                                    <a href="javascript:undefined;" onclick='markReviewHelpful(<?php echo FatUtility::int($review['spreview_id']); ?>,1);return false;' class="yes"><img src="<?php echo CONF_WEBROOT_URL; ?>images/thumb-up.png" alt="<?php echo Labels::getLabel('LBL_Helpful', $siteLangId); ?>"> (<?php echo $review['helpful']; ?>)
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:undefined;" onclick='markReviewHelpful("<?php echo $review['spreview_id']; ?>",0);return false;' class="no">
                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/thumb-down.png" alt="<?php echo Labels::getLabel('LBL_Not_Helpful', $siteLangId); ?>"> (<?php echo $review['notHelpful']; ?>)
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="reviews-desc">
                    <ul class="ratedby-list">
                        <?php
                        foreach ($recordRatings as $rating) {
                            if ($review['spreview_id'] != $rating['sprating_spreview_id']) {
                                continue;
                            }
                        ?>
                            <li>
                                <div class="rating flex-column">
                                    <span class="rating__text"><?php echo $rating['ratingtype_name']; ?></span>
                                    <div class="rating-view" data-rating="<?php echo $rating['sprating_rating']; ?>">
                                        <?php for ($i = 5; $i >= 1; $i--) { ?>
                                            <svg class="icon" width="24" height="24">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                            </svg>
                                        <?php } ?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>

                    <div class="review-container">
                        <div class="cms">
                            <h6><strong><?php echo $review['spreview_title']; ?></strong></h6>
                            <p>
                                <span class='lessText'>
                                    <?php echo CommonHelper::truncateCharacters($review['spreview_description'], 200, '', '', true); ?>
                                </span>
                                <?php if (strlen($review['spreview_description']) > 200) { ?>
                                    <span class='moreText hidden'>
                                        <?php echo nl2br($review['spreview_description']); ?>
                                    </span>
                                    <a class="readMore link--arrow btn-link" href="javascript:void(0);">
                                        <?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?> </a>
                                <?php } ?>
                            </p>
                        </div>
                        <div class="uploaded-media">
                            <ul>
                                <?php
                                $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_ORDER_FEEDBACK, $review['spreview_id']);
                                
                                $i = 0;
                                foreach ($images as $image) { 
                                    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                                    $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($review['spreview_id'], 0, 'MINITHUMB', $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                    $largeImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($review['spreview_id'], 0, 'LARGE', $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

                                    if (5 > $i || 5 < $i) { ?>
                                        <li class="<?php echo 5 < $i ? 'd-none' : ''; ?>">
                                            <a class="review-media" href="javascript:void(0)" onclick="previewImage(this);">
                                                <img src="<?php echo $imgUrl; ?>" data-altimg="<?php echo $largeImgUrl; ?>">
                                            </a>
                                        </li>
                                    <?php } else { ?>
                                        <li class="more-media" onclick="loadMoreImages(this);">
                                            <a class="review-media" href="javascript:void(0)" data-count="<?php echo count($images); ?>+">
                                                <img src="<?php echo $imgUrl; ?>" data-altimg="<?php echo $largeImgUrl; ?>">
                                            </a>
                                        </li>
                                    <?php }
                                    $i++;
                                } ?>
                            </ul>
                        </div>
                        <a class="btn btn-outline-gray btn-sm mt-3" href="<?php echo UrlHelper::generateUrl('Reviews', 'productPermalink', array($review['spreview_selprod_id'], $review['spreview_id'])) ?>"><?php echo Labels::getLabel('Lbl_Permalink', $siteLangId); ?> </a>
                    </div>

                </div>
            </li>
        <?php } ?>
    </ul>
    <div class="align-center mt-4"><a href="<?php echo UrlHelper::generateUrl('Reviews', 'Product', array($selprod_id)); ?>" class="btn btn-outline-brand"><?php echo Labels::getLabel('Lbl_Showing_All', $siteLangId) . ' ' . count($reviewsList) . ' ' . Labels::getLabel('Lbl_Reviews', $siteLangId); ?> </a></div> <?php echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmSearchReviewsPaging')); ?>
<?php } else {
    // $this->includeTemplate('_partial/no-record-found.php', array('siteLangId'=>$siteLangId), false);
} ?>