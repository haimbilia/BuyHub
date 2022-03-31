<?php
defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
    <?php   
    echo $frmReviewSearch->getFormHtml();
    $this->includeTemplate('_partial/shop-reviews.php', [
        'reviews' => $reviews,
        'ratingAspects' => $ratingAspects,
        'siteLangId' => $siteLangId,       
        'shop' => $shop,
        'shopView' => false,
    ], false);
    ?>
</div>
<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>