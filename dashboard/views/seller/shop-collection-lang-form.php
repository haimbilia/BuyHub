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
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SHOP_COLLECTIONS_SETUP'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs" id="shopFormChildBlockTabsJs">
            <a class="nav-link " href="javascript:void(0);" onclick="getShopCollectionGeneralForm(<?php echo $scollection_id; ?>);" title="<?php echo Labels::getLabel('LBL_GENERAL', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_GENERAL', $siteLangId); ?>
            </a>
            <?php if(0 < count($languages)){ ?>
            <a class="nav-link active" href="javascript:void(0);" onclick="editShopCollectionLangForm(<?php echo $scollection_id ?>,<?php echo array_key_first($languages); ?>)" title="<?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>
            </a>
            <?php } ?>
            <a class="nav-link" onclick="sellerCollectionProducts(<?php echo $scollection_id ?>)" href="javascript:void(0);" title="<?php echo Labels::getLabel('LBL_LINK', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_LINK', $siteLangId); ?>
            </a>
            <a class="nav-link" onclick="collectionMediaForm(<?php echo $scollection_id; ?>)" href="javascript:void(0);" title="<?php echo Labels::getLabel('LBL_Media', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_MEDIA', $siteLangId); ?>
            </a>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs">
        <div class="row" id="shopFormChildBlockJs">
            <div class="col-md-12">
                <?php echo $shopColLangFrm->getFormHtml(); ?>
            </div>
        </div>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>