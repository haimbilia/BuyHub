<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$href = $href ?? "javascript:void(0)";
$onclick = !empty($onclick) ? "onclick = " . $onclick : "";

$uploadedTime = AttachedFile::setTimeParam($user['user_updated_on']);
$userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', array($user['user_id'],'MINITHUMB'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
$username = !empty($user['user_name']) ? $user['user_name'] . ' (' . $user['credential_username'] . ')' : $user['credential_username']; 
?>
<div class="user-profile">
    <figure class="user-profile_photo">
        <img width="40" height="40" title="<?php echo $user['user_name']; ?>" alt="<?php echo $user['user_name']; ?>" src="<?php echo $userImageUrl; ?>">
    </figure>
    <div class="user-profile_data">
        <a class="user-profile_title" href="<?php echo $href; ?>" <?php echo $onclick; ?>><?php echo $username; ?></a>
        <span class="text-muted"><?php echo $user['credential_email']; ?></span>
        <?php
        if (isset($user['extra_text']) || !empty($user['extra_text'])) {
            echo '<span>' . $user['extra_text'] . '</span>';
        }
        ?>
    </div>
</div>