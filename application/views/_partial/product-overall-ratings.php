<?php defined('SYSTEM_INIT') or die('Invalid usage');
/* reviews processing */
$totReviews = 0 ;
$rate_5_width = $rate_4_width = $rate_3_width = $rate_2_width = $rate_1_width = 0;
if (!empty($reviews)) {
    $totReviews = (!empty($reviews['totReviews'])) ? FatUtility::int($reviews['totReviews']) : 0;
    
    if ($totReviews) {
        $rated_1 = FatUtility::int($reviews['rated_1']);
        $rated_2 = FatUtility::int($reviews['rated_2']);
        $rated_3 = FatUtility::int($reviews['rated_3']);
        $rated_4 = FatUtility::int($reviews['rated_4']);
        $rated_5 = FatUtility::int($reviews['rated_5']);

        $rate_5_width = round(FatUtility::convertToType($rated_5 / $totReviews * 100, FatUtility::VAR_FLOAT), 2);
        $rate_4_width = round(FatUtility::convertToType($rated_4 / $totReviews * 100, FatUtility::VAR_FLOAT), 2);
        $rate_3_width = round(FatUtility::convertToType($rated_3 / $totReviews * 100, FatUtility::VAR_FLOAT), 2);
        $rate_2_width = round(FatUtility::convertToType($rated_2 / $totReviews * 100, FatUtility::VAR_FLOAT), 2);
        $rate_1_width = round(FatUtility::convertToType($rated_1 / $totReviews * 100, FatUtility::VAR_FLOAT), 2);
    }
}
?>
<div class="col-md-8">
    <div class="listing--progress-wrapper ">
        <ul class="listing--progress">
            <li>
                <div class="progress">
                    <span class="progress__lbl">Shipping</span>                
                    <div class="progress__bar">
                        <div title="<?php echo $rate_5_width,'% ',Labels::getLabel('LBL_Number_of_reviews_have_5_stars', $siteLangId); ?>" style="width: <?php echo $rate_5_width; ?>%" class="progress__fill"></div>
                    </div>
                    <span class="progress__count">3 </span>
                </div>
            </li>
            <li>
                <div class="progress">
                    <span class="progress__lbl">Stock Availability</span>                
                    <div class="progress__bar">
                        <div title="<?php echo $rate_4_width,'% ',Labels::getLabel('LBL_Number_of_reviews_have_4_stars', $siteLangId); ?>" style="width: <?php echo $rate_4_width; ?>%" class="progress__fill"></div>
                    </div>
                    <span class="progress__count">4</span>
                </div>
            </li>
            <li>
                <div class="progress">
                        <span class="progress__lbl">Delivery time</span>                
                        <div class="progress__bar">
                            <div title="<?php echo $rate_3_width,'% ',Labels::getLabel('LBL_Number_of_reviews_have_3_stars', $siteLangId); ?>" style="width: <?php echo $rate_3_width; ?>%" class="progress__fill"></div>
                        </div>
                        <span class="progress__count">5 </span>
                </div>
            </li>
            <li>
                 <div class="progress">
                    <span class="progress__lbl">Package Quality</span>                 
                    <div class="progress__bar">
                        <div title="<?php echo $rate_2_width,'% ',Labels::getLabel('LBL_Number_of_reviews_have_2_stars', $siteLangId); ?>" style="width: <?php echo $rate_2_width; ?>%" class="progress__fill"></div>
                    </div>
                    <span class="progress__count">2 </span>
                </div>
            </li>
            
        </ul>
    </div>
</div>
