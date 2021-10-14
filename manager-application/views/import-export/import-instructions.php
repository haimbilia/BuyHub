<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$activeInstTab = true;
require_once(CONF_THEME_PATH . 'import-export/_partial/import-form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php
        if (!empty($pageData['epage_content'])) {
            echo '<h2>' . $pageData["epage_label"] . '</h2>';
            echo FatUtility::decodeHtmlEntities($pageData['epage_content']);
        } else {
            echo HtmlHelper::getErrorMessageHtml(Labels::getLabel('LBL_SORRY!!_NO_INSTRUCTION_FOUND', $siteLangId));
        }
        ?>
    </div>
</div> <!-- Close </div> This must be placed. Opening tag is inside import-form-head.php file. -->