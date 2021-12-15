<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
//$frm->developerTags['colClassPrefix'] = 'col-md-';
//$frm->developerTags['fld_default_col'] = 6;

$frm->setFormTagAttribute('dir', $formLayout);
$langFld = $frm->getField('lang_id');
$langFld->setFieldTagAttribute('onChange', "editRecord(" . $addressId . ", this.value);");

$addrLabelFld = $frm->getField('addr_title');
$addrLabelFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_E.g:_My_Office_Address', $langId));

$countryFld = $frm->getField('addr_country_id');
$countryFld->setFieldTagAttribute('id', 'addr_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#shop_state\',' . $langId . ')');

$stateFld = $frm->getField('addr_state_id');
$stateFld->setFieldTagAttribute('id', 'shop_state');

$slotTypeFld = $frm->getField('tslot_availability');
$slotTypeFld->setOptionListTagAttribute('class', 'list-inline-checkboxes');
$slotTypeFld->developerTags['rdLabelAttributes'] = array('class' => 'radio');
$slotTypeFld->developerTags['rdHtmlAfterRadio'] = '<i class="input-helper"></i>';
$slotTypeFld->setFieldTagAttribute('onChange', 'displaySlotTimings(this);');
$slotTypeFld->setFieldTagAttribute('class', 'availabilityType-js');

$slotTypeFld = $frm->getField('tslot_availability');
$slotTypeFld->addOptionListTagAttribute('class', 'list-radio');
$slotTypeFld->addFieldTagAttribute('class', 'prefRatio-js');
?>
<div class="modal-header">
    <h5 class="modal-title">
<?php echo Labels::getLabel('LBL_PICKUP_ADDRESSES_SETUP'); ?>
    </h5>
</div>
<div class="form-edit-body loaderContainerJs sectionbody space">
    <div class="row">
        <div class="col-md-12">
<?php echo $frm->getFormTag(); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label"> <?php
echo $frm->getFieldHtml('addr_id');
$fld = $frm->getField('lang_id');
echo $fld->getCaption();
?> </label>
                        <div class=""> <?php echo $frm->getFieldHtml('lang_id'); ?> </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label"><?php
                            $fld = $frm->getField('addr_title');
                            echo $fld->getCaption();
?>
                        </label>
                        <div class="">
<?php echo $frm->getFieldHtml('addr_title'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label"><?php
$fld = $frm->getField('addr_name');
echo $fld->getCaption();
?>
                            <span class="spn_must_field">*</span>
                        </label>
                        <div class="">
<?php echo $frm->getFieldHtml('addr_name'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label"><?php
$fld = $frm->getField('addr_address1');
echo $fld->getCaption();
?>
                            <span class="spn_must_field">*</span>
                        </label>
                        <div class="">
<?php echo $frm->getFieldHtml('addr_address1'); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label">
<?php
$fld = $frm->getField('addr_address2');
echo $fld->getCaption();
?>
                        </label>

                        <div class=" ">
<?php echo $frm->getFieldHtml('addr_address2'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label">
<?php
$fld = $frm->getField('addr_country_id');
echo $fld->getCaption();
?>
                            <span class="spn_must_field">*</span>
                        </label>
                        <div class="field_cover">
<?php echo $frm->getFieldHtml('addr_country_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label">
<?php
$fld = $frm->getField('addr_state_id');
echo $fld->getCaption();
?>
                            <span class="spn_must_field">*</span>
                        </label>
                        <div class=" ">
<?php echo $frm->getFieldHtml('addr_state_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label">
<?php
$fld = $frm->getField('addr_city');
echo $fld->getCaption();
?>
                            <span class="spn_must_field">*</span>
                        </label>
                        <div class=" ">
<?php echo $frm->getFieldHtml('addr_city'); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label">
<?php
$fld = $frm->getField('addr_zip');
echo $fld->getCaption();
?>
                            <span class="spn_must_field">*</span>
                        </label>
                        <div class=" ">
<?php echo $frm->getFieldHtml('addr_zip'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label">
<?php
$fld = $frm->getField('addr_phone');
echo $fld->getCaption();
?>
                            <span class="spn_must_field">*</span>
                        </label>

                        <div class=" ">
<?php
echo $frm->getFieldHtml('addr_phone');
echo $frm->getFieldHtml('addr_phone_dcode');
?>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="label">
<?php
$fld = $frm->getField('tslot_availability');
echo $fld->getCaption();
?>
                        </label>
                        <div class=" ">
<?php echo $frm->getFieldHtml('tslot_availability'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 js-slot-individual">
                    <div class="table-responsive table-scrollable js-scrollable">
                        <table class="table table-slots">
                            <thead>
                                <tr>
                                    <th>Days</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th class="align-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$daysArr = TimeSlot::getDaysArr($langId);
$row = 0;
for ($i = 0;
        $i < count($daysArr);
        $i++) {
    $dayFld = $frm->getField('tslot_day[' . $i . ']');
    $dayFld->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
    $dayFld->developerTags['cbHtmlAfterCheckbox'] = '<i class="input-helper"></i>';
    $dayFld->setFieldTagAttribute('onChange', 'displayFields(' . $i . ', this)');
    $dayFld->setFieldTagAttribute('class', 'slotDays-js');

    $addRowFld = $frm->getField('btn_add_row[' . $i . ']');
    $addRowFld->setFieldTagAttribute('onClick', 'addTimeSlotRow(' . $i . ')');
    $addRowFld->setFieldTagAttribute('class', 'js-slot-add-' . $i);
    if (!empty($slotData) && isset($slotData['tslot_day'][$i])) {
        $dayFld->setFieldTagAttribute('checked', 'true');
        foreach ($slotData['tslot_from_time'][$i] as $key => $time) {
            $fromTime = date('H:i', strtotime($time));
            $toTime = date('H:i', strtotime($slotData['tslot_to_time'][$i][$key]));

            $fromFld = $frm->getField('tslot_from_time[' . $i . '][]');
            $fromFld->setFieldTagAttribute('class', 'js-slot-from-' . $i . ' fromTime-js');
            $fromFld->setFieldTagAttribute('data-row', $row);
            $fromFld->setFieldTagAttribute('onChange', 'displayAddRowValues(' . $i . ', this)');
            $fromFld->value = $fromTime;

            $toFld = $frm->getField('tslot_to_time[' . $i . '][]');
            $toFld->setFieldTagAttribute('class', 'js-slot-to-' . $i);
            $toFld->setFieldTagAttribute('data-row', $row);
            $toFld->setFieldTagAttribute('onChange', 'displayAddRowValues(' . $i . ', this)');
            $toFld->value = $toTime;
            ?>

                                            <tr data-count="<?php echo $row; ?>" class="rows jsDay-<?php echo $i; ?> row-<?php
                                echo $row;
                                echo ($key > 0) ? ' js-added-rows-' . $i : ''
            ?>">

                                                <td class="<?php echo ($key != 0) ? "border-0" : "jsWeekDay" ?>">
            <?php if ($key == 0) { ?> 
                                                        <?php echo $frm->getFieldHtml('tslot_day[' . $i . ']'); ?>
                                                        <span class="input-helper"></span> 
                                                    <?php }
                                                    ?>
                                                </td>
                                                <td <?php if ($key != 0) { ?> class="border-0" <?php } ?>>
            <?php echo $frm->getFieldHtml('tslot_from_time[' . $i . '][]'); ?>
                                                </td>
                                                <td <?php if ($key != 0) { ?> class="border-0" <?php } ?>>
            <?php echo $frm->getFieldHtml('tslot_to_time[' . $i . '][]'); ?>
                                                </td> 
                                                <td class="align-right <?php if ($key != 0) { ?> border-0<?php } ?>" >
                                                    <ul class="actions"> 
                                                        <li class="addRowBtn<?php echo $i; ?>-js">
                                                            <a href="javascript:void(0)" onclick="addRow('<?php echo $i; ?>')" class=""><svg class="svg" width="18" height="18">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#add">
                                                                </use>
                                                                </svg>
                                                            </a>
                                                        </li>
            <?php if ($key != 0) { ?>
                                                            <li class="btn-remove-row-js" data-day="<?php echo $i; ?>">
                                                                <a href="javascript:void(0)" class=""><svg class="svg" width="18" height="18">
                                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                    </use>
                                                                    </svg>
                                                                </a>
                                                            </li>
            <?php } ?>
                                                    </ul> 
                                                </td> 
                                            </tr> 
            <?php
            $row++;
        }
    } else {
        $addRowFld->setFieldTagAttribute('class', 'd-none js-slot-add-' . $i);

        $fromFld = $frm->getField('tslot_from_time[' . $i . '][]');
        $fromFld->setFieldTagAttribute('disabled', 'true');
        $fromFld->setFieldTagAttribute('data-row', $row);
        $fromFld->setFieldTagAttribute('class', 'js-slot-from-' . $i . ' fromTime-js');
        $fromFld->setFieldTagAttribute('onChange', 'displayAddRowValues(' . $i . ', this)');

        $toFld = $frm->getField('tslot_to_time[' . $i . '][]');
        $toFld->setFieldTagAttribute('disabled', 'true');
        $toFld->setFieldTagAttribute('data-row', $row);
        $toFld->setFieldTagAttribute('class', 'js-slot-to-' . $i);
        $toFld->setFieldTagAttribute('onChange', 'displayAddRowValues(' . $i . ', this)');
        ?>
                                        <tr data-count="<?php echo $i; ?>" class="rows jsDay-<?php echo $i; ?> row-<?php echo $row; ?>">
                                            <td  class= "jsWeekDay"> 
        <?php echo $frm->getFieldHtml('tslot_day[' . $i . ']'); ?>
                                                <span class="input-helper"></span>  
                                            </td>
                                            <td>
        <?php echo $frm->getFieldHtml('tslot_from_time[' . $i . '][]'); ?>
                                            </td>
                                            <td>
        <?php echo $frm->getFieldHtml('tslot_to_time[' . $i . '][]'); ?>
                                            </td> 
                                            <td class="align-right" >
                                                <ul class="actions">  
                                                    <li class="addRowBtn<?php echo $i; ?>-js">
                                                        <a href="javascript:void(0)" onclick="addRow('<?php echo $i; ?>')" class=""><svg class="svg" width="18" height="18">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#add">
                                                            </use>
                                                            </svg>
                                                        </a>
                                                    </li> 
                                                </ul> 
                                            </td> 
                                        </tr> 
        <?php
        $row++;
    }
}
?>
                            </tbody> 
                        </table>

                        <div>&nbsp;</div>
                        <div>&nbsp;</div>  
                        <div>&nbsp;</div>
                        <div>&nbsp;</div> 
                    </div>
                </div>

                </form>
<?php echo $frm->getExternalJS(); ?>

            </div>
        </div>

    </div>


</div>
<div class="form-edit-foot">
    <div class="row">
        <div class="col">
<?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_RESET', $siteLangId), 'button', 'btn_reset_form', 'btn btn-outline-brand resetModalFormJs'); ?>
        </div>
        <div class="col-auto">
<?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_SAVE', $siteLangId), 'button', 'btn_save', 'btn btn-brand gb-btn gb-btn-primary submitBtnJs'); ?>
        </div>
    </div>
</div>

<script language="javascript">
    var DAY_SUNDAY = <?php echo TimeSlot::DAY_SUNDAY; ?>;
<?php if ($addressId > 0) { ?>
        $(document).ready(function () {
            $('.availabilityType-js:checked').trigger('change');
            getCountryStates($("#addr_country_id").val(), <?php echo ($stateId) ? $stateId : 0; ?>, '#shop_state', <?php echo $langId; ?>);

        });
<?php } ?>
</script>