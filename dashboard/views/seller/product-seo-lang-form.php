<?php
HtmlHelper::formatFormFields($productSeoLangForm);
$productSeoLangForm->setFormTagAttribute('class', 'form modalFormJs');

if (CommonHelper::getLayoutDirection() != $formLayout) {
    $productSeoLangForm->addFormTagAttribute('class', "layout--" . $formLayout);
    $productSeoLangForm->setFormTagAttribute('dir', $formLayout);
}
$productSeoLangForm->setFormTagAttribute('onsubmit', 'setupProductLangMetaTag(this, 0); return(false);');
$productSeoLangForm->developerTags['colClassPrefix'] = 'col-md-';
$productSeoLangForm->developerTags['fld_default_col'] = 12;
$langFld = $productSeoLangForm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editProductMetaTagLangForm(" . $selprodId . ", this.value);");
HtmlHelper::attachTransalateIcon($langFld, $selprod_lang_id ,'editProductMetaTagLangForm(' . $selprodId . ', ' . $selprod_lang_id . ', 1)');

$mKeywordFld = $productSeoLangForm->getField('meta_keywords');
$mKeywordFld->setfieldTagAttribute('class', "txtarea-height");
$mDescFld = $productSeoLangForm->getField('meta_description');
$mDescFld->setfieldTagAttribute('class', "txtarea-height");
$mtagsFld = $productSeoLangForm->getField('meta_other_meta_tags');
$mtagsFld->setfieldTagAttribute('class', "txtarea-height");

$nextBtn = $productSeoLangForm->getField('btn_next');
$nextBtn->developerTags['col'] = 6;
$nextBtn->setfieldTagAttribute('class', "btn btn-brand");
$nextBtn->setfieldTagAttribute('onclick', 'setupProductLangMetaTag($("#' . $productSeoLangForm->getFormTagAttribute('id') . '")[0],0); return(false);');

$nextBtn->setWrapperAttribute('class', "text-right");
$nextBtn->developerTags['noCaptionTag'] = true;

$exitBtn = $productSeoLangForm->getField('btn_exit');
$exitBtn->developerTags['col'] = 6;
$exitBtn->setfieldTagAttribute('class', "btn btn-outline-gray");
$exitBtn->setfieldTagAttribute('onclick', 'setupProductLangMetaTag($("#' . $productSeoLangForm->getFormTagAttribute('id') . '")[0],1); return(false);');
$exitBtn->developerTags['noCaptionTag'] = true;

end($languages);
if (key($languages) == $selprod_lang_id) {
    $nextBtn->value = Labels::getLabel("LBL_Save", $siteLangId);
    $nextBtn->setfieldTagAttribute('class', "btn btn-brand");
    $exitBtn->setfieldTagAttribute('class', "btn btn-outline-gray");
} 

$fld = $productSeoLangForm->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);  
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$productSeoLangForm->removeField($nextBtn);
$productSeoLangForm->removeField($exitBtn);

?>

<div id="dvForm">
    <div class="card-head">
        <h5 class="card-title mb-2">
            <?php echo SellerProduct::getProductDisplayTitle($selprodId, $siteLangId, false); ?>
        </h5>
    </div>
    <div class="card-body">
        <?php echo $productSeoLangForm->getFormHtml(); ?>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col">
                <?php echo $exitBtn->getHtml();  ?>
            </div>
            <div class="col-auto">
            <?php echo $nextBtn->getHtml();  ?>
            </div>
        </div>
    </div>
</div>