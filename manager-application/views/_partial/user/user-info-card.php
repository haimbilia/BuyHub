<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$onclick = !empty($onclick) ? "onclick = " . $onclick : "";
$href = isset($href) && !empty($onclick) ? "javascript:void(0)" : '';
$extraClass = $extraClass ?? '';
$displayEmail = $displayEmail ?? true;
$userTitleClass = $userTitleClass ?? 'user-profile_title';
$title = $title ?? '';
$addVerifiedBadge = $addVerifiedBadge ?? false;
$displayProfileImage = $displayProfileImage ?? true;

$verifiedBadge = '';
if (true === $addVerifiedBadge) {
    $isverfied = (applicationConstants::NO == $user['credential_verified']);
    $class = $isverfied ? 'is-verified' : '';
    $verifiedTitle = $isverfied ? Labels::getLabel('LBL_VERIFIED', $siteLangId) : Labels::getLabel('LBL_NOT_VERIFIED', $siteLangId);
    $verifiedBadge = '<div class="verified ' . $class . '" data-bs-toggle="tooltip" data-bs-palcement="top" title="' . $verifiedTitle . '">
                    <svg class="svg" width="16" height="16">
                        <use
                            xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-verified">
                        </use>
                    </svg>
                </div>';
}

$username = !empty($user['user_name']) ? $user['user_name'] . ' (' . $user['credential_username'] . ')' : $user['credential_username'];
?>
<div class="user-profile <?php echo $extraClass; ?>">
    <?php if($displayProfileImage){
        $uploadedTime = AttachedFile::setTimeParam($user['user_updated_on']);
        $userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', array($user['user_id'], 'MINITHUMB', true), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    ?>
        <figure class="user-profile_photo">
            <img width="40" height="40" title="<?php echo $user['user_name']; ?>" alt="<?php echo $user['user_name']; ?>" src="<?php echo $userImageUrl; ?>">
        </figure>
    <?php } ?>
    <div class="user-profile_data">
        <div class="verified-wrap">
            <?php echo $verifiedBadge; ?>

            <?php if (!empty($href) || !empty($onclick)) { ?>
                <a class="<?php echo $userTitleClass; ?>" href="<?php echo $href; ?>" <?php echo $onclick; ?> title="<?php echo $title; ?>" data-bs-toggle="tooltip">
                    <?php echo $username; ?>
                </a>
            <?php } else { ?>
                <span class="<?php echo $userTitleClass; ?>"><?php echo $username; ?> </span>
            <?php } ?>
        </div>

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