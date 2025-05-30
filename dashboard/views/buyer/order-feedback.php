<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form ');
// $frm->setFormTagAttribute('action', UrlHelper::generateUrl('Buyer', 'setupOrderFeedback'));
$frm->setFormTagAttribute('onSubmit', 'setupFeedback(this); return false;');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 8;
$btnSubmit = $frm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
$btnSubmit->setFieldTagAttribute('disabled', "disabled");
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php
            $data = [
                'headingLabel' => Labels::getLabel('LBL_Order_Feedback', $siteLangId),
                'siteLangId' => $siteLangId,
            ];
            $this->includeTemplate('_partial/header/content-header.php', $data); ?>
            <div class="content-body">
                <div class="card">
                    <div class="card-body p-0">
                        <?php echo $frm->getFormTag(); ?>
                        <div class="order-feedback-section">
                            <div class="feedback-block">
                                <h5 class="card-title ">
                                    <?php echo Labels::getLabel('LBL_PRODUCT_FEEDBACK', $siteLangId); ?></h5>
                                <div class="feedback-block_content">
                                    <div class="product-profile mb-3">
                                        <div class="product-profile__pic ">
                                            <?php
                                            $prodTitle =  (!empty($opDetail['op_selprod_title']) ? $opDetail['op_selprod_title'] : $opDetail['op_product_name']);

                                            $selProdCodeArr = explode('_', $opDetail['op_selprod_code']);
                                            if ($opDetail['op_is_batch']) {
                                                $prodImg = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'BatchProduct', array($opDetail['op_selprod_id'], $siteLangId, ImageDimension::VIEW_MEDIUM), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                                            } else {
                                                $prodImg = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($selProdCodeArr[0], ImageDimension::VIEW_MEDIUM, $opDetail['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                                            } ?>
                                            <a href="<?php echo UrlHelper::generateUrl('products', 'view', array($opDetail['op_selprod_id']), CONF_WEBROOT_FRONTEND) ?>">
                                                <img <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_MEDIUM); ?> src="<?php echo $prodImg; ?>" alt="<?php echo $prodTitle; ?>" title="<?php echo $prodTitle; ?>">
                                            </a>
                                        </div>
                                        <div class="product-profile__description">
                                            <div class="item__category"><a href="<?php echo UrlHelper::generateUrl('shops', 'view', array($opDetail['op_shop_id'])); ?>"><?php echo $opDetail['op_shop_name']; ?></a></div>
                                            <div class="product-profile__title"><a title="<?php echo $prodTitle; ?>" href="<?php echo UrlHelper::generateUrl('products', 'view', array($opDetail['op_selprod_id']), CONF_WEBROOT_FRONTEND) ?>"><?php echo $prodTitle; ?></a>
                                            </div>
                                            <div class="product-profile__specification"> <?php echo $opDetail['op_selprod_options']; ?> </div>
                                        </div>
                                    </div>
                                    <div class="rating-listing rating-listing-column">
                                        <?php foreach ($selProdRating as $ratingTypeId => $ratingTypeLabel) { ?>
                                            <div class="rating rating-f">
                                                <span class="rating__text"><?php echo $ratingTypeLabel; ?>*</span>
                                                <?php
                                                $fld = $frm->getField('review_rating[' . $ratingTypeId . ']');
                                                $fld->setFieldTagAttribute('class', 'd-none star-rating');
                                                echo $frm->getFieldHtml('review_rating[' . $ratingTypeId . ']'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <?php echo $frm->getField('spreview_title')->getCaption(); ?>
                                                </label>
                                                <?php echo $frm->getFieldHtml('spreview_title'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <?php echo $frm->getField('spreview_description')->getCaption(); ?>
                                                </label>
                                                <?php echo $frm->getFieldHtml('spreview_description'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
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
                                                <div class='uploaded-media multipleImgsGallery--js'>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <?php if (!empty($shopRatingTypesArr) || !empty($deliveryRatingTypesArr)) { ?>

                                <?php if (!empty($shopRatingTypesArr)) { ?>
                                    <div class="feedback-block">
                                        <h5 class="card-title ">
                                            <?php echo Labels::getLabel('LBL_SELLER_FEEDBACK', $siteLangId); ?></h5>
                                        <div class="feedback-block_content">
                                            <div class="shop-rating-wrap">
                                                <div class="shop-card">
                                                    <div class="shop-card__img">
                                                        <img width="48" height="48" src="<?php echo UrlHelper::generateFileUrl('image', 'shopLogo', array($opDetail['op_shop_id'], $siteLangId, ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONTEND); ?>" />
                                                    </div>
                                                    <div class="shop-card__detail">
                                                        <h6><?php echo $opDetail['op_shop_name']; ?> </h6>
                                                        <span class="shop-opened">
                                                            <?php echo Labels::getLabel('LBL_Shop_Opened_On', $siteLangId);
                                                            $date = new DateTime($shop['user_regdate']);
                                                            echo $date->format('M d, Y'); ?> </span>
                                                    </div>
                                                </div>
                                                <div class="rating-listing rating-listing-column">
                                                    <?php foreach ($shopRatingTypesArr as $ratingTypeId => $ratingTypeLabel) { ?>
                                                        <div class="rating rating-f">
                                                            <?php
                                                            $fld = $frm->getField('review_rating[' . $ratingTypeId . ']');
                                                            $fld->setFieldTagAttribute('class', 'd-none star-rating');
                                                            echo $frm->getFieldHtml('review_rating[' . $ratingTypeId . ']'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--shop-rating-wrap-->
                                    <div class="divider"></div>
                                <?php }

                                if (!empty($deliveryRatingTypesArr)) { ?>
                                    <div class="feedback-block">
                                        <h5 class="card-title ">
                                            <?php echo Labels::getLabel('LBL_DELIVERY_FEEDBACK', $siteLangId); ?>
                                        </h5>
                                        <div class="feedback-block_content">
                                            <div class="shop-rating-wrap">
                                                <div class="rating-listing">

                                                    <div class="rating-listing rating-listing-column">
                                                        <?php foreach ($deliveryRatingTypesArr as $ratingTypeId => $ratingTypeLabel) { ?>
                                                            <div class="rating rating-f pb-0">
                                                                <?php
                                                                $fld = $frm->getField('review_rating[' . $ratingTypeId . ']');
                                                                $fld->setFieldTagAttribute('class', 'd-none star-rating');
                                                                echo $frm->getFieldHtml('review_rating[' . $ratingTypeId . ']'); ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Delivery-rating-wrap-->
                                <?php } ?>
                            <?php } ?>
                            <div class="feedback-block">
                                <div class="form-group">
                                    <?php
                                    $fld = $frm->getField('agree');
                                    $fld->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
                                    echo $frm->getFieldHtml('agree');
                                    ?>
                                </div>
                                <?php
                                echo $frm->getFieldHtml('op_id');
                                echo $frm->getFieldHtml('referrer');
                                echo $frm->getFieldHtml('btn_submit');
                                ?>

                            </div>
                        </div>
                        </form>
                        <?php echo $frm->getExternalJS(); ?>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

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

        $('.star-rating').barrating({
            showSelectedRating: false
        });
    });
</script>