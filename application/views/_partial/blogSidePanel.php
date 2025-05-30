<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="blog-detail-right">
    <?php if (!empty($popularPostList) || (!empty($featuredPostList))) { ?>
        <div class="">
            <ul class="js-tabs tabs-blog">
                <?php if (!empty($popularPostList)) { ?>
                    <li class="is--active">
                        <a href="#/tab-1">
                            <?php echo Labels::getLabel('LBL_Popular', $siteLangId) ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if (!empty($featuredPostList)) { ?>
                    <li>
                        <a href="#/tab-2">
                            <?php echo Labels::getLabel('LBL_Featured', $siteLangId) ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <div class="tabs-content">
                <?php if (!empty($popularPostList)) { ?>
                    <div id="tab-1" class="content-data" style="display: block;">
                        <ul>
                            <?php foreach ($popularPostList as $blogPost) { ?>
                                <li>
                                    <div class="post">
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
                                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>">
                                                    <?php echo mb_substr($blogPost['post_title'], 0, 80); ?></a>
                                            </h2>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <?php if (!empty($featuredPostList)) { ?>
                    <div id="tab-2" class="content-data">
                        <ul>
                            <?php foreach ($featuredPostList as $blogPost) { ?>
                                <li>
                                    <div class="post">
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
                                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo mb_substr($blogPost['post_title'], 0, 80); ?>
                                                </a>
                                            </h2>

                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <a href="<?php echo UrlHelper::generateUrl('Blog', 'contributionForm'); ?>" class="btn btn-brand btn--lg btn-block ripplelink btn--contribute"> <?php echo Labels::getLabel('Lbl_Contribute', $siteLangId); ?>
    </a>
</div>



<?php /*if (!empty($categoriesArr)) { ?>
<h3 class="widget__title -style-uppercase"><?php echo Labels::getLabel('Lbl_categories', $siteLangId); ?></h3>
<div class="">
    <nav class="nav nav--toggled nav--toggled-js">
        <ul class="blog_lnks accordion">
            <?php foreach ($categoriesArr as $cat) { ?>
            <li class="<?php echo (count($cat['children'])>0) ? "has-child" : "" ?>"><a
                    href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($cat['bpcategory_id'])); ?>"><?php echo $cat['bpcategory_name']; echo !empty($cat['countChildBlogPosts'])?" <span class='badge'>($cat[countChildBlogPosts])</span>":''; ?></a>
                <?php if (count($cat['children'])) { ?>
                <span class="link--toggle link--toggle-js"></span>
                <ul style="display:none">
                    <?php foreach ($cat['children'] as $children) { ?>
                    <li><a
                            href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($children['bpcategory_id'])); ?>"><?php echo $children['bpcategory_name']; echo !empty($children['countChildBlogPosts'])?" <span class='badge'>($children[countChildBlogPosts])</span>":''; ?></a>
                        <?php if (count($children['children'])) { ?>
                        <ul class="">
                            <?php foreach ($children['children'] as $subChildren) { ?>
                            <li class="">
                                <a href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($subChildren['bpcategory_id'])); ?>"><?php echo $subChildren['bpcategory_name']; ?></a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php }?>
                    </li>
                    <?php }?>
                </ul>
                <?php }?>
            </li>
            <?php }?>
        </ul>
    </nav>
</div>
<?php }*/ ?>

<script>
    $(function() {
        /* for blog links */
        $('.link--toggle-js').on('click', function() {
            if ($(this).hasClass('is-active')) {
                $(this).removeClass('is-active');
                $(this).next('.nav--toggled-js > ul > li ul').find('.link--toggle-js').removeClass('is-active');
                $(this).next('.nav--toggled-js > ul > li ul').slideUp();
                $(this).next('.nav--toggled-js > ul > li ul').find('.nav--toggled-js > ul > li ul').slideUp();
                return false;
            }
            $('.link--toggle-js').removeClass('is-active');
            $(this).addClass("is-active");
            $(this).parents('ul').each(function() {
                $(this).siblings('span').addClass('is-active');
            });
            $(this).closest('ul').find('li .nav--toggled-js > ul > li ul').slideUp();
            $(this).next('.nav--toggled-js > ul > li ul').slideDown();
        });
    });
</script>