<?php defined('SYSTEM_INIT') or die('Invalid usage');
$totReviews = $avgRating  = $pixelToFillRight = 0;
if (!empty($reviews)) {
    $totReviews = (!empty($reviews['totReviews'])) ? FatUtility::int($reviews['totReviews']) : 0;
    $avgRating = (!empty($reviews['prod_rating'])) ? FatUtility::convertToType($reviews['prod_rating'], FatUtility::VAR_FLOAT) : 0;

    $pixelToFillRight = $avgRating / 5 * 160;
    $pixelToFillRight = FatUtility::convertToType($pixelToFillRight, FatUtility::VAR_FLOAT);
}
?>
<div class="detail-content">
    <!-- <div class="section-head">
        <div class="section-heading">
            <h2>
                <?php echo Labels::getLabel('LBl_Rating_&_Reviews', $siteLangId); ?>
            </h2>
        </div>
        <div class="section-action">
            <?php if ($canSubmitFeedback || $totReviews > 0) { ?>
                <div class="row">
                    <?php if ($canSubmitFeedback) { ?>
                        <div class="col-auto <?php echo ($totReviews > 0) ? 'col-auto' : ''; ?>">
                            <a onClick="rateAndReviewProduct(<?php echo $product_id; ?>)" href="javascript:void(0)" class="btn btn-brand btn-sm <?php echo ($totReviews > 0) ? 'btn-block' : ''; ?>"><?php echo Labels::getLabel('Lbl_Add_Review', $siteLangId); ?></a>
                        </div>
                    <?php } ?>
                    <?php if ($totReviews > 0) { ?>
                        <div class="col <?php echo ($canSubmitFeedback) ? '' : ''; ?>">
                            <div class="dropdown">
                                <button class="btn btn-outline-gray  btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                    <span><?php echo Labels::getLabel('Lbl_Most_Recent', $siteLangId); ?></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-anim">
                                    <ul class="drop nav nav-block">
                                        <li class="nav__item selected"><a class="dropdown-item nav__link" href="javascript:void(0);" data-sort='most_recent' onclick="getSortedReviews(this);return false;"><?php echo Labels::getLabel('Lbl_Most_Recent', $siteLangId); ?></a>
                                        </li>
                                        <li class="nav__item selected"><a class="dropdown-item nav__link" href="javascript:void(0);" data-sort='most_helpful' onclick="getSortedReviews(this);return false;"><?php echo Labels::getLabel('Lbl_Most_Helpful', $siteLangId); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div> -->

    <div class="rating-layout">
        <div class="rating-layout-start">
            <div class="sticky-lg-top">
                <div class="rating-block">
                    <h2 class="title">Customer Reviews</h2>
                    <div class="product-ratings">
                        <i class="icn">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                </use>
                            </svg>
                        </i>
                        <span class="rate">4.3 out of 5.0</span>
                    </div>
                </div>
                <div class="rating-block">
                    <p class="text-muted text-info">1331 Ratings</p>
                    <ul class="progress-block">
                        <li class="progress-block-item">
                            <span class="star">5 Star</span>
                            <progress class="progress" min="0" max="100" value="23" data-rating="5"></progress>
                            <span class="count">23%</span>
                        </li>
                        <li class="progress-block-item">
                            <span class="star">4 Star</span>
                            <progress class="progress" min="0" max="100" value="45" data-rating="4"></progress>
                            <span class="count">45%</span>
                        </li>
                        <li class="progress-block-item">
                            <span class="star">3 Star</span>
                            <progress class="progress" min="0" max="100" value="2" data-rating="3"></progress>
                            <span class="count">2%</span>
                        </li>
                        <li class="progress-block-item">
                            <span class="star">2 Star</span>
                            <progress class="progress" min="0" max="100" value="10" data-rating="2"></progress>
                            <span class="count">10%</span>
                        </li>
                        <li class="progress-block-item">
                            <span class="star">1 Star</span>
                            <progress class="progress" min="0" max="100" value="20" data-rating="1"></progress>
                            <span class="count">20%</span>
                        </li>
                    </ul>
                </div>
                <div class="divider"></div>
                <div class="rating-block">
                    <h5 class="title-sub"> By Category </h5>
                    <ul class="rating-by-category">
                        <li class="rating-by-category-item">
                            <span class="label">
                                Contrast
                            </span>
                            <span class="value">
                                <ul class="star-inline">
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>

                                </ul>

                                <span class="out-of">4.2 /5</span>
                            </span>

                        </li>
                        <li class="rating-by-category-item">
                            <span class="label">
                                Contrast
                            </span>
                            <span class="value">
                                <ul class="star-inline">
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                </ul>

                                <span class="out-of">4.2 /5</span>
                            </span>

                        </li>
                        <li class="rating-by-category-item">
                            <span class="label">
                                Design
                            </span>
                            <span class="value">
                                <ul class="star-inline">
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>

                                </ul>

                                <span class="out-of">4.2 /5</span>
                            </span>

                        </li>
                        <li class="rating-by-category-item">
                            <span class="label">
                                Pigmentation
                            </span>
                            <span class="value">
                                <ul class="star-inline">
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>
                                    <li class="star-inline-item">
                                        <i class="icn">
                                            <svg class="svg" width="11" height="11">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                </use>
                                            </svg>
                                        </i>
                                    </li>

                                </ul>

                                <span class="out-of">4.2 /5</span>
                            </span>

                        </li>

                    </ul>
                </div>
                <div class="divider"></div>
                <div class="rating-block">
                    <div class="review-cta">
                        <h5 class="title-sub">Review this product</h5>
                        <p>Share your thoughts with other customers</p>
                        <button class="btn btn-outline-black btn-block" type="button">
                            Write a Review
                        </button>
                    </div>
                </div>
                <!-- <div class="rating-wrapper">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <div class="products__rating overall-rating-count">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-icon"></use>
                            </svg>
                            <span class="rate"><?php echo round($avgRating, 1); ?><span></span></span>
                        </div>
                        <h6 class="rating-based-on small text-center">
                            <span><?php echo Labels::getLabel('Lbl_Based_on', $siteLangId); ?></span>
                            <strong><?php echo $totReviews ?></strong>
                            <?php echo Labels::getLabel('Lbl_ratings', $siteLangId); ?>
                        </h6>

                    </div>
                    <?php $this->includeTemplate('_partial/product-overall-ratings.php', array('ratingAspects' => $ratingAspects, 'siteLangId' => $siteLangId, 'product_id' => $product_id), false); ?>
                </div>
            </div> -->
            </div>
        </div>
        <div class="rating-layout-end">
            <div class="user-reviews">
                <p class="mb-4"> Reviews with Images</p>
                <div class="review-images">
                    <div class="image">
                        <a href=""><img src="<?php echo CONF_WEBROOT_URL; ?>images/product-thumb.jpg" alt=""></a>
                    </div>
                    <div class="image">
                        <a href=""><img src="<?php echo CONF_WEBROOT_URL; ?>images/product-thumb.jpg" alt=""></a>
                    </div>
                    <div class="image">
                        <a href=""><img src="<?php echo CONF_WEBROOT_URL; ?>images/product-thumb.jpg" alt=""></a>
                    </div>
                    <div class="image">
                        <a href=""><img src="<?php echo CONF_WEBROOT_URL; ?>images/product-thumb.jpg" alt=""></a>
                    </div>
                    <div class="image">
                        <a href=""><img src="<?php echo CONF_WEBROOT_URL; ?>images/product-thumb.jpg" alt=""></a>
                    </div>
                    <div class="image">
                        <a href=""><img src="<?php echo CONF_WEBROOT_URL; ?>images/product-thumb.jpg" alt=""></a>
                    </div>
                    <div class="image">
                        <a href=""><img src="<?php echo CONF_WEBROOT_URL; ?>images/product-thumb.jpg" alt="">
                            <span class="txt-over"> +10</span></a>


                    </div>

                </div>

                <div class="sort-by">
                    <span class="txt-label"> Sort By:</span>
                    <div class="dropdown">
                        <button class="btn btn-outline-gray btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true">
                            <span>Most Recent</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-anim" data-popper-placement="bottom-start">
                            <ul class="drop nav nav-block">
                                <li class="nav__item selected"><a class="dropdown-item nav__link" href="javascript:void(0);" data-sort="most_recent" onclick="getSortedReviews(this);return false;">Most Recent</a>
                                </li>
                                <li class="nav__item selected"><a class="dropdown-item nav__link" href="javascript:void(0);" data-sort="most_helpful" onclick="getSortedReviews(this);return false;">Most Helpful</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="user-reviews-item">
                    <div class="profile-avatar">
                        <div class="profile-dp">
                            <img src="/yokart/image/user/20/thumb/1" alt="Dougals">
                        </div>
                        <div class="profile-bio">
                            <div class="title">By Dougals <span class="dated">On Date 23/12/2020</span>
                            </div>
                        </div>
                    </div>

                    <ul class="rated-by">
                        <li class="rated-by-item">
                            <span class="rated-by-label">Product</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Stock Availability</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>

                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Packaging Quality</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                    </ul>

                    <div class="review-data">
                        <div class="cms">
                            <h6><strong>99.99% Perfect Smartphone !!</strong></h6>
                            <p>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always
                                <br>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always from Apple.

                            </p>
                        </div>

                    </div>
                    <ul class="yes-no">
                        <li>
                            <a class="btn btn-light" href="/yokart/reviews/product-permalink/172/15">Permalink</a>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(15,1);return false;">

                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-up">
                                        </use>
                                    </svg>
                                </i>
                                (10)
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(&quot;15&quot;,0);return false;">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-down">
                                        </use>
                                    </svg>
                                </i>
                                (2)
                            </button>
                        </li>

                    </ul>
                </div>
                <div class="user-reviews-item">
                    <div class="profile-avatar">
                        <div class="profile-dp">
                            <img src="/yokart/image/user/20/thumb/1" alt="Dougals">
                        </div>
                        <div class="profile-bio">
                            <div class="title">By Dougals <span class="dated">On Date 23/12/2020</span>
                            </div>
                        </div>
                    </div>

                    <ul class="rated-by">
                        <li class="rated-by-item">
                            <span class="rated-by-label">Product</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Stock Availability</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>

                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Packaging Quality</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                    </ul>

                    <div class="review-data">
                        <div class="cms">
                            <h6><strong>99.99% Perfect Smartphone !!</strong></h6>
                            <p>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always
                                <br>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always from Apple.

                            </p>
                        </div>

                    </div>
                    <ul class="yes-no">
                        <li>
                            <a class="btn btn-light" href="/yokart/reviews/product-permalink/172/15">Permalink</a>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(15,1);return false;">

                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-up">
                                        </use>
                                    </svg>
                                </i>
                                (10)
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(&quot;15&quot;,0);return false;">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-down">
                                        </use>
                                    </svg>
                                </i>
                                (2)
                            </button>
                        </li>

                    </ul>
                </div>
                <div class="user-reviews-item">
                    <div class="profile-avatar">
                        <div class="profile-dp">
                            <img src="/yokart/image/user/20/thumb/1" alt="Dougals">
                        </div>
                        <div class="profile-bio">
                            <div class="title">By Dougals <span class="dated">On Date 23/12/2020</span>
                            </div>
                        </div>
                    </div>

                    <ul class="rated-by">
                        <li class="rated-by-item">
                            <span class="rated-by-label">Product</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Stock Availability</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>

                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Packaging Quality</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                    </ul>

                    <div class="review-data">
                        <div class="cms">
                            <h6><strong>99.99% Perfect Smartphone !!</strong></h6>
                            <p>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always
                                <br>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always from Apple.

                            </p>
                        </div>

                    </div>
                    <ul class="yes-no">
                        <li>
                            <a class="btn btn-light" href="/yokart/reviews/product-permalink/172/15">Permalink</a>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(15,1);return false;">

                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-up">
                                        </use>
                                    </svg>
                                </i>
                                (10)
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(&quot;15&quot;,0);return false;">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-down">
                                        </use>
                                    </svg>
                                </i>
                                (2)
                            </button>
                        </li>

                    </ul>
                </div>
                <div class="user-reviews-item">
                    <div class="profile-avatar">
                        <div class="profile-dp">
                            <img src="/yokart/image/user/20/thumb/1" alt="Dougals">
                        </div>
                        <div class="profile-bio">
                            <div class="title">By Dougals <span class="dated">On Date 23/12/2020</span>
                            </div>
                        </div>
                    </div>

                    <ul class="rated-by">
                        <li class="rated-by-item">
                            <span class="rated-by-label">Product</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Stock Availability</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>

                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Packaging Quality</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                    </ul>

                    <div class="review-data">
                        <div class="cms">
                            <h6><strong>99.99% Perfect Smartphone !!</strong></h6>
                            <p>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always
                                <br>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always from Apple.

                            </p>
                        </div>

                    </div>
                    <ul class="yes-no">
                        <li>
                            <a class="btn btn-light" href="/yokart/reviews/product-permalink/172/15">Permalink</a>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(15,1);return false;">

                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-up">
                                        </use>
                                    </svg>
                                </i>
                                (10)
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(&quot;15&quot;,0);return false;">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-down">
                                        </use>
                                    </svg>
                                </i>
                                (2)
                            </button>
                        </li>

                    </ul>
                </div>
                <div class="user-reviews-item">
                    <div class="profile-avatar">
                        <div class="profile-dp">
                            <img src="/yokart/image/user/20/thumb/1" alt="Dougals">
                        </div>
                        <div class="profile-bio">
                            <div class="title">By Dougals <span class="dated">On Date 23/12/2020</span>
                            </div>
                        </div>
                    </div>

                    <ul class="rated-by">
                        <li class="rated-by-item">
                            <span class="rated-by-label">Product</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Stock Availability</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>

                        </li>
                        <li class="rated-by-item">

                            <span class="rated-by-label">Packaging Quality</span>
                            <div class="product-ratings">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                        </use>
                                    </svg>
                                </i>
                                <span class="rate">4.2 /5</span>
                            </div>
                        </li>
                    </ul>

                    <div class="review-data">
                        <div class="cms">
                            <h6><strong>99.99% Perfect Smartphone !!</strong></h6>
                            <p>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always
                                <br>

                                Another beauty from Apple. I was upgraded from iPhone X and it was great experience with all the latest specs and flawlessly smooth. Thanks to all new A14 Bionic chip.<br>
                                Build quality was great as always from Apple.

                            </p>
                        </div>

                    </div>
                    <ul class="yes-no">
                        <li>
                            <a class="btn btn-light" href="/yokart/reviews/product-permalink/172/15">Permalink</a>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(15,1);return false;">

                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-up">
                                        </use>
                                    </svg>
                                </i>
                                (10)
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-thumb" type="button" onclick="markReviewHelpful(&quot;15&quot;,0);return false;">
                                <i class="icn">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#hand-thumbs-down">
                                        </use>
                                    </svg>
                                </i>
                                (2)
                            </button>
                        </li>

                    </ul>
                </div>
                <button class="btn btn-outline-black btn-wide" type="button">
                    All 567 Reviews
                </button>
            </div>


            <!-- <div class="listing__all"></div>
            <div id="loadMoreReviewsBtnDiv" class="text-center"></div> -->

        </div>

    </div>



</div>

<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
    $('#itemRatings div.progress__fill').css({
        'clip': 'rect(0px, <?php echo $pixelToFillRight; ?>px, 160px, 0px)'
    });

    $(document).ready(function() {
        function DropDown(el) {
            this.dd = el;
            this.placeholder = this.dd.children('span');
            this.opts = this.dd.find('ul.drop li');
            this.val = '';
            this.index = -1;
            this.initEvents();
        }

        DropDown.prototype = {
            initEvents: function() {
                var obj = this;
                obj.dd.on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).toggleClass('active');
                });
                obj.opts.on('click', function() {
                    var opt = $(this);
                    obj.val = opt.text();
                    obj.index = opt.index();
                    obj.placeholder.text(obj.val);
                    opt.siblings().removeClass('selected');
                    opt.filter(':contains("' + obj.val + '")').addClass('selected');
                }).change();
            },
            getValue: function() {
                return this.val;
            },
            getIndex: function() {
                return this.index;
            }
        };

        $(function() {
            // create new variable for each menu
            var dd1 = new DropDown($('.js-wrap-drop-reviews'));
            $(document).click(function() {
                // close menu on document click
                $('.wrap-drop').removeClass('active');
            });
        });
    });
</script>