<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (isset($collection['categories']) && count($collection['categories'])) { ?>
    <section class="section" data-section="section">
        <div class="container">
            <header class="section-head section-head-center">
                <?php echo ($collection['collection_name'] != '') ? ' <div class="section-heading"><h2>' . $collection['collection_name'] . '</h2></div>' : ''; ?>
            </header>
            <div class="section-body">
                <div class="category-layout-2">
                    <?php foreach ($collection['categories'] as $category) { ?>
                        <div class="category">
                            <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $category['prodcat_id']);
                            $uploadedTime = AttachedFile::setTimeParam($fileRow['afile_updated_at']);
                            ?>
                            <div class="category-head">
                                <?php
                                $pictureAttr = [
                                    'webpImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'banner', array($category['prodcat_id'], $siteLangId, 'WEBP' . ImageDimension::VIEW_MEDIUM, 0, applicationConstants::SCREEN_DESKTOP, true)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp')],
                                    'jpgImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_MEDIUM, 0, applicationConstants::SCREEN_DESKTOP, true)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg')],
                                    'ratio' => '4:1',
                                    'imageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_MEDIUM, 0, applicationConstants::SCREEN_DESKTOP, true)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                    'alt' => (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $category['prodcat_name'],
                                    'title' => (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $category['prodcat_name'],
                                    'siteLangId' => $siteLangId,
                                ];

                                $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                                ?>
                            </div>

                            <div class="category-body">
                                <ul class="category-list">
                                    <li class="category-list-item category-list-head">
                                        <a
                                            href="<?php echo UrlHelper::generateUrl('Category', 'View', array($category['prodcat_id'])); ?>" title="<?php echo $category['prodcat_name']; ?>">
                                            <?php echo $category['prodcat_name']; ?>
                                        </a>
                                    </li>
                                    <?php $i = 1;
                                    foreach ($category['subCategories'] as $subCat) { ?>
                                        <li class="category-list-item">
                                            <a
                                                href="<?php echo UrlHelper::generateUrl('Category', 'View', array($subCat['prodcat_id'])); ?>" title="<?php echo $subCat['prodcat_name']; ?>">
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
            <?php if (count($collection['categories']) > Collections::LIMIT_CATEGORY_LAYOUT2) { ?>
                <div class="section-foot">
                    <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>"
                        class="link-underline">
                        <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>
<?php }
