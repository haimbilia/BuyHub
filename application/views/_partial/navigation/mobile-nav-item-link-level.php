<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<ul class="grouping grouping-level" id="level-link-<?php echo $linkId; ?>">
    <?php foreach ($children as $child) {
        $href = CommonHelper::getnavigationUrl($child['nlink_type'], $child['nlink_url'], $child['nlink_cpage_id'], $child['nlink_category_id']);
        $target = $child['nlink_target'];
        $childLevelHtml = '';
        if (0 < count($child['children'])) {
            $childLevelHtml = $this->includeTemplate('_partial/navigation/mobile-nav-item-link-level.php', ['linkId' => $child['nlink_id'], 'children' => $child['children']], false, true);
        }
        $caption = $child['nlink_caption'];
    ?>
        <li class="grouping-item groupingItemJs">
            <span class="grouping-section groupingSectionJs">
                <a class="grouping-title groupingLinkJs" href="<?php echo $href; ?>" target="<?php echo $target; ?>"><?php echo $caption; ?></a>
                <?php if (0 < count($child['children'])) { ?>
                    <button class="grouping-arrow dropdown-toggle-custom collapseBtnJs collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#navItem-<?php echo $child['nlink_id']; ?>" aria-controls="navItem-<?php echo $child['nlink_id']; ?>">
                        <i class="grouping-arrow-icon dropdown-toggle-custom-arrow"></i>
                    </button>
                <?php } ?>
            </span>
            <?php if (0 < count($child['children'])) { ?>
                <div class="collapse collapseJs" id="navItem-<?php echo $child['nlink_id']; ?>" data-bs-parent="#level-link-<?php echo $linkId; ?>">
                    <?php echo $childLevelHtml; ?>
                </div>
            <?php } ?>
        </li>
    <?php } ?>
</ul>