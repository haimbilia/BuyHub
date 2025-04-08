<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if ($rows) { ?>

    <ul class="footer-social">
        <?php foreach ($rows as $row) {
            $img = AttachedFile::getAttachment(AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE, $row['splatform_id']);
            $title = ($row['splatform_title'] != '') ? $row['splatform_title'] : $row['splatform_identifier']; ?>
            <li class="footer-social-item">
                <a class="footer-social-link" aria-label="<?php echo $title; ?>" <?php if ($row['splatform_url'] != '') { ?>target="_blank" rel="noopener" <?php } ?> href="<?php echo ($row['splatform_url'] != '') ? $row['splatform_url'] : 'javascript:void(0)'; ?>">
                    <?php
                    echo '<img ' . HtmlHelper::getImgDimParm(ImageDimension::TYPE_SOCIAL_PLATFORM, ImageDimension::VIEW_NORMAL) . ' class="footer-social-icon" alt="" src = "' . UrlHelper::generateFileUrl('Image', 'SocialPlatform', array($row['splatform_id'])) . '" aria-hidden="true"/>';
                    ?>
                    <span class="footer-social-text"><?php echo $title; ?></span>
                </a>
            </li>
        <?php
        } ?>
    </ul>

<?php } ?>