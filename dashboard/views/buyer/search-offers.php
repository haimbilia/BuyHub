<ul class="list-group list-coupons">
    <li class="list-group-item ">
        <div class="coupon">
            <div class="coupon__code-img">
                <div class="coupon__img">
                    <img src="media/coupon-img.png" alt="" data-ratio="1:1">
                </div>
                <span class="coupon__tag">New 20</span>
            </div>
            <div class="coupon__detail">
                <h6>10% Discount to New Customer - <span class="coupon__uses-left">100 uses left</span></h6>
                <span class="coupon__highlight">You saved additional $152</span>
                <p> Flat $100.00 off upto Rs. 100 on minimum purchase of Rs.
                    XXXXX.
                    <br> Expires on Jul 31, 2020 10:00 PM
                </p>
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
    <li class="list-group-item coupon--notused">
        <div class="coupon">
            <div class="coupon__code-img">
                <div class="coupon__img">
                    <img src="media/coupon-img.png" alt="" data-ratio="1:1">
                </div>
                <span class="coupon__tag">Expired</span>
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
        <div class="coupon">
            <div class="coupon__code-img">
                <div class="coupon__img">
                    <img src="media/coupon-img.png" alt="" data-ratio="1:1">
                </div>
                <span class="coupon__tag">New 20</span>
            </div>
            <div class="coupon__detail">
                <h6>10% Discount to New Customer</h6>
                <p> Flat $100.00 off upto Rs. 100 on minimum purchase of Rs.
                    XXXXX. Expires on Jul 31, 2020 10:00 PM</p>
                <a class="link-text" href="#">View Products</a>
            </div>
        </div>
    </li>
</ul>
<?php
if (!empty($offers)) {
    foreach ($offers as $row) {
        $discountValue = ($row['coupon_discount_in_percent'] == ApplicationConstants::PERCENTAGE) ? $row['coupon_discount_value'] . ' %' : CommonHelper::displayMoneyFormat($row['coupon_discount_value']); ?>
        <div class="col-lg-6 mb-4">
            <div class="box--offer">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="offer">
                            <div class="offer__logo">
                                <img src="<?php echo UrlHelper::generateFullUrl('Image', 'coupon', array($row['coupon_id'], $siteLangId, 'NORMAL'), CONF_WEBROOT_FRONTEND) ?>" alt="<?php echo ($row['coupon_title'] == '') ? $row['coupon_identifier'] : $row['coupon_title']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h4><?php echo $discountValue; ?> <?php echo Labels::getLabel('LBL_OFF', $siteLangId); ?></h4>
                        <h6><?php echo ($row['coupon_title'] == '') ? $row['coupon_identifier'] : $row['coupon_title']; ?></h6>
                        <p><span class="lessText"><?php echo CommonHelper::truncateCharacters($row['coupon_description'], 85, '', '', true); ?></span> <?php if (strlen($row['coupon_description']) > 85) {
                                                                                                                                                        ?> <span class="moreText hidden"><?php echo nl2br($row['coupon_description']); ?></span>
                                <a class="readMore link" href="javascript:void(0);"> <?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?> </a>
                        </p> <?php
                                                                                                                                                        } ?> <div class="offer__footer">
                        <div class="offer__grid">
                            <p><?php echo Labels::getLabel('LBL_Expires_On', $siteLangId); ?>: <strong><?php echo FatDate::format($row['coupon_end_date']); ?></strong> <br><?php echo Labels::getLabel('LBL_Min_Order', $siteLangId); ?>:
                                <strong><?php echo CommonHelper::displayMoneyFormat($row['coupon_min_order_value']); ?></strong>
                            </p>
                        </div>
                        <span class="coupon-code"><?php echo $row['coupon_code']; ?></span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
<?php }
} elseif (isset($noRecordsHtml)) {
    echo FatUtility::decodeHtmlEntities($noRecordsHtml);
}
