<?php if (isset($collection['blogs']) && count($collection['blogs']) > 0) { ?>
<section class="section" data-section="section">
    <div class="container">
        <header class="section-head">
            <?php echo (isset($collection['collection_name']) && $collection['collection_name'] != '') ? ' <div class="section-heading"><h2>' . $collection['collection_name'] . '</h2></div>' : ''; ?>
            <?php if (isset($collection['totBlogs']) && $collection['totBlogs'] > Collections::LIMIT_BLOG_LAYOUT1) { ?>
            <div class="section-foot">
                <div class="section-action">
                    <a class="link-underline" href="<?php echo UrlHelper::generateUrl('blog'); ?>">
                        <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
                    </a>
                </div>
            </div>
            <?php } ?>
        </header>
        <div class="row">
            <?php foreach ($collection['blogs'] as $blog) { ?>
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="post">
                    <div class="post-head">
                        <div class="post-media">
                            <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blog['post_id'])); ?>"
                                class="animate-scale">
                                <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $blog['post_id']);
                                        $uploadedTime = AttachedFile::setTimeParam($fileRow['afile_updated_at']);
                                        $pictureAttr = [
                                            'webpImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Image', 'blogPostFront', array($blog['post_id'], $siteLangId, "WEBP" . ImageDimension::VIEW_FEATURED)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp')],
                                            'jpgImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Image', 'blogPostFront', array($blog['post_id'], $siteLangId, ImageDimension::VIEW_FEATURED)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg')],
                                            'ratio' => '16:9',
                                            'imageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Image', 'blogPostFront', array($blog['post_id'], $siteLangId, ImageDimension::VIEW_FEATURED)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                            'alt' => (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $blog['post_title'],
                                            'siteLangId' => $siteLangId,
                                        ];
                                        $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                                        ?>

                            </a>
                        </div>
                    </div>
                    <div class="post-body">
                        <div class="article-inner">
                            <div class="blog_author">
                                <span class="article__author"><?php echo $blog['post_author_name']; ?></span>
                                <span class="article__date"><?php echo $blog['post_updated_on']; ?></span>
                            </div>
                            <h3 class="article-title">
                                <a
                                    href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blog['post_id'])); ?>">
                                    <span>
                                        <?php
                                                $title = !empty($blog['post_title']) ? $blog['post_title'] : $blog['post_identifier'];
                                                echo mb_strimwidth($title, 0, applicationConstants::BLOG_TITLE_CHARACTER_LENGTH, '...');
                                                ?>
                                    </span>
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>