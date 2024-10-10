<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($banners) && isset($banners['blocation_active']) && $banners['blocation_active'] && count($banners['banners'])) { ?>
<section class="section" data-section="section">
    <div class="container">
        <div class="poster-layout">
            <?php
                foreach ($banners['banners'] as $val) {
                    $desktop_url = '';
                    $tablet_url = '';
                    $mobile_url = '';
                    $image = AttachedFile::getAttachment(AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId, true, applicationConstants::SCREEN_DESKTOP);
                    if (0 > $image['afile_id']) {
                        continue;
                    }
                    $uploadedTime = AttachedFile::setTimeParam($val['banner_updated_on']);
                    $desktopUrl = UrlHelper::generateUrl('Banner', 'BannerImage', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP, ImageDimension::VIEW_PROD_PROMOTIONAL_BANNER)) . $uploadedTime;
                    ?>

            <div class="poster">
                <a href="<?php echo UrlHelper::generateUrl('Banner', 'track', array($val['banner_id'])); ?>"
                    target="<?php echo $val['banner_target']; ?>" title="<?php echo $val['banner_title']; ?>">
                    <?php
                            $pictureAttr = [
                                'siteLangId' => $siteLangId,
                                'webpImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::generateUrl('Banner', 'BannerImage', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP, 'WEBP' . ImageDimension::VIEW_PROD_PROMOTIONAL_BANNER)) . $uploadedTime],
                                'jpgImageUrl' => [ImageDimension::VIEW_DESKTOP => $desktopUrl],
                                'imageUrl' => $desktopUrl,
                                'alt' => !empty($val['banner_title']) ? $val['banner_title'] : $val['promotion_name'],
                            ];
                            $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                            ?>
                </a>
            </div>
            <?php
                    if (isset($val['banner_record_id']) && $val['banner_record_id'] > 0 && $val['banner_type'] == Banner::TYPE_PPC) {
                        Promotion::updateImpressionData($val['banner_record_id']);
                    }
                } ?>
        </div>
    </div>
</section>
<?php } ?>