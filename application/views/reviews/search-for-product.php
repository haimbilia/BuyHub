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
                        <li>
                            <div class="rating flex-column">
                                <span class="rating__text"> Shipping</span>
                                <div class="rating-view" data-rating="4">
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="rating flex-column">
                                <span class="rating__text">Stock Availability</span>
                                <div class="rating-view" data-rating="3">
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                </div>

                            </div>
                        </li>
                        <li>
                            <div class="rating flex-column">
                                <span class="rating__text">Delivery time</span>
                                <div class="rating-view" data-rating="2">
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                </div>

                            </div>
                        </li>
                        <li>
                            <div class="rating flex-column">
                                <span class="rating__text">Package Quality</span>
                                <div class="rating-view" data-rating="4">
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                    <svg class="icon" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                    </svg>
                                </div>

                            </div>
                        </li>
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
                            <!-- <a class="btn btn-secondary mt-3" href="<?php echo UrlHelper::generateUrl('Reviews', 'productPermalink', array($review['spreview_selprod_id'], $review['spreview_id'])) ?>"><?php echo Labels::getLabel('Lbl_Permalink', $siteLangId); ?> </a> -->
                        </div>
                        <div class="all-review-media">
                            <ul class="review-media-list">
                                <li><a class="review-media" href="javascript:void(0)"><img src="http://yokart-v8.local.4livedemo.com/image/product/7/MEDIUM/0/1591"></a></li>
                                <li><a class="review-media" href="javascript:void(0)"><img src="http://yokart-v8.local.4livedemo.com/image/product/7/MEDIUM/0/1591"></a></li>
                                <li><a class="review-media" href="javascript:void(0)"><img src="http://yokart-v8.local.4livedemo.com/image/product/7/MEDIUM/0/1591"></a></li>
                                <li><a class="review-media" href="javascript:void(0)"><img src="http://yokart-v8.local.4livedemo.com/image/product/7/MEDIUM/0/1591"></a></li>
                                <li><a class="review-media" href="javascript:void(0)"><img src="http://yokart-v8.local.4livedemo.com/image/product/7/MEDIUM/0/1591"></a></li>

                                <li class="more-media">
                                    <a class="review-media" href="javascript:void(0)" data-count="45+">
                                        <img src="http://yokart-v8.local.4livedemo.com/image/product/7/MEDIUM/0/1591">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </li>
        <?php } ?>
    </ul>
    <div class="align--center  mt-4"><a href="<?php echo UrlHelper::generateUrl('Reviews', 'Product', array($selprod_id)); ?>" class="btn btn-secondary"><?php echo Labels::getLabel('Lbl_Showing_All', $siteLangId) . ' ' . count($reviewsList) . ' ' . Labels::getLabel('Lbl_Reviews', $siteLangId); ?> </a></div> <?php echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmSearchReviewsPaging')); ?>
<?php } else {
    // $this->includeTemplate('_partial/no-record-found.php', array('siteLangId'=>$siteLangId), false);
} ?>