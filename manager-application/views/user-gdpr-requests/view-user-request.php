<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_User_Request', $siteLangId); ?>
    </h5>
</div>
<main class="mainJs">
    <div class="modal-body form-edit pd-0">
        <div class="form-edit-body loaderContainerJs">
            <form class="modal-body form pd-0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label"><?php echo Labels::getLabel('LBL_Full_Name', $siteLangId); ?></label>
                            <div class=""><?php echo CommonHelper::displayNotApplicable($siteLangId, $userRequest['user_name']); ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label"><?php echo Labels::getLabel('LBL_Email', $siteLangId); ?></label>
                            <div class=""><?php echo $userRequest['credential_email']; ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label"><?php echo Labels::getLabel('LBL_Username', $siteLangId); ?></label>
                            <div class=""><?php echo $userRequest['credential_username']; ?></div>
                        </div>
                    </div>
                    <?php if (!empty($userRequest['ureq_purpose'])) { ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label"><?php echo Labels::getLabel('LBL_Purpose_of_request', $siteLangId); ?></label>
                                <div class=""><?php echo nl2br($userRequest['ureq_purpose']); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label"><?php echo Labels::getLabel('LBL_Request_Date', $siteLangId); ?></label>
                            <div class=""><?php echo FatDate::format($userRequest['ureq_date'],true); ?></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>