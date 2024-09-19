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
                <ul class="list-stats list-stats-double">
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_Full_Name', $siteLangId); ?></span>
                        <span class="value"><?php echo CommonHelper::displayNotApplicable($siteLangId, $userRequest['user_name']); ?></span>
                    </li>
                    <?php if (!empty($userRequest['credential_email'])) { ?>
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_Email', $siteLangId); ?></span>
                            <span class="value"><?php echo $userRequest['credential_email']; ?></span>
                        </li>
                    <?php } ?>
                    <?php if (!empty($userRequest['user_phone'])) { ?>
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_PHONE', $siteLangId); ?></span>
                            <span class="value"><span class="default-ltr"><?php echo ValidateElement::formatDialCode($userRequest['user_phone_dcode']) . $userRequest['user_phone']; ?></span></span>
                        </li>
                    <?php } ?>
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_Username', $siteLangId); ?></span>
                        <span class="value"><?php echo $userRequest['credential_username']; ?></span>
                    </li>
                    <?php if (!empty($userRequest['ureq_purpose'])) { ?>
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_Purpose_of_request', $siteLangId); ?></span>
                            <span class="value"><?php echo nl2br($userRequest['ureq_purpose']); ?></span>
                        </li>
                    <?php } ?>
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_Request_Date', $siteLangId); ?></span>
                        <span class="value"><?php echo FatDate::format($userRequest['ureq_date'], true); ?></span>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</main>