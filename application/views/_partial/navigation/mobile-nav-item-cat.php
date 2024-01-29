<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$href = UrlHelper::generateUrl('category', 'view', array($link['prodcat_id']));
$childHtml = '';
if (0 < count($link['children'])) {
    $childHtml = $this->includeTemplate('_partial/navigation/mobile-nav-item-cat-level.php', ['prodcatId' => $link['prodcat_id'], 'level' => 2, 'children' => $link['children']], false, true);;
}
$caption = $link['prodcat_name'];
?>

<li class="grouping-item groupingItemJs">
    <span class="grouping-section groupingSectionJs">
        <a class="grouping-title groupingLinkJs" href="<?php echo $href; ?>"><?php echo $caption; ?></a>
        <?php if (0 < count($link['children'])) { ?>
            <button class="grouping-arrow dropdown-toggle-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navCatItem-<?php echo $link['prodcat_id']; ?>" aria-expanded="false" aria-controls="navCatItem-<?php echo $link['prodcat_id']; ?>">
                <?php if (0 < count($link['children'])) { ?>
                    <i class="grouping-arrow-icon dropdown-toggle-custom-arrow"></i>
                <?php } ?>
            </button>
        <?php } ?>
    </span>
    <?php if (0 < count($link['children'])) { ?>
        <div class="collapse collapseJs" id="navCatItem-<?php echo $link['prodcat_id']; ?>" aria-labelledby="" data-bs-parent="#sidebarNavLinks">
            <?php echo $childHtml; ?>
        </div>
    <?php } ?>
</li>