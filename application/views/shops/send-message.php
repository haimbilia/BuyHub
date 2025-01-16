<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onSubmit', 'setUpSendMessage(this); return false;');
$fromFld = $frm->getField('send_message_from');
$toFld = $frm->getField('send_message_to');

$btnFld = $frm->getField('btn_submit');
$btnFld->addFieldTagAttribute('class', 'btn btn-brand btn-wide');

$fromFldHtml = new HtmlElement('div', array('class' => 'field-set'));
$fromFldCaptionWrapper = $fromFldHtml->appendElement('div', array('class' => 'caption-wraper'));
$fromFldCaptionWrapper->appendElement('label', array('class' => 'form-label'), Labels::getLabel('LBL_From', $siteLangId));

$fromFldFieldWrapper = $fromFldHtml->appendElement('div', array('class' => 'field-wraper'));
$fromFldData = $loggedUserData['credential_username'] . ' (<em>' . $loggedUserData['user_name'] . '</em>)';
$fromFldData .= '<br/><span class="form-text text-muted">' . Labels::getLabel('LBL_Contact_info_not_shared', $siteLangId) . '</span>';
$fromFldFieldWrapper->appendElement('div', array('class' => 'field_cover'), $fromFldData, true);

$fromFld->value = $fromFldHtml->getHtml();

$toFldHtml = new HtmlElement('div', array('class' => 'field-set'));
$toFldCaptionWrapper = $toFldHtml->appendElement('div', array('class' => 'caption-wraper'));
$toFldCaptionWrapper->appendElement('label', array('class' => 'form-label'), Labels::getLabel('LBL_To', $siteLangId));

$toFldFieldWrapper = $toFldHtml->appendElement('div', array('class' => 'field-wraper'));
$toFldFieldWrapper->appendElement('div', array('class' => 'field_cover'), $shop['shop_owner_name'] . ' (<em>' . $shop['shop_name'] . '</em>)', true);

$toFld->value = $toFldHtml->getHtml();

if (isset($product)) {
    $productFld = $frm->getField('about_product');
    $productFldHTML = new HtmlElement('div', array('class' => 'field-set'));
    $productFldCaptionWrapper = $productFldHTML->appendElement('div', array('class' => 'caption-wraper'));
    $productFldCaptionWrapper->appendElement('label', array('class' => 'form-label'), Labels::getLabel('LBL_About_Product', $siteLangId));

    $productFldFieldWrapper = $productFldHTML->appendElement('div', array('class' => 'field-wraper'));
    $productFldFieldWrapper->appendElement('div', array('class' => 'field_cover'), $product['selprod_title'], true);

    $productFld->value = $productFldHTML->getHtml();
}
?>
<div id="body" class="body template-<?php echo $template_id; ?>">
    <?php
    $this->includeTemplate('shops/_breadcrumb.php');
    $variables = array('shop' => $shop, 'siteLangId' => $siteLangId, 'template_id' => $template_id, 'action' => $action, 'shopTotalReviews' => $shopTotalReviews, 'shopRating' => $shopRating, 'socialPlatforms' => $socialPlatforms, 'userParentId' => $userParentId);
    $this->includeTemplate('shops/templates/' . $template_id . '.php', $variables, false);
    ?>

    <section class="section" data-section="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <header class="section-head">
                        <h4>
                            <?php echo Labels::getLabel('LBL_Send_Message_to_shop_owner', $siteLangId); ?>
                        </h4>
                    </header>
                    <div class="section-body">
                        <div class=""><?php echo $frm->getFormHtml(); ?> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="gap"></div>
</div>
<?php echo $this->includeTemplate('_partial/shareThisScript.php'); ?>