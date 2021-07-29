<div id="body" class="body">
    <div class="bg-brand-light pt-3 pb-3">
        <div class="container">
            <div class="section-head justify-content-center mb-0">
                <div class="section__heading">
                    <h2 class="mb-0"><?php echo Labels::getLabel('LBL_Shop_By_Categories', $siteLangId); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="masonry">
                <?php foreach ($categoriesArr as $category) { ?>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="categories-thumb">
                            <a
                                href="<?php echo UrlHelper::generateUrl('category', 'view', array($category['prodcat_id'])); ?>">
                                <div class="aspect-ratio" style="padding-bottom: 45%">
                                    <div class="categories-thumb-bg"
                                        style="background-image: url(<?php echo UrlHelper::generateFullFileUrl('Category', 'banner', array($category['prodcat_id'], $siteLangId)); ?>);">
                                    </div>
                                </div>
                                <h6 class="categories-thumb-heading"><?php echo $category['prodcat_name']; ?></h6>
                            </a>
                        </div>
                        <?php if (array_key_exists('childrens', $category) && 0 < count($category['childrens'])) { ?>
                        <ul>
                            <?php foreach ($category['childrens'] as $childCat) { ?>
                            <li>
                                <a
                                    href="<?php echo UrlHelper::generateUrl('category', 'view', array($childCat['prodcat_id'])); ?>">
                                    <?php echo $childCat['prodcat_name']; ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>
<script>
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
        imagesLoaded(allItems[i], function(instance) {
            var item = instance.elements[0];
            resizeMasonryItem(item);
        });
    }
}

/* Resize all the grid items on the load and resize events */
var masonryEvents = ['load', 'resize'];
masonryEvents.forEach(function(event) {
    window.addEventListener(event, resizeAllMasonryItems);
});

/* Do a resize once more when all the images finish loading */
waitForImages();
</script>