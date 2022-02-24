<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$webpImageUrl = isset($webpImageUrl) ? $webpImageUrl : '';
$jpgImageUrl = isset($jpgImageUrl) ? $jpgImageUrl : '';
$imageUrl = isset($imageUrl) ? $imageUrl : '';
$ratio = isset($ratio) ? $ratio : '';
$alt = isset($alt) ? htmlspecialchars_decode($alt) : FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId);
$title = isset($title) ? htmlspecialchars_decode($title) : $alt;
?>
<picture>
    <source type="image/webp" srcset="<?php echo $webpImageUrl; ?>" media="(max-width: 767px),(max-width: 1024px)">
    <source type="image/jpeg" srcset="<?php echo $jpgImageUrl; ?>" media="(max-width: 767px),(max-width: 1024px)">
    <img loading='lazy' data-ratio="<?php echo $ratio; ?>" src="<?php echo $imageUrl; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
</picture>