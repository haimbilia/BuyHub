<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($footer_navigation)) { ?>
<?php foreach ($footer_navigation as $nav) { ?>
<div class="col-lg-4 col-md-4 mb-3 mb-md-0">
    <div class="footer-group">
        <h4 class="footer-group-head dropdown-toggle-custom" data-bs-toggle="collapse"
            data-bs-target="#collapseWidthExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            <?php echo $nav['parent']; ?><i class="dropdown-toggle-custom-arrow"></i>
        </h4>
        <ul class="footer-nav collapse" id="collapseWidthExample">
            <?php if ($nav['pages']) {
                        $getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
                        foreach ($nav['pages'] as $link) {
                            $navUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']);
                            $OrgnavUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'], $getOrgUrl); ?>
            <li class="footer-nav-item">
                <a class="footer-nav-link" target="<?php echo $link['nlink_target']; ?>"
                    data-org-url="<?php echo $OrgnavUrl; ?>"
                    href="<?php echo $navUrl; ?>"><?php echo $link['nlink_caption']; ?>
                </a>
            </li>
            <?php }
                    } ?>
        </ul>

    </div>
</div>
<?php }
} ?>