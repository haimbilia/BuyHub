<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$promotionMediaFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
$promotionMediaFrm->developerTags['colClassPrefix'] = 'col-md-';
$promotionMediaFrm->developerTags['fld_default_col'] = 12;
$fld = $promotionMediaFrm->getField('promotion_media');
$fld->addFieldTagAttribute('class', 'btn btn-brand btn-sm');
?>
<div class="tabs__content form">
    <div class="row">
        <div class="col-md-12">

            <div class="nav nav-pills nav-sm">
                <ul>
                    <li><a href="javascript:void(0)" onclick="promotionGeneralForm(<?php echo $promotion_id ?>)"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a></li>
                    <li class="<?php echo (0 == $promotion_id) ? 'fat-inactive' : ''; ?>">
                        <a href="javascript:void(0);" <?php echo (0 < $promotion_id) ? "onclick='promotionLangForm(" . $promotion_id . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                            <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                        </a>
                    </li>
                    <li class="is-active"><a href="javascript:void(0)" onclick="promotionMediaForm(<?php echo $promotion_id; ?>)"><?php echo Labels::getLabel('LBL_Media', $siteLangId); ?></a></li>
                </ul>
            </div>
            <div class="form__subcontent">
                <div id="mediaResponse"></div>
                <div class="col-md-6">
                    <div class="preview">
                        <small class="form-text text-muted"><?php echo Labels::getLabel('MSG_Upload_Promotion_Media_text', $siteLangId); ?></small>
                        <?php echo $promotionMediaFrm->getFormHtml(); ?>
                        <?php foreach ($bannerAttachments as $img) { ?>
                            <div class=" col-md-12 profile__pic">
                                <img src="<?php echo UrlHelper::generateFileUrl('Image', 'promotionMedia', array($img['afile_record_id'], $img['afile_lang_id'], ImageDimension::VIEW_PREVIEW, $img['afile_id']), CONF_WEBROOT_FRONTEND); ?>" alt="<?php echo Labels::getLabel('LBL_Promotion_Banner', $siteLangId); ?>">
                            </div>
                            <div class="btngroup--fix">
                                <a class="btn btn-brand btn-sm" href="javascript:void(0);" onclick="removePromotionMedia(<?php echo $promotion_id; ?>,<?php echo $img['afile_id']; ?>)"><?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>