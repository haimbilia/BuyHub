<?php
if (isset($collection['shops']) && count($collection['shops'])) { ?>
    <section class="section">
        <div class="container">
            <div class="section-head">
                <div class="section-heading">
                    <h2><?php echo ($collection['collection_name'] != '') ? $collection['collection_name'] : ''; ?></h2>
                </div>

            </div>
            <?php $collection = $collection['shops'];
            $collection['rating'] = $collection['rating'];
            $track = true;
            include('shop-layout-1-list.php'); ?>
            <?php if ($collection['totShops'] > Collections::LIMIT_SHOP_LAYOUT1) { ?>
                <div class="section-foot">
                    <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>" class="link-underline">
                        <?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?></a>
                </div>
            <?php }  ?>
        </div>
    </section>
<?php }
/* ] */
