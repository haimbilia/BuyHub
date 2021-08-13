<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$bgUrl = UrlHelper::generateFullUrl('Image', 'shopBackgroundImage', array($shop['shop_id'],$siteLangId,0,0,$template_id));
$haveBannerImage = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_SHOP_BANNER, $shop['shop_id'], '', $siteLangId);
$shopPolicyArr = array(
    'shop_payment_policy',
    'shop_delivery_policy',
    'shop_refund_policy',
    'shop_additional_info',
    'shop_seller_info',
);
?>

<div id="body" class="body template-<?php echo $template_id;?>"   >
    <?php
        $variables = array('shop' => $shop, 'siteLangId' => $siteLangId, 'template_id' => $template_id, 'collectionData' => $collectionData, 'action' => $action, 'shopRating' => $shopRating, 'shopTotalReviews' => $shopTotalReviews, 'socialPlatforms' => $socialPlatforms, 'userParentId' => $userParentId);
        $this->includeTemplate('shops/templates/'.$template_id.'.php', $variables, false);
    ?>
    <section class="section">      
<div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div id="itemRatings">
                        <div class="section__head">
                            <h4><?php echo Labels::getLabel('Lbl_Reviews_for', $siteLangId) . ' ' . $shop['shop_name']; ?></h4>
                            <?php echo $frmReviewSearch->getFormHtml(); ?>
                        </div>
                        <div class="section__body">
                            <?php $this->includeTemplate('_partial/shop-reviews.php', array('reviews' => $reviews, 'shop_rating' => $shopRating, 'ratingAspects' => $ratingAspects, 'siteLangId' => $siteLangId, 'shop_id' => $shop['shop_id']), false); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="gap"></div>
    </div>
    <?php echo $this->includeTemplate('_partial/shareThisScript.php'); ?>
    <script type="text/javascript">
    (function($){    
    if(langLbl.layoutDirection == 'rtl'){
        $('.shops-sliders').slick({
            dots: false,
            arrows:true,
            autoplay:true,
            rtl:true,
            pauseOnHover:false,
            speed: 500,
    fade: true,
    cssEase: 'linear',
        });
    }
    else
    {
        $('.shops-sliders').slick({
        dots: false,
        arrows:true,
        autoplay:true,
        pauseOnHover:false,
        speed: 500,
    fade: true,
    cssEase: 'linear',
        });
    }
    })(jQuery);
    </script>
