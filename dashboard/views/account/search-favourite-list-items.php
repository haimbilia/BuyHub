<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="content-body" id="listingDiv">
    <div class="card card-tabs">
        <div class="card-head">
            <nav class="nav nav-tabs">
                <a class="nav-link active navLinkJs favtProductsJs" onclick="searchFavouriteListItems()" href="javascript:void(0);" id="tab-wishlist">
                    <?php echo Labels::getLabel("LBL_PRODUCTS", $siteLangId); ?>
                </a>
                <a class="nav-link navLinkJs favtShopsJs" onclick="searchFavoriteShop();" href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Shops', $siteLangId); ?></a>
            </nav>

            <div class="card-toolbar">
                <?php $this->includeTemplate('account/wishListItemsActions.php', array('isWishList' => false, 'siteLangId' => $siteLangId, 'products' => $products)); ?>
            </div>
        </div>
        <div class="card-body">
            <form method="post" name="favtlistForm" id="favtlistForm">
                <?php require_once(CONF_THEME_PATH . 'products/products-list.php');  ?>
            </form>
        </div>
    </div>
</div>