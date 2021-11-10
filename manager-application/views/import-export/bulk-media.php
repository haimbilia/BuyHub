<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="card-body">
    <?php echo HtmlHelper::getDropZoneHtml(FatUtility::generateUrl('ImportExport', 'upload')); ?>

    <?php echo $frmSearch->getFormHtml(); ?>
    <div class="table-responsive listingTableJs">
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

 