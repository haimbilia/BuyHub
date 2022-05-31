<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<!-- offcanvas-mobile-menu -->
<div class="offcanvas offcanvas-start offcanvas-mobile-menu" tabindex="-1" id="blog-menu">
    <?php if (!empty($categoriesArr)) { ?>
        <ul class="nav-blog">
            <?php
            foreach ($categoriesArr as $id => $cat) { ?>
                <li class="nav-blog-item">
                    <a class="nav-blog-link" href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>">
                        <?php echo $cat; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>