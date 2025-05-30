<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$mediaFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
$mediaFrm->setFormTagAttribute('class', 'form--horizontal');
$mediaFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$mediaFrm->developerTags['fld_default_col'] = 8;
$fld = $mediaFrm->getField('category_banner');
$fld->addFieldTagAttribute('class', 'btn btn-brand btn-sm');
?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Banner', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="tabs__content">
            <div class="row ">
                <div class="col-md-12">
                    <div class="preview">
                        <small class="form-text text-muted"><?php echo sprintf(Labels::getLabel('MSG_Upload_shop_banner_text', $siteLangId), '2000*500') ?></small>
                        <?php echo $mediaFrm->getFormHtml(); ?>
                        <div class="">
                            <?php foreach ($attachments as $img) { ?>
                                <img src="<?php echo UrlHelper::generateUrl('Category', 'sellerBanner', array($img['afile_record_id'], $img['afile_record_subid'], $img['afile_lang_id'], ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONTEND); ?>" alt="<?php echo Labels::getLabel('LBL_Shop_Banner', $siteLangId); ?>">
                                <small class="form-text text-muted"><?php echo $bannerTypeArr[$img['afile_lang_id']]; ?></small>
                                <div class="btngroup--fix">
                                    <a class="btn btn-brand btn-sm" href="javascript:void(0);" onclick="removeCategoryBanner(<?php echo $img['afile_record_subid']; ?>,<?php echo $img['afile_lang_id']; ?>)"><?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?></a>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                    <div id="mediaResponse"></div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>