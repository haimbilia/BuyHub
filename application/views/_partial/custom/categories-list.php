<?php
$catCount = 1;
foreach ($categoriesArr as $category) { ?>
    <h5 class="">
        <a href="<?php echo UrlHelper::generateUrl('category', 'view', array($category['prodcat_id'])); ?>"><?php echo $category['prodcat_name']; ?></a>
    </h5>
    <?php if (!empty($category['children'])) { ?>
        <div class="item">
            <ul>
                <?php foreach ($category['children'] as $subcat) { ?>
                    <li><a href="<?php echo UrlHelper::generateUrl('category', 'view', array($subcat['prodcat_id'])); ?>"> <?php echo $subcat['prodcat_name'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    <?php
    } ?>
<?php $catCount++;
} ?>