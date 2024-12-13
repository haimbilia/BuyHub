<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$selectorClass = $selectorClass ?? '';
?>
<ul class="grouping grouping-level grouping-level-<?php echo $level; ?>" id="level-cat-<?php echo $prodcatId; ?>">
    <?php foreach ($children as $child) {
        $href = UrlHelper::generateUrl('category', 'view', array($child['prodcat_id']));
        $childLevelHtml = '';
        if (0 < count($child['children'])) {
            $childLevelHtml = $this->includeTemplate('_partial/navigation/mobile-nav-item-cat-level.php', ['prodcatId' => $child['prodcat_id'], 'children' => $child['children'], 'selectorClass' => $selectorClass, 'level' => ($level + 1)], false, true);
        }
        $caption = $child['prodcat_name'];
        ?>
        <li class="grouping-item groupingItemJs">
            <span class="grouping-section groupingSectionJs">
                <a class="grouping-title groupingLinkJs" href="<?php echo $href; ?>"><?php echo $caption; ?></a>
                <?php if (0 < count($child['children'])) { ?>
                    <button class="grouping-arrow dropdown-toggle-custom collapseBtnJs collapsed" type="button"
                        data-bs-toggle="collapse" aria-expanded="false"
                        data-bs-target="#<?php echo $selectorClass; ?>navCatItem-<?php echo $child['prodcat_id']; ?>"
                        aria-controls="<?php echo $selectorClass; ?>navCatItem-<?php echo $child['prodcat_id']; ?>">
                        <i class="grouping-arrow-icon dropdown-toggle-custom-arrow"></i>
                    </button>
                <?php } ?>
            </span>
            <?php if (0 < count($child['children'])) { ?>
                <div class="collapse collapseJs"
                    id="<?php echo $selectorClass; ?>navCatItem-<?php echo $child['prodcat_id']; ?>"
                    data-bs-parent="#level-cat-<?php echo $prodcatId; ?>">
                    <?php echo $childLevelHtml; ?>
                </div>
            <?php } ?>
        </li>
    <?php } ?>
</ul>