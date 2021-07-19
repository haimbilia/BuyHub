<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$frm->setFormTagAttribute( 'onSubmit', 'setUpLangBatch(this); return false;' );
$frm->setFormTagAttribute('class','form form--horizontal layout--'.$formLayout);
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;

$langFld = $frm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "batchLangForm(" . $prodgroup_id . ",this.value);");
 ?>
 <div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel("LBL_Manage_Batch_Products", $siteLangId); ?></h5>
</div>
<div class="modal-body">
    <ul class="tabs tabs--small    -js clearfix setactive-js">
		<li><a href="javascript:void(0)" onclick="batchForm(<?php echo $prodgroup_id; ?>)"><?php echo Labels::getLabel( 'LBL_General', $siteLangId ); ?></a></li>
        <li class="<?php echo (0 < $prodgroup_lang_id) ? 'is-active' : ''; ?>">
            <a href="javascript:void(0);">
                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
            </a>
        </li>
		<li><a href="javascript:void(0)" onClick="batchMediaForm(<?php echo $prodgroup_id; ?>)"><?php echo Labels::getLabel('LBL_Media',$siteLangId); ?></a></li>
	</ul>
    <?php
            $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
            $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
            if (!empty($translatorSubscriptionKey) && $prodgroup_lang_id != $siteDefaultLangId) { ?> 
                <div class="row justify-content-end"> 
                    <div class="col-auto mb-4">
                        <input class="btn btn-brand" 
                            type="button" 
                            value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" 
                            onClick="batchLangForm(<?php echo $prodgroup_id; ?>,<?php echo $prodgroup_lang_id; ?>, 1)">
                    </div>
                </div>
            <?php } ?>
	<div class="col-md-12">
		<?php echo $frm->getFormHtml(); ?>
	</div>
</div>
