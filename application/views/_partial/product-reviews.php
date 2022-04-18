<?php defined('SYSTEM_INIT') or die('Invalid usage');
$totReviews = $avgRating  = $pixelToFillRight = 0;
if (!empty($reviews)) {
    $totReviews = (!empty($reviews['totReviews'])) ? FatUtility::int($reviews['totReviews']) : 0;
    $avgRating = (!empty($reviews['prod_rating'])) ? FatUtility::convertToType($reviews['prod_rating'], FatUtility::VAR_FLOAT) : 0;

    $pixelToFillRight = $avgRating / 5 * 160;
    $pixelToFillRight = FatUtility::convertToType($pixelToFillRight, FatUtility::VAR_FLOAT);
}

$productView = $productView ?? false;
?>
<section class="section">
    <div class="container" id="itemRatings">
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
                                <div class="sticky-top">
                                    <div class="product-card">
                                        <?php if (false === $productView && !empty($product)) { ?>
                                            <div class="product-card-start">
                                                <div class="product-card-img">                                                
                                                    <img alt="<?php echo $product['product_name']; ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_SMALL, $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg'); ?>">
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="product-card-end">

                                            <?php
                                            if (!empty($product) && !$productView) { ?>
                                                <div class="product-description">
                                                    <?php include(CONF_THEME_PATH . 'products/product-info.php'); ?>
                                                </div>

                                            <?php } ?>


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
                                        </div>
                                    </div>


                                    <div class="divider"></div>
                                    <?php
                                    $this->includeTemplate('_partial/product-overall-ratings.php', [
                                        'reviews' => $reviews,
                                        'ratingAspects' => $ratingAspects,
                                        'siteLangId' => $siteLangId,
                                        'canSubmitFeedback' => $canSubmitFeedback,
                                        'product_id' => $product_id,
                                    ], false);
                                    ?>
                                </div>
                            </div>
                            <!-- Rating Section -->

                            <!-- Comments Section -->
                            <div class="rating-layout-end reviewListJs"></div>
                            <div id="loadMoreReviewsBtnDiv" class="align-center"></div>
                            <!-- Comments Section -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
    $('#itemRatings div.progress__fill').css({
        'clip': 'rect(0px, <?php echo $pixelToFillRight; ?>px, 160px, 0px)'
    });

    $(function() {
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

        // create new variable for each menu
        var dd1 = new DropDown($('.js-wrap-drop-reviews'));
        $(document).on('click', function() {
            // close menu on document click
            $('.wrap-drop').removeClass('active');
        });
    });
</script>