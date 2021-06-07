<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<section class="section">
    <?php if (isset($banners) && isset($banners['blocation_active']) && $banners['blocation_active'] && count($banners['banners'])) { ?>
        <div class="container">
            <div class="row">
                <?php
                foreach ($banners['banners'] as $val) {
                    $desktop_url = '';
                    $tablet_url = '';
                    $mobile_url = '';
                    if (!AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId)) {
                        continue;
                    } else {
                        $slideArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId);
                        foreach ($slideArr as $slideScreen) {
                            switch ($slideScreen['afile_screen']) {
                                case applicationConstants::SCREEN_MOBILE:
                                    $mobile_url = UrlHelper::generateUrl('Banner', 'productDetailPageBanner', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_MOBILE)) . ",";
                                    break;
                                case applicationConstants::SCREEN_IPAD:
                                    $tablet_url = UrlHelper::generateUrl('Banner', 'productDetailPageBanner', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD)) . ",";
                                    break;
                                case applicationConstants::SCREEN_DESKTOP:
                                    $desktop_url = UrlHelper::generateUrl('Banner', 'productDetailPageBanner', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP)) . ",";
                                    break;
                            }
                        }
                    } ?>
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="banner-ppc"><a href="<?php echo UrlHelper::generateUrl('Banner', 'url', array($val['banner_id'])); ?>" target="<?php echo $val['banner_target']; ?>" title="<?php echo $val['banner_title']; ?>" class="advertise__block">
                                <picture>
                                    <source data-aspect-ratio="4:3" srcset="<?php echo $mobile_url; ?>" media="(max-width: 767px)">
                                    <source data-aspect-ratio="4:3" srcset="<?php echo $tablet_url; ?>" media="(max-width: 1024px)">
                                    <source data-aspect-ratio="4:1" srcset="<?php echo $desktop_url; ?>">
                                    <img data-aspect-ratio="4:1" src="<?php echo $desktop_url; ?>" alt="">
                                </picture>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php }
    if (isset($val['banner_record_id']) && $val['banner_record_id'] > 0 && $val['banner_type'] == Banner::TYPE_PPC) {
        Promotion::updateImpressionData($val['banner_record_id']);
    } ?>
</section>