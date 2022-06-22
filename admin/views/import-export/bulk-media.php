<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="card-body">
    <?php echo HtmlHelper::getDropZoneHtml(FatUtility::generateUrl('ImportExport', 'upload')); ?>
    <p class="form-text text-muted"><?php echo Labels::getLabel('LBL_ONLY_ZIP_FILES_ARE_ALLOWED.'); ?></p>
    <?php echo $frmSearch->getFormHtml(); ?>
    <div class="table-responsive table-scrollable js-scrollable listingTableJs">
        <?php
        require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
        require_once(CONF_THEME_PATH . 'import-export/search.php');

        $data = [
            'tbl' => $tbl, /* Received from listing-column-head.php file. */
        ];
        $this->includeTemplate('_partial/listing/print-listing-table.php', $data, false); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
</div>

 