<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMENTS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <span class="lessContent<?php echo $offerId; ?>Js">
            <?php echo 200 < strlen((string)$comments) ? substr($comments, 0, 200) . ' ... <button class="link-underline showMoreJs" data-row-id="' . $offerId . '">' . Labels::getLabel('LBL_SHOW_MORE') . '</button>' : $comments; ?>
        </span>
        <span class="moreContent<?php echo $offerId; ?>Js" style="display:none">
            <?php echo $comments . ' <button class="link-underline showLessJs" data-row-id="' . $offerId . '">' . Labels::getLabel('LBL_SHOW_LESS') . '</button>'; ?>
        </span>
    </div>
</div>