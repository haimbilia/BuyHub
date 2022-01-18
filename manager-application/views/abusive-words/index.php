<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_ABUSIVE_KEYWORD', $siteLangId);
$deleteButton = true;

$langLayout = [];
foreach ($languages as $langId => $langName) {
    $layOutDir = Language::getLayoutDirection($langId);
    $langLayout[$langId] = $layOutDir;
}

require_once(CONF_THEME_PATH . '_partial/listing/index.php'); ?>

<script>
    var langLayOuts = <?php echo json_encode($langLayout); ?>;
</script>