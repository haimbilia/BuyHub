<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Custom_Product_Request', $siteLangId),
        'siteLangId' => $siteLangId,
        'otherButtons' => [
            [
                'attr' => [
                    'href' => UrlHelper::generateUrl('SellerRequests'),
                    'title' => Labels::getLabel('LBL_Back_to_Product_Requests', $siteLangId),
                ],
                'label' => Labels::getLabel('LBL_Back_to_Product_Requests', $siteLangId),
            ],
        ]
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="d-flex">
            <nav class="nav nav-tabs navTabsJs">
                <a class="nav-link tabs_001" rel="tabs_001" href="javascript:void(0)">
                    <?php echo Labels::getLabel('LBL_Initial_Setup', $siteLangId); ?> <i class="tabs-icon fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Setup_Basic_Details', $siteLangId); ?>">
                    </i>
                </a>
                <a class="nav-link tabs_002" rel="tabs_002" href="javascript:void(0)">
                    <?php echo Labels::getLabel('LBL_Attribute_&_Specifications', $siteLangId); ?>
                    <i class="tabs-icon fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Add_Attribute_&_Specifications', $siteLangId); ?>"></i></a>

                <a class="nav-link tabs_003" rel="tabs_003" href="javascript:void(0)">
                    <?php echo Labels::getLabel('LBL_Options_And_Tags', $siteLangId); ?>
                    <i class="tabs-icon fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Add_Options_And_Tags', $siteLangId); ?>"></i>

                </a>

                <a class="nav-link tabs_004" rel="tabs_004" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Shipping_Information', $siteLangId); ?>
                    <i class="tabs-icon fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Setup_Dimentions_And_Shipping_Information', $siteLangId); ?>"></i>

                </a>
                <a class="nav-link tabs_005" rel="tabs_005" href="javascript:void(0)"> <?php echo Labels::getLabel('LBL_Media', $siteLangId); ?>
                    <i class="tabs-icon fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Add_Option_Based_Media', $siteLangId); ?>"></i>

                </a>
                <a class="nav-link tabs_006" rel="tabs_006" href="javascript:void(0)">
                    <?php echo Labels::getLabel('LBL_Downloads', $siteLangId); ?>
                    <i class="tabs-icon fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Add_Catalog_Inventory_Based_Downloads', $siteLangId); ?>"></i>
                </a>
            </nav>
            <div class="col-auto js-approval-btn"></div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="tabs__content">
                    <div id="tabs_001" class="tabs_panel" style="display: block;"></div>
                    <div id="tabs_002" class="tabs_panel" style="display: none;"> </div>
                    <div id="tabs_003" class="tabs_panel" style="display: none;"></div>
                    <div id="tabs_004" class="tabs_panel" style="display: none;"></div>
                    <div id="tabs_005" class="tabs_panel" style="display: none;"></div>
                    <div id="tabs_006" class="tabs_panel" style="display: none;"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    var PRODUCT_TYPE_DIGITAL = '<?php echo Product::PRODUCT_TYPE_DIGITAL; ?>';
    var PRODUCT_TYPE_PHYSICAL = '<?php echo Product::PRODUCT_TYPE_PHYSICAL; ?>';
    var product_type = '<?php echo $productType; ?>';

    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;
    var attachDownloadsWithInv = '<?php echo $attachDownloadsWithInv; ?>';
    $(document).ready(function() {
        customCatalogProductForm(<?php echo $preqId; ?>);
        if (product_type == PRODUCT_TYPE_DIGITAL) {
            if (0 == attachDownloadsWithInv) {
                showDownloadTab();
            } else {
                hideDownloadTab();
            }
        } else {
            hideDownloadTab();
        }

        hideShippingTab('<?php echo $productType; ?>', '<?php echo Product::PRODUCT_TYPE_DIGITAL; ?>');
    });
</script>