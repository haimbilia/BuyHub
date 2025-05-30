<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (isset($slides) && count($slides)) { ?>
    <section class="jsSliderSection" data-width="<?php echo $fullWidth; ?>" data-section="hero-slides">
        <?php if (0 == $fullWidth) { ?>
            <div class="container">
            <?php } ?>
            <div class="js-hero-slider hero-slider <?php echo (0 < $fullWidth) ? 'hero-slider-full' : 'hero-slider-fixed' ?>" dir="<?php echo CommonHelper::getLayoutDirection(); ?> ">
                <?php foreach ($slides as $slide) {
                    $desktopUrl = $desktopWebpUrl = '';
                    $tabletUrl = $tabletWebpUrl = '';
                    $mobileUrl = $mobileWebpUrl = '';
                    $haveUrl = ($slide['slide_url'] != '') ? true : false;
                    $defaultUrl = '';
                    $slideArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_HOME_PAGE_BANNER, $slide['slide_id'], 0, $siteLangId);
                    if (!$slideArr) {
                        continue;
                    } else {
                        foreach ($slideArr as $slideScreen) {
                            $uploadedTime = AttachedFile::setTimeParam($slideScreen['afile_updated_at']);
                            switch ($slideScreen['afile_screen']) {
                                case applicationConstants::SCREEN_MOBILE:
                                    $mobileUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_MOBILE, $siteLangId, ImageDimension::VIEW_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                    $mobileWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_MOBILE, $siteLangId, "WEBP" . ImageDimension::VIEW_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                                    break;
                                case applicationConstants::SCREEN_IPAD:
                                    $tabletUrl = UrlHelper::getCachedUrl(
                                        UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_IPAD, $siteLangId, ImageDimension::VIEW_TABLET)) . $uploadedTime,
                                        CONF_IMG_CACHE_TIME,
                                        '.jpg'
                                    );
                                    $tabletWebpUrl = UrlHelper::getCachedUrl(
                                        UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_IPAD, $siteLangId, "WEBP" . ImageDimension::VIEW_TABLET)) . $uploadedTime,
                                        CONF_IMG_CACHE_TIME,
                                        '.webp'
                                    );
                                    break;
                                case applicationConstants::SCREEN_DESKTOP:
                                    $desktopUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_DESKTOP, $siteLangId, ImageDimension::VIEW_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                    $desktopWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_DESKTOP, $siteLangId, "WEBP" . ImageDimension::VIEW_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                                    break;
                            }
                        }
                    }

                    if ($desktopUrl == '') {
                        $desktopUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_DESKTOP, $siteLangId, ImageDimension::VIEW_DESKTOP)), CONF_IMG_CACHE_TIME, '.jpg');
                    }

                    $imageDimension = ImageDimension::getData(ImageDimension::TYPE_SLIDE);


                    $out = '<div class="hero-slider-item" role="group">';
                    if ($haveUrl) {
                        if ($slide['promotion_id'] > 0) {
                            $slideUrl = UrlHelper::generateUrl('slides', 'track', array($slide['slide_id']));
                        } else {
                            $slideUrl = CommonHelper::processUrlString($slide['slide_url']);
                        }
                    }
                    if ($haveUrl) {
                        $arialLabelTxt = ($slide['slide_target'] == applicationConstants::LINK_TARGET_BLANK_WINDOW) ? 'Opens in a new tab' : 'Opens in a current tab';

                        $out .= '<a target="' . $slide['slide_target'] . '" href="' . $slideUrl . '" aria-label="' . $slide['slide_title'] . ' ' . $arialLabelTxt . '">';
                    }
                    $out .= '<div class="hero-slider-media">';
                    $slideTypeArr = Slides::getSlideTypesArr($siteLangId);
                    $pictureAttr = [
                        'siteLangId' => $siteLangId,
                        'webpImageUrl' => [ImageDimension::VIEW_MOBILE => $mobileWebpUrl, ImageDimension::VIEW_TABLET => $tabletWebpUrl, ImageDimension::VIEW_DESKTOP => $desktopWebpUrl],
                        'jpgImageUrl' => [ImageDimension::VIEW_MOBILE => $mobileUrl, ImageDimension::VIEW_TABLET => $tabletUrl, ImageDimension::VIEW_DESKTOP => $desktopUrl],
                        'imageUrl' => $desktopUrl,
                        'ratio' => $imageDimension[ImageDimension::VIEW_DESKTOP]['aspectRatio'],
                        'alt' => $slideTypeArr[$slide['slide_type']] . ' ' . $slide['slide_title'],
                        'title' => $slide['slide_title'],
                    ];
                    $out .= $this->includeTemplate('_partial/picture-tag.php', $pictureAttr, true, true);
                    $out .= '</div>';
                    if ($haveUrl) {
                        $out .= '</a>';
                    }
                    $out .= '</div>';
                    echo $out;
                    if (isset($slide['promotion_id']) && $slide['promotion_id'] > 0) {
                        Promotion::updateImpressionData($slide['promotion_id']);
                    }
                } ?>
            </div>
            <?php if (0 == $fullWidth) { ?>
            </div>
        <?php } ?>
    </section>
<?php } ?>