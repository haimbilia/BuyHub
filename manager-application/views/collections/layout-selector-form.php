<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COLLECTIONS_LAYOUTS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body p-0 loaderContainerJs">
        <ul class="layout">
            <?php foreach ($typeLayouts as $type => $layouts) { ?>
                <li class="layout-item">
                    <div class="layout-head dropdown-toggle-custom collapsed" data-bs-toggle="collapse" data-bs-target="#collectionType<?php echo $type; ?>" aria-expanded="false" aria-controls="collectionType<?php echo $type; ?>">
                        <span class="h3"><?php echo $typeArr[$type]; ?></span>
                        <i class="dropdown-toggle-custom-arrow"></i>
                    </div>
                    <div class="layout-data collapse" id="collectionType<?php echo $type; ?>">
                        <?php foreach ($layouts as $layoutType => $layout) { ?>
                            <div class="layout-block" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $layout; ?>">
                                <i class="icn">
                                    <svg class="svg" width="40" height="40">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-layout.svg#collection-layout-<?php echo $layoutType; ?>"></use>
                                    </svg>
                                </i>
                            </div>
                        <?php } ?>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>