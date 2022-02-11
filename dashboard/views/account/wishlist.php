<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php');

$isWishList = (0 < FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1));

$label = Labels::getLabel("LBL_FAVORITES", $siteLangId);
$function = 'searchFavouriteListItems()';
if ($isWishList) {
    $label = Labels::getLabel("LBL_WISHLIST", $siteLangId);
    $function = 'searchWishList()';
}
?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => $label,
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body" id="listingDiv">
        <div class="card card-tabs">
            <div class="card-head">
                <nav class="nav nav-tabs">
                    <a class="nav-link active navLinkJs favtProductsJs" onClick="<?php echo $function; ?>" href="javascript:void(0);" id="tab-wishlist">
                        <?php echo Labels::getLabel("LBL_PRODUCTS", $siteLangId); ?>
                    </a>
                    <a class="nav-link navLinkJs favtShopsJs" onClick="searchFavoriteShop();" href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Shops', $siteLangId); ?></a>
                </nav>
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body"></div>
        </div>
    </div>
</div>
<script>
    <?php echo $function; ?>;
</script>