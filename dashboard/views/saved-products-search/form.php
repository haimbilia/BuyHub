<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form-apply setupSaveProductSearch-Js');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onsubmit', 'setupSaveProductSearch(this,event); return(false);');
$search_title_fld = $frm->getField('pssearch_name');
$search_title_fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Title', $siteLangId));
$btn = $frm->getField('btn_submit');
$btn->addFieldTagAttribute('class', "btn btn-brand");
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Save_Search', $siteLangId); ?></h5>
</div>

<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php
        echo $frm->getFormTag();
        echo $frm->getFieldHtml('pssearch_name');
        echo $frm->getFieldHtml('btn_submit');
        ?>
        </form>
        <?php echo $frm->getExternalJs(); ?>
    </div>

</div>