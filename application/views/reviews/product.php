<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
    <?php
    echo $frmReviewSearch->getFormHtml();
    $this->includeTemplate('_partial/product-reviews.php', [
        'reviews' => $reviews,
        'ratingAspects' => $ratingAspects,
        'siteLangId' => $siteLangId,
        'product_id' => $product['product_id'],
        'canSubmitFeedback' => $canSubmitFeedback,
        'product' => $product
    ], false);
    ?>
</div>