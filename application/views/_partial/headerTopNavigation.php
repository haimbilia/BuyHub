<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$liClass = $liClass ?? 'quick-nav-item item-desktop';
$aClass = $aClass ?? 'quick-nav-link';

if ($top_header_navigation && count($top_header_navigation)) {
    foreach ($top_header_navigation as $nav) {
        if ($nav['pages']) {
            $noOfCharAllowedInNav = 60;
            $navLinkCount = 0;
            foreach ($nav['pages'] as $nlink) {
                $noOfCharAllowedInNav = $noOfCharAllowedInNav - mb_strlen($nlink['nlink_caption']);
                if ($noOfCharAllowedInNav < 0) {
                    break;
                }
                $navLinkCount++;
            }
            $mainNavigation = array_slice($nav['pages'], 0, $navLinkCount, true);
            $hiddenNavs = array_slice($nav['pages'], count($mainNavigation));
            $getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
            foreach ($mainNavigation as $link) {
                $navUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']);
                $OrgnavUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'], $getOrgUrl); ?>
                <li class="<?php echo $liClass; ?>">
                    <a class="<?php echo $aClass; ?>" target="<?php echo $link['nlink_target']; ?>" data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $navUrl; ?>"><?php echo $link['nlink_caption']; ?></a>
                </li>
            <?php }
            if (!empty($hiddenNavs)) { ?>
                <li class="nav-blog-item">
                    <a class="nav-blog-link nav-nav-more" data-bs-toggle="collapse" href="#nav-more" role="button" aria-expanded="false" aria-controls="nav-more">
                        <?php echo Labels::getLabel('LBL_MORE'); ?>
                    </a>
                    <div class="collapse nav-more" id="nav-more">
                        <div class="container">
                            <ul>
                                <?php
                                foreach ($hiddenNavs as $link) {
                                    $navUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id']); ?>
                                    <li>
                                        <a href="<?php echo $navUrl; ?>">
                                            <?php echo $link['nlink_caption']; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </li>
        <?php }
        }
    }
} ?>