<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('id', 'frmDownload');

$frm->setFormTagAttribute('onsubmit', 'return(false);');
$includeTabs = false;
require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
<div class="form-edit-body loaderContainerJs">
    <?php echo $frm->getFormTag(); ?>
    <div class="row">
        <?php
            echo HtmlHelper::getFieldHtml($frm, 'download_type', 6);
            echo HtmlHelper::getFieldHtml($frm, 'option_comb_id', 6);
            echo HtmlHelper::getFieldHtml($frm, 'lang_id', 6); 
            echo $frm->getFieldHtml('record_id');         
            echo $frm->getFieldHtml('dd_link_id');
            echo $frm->getFieldHtml('dd_link_ref_id');
            echo $frm->getFieldHtml('is_preview');
            echo $frm->getFieldHtml('ref_file_id');
        ?>
        </form>
        <?php echo $frm->getExternalJS(); ?>
        <div class="col-md-12" class="dd-list"><div class="row" id="digital_download_list"></div></div>
    </div>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->

