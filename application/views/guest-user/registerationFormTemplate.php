<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$showLogInLink = isset($showLogInLink) ? $showLogInLink : true;
$onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : false;

if (isset($signUpWithPhone) && 0 < $signUpWithPhone) {
    $onSubmitFunctionName = 'return registerWithPhone';
}

$registerFrm->setFormTagAttribute('action', UrlHelper::generateUrl('GuestUser', 'register'));

if ($onSubmitFunctionName) {
    $registerFrm->setValidatorJsObjectName('SignUpValObj');
    $registerFrm->setFormTagAttribute('onsubmit', $onSubmitFunctionName . '(this, SignUpValObj); return(false);');
}
?>
<?php
$registerFrm->setFormTagAttribute('class', 'form');
$fldSubmit = $registerFrm->getField('btn_submit');
$fldSubmit->addFieldTagAttribute('class', 'btn btn-secondary btn-block');
$registerFrm->developerTags['colClassPrefix'] = 'col-lg-12  col-sm-';
$registerFrm->developerTags['fld_default_col'] = 12;

echo $registerFrm->getFormTag();
?>
<div class="row gx-2">
    <div class="col-lg-6">
        <div class="form-group">
            <?php echo $registerFrm->getFieldHtml('user_name'); ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <?php echo $registerFrm->getFieldHtml('user_username'); ?>
        </div>

    </div>
</div>
<?php if (isset($signUpWithPhone) && 0 < $signUpWithPhone) { ?>
    <div class="row gx-2">
        <div class="col-lg-12">
            <div class="form-group">
                <?php
                echo $registerFrm->getFieldHtml('user_phone');
                echo $registerFrm->getFieldHtml('user_phone_dcode');
                ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row gx-2">
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $registerFrm->getFieldHtml('user_email'); ?></div>
        </div>
    </div>
    <div class="row gx-2">
        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $registerFrm->getFieldHtml('user_password'); ?>
                <span class="text-muted form-text"><?php echo sprintf(Labels::getLabel('LBL_EXAMPLE_PASSWORD', $siteLangId), 'User@123') ?></span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $registerFrm->getFieldHtml('password1'); ?>
            </div>

        </div>
    </div>
<?php } ?>
<div class="row gx-2">
    <div class="col-lg-12">
        <div class="form-group">
            <label class="checkbox checkbox-flex py-2">
                <?php
                $fld = $registerFrm->getFieldHTML('agree');
                $fld = str_replace("<label >", "", $fld);
                $fld = str_replace("</label>", "", $fld);
                echo $fld;
                ?>
                <span class="label-txt">
                    <?php echo CommonHelper::replaceStringData(Labels::getLabel('LBL_I_AGREE_TO_THE_{TERMS-CONDITIONS}_AND_{PRIVACY-POLICY}', $siteLangId),
                        [
                            '{TERMS-CONDITIONS}' => "<a target='_blank' href='$termsAndConditionsLinkHref'>" . Labels::getLabel('LBL_TERMS_CONDITIONS', $siteLangId) . '</a>',
                            '{PRIVACY-POLICY}' => "<a target='_blank' href='$privacyPolicyLinkHref'>" . Labels::getLabel('LBL_PRIVACY_POLICY', $siteLangId) . '</a>'
                        ]
                    ); ?>
                </span>
            </label>
            <?php if ($registerFrm->getField('user_newsletter_signup')) { ?>

                <label class="checkbox checkbox-flex">
                    <?php
                    $fld = $registerFrm->getFieldHTML('user_newsletter_signup');
                    $fld = str_replace("<label >", "", $fld);
                    $fld = str_replace("</label>", "", $fld);
                    echo $fld;
                    ?>
                </label>
            <?php }
            if ((!isset($signUpWithPhone) || 1 > $signUpWithPhone) && $registerFrm->getField('isCheckOutPage')) {
                echo $registerFrm->getFieldHTML('isCheckOutPage');
            } ?>

        </div>
    </div>
</div>
<div class="row gx-2">
    <div class="col-lg-12">
        <div class="form-group">
            <?php echo $registerFrm->getFieldHTML('user_id'), $registerFrm->getFieldHTML('btn_submit'); ?>
            <?php echo (isset($signUpWithPhone) && 0 < $signUpWithPhone) ? $registerFrm->getFieldHTML('signUpWithPhone') : ''; ?>
            <?php echo $registerFrm->getFieldHtml('fatpostsectkn'); ?>
        </div>
    </div>
</div>
</form>
<?php echo $registerFrm->getExternalJs(); ?>