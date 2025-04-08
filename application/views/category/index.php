<div id="body" class="body">
    <?php $this->includeTemplate('_partial/page-head-section.php', ['headLabel' => Labels::getLabel('LBL_SHOP_BY_CATEGORIES')]); ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="category-layout-2 category-layout-page">
                <?php foreach ($categoriesArr as $category) { ?>
                    <div class="category">
                        <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $category['prodcat_id']);
                        $uploadedTime = AttachedFile::setTimeParam($fileRow['afile_updated_at']);
                        ?>
                        <div class="category-head">
                            <?php
                            $pictureAttr = [
                                'webpImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'banner', array($category['prodcat_id'], $siteLangId, 'WEBP' . ImageDimension::VIEW_MEDIUM, 0, applicationConstants::SCREEN_DESKTOP, true)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp')],
                                'jpgImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_MEDIUM, 0, applicationConstants::SCREEN_DESKTOP, true)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg')],
                                'ratio' => '4:1',
                                'imageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_MEDIUM, 0, applicationConstants::SCREEN_DESKTOP, true)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                'alt' => '',
                                'title' => (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $category['prodcat_name'],
                                'siteLangId' => $siteLangId,
                            ];

                            $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                            ?>
                        </div>

                        <div class="category-body">
                            <ul class="category-list">
                                <li class="category-list-item category-list-head">
                                    <a
                                        href="<?php echo UrlHelper::generateUrl('Category', 'View', array($category['prodcat_id'])); ?>">
                                        <?php echo $category['prodcat_name']; ?>
                                    </a>
                                </li>
                                <?php
                                if (array_key_exists('children', $category) && 0 < count($category['children'])) {
                                    foreach ($category['children'] as $subCat) { ?>
                                        <li class="category-list-item">
                                            <a
                                                href="<?php echo UrlHelper::generateUrl('Category', 'View', array($subCat['prodcat_id'])); ?>">
                                                <?php echo $subCat['prodcat_name']; ?></a>
                                        </li>
                                        <?php
                                    }
                                } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {
        function resizeMasonryItem(item) {
            /* Get the grid object, its row-gap, and the size of its implicit rows */
            var grid = document.getElementsByClassName('masonry')[0],
                rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap')),
                rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));

            /*
             * Spanning for any brick = S
             * Grid's row-gap = G
             * Size of grid's implicitly create row-track = R
             * Height of item content = H
             * Net height of the item = H1 = H + G
             * Net height of the implicit row-track = T = G + R
             * S = H1 / T
             */
            var rowSpan = Math.ceil((item.querySelector('.masonry-content').getBoundingClientRect().height + rowGap) / (
                rowHeight + rowGap));

            /* Set the spanning as calculated above (S) */
            item.style.gridRowEnd = 'span ' + rowSpan;

            /* Make the images take all the available space in the cell/item */
            item.querySelector('.masonry-content').style.height = rowSpan * 10 + "px";
        }

        /**
         * Apply spanning to all the masonry items
         *
         * Loop through all the items and apply the spanning to them using 
         * `resizeMasonryItem()` function.
         *
         * @uses resizeMasonryItem
         */
        function resizeAllMasonryItems() {
            // Get all item class objects in one list
            var allItems = document.getElementsByClassName('masonry-item');

            /*
             * Loop through the above list and execute the spanning function to
             * each list-item (i.e. each masonry item)
             */
            for (var i = 0; i > allItems.length; i++) {
                resizeMasonryItem(allItems[i]);
            }
        }

        /**
         * Resize the items when all the images inside the masonry grid 
         * finish loading. This will ensure that all the content inside our
         * masonry items is visible.
         *
         * @uses ImagesLoaded
         * @uses resizeMasonryItem
         */
        function waitForImages() {
            var allItems = document.getElementsByClassName('masonry-item');
            for (var i = 0; i < allItems.length; i++) {
                imagesLoaded(allItems[i], function (instance) {
                    var item = instance.elements[0];
                    resizeMasonryItem(item);
                });
            }
        }

        /* Resize all the grid items on the load and resize events */
        var masonryEvents = ['load', 'resize'];
        masonryEvents.forEach(function (event) {
            window.addEventListener(event, resizeAllMasonryItems);
        });

        /* Do a resize once more when all the images finish loading */
        waitForImages();
    });
</script>