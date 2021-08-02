<?php
    $webpImageUrl = isset($webpImageUrl) ? $webpImageUrl : '';
    $jpgImageUrl = isset($jpgImageUrl) ? $jpgImageUrl : '';
    $ratio = isset($ratio) ? $ratio : '';
    $alt = isset($alt) ? htmlspecialchars_decode($alt) : FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId);
    $title = isset($title) ? htmlspecialchars_decode($title) : $alt;
?>
<picture>
    <source type="image/webp" srcset="<?php echo $webpImageUrl; ?>">
    <source type="image/jpeg" srcset="<?php echo $jpgImageUrl; ?>">
    <img loading='lazy' data-ratio="<?php echo $ratio; ?>" src="<?php echo $jpgImageUrl; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
</picture>