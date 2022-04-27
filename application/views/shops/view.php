<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$bgUrl = UrlHelper::generateFullUrl('Image', 'shopBackgroundImage', array($shop['shop_id'], $siteLangId, 0, 0, $template_id));
?>
<div id="body" class="body template-<?php echo $template_id; ?>">
    <?php
    $this->includeTemplate('shops/_breadcrumb.php');
    $userParentId = (isset($userParentId)) ? $userParentId : 0;
    $shopData = array_merge($data, array('template_id' => $template_id, 'action' => $action, 'shopTotalReviews' => $shopTotalReviews, 'shopRating' => $shopRating, 'socialPlatforms' => $socialPlatforms, 'userParentId' => $userParentId, 'showBanner' => ($showBanner ?? false)));
    $this->includeTemplate('shops/templates/' . $template_id . '.php', $shopData, false);
    echo $this->includeTemplate('products/listing-page.php', $shopData, false);
    if (!empty($collectionData)) { ?>
        <section class="section pt-0">
            <div class="container">
                <div class="js-carousel shop-slider" data-slides="3,3,2,2">
                    <?php foreach ($collectionData as $collection) { ?>
                        <div class="item">
                            <img class="" src="<?php echo UrlHelper::generateFileUrl('Image', 'shopCollectionImage', array($collection['scollection_id'], $siteLangId, ImageDimension::VIEW_SHOP)); ?>" alt="" data-ratio="2:1">
                            <div class="overlay-content">
                                <h4><?php echo $collection['scollection_name']; ?></h4>
                                <!--<p>From the runway to your wardrobe</p>-->
                                <a class="link-underline" href="<?php echo UrlHelper::generateUrl('Shops', 'collection', array($shop['shop_id'], $collection['scollection_id'])) ?>">
                                    <?php echo Labels::getLabel('MSG_Explore', $siteLangId) ?></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php }

    echo $this->includeTemplate('_partial/shareThisScript.php'); ?>