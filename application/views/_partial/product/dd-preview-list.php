<div class="detail-content">
    <div class="section-head">
        <div class="section-heading" id="prev-files">
            <h2>
                <?php echo Labels::getLabel('LBL_Preview_files', $siteLangId); ?>
            </h2>
        </div>
    </div>
    <div class="prev-files mb-5">
        <?php
        if (0 < count($product['preview_links']) || 0 < count($product['preview_attachments'])) {
            if (0 < count($product['preview_links'])) { ?>
                <h6 class="h6">
                    <?php echo Labels::getLabel('LBL_Links', $siteLangId); ?></h6>
                <ul class="list-files">
                    <?php
                    foreach ($product['preview_links'] as $keys => $link) {
                        if ('' == $link['pdl_preview_link']) {
                            continue;
                        }
                    ?>
                        <li>

                            <?php echo '<div class="clipboard">
                                <input class="copy-input" value="' . $link['pdl_preview_link'] . '" id="copypreview_' . $link['pdl_id'] . '" readonly> <button class="copy-btn" id="copyButton_' . $link['pdl_id'] . '" onclick="fcom.copyToClipboard(\'copypreview_' . $link['pdl_id'] . '\')">
       
                                                <svg class="svg" width="18" height="18">
                                                    <use xlink:href="' . CONF_WEBROOT_FRONTEND . 'images/retina/sprite.svg#copy-to-all">
                                                    </use>
                                                </svg>                                           
                                           
                                        </button>'; ?>


                        </li>

                    <?php } ?>
                </ul>
            <?php }
            if (0 < count($product['preview_attachments'])) { ?>
                <h6 class="prod-attached-files mt-4 h6"><?php echo Labels::getLabel('LBL_Attachments', $siteLangId); ?></h6>
                <ul class="list-files">
                    <?php foreach ($product['preview_attachments'] as $keys => $attachment) {
                        if (0 < strlen($attachment['preview'])) {
                            $fileExt = pathinfo($attachment['preview'], PATHINFO_EXTENSION);
                            $fileExt = strtolower($fileExt);
                            $videoPath = AttachedFile::getProductPreviewVideoUrl($attachment['prev_afile_id']); ?>
                            <li>
                                <div class="clipboard">
                                    <div class="copy-input">
                                        <?php echo $attachment['preview']; ?>
                                    </div>
                                    <div class="btn-group">
                                        <?php if (in_array($fileExt, applicationConstants::allowedVideoFileExtensions())) { ?>
                                            <button class="copy-btn play-preview" type="button" title="<?php echo $attachment['preview']; ?>" onclick="playVideo('<?php echo $videoPath; ?>', '<?php echo $fileExt; ?>','<?php echo $attachment['preview']; ?>','<?php echo $attachment['preview']; ?>'); return false;">
                                                <svg class="svg" width="18" height="18">
                                                    <use xlink:href="<?php echo  CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#icon-preview">
                                                    </use>
                                                </svg>
                                            </button>
                                        <?php } ?>
                                        <a class="copy-btn download-preview" target="_blank" href="<?php echo UrlHelper::generateFullUrl('Products', 'downloadPreview', array($attachment['prev_afile_id'], $product['selprod_id'])) . '/' . $attachment['preview']; ?>" title="<?php echo $attachment['preview']; ?>">
                                            <svg class="svg" width="18" height="18">
                                                <use xlink:href="<?php echo  CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#icon-download">
                                                </use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </li>
                    <?php
                        } /* closed if (0 < strlen($attachment['preview']) */
                    } /* foreach Attachments */ ?>
                </ul>
        <?php
            }
        } else {
            echo Labels::getLabel('LBL_No_preview_available', $siteLangId);
        }
        ?>
    </div>