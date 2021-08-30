<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main"   >
    <div class="content-wrapper content-space">
        <?php
        $data = [
            'headingLabel' => Labels::getLabel('LBL_Inventory_Setup', $siteLangId),
            'siteLangId' => $siteLangId,
            'otherButtons' => [
                [
                    'attr' => [
                        'href' => UrlHelper::generateUrl('seller', 'products'),
                        'title' => Labels::getLabel('LBL_Back_To_My_Inventory', $siteLangId)
                    ],
                    'label' => Labels::getLabel('LBL_Back_To_My_Inventory', $siteLangId)
                ],
            ]
        ];

        $this->includeTemplate('_partial/header/content-header.php', $data, false);
        ?>
        <div class="content-body">
            <?php if ($product_type == Product::PRODUCT_TYPE_DIGITAL) { ?>
                <div class="tabs">
                    <ul class="tabs_nav-js">
                        <li>
                            <a class="tabs_001" rel="tabs_001" href="javascript:void(0)">
                                <?php echo Labels::getLabel('LBL_Initial_Setup', $siteLangId); ?> <i class="tabs-icon fa fa-info-circle"  data-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Setup_Basic_Details', $siteLangId); ?>">
                                </i>
                            </a>
                        </li>
                        <li><a rel="tabs_002" class="tabs_002" href="javascript:void(0)">
                            <?php echo Labels::getLabel('LBL_Downloads', $siteLangId); ?>
                            <i class="tabs-icon fa fa-info-circle"  data-toggle="tooltip" data-placement="right" title="<?php echo Labels::getLabel('LBL_Downloadable_files/Links', $siteLangId); ?>"></i></a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
            <div class="card">
                <div class="card-body">
                    <div class="tabs__content">
                        <div id="tabs_001" class="tabs_panel" style="display: block;"></div>
                        <div id="tabs_002" class="tabs_panel" style="display: none;"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
var product_id = <?php echo $product_id ;?>;
var selprod_id = <?php echo $selprod_id ;?>;
var canAttachDigitalDownload = <?php echo $canAttachDigitalDownload ;?>;

$(document).ready(function () {
    sellerProductForm(product_id, selprod_id);
});
</script>
