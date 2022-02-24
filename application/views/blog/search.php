<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="">
    <div class="container">
        <div class="blog-detail">
            <div class="blog-detail-left">
                <div class="collection-2" id="blogs-listing-js"></div>
            </div>
            <?php $this->includeTemplate('_partial/blogSidePanel.php', array('popularPostList' => $popularPostList, 'featuredPostList' => $featuredPostList)); ?>

        </div>
    </div>
</section>
<script type="text/javascript">
    var keyword = '<?php echo (isset($keyword)) ? $keyword : ''; ?>';
</script>