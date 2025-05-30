<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Product', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <ul>
            <?php if (User::canAddCustomProduct()) { ?>
                <li data-heading="OR">
                    <a href="<?php echo UrlHelper::generateUrl('products', 'form'); ?>">
                        <i class="icn fa  fa-camera"></i>
                        <p>
                            <?php echo Labels::getLabel('LBL_Create_new_product', $siteLangId); ?>
                        </p>
                        <span>
                            <?php echo Labels::getLabel('LBL_Create_your_Product', $siteLangId); ?>
                        </span>
                    </a>
                </li>
            <?php } else if ((isset($canAddCustomProduct) && $canAddCustomProduct == false) && (isset($canRequestProduct) && $canRequestProduct === true)) { ?>
                <li data-heading="OR">
                    <a href="<?php echo UrlHelper::generateUrl('Seller', 'requestedCatalog'); ?>" class="btn btn-brand btn-sm">
                        <i class="icn fa fa-file-text "></i>
                        <p>
                            <?php echo Labels::getLabel('LBL_Request_A_Product', $siteLangId); ?>
                        </p>
                        <span>
                            <?php echo Labels::getLabel('LBL_Request_to_add_a_new_product_in_catalog', $siteLangId); ?>
                        </span>
                    </a>
                </li>
            <?php } ?>
            <li data-heading="OR">
                <a href="<?php echo UrlHelper::generateUrl('seller', 'catalog', array(1)); ?>">
                    <i class="icn fa fa-camera-retro"></i>
                    <p>
                        <?php echo Labels::getLabel('LBL_Search_and_add_Products_from_marketplace', $siteLangId); ?>
                    </p>
                    <span>
                        <?php echo Labels::getLabel('LBL_Search_and_pick_to_sell_products_from_existing_marketplace_products', $siteLangId); ?>
                    </span>
                </a>
            </li>
            <li data-heading="OR">
                <a href="<?php echo UrlHelper::generateUrl('ImportExport', 'index'); ?>">
                    <i class="far fa-file-alt"></i>
                    <p>
                        <?php echo Labels::getLabel('LBL_Import_Export', $siteLangId); ?>
                    </p>
                    <span>
                        <?php echo Labels::getLabel('LBL_Import_Export_Existing_Data', $siteLangId); ?>
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>