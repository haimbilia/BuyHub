<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$remembermeField = $loginFrm->getField('remember_me');
$remembermeField->setWrapperAttribute("class", "rememberme-text");
$remembermeField->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
$remembermeField->developerTags['col'] = 6;
$remembermeField->developerTags['cbHtmlAfterCheckbox'] = '';

$fldforgot = $loginFrm->getField('forgot');
$fldforgot->value = '<a href="' . UrlHelper::generateUrl('GuestUser', 'forgotPasswordForm') . '"
    class="link-underline">' . Labels::getLabel('LBL_Forgot_Password?', $siteLangId) . '</a>';
$fldforgot->developerTags['col'] = 6;

$fld = $loginFrm->getField('username');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_USERNAME_OR_EMAIL', $siteLangId));
$pwdFld = $loginFrm->getField('password');
$pwdFld->addFieldTagAttribute('id', 'password');

echo $loginFrm->getFormTag(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo $loginFrm->getFieldHtml('username'); ?>
            </div>
        </div>
    </div>
    <div class="row pwdField--js">
        <div class="col-md-12">
            <div class="form-group form-group-relative">
                <?php echo $loginFrm->getFieldHtml('password'); ?>
                <span class="input-group-text field-password" id="showPass"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col remember--js">
            <div class="form-group">
                <?php
                $fld = $loginFrm->getFieldHTML('remember_me');
                $fld = str_replace("<label >", "", $fld);
                $fld = str_replace("</label>", "", $fld);
                echo $fld;
                ?>
            </div>
        </div>
    </div>
    <div class="row submitBtn--js">
        <div class="col-md-12">
            <div class="form-group"> <?php echo $loginFrm->getFieldHtml('btn_submit'); ?>
                <?php echo $loginFrm->getFieldHtml('fatpostsectkn'); ?>
            </div>
        </div>
    </div>
</form>