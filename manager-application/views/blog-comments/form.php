<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMENT_DETAILS', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="listview">
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Full_Name',$adminLangId); ?></dt>
                <dd><?php echo CommonHelper::displayName($data['bpcomment_author_name']);?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Email',$adminLangId); ?></dt>
                <dd><?php echo $data['bpcomment_author_email'];?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Posted_On',$adminLangId); ?></dt>
                <dd><?php echo FatDate::format($data['bpcomment_added_on']);?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Blog_Post_Title',$adminLangId); ?></dt>
                <dd><?php echo $data['post_title'];?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Comment',$adminLangId); ?></dt>
                <dd><?php echo nl2br($data['bpcomment_content']);?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_User_IP',$adminLangId); ?></dt>
                <dd><?php echo $data['bpcomment_user_ip'];?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_User_Agent',$adminLangId); ?></dt>
                <dd><?php echo $data['bpcomment_user_agent'];?></dd>
            </dl>
        </div>
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php 
                        if (0 < $recordId) {
                            echo Labels::getLabel('LBL_UPDATE', $adminLangId); 
                        } else {
                            echo Labels::getLabel('LBL_SAVE', $adminLangId); 
                        }
                    ?>
                </button>
            </div>
        </div>
    </div>
</div>