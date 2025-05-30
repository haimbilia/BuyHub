<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($arrListing) && is_array($arrListing)) {
    foreach ($arrListing as $sn => $row) {
        $discountValue = ($row['coupon_discount_in_percent'] == applicationConstants::PERCENTAGE) ? $row['coupon_discount_value'] . ' %' : CommonHelper::displayMoneyFormat($row['coupon_discount_value']);

        $title = ($row['coupon_title'] == '') ? $row['coupon_identifier'] : $row['coupon_title'];
        $uploadedTime = AttachedFile::setTimeParam($row['coupon_updated_on']);
        $imgUrl =  UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'coupon', array($row['coupon_id'], $siteLangId, ImageDimension::VIEW_NORMAL), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        ?>
        <div class="col-md-6">
            <div class="box--offer">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="offer">
                            <div class="offer__logo"><img src="<?php echo $imgUrl; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_COUPON, ImageDimension::VIEW_NORMAL); ?>></div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h4><?php echo $discountValue; ?> <?php echo Labels::getLabel('LBL_OFF', $siteLangId); ?></h4>
                        <h6><?php echo $title; ?></h6>
                        <p><span class="lessText"><?php echo CommonHelper::truncateCharacters($row['coupon_description'], 85, '', '', true); ?></span>
                            <?php if (strlen((string)$row['coupon_description']) > 85) { ?>
                                <span class="moreText" hidden><?php echo nl2br($row['coupon_description']); ?></span>
                                <a class="readMore link-underline" href="javascript:void(0);"> <?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?> </a>
                        </p>
                    <?php } ?>
                    <div class="offer__footer">
                        <div class="offer__grid">
                            <p><?php echo Labels::getLabel('LBL_Expires_On', $siteLangId); ?>: <strong><?php echo FatDate::format($row['coupon_end_date']); ?></strong> <br><?php echo Labels::getLabel('LBL_Min_Order', $siteLangId); ?>: <strong><?php echo CommonHelper::displayMoneyFormat($row['coupon_min_order_value']); ?></strong></p>
                        </div>
                        <span class="coupon-code"><?php echo $row['coupon_code']; ?></span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
<?php }
} else {
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId), false);
} ?>
<div id="loadMoreBtnDiv"></div>
<?php
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmCouponSrchPaging')); ?>
<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>