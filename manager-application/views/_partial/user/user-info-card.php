<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$onclick = !empty($onclick) ? "onclick = " . $onclick : "";
$href = isset($href) && !empty($onclick) ? "javascript:void(0)" : '';
$extraClass = $extraClass ?? '';
$displayEmail = $displayEmail ?? true;
$userTitleClass = $userTitleClass ?? 'user-profile_title';
$title = $title ?? '';

$uploadedTime = AttachedFile::setTimeParam($user['user_updated_on']);
$userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', array($user['user_id'], 'MINITHUMB', true), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
$username = !empty($user['user_name']) ? $user['user_name'] . ' (' . $user['credential_username'] . ')' : $user['credential_username'];
?>
<div class="user-profile <?php echo $extraClass; ?>">
    <figure class="user-profile_photo">
        <img width="40" height="40" title="<?php echo $user['user_name']; ?>" alt="<?php echo $user['user_name']; ?>" src="<?php echo $userImageUrl; ?>">
    </figure>
    <div class="user-profile_data">
        <?php if (!empty($href) || !empty($onclick)) { ?>
            <a class="<?php echo $userTitleClass; ?>" href="<?php echo $href; ?>" <?php echo $onclick; ?> title="<?php echo $title; ?>" data-bs-toggle="tooltip">
                <?php echo $username; ?>
            </a>
        <?php } else {
            echo $username;
        } ?>
        <?php if ($displayEmail) { ?>
            <span class="text-muted"><?php echo $user['credential_email']; ?></span>
        <?php } ?>
        <?php
        if (isset($user['extra_text']) || !empty($user['extra_text'])) {
            echo '<span>' . $user['extra_text'] . '</span>';
        }
        ?>
    </div>
</div>