<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$shop_city = $shop['shop_city'];
$shop_state = (strlen($shop['shop_city']) > 0) ? ', ' . $shop['shop_state_name'] : $shop['shop_state_name'];
$shop_country = (strlen($shop_state) > 0) ? ', ' . $shop['shop_country_name'] : $shop['shop_country_name'];
$shopLocation = $shop_city . $shop_state . $shop_country;
?> <div id="body" class="body">
    <div class="bg-second pt-3 pb-3">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-8">
                    <div class="section-head section--white--head mb-0">
                        <div class="section__heading">
                            <h2><?php echo $shop['shop_name']; ?></h2>
                            <p><?php echo $shopLocation; ?>
                                <?php echo Labels::getLabel('LBL_Opened_on', $siteLangId); ?>
                                <?php echo FatDate::format($shop['shop_created_on']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-auto col-sm-auto">
                    <a href="<?php echo UrlHelper::generateUrl('Shops', 'view', array($shop['shop_id'])); ?>"
                        class="btn btn-outline-white btn-sm"><?php echo Labels::getLabel('Lbl_Back_to_Shop', $siteLangId); ?></a>
                </div>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div id="itemRatings">
                        <div class="section__head">
                            <h4><?php echo Labels::getLabel('Lbl_Review_of', $siteLangId) . ' ' . $shop['shop_name'], ' ', Labels::getLabel('Lbl_by', $siteLangId), ' : ', $reviewData['user_name']; ?>
                            </h4>
                        </div>
                        <div class="rowx listing__all">
                            <ul class="reviews-list mt-4">
                                <li>
                                    <div class="row justify-content-between">
                                        <div class="col-auto">
                                            <div class="profile-avatar">
                                                <div class="profile__dp">
                                                    <img src="<?php echo UrlHelper::generateFileUrl('Image', 'user', array($reviewData['spreview_postedby_user_id'], 'thumb', true)); ?>"
                                                        alt="<?php echo $reviewData['user_name']; ?>">
                                                </div>
                                                <div class="profile__bio">
                                                    <div class="title">
                                                        <?php echo Labels::getLabel('Lbl_By', $siteLangId); ?>
                                                        <?php echo CommonHelper::displayName($reviewData['user_name']); ?>
                                                        <span
                                                            class="dated"><?php echo Labels::getLabel('Lbl_On_Date', $siteLangId), ' ', FatDate::format($reviewData['spreview_posted_on']); ?></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="yes-no">
                                                <ul>
                                                    <li><a href="javascript:undefined;"
                                                            onclick='markReviewHelpful(<?php echo FatUtility::int($reviewData['spreview_id']); ?>,1);return false;'
                                                            class="yes <?php echo 'rev_' . FatUtility::int($reviewData['spreview_id']) . '_1'; ?>"><img
                                                                src="<?php echo CONF_WEBROOT_URL; ?>images/thumb-up.png"
                                                                alt="<?php echo Labels::getLabel('LBL_Helpful', $siteLangId); ?>">
                                                            <span>(<?php echo $reviewHelpfulData['helpful']; ?>)</span></a>
                                                    </li>
                                                    <li><a href="javascript:undefined;"
                                                            onclick='markReviewHelpful("<?php echo $reviewData['spreview_id']; ?>",0);return false;'
                                                            class="no <?php echo 'rev_' . FatUtility::int($reviewData['spreview_id']) . '_0'; ?>"><img
                                                                src="<?php echo CONF_WEBROOT_URL; ?>images/thumb-down.png"
                                                                alt="<?php echo Labels::getLabel('LBL_Not_Helpful', $siteLangId); ?>">
                                                            <span>(<?php echo $reviewHelpfulData['notHelpful']; ?>)</span>
                                                        </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="reviews-desc">
                                        <ul class="ratedby-list">
                                            <?php foreach ($recordRatings as $rating) { ?>
                                            <li>
                                                <div class="rating flex-column">
                                                    <span
                                                        class="rating__text"><?php echo $rating['ratingtype_name']; ?></span>
                                                    <div class="rating-view"
                                                        data-rating="<?php echo $rating['sprating_rating']; ?>">
                                                        <?php for ($i = 5; $i >= 1; $i--) { ?>
                                                        <svg class="icon" width="24" height="24">
                                                            <use
                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star">
                                                            </use>
                                                        </svg>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="review-container">
                                            <div class="cms">
                                                <h6><strong><?php echo $reviewData['spreview_title']; ?></strong></h6>
                                                <p> <?php echo nl2br($reviewData['spreview_description']); ?> </p>
                                            </div>
                                            <?php $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_ORDER_FEEDBACK, $reviewData['spreview_id']); 
                                                if (!empty($images)) {
                                            ?>
                                            <div class="uploaded-media all-review-media">
                                                <ul class="review-media-list">
                                                    <?php
                                                        $i = 0;
                                                        foreach ($images as $image) {
                                                            $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                                                            $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($reviewData['spreview_id'], 0, 'MINITHUMB', $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                                            $largeImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($reviewData['spreview_id'], 0, 'LARGE', $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

                                                            if (5 > $i || 5 < $i) { ?>
                                                    <li class="<?php echo 5 < $i ? 'd-none' : ''; ?>">
                                                        <a class="uploaded-file" href="javascript:void(0)"
                                                            onclick="previewImage(this);">
                                                            <img src="<?php echo $imgUrl; ?>"
                                                                data-altimg="<?php echo $largeImgUrl; ?>">
                                                        </a>
                                                    </li>
                                                    <?php } else { ?>
                                                    <li class="more-media" onclick="loadMoreImages(this);">
                                                        <a class="uploaded-file review-media" href="javascript:void(0)"
                                                            data-count="<?php echo count($images); ?>+">
                                                            <img src="<?php echo $imgUrl; ?>"
                                                                data-altimg="<?php echo $largeImgUrl; ?>">
                                                        </a>
                                                    </li>
                                                    <?php }
                                                            $i++;
                                                        } ?>
                                                </ul>
                                            </div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="gap"></div>
</div>
<script>
var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>
</div>