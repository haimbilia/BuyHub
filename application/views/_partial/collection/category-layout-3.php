<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($collection['categories']) && count($collection['categories'])) { ?>
    <section class="section">
        <div class="container">
            <div class="section-head section-head-center">
                <?php echo ($collection['collection_name'] != '') ? ' <div class="section-heading"><h2>' . $collection['collection_name'] . '</h2></div>' : ''; ?>

                <?php if ($collection['totCategories'] > Collections::LIMIT_CATEGORY_LAYOUT3) { ?>
                    <div class="section-action"> <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>" class="link"><?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?></a>
                    </div>
                <?php }  ?>
            </div>
            <div class="category-layout-1">
                <?php foreach ($collection['categories'] as $category) {
                ?>
                    <div class="category">
                        <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $category['prodcat_id']);
                        $uploadedTime = AttachedFile::setTimeParam($fileRow['afile_updated_at']);
                        ?>
                        <div class="category-head">
                            <?php
                            $pictureAttr = [
                                'webpImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'image', array($category['prodcat_id'], $siteLangId, 'MEDIUM', applicationConstants::SCREEN_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp'),
                                'jpgImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'image', array($category['prodcat_id'], $siteLangId, 'MEDIUM', applicationConstants::SCREEN_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                'ratio' => '1:1',
                                'imageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'image', array($category['prodcat_id'], $siteLangId, 'MEDIUM', applicationConstants::SCREEN_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                'alt' => (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $category['prodcat_name'],
                                'siteLangId' => $siteLangId,
                            ];

                            $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                            ?>
                        </div>
                        <div class="category-body">
                            <ul class="category-list">
                                <li class="category-list-item category-list-head">
                                    <a href="<?php echo UrlHelper::generateUrl('Category', 'View', array($category['prodcat_id'])); ?>">
                                        <?php echo $category['prodcat_name']; ?>
                                    </a>
                                </li>
                                <?php $i = 1;
                                foreach ($category['subCategories'] as $subCat) { ?>
                                    <li class="category-list-item">
                                        <a href="<?php echo UrlHelper::generateUrl('Category', 'View', array($subCat['prodcat_id'])); ?>">
                                            <?php echo $subCat['prodcat_name']; ?></a>
                                    </li>
                                <?php $i++;
                                    if ($i > 5) {
                                        break;
                                    }
                                } ?>

                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>