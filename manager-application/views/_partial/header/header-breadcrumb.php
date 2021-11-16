<?php defined('SYSTEM_INIT') or die('Invalid usage'); ?>
<div class="breadcrumb-wrap">
    <ul class="breadcrumb ">
        <li class="breadcrumb-item">
            <a href="<?php echo UrlHelper::generateUrl('') ?>">
                <?php echo labels::getLabel('LBL_Home', $siteLangId); ?>
            </a>
        </li>
        <?php
        if (!empty($this->variables['nodes'])) {
            foreach ($this->variables['nodes'] as $nodes) { ?>
                <?php if (!empty($nodes['href'])) { ?>
                    <li class="breadcrumb-item">
                        <a href="<?php echo $nodes['href']; ?>" <?php echo (!empty($nodes['other'])) ? $nodes['other'] : ''; ?>>
                            <?php $title = str_replace(' ', '_', $nodes['title']);
                            echo Labels::getLabel('LBL_' . $title, $siteLangId); ?>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="breadcrumb-item">
                        <?php $title = str_replace(' ', '_', $nodes['title']);
                        echo (isset($nodes['title'])) ? Labels::getLabel('LBL_' . $title, $siteLangId) : ''; ?>
                    </li>
        <?php }
            }
        } ?>
    </ul>
    <?php
    $newRecordBtn = $newRecordBtn ?? false;
    $newRecordBtnAttrs = $newRecordBtnAttrs ?? [];
    if (isset($newRecordBtn) && true === $newRecordBtn && $canEdit) {
        $href = "javascript:void(0)";
        $onclick = "addNew()";
        $title = Labels::getLabel('BTN_NEW', $siteLangId);
        $label = $title;
        if (isset($newRecordBtnAttrs) && 0 < count($newRecordBtnAttrs)) {
            $href = $newRecordBtnAttrs['attr']['href'] ?? $href;
            $onclick = $newRecordBtnAttrs['attr']['onclick'] ?? $onclick;
            $title = $newRecordBtnAttrs['attr']['title'] ?? $title;
            $label = $newRecordBtnAttrs['label'] ?? $label;
        }

    ?>
        <a href="<?php echo $href; ?>" class="btn btn-icon btn-outline-brand btn-add" onclick="<?php echo $onclick; ?>" title="<?php echo $title; ?>">
            <svg class="svg" width="18" height="18">
                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>/images/retina/sprite-actions.svg#add">
                </use>
            </svg>
            <span><?php echo $label; ?></span>
        </a>
    <?php
    }
    ?>
</div>