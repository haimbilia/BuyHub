<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$tagLangFrm->setFormTagAttribute('class', 'form form--horizontal');
if (CommonHelper::getLayoutDirection() != $formLayout) {
    $tagLangFrm->addFormTagAttribute('class', "layout--" . $formLayout);
    $tagLangFrm->setFormTagAttribute('dir', $formLayout);
}
$tagLangFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$tagLangFrm->developerTags['fld_default_col'] = 12;
$tagLangFrm->setFormTagAttribute('onsubmit', 'setupTagLang(this); return(false);');

$langFld = $tagLangFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "addTagLangForm(" . $tag_id . ", this.value);");

$fld = $tagLangFrm->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
}
?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Add_Tags', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="box__body">
            <div class="tabs ">
                <ul>
                    <li><a class="active" href="javascript:void(0)" onclick="addTagForm(<?php echo $tag_id ?>);"><?php echo Labels::getLabel('LBL_Basic', $siteLangId); ?></a></li>
                    <?php $inactive = ($tag_id == 0) ? 'fat-inactive' : ''; ?>
                    <li class="<?php echo (0 < $tag_lang_id) ? 'is-active' : '';
                                echo $inactive; ?>">
                        <a href="javascript:void(0);">
                            <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                        </a>
                    </li>
                    <?php /* foreach ($languages as $langId => $langName) { ?>
                <li class="<?php echo $inactive;?> <?php echo ($langId == $tag_lang_id) ? 'is-active' : ''; ?>"><a href="javascript:void(0);"
                    <?php if ($tag_id > 0) { ?>
                        onclick="addTagLangForm(<?php echo $tag_id ?>, <?php echo $langId;?>);"
                    <?php } ?>>
                    <?php echo $langName;?></a>
                </li>
                <?php } */ ?>
                </ul>
            </div>
            <div class="tabs__content form">
                <?php
                $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
                $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
                if (!empty($translatorSubscriptionKey) && $tag_lang_id != $siteDefaultLangId) { ?>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <input class="btn btn-brand" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" onclick="addTagLangForm( <?php echo $tag_id; ?>, <?php echo $tag_lang_id; ?>, 1)">
                        </div>
                    </div>
                <?php } ?>
                <?php
                echo $tagLangFrm->getFormHtml();
                ?>
            </div>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>