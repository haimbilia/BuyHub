<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form-horizontal');

$currentPassFld = $frm->getField('current_password');
$newPassFld = $frm->getField('new_password');
$confPassFld = $frm->getField('conf_new_password');
?>
<div class="card">
    <div class="card-head">
        <div class="card-head-label">
            <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_CHANGE_PASSWORD', $adminLangId); ?></h3>
        </div>
    </div>
    <?php echo $frm->getFormTag(); ?>
    <div class="card-body">        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">               
                    <label class="label <?php echo $currentPassFld->requirements()->isRequired() ? 'required ' : '' ?>"><?php echo $currentPassFld->getCaption(); ?></label>
                    <?php echo $currentPassFld->getHTML(); ?>                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">                  
                    <label class="label <?php echo $newPassFld->requirements()->isRequired() ? 'required ' : '' ?>"><?php echo $newPassFld->getCaption(); ?></label>
                    <?php echo $newPassFld->getHTML(); ?> 
                </div>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">               
                    <label class="label <?php echo $confPassFld->requirements()->isRequired() ? 'required ' : '' ?>"><?php echo $confPassFld->getCaption(); ?></label>
                    <?php echo $confPassFld->getHTML(); ?>                    
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
</form>
<?php echo $frm->getExternalJS(); ?>
</div>
