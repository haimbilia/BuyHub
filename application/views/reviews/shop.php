<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$bgUrl = UrlHelper::generateFullUrl('Image', 'shopBackgroundImage', array($shop['shop_id'], $siteLangId, 0, 0, $template_id));
$haveBannerImage = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_SHOP_BANNER, $shop['shop_id'], '', $siteLangId);
$shopPolicyArr = array(
    'shop_payment_policy',
    'shop_delivery_policy',
    'shop_refund_policy',
    'shop_additional_info',
    'shop_seller_info',
);
?>

<div id="body" class="body template-<?php echo $template_id; ?>">
    <?php
    $this->includeTemplate('shops/_breadcrumb.php');
    $userParentId = (isset($userParentId)) ? $userParentId : 0;
    $variables = array('shop' => $shop, 'siteLangId' => $siteLangId, 'template_id' => $template_id, 'collectionData' => $collectionData, 'action' => $action, 'shopRating' => $shopRating, 'shopTotalReviews' => $shopTotalReviews, 'socialPlatforms' => $socialPlatforms, 'userParentId' => $userParentId);
    $this->includeTemplate('shops/templates/' . $template_id . '.php', $variables, false);
    echo $frmReviewSearch->getFormHtml();
    ?>
    <section class="section">
        <div class="container" id="itemRatings">
            <!--
                        <div class="section__body">
                            <?php //$this->includeTemplate('_partial/shop-reviews.php', array('reviews' => $reviews, 'shop_rating' => $shopRating, 'ratingAspects' => $ratingAspects, 'siteLangId' => $siteLangId, 'shop_id' => $shop['shop_id']), false); 
                            ?>
                        </div> -->

            <?php
            $totReviews = 0;
            $avgRating = 0;

            $productView = true;
            if (is_array($reviews) && 0 < count($reviews)) {
                $totReviews = FatUtility::int($reviews['totReviews']);
                $avgRating = $reviews['avg_seller_rating'];
            }

            ?>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="customer-reviews">
                        <?php if (true === $productView) { ?>
                            <div class="customer-reviews-head">
                                <h2 class="title"><?php echo Labels::getLabel('LBL_CUSTOMER_REVIEWS', $siteLangId); ?></h2>
                                <?php if ($totReviews > 0) { ?>
                                    <div class="">
                                        <div class="sort-by" title="<?php echo Labels::getLabel("LBL_SORT_BY", $siteLangId); ?>" data-bs-toggle="tooltip">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle-custom btn btn-outline-gray btn-dropdown sort-by-btn" type="button" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sortByTxtJs"><?php echo Labels::getLabel('LBL_MOST_RECENT', $siteLangId); ?></span>
                                                    <i class="dropdown-toggle-custom-arrow"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-anim">
                                                    <ul class="drop nav nav-block">
                                                        <li class="nav__item">
                                                            <a class="dropdown-item nav__link sortByEleJs active" href="javascript:void(0);" data-sort='most_recent' onclick="getSortedReviews(this);return false;">
                                                                <?php echo Labels::getLabel('LBL_MOST_RECENT', $siteLangId); ?>
                                                            </a>
                                                        </li>
                                                        <li class="nav__item">
                                                            <a class="dropdown-item nav__link sortByEleJs" href="javascript:void(0);" data-sort='most_helpful' onclick="getSortedReviews(this);return false;">
                                                                <?php echo Labels::getLabel('LBL_MOST_HELPFUL', $siteLangId); ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="customer-reviews-body">
                            <div class="rating-layout">
                                <!-- Rating Section -->
                                <div class="rating-layout-start">
                                    <div class="sticky-lg-top">
                                        <div class="rating-block">
                                            <div class="average-rating">
                                                <span class="rate"><?php echo round($avgRating, 1); ?>
                                                    <svg class="svg" width="16" height="16">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                        </use>
                                                    </svg>
                                                </span>
                                                <span class="totals"><?php echo $totReviews . ' ' . Labels::getLabel("LBL_REVIEWS", $siteLangId); ?></span>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <?php
                                        $this->includeTemplate('_partial/product-overall-ratings.php', [
                                            'reviews' => $reviews,
                                            'ratingAspects' => $ratingAspects,
                                            'siteLangId' => $siteLangId,
                                            'canSubmitFeedback' => false,
                                        ], false);
                                        ?>
                                    </div>
                                </div>
                                <!-- Rating Section -->

                                <!-- Comments Section -->
                                <div class="rating-layout-end reviewListJs"></div>
                                <div id="loadMoreReviewsBtnDiv" class="align-center">

                                </div>
                                <!-- Comments Section -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="gap"></div>
</div>
<?php echo $this->includeTemplate('_partial/shareThisScript.php'); ?>
<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>