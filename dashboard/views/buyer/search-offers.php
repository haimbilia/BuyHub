<?php if (empty($offers)) {
    echo FatUtility::decodeHtmlEntities($noRecordsHtml);
}
?>

<ul class="list-group list-coupons">
    <?php
    foreach ($offers as $row) {
        $discountValue = ($row['coupon_discount_in_percent'] == ApplicationConstants::PERCENTAGE) ? $row['coupon_discount_value'] . ' %' : CommonHelper::displayMoneyFormat($row['coupon_discount_value']);
        $title = ($row['coupon_title'] == '') ? $row['coupon_identifier'] : $row['coupon_title'];
        $uploadedTime = isset($row['coupon_updated_on']) ? AttachedFile::setTimeParam($row['coupon_updated_on']) : '';
        $imgUrl =  UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'coupon', array($row['coupon_id'], $siteLangId, ImageDimension::VIEW_NORMAL), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        $imageCouponDimensions = ImageDimension::getData(ImageDimension::TYPE_COUPON, ImageDimension::VIEW_NORMAL);

    ?>
        <li class="list-group-item ">
            <div class="coupon">
                <div class="coupon__code-img">
                    <div class="coupon__img">
                        <img src="<?php echo $imgUrl; ?>" data-aspect-ratio="<?php echo $imageCouponDimensions[ImageDimension::VIEW_NORMAL]['aspectRatio']; ?>" alt="<?php echo $title; ?>">
                    </div>
                    <span class="coupon__tag">
                        <?php
                        if (strtotime($row['coupon_end_date']) <= strtotime(date('Y-m-d'))) {
                            echo Labels::getLabel('LBL_EXPIRED', $siteLangId);
                        } else {
                            echo $row['coupon_code'];
                        }
                        ?></span>
                </div>
                <div class="coupon__detail">
                    <h6><?php echo $discountValue; ?> <?php echo Labels::getLabel('LBL_OFF', $siteLangId); ?> <span class="coupon__uses-left"><?php echo ($row['coupon_title'] == '') ? $row['coupon_identifier'] : $row['coupon_title']; ?></span></h6>
                    <span class="coupon__highlight"><?php echo Labels::getLabel('LBL_MIN_ORDER', $siteLangId); ?> : <?php echo CommonHelper::displayMoneyFormat($row['coupon_min_order_value']); ?></span>
                    <p> <span class="lessText"><?php echo CommonHelper::truncateCharacters($row['coupon_description'], 85, '', '', true);
                                                echo (strlen($row['coupon_description']) > 85) ? '..' : ''; ?></span>
                        <?php if (strlen($row['coupon_description']) > 85) {
                        ?> <span class="moreText" style="display:none;"><?php echo nl2br($row['coupon_description']); ?></span>
                            <a class="readMore link-text" href="javascript:void(0);"> <?php echo Labels::getLabel('LBL_SHOW_MORE', $siteLangId); ?> </a>
                        <?php } ?>
                        <br> <?php echo Labels::getLabel('LBL_EXPIRES_ON', $siteLangId); ?>: <?php echo FatDate::format($row['coupon_end_date']); ?>
                    </p>
                </div>
            </div>
        </li>
    <?php } ?>
    <?php /* ?> <li class="list-group-item ">
        <div class="coupon coupon--notused">
            <div class="coupon__code-img">
                <div class="coupon__img">
                    <img src="media/coupon-img.png" alt="" data-ratio="1:1">
                </div>
                <span class="coupon__tag">Redeemed</span>
            </div>
            <div class="coupon__detail">
                <h6>10% Discount to New Customer</h6>
                <p> Flat $100.00 off upto Rs. 100 on minimum purchase of Rs.
                    XXXXX. Expires on Jul 31, 2020 10:00 PM</p>
                <a class="link-text" href="#">View Products</a>
            </div>
        </div>
    </li>
    <li class="list-group-item ">
        <div class="coupon coupon--notused">
            <div class="coupon__code-img">
                <div class="coupon__img">
                    <img src="media/coupon-img.png" alt="" data-ratio="1:1">
                </div>
                <span class="coupon__tag">Redeemed</span>
            </div>
            <div class="coupon__detail">
                <h6>10% Discount to New Customer</h6>
                <p> Flat $100.00 off upto Rs. 100 on minimum purchase of Rs.
                    XXXXX. Expires on Jul 31, 2020 10:00 PM</p>
                <a class="link-text" href="#">View Products</a>
            </div>
        </div>
    </li>
    <li class="list-group-item ">
        <div class="coupon coupon--notused">
            <div class="coupon__code-img">
                <div class="coupon__img">
                    <img src="media/coupon-img.png" alt="" data-ratio="1:1">
                </div>
                <span class="coupon__tag">Redeemed</span>
            </div>
            <div class="coupon__detail">
                <h6>10% Discount to New Customer</h6>
                <p> Flat $100.00 off upto Rs. 100 on minimum purchase of Rs.
                    XXXXX. Expires on Jul 31, 2020 10:00 PM</p>
                <a class="link-text" href="#">View Products</a>
            </div>
        </div>
    </li>
    <?php  */ ?>
</ul>