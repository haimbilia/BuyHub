<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('class', 'web_form form_horizontal layout--' . $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'setupLang(this); return(false);');
$langFrm->developerTags['colClassPrefix'] = 'col-md-';
$langFrm->developerTags['fld_default_col'] = 12;

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "addLangForm(" . $nav_id . ", this.value);");

$translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
if (!empty($translatorSubscriptionKey) && $nav_lang_id != $siteDefaultLangId) {
    $langFld->developerTags['fldWidthValues'] = ['d-flex', '', '', ''];
    $langFld->htmlAfterField = '<a href="javascript:void(0);" onclick="addLangForm(' . $nav_id . ', ' . $nav_lang_id . ', 1)" class="btn" title="' .  Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId) . '">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-translate">
                                            </use>
                                        </svg>
                                    </a>';
} 

?>

<section class="section">
    <div class="sectionhead">

        <h4><?php echo Labels::getLabel('LBL_navigation_Setup', $siteLangId); ?>
        </h4>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="tabs_nav_container responsive flat">
                        <ul class="tabs_nav">
                            <li><a href="javascript:void(0);"
                                    onclick="addForm(<?php echo $nav_id ?>);"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a>
                            </li>
                            <li class="<?php echo (0 == $nav_id) ? 'fat-inactive' : ''; ?>">
                                <a class="active" href="javascript:void(0);" <?php echo (0 < $nav_id) ? "onclick='addLangForm(" . $nav_id . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                                    <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                                </a>
                            </li>
                        </ul>
                        <div class="tabs_panel_wrap">
                            <div class="tabs_panel">
                                <?php echo $langFrm->getFormHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>