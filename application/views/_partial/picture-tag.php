<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$webpImageUrl = $webpImageUrl ?? [];
$jpgImageUrl = $jpgImageUrl ?? [];
$lazyLoading = $lazyLoading ?? true;

$imageUrl = isset($imageUrl) ? $imageUrl : '';
$ratio = isset($ratio) ? $ratio : '';
$alt = isset($alt) ? htmlspecialchars_decode($alt) : FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId);
$title = isset($title) ? htmlspecialchars_decode($title) : $alt;
?>
<picture>
    <?php foreach ($webpImageUrl as $key => $url) {
        if (empty($url)) {
            continue;
        }
        $key = strtoupper($key);
        $mediaArr = ImageDimension::getPictureTagMedia($key);
    ?>
        <source srcset="<?php echo $url; ?>" type="image/webp" media="(<?php echo $mediaArr['key']; ?>: <?php echo $mediaArr['value']; ?>px)">
    <?php } ?>
    <?php foreach ($jpgImageUrl as $key => $url) {
        if (empty($url)) {
            continue;
        }
        $key = strtoupper($key);
        $mediaArr = ImageDimension::getPictureTagMedia($key); ?>

        <source srcset="<?php echo $url; ?>" type="image/jpeg" media="(<?php echo $mediaArr['key']; ?>: <?php echo $mediaArr['value']; ?>px)">
    <?php } ?>
    <img <?php (true == $lazyLoading) ? "loading='lazy'" : ""; ?> <?php !empty($ratio) ? "data-ratio='" . $ratio . "'" : ""; ?> src="<?php echo $imageUrl; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
</picture>