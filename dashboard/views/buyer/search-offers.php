<?php if (empty($offers)) {
    echo FatUtility::decodeHtmlEntities($noRecordsHtml);
} else { ?>
    <ul class="list-coupons">
        <?php
        foreach ($offers as $row) {
            $discountValue = ($row['coupon_discount_in_percent'] == applicationConstants::PERCENTAGE) ? $row['coupon_discount_value'] . ' %' : CommonHelper::displayMoneyFormat($row['coupon_discount_value']);
            $title = ($row['coupon_title'] == '') ? $row['coupon_identifier'] : $row['coupon_title'];
            $uploadedTime = AttachedFile::setTimeParam($row['coupon_updated_on']);
            $imgUrl =  UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'coupon', array($row['coupon_id'], $siteLangId, ImageDimension::VIEW_NORMAL), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $imageCouponDimensions = ImageDimension::getData(ImageDimension::TYPE_COUPON, ImageDimension::VIEW_NORMAL);

        ?>
            <li class="list-coupons-item">
                <div class="coupon">
                    <div class="coupon__code-img">
                        <div class="coupon__img">
                            <img src="<?php echo $imgUrl; ?>" data-aspect-ratio="<?php echo $imageCouponDimensions[ImageDimension::VIEW_NORMAL]['aspectRatio']; ?>" alt="<?php echo $title; ?>">
                        </div>
                        <span class="coupon__tag">
                            <?php
                            if (strtotime($row['coupon_end_date']) < strtotime(date('Y-m-d'))) {
                                echo Labels::getLabel('LBL_EXPIRED', $siteLangId);
                            } else {
                                echo $row['coupon_code'];
                            }
                            ?>
                        </span>
                    </div>
                    <div class="coupon__detail">
                        <h6>
                            <?php echo $discountValue; ?> <?php echo Labels::getLabel('LBL_OFF', $siteLangId); ?> <span class="coupon__uses-left">
                                <?php echo ($row['coupon_title'] == '') ? $row['coupon_identifier'] : $row['coupon_title']; ?>
                            </span>
                        </h6>
                        <span class="coupon__highlight"><?php echo Labels::getLabel('LBL_MIN_ORDER', $siteLangId); ?> : <?php echo CommonHelper::displayMoneyFormat($row['coupon_min_order_value']); ?></span>
                        <p> <span class="lessText">
                                <?php echo CommonHelper::truncateCharacters($row['coupon_description'], 85, '', '', true);
                                echo (strlen((string)$row['coupon_description'] ?? '') > 85) ? '..' : ''; ?>
                            </span>
                            <?php if (strlen((string)$row['coupon_description'] ?? '') > 85) {
                            ?>
                                <span class="moreText" style="display:none;"><?php echo nl2br($row['coupon_description']); ?></span>
                                <a class="readMore link-text" href="javascript:void(0);"> <?php echo Labels::getLabel('LBL_SHOW_MORE', $siteLangId); ?> </a>
                            <?php } ?>


                        </p>
                        <p class="expiring"><?php echo Labels::getLabel('LBL_EXPIRES_ON', $siteLangId); ?>: <?php echo FatDate::format($row['coupon_end_date']); ?></p>

                        <?php if (isset($row['plans']) && !empty($row['plans'])) { ?>

                            <span class="d-inline-block link-dotted" tabindex="0" data-bs-toggle="popover" data-bs-placement="right" data-bs-trigger="hover focus" data-popover-html="#linkedRecords<?php echo $row['coupon_id']; ?>">
                                <?php echo Labels::getLabel('LBL_LINKED_RECORDS'); ?>
                            </span>
                            <div class="hidden" id="linkedRecords<?php echo $row['coupon_id']; ?>">
                                <?php
                                $i = 0;
                                foreach ($row['plans'] as  $plans) {
                                    if (0 < $i) {
                                        echo '<hr>';
                                    }
                                ?>
                                    <p><strong><?php echo $plans['plan_name']; ?></strong></p>
                                    <ul class="list-stats list-stats-popover">
                                        <?php foreach ($plans['plans'] as $plan) { ?>
                                            <li class="list-stats-item">
                                                <?php echo SellerPackagePlans::getPlanPriceWithPeriod($plan, $plan[SellerPackagePlans::DB_TBL_PREFIX . 'price']); ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php $i++;
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
<?php } ?>