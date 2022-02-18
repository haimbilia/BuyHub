<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('class', 'form form--horizontal layout--' . $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'setupPromotionLang(this); return(false);');

$langFrm->developerTags['colClassPrefix'] = 'col-md-';
$langFrm->developerTags['fld_default_col'] = 6;

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "promotionLangForm(" . $promotionId . ", this.value);");

$btnSubmitFld = $langFrm->getField('btn_submit');
$btnSubmitFld->setFieldTagAttribute('class', 'btn btn-brand btn-wide');

$fld = $langFrm->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
}
?>
<div id="listing">
    <div class="card-head">
        <h5 class="card-title">
            <a title="<?php echo Labels::getLabel('LBL_PROMOTION_LIST', $siteLangId); ?>" class="back" href="javascript:void(0)" onclick="searchRecords()" data-bs-toggle="tootip">
                <svg class="svg" width="24" height="24">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#back">
                    </use>
                </svg>
            </a>
            <?php echo Labels::getLabel('LBL_BACK_TO_PROMOTION_LIST', $siteLangId); ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="row ">
            <div class="col-md-12">
                <div class="tabs tabs--small   tabs--scroll clearfix setactive-js rtl">
                    <ul>
                        <li><a href="javascript:void(0);" onclick="promotionForm(<?php echo $promotionId; ?>)"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a></li>
                        <li class="is-active">
                            <a href="javascript:void(0);">
                                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                            </a>
                        </li>
                        <?php if ($promotionType == Promotion::TYPE_BANNER || $promotionType == Promotion::TYPE_SLIDES) { ?>
                            <li><a href="javascript:void(0)" <?php if ($promotionId > 0) { ?> onclick="promotionMediaForm(<?php echo $promotionId; ?>)" <?php } ?>> <?php echo Labels::getLabel('LBL_Media', $siteLangId); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="tabs__content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
                            $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
                            if (!empty($translatorSubscriptionKey) && $promotion_lang_id != $siteDefaultLangId) { ?>
                                <div class="row justify-content-end">
                                    <div class="col-auto">
                                        <input class="btn btn-outline-gray btn-sm" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" onclick="promotionLangForm(<?php echo $promotionId; ?>, <?php echo $promotion_lang_id; ?>, 1)">
                                    </div>
                                </div>
                            <?php } ?>
                            <?php echo $langFrm->getFormHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>