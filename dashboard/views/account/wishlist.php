<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php', ['isUserDashboard' => $isUserDashboard]);

$label = Labels::getLabel("LBL_FAVORITES", $siteLangId);
if (0 < FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1)) {
    $label = Labels::getLabel("LBL_WISHLIST", $siteLangId);
}
if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
    $function = 'viewFavouriteItems()';
} else {
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
        <div class="content-body">
            <div class="card card-tabs">
                <div class="card-head">
                    <nav class="nav nav-tabs">
                        <a class="nav-link active" onClick="<?php echo $function; ?>" href="javascript:void(0);" id="tab-wishlist">
                            <?php echo $label; ?>
                        </a>
                        <a class="nav-link" onClick="searchFavoriteShop();" href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Shops', $siteLangId); ?></a>
                    </nav>
                </div>
                <div class="card-body">
                    <div id="listingDiv"></div>
                    <div id="loadMoreBtnDiv"></div>
                </div>
            </div>
        </div>
    </div>

<script>
    <?php echo $function; ?>;
</script>