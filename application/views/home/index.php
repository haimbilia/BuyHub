<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<script>
ykevents.viewContent();
</script>

<main id="main" class="main">
    <?php foreach ($collectionTemplates as $collection) {
        echo FatUtility::decodeHtmlEntities($collection['html']);
    }
    $this->includeTemplate('_partial/footerTrustBanners.php');
    ?>
</main>