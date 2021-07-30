<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

$bCount = 1;

if (!empty($bannerLayout1['banners']) && $bannerLayout1['blocation_active']) { ?>
 <section class="section" >
 <div class="container">
    <div class="banner-wrappers">
	<?php foreach ($bannerLayout1['banners'] as $val) {
    /* if($bCount%2==0)
    {
        $bannerClass="banners_right";
    }
    else
    {
        $bannerClass="banners_left";
    } */
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
                    case applicationConstants::SCREEN_MOBILE:
                        $mobileUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Banner', 'HomePageBannerBottomLayout', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_MOBILE)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg').",";
                        $mobileWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Banner', 'HomePageBannerBottomLayout', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_MOBILE,'webp')).$uploadedTime, CONF_IMG_CACHE_TIME, '.webp').",";
                        break;
                    case applicationConstants::SCREEN_IPAD:
                        $tabletUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Banner', 'HomePageBannerBottomLayout', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg').",";
                        $tabletWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Banner', 'HomePageBannerBottomLayout', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD),'webp').$uploadedTime, CONF_IMG_CACHE_TIME, '.webp').",";
                        break;
                    case applicationConstants::SCREEN_DESKTOP:
                        $desktopUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Banner', 'HomePageBannerBottomLayout', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); 
                        $desktopWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Banner', 'HomePageBannerBottomLayout', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP,'webp')).$uploadedTime, CONF_IMG_CACHE_TIME, '.webp');                        
                        break;
                }
        }
    }

    if($desktopUrl == ''){
        $desktopUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Banner', 'HomePageBannerBottomLayout', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); 
        $desktopWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Banner', 'HomePageBannerBottomLayout', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP,'webp')).$uploadedTime, CONF_IMG_CACHE_TIME, '.webp');  
    }

    if ($val['banner_record_id'] > 0 && $val['banner_type'] == Banner::TYPE_PPC) {
        Promotion::updateImpressionData($val['banner_record_id']);
    }/* else{
            Banner::updateImpressionData($val['banner_id']);
        } */ ?>
	 
        <div class="banner-ppc">
			<a  target="<?php echo $val['banner_target']; ?>" href="<?php echo UrlHelper::generateUrl('Banner', 'url', array($val['banner_id'])); ?>" title="<?php echo $val['banner_title']; ?>">
            <picture>
                <source type="image/webp" srcset="<?php echo $mobileWebpUrl . $tabletWebpUrl . $desktopWebpUrl; ?>" media="(max-width: 767px),(max-width: 1024px)">
                <source type="image/jpeg" srcset="<?php echo $mobileUrl . $tabletUrl . $desktopUrl; ?>" media="(max-width: 767px),(max-width: 1024px)">
                <img data-aspect-ratio="10:3" src="<?php echo $desktopUrl; ?>" alt="" loading="lazy">
            </picture>
			</a>
		</div>
     
<?php $bCount++;
} ?>
    </div>
</div>
</section>
<hr class="m-0">
<?php } 	?>
