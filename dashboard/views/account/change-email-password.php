<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php');
$col = (true === $canSendSms) ? '4' : '6';
?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_UPDATE_CREDENTIALS', $siteLangId),
        'siteLangId' => $siteLangId
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-<?php echo $col; ?> col-md-<?php echo $col; ?> mb-3">
                <div class="card card-full-height">
                    <div class="card-head">
                        <h5 class="card-title "><?php echo Labels::getLabel('Lbl_UPDATE_EMAIL', $siteLangId); ?></h5>
                    </div>
                    <div class="card-body ">
                        <div id="changeEmailFrmBlock"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                    </div>
                </div>
            </div>
            <?php if ($hasEmailId) { ?>
                <div class="col-lg-<?php echo $col; ?> col-md-<?php echo $col; ?> mb-3">
                    <div class="card card-full-height">
                        <div class="card-head">
                            <h5 class="card-title "><?php echo Labels::getLabel('LBL_UPDATE_PASSWORD', $siteLangId); ?></h5>
                        </div>
                        <div class="card-body">
                            <div id="changePassFrmBlock"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (true === $canSendSms) { ?>
                <div class="col-lg-4 col-md-4 mb-3">
                    <div class="card card-full-height">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h5 class="card-title"><?php echo Labels::getLabel('Lbl_UPDATE_PHONE_NUMBER', $siteLangId); ?></h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="changePhoneNumberFrmBlock"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    var OTP_FOR_OLD_PHONE_NO = <?php echo User::OTP_FOR_OLD_PHONE_NO; ?>;
    var OTP_FOR_NEW_PHONE_NO = <?php echo User::OTP_FOR_NEW_PHONE_NO; ?>;
    var OTP_FOR_EMAIL = <?php echo User::OTP_FOR_EMAIL; ?>;
    $(document).ready(function() {
        <?php if ($hasEmailId) { ?>
            changePasswordForm();
            changeEmailForm();
        <?php } else { ?>
            changeEmailUsingPhoneForm1();
        <?php } ?>
        changePhoneNumberForm();
    });
</script>