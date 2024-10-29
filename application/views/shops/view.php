<?php defined('SYSTEM_INIT') or die('Invalid Usage');
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
                <header class="section-head">
                    <div class="section-heading">
                        <h2><?php echo Labels::getLabel('LBL_SHOP_COLLECTIONS'); ?></h2>
                    </div>
                    <div class="section-action">
                        <div class="slider-controls">
                            <button class="btn btn-prev" type="button" data-href="#shop-collection-listing"
                                aria-label="Previous"> <span></span>
                            </button>
                            <button class="btn btn-next" type="button" data-href="#shop-collection-listing"
                                aria-label="Next"> <span></span>
                            </button>
                        </div>
                    </div>
                </header>
                <div class="section-body">
                    <div class="js-carousel shop-slider" id="shop-collection-listing" data-slides="3,3,2,2">
                        <?php foreach ($collectionData as $collection) { ?>
                            <div class="js-carousel-item">
                                <div class="shop-slider-item">
                                    <img class=""
                                        src="<?php echo UrlHelper::generateFileUrl('Image', 'shopCollectionImage', array($collection['scollection_id'], $siteLangId, ImageDimension::VIEW_SHOP)); ?>"
                                        <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_SHOP_COLLECTION_IMAGE, ImageDimension::VIEW_SHOP); ?>>
                                    <div class="overlay-content">
                                        <h4><?php echo $collection['scollection_name']; ?></h4>
                                        <!--<p>From the runway to your wardrobe</p>-->
                                        <a class="link-underline"
                                            href="<?php echo UrlHelper::generateUrl('Shops', 'collection', array($shop['shop_id'], $collection['scollection_id'])) ?>">
                                            <?php echo Labels::getLabel('MSG_Explore', $siteLangId) ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php }

    echo $this->includeTemplate('_partial/shareThisScript.php'); ?>