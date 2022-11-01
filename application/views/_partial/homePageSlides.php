<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="js-hero-slider hero-slider" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
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
                        $desktopUrl =  UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_DESKTOP, $siteLangId, ImageDimension::VIEW_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $desktopWebpUrl =  UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_DESKTOP, $siteLangId, "WEBP" . ImageDimension::VIEW_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                        break;
                }
            }
        }

        if ($desktopUrl == '') {
            $desktopUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'slide', array($slide['slide_id'], applicationConstants::SCREEN_DESKTOP, $siteLangId, ImageDimension::VIEW_DESKTOP)), CONF_IMG_CACHE_TIME, '.jpg');
        }

        $imageDimension = ImageDimension::getData(ImageDimension::TYPE_SLIDE);


        $out = '<div class="hero-slider-item">';
        if ($haveUrl) {
            if ($slide['promotion_id'] > 0) {
                $slideUrl =  UrlHelper::generateUrl('slides', 'track', array($slide['slide_id']));
            } else {
                $slideUrl = CommonHelper::processUrlString($slide['slide_url']);
            }
        }
        if ($haveUrl) {
            $out .= '<a target="' . $slide['slide_target'] . '" href="' . $slideUrl . '">';
        }
        $out .= '<div class="hero-slider-media">';
        $pictureAttr = [
            'siteLangId' => $siteLangId,
            'webpImageUrl' => [ImageDimension::VIEW_MOBILE => $mobileWebpUrl, ImageDimension::VIEW_TABLET => $tabletWebpUrl, ImageDimension::VIEW_DESKTOP => $desktopWebpUrl],
            'jpgImageUrl' => [ImageDimension::VIEW_MOBILE => $mobileUrl, ImageDimension::VIEW_TABLET => $tabletUrl, ImageDimension::VIEW_DESKTOP => $desktopUrl],
            'imageUrl' => $desktopUrl,
            'ratio' => $imageDimension[ImageDimension::VIEW_DESKTOP]['aspectRatio'],
            'alt' => $slide['slide_title'],
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
</section>
<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-heading">
                <h2>Popular product</h2>
            </div>
        </div>
        <div class="product-layout-4">
            <div class="products product-item products-1">
                <div class="products-body">
                    <div class="products-img">
                        <a href=""> <img src="https://localhost/yokart/image/product/85/LARGE/0/2698?t=1655272492" alt="">
                        </a>
                    </div>

                </div>
                <div class="products-foot">
                    <div class="products-price">
                        <span class="products-price-new">$85.00</span>
                        <del class="products-price-old">$120.00</del>
                        <div class="products-price-off">29.17% OFF</div>
                    </div>
                </div>
            </div>
            <div class="products product-item products-2">
                <div class="products-body">
                    <div class="products-img">
                        <a href=""> <img src="https://localhost/yokart/image/product/104/LARGE/0/2814?t=1655721063" alt="">
                        </a>
                    </div>

                </div>
                <div class="products-foot">
                    <div class="products-price">
                        <span class="products-price-new">$85.00</span>
                        <del class="products-price-old">$120.00</del>
                    </div>
                </div>
            </div>
            <div class="products product-item products-3">
                <div class="products-body">

                    <div class="products-img">
                        <a href=""> <img src="https://localhost/yokart/image/product/86/LARGE/0/2704?t=1655276736" alt="">
                        </a>
                    </div>

                </div>
                <div class="products-foot">
                    <div class="products-price">
                        <span class="products-price-new">$35.00</span>
                    </div>

                </div>
            </div>
            <div class="products product-item products-4">
                <div class="products-body">

                    <div class="products-img">
                        <a href=""> <img src="https://localhost/yokart/image/product/87/LARGE/0/2709?t=1655278798" alt="">
                        </a>
                    </div>

                </div>
                <div class="products-foot">
                    <div class="products-price">
                        <span class="products-price-new">$535.00</span>
                    </div>

                </div>
            </div>
            <div class="products product-item products-5">
                <div class="products-body">

                    <div class="products-img">
                        <a href=""> <img src="https://localhost/yokart/image/product/171/LARGE/0/3243?t=1657709329" alt="">
                        </a>
                    </div>

                </div>
                <div class="products-foot">
                    <div class="products-price">
                        <span class="products-price-new">$325.00</span>
                    </div>

                </div>
            </div>
            <div class="products product-item products-6">
                <div class="products-body">

                    <div class="products-img">
                        <a href=""> <img src="https://localhost/yokart/image/product/184/LARGE/0/3314?t=1658130568" alt="">
                        </a>
                    </div>

                </div>
                <div class="products-foot">
                    <div class="products-price">
                        <span class="products-price-new">$365.00</span>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>