<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php');

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
<main id="main-area" class="main">
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
                    <div class="card-toolbar">
                        <ul>
                            <li title="" data-bs-toggle="tooltip" data-placement="top" data-bs-original-title="">
                                <label class="btn btn-outline-gray   checkbox checkbox-inline select-all">
                                    <input type="checkbox" class="selectAll-js" onclick="selectAll($(this));"> Select all
                                </label>

                            </li>
                            <li title="" data-bs-toggle="tooltip" data-placement="top" data-bs-original-title="">
                                <button class="btn btn-outline-gray btn-icon">
                                    <svg class="svg btn-icon-start" width="18" height="18">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#test">
                                        </use>
                                    </svg>
                                    <span>Cart</span></button>
                            </li>
                            <li title="" data-bs-toggle="tooltip" data-placement="top" data-bs-original-title="">
                                <button class="btn btn-outline-gray btn-icon" onclick="deleteSelected()"><svg class="svg btn-icon-start" width="18" height="18">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-actions.svg#delete">
                                        </use>
                                    </svg>
                                    <span>Delete</span></button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="listingDiv"></div>
                    <div id="loadMoreBtnDiv"></div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    <?php echo $function; ?>;
</script>