<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('class', 'form form-edit');
$frm->setFormTagAttribute('id', 'frmImgAttribute');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');

$langFld = $frm->getField('lang_id');
$langFld->addFieldTagAttribute('class', 'language-js');

$btn = $frm->getField('btn_submit');
$btn->setFieldTagAttribute('class', "form-control");

$btn = $frm->getField('btn_discard');
$btn->addFieldTagAttribute('onClick', "discardForm()");
$btn->setFieldTagAttribute('class', "form-control");

$optionIdFld = $frm->getField('option_id');
if ($optionIdFld !== null) {
    $optionIdFld->addFieldTagAttribute('class', 'option-js');
}

echo $frm->getFormTag();
HtmlHelper::renderHiddenFields($frm);
?>

<div class="card">
    <div class="card-head">
        <div class="card-head-label">
            <h3 class="card-head-title"><?php echo $title; ?></h3>
        </div>

    </div>
    <div class="card-body">
        <div class="row">
            <?php if ($optionIdFld !== null) { ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label"><?php echo $optionIdFld->getCaption(); ?></label>
                        <div> <?php echo $frm->getFieldHtml('option_id'); ?></div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="label"><?php
                                            $fld = $frm->getField('lang_id');
                                            echo $fld->getCaption();   ?>
                    </label>
                    <div> <?php echo $frm->getFieldHtml('lang_id'); ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label">
                    </label>
                    <div> <?php echo $frm->getFieldHtml('btn_submit'); ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label">
                    </label>
                    <div> <?php echo $frm->getFieldHtml('btn_discard'); ?></div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 col-md-12">
                <div class="">
                    <?php if (!empty($images)) { ?>
                        <?php foreach ($images as $afileId => $afileData) {
                            $uploadedTime = AttachedFile::setTimeParam($afileData['afile_updated_at']);
                            $frm->getField('image_title' . $afileId)->value = $afileData['afile_attribute_title'];
                            $frm->getField('image_alt' . $afileId)->value = $afileData['afile_attribute_alt'];
                            switch ($moduleType) {
                                case AttachedFile::FILETYPE_PRODUCT_IMAGE:
                                    $imageUrl = UrlHelper::generateFullUrl('Image', 'Product', array($recordId, "THUMB", 0, $afileId, $langId), CONF_WEBROOT_FRONT_URL);
                                    break;
                                case AttachedFile::FILETYPE_BRAND_LOGO:
                                    $imageUrl = UrlHelper::generateFullUrl('Image', 'brand', array($recordId, $langId, "THUMB", $afileId), CONF_WEBROOT_FRONT_URL);
                                    break;
                                case AttachedFile::FILETYPE_BRAND_IMAGE:
                                    $imageUrl = UrlHelper::generateFullUrl('Image', 'brandImage', array($recordId, $langId, "THUMB", $afileId), CONF_WEBROOT_FRONT_URL);
                                    break;
                                case AttachedFile::FILETYPE_BLOG_POST_IMAGE:
                                    $imageUrl = UrlHelper::generateFullUrl('Image', 'blogPost', array($recordId, $langId, "THUMB", 0, $afileId, false), CONF_WEBROOT_FRONT_URL);
                                    break;
                                case AttachedFile::FILETYPE_CATEGORY_IMAGE:
                                    $imageUrl = UrlHelper::generateFullUrl('Category', 'image', array($recordId, $langId, "THUMB", 0, $afileId), CONF_WEBROOT_FRONT_URL);
                                    break;
                                default:
                                    $imageUrl = UrlHelper::generateFullUrl('Category', 'banner', array($recordId, $langId, "THUMB", 0, $afileId), CONF_WEBROOT_FRONT_URL);
                                    break;
                            } ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="field-set">
                                        <img src="<?php echo UrlHelper::getCachedUrl($imageUrl . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="field-set">
                                        <div class="caption-wraper">
                                            <label class="field_label">
                                                <?php
                                                $fld = $frm->getField('image_title' . $afileId);
                                                echo $fld->getCaption();
                                                ?></label>
                                        </div>
                                        <div class="field-wraper">
                                            <div class="field_cover">
                                                <?php echo $frm->getFieldHtml('image_title' . $afileId); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="field-set">
                                        <div class="caption-wraper">
                                            <label class="field_label">
                                                <?php
                                                $fld = $frm->getField('image_alt' . $afileId);
                                                echo $fld->getCaption();
                                                ?></label>
                                        </div>
                                        <div class="field-wraper">
                                            <div class="field_cover">
                                                <?php echo $frm->getFieldHtml('image_alt' . $afileId); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else {
                        echo Labels::getLabel('LBL_No_Records_Found', $siteLangId);
                    } ?>
                </div>
            </div>
        </div>
    </div>   
</div>
</form>
<?php echo $frm->getExternalJS(); ?>