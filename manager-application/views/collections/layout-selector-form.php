<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COLLECTIONS_LAYOUTS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <ul class="nav nav--block">
            <?php
            foreach ($typeLayouts as $type => $layouts) {
                foreach ($layouts as $layoutType => $layout) { ?>
                    <li class="nav__item">
                        <a href="#" class="nav__link">
                            <span class="nav__link-text"><?php echo $layout; ?></span>
                        </a>
                        <div class="actions">
                            <a href="javascript:void(0)" onclick="collectionForm(<?php echo $type; ?>, <?php echo $layoutType; ?>, 0)" title="<?php echo Labels::getLabel('LBL_ADD_COLLECTION', $siteLangId); ?>" class="btn-clean btn-sm btn-icon btn-secondary ">
                                <i class="fas fa-plus">
                                    <!-- <svg class="svg" width="16px" height="16px">
                                        <use xlink:href="<//?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#plus">
                                        </use>
                                    </svg> -->
                                </i></a>
                            <a rel="facebox" onClick="displayImageInFacebox('<?php echo CONF_WEBROOT_URL; ?>images/collection_layouts/<?php echo Collections::getLayoutImagesArr()[$layoutType]; ?>');" href="javascript:void(0)" title="<?php echo Labels::getLabel('LBL_LAYOUT_INSTRUCTION', $siteLangId); ?>" class="btn-clean btn-sm btn-icon btn-secondary "><i class="fas fa-file-image"></i></a>
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>