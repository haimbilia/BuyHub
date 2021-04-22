<?php defined('SYSTEM_INIT') or die('Invalid usage'); ?>
<div class="col-md-8">
    <div class="listing--progress-wrapper ">
        <ul class="listing--progress">
            <?php foreach ($ratingAspects as $rating) {
                    $ratingValue = CommonHelper::numberFormat($rating['prod_rating'], false, true, 1);
                    $width = round(FatUtility::convertToType($ratingValue / 5 * 100, FatUtility::VAR_FLOAT), 2);
                    $label = Labels::getLabel('LBL_{RATING}_RATING_OUT_OF_5_FOR_{NAME}', $siteLangId);
                    $label = CommonHelper::replaceStringData($label, [
                        '{RATING}' => $ratingValue,
                        '{NAME}' => $rating['ratingtype_name'],
                    ]);
                ?>
                <li>
                    <div class="progress">
                        <span class="progress__lbl"><?php echo $rating['ratingtype_name'];?></span>                
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
