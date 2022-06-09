<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$liClass = $liClass ?? 'quick-nav-item item-desktop';
$aClass = $aClass ?? 'quick-nav-link';
if ($top_header_navigation && count($top_header_navigation)) { ?>
    <div class="offcanvas offcanvas-start offcanvas-seller-nav" tabindex="-1" id="offcanvas-seller-nav">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="seller-nav">
                <?php
                foreach ($top_header_navigation as $nav) {
                    if ($nav['pages']) {
                        foreach ($nav['pages'] as $link) {
                            $navUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']);
                            $OrgnavUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'], boolval(CONF_DEVELOPMENT_MODE)); ?>
                            <li class="<?php echo $liClass; ?>">
                                <a class="<?php echo $aClass; ?>" target="<?php echo $link['nlink_target']; ?>" data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $navUrl; ?>"><?php echo $link['nlink_caption']; ?></a>
                            </li>
                <?php }
                    }
                } ?>
            </ul>
        </div>
    </div>
<?php } ?>