<?php
defined('SYSTEM_INIT') or die('Invalid Usage.'); 
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'searchProducts(' . $profileId . ',this); return(false);');
$proFld = $frm->getField("keyword");
$proFld->developerTags['noCaptionTag'] = true;
$proFld->developerTags['colWidthValues'] = [null, '8', null, null];
$proFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product...', $siteLangId)); 
$btn = $frm->getField('btn_submit');
$btn->developerTags['colWidthValues'] = [null, '2', null, null];
$btn->addFieldTagAttribute('class', 'btn btn-brand'); 
$btn = $frm->getField('btn_clear');
$btn->developerTags['colWidthValues'] = [null, '2', null, null];  
?> 
<div class="row"> 
    <div class="col-md-12">
        <?php echo $frm->getFormHtml(); ?></form>
    </div>
</div>
<div id="product-listing--js"></div>