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
                        <span class="nav__link">
                            <span class="nav__link-text"><?php echo $layout; ?></span>
                            <ul class="actions">
                                <li title="<?php echo Labels::getLabel('LBL_LAYOUT_INSTRUCTION', $siteLangId); ?>" data-toggle="tooltip" data-placement="top">
                                    <?php 
                                        $url = CONF_WEBROOT_URL . 'images/collection_layouts/' . Collections::getLayoutImagesArr()[$layoutType];
                                    ?>
                                    <a href="javascript:void(0)" onclick="displayImageInFacebox('<?php echo $layout; ?>', '<?php echo $url ?>')">
                                        <svg class="svg" width="18" height="18">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view"></use>    
                                        </svg>
                                    </a>
                                </li>
                                <li title="<?php echo Labels::getLabel('LBL_ADD_COLLECTION', $siteLangId); ?>" data-toggle="tooltip" data-placement="top">
                                    <a href="javascript:void(0)" onclick="collectionForm(<?php echo $type; ?>, <?php echo $layoutType; ?>)">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#add"></use>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </span>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>