<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-lg-';
$frm->developerTags['fld_default_col'] = 4;
$frm->setFormTagAttribute('id', 'rfqJs');
$frm->setFormTagAttribute('data-onclear', 'requestForQuoteFn(' . $selprodId . ')');
$frm->setFormTagAttribute('onsubmit', 'saveRfq($("#rfqJs")); return(false);');

$fld = $frm->getField('rfq_quantity');
$fld->addFieldTagAttribute('class', 'form-control rfqQtyJs');

$fld = $frm->getField('rfq_quantity_unit');
$fld->addFieldTagAttribute('class', 'form-select ');
$fld = $frm->getField('rfq_description');
$fld->addFieldTagAttribute('class', 'form-textarea');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_COMMENTS_FOR_SELLER*'));
$fld->htmlAfterField = '<a class="btn btn-attachment attachmentJs" >
                            <input class="attachment-file rfqDocumentJs" type="file" name="document" >
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.svg#attachment">
                                </use>
                            </svg>' . Labels::getLabel('LBL_Add_ATTACHMENT') . '
                        </a><div class="text-break rfqFileNameJs"></div>';
$fld->developerTags['col'] = 12;

$fld = $frm->getField('rfq_addr_id');
$fld->addFieldTagAttribute('class', 'addrIdJs');
$fld->requirement->setRequired(true);

$fld = $frm->getField('rfq_delivery_date');
$fld->addFieldTagAttribute('placeholder', 'YYYY-MM-DD');
$fld->addFieldTagAttribute('class', 'rfqDeliveryDateJs form-control');

if (!$isUserLogged) {
    $fld = $frm->getField('user_name');
    $fld->addFieldTagAttribute('class', 'form-control');
    $fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_NAME', $siteLangId));


    $fld = $frm->getField('user_email');
    $fld->addFieldTagAttribute('class', 'form-control');
    $fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_USERNAME_OR_EMAIL', $siteLangId));

    $fld = $frm->getField('user_phone');
    $fld->addFieldTagAttribute('class', 'form-control phoneNumberJs');
    $fld->addFieldTagAttribute('data-parent-attrs', json_encode([
        'class' => 'phonenumber--js from-group--phonefield'
    ]));
} ?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_REQUEST_A_QUOTE'); ?></h5>
</div>
<div class="modal-body form-edit">
    <?php
    echo $frm->getFormTag();
    echo $frm->getFieldHtml('rfq_product_id');
    echo $frm->getFieldHtml('rfq_addr_id');
    echo $frm->getFieldHtml('rfq_selprod_id');
    ?>
    <div class="request-quote">
        <?php if (!$isUserLogged) { ?>
            <div class="request-quote__body">
                <div class="g-checkout-form">
                    <h6 class="h6">
                        <strong>
                            <?php echo Labels::getLabel('LBL_PLEASE_FILL_IN_THE_DETAILS_TO_PROCEED_WITH_RFQ_GUEST_CHECKOUT.'); ?>
                        </strong>
                    </h6>
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $frm->getFieldHtml('user_name'); ?>
                        </div>
                        <div class="col-lg-6">
                            <?php echo $frm->getFieldHtml('user_email'); ?>
                        </div>
                        <div class="col-lg-6">
                            <?php echo $frm->getFieldHtml('user_phone'); ?>
                        </div>
                    </div>

                </div>
            </div>
        <?php
        } ?>
        <div class="request-quote__head">
            <div class="quote">
                <?php if (1 > FatApp::getConfig('CONF_HIDE_SELLER_INFO', FatUtility::VAR_INT, 0) && RequestForQuote::TYPE_INDIVIDUAL == FatApp::getConfig('CONF_RFQ_MODULE_TYPE', FatUtility::VAR_INT, 0)) { ?>
                    <div class="quote-to">
                        <span class="label"><?php echo Labels::getLabel('LBL_TO:'); ?></span>
                        <div class="avatar">
                            <div class="avatar-media">
                                <?php
                                $userImgUpdatedOn = User::getAttributesById($selprodData['shop_user_id'], 'user_updated_on');
                                $uploadedTime = AttachedFile::setTimeParam($userImgUpdatedOn);
                                $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_USER_PROFILE_IMAGE, $selprodData['shop_user_id']);
                                $profileImg = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'user', array($selprodData['shop_user_id'], ImageDimension::VIEW_THUMB, true), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                ?>
                                <img src="<?php echo $profileImg; ?>" alt="<?php echo $selprodData['shop_user_name']; ?>">
                            </div>
                            <div class="avatar-detail">
                                <span class="title"><?php echo $selprodData['shop_user_name']; ?></span>
                            </div>
                        </div>
                        <div class="quote-shop">
                            <div class="shop-name"><?php echo $selprodData['shop_name']; ?></div>
                            <?php if (0 < $shopRating || 0 < $totReviews) { ?>
                                <div class="reviews">
                                    <?php if (0 < $shopRating) { ?>
                                        <div class="rating">
                                            <div class="rating-count"><?php echo round($shopRating, 1); ?></div>
                                            <div class="rating-stars">
                                                <svg class="star svg" width="16" height="16">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                                    </use>
                                                </svg>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if (0 < $totReviews) { ?>
                                        <div class="reviews-count">
                                            <?php echo '(' . $totReviews . ' ' . Labels::getLabel("LBL_REVIEWS", $siteLangId) . ')'; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="quote-for">
                    <div class="product-profile">
                        <div class="product-profile-thumbnail">
                            <?php
                            $productTitle = $selprodData['selprod_title'];
                            $uploadedTime = AttachedFile::setTimeParam($selprodData['selprod_updated_on']);
                            $prodUrl = UrlHelper::generateUrl('Products', 'view', array($selprodId), CONF_WEBROOT_FRONTEND);
                            $imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($selprodData['selprod_product_id'], ImageDimension::VIEW_SMALL, $selprodId, 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                            
                            $options = SellerProduct::getSellerProductOptions($selprodId, true, $siteLangId);
                            if (!empty($options)) {
                                $options = implode(' | ', array_column($options, 'optionvalue_name'));
                            }
                            ?>
                            <a class="" href="<?php echo $prodUrl; ?>">
                                <img src="<?php echo $imgSrc; ?>" <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_SMALL); ?> title="<?php echo $productTitle; ?>" alt="<?php echo $productTitle; ?>">
                            </a>
                        </div>

                        <div class="product-profile-data">
                            <a class="title" href="<?php echo $prodUrl; ?>">
                                <?php echo $productTitle . (!empty($options) ? ' | ' . $options : ''); ?>
                            </a>
                            <div class="product-profile-category">
                                <?php echo $selprodData['brand_name']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="quote-for-qty">
                        <div class="qty-wrap">
                            <span class="label"><?php echo Labels::getLabel('LBL_REQUIRED_QUANTITY'); ?></span>
                            <span><?php echo $frm->getFieldHtml('rfq_quantity'); ?></span>
                            <span><?php echo $frm->getFieldHtml('rfq_quantity_unit'); ?></span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="request-quote__body">
            <?php if (count($optionRows) > 0) { ?>
                <div class="accordion-group">
                    <div class="accordion-group__head" data-bs-toggle="collapse" data-bs-target="#variants" aria-expanded="false" aria-controls="">
                        <h6><?php echo Labels::getLabel('LBL_Product_variants'); ?></h6>
                        <p>
                            <?php echo Labels::getLabel('LBL_YOU_CAN_FILL_IN_THE_FOLLOWING_PRODUCT_ATTRIBUTES_TO_GET_A_QUOTATION_FROM_THE_SELLER_WITHIN_24_HOURS'); ?>
                        </p>
                    </div>

                    <div class="accordion-group__body  collapse" id="variants">
                        <div class="row g-2">
                            <?php foreach ($optionRows as $optionsList) { ?>
                                <div class="col-xl-6">
                                    <div class="form-group form-floating">
                                        <select class="form-control" name="selprod_variants" onchange="requestForQuoteFn(this.value);">
                                            <?php
                                            foreach ($optionsList['values'] as $optVals) {
                                            ?>
                                                <option <?php echo (in_array($optVals['optionvalue_id'], $selectedOptions)) ? 'selected' : ''; ?> value=" <?php echo $optVals['selprod_id']; ?>"><?php echo $optVals['optionvalue_name']; ?> </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label class="form-floating-label"><?php echo $optionsList['option_name']; ?> </label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                </div>
            <?php } ?>
            <div class="accordion-group">
                <div class="accordion-group__head descHeadJs" data-bs-toggle="collapse" data-bs-target="#detailed" aria-expanded="true" aria-controls="">
                    <h6>
                        <?php echo Labels::getLabel('LBL_DETAILED_REQUIREMENTS_*'); ?>
                    </h6>
                    <p>
                        <?php echo Labels::getLabel('LBL_QUOTE_DETAILED_DESCRIPTION'); ?>
                    </p>
                </div>
                <div class="accordion-group__body  descBodyJs collapse show" id="detailed">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="field-set">
                                    <div class="caption-wraper d-flex justify-content-between align-items-center">
                                        <label class="field_label">
                                            <?php

                                            $fld = $frm->getField('rfq_delivery_date');
                                            echo $fld->getCaption(); ?>
                                        </label>
                                    </div>
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <?php
                                            echo $frm->getFieldHtml('rfq_delivery_date');

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="field-set">
                                    <div class="caption-wraper d-flex justify-content-between align-items-center">
                                        <label class="field_label">
                                            <?php echo Labels::getLabel('LBL_DELIVERY_ADDRESS'); ?><span class="spn_must_field">*</span>
                                        </label>
                                        <a class="link-brand link-underline" onclick="addAddress(<?php echo $selprodId; ?>);">
                                            <?php echo Labels::getLabel('LBL_ADD_NEW'); ?>
                                        </a>
                                    </div>
                                    <div class="field-wraper">
                                        <?php $formId = $frm->getFormTagAttribute('id'); ?>
                                        <div class="field_cover addressSectionJs" data-form-id="<?php echo $formId ?>">
                                            <?php if ($addresses) {
                                                require CONF_THEME_PATH . 'addresses/address-element.php';
                                            } else { ?>
                                                <small class="color-light mb-2 mt-2 d-block">
                                                    <?php echo Labels::getLabel("LBL_YOU_HAVN'T_ADDED_DELIVERY_ADDRESS_YET", $siteLangId); ?>
                                                </small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <?php
                                echo $frm->getFieldHtml('rfq_description');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo '</form>' . $frm->getExternalJs(); ?>
</div>
<div class="modal-footer">
    <div class="buttons-group">
        <button class="btn btn-outline-gray" type="button" onclick="$.ykmodal.close();"><?php echo Labels::getLabel('LBL_CLOSE'); ?></button>
        <button class="btn btn-brand btn-wide submitBtnJs" type="submit" form="<?php echo $frm->getFormTagAttribute('id'); ?>">
            <?php echo Labels::getLabel('LBL_SUBMIT'); ?>
        </button>
    </div>
</div>