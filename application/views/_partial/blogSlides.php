<section>
    <div class="js-posts-slider posts-slider" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
        <?php foreach ($postList as $blogPost) { ?>
            <div class="post-item">
                <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $blogPost['post_id']); ?>
                <div class="post-media"><img src="<?php echo UrlHelper::generateFileUrl('image', 'blogPostFront', array($blogPost['post_id'], $siteLangId, ImageDimension::VIEW_LAYOUT1), CONF_WEBROOT_URL); ?>" data-ratio="16:9" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $blogPost['post_title']; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $blogPost['post_title']; ?>" class="img"></div>
                <div class="post-data">
                    <div class="date-wrap"><span class="tag"><?php echo Labels::getLabel('Lbl_Latest_Post', $siteLangId); ?></span>
                    </div>
                    <div class="post-heading">
                        <h2><?php echo $blogPost['post_title']; ?>
                        </h2>
                    </div>
                    <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>" class="links"><?php echo Labels::getLabel('Lbl_Read_More', $siteLangId); ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>