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
    $this->includeTemplate('_partial/shop-reviews.php', [
        'reviews' => $reviews,
        'ratingAspects' => $ratingAspects,
        'siteLangId' => $siteLangId,   
        'shopView' => true,  
    ], false);
    ?>       
    <div class="gap"></div>
</div>
<?php echo $this->includeTemplate('_partial/shareThisScript.php'); ?>
<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>