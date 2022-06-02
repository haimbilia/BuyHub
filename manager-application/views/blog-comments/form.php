<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMENT_DETAILS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <ul class="list-stats">
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_Full_Name', $siteLangId); ?></span>
                <span class='value'><?php echo CommonHelper::displayName($data['bpcomment_author_name']); ?></span>
            </li>
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_Email', $siteLangId); ?></span>
                <span class='value'><?php echo $data['bpcomment_author_email']; ?></span>
            </li>
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_Posted_On', $siteLangId); ?></span>
                <span class='value'><?php echo FatDate::format($data['bpcomment_added_on']); ?></span>
            </li>
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_Blog_Post_Title', $siteLangId); ?></span>
                <span class='value'><?php echo $data['post_title']; ?></span>
            </li>           
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_User_IP', $siteLangId); ?></span>
                <span class='value'><?php echo $data['bpcomment_user_ip']; ?></span>
            </li>
            <li class="list-stats-item">
                <span class='lable'><?php echo Labels::getLabel('LBL_User_Agent', $siteLangId); ?></span>
                <span class='value'><?php echo $data['bpcomment_user_agent']; ?></span>
            </li>
        </ul>
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>