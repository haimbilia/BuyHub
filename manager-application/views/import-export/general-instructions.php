<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-head">
    <div class="card-head-label">
        <h3 class="card-head-title">
            <?php echo $pageData['epage_label']; ?>
        </h3>
    </div>
</div>
<div class="card-body">
    <div class="cms">
        <?php
        if (!empty($pageData['epage_content'])) {
            echo FatUtility::decodeHtmlEntities($pageData['epage_content']);
        } else {
            echo Labels::getLabel('LBL_Sorry!_No_Instructions', $adminLangId);
        }
        ?>
    </div>
</div>