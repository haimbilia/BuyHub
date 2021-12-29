<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$theDay = '';
$count = 1;
foreach ($arrListing as $sn => $row) {
    $headTitle = HtmlHelper::getTheDay($row['acsh_added_on'], $siteLangId);
    if ($theDay != $headTitle) {
        $theDay = $headTitle;
        if ($count != 1) {
            echo '</ul></div>';
        } ?>
        <div class="rowJs" data-reference="<?php echo date('Y-m-d', strtotime($row['acsh_added_on'])); ?>">
            <div class="timeline-v4__item-date">
                <span class="tag">
                    <?php echo $headTitle; ?>
                </span>
            </div>
            <ul class="timeline-v4__items ulJs">
    <?php } ?>

    <li class="timeline-v4__item">
        <span class="timeline-v4__item-time"><?php echo date('H:i', strtotime($row['acsh_added_on'])); ?></span>
        <div class="timeline-v4__item-desc">
            <span class="timeline-v4__item-value badge badge-success">
                <span class="tag"><?php echo CommonHelper::numberFormat($row['acsh_afcommsetting_fees']); ?>%</span>
            </span>
            <?php if (!empty($row['prodcat_name'])) { ?>
                <span class="timeline-v4__item-textarea">
                    <strong><?php echo Labels::getLabel('LBL_Category', $siteLangId); ?>:</strong>
                    <?php echo  CommonHelper::displayText($row['prodcat_name']); ?>
                </span>
            <?php } ?>
            <?php if (!empty($row['vendor'])) { ?>
                <span class="timeline-v4__item-user-name">
                    <a data-bs-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('LBL_AFFILIATE_USER', $siteLangId); ?>" href="javascript:void(0);" onclick="redirectUser(<?php echo $row['vendor_id']; ?>)" class="timeline-v4__item-link user-profile user-profile-sm">
                        <figure class="user-profile_photo">
                            <?php 
                            $uploadedTime = AttachedFile::setTimeParam($row['user_updated_on']);
                            $userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', array($row['vendor_id'], 'MINITHUMB'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>
                            <img width="40" height="40" title="<?php echo CommonHelper::displayText($row['vendor']); ?>" alt="<?php echo CommonHelper::displayText($row['vendor']); ?>" src="<?php echo $userImageUrl; ?>">
                        </figure>
                        <div class="user-profile_data"><?php echo CommonHelper::displayText($row['vendor']); ?></div>
                    </a>
                </span>
            <?php } ?>
        </div>
    </li>

    <?php if (count($arrListing) == $count) {
        echo '</ul></div>';
    }
    $count++;
}
