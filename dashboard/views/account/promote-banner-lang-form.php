<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$promotionLangFrm->setFormTagAttribute('onsubmit', 'setupPromotionLang(this); return(false);');
$promotionLangFrm->setFormTagAttribute('class', 'form form--horizontal');

if (CommonHelper::getLayoutDirection() != $formLayout) {
    $promotionLangFrm->addFormTagAttribute('class', "layout--" . $formLayout);
    $promotionLangFrm->setFormTagAttribute('dir', $formLayout);
}

$promotionLangFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$promotionLangFrm->developerTags['fld_default_col'] = 12;

$langFld = $promotionLangFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "promotionLangForm(" . $promotion_id . ", this.value);");

$fld = $promotionLangFrm->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
}
?>


<div class="row">
    <div class="col-md-12">
        <div class="nav nav-pills nav-fill">
            <ul>
                <li><a href="javascript:void(0)" onclick="promotionGeneralForm(<?php echo $promotion_id ?>)"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a>
                </li>
                <?php $inactive = ($promotion_id == 0) ? 'fat-inactive' : ''; ?>
                <li class="<?php echo (0 < $formLangId) ? 'is-active' : '';
                            echo $inactive; ?>">
                    <a href="javascript:void(0);">
                        <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                    </a>
                </li>
                <?php
                /* foreach($language as $langId => $langName){?>
                <li class="<?php echo ($formLangId == $langId)?'is-active':'' ; ?>"><a href="javascript:void(0)"
                        <?php if($promotion_id>0){ ?>
                        onclick="promotionLangForm(<?php echo $promotion_id;?>,<?php echo $langId;?>)" <?php }?>>
                        <?php echo $langName;?></a></li>
                <?php } */ ?>
                <li class="<?php echo $inactive; ?>"><a href="javascript:void(0)" onclick="promotionMediaForm(<?php echo $promotion_id; ?>)"><?php echo Labels::getLabel('LBL_Media', $siteLangId); ?></a>
                </li>
            </ul>
        </div>
        <div class="form__subcontent">
            <?php
            $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
            $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
            if (!empty($translatorSubscriptionKey) && $formLangId != $siteDefaultLangId) { ?>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <input class="btn btn-outline-gray btn-sm" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" onclick="promotionLangForm(<?php echo $promotion_id; ?>, <?php echo $formLangId; ?>, 1)">
                    </div>
                <?php } ?>
                <?php echo $promotionLangFrm->getFormTag();
                echo $promotionLangFrm->getFormHtml(false);
                echo '</form>'; ?>
                </div>
        </div>
    </div>