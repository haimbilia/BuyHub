<?php if (isset($collection['brands']) && count($collection['brands']) > 0) { ?>
<section class="section" data-section="section">
    <div class="container">
        <div class="section-head">
            <?php echo ($collection['collection_name'] != '') ? ' <div class="section-heading"><h2>' . $collection['collection_name'] . '</h2></div>' : ''; ?>
            <?php if ($collection['totBrands'] > Collections::LIMIT_BRAND_LAYOUT1) { ?>
            <div class="section-action">
                <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>"
                    class="link-underline"><?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?></a>
            </div>
            <?php } ?>
        </div>
        <div class="brand-layout-1"
            data-view="<?php echo (0 < $collection['collection_primary_records'] ? $collection['collection_primary_records'] : 1); ?>">
            <?php $i = 0;
                foreach ($collection['brands'] as $brand) { ?>
            <div class="brand">
                <a class="brand-logo"
                    href="<?php echo UrlHelper::generateUrl('brands', 'View', array($brand['brand_id'])); ?>">
                    <?php
                            $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_LOGO, $brand['brand_id'], 0, 0, false);
                            $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                            $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                            $ratio = "";
                            if (isset($fileData['afile_aspect_ratio']) && $fileData['afile_aspect_ratio'] > 0 && isset($aspectRatioArr[$fileData['afile_aspect_ratio']])) {
                                $ratio = $aspectRatioArr[$fileData['afile_aspect_ratio']];
                            } ?>
                    <img loading='lazy' data-ratio="<?php echo $ratio; ?>"
                        src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'brand', array($brand['brand_id'], $siteLangId, ImageDimension::VIEW_COLLECTION_PAGE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>"
                        alt="<?php echo (!empty($fileData['afile_attribute_alt'])) ? $fileData['afile_attribute_alt'] : $brand['brand_name']; ?>"
                        title="<?php echo (!empty($fileData['afile_attribute_alt'])) ? $fileData['afile_attribute_alt'] : $brand['brand_name']; ?>">

                </a>
            </div>
            <?php $i++;
                } ?>
        </div>


    </div>
</section>
<?php } ?>