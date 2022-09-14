<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmTag->setFormTagAttribute('class', 'form form--horizontal');
$frmTag->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frmTag->developerTags['fld_default_col'] = 12;
$frmTag->setFormTagAttribute('onsubmit', 'setupTag(this); return(false);');
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Add_Tags', $langId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="box__body">
            <div class="tabs ">
                <ul>
                    <li class="is-active">
                        <a href="javascript:void(0)" onclick="addTagForm(<?php echo $tag_id ?>);">
                            <?php echo Labels::getLabel('LBL_Basic', $siteLangId); ?>
                        </a>
                    </li>
                    <li class="<?php echo (0 == $tag_id) ? 'fat-inactive' : ''; ?>">
                        <a href="javascript:void(0);" <?php echo (0 < $tag_id) ? "onclick='addTagLangForm(" . $tag_id . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                            <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tabs__content form">
                <?php
                echo $frmTag->getFormHtml();
                ?>
            </div>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>