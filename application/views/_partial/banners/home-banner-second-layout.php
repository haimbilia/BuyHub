<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

$bCount = 1;

if (!empty($bannerLayout1['banners']) && $bannerLayout1['blocation_active']) { ?>
<section class="section section-banner" data-section="section">
    <?php if (!$collection['collection_full_width']) { ?>
    <div class="container">
        <?php } ?>
        <div class="poster-layout"
            data-view="<?php echo (0 < $collection['collection_primary_records'] ? $collection['collection_primary_records'] : 2); ?>">
            <?php foreach ($bannerLayout1['banners'] as $val) {
                    $desktopUrl = $desktopWebpUrl = '';
                    $tabletUrl = $tabletWebpUrl = '';
                    $mobileUrl = $mobileWebpUrl = '';

                    if (!AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId)) {
                        continue;
                    } else {
                        $slideArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId);
                        foreach ($slideArr as $slideScreen) {
                            $uploadedTime = AttachedFile::setTimeParam($slideScreen['afile_updated_at']);
                            switch ($slideScreen['afile_screen']) {
                                /*  case applicationConstants::SCREEN_MOBILE:
                                 $mobileUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'Banner', array($val['banner_id'], Collections::TYPE_BANNER_LAYOUT2, $siteLangId, applicationConstants::SCREEN_MOBILE, ImageDimension::VIEW_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                 $mobileWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'Banner', array($val['banner_id'], Collections::TYPE_BANNER_LAYOUT2, $siteLangId, applicationConstants::SCREEN_MOBILE, 'webp' . ImageDimension::VIEW_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                                 break;
                             case applicationConstants::SCREEN_IPAD:
                                 $tabletUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'Banner', array($val['banner_id'], Collections::TYPE_BANNER_LAYOUT2, $siteLangId, applicationConstants::SCREEN_IPAD, ImageDimension::VIEW_TABLET)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                 $tabletWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'Banner', array($val['banner_id'], Collections::TYPE_BANNER_LAYOUT2, $siteLangId, applicationConstants::SCREEN_IPAD), 'webp' . ImageDimension::VIEW_TABLET) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                                 break; */
                                case applicationConstants::SCREEN_DESKTOP:
                                    $desktopUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'Banner', array($val['banner_id'], Collections::TYPE_BANNER_LAYOUT2, $siteLangId, applicationConstants::SCREEN_DESKTOP, ImageDimension::VIEW_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                    $desktopWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'Banner', array($val['banner_id'], Collections::TYPE_BANNER_LAYOUT2, $siteLangId, applicationConstants::SCREEN_DESKTOP, 'webp' . ImageDimension::VIEW_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                                    break;
                            }
                        }
                    }

                    if ($desktopUrl == '') {
                        $desktopUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'Banner', array($val['banner_id'], Collections::TYPE_BANNER_LAYOUT2, $siteLangId, applicationConstants::SCREEN_DESKTOP, ImageDimension::VIEW_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $desktopWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'Banner', array($val['banner_id'], Collections::TYPE_BANNER_LAYOUT2, $siteLangId, applicationConstants::SCREEN_DESKTOP, 'webp' . ImageDimension::VIEW_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                    }

                    if ($val['banner_record_id'] > 0 && $val['banner_type'] == Banner::TYPE_PPC) {
                        Promotion::updateImpressionData($val['banner_record_id']);
                    }/* else{
    Banner::updateImpressionData($val['banner_id']);
} */ ?>

            <div class="poster">
                <a target="<?php echo $val['banner_target']; ?>"
                    href="<?php echo UrlHelper::generateUrl('Banner', 'track', array($val['banner_id'])); ?>"
                    title="<?php echo $val['banner_title']; ?>">
                    <?php
                            $bannerDimension = ImageDimension::getBannerData('', Collections::TYPE_BANNER_LAYOUT2);
                            $pictureAttr = [
                                'webpImageUrl' => [ImageDimension::VIEW_MOBILE => $mobileWebpUrl, ImageDimension::VIEW_TABLET => $tabletWebpUrl, ImageDimension::VIEW_DESKTOP => $desktopWebpUrl],
                                'jpgImageUrl' => [ImageDimension::VIEW_MOBILE => $mobileUrl, ImageDimension::VIEW_TABLET => $tabletUrl, ImageDimension::VIEW_DESKTOP => $desktopUrl],
                                'imageUrl' => $desktopUrl,
                                'ratio' => $bannerDimension['aspectRatio'],
                                'alt' => !empty($val['banner_title']) ? $val['banner_title'] : $val['promotion_name'],
                                'siteLangId' => $siteLangId,
                            ];

                            $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                            ?>
                </a>
            </div>

            <?php $bCount++;
                } ?>
        </div>
        <?php if (!$collection['collection_full_width']) { ?>
    </div>
    <?php } ?>
</section>
<?php } ?>