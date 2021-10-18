<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$prodBrandLangFrm->setFormTagAttribute('id', 'prodBrand');
$prodBrandLangFrm->setFormTagAttribute('class', 'web_form form_horizontal layout--' . $formLayout);
$prodBrandLangFrm->setFormTagAttribute('onsubmit', 'setupBrandLang(this); return(false);');
$prodBrandLangFrm->developerTags['colClassPrefix'] = 'col-md-';
$prodBrandLangFrm->developerTags['fld_default_col'] = 12;

$langFld = $prodBrandLangFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "brandRequestLangForm(" . $brand_id . ", this.value);");

$translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
if (!empty($translatorSubscriptionKey) && $brand_lang_id != $siteDefaultLangId) {
    $langFld->developerTags['fldWidthValues'] = ['d-flex', '', '', ''];
    $langFld->htmlAfterField = '<a href="javascript:void(0);" onclick="brandRequestLangForm(' . $brand_id . ', ' . $brand_lang_id . ', 1)" class="btn" title="' .  Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId) . '">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-translate">
                                            </use>
                                        </svg>
                                    </a>';
} ?>
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Labels::getLabel('LBL_Product_Brand_Setup', $siteLangId); ?></h4>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs_nav_container responsive flat">
                    <ul class="tabs_nav">
                        <li><a href="javascript:void(0);" onclick="brandRequestForm(<?php echo $brand_id ?>);"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a>
                        </li>
                        <li class="<?php echo (0 == $brand_id) ? 'fat-inactive' : ''; ?>">
                            <a class="active" href="javascript:void(0);" <?php echo (0 < $brand_id) ? "onclick='brandRequestLangForm(" . $brand_id . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" <?php if ($brand_id > 0) { ?> onclick="brandRequestMediaForm(<?php echo $brand_id ?>);" <?php } ?>>
                                <?php echo Labels::getLabel('LBL_Media', $siteLangId); ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tabs_panel_wrap">
                        <div class="tabs_panel">
                            <?php echo $prodBrandLangFrm->getFormHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>