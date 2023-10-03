<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$href = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']);
$target = $link['nlink_target'];
$childHtml = '';
if (0 < count($link['children'])) {
    $childHtml = $this->includeTemplate('_partial/navigation/mobile-nav-item-link-level.php', ['linkId' => $link['nlink_id'], 'children' => $link['children']], false, true);
}
$caption = $link['nlink_caption'];
?>

<li class="grouping-item groupingItemJs is-mobile">
    <span class="grouping-section groupingSectionJs">
        <a class="grouping-title groupingLinkJs" href="<?php echo $href; ?>" target="<?php echo $target; ?>"><?php echo $caption; ?></a>
        <?php if (0 < count($link['children'])) { ?>
            <button class="grouping-arrow collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navItem-<?php echo $link['nlink_id']; ?>" aria-expanded="false" aria-controls="navItem-<?php echo $link['nlink_id']; ?>">
                <?php if (0 < count($link['children'])) { ?>
                    <i class="grouping-arrow-icon dropdown-toggle-custom-arrow"></i>
                <?php } ?>
            </button>
        <?php } ?>
    </span>
    <?php if (0 < count($link['children'])) { ?>
        <div class="collapse collapseJs" id="navItem-<?php echo $link['nlink_id']; ?>" aria-labelledby="" data-bs-parent="#sidebarNavLinks">
            <?php echo $childHtml; ?>
        </div>
    <?php } ?>
</li>