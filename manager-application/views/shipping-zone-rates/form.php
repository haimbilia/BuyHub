<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="generalForm"></div>
<?php
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs');
$frm->setFormTagAttribute('onsubmit', 'setupRate(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$formTitle = Labels::getLabel('LBL_SHIPPING_RATES_SETUP', $siteLangId);
$activeGentab = !empty($activeGentab) ? 'active' : '';
$activeLangtab = !empty($activeLangtab) ? 'active' : '';
$languages = $languages ?? [];
unset($languages[CommonHelper::getDefaultFormLangId()]);
$label = isset($generalTab['label']) ? $generalTab['label'] : '';

$costFld = $frm->getField('shiprate_cost');
$costFld->htmlAfterField = "<div class='gap'></div><p class='add-condition--js'><a href='javascript:void(0);' onclick='modifyRateFields(1);'>" . Labels::getLabel("LBL_Add_Condition", $siteLangId) . "</a></p> <p class='remove-condition--js' style='display : none;'><a href='javascript:void(0);' onclick='modifyRateFields(0);'>" . Labels::getLabel("LBL_Remove_Condition", $siteLangId) . "</a></p>";
$extraClass = 'hide';
if (!empty($rateData) && $rateData['shiprate_condition_type'] > 0) {
    $extraClass = '';
}
$cndFld = $frm->getField('shiprate_condition_type');
$cndFld->setWrapperAttribute('class', 'condition-field--js ' . $extraClass);

$minFld = $frm->getField('shiprate_min_val');
$minFld->setWrapperAttribute('class', 'condition-field--js ' . $extraClass);

$maxFld = $frm->getField('shiprate_max_val');
$maxFld->setWrapperAttribute('class', 'condition-field--js ' . $extraClass);
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
                    <a class="nav-link <?php echo $activeLangtab; ?>" href="javascript:void(0);" <?php if (0 < $recordId) { ?>onclick="editRateLangForm('<?php echo $zoneId; ?>', '<?php echo $rateId; ?>', '<?php echo array_key_first($languages); ?>');" <?php } ?> title="<?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>">
                        <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>
                    </a>
                <?php } ?> 
            </nav>
        </div>
    <?php } ?> 
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
        </form>
    </div>
    <?php
    require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php');
    ?>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->
<?php if (!empty($rateData) && $rateData['shiprate_condition_type'] > 0) { ?>
    <script>
        $(document).ready(function () {
            $('.add-condition--js').hide();
            $('.remove-condition--js').show();
        });
    </script>
    <?php
}