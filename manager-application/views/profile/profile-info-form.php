<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$userNameFld = $frm->getField('admin_username');
$userNameFld->addFieldTagAttribute('id', 'admin_username');

$emailFld = $frm->getField('admin_email');
$emailFld->addFieldTagAttribute('id', 'admin_email');

$nameFld = $frm->getField('admin_name');

$frm->setFormTagAttribute('id', 'profileInfoFrm');
$frm->setFormTagAttribute('class', 'form form-horizontal');
$frm->developerTags['fld_default_col'] = 6;
$frm->setFormTagAttribute('onsubmit', 'updateProfileInfo(this); return(false);');

$imageFld = $frm->getField('user_profile_image');
$imageFld->addFieldTagAttribute('onChange','popupImage(this)');
$imageFld->addFieldTagAttribute('accept','image/*');
?>
<div class="card">
    <div class="card-head">
        <div class="card-head-label">
            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_MY_PROFILE', $adminLangId); ?></h3>
        </div>
    </div>
    <?php echo $frm->getFormTag(); ?>
    <div class="card-body">  
        <div class="row form-group">
            <label class="col-lg-4 col-form-label label"><?php echo $imageFld->getCaption(); ?></label>
            <div class="col-lg-8">
                <div class="image-input image-input-outline" data-image-input="true" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/media/avatars/blank.png)">
                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/media/avatars/150-26.jpg)">
                    </div>               
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-image-input-action="change" data-toggle="tooltip" title="" data-original-title="<?php echo $imageFld->getCaption(); ?>">
                        <i class="bi bi-pencil-fill fs-7"></i>
                        <?php echo $imageFld->getHTML(); ?>
                    </label>   
                    <?php if ($newImage == false) { ?>
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-image-input-action="remove" data-toggle="tooltip" title="" data-original-title="<?php echo Labels::getLabel('LBL_Edit', $adminLangId); ?>" onclick="popupImage();">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-image-input-action="remove" data-toggle="tooltip" title="" data-original-title="<?php echo Labels::getLabel('LBL_REMOVE_IMAGE', $adminLangId); ?>" onclick="removeProfileImage();">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                    <?php } ?>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">               
                    <label class="label <?php echo $userNameFld->requirements()->isRequired() ? 'required ' : '' ?>"><?php echo $userNameFld->getCaption(); ?></label>
                    <?php echo $userNameFld->getHTML(); ?>                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">                  
                    <label class="label <?php echo $emailFld->requirements()->isRequired() ? 'required ' : '' ?>"><?php echo $emailFld->getCaption(); ?></label>
                    <?php echo $emailFld->getHTML(); ?> 
                </div>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">               
                    <label class="label <?php echo $nameFld->requirements()->isRequired() ? 'required ' : '' ?>"><?php echo $nameFld->getCaption(); ?></label>
                    <?php echo $nameFld->getHTML(); ?>                    
                </div>
            </div>                
        </div>
    </div>
    <div class="card-foot">
        <div class="row">                                    
            <div class="col-auto">
                <button type="submit" class="btn btn-brand gb-btn gb-btn-primary"><?php echo Labels::getLabel('LBL_UPDATE', $adminLangId); ?></button>
            </div>
        </div>
    </div> 
    <?php echo $frm->getFieldHTML('admin_id'); ?>
</form>
<?php echo $frm->getExternalJS(); ?>
</div>
