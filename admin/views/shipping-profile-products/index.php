<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$frm->developerTags['fieldWrapperRowExtraClassDefault'] = '';
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'searchProducts(' . $profileId . ',this); return(false);');
$proFld = $frm->getField("keyword");
$proFld->developerTags['noCaptionTag'] = true;
$proFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product...', $siteLangId));
$proFld->addFieldTagAttribute('autocomplete', 'off')
?>
<div class="row">
    <div class="col-md-12 searchFormJs" style="display:none;">
        <?php echo $frm->getFormHtml(); ?></form>
    </div>
</div>
<div id="product-listing--js"></div>