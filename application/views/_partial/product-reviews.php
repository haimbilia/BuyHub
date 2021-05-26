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
    <div class="section-head">
        <div class="section__heading">
            <h2><?php echo Labels::getLabel('LBl_Rating_&_Reviews', $siteLangId); ?></h2>
        </div>
        <div class="section__action">
            <?php if ($canSubmitFeedback || $totReviews > 0) { ?>
            <div class="row">
                <?php if ($canSubmitFeedback) { ?>
                <div class="col-auto <?php echo ($totReviews > 0) ? 'col-auto' : ''; ?>">
                    <a onClick="rateAndReviewProduct(<?php echo $product_id; ?>)" href="javascript:void(0)"
                        class="btn btn-brand btn-sm <?php echo ($totReviews > 0) ? 'btn-block' : ''; ?>"><?php echo Labels::getLabel('Lbl_Add_Review', $siteLangId); ?></a>
                </div>
                <?php } ?>
                <?php if ($totReviews > 0) { ?>
                <div class="col <?php echo ($canSubmitFeedback) ? '' : ''; ?>">
                    <div class="dropdown">
                        <button class="btn btn-outline-gray  btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                            data-display="static" aria-haspopup="true" aria-expanded="false">
                            <span><?php echo Labels::getLabel('Lbl_Most_Recent', $siteLangId); ?></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-anim">
                            <ul class="drop nav nav-block">
                                <li class="nav__item selected"><a class="dropdown-item nav__link"
                                        href="javascript:void(0);" data-sort='most_recent'
                                        onclick="getSortedReviews(this);return false;"><?php echo Labels::getLabel('Lbl_Most_Recent', $siteLangId); ?></a>
                                </li>
                                <li class="nav__item selected"><a class="dropdown-item nav__link"
                                        href="javascript:void(0);" data-sort='most_helpful'
                                        onclick="getSortedReviews(this);return false;"><?php echo Labels::getLabel('Lbl_Most_Helpful', $siteLangId); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>


    <div class="rating-wrapper">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-4">
                <div class="products__rating overall-rating-count">
                    <svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-icon"
                            href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-icon"></use>
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
    </div>
</div>

<div class="listing__all"></div>
<div id="loadMoreReviewsBtnDiv" class="text-center"></div>

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