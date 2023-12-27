<?php if (!empty($blogs)) {   ?>
    <ul class="text-suggestions p-2">
        <?php foreach ($blogs as $blog) { ?>
            <li class="text-suggestions-item">
                <a class="text-suggestions-link" href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blog['post_id'])); ?>"  data-txt="<?php echo $blog['post_title']; ?>"><span class=""><?php echo str_ireplace($keyword, "<b>$keyword</b>", $blog['post_title']); ?></span></a>
            </li>
        <?php } ?>
    </ul>
<?php }
