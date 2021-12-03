<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="generalForm"></div>
<?php
$langFrm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs');
$langFrm->setFormTagAttribute('onsubmit', 'setupLangRate(this); return(false);');
$langFrm->developerTags['colClassPrefix'] = 'col-md-';
$langFrm->developerTags['fld_default_col'] = 12;
HtmlHelper::formatFormFields($langFrm);
if (!$langFrm->getFormTagAttribute('id')) {
    $langFrm->setFormTagAttribute('id', 'frmLangJs');
} 
$langFrm->setFormTagAttribute('dir', $formLayout); 
$formTitle = Labels::getLabel('LBL_SHIPPING_RATES_SETUP', $siteLangId);
$activeGentab = !empty($activeGentab) ? 'active' : '';
$activeLangtab = !empty($activeLangtab) ? 'active' : '';
$languages = $languages ?? [];
unset($languages[CommonHelper::getDefaultFormLangId()]);
$label = isset($generalTab['label']) ? $generalTab['label'] : '';
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $formTitle; ?> 
    </h5>
</div>
<div class="modal-body form-edit">
    <!-- Closing tag must be added inside the files who include this file. -->
    <?php if (0 < count($languages)) { ?>
        <div class="form-edit-head">
            <nav class="nav nav-tabs navTabsJs"> 
                <a class="nav-link <?php echo $activeGentab; ?>" href="javascript:void(0);" onclick="addEditShipRates('<?php echo $zoneId; ?>', '<?php echo $rateId; ?>');"  >
                    <?php echo Labels::getLabel('LBL_GENERAL', $siteLangId); ?>
                </a>
                <?php if (0 < count($languages)) { ?>
                    <a class="nav-link <?php echo $activeLangtab; ?>" href="javascript:void(0);" <?php if (0 < $rateId) { ?>onclick="editRateLangForm('<?php echo $zoneId; ?>', '<?php echo $rateId; ?>', '<?php echo array_key_first($languages); ?>');" <?php } ?> title="<?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>">
                        <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>
                    </a>
                <?php } ?> 
            </nav>
        </div>
    <?php } ?> 
    <div class="form-edit-body loaderContainerJs">
        <?php echo $langFrm->getFormHtml(); ?>
        </form>
    </div>
    <?php
    require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php');
    ?>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->