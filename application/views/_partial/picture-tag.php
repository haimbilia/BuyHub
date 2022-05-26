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
    <?php
    $emptyWebpUrlCount = 0;
    $webpItmesCount =  count($webpImageUrl);
    foreach ($webpImageUrl as $key => $url) {
        if (empty($url)) {
            $emptyWebpUrlCount++;
            continue;
        }
        $key = strtoupper($key);
        $mediaArr = ImageDimension::getPictureTagMedia($key);

        $media = 'media="(' . $mediaArr['key'] . ':' . $mediaArr['value'] . 'px)"';
        if (1 < $emptyWebpUrlCount || $webpItmesCount == 1) {
            $media = '';
        }

    ?>
        <source srcset="<?php echo $url; ?>" type="image/webp" <?php echo $media; ?>>
    <?php } ?>
    <?php
    $emptyJpgUrlCount = 0;
    $jpgItmesCount =  count($jpgImageUrl);
    foreach ($jpgImageUrl as $key => $url) {
        if (empty($url)) {
            $emptyJpgUrlCount++;
            continue;
        }
        $key = strtoupper($key);
        $mediaArr = ImageDimension::getPictureTagMedia($key);

        $media = 'media="(' . $mediaArr['key'] . ':' . $mediaArr['value'] . 'px)"';
        if (1 < $emptyJpgUrlCount  || $jpgItmesCount == 1) {
            $media = '';
        }
    ?>

        <source srcset="<?php echo $url; ?>" type="image/jpeg" <?php echo $media; ?>>
    <?php } ?>
    <img <?php (true == $lazyLoading) ? "loading='lazy'" : ""; ?> <?php !empty($ratio) ? "data-ratio='" . $ratio . "'" : ""; ?> src="<?php echo $imageUrl; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
</picture>