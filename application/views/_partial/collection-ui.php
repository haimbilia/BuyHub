<?php
$showActionBtns = !empty($showActionBtns) ? $showActionBtns : false;
$isWishList = isset($isWishList) ? $isWishList : 0;
$staticCollectionClass = '';
if ($controllerName = 'Products' && isset($action) && $action == 'view') {
    $staticCollectionClass = 'static--collection';
}
if (!isset($showAddToFavorite)) {
    $showAddToFavorite = true;
    if (UserAuthentication::isUserLogged() && (!User::isBuyer())) {
        $showAddToFavorite = false;
    }
}

if ($showAddToFavorite) {
    if (!isset($includeRibbon) || true === $includeRibbon) {
        $ribSelProdId = $product['selprod_id'];
        $ribProdId = $product['product_id'];
        $ribShopId = $product['shop_id'];
        include (CONF_THEME_PATH . '_partial/get-ribbon.php');
    } ?>

<div class="favourite-wrapper">
    <?php if (true ==  $showActionBtns) { ?>
    <div class="actions_wishlist">
        <ul class="actions">
            <?php if ($product['in_stock'] &&  time() >= strtotime($product['selprod_available_from'])) { ?>
            <li>
                <label class="checkbox">
                    <input type="checkbox" name='selprod_id[]' class="selectItem--js"
                        value="<?php echo $product['selprod_id']; ?>" />

                </label>
            </li>
            <li>
                <a onClick="addToCart( $(this), event , <?php echo $isWishList; ?>);" href="javascript:void(0)" class=""
                    title="<?php echo Labels::getLabel('LBL_Move_to_cart', $siteLangId); ?>"
                    data-id='<?php echo $product['selprod_id']; ?>'><i class="fa fa-shopping-cart"></i></a>
            </li>
            <?php } ?>
            <li>
                <?php if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::YES) { ?>
                <a title='<?php echo Labels::getLabel('LBL_Move_to_trash', $siteLangId); ?>'
                    onclick="removeFromWishlist(<?php echo $product['selprod_id']; ?>, <?php echo $product['uwlp_uwlist_id']; ?>, event);"
                    href="javascript:void(0)" class="">
                    <i class="fa fa-trash"></i>
                </a>
                <?php } else { ?>
                <a title='<?php echo Labels::getLabel('LBL_Move_to_trash', $siteLangId); ?>' href="javascript:void(0)"
                    onclick="removeFromFavorite(<?php echo $product['selprod_id']; ?>, 'searchFavouriteListItems');"
                    data-id="<?php echo $product['selprod_id']; ?>">
                    <i class="fa fa-trash"></i>
                </a>
                <?php } ?>
            </li>
        </ul>
    </div>
    <?php } ?>
    <ul class="actions">
        <?php    if (isset($productView) && true == $productView) {
            if (false ==  $showActionBtns) { ?>
        <li>
            <?php if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
                    $jsFunc = 0 < $product['ufp_id'] ? 'removeFromFavorite(' . $product['selprod_id'] . ')' : 'markAsFavorite(' . $product['selprod_id'] . ')';
                ?>

            <a class="favourite <?php echo ($product['ufp_id']) ? 'is-active' : ''; ?>" onclick="<?php echo $jsFunc; ?>"
                data-id="<?php echo $product['selprod_id']; ?>" href="javascript:void(0)"
                title="<?php echo ($product['ufp_id']) ? Labels::getLabel('LBL_Remove_product_from_favourite_list', $siteLangId) : Labels::getLabel('LBL_Add_Product_to_favourite_list', $siteLangId); ?>">
                <i class="icn">
                    <svg class="svg" width="16px" height="16px">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart">
                        </use>
                    </svg>
                </i>
            </a>

            <?php } else { ?>

            <a class="favourite wishListLink-Js <?php echo ($product['is_in_any_wishlist']) ? 'is-active' : ''; ?>"
                data-id="<?php echo $product['selprod_id']; ?>" href="javascript:void(0)"
                onClick="viewWishList(<?php echo $product['selprod_id']; ?>,this,event);"
                title="<?php echo ($product['is_in_any_wishlist']) ? Labels::getLabel('LBL_Remove_product_from_your_wishlist', $siteLangId) : Labels::getLabel('LBL_Add_Product_to_your_wishlist', $siteLangId); ?>">
                <i class="icn">
                    <svg class="svg" width="16px" height="16px">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart">
                        </use>
                    </svg>
                </i>
            </a>

            <?php } ?>
        </li>
        <?php    } ?>
        <li>
            <a class="" href="javascript:void(0)" data-toggle="modal" data-target="#shareIcon">
                <i class="icn">
                    <svg class="svg" width="16px" height="16px">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share">
                        </use>
                    </svg>
                </i>
            </a>
        </li>
    </ul>
    <div class="modal fade" id="shareIcon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="share-wrap">
                        <h6><?php echo Labels::getLabel('Lbl_Share_this_via', $siteLangId); ?></h6>
                        <ul class="social-sharing">
                            <li class="social-facebook">
                                <a href="javascript:void(0)" class="st-custom-button" data-network="facebook"
                                    data-url="<?php echo UrlHelper::generateFullUrl('Products', 'view', array($product['selprod_id'])); ?>/">
                                    <i class="icn"><svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb"
                                                href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb">
                                            </use>
                                        </svg></i>
                                </a>
                            </li>
                            <li class="social-twitter">
                                <a href="javascript:void(0)" class="st-custom-button" data-network="twitter">
                                    <i class="icn"><svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw"
                                                href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw">
                                            </use>
                                        </svg></i>
                                </a>
                            </li>
                            <li class="social-pintrest">
                                <a href="javascript:void(0)" class="st-custom-button" data-network="pinterest">
                                    <i class="icn"><svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt"
                                                href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt">
                                            </use>
                                        </svg></i>
                                </a>
                            </li>
                            <li class="social-email">
                                <a href="javascript:void(0)" class="st-custom-button" data-network="email">
                                    <i class="icn"><svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope"
                                                href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope">
                                            </use>
                                        </svg>
                                    </i>
                                </a>
                            </li>
                        </ul>
                        <div class="gap"></div>
                        <h6>Or copy link</h6>
                        <div class="clipboard">
                            <span
                                class="clipboard_url">https://dribbble.com/shots/8230931-Game-Share-Modal-w-Color</span>
                            <a class="clipboard_btn" href=""><i class="far fa-copy"></i></a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>
</div>
<?php }
?>

<script>
$('#shareIcon').insertAfter("#body");
</script>