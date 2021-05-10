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

if ($showAddToFavorite) { ?>
    <div class="favourite-wrapper <?php /* echo $staticCollectionClass; */ ?>">
        <?php if (true ==  $showActionBtns) { ?>
            <div class="actions_wishlist">
                <ul class="actions">
                    <?php if ($product['in_stock'] &&  time() >= strtotime($product['selprod_available_from'])) { ?>
                        <li>
                            <label class="checkbox">
                                <input type="checkbox" name='selprod_id[]' class="selectItem--js" value="<?php echo $product['selprod_id']; ?>" />
                                <i class="input-helper"></i>
                            </label>
                        </li>
                        <li>
                            <a onClick="addToCart( $(this), event , <?php echo $isWishList; ?>);" href="javascript:void(0)" class="" title="<?php echo Labels::getLabel('LBL_Move_to_cart', $siteLangId); ?>" data-id='<?php echo $product['selprod_id']; ?>'><i class="fa fa-shopping-cart"></i></a>
                        </li>
                    <?php } ?>
                    <li>
                        <?php if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::YES) { ?>
                            <a title='<?php echo Labels::getLabel('LBL_Move_to_trash', $siteLangId); ?>' onclick="removeFromWishlist(<?php echo $product['selprod_id']; ?>, <?php echo $product['uwlp_uwlist_id']; ?>, event);" href="javascript:void(0)" class="">
                                <i class="fa fa-trash"></i>
                            </a>
                        <?php } else { ?>
                            <a title='<?php echo Labels::getLabel('LBL_Move_to_trash', $siteLangId); ?>' href="javascript:void(0)" onclick="removeFromFavorite(<?php echo $product['selprod_id']; ?>, 'searchFavouriteListItems');" data-id="<?php echo $product['selprod_id']; ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        <?php
            }
            if (isset($productView) && true == $productView) { ?>
            <?php if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
                    $jsFunc = 0 < $product['ufp_id'] ? 'removeFromFavorite(' . $product['selprod_id'] . ')' : 'markAsFavorite(' . $product['selprod_id'] . ')';
            ?>
                <div class="favourite heart-wrapper <?php echo ($product['ufp_id']) ? 'is-active' : ''; ?>" onclick="<?php echo $jsFunc; ?>" data-id="<?php echo $product['selprod_id']; ?>">
                    <a href="javascript:void(0)" title="<?php echo ($product['ufp_id']) ? Labels::getLabel('LBL_Remove_product_from_favourite_list', $siteLangId) : Labels::getLabel('LBL_Add_Product_to_favourite_list', $siteLangId); ?>">
                        <div class="ring"></div>
                        <div class="circles"></div>
                    </a>
                </div>
            <?php } else { ?>
                <div class="favourite heart-wrapper wishListLink-Js <?php echo ($product['is_in_any_wishlist']) ? 'is-active' : ''; ?>" data-id="<?php echo $product['selprod_id']; ?>">
                    <a href="javascript:void(0)" onClick="viewWishList(<?php echo $product['selprod_id']; ?>,this,event);" title="<?php echo ($product['is_in_any_wishlist']) ? Labels::getLabel('LBL_Remove_product_from_your_wishlist', $siteLangId) : Labels::getLabel('LBL_Add_Product_to_your_wishlist', $siteLangId); ?>">
                        <div class="ring"></div>
                        <div class="circles"></div>
                    </a>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php }
