<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');

$delBtn = '<button type="button" data-id="' . $firstCompontentId . '" class="btn btn--secondary ripplelink remove-combined-form--js ml-2" title="Remove">
        <svg class="svg" width="18" height="18">
            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#delete">
            </use>
        </svg>
    </button>';
$addBtn = '<button type="button"  class="btn btn--secondary ripplelink add-combined-form--js ml-2" title="Add"> 
        <svg class="svg" width="18" height="18">
            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#add">
            </use>
        </svg>
    </button>';
$htmlFld = $frm->getField('component_link');
$htmlFld->value = ' ' . $addBtn . $delBtn . ' ';
$otherButtons = [];

$formTitle = Labels::getLabel('LBL_TAX_STRUCTURE_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.component_link').closest('.col-md-12').addClass('hide');
        if ($("input[name=taxstr_is_combined]").prop('checked') == true) {
            $('.component_link').closest('.col-md-12').removeClass('hide');
        }
<?php
if (!empty($combinedTaxes)) {
    foreach ($combinedTaxes as $key => $tax) {
        ?>
                $('.component_link').find('.component-row--js').last().after($('.component_link').find('.component-row--js').last().clone());
                $('.component_link').find('.component-row--js').last().find('input[type=text]').val('<?php echo $tax; ?>');
                $('.component_link').find('.component-row--js').last().find('.remove-combined-form--js').removeClass('hide');
                $('.component_link').find('.component-row--js').last().find('.remove-combined-form--js').attr('data-id', '<?php echo $key; ?>');
        <?php
    }
}
?>
    });
</script>