<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<!-- offcanvas-mobile-menu -->
<div class="offcanvas offcanvas-start offcanvas-mobile-menu" tabindex="-1" id="blog-menu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"><?php echo Labels::getLabel('LBL_BLOG_POST_CATEGORIES'); ?> </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <?php if (!empty($categoriesArr)) { ?>
            <ul class="offcanvas-blog-nav">
                <?php
                foreach ($categoriesArr as $id => $cat) { ?>
                    <li class="offcanvas-blog-nav-item">
                        <a class="offcanvas-blog-nav-link" href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>">
                            <?php echo $cat; ?>
                            <i class="icon icon-arrow-right"></i>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>