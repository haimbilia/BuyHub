<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($colectionForm);
$colectionForm->setFormTagAttribute('class', 'form modalFormJs');
$colectionForm->setFormTagAttribute('onsubmit', 'setupShopCollection(this); return(false);');
$colectionForm->setFormTagAttribute('data-onclear', "getShopCollectionGeneralForm(" . $scollection_id . ");");

$urlFld = $colectionForm->getField('urlrewrite_custom');
$urlFld->setFieldTagAttribute('id', "urlrewrite_custom");
$urlFld->setFieldTagAttribute('onkeyup', "getSlugUrl(this,this.value,'" . $baseUrl . "','post')");
$collectionUrl = "";
if (0 < $scollection_id) {
    $collectionUrl = UrlHelper::generateFullUrl('Shops', 'Collection', array($shop_id, $scollection_id), CONF_WEBROOT_FRONTEND);
}
$urlFld->htmlAfterField = "<small class='form-text text-muted'>" . $collectionUrl . '</small>';
$IDFld = $colectionForm->getField('scollection_id');
$IDFld->setFieldTagAttribute('id', "scollection_id");

$inactive = 1 > $scollection_id ? 'disabled' : '';

$fld = $colectionForm->getField('scollection_name');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','scollection_id');getIdentifier(this);");
$fld->htmlAfterField = "<small class='form-text text-muted'>" . HtmlHelper::getIdentifierText($identifier, $siteLangId) . '</small>';

$fld = $colectionForm->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$fld = $colectionForm->getField('scollection_active');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;
$fld->developerTags['colWidthValues'] = [null, '12', null, null];

unset($languages[CommonHelper::getDefaultFormLangId()]);
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SHOP_COLLECTIONS_SETUP'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs" id="shopFormChildBlockTabsJs">
            <a class="nav-link active" href="javascript:void(0);" onclick="getShopCollectionGeneralForm(<?php echo $scollection_id; ?>);" title="<?php echo Labels::getLabel('LBL_GENERAL', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_GENERAL', $siteLangId); ?>
            </a>
            <?php if (0 < count($languages)) { ?>
                <a class="nav-link <?php echo $inactive; ?>" href="javascript:void(0);" onclick="editShopCollectionLangForm(<?php echo $scollection_id ?>,<?php echo array_key_first($languages); ?>)" title="<?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>">
                    <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>
                </a>
            <?php } ?>
            <a class="nav-link <?php echo $inactive; ?>" onclick="sellerCollectionProducts(<?php echo $scollection_id ?>)" href="javascript:void(0);" title="<?php echo Labels::getLabel('LBL_LINK', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_LINK', $siteLangId); ?>
            </a>
            <a class="nav-link <?php echo $inactive; ?>" onclick="collectionMediaForm(<?php echo $scollection_id; ?>)" href="javascript:void(0);" title="<?php echo Labels::getLabel('LBL_Media', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_MEDIA', $siteLangId); ?>
            </a>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs">
        <div class="row" id="shopFormChildBlockJs">
            <div class="col-md-12">
                <?php echo $colectionForm->getFormHtml(); ?>
            </div>
        </div>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>