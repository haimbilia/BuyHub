<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Inventory_Setup', $siteLangId),
        'siteLangId' => $siteLangId,
        'headingBackButton' => [
            'href' => UrlHelper::generateUrl('seller', 'products'),
            'onclick' => '',
        ]
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="card card-tabs">
            <?php if ($product_type == Product::PRODUCT_TYPE_DIGITAL) { ?>
                <div class="card-head">
                    <nav class="nav nav-tabs tabsNavJs">
                        <a class="nav-link tabs_001" rel="tabs_001" href="javascript:void(0)">
                            <?php echo Labels::getLabel('LBL_Initial_Setup', $siteLangId); ?> <i class="tabs-icon fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Setup_Basic_Details', $siteLangId); ?>">
                            </i>
                        </a>
                        <a class="nav-link tabs_002" rel="tabs_002" href="javascript:void(0)">
                            <?php echo Labels::getLabel('LBL_Downloads', $siteLangId); ?>
                            <i class="tabs-icon fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Downloadable_files/Links', $siteLangId); ?>"></i>
                        </a>
                    </nav>
                </div>
            <?php } ?>
            <div class="card-body">
                <div class="tabs__content">
                    <div id="tabs_001" class="tabs_panel" style="display: block;"></div>
                    <div id="tabs_002" class="tabs_panel" style="display: none;"> </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var product_id = <?php echo $product_id; ?>;
    var selprod_id = <?php echo $selprod_id; ?>;
    var canAttachDigitalDownload = <?php echo $canAttachDigitalDownload; ?>;

    $(document).ready(function() {
        sellerProductForm(product_id, selprod_id);
    });
</script>