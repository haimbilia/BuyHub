<?php if (isset($shop)) { ?>
<div class="shop-information">
    <div class="shop-logo">
        <?php
                $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_SHOP_LOGO, $shop['shop_id'], 0, 0, false);
                $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                ?>
        <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?>
            data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?>
            src="<?php echo UrlHelper::generateUrl('image', 'shopLogo', array($shop['shop_id'], $siteLangId, 'SMALL')); ?>"
            alt="<?php echo $shop['shop_name']; ?>">
    </div>

    <div class="shop-info">
        <div class="shop-name">
            <h5>
                <?php echo $shop['shop_name']; ?>
                <span class="blk-txt"><?php echo Labels::getLabel('LBL_Shop_Opened_On', $siteLangId); ?> <strong>
                        <?php $date = new DateTime($shop['user_regdate']);
                        echo $date->format('M d, Y'); ?>
                    </strong></span>
            </h5>
            <?php if (0 < FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
            <div class="products__rating"> <i class="icn"><svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"
                            href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                    </svg></i> <span class="rate"><?php echo round($shopRating, 1), ' ', Labels::getLabel('Lbl_Out_of', $siteLangId), ' ', '5';
                                                                if ($shopTotalReviews) { ?>
                    - <a
                        href="<?php echo UrlHelper::generateUrl('Reviews', 'shop', array($shop['shop_id'])); ?>"><?php echo $shopTotalReviews, ' ', Labels::getLabel('Lbl_Reviews', $siteLangId); ?></a>
                    <?php } ?> </span>
            </div>
            <?php } ?>
            <?php 
                        $bdgShopId = $shop['shop_id'];
                        $bdgExcludeCndType = [BadgeLinkCondition::COND_TYPE_AVG_RATING_SELPROD];
                        include (CONF_THEME_PATH . '_partial/get-badge.php'); 
                    ?>
        </div>

        
            <div class="shop-btn-group">
                <a class="share-icon" href="javascript:void(0)"  data-toggle="modal" data-target="#shareIcon">
                    <i class="icn" title="<?php echo Labels::getLabel('Lbl_Share', $siteLangId); ?>">
                        <svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share"
                             href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share"></use>
                        </svg>
                    </i>
                </a>
            <?php $showAddToFavorite = true;
                    if (UserAuthentication::isUserLogged() && (!User::isBuyer())) {
                        $showAddToFavorite = false;
                    }
                    ?>
            <?php if ($showAddToFavorite) { ?>
            <a href="javascript:void(0)"
                title="<?php echo ($shop['is_favorite']) ? Labels::getLabel('Lbl_Unfavorite_Shop', $siteLangId) : Labels::getLabel('Lbl_Favorite_Shop', $siteLangId); ?>"
                onclick="toggleShopFavorite(<?php echo $shop['shop_id']; ?>);"
                class="btn btn-brand btn-sm <?php echo ($shop['is_favorite']) ? 'is-active' : ''; ?>"
                id="shop_<?php echo $shop['shop_id']; ?>"><i class="icn"><svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart"
                            href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart"></use>
                    </svg></i></a>
            <?php } ?>
            <?php $showMoreButtons = true;
                    if (isset($userParentId) && $userParentId == $shop['shop_user_id']) {
                        $showMoreButtons = false;
                    } ?>
            <?php if ($showMoreButtons) {
                        $shopRepData = ShopReport::getReportDetail($shop['shop_id'], UserAuthentication::getLoggedUserId(true), 'sreport_id');
                        if (false === UserAuthentication::isUserLogged() || empty($shopRepData)) { ?>
            <a href="<?php echo UrlHelper::generateUrl('Shops', 'ReportSpam', array($shop['shop_id'])); ?>"
                title="<?php echo Labels::getLabel('Lbl_Report_Spam', $siteLangId); ?>" class="btn btn-brand btn-sm"><i
                    class="icn"><svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#report"
                            href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#report"></use>
                    </svg></i></a>
            <?php } ?>
            <?php if (!UserAuthentication::isUserLogged() || (UserAuthentication::isUserLogged() && ((User::isBuyer()) || (User::isSeller())))) { ?>
            <a href="<?php echo UrlHelper::generateUrl('shops', 'sendMessage', array($shop['shop_id'])); ?>"
                title="<?php echo Labels::getLabel('Lbl_Send_Message', $siteLangId); ?>" class="btn btn-brand btn-sm"><i
                    class="icn"><svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#send-msg"
                            href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#send-msg"></use>
                    </svg></i></a>
            <?php } ?>
            <?php } ?>
        </div>
        <?php if ($socialPlatforms) { ?>
        <div class="contact-social">
            <h5><strong><?php echo Labels::getLabel('LBL_Follow_Us', $siteLangId); ?></strong> </h5>

            <ul class="">
                <?php foreach ($socialPlatforms as $row) { ?>
                <li>
                    <a <?php if ($row['splatform_url'] != '') { ?> target="_blank" <?php } ?>
                        href="<?php echo ($row['splatform_url'] != '') ? $row['splatform_url'] : 'javascript:void(0)'; ?>">
                        <span class="icon-1">
                            <i class="fab fa-<?php echo $row['splatform_icon_class']; ?>"></i>
                        </span><span class="icon-2">
                            <i class="fab fa-<?php echo $row['splatform_icon_class']; ?>"></i>
                        </span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
<div class="modal fade" id="shareIcon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo Labels::getLabel('Lbl_Share', $siteLangId); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="" >
            <ul class="social-sharing">
                <li class="social-facebook">
                    <a class="social-link st-custom-button" data-network="facebook"
                       data-url="<?php echo UrlHelper::generateFullUrl('Shops', 'view', array($shop['shop_id'])); ?>/">
                        <i class="icn"><svg class="svg">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb"
                                 href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb"></use>
                            </svg></i>
                    </a>
                </li>
                <li class="social-twitter">
                    <a class="social-link st-custom-button" data-network="twitter">
                        <i class="icn"><svg class="svg">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw"
                                 href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw"></use>
                            </svg></i>
                    </a>
                </li>
                <li class="social-pintrest">
                    <a class="social-link st-custom-button" data-network="pinterest">
                        <i class="icn"><svg class="svg">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt"
                                 href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt"></use>
                            </svg></i>
                    </a>
                </li>
                <li class="social-email">
                    <a class="social-link st-custom-button" data-network="email">
                        <i class="icn"><svg class="svg">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope"
                                 href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope">
                            </use>
                            </svg></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
       </div>
  </div>
</div>   

<script>
    $('#shareIcon').insertAfter("#body");
</script>
        


