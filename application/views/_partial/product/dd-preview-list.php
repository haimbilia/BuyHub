<div class="detail-content">
    <div class="section-head">
        <div class="section__heading" id="prev-files">
            <h2><?php echo Labels::getLabel('LBL_Prev_files', $siteLangId); ?></h2>
        </div>
    </div>
    <div class="bg-gray p-4 mb-4">
        <?php 
        if (0 < count($product['preview_links']) || 0 < count($product['preview_attachments'])) {
            if (0 < count($product['preview_links'])) { ?>
                <div class="h6"><?php echo Labels::getLabel('LBL_Links', $siteLangId); ?></div>
                <ul class="list-files">
                    <?php
                    foreach ($product['preview_links'] as $keys => $link) {
                        if ('' == $link['pdl_preview_link']) {
                            continue;
                        }    
                    ?>
                        <li>
                            <?php echo '<div class="clipboard"><input class="copy-input" value="'.$link['pdl_preview_link'].'" id="copypreview_'. $link['pdl_id'] .'" readonly> <button class="btn btn-light btn-sm copy-btn" id="copyButton_'. $link['pdl_id'] .'" onclick="fcom.copyToClipboard(\'copypreview_'. $link['pdl_id'] .'\')"><i class="far fa-copy"></i></button><br />'; ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php }
            if (0 < count($product['preview_attachments'])) { ?>
                <div class="prod-attached-files"><?php echo Labels::getLabel('LBL_Attachments', $siteLangId); ?></div>
                <ul class="list-files">
                    <?php foreach ($product['preview_attachments'] as $keys => $attachment) {
                        if (0 < strlen($attachment['preview'])) {
                            $fileExt = pathinfo($attachment['preview'], PATHINFO_EXTENSION);
                            $fileExt = strtolower($fileExt);
                            $videoPath = AttachedFile::getProductPreviewVideoUrl($attachment['prev_afile_id']); ?>
                            <li>
                                <div class="text-break">
                                    <?php echo $attachment['preview']; ?>
                                </div>
                                <div class="btn-group">
                                    <?php if (in_array($fileExt, applicationConstants::allowedVideoFileExtensions())) { ?>
                                    <a class="btn btn-light btn-sm play-preview" href="javascript:void(0);"
                                        title="<?php echo $attachment['preview'];?>"
                                        onclick="playVideo('<?php echo $videoPath;?>', '<?php echo $fileExt;?>','<?php echo $attachment['preview'];?>','<?php echo $attachment['preview'];?>'); return false;">
                                        <i class="fa fa-caret-square-right icon"></i>
                                    </a>
                                    <?php } ?>
                                    <a class="btn btn-light btn-sm download--preview" target="_blank"
                                        href="<?php echo UrlHelper::generateFullUrl('Products', 'downloadPreview', array($attachment['prev_afile_id'], $product['selprod_id'])) . '/' . $attachment['preview']; ?>"
                                        title="<?php echo $attachment['preview']; ?>">
                                        <i class="fa fa-download icon"></i>
                                    </a>
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