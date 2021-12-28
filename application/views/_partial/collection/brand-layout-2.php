<?php if (isset($collection['brands']) && count($collection['brands']) > 0) { ?>
   

    <section class="section">
        <div class="container">
            <div class="section-head section-head-center">
                <?php echo ($collection['collection_name'] != '') ? ' <div class="section__heading"><h2>' . $collection['collection_name'] . '</h2></div>' : ''; ?>

                <?php if ($collection['totBrands'] > Collections::LIMIT_BRAND_LAYOUT1) { ?>
                    <div class="section__action"> <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>" class="link"><?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?></a> </div>
                <?php } ?>
            </div>
            <div class="brand-layout-2">
                <?php $i = 0;
                foreach ($collection['brands'] as $brand) { ?>

                    <?php
                    $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_LOGO, $brand['brand_id'], 0, 0, false);
                    $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                    $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                    $ratio = "";
                    if (isset($fileData['afile_aspect_ratio']) && $fileData['afile_aspect_ratio'] > 0 && isset($aspectRatioArr[$fileData['afile_aspect_ratio']])) {
                        $ratio = $aspectRatioArr[$fileData['afile_aspect_ratio']];
                    } ?>
                   

                    <a href="<?php echo UrlHelper::generateUrl('brands', 'View', array($brand['brand_id'])); ?>" class="brand">
                        <div class="brand-thumb">
                            <img loading='lazy' data-ratio="<?php echo $ratio; ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'brandImage', array($brand['brand_id'], $siteLangId, 'COLLECTION_PAGE')) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo (!empty($fileData['afile_attribute_alt'])) ? $fileData['afile_attribute_alt'] : $brand['brand_name']; ?>" title="<?php echo (!empty($fileData['afile_attribute_alt'])) ? $fileData['afile_attribute_alt'] : $brand['brand_name']; ?>">
                        </div>
                        <div class="brand-logo">
                            <img loading='lazy' data-ratio="<?php echo $ratio; ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'brand', array($brand['brand_id'], $siteLangId, 'COLLECTION_PAGE')) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo (!empty($fileData['afile_attribute_alt'])) ? $fileData['afile_attribute_alt'] : $brand['brand_name']; ?>" title="<?php echo (!empty($fileData['afile_attribute_alt'])) ? $fileData['afile_attribute_alt'] : $brand['brand_name']; ?>">
                        </div>
                    </a>
                <?php $i++;
                } ?>


            </div>
        </div>
    </section>
<?php } ?>