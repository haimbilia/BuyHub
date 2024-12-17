<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onSubmit', 'setUpShopSpam(this); return false;');

$btnFld = $frm->getField('btn_submit');
if (null != $btnFld) {
    $btnFld->addFieldTagAttribute('class', 'btn btn-brand');
}

$userParentId = $userParentId ?? 0;
?>

<div id="body" class="body template-<?php echo $template_id; ?>">
    <?php
    $variables = array('shop' => $shop, 'siteLangId' => $siteLangId, 'template_id' => $template_id, 'action' => $action, 'shopTotalReviews' => $shopTotalReviews, 'shopRating' => $shopRating, 'socialPlatforms' => $socialPlatforms, 'userParentId' => $userParentId);
    $this->includeTemplate('shops/templates/' . $template_id . '.php', $variables, false);
    ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <header class="section-head">
                        <h4><?php echo Labels::getLabel('LBL_Why_are_you_reporting_this_shop_as_spam', $siteLangId); ?>
                        </h4>
                    </header>
                    <div class="">
                        <div class="border p-3"> <?php echo $frm->getFormHtml(); ?> </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <div class="gap"></div>
</div>
<?php echo $this->includeTemplate('_partial/shareThisScript.php'); ?>