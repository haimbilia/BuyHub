<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($shopColLangFrm);
$shopColLangFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$shopColLangFrm->setFormTagAttribute('dir', $formLayout);
$shopColLangFrm->setFormTagAttribute('data-onclear', "editShopCollectionLangForm(" . $scollection_id . ", " . $langId . ");");
$shopColLangFrm->setFormTagAttribute('onsubmit', 'setupShopCollectionlangForm(this); return(false);');

$langFld = $shopColLangFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editShopCollectionLangForm(" . $scollection_id . ", this.value);");
HtmlHelper::attachTransalateIcon($langFld, $langId ,'editShopCollectionLangForm(' . $scollection_id . ', ' . $langId . ', 1)');
?>
<div class="col-md-12">
    <?php echo $shopColLangFrm->getFormHtml(); ?>
</div>