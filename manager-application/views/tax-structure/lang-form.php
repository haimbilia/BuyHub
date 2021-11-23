<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$otherButtons = [
];
$delBtn = '<button type="button" data-id="0" class="btn btn--secondary ripplelink remove-combined-form--js ml-2" title="Remove">
        <svg class="svg" width="18" height="18">
            <use xlink:href="/admin/images/retina/sprite-actions.svg#delete">
            </use>
        </svg>
    </button>';
$addBtn = '<button type="button" class="btn btn--secondary ripplelink add-combined-form--js ml-2" title="Add">
        <svg class="svg" width="18" height="18">
            <use xlink:href="/admin//images/retina/sprite-actions.svg#add">
            </use>
        </svg>
    </button>';
$htmlFld = $langFrm->getField('component_link');
$htmlFld->value = $addBtn . $delBtn;
$formTitle = Labels::getLabel('LBL_BRAND_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.component_link').closest('.col-md-12').addClass('hide');
        if ($("input[name=taxstr_is_combined]").prop('checked') == true) {
            $('.component_link').closest('.col-md-12').removeClass('hide');
        }
    });
</script>