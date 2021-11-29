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
            foreach ($this->variables['nodes'] as $nodes) {
        ?>
                <?php if (!empty($nodes['href'])) { ?>
                    <li class="breadcrumb-item">
                        <a href="<?php echo $nodes['href']; ?>" <?php echo (!empty($nodes['other'])) ? $nodes['other'] : ''; ?>>
                            <?php echo $nodes['title'] ?? ''; ?>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="breadcrumb-item">
                        <?php echo $nodes['title'] ?? ''; ?>
                    </li>
        <?php
                }
            }
        }
        ?>
    </ul>

    <!-- <div class="d-flex ">
        <select class="form-control form-select select-language">
            <option value="2" selected="selected">Arabic</option>
        </select>
    </div> -->



    <?php
    $newRecordBtn = $newRecordBtn ?? false;
    $newRecordParent = $newRecordParent ?? '';
    $newRecordBtnAttrs = $newRecordBtnAttrs ?? [];
    if (isset($newRecordBtn) && true === $newRecordBtn && $canEdit) {
        $href = "javascript:void(0)";
        $onclick = "addNew(" . $newRecordParent . ")";
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