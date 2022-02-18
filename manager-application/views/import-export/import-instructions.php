<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$activeInstTab = true;
require_once(CONF_THEME_PATH . 'import-export/_partial/import-form-head.php'); ?>
<div class="form-edit-body loaderContainerJs">
    <div class="cms">
        <?php      
        if (!empty($pageData['epage_content'])) {
            echo '<h3 class="mb-3" >' . $pageData["epage_label"] . '</h3>';
            echo FatUtility::decodeHtmlEntities($pageData['epage_content']);
        } else {
            echo '<h3 class="mb-3" >' . $pageData["epage_identifier"] . '</h3>';
            echo FatUtility::decodeHtmlEntities($pageData['epage_default_content']);            
        }
        ?>
    </div>
</div>
</div> <!-- Close </div> This must be placed. Opening tag is inside import-form-head.php file. -->