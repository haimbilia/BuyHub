<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_CONTRIBUTION_DETAIL', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <ul class="list-stats list-stats-double">
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_Full_Name', $siteLangId); ?></span>
                <span class='value'><?php echo CommonHelper::displayName($data['bcontributions_author_first_name'] . ' ' . $data['bcontributions_author_last_name']); ?></span>
            </li>
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_Email', $siteLangId); ?></span>
                <span class='value'><?php echo $data['bcontributions_author_email']; ?></span>
            </li>
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_Phone', $siteLangId); ?></span>
                <span class='value'><span class="default-ltr"><?php echo ValidateElement::formatDialCode($data['bcontributions_author_phone_dcode']) . $data['bcontributions_author_phone']; ?></span></span>
            </li>
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_Posted_On', $siteLangId); ?></span>
                <span class='value'><?php echo FatDate::format($data['bcontributions_added_on'],true); ?></span>
            </li>
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_Status', $siteLangId); ?></span>
                <span class='value'><?php echo $statusArr[$data['bcontributions_status']]; ?></span>
            </li>
            <?php if (!empty($attachedFile)) { ?>
                <li class="list-stats-item list-stats-item-full">
                    <span class='lable'><?php echo Labels::getLabel('LBL_Attached_File', $siteLangId); ?></span>
                    <span class='value'><a target="_new" href="<?php echo UrlHelper::generateUrl('BlogContributions', 'downloadAttachedFile', array($data['bcontributions_id'])); ?>"><?php echo $attachedFile; ?></a></span>
                </li>
            <?php } ?>
        </ul>
        <div class="separator separator-dashed my-4"></div>
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>