<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Guest_User', $siteLangId);?></h5>
</div>
<div class="modal-body">
    <div class="login-wrapper">
        <div class="form-side">
            <?php
            $frm->setFormTagAttribute('class', 'form form-checkout-login');
            $frm->setFormTagAttribute('name', 'frmGuestLogin');
            $frm->setFormTagAttribute('id', 'frmGuestLogin');
            $frm->setValidatorJsObjectName('guestLoginFormObj');

            $frm->setFormTagAttribute('onsubmit','return guestUserLogin(this, guestLoginFormObj);');
            $frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-12 col-xs-';
            $frm->developerTags['fld_default_col'] = 12;

            /* $fldSpace = $frm->getField('space');
            $fldSpace->value ='<a href="#" class="forgot">&nbsp;</a>'; */

            $fldSubmit = $frm->getField('btn_submit');
            $fldSubmit->addFieldTagAttribute("class","btn-block");
            $fldSubmit->developerTags['noCaptionTag'] = true;
            echo $frm->getFormHtml(); ?>
            <div class="row justify-content-center">
                <div class="col-auto text-center">
                    <a class="link" href="<?php echo UrlHelper::generateUrl('GuestUser', 'registrationForm'); ?>"><?php echo sprintf(Labels::getLabel('LBL_Not_Register_Yet?', $siteLangId), FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId));?></a>
                </div>
                <div class="col-auto text-center">
                    <a class="link" href="javascript:void(0)" onclick="openSignInForm(true)"><?php echo sprintf(Labels::getLabel('LBL_Existing_User?', $siteLangId), FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId));?></a>
                </div>
            </div>
        </div>
    </div>
</div>
