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
        <div class="listview">
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Full_Name',$siteLangId); ?></dt>
                <dd><?php echo CommonHelper::displayName($data['bpcomment_author_name']);?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Email',$siteLangId); ?></dt>
                <dd><?php echo $data['bpcomment_author_email'];?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Posted_On',$siteLangId); ?></dt>
                <dd><?php echo FatDate::format($data['bpcomment_added_on']);?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Blog_Post_Title',$siteLangId); ?></dt>
                <dd><?php echo $data['post_title'];?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Comment',$siteLangId); ?></dt>
                <dd><?php echo nl2br($data['bpcomment_content']);?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_User_IP',$siteLangId); ?></dt>
                <dd><?php echo $data['bpcomment_user_ip'];?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_User_Agent',$siteLangId); ?></dt>
                <dd><?php echo $data['bpcomment_user_agent'];?></dd>
            </dl>
        </div>
        <?php echo $frm->getFormHtml(); ?>
    </div>
    
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>