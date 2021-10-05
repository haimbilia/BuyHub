<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_CONTRIBUTION_DETAIL', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="listview">
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Full_Name',$adminLangId); ?></dt>
                <dd><?php echo CommonHelper::displayName($data['bcontributions_author_first_name'].' '.$data['bcontributions_author_last_name']);?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Email',$adminLangId); ?></dt>
                <dd><?php echo $data['bcontributions_author_email'];?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Phone',$adminLangId); ?></dt>
                <dd><?php echo ValidateElement::formatDialCode($data['bcontributions_author_phone_dcode']) . $data['bcontributions_author_phone'];?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Posted_On',$adminLangId); ?></dt>
                <dd><?php echo $data['bcontributions_added_on'];?></dd>
            </dl>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Status',$adminLangId); ?></dt>
                <dd><?php echo $statusArr[$data['bcontributions_status']];?></dd>
            </dl>
            <?php if(!empty($attachedFile)){?>
            <dl class="list">
                <dt><?php echo Labels::getLabel('LBL_Attached_File',$adminLangId); ?></dt>
                <dd><a target="_new" href="<?php echo UrlHelper::generateUrl('BlogContributions','downloadAttachedFile',array($data['bcontributions_id']));?>" ><?php echo $attachedFile; ?></a></dd>
            </dl>			
            <?php } ?>
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