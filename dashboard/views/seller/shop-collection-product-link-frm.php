<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($collectionLinkFrm);

$collectionLinkFrm->setFormTagAttribute('onsubmit', 'setUpSellerCollectionProductLinks(this); return(false);');
$collectionLinkFrm->setFormTagAttribute('class', 'form modalFormJs');
$collectionLinkFrm->setFormTagAttribute('data-onclear', "sellerCollectionProducts(" . $scollection_id . ");");

$fld = $collectionLinkFrm->getField('scp_selprod_id[]');
$fld->setfieldTagAttribute('multiple','true');
$fld->setfieldTagAttribute('placeholder',Labels::getLabel('FRM_SEARCH_RECORDS', $siteLangId));
?>
<div class="col-md-12">
    <?php echo $collectionLinkFrm->getFormHtml(); ?>
</div>