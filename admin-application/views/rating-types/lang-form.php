<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'ratingTypes');
$frm->setFormTagAttribute('class', 'web_form form_horizontal layout--'.$formLayout);
$frm->setFormTagAttribute('onsubmit', 'setupRatingTypesLang(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$langFld = $frm->getField('ratingtypelang_lang_id');
$langFld->setfieldTagAttribute('onChange', "ratingTypesLangForm(" . $rtId . ", this.value);");
?>
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Labels::getLabel('LBL_RATING_TYPES_SETUP', $adminLangId); ?></h4>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs_nav_container responsive flat">
                    <?php if (!array_key_exists($rtId, $defaultRatingsCols)) { ?>
                        <ul class="tabs_nav">
                            <li><a href="javascript:void(0);"
                                    onclick="ratingTypesForm(<?php echo $rtId ?>);"><?php echo Labels::getLabel('LBL_General', $adminLangId); ?></a>
                            </li>
                            <li class="<?php echo (0 == $rtId) ? 'fat-inactive' : ''; ?>">
                                <a class="active" href="javascript:void(0);">
                                    <?php echo Labels::getLabel('LBL_Language_Data', $adminLangId); ?>
                                </a>
                            </li>
                        </ul>
					<?php } ?>
                    <div class="tabs_panel_wrap" style="min-height: inherit;">
                        <?php
                        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
                        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
                        if (!empty($translatorSubscriptionKey) && $rt_lang_id != $siteDefaultLangId) { ?> 
                            <div class="row justify-content-end"> 
                                <div class="col-auto mb-4">
                                    <input class="btn btn-brand" 
                                        type="button" 
                                        value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $adminLangId); ?>" 
                                        onClick="ratingTypesLangForm(<?php echo $rtId; ?>, <?php echo $rt_lang_id; ?>, 1)">
                                </div>
                            </div>
                        <?php } ?> 
                        <div class="tabs_panel">
                            <?php echo $frm->getFormHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>