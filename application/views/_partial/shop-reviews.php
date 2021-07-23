<?php defined('SYSTEM_INIT') or die('Invalid usage');
/* reviews processing */

$totReviews = 0;
if (is_array($reviews) && 0 < count($reviews)) {
	$totReviews = FatUtility::int($reviews['totReviews']);
}

$pixelToFillRight = $shop_rating / 5 * 160;
$pixelToFillRight = FatUtility::convertToType($pixelToFillRight, FatUtility::VAR_FLOAT);

?>
<div class="rating-wrapper">
	<div class="row align-items-center">
		<div class="col-md-4 column">
			<div class="products__rating overall-rating-count">
				<svg class="svg">
					<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-icon" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-icon"></use>
				</svg>
				<span class="rate"><?php echo CommonHelper::numberFormat($shop_rating, false, true, 1); ?></span>
			</div>
			<h6 class="rating-based-on small text-center">
				<span><?php echo Labels::getLabel('Lbl_Based_on', $siteLangId); ?></span>
				<strong><?php echo $totReviews ?></strong>
				<?php echo Labels::getLabel('Lbl_ratings', $siteLangId); ?>
			</h6>
		</div>
		<div class="col-md-8 column">
			<div class="listing--progress-wrapper">
				<ul class="listing--progress">
					<?php
                                        foreach ($ratingAspects as $rating) {
						$ratingValue = CommonHelper::numberFormat($rating['prod_rating'], false, true, 1);
						$width = round(FatUtility::convertToType( (float) $ratingValue / 5 * 100, FatUtility::VAR_FLOAT), 2);
						$label = Labels::getLabel('LBL_{RATING}_RATING_OUT_OF_5_FOR_{NAME}', $siteLangId);
						$label = CommonHelper::replaceStringData($label, [
							'{RATING}' => $ratingValue,
							'{NAME}' => $rating['ratingtype_name'],
						]);
					?>
						<li>
							<div class="progress">
								<span class="progress__lbl"><?php echo $rating['ratingtype_name']; ?></span>
								<div class="progress__bar">
									<div title="<?php echo $label; ?>" style="width: <?php echo $width; ?>%" class="progress__fill"></div>
								</div>
								<span class="progress__count"><?php echo $ratingValue; ?></span>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<?php
		/* <div class="col-md-4 border--left">
		<h4><?php echo Labels::getLabel('Lbl_Share_your_thoughts',$siteLangId); ?></h4>
		<h6><?php echo Labels::getLabel('Lbl_With_other_customers',$siteLangId); ?></h6>
		<a class="btn btn-brand btn--h-large" href="<?php echo UrlHelper::generateUrl('Reviews','write',array($shop_id)); ?>"><?php echo Labels::getLabel('Lbl_Write_a_Review',$siteLangId); ?></a>
	</div> */
		?>

	</div>
</div>
<div class="listings__body">

	<div class="row">
		<div class="col-md-6 col-sm-6"><span id='reviews-pagination-strip--js' hidden><?php echo Labels::getLabel('Lbl_Displaying_Reviews', $siteLangId); ?> <span id='reviewStartIndex'>XX</span>-<span id='reviewEndIndex'>XX</span> <?php echo Labels::getLabel('Lbl_of', $siteLangId); ?> <span id='reviewsTotal'>XX</span></span></div>
	</div>
	<div class="row mt-5">
		<div class="col-md-6 mb-3 mb-md-0">
			<a href="javascript:void(0);" class="btn btn-brand d-block" data-sort='most_recent' onclick="getSortedReviews(this);return false;"><?php echo Labels::getLabel('Lbl_Most_Recent', $siteLangId); ?></a>
		</div>
		<div class="col-md-6">
			<a href="javascript:void(0);" class="btn btn-secondary d-block" data-sort='most_helpful' onclick="getSortedReviews(this);return false;"><?php echo Labels::getLabel('Lbl_Most_Helpful', $siteLangId); ?> </a>
		</div>
	</div>
	<div class="gap"></div>
	<div class="listing__all"></div>
	<div id="loadMoreReviewsBtnDiv" class="text-center"></div>
	<!--<a class="loadmore text--uppercase" href="javascript:alert('Pending');">Load More</a>-->

</div>
<script>
	var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
	var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>