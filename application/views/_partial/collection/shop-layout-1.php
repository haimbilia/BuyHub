<?php
if (isset($collection['shops']) && count($collection['shops'])) { ?>
<section class="section" data-section="section">
    <div class="container">
        <div class="section-head">
            <div class="section-heading">
                <h2><?php echo ($collection['collection_name'] != '') ? $collection['collection_name'] : ''; ?></h2>
            </div>
            <?php if ($collection['totShops'] > Collections::LIMIT_SHOP_LAYOUT1) { ?>
            <div class="section-action">
                <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>"
                    class="link-underline"><?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?></a>
            </div>
            <?php } ?>
        </div>
        <?php include('shop-layout-1-list.php'); ?>

    </div>
</section>
<?php }
/* ] */