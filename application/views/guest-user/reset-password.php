<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 <?php echo (empty($pageData)) ? '' : '';?>">
                    <div class="section-head">
                        <div class="section__heading mb-3">
                            <h3><?php echo empty($user_password) ? Labels::getLabel('LBL_SET_PASSWORD', $siteLangId): Labels::getLabel('LBL_Reset_Password', $siteLangId);?></h3>
                            <p><?php echo empty($user_password) ? Labels::getLabel('LBL_SET_PASSWORD_MSG', $siteLangId) : Labels::getLabel('LBL_Reset_Password_Msg', $siteLangId); ?></p>
                        </div>
                    </div>
                    <?php
                    $frm->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_POSITION_NONE);
                    $frm->setFormTagAttribute('class', 'form');
                    $frm->setValidatorJsObjectName('resetValObj');
                    $frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
                    $frm->developerTags['fld_default_col'] = 12;
                    $frm->setFormTagAttribute('action', '');
                    $btnFld = $frm->getField('btn_submit');
                    $btnFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
                    if(empty($user_password)){
                        $btnFld->value = Labels::getLabel('LBL_SET_PASSWORD', $siteLangId);   
                    }
                    
                    $frm->setFormTagAttribute('onSubmit', 'resetpwd(this, resetValObj); return(false);');
                    $passFld = $frm->getField('new_pwd');
                    $passFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_NEW_PASSWORD', $siteLangId));
                    $confirmFld = $frm->getField('confirm_pwd');
                    $confirmFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_CONFIRM_NEW_PASSWORD', $siteLangId)); 
                    $fld = $frm->getField('user_name');
                    $fld->setFieldTagAttribute('disabled', 'disabled');
                    $fld->value = $credential_username;
                    
                    echo $frm->getFormHtml();
                    ?>
                    
                </div>
                <?php if (!empty($pageData)) {
                              $this->includeTemplate('_partial/GuestUserRightPanel.php', $pageData, false);
                          } ?>
            </div>
        </div>
    </section>
</div>
