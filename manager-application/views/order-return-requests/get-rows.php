<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$count = 1;
$month = 0;

$lastDateRef = isset($postedData['reference']) ? date('Y-m-d', strtotime($postedData['reference'])) : '';
foreach ($arrListing as $sn => $row) {
    $currentRef = FatDate::format($row['orrmsg_date']);
    $newDate = false;
    if ($lastDateRef != $currentRef) {
        $lastDateRef = $currentRef;
        $newDate = true;
        if ($count != 1) {
            echo "</li>";
        }
    }

    if ($count != 1 && 0 < $month && $month != date("m", strtotime($row['orrmsg_date']))) {
?>
        <li class="timeline-item period">
            <div class="timeline-info"></div>
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <h2 class="timeline-title"><?php echo date("F m, Y", strtotime($row['orrmsg_date'])); ?></h2>
            </div>
        </li>
    <?php
    }
    if ($newDate) { ?>
        <li class="timeline-item rowJs " data-reference="<?php echo date('Y-m-d', strtotime($row['orrmsg_date'])); ?>">
            <div class="timeline-info">
                <span><?php echo $currentRef; ?></span>
            </div>
            <div class="timeline-marker"></div>
        <?php } ?>
        <div class="timeline-content">
            <h3 class="timeline-title">
                <?php
                $imageUserDimensions = ImageDimension::getData(ImageDimension::TYPE_USER, ImageDimension::VIEW_THUMB);
                $img = '<img data-aspect-ratio = "' . $imageUserDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'] . '" title="' . $row['msg_user_name'] . '" src = "' . UrlHelper::generateFileUrl('Image', 'User', array($row['orrmsg_from_user_id'], ImageDimension::VIEW_THUMB, 1), CONF_WEBROOT_FRONT_URL) . '" alt = "' . $row['msg_user_name'] . '" >';

                $name = '<a class="user-profile_title" href="javascript:void(0)" onclick="redirectUser(' . $row['orrmsg_from_user_id'] . ')">' . $row['msg_user_name'] . ' (' . $row['msg_username'] . ')</a>';
                $email = $row['msg_user_email'];

                if ($row['orrmsg_from_admin_id']) {
                    $name = $row['admin_name'] . ' (' . $row['admin_username'] . ')';
                    $email = $row['admin_email'];
                    $img = '<img width="40" height="40" title="' . $row['admin_name'] . '" src = "' . UrlHelper::generateFileUrl('Image', 'siteAdminLogo', array($siteLangId)) . '" alt = "' . $row['admin_name'] . '" >';
                }
                ?>
                <div class="user-profile">
                    <figure class="user-profile_photo">
                        <?php echo $img; ?>
                    </figure>
                    <div class="user-profile_data">
                        <?php echo $name; ?>
                        <span class="text-muted">
                            <?php echo $email; ?>
                        </span>
                    </div>
                </div>
            </h3>
            <p>
                <?php echo nl2br($row['orrmsg_msg']); ?>
                <span><?php echo date('H:i', strtotime($row['orrmsg_date'])); ?></span>
            </p>
        </div>
    <?php
    if (count($arrListing) == $count) {
        echo '</div>';
    }
    $month = date("m", strtotime($row['orrmsg_date']));
    $count++;
}
