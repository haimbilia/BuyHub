<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
// $frm->setFormTagAttribute('action', UrlHelper::generateUrl('Buyer', 'setupOrderFeedback'));
$frm->setFormTagAttribute('onSubmit', 'setupFeedback(this); return false;');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 8;
$btnSubmit = $frm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
$btnSubmit->setFieldTagAttribute('disabled', "disabled");

$this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <div class="content-header row">
            <div class="col">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Order_Feedback', $siteLangId); ?></h2>
            </div>
        </div>
        <div class="content-body order-feedback-section">
            <div class="card">
                <div class="card-body ">
                    <?php echo $frm->getFormTag(); ?>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h5 class="blocktitle"><?php echo Labels::getLabel('LBL_PRODUCT_FEEDBACK', $siteLangId); ?></h5>
                                <div class="product-card pb-3">
                                    <div class="product-card__img">
                                        <?php
                                        $selProdCodeArr = explode('_', $opDetail['op_selprod_code']);

                                        if ($opDetail['op_is_batch']) {
                                            $prodImg = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'BatchProduct', array($opDetail['op_selprod_id'], $siteLangId, "MEDIUM"), CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
                                        } else {
                                            $prodImg = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($selProdCodeArr[0], "MEDIUM", $opDetail['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
                                        } ?>
                                        <img src="<?php echo $prodImg; ?>" />
                                    </div>
                                    <div class="product-card__detail">
                                        <h6><?php echo (!empty($opDetail['op_selprod_title']) ? $opDetail['op_selprod_title'] : $opDetail['op_product_name']), ' '; ?></h6>
                                    </div>
                                </div>
                                <div class="rating-listing">
                                    <?php foreach ($ratingAspects as $ratingTypeId => $ratingTypeLabel) { 
                                            if (in_array($ratingTypeId, [RatingType::TYPE_SHOP, RatingType::TYPE_DELIVERY])) {
                                                continue;
                                            }
                                        ?>
                                        <div class="rating">
                                            <span class="rating__text"><?php echo $ratingTypeLabel; ?>*</span>
                                            <div class="rating-action" data-rating="0">
                                                <?php for ($i = 5; $i >= 1; $i--) { ?>
                                                    <svg class="icon" width="24" height="24" data-star='<?php echo $i; ?>'>
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                                    </svg>
                                                <?php } ?>
                                            </div>
                                            <?php
                                                $fld = $frm->getField('review_rating[' . $ratingTypeId . ']');
                                                $fld->setFieldTagAttribute('class', 'd-none');
                                                echo $frm->getFieldHtml('review_rating[' . $ratingTypeId . ']'); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field-set">
                                            <div class="caption-wraper">
                                                <label class="field_label">
                                                    <?php echo $frm->getField('spreview_title')->getCaption(); ?>
                                                </label>
                                            </div>
                                            <div class="field-wraper">
                                                <div class="field_cover">
                                                    <?php echo $frm->getFieldHtml('spreview_title'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field-set">
                                            <div class="caption-wraper">
                                                <label class="field_label">
                                                    <?php echo $frm->getField('spreview_description')->getCaption(); ?>
                                                </label>
                                            </div>
                                            <div class="field-wraper">
                                                <div class="field_cover">
                                                    <?php echo $frm->getFieldHtml('spreview_description'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field-set">
                                            <div class="field-wraper">
                                                <div class="field_cover">
                                                    <div class="file__upload">
                                                        <?php 
                                                        $fld = $frm->getField('spreview_image[]');
                                                        $fld->setFieldTagAttribute('multiple', 'multiple');
                                                        $fld->setFieldTagAttribute('class', 'multipleImgs--js');
                                                        echo $frm->getFieldHtml('spreview_image[]'); ?>
                                                        <span class="upload-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path d="M3 4V1h2v3h3v2H5v3H3V6H0V4zm3 6V7h3V4h7l1.83 2H21a2.006 2.006 0 0 1 2 2v12a2.006 2.006 0 0 1-2 2H5a2.006 2.006 0 0 1-2-2V10zm7 9a5 5 0 1 0-5-5 5 5 0 0 0 5 5zm-3.2-5a3.2 3.2 0 1 0 3.2-3.2A3.2 3.2 0 0 0 9.8 14z" data-name="Path 2486"></path>
                                                            </svg>
                                                        </span>
                                                        <span><?php echo Labels::getLabel('LBL_UPLOAD_IMAGES', $siteLangId); ?></span>
                                                    </div>
                                                    <div class='all-review-media mt-2 multipleImgsGallery--js'></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="blocktitle"><?php echo Labels::getLabel('LBL_SELLER_FEEDBACK', $siteLangId); ?></h5>
                                <div class="shop-rating-wrap mb-4">
                                    <div class="shop-card pb-3">
                                        <div class="shop-card__img">
                                            <img src="<?php echo UrlHelper::generateUrl('image', 'shopLogo', array($opDetail['op_shop_id'], $siteLangId, 'SMALL')); ?>" />
                                        </div>
                                        <div class="shop-card__detail">
                                            <h6><?php echo $opDetail['op_shop_name']; ?> </h6>
                                            <span class="shop-opened">
                                                <?php echo Labels::getLabel('LBL_Shop_Opened_On', $siteLangId);
                                                $date = new DateTime($shop['user_regdate']);
                                                echo $date->format('M d, Y'); ?> </span>
                                        </div>
                                    </div>
                                    <div class="rating-listing">
                                        <?php foreach ($shopRatingTypesArr as $ratingTypeId => $ratingTypeLabel) { ?>
                                            <div class="rating">
                                                <span class="rating__text"><?php echo $ratingTypeLabel; ?>*</span>
                                                <div class="rating-action" data-rating="0">
                                                    <?php for ($i = 5; $i >= 1; $i--) { ?>
                                                        <svg class="icon" width="24" height="24" data-star='<?php echo $i; ?>'>
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                                        </svg>
                                                    <?php } ?>
                                                </div>
                                                <?php
                                                    $fld = $frm->getField('review_rating[' . $ratingTypeId . ']');
                                                    $fld->setFieldTagAttribute('class', 'd-none');
                                                    echo $frm->getFieldHtml('review_rating[' . $ratingTypeId . ']'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--shop-rating-wrap-->
                                <h5 class="blocktitle"><?php echo Labels::getLabel('LBL_DELIVERY_FEEDBACK', $siteLangId); ?></h5>
                                <div class="shop-rating-wrap mb-4">
                                    <div class="rating-listing">
                                        <?php foreach ($deliveryRatingTypesArr as $ratingTypeId => $ratingTypeLabel) { ?>
                                            <div class="rating pb-0">
                                                <span class="rating__text"><?php echo $ratingTypeLabel; ?>*</span>
                                                <div class="rating-action" data-rating="0">
                                                    <?php for ($i = 5; $i >= 1; $i--) { ?>
                                                        <svg class="icon" width="24" height="24" data-star='<?php echo $i; ?>'>
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star"></use>
                                                        </svg>
                                                    <?php } ?>
                                                </div>
                                                <?php
                                                    $fld = $frm->getField('review_rating[' . $ratingTypeId . ']');
                                                    $fld->setFieldTagAttribute('class', 'd-none');
                                                    echo $frm->getFieldHtml('review_rating[' . $ratingTypeId . ']'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--Delivery-rating-wrap-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="field-set">
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <label class="mb-3">
                                                <span class="checkbox">
                                                    <?php echo $frm->getFieldHtml('agree'); ?>
                                                </span>
                                            </label>
                                            <?php 
                                                echo $frm->getFieldHtml('op_id'); 
                                                echo $frm->getFieldHtml('referrer'); 
                                                echo $frm->getFieldHtml('btn_submit'); 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php echo $frm->getExternalJS(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.rating-action svg', function() {
            var parent = $(this).closest('.rating-action');
            var star = $(this).data('star');
            parent.attr('data-rating', star);
            parent.siblings('select').val(star);
        });

        $("input[name='agree']").change(function() {
            if (this.checked) {
                $("input[name='btn_submit']").removeAttr('disabled');
            } else {
                $("input[name='btn_submit']").attr('disabled', 'disabled');
            }
        });
    });
</script>