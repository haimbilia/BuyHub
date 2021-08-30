<?php
$canEdit = isset($canEdit) ? $canEdit : true;
$action = isset($action) ? $action : '';

if ($canEdit) { ?>
    <div class="content-header-toolbar">
        <?php if (User::canAddCustomProduct() && $action == 'products') { ?>
            <a href="<?php echo UrlHelper::generateUrl('seller', 'customProductForm'); ?>" class="btn btn-outline-brand btn-sm">
                <?php echo Labels::getLabel('LBL_ADD_NEW_PRODUCT', $siteLangId); ?>
            </a>
            <a href="<?php echo UrlHelper::generateUrl('seller', 'catalog'); ?>" class="btn btn-outline-brand btn-sm">
                <?php echo Labels::getLabel('LBL_MY_PRODUCTS', $siteLangId); ?>
            </a>
        <?php } ?>
        <?php if (isset($adminCatalogs) && $adminCatalogs > 0) { ?>
            <a href="<?php echo UrlHelper::generateUrl('seller', 'catalog', [0]); ?>" class="btn btn-outline-brand btn-sm">
                <?php echo Labels::getLabel('LBL_MARKETPLACE_PRODUCTS', $siteLangId); ?>
            </a>
        <?php } ?>
        <?php if (User::canAddCustomProduct() && $action == 'catalog' && $type == 1) { ?>
            <a href="<?php echo UrlHelper::generateUrl('seller', 'customProductForm'); ?>" class="btn btn-outline-brand btn-sm">
                <?php echo Labels::getLabel('LBL_ADD_NEW_CATALOG', $siteLangId); ?>
            </a>
        <?php } ?>

        <?php if ((isset($canAddCustomProduct) && $canAddCustomProduct == false) && (isset($canRequestProduct) && $canRequestProduct === true)) { ?>
            <a href="<?php echo UrlHelper::generateUrl('Seller', 'requestedCatalog'); ?>" class="btn btn-outline-brand btn-sm"><?php echo Labels::getLabel('LBL_REQUEST_A_PRODUCT', $siteLangId); ?></a>
        <?php } ?>

        <?php if (User::canAddCustomProduct() && ($action == 'catalog')) { ?>
            <a href="<?php echo UrlHelper::generateUrl('seller', 'products'); ?>" class="btn btn-outline-brand btn-sm">
                <?php echo Labels::getLabel('LBL_BACK_TO_INVENTORY', $siteLangId); ?>
            </a>
        <?php } ?>

        <?php if (isset($otherButtons) && is_array($otherButtons) && !empty($otherButtons)) {
            $class = 'btn btn-sm ';
            if (count($otherButtons) == count($otherButtons, COUNT_RECURSIVE)) {
                if (array_key_exists('html', $otherButtons)) {
                    echo $otherButtons['html'];
                } else {
                    $class = isset($otherButtons['class']) ? $class . $otherButtons['class'] : $class . 'btn-outline-brand';
                    $title = isset($otherButtons['title']) ? $otherButtons['title'] : '';
                    $href = isset($otherButtons['href']) ? $otherButtons['href'] : 'javascript:void(0);';
                    $onclick = isset($otherButtons['onclick']) ? 'onclick = ' . $otherButtons['onclick'] : '';
                    $label = isset($otherButtons['label']) ? $otherButtons['label'] : ''; ?>
                    <a href="<?php echo $href; ?>" class="<?php echo $class; ?>" <?php echo $onclick; ?> title="<?php echo $title; ?>">
                        <?php echo $label; ?>
                    </a>
                <?php }
            } else {
                foreach ($otherButtons as $attr) {
                    if (array_key_exists('html', $attr)) {
                        echo $attr['html'];
                    } else {
                        $btnClass = isset($attr['attr']['class']) ? $class . $attr['attr']['class'] : $class . 'btn-outline-brand';
                        $title = isset($attr['attr']['title']) ? $attr['attr']['title'] : '';
                        $href = isset($attr['attr']['href']) ? $attr['attr']['href'] : 'javascript:void(0);';
                        $onclick = isset($attr['attr']['onclick']) ? 'onclick = ' . $attr['attr']['onclick'] : '';
                        $label = isset($attr['label']) ? $attr['label'] : ''; ?>
                        <a href="<?php echo $href; ?>" class="<?php echo $btnClass; ?>" <?php echo $onclick; ?> title="<?php echo $title; ?>">
                            <?php echo $label; ?>
                        </a>
                <?php }
                }
            }
        } ?>
    </div>
<?php } ?>