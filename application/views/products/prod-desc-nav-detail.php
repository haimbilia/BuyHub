<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$youtube_embed_code = UrlHelper::parseYoutubeUrl($product["product_youtube_video"]); ?>

<!-- Don't remove scrollUpTo-js span -->
<span id="scrollUpTo-js"></span>
<div class="nav-detail nav-detail-js">
    <ul>
        <?php if (Product::PRODUCT_TYPE_DIGITAL == $product['product_type']) { ?>
            <li>
                <a class="nav-scroll-js is-active" href="#specifications">
                    <?php echo Labels::getLabel('LBL_FILES', $siteLangId); ?>
                </a>
            </li>
        <?php } ?>
        <?php if (count($productSpecifications) > 0) { ?>
            <li><a class="nav-scroll-js is-active" href="#specifications"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?></a>
            </li>
        <?php } ?>
        <?php if (trim($product['product_description']) != '') { ?>
            <li class=""><a class="nav-scroll-js" href="#description"><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?> </a>
            </li>
        <?php } ?>
        <?php if ($youtube_embed_code) { ?>
            <li class=""><a class="nav-scroll-js" href="#video"><?php echo Labels::getLabel('LBL_Video', $siteLangId); ?>
                </a></li>
        <?php } ?>
        <?php if ($shop['shop_payment_policy'] != '' || !empty($shop["shop_delivery_policy"] != "") || !empty($shop["shop_delivery_policy"] != "")) { ?>
            <li class=""><a class="nav-scroll-js" href="#shop-policies"><?php echo Labels::getLabel('LBL_Shop_Policies', $siteLangId); ?> </a>
            </li>
        <?php } ?>
        <?php if (!empty($product['selprodComments'])) { ?>
            <li class=""><a class="nav-scroll-js" href="#extra-comments"><?php echo Labels::getLabel('LBL_Extra_comments', $siteLangId); ?>
                </a>
            </li>
        <?php } ?>
        <?php if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
            <li class=""><a class="nav-scroll-js" href="#itemRatings"><?php echo Labels::getLabel('LBL_Ratings_and_Reviews', $siteLangId); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-xl-7">
            <?php if (Product::PRODUCT_TYPE_DIGITAL == $product['product_type']) { ?>
                <?php $this->includeTemplate('_partial/product/dd-preview-list.php', array('siteLangId' => $siteLangId, 'product' => $product), false); ?>
            <?php } ?>
            <?php if (count($productSpecifications) > 0) { ?>
                <div class="detail-content">
                    <div class="section-head">
                        <div class="section__heading" id="specifications">
                            <h2><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?></h2>
                        </div>
                    </div>
                    <div class="cms bg-gray p-4 mb-4">
                        <table>
                            <tbody>
                                <?php foreach ($productSpecifications as $key => $specification) { ?>
                                    <tr>
                                        <th><?php echo $specification['prodspec_name'] . ":"; ?></th>
                                        <td><?php echo html_entity_decode($specification['prodspec_value'], ENT_QUOTES, 'utf-8'); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
            <?php if (trim($product['product_description']) != '') { ?>
                <div class="detail-content">
                    <div class="section-head">
                        <div class="section__heading" id="description">
                            <h2><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?></h2>
                        </div>
                    </div>
                    <div class="cms bg-gray p-4 mb-4">
                        <p><?php echo CommonHelper::renderHtml($product['product_description']); ?></p>
                    </div>
                </div>
            <?php } ?>
            <?php if ($youtube_embed_code) { ?>
                <div class="detail-content">
                    <div class="section-head">
                        <div class="section__heading" id="video">
                            <h2><?php echo Labels::getLabel('LBL_Video', $siteLangId); ?></h2>
                        </div>
                    </div>
                    <?php if ($youtube_embed_code != "") { ?>
                        <div class="mb-4 video-wrapper">
                            <iframe width="100%" height="315" src="//www.youtube.com/embed/<?php echo $youtube_embed_code ?>" allowfullscreen></iframe>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($shop['shop_payment_policy'] != '' || !empty($shop["shop_delivery_policy"] != "") || !empty($shop["shop_delivery_policy"] != "")) { ?>
                <div class="detail-content">
                    <div class="section-head">
                        <div class="section__heading" id="shop-policies">
                            <h2><?php echo Labels::getLabel('LBL_Shop_Policies', $siteLangId); ?></h2>
                        </div>
                    </div>
                    <div class="cms bg-gray p-4 mb-4">
                        <?php if ($shop['shop_payment_policy'] != '') { ?>
                            <h6><?php echo Labels::getLabel('LBL_Payment_Policy', $siteLangId) ?></h6>
                            <p><?php echo nl2br($shop['shop_payment_policy']); ?></p>
                            <br>
                        <?php } ?>
                        <?php if ($shop['shop_delivery_policy'] != '') { ?>
                            <h6><?php echo Labels::getLabel('LBL_Delivery_Policy', $siteLangId) ?></h6>
                            <p><?php echo nl2br($shop['shop_delivery_policy']); ?></p>
                            <br>
                        <?php } ?>
                        <?php if ($shop['shop_refund_policy'] != '') { ?>
                            <h6><?php echo Labels::getLabel('LBL_Refund_Policy', $siteLangId) ?></h6>
                            <p><?php echo nl2br($shop['shop_refund_policy']); ?></p>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($product['selprodComments'])) { ?>
                <div class="detail-content">
                    <div class="section-head">
                        <div class="section__heading" id="extra-comments">
                            <h2><?php echo Labels::getLabel('LBL_Extra_comments', $siteLangId); ?></h2>
                        </div>
                    </div>
                    <div class="cms bg-gray p-4 mb-4">
                        <p><?php echo CommonHelper::displayNotApplicable($siteLangId, nl2br($product['selprodComments'])); ?>
                        </p>
                    </div>
                </div>
            <?php } ?>
            <?php if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
                <div id="itemRatings">
                    <?php 
                        echo $frmReviewSearch->getFormHtml(); 
                        
                        $this->includeTemplate('_partial/product-reviews.php', array('reviews' => $reviews, 'ratingAspects' => $ratingAspects, 'siteLangId' => $siteLangId, 'product_id' => $product['product_id'], 'canSubmitFeedback' => $canSubmitFeedback), false); 
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>