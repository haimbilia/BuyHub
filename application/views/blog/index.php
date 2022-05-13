<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($postList)) {
    foreach ($postList as $blogPost) { ?>
        <section class="section">
            <div class="container">
                <div class="collection-1">
                    <div class="post">
                        <div class="post-head">
                            <figure class="post-media">
                                <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $blogPost['post_id']); ?>
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><img data-ratio="16:9" src="<?php echo UrlHelper::generateFileUrl('image', 'blogPostFront', array($blogPost['post_id'], $siteLangId, ImageDimension::VIEW_LAYOUT1), CONF_WEBROOT_URL); ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $blogPost['post_title']; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $blogPost['post_title']; ?>"></a>
                            </figure>
                        </div>
                        <div class="post-body">
                            <ul class="post-category">
                                <?php $categoryIds = !empty($blogPost['categoryIds']) ? explode(',', $blogPost['categoryIds']) : array();
                                $categoryNames = !empty($blogPost['categoryNames']) ? explode('~', $blogPost['categoryNames']) : array();
                                $categories = array_combine($categoryIds, $categoryNames);
                                foreach ($categories as $id => $name) { ?>
                                    <li class="post-category-tag">
                                        <a href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>"><?php echo $name; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <h1 class="post-title">
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo $blogPost['post_title'] ?>
                                </a>
                            </h1>
                            <p class="post-description">
                                <?php echo mb_strimwidth(strip_tags(html_entity_decode($blogPost['post_description'])), 0, 130, "..."); ?>
                            </p>
                            <a class="post-link" href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo Labels::getLabel('LBL_READ_MORE', $siteLangId); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php break;
    } ?>
<?php
} ?>
<?php $postList = array_slice($postList, 1);
if (!empty($postList)) { ?>
    <section class="section">
        <div class="container">
            <div class="collection-2">
                <?php $count = 1;
                foreach ($postList as $blogPost) { ?>
                    <div class="post">
                        <div class="post-head">
                            <figure class="post-media">
                                <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $blogPost['post_id']); ?>
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><img data-ratio="16:9" src="<?php echo UrlHelper::generateUrl('image', 'blogPostFront', array($blogPost['post_id'], $siteLangId, ImageDimension::VIEW_LAYOUT2), CONF_WEBROOT_URL); ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $blogPost['post_title']; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $blogPost['post_title']; ?>"></a>
                            </figure>
                        </div>
                        <div class="post-body">
                            <ul class="post-category">
                                <?php $categoryIds = !empty($blogPost['categoryIds']) ? explode(',', $blogPost['categoryIds']) : array();
                                $categoryNames = !empty($blogPost['categoryNames']) ? explode('~', $blogPost['categoryNames']) : array();
                                $categories = array_combine($categoryIds, $categoryNames);
                                foreach ($categories as $id => $name) { ?>
                                    <li class="post-category-tag">
                                        <a href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>">
                                            <?php echo $name; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <h2 class="post-title">
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo $blogPost['post_title'] ?></a>
                            </h2>
                        </div>
                        <div class="post-foot">
                            <a class="post-link" href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo Labels::getLabel('LBL_READ_MORE', $siteLangId); ?></a>
                        </div>
                    </div>
                <?php $count++;
                    if ($count > 9) {
                        break;
                    }
                } ?>
            </div>
        </div>
    </section>
<?php } ?>
<?php if (!empty($featuredPostList)) { ?>
    <section class="section bg-gray" data-collection="Featured blogs">
        <div class="container">
            <div class="section-head section-head-center">
                <div class="section-heading">
                    <h2>
                        <?php echo Labels::getLabel('LBL_Featured_Blogs', $siteLangId); ?>
                    </h2>
                </div>
                <?php if (count($featuredPostList) > 4) { ?>
                <?php } ?>
            </div>
            <div class="collection-2">
                <?php foreach ($featuredPostList as $blogPost) { ?>
                    <div class="post">
                        <div class="post-head">
                            <figure class="post-media">
                                <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $blogPost['post_id']); ?>
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>">
                                    <img data-ratio="16:9" src="<?php echo UrlHelper::generateUrl('image', 'blogPostFront', array($blogPost['post_id'], $siteLangId, ImageDimension::VIEW_FEATURED), CONF_WEBROOT_URL); ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $blogPost['post_title']; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $blogPost['post_title']; ?>"></a>
                            </figure>
                        </div>
                        <div class="post-body">
                            <ul class="post-category">
                                <?php $categoryIds = !empty($blogPost['categoryIds']) ? explode(',', $blogPost['categoryIds']) : array();
                                $categoryNames = !empty($blogPost['categoryNames']) ? explode('~', $blogPost['categoryNames']) : array();
                                $categories = array_combine($categoryIds, $categoryNames);
                                foreach ($categories as $id => $name) { ?>
                                    <li class="post-category-tag"><a href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>"><?php echo $name; ?></a></li>
                                <?php } ?>
                            </ul>
                            <h2 class="post-title"> <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo mb_substr($blogPost['post_title'], 0, 80); ?></a>
                            </h2>
                            <a class="post-link" href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo Labels::getLabel('LBL_READ_MORE', $siteLangId); ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<?php $postList = array_slice($postList, 2);
if (!empty($postList)) { ?>
    <section class="section">
        <div class="container">
            <div class="collection-1">
                <?php foreach ($postList as $blogPost) { ?>
                    <div class="post">
                        <div class="post-head">
                            <figure class="post-media">
                                <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $blogPost['post_id']); ?>
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><img data-ratio="16:9" src="<?php echo UrlHelper::generateUrl('image', 'blogPostFront', array($blogPost['post_id'], $siteLangId, ImageDimension::VIEW_LAYOUT1), CONF_WEBROOT_URL); ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $blogPost['post_title']; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $blogPost['post_title']; ?>"></a>
                            </figure>
                        </div>
                        <div class="post-body">
                            <ul class="post-category">
                                <?php $categoryIds = !empty($blogPost['categoryIds']) ? explode(',', $blogPost['categoryIds']) : array();
                                $categoryNames = !empty($blogPost['categoryNames']) ? explode('~', $blogPost['categoryNames']) : array();
                                $categories = array_combine($categoryIds, $categoryNames);
                                foreach ($categories as $id => $name) { ?>
                                    <li class="post-category-tag">
                                        <a href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>"><?php echo $name; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <h2 class="post-title">
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo $blogPost['post_title'] ?>
                                </a>
                            </h2>
                            <a class="post-link" href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo Labels::getLabel('LBL_READ_MORE', $siteLangId); ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
<?php if (!empty($popularPostList)) { ?>
    <section class="section" data-collection="Popular stories">
        <div class="container">
            <div class="section-head section-head-center">
                <div class="section-heading">
                    <h2>
                        <?php echo Labels::getLabel('LBL_Popular_Blogs', $siteLangId); ?>
                    </h2>
                </div>
            </div>
            <div class="collection-2">
                <?php foreach ($popularPostList as $blogPost) { ?>
                    <div class="post">
                        <div class="post-head">
                            <figure class="post-media">
                                <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $blogPost['post_id']); ?>
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>">
                                    <img data-ratio="16:9" src="<?php echo UrlHelper::generateUrl('image', 'blogPostFront', array($blogPost['post_id'], $siteLangId, ImageDimension::VIEW_FEATURED), CONF_WEBROOT_URL); ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $blogPost['post_title']; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $blogPost['post_title']; ?>"></a>
                            </figure>
                        </div>
                        <div class="post-body">
                            <ul class="post-category">
                                <?php $categoryIds = !empty($blogPost['categoryIds']) ? explode(',', $blogPost['categoryIds']) : array();
                                $categoryNames = !empty($blogPost['categoryNames']) ? explode('~', $blogPost['categoryNames']) : array();
                                $categories = array_combine($categoryIds, $categoryNames);
                                foreach ($categories as $id => $name) { ?>
                                    <li class="post-category-tag">
                                        <a href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>"><?php echo $name; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <h2 class="post-title">
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo mb_substr($blogPost['post_title'], 0, 80); ?></a>
                            </h2>
                            <a class="post-link" href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo Labels::getLabel('LBL_READ_MORE', $siteLangId); ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
<script>
    var layoutDirection = '<?php echo CommonHelper::getLayoutDirection(); ?>';
    var rtl = (layoutDirection == 'rtl') ? true : false;
    $(function() {
        $('.js-popular-stories').slick({
            dots: false,
            arrows: false,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            rtl: rtl,
            responsive: [{
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 1023,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.arrows--left').on('click', function() {
            $('.js-popular-stories').slick('slickPrev');
        })

        $('.arrows--right').on('click', function() {
            $('.js-popular-stories').slick('slickNext');
        });
    });
</script>
<?php echo $this->includeTemplate('_partial/shareThisScript.php');
