<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'pickupAddressFrm');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'setPickupAddress(this); return(false);');

$addrLabelFld = $frm->getField('addr_title');
$addrLabelFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_E.g:_My_Office_Address', $siteLangId));

$countryFld = $frm->getField('addr_country_id');
$countryFld->setFieldTagAttribute('id', 'addr_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#addr_state_id\')');

$stateFld = $frm->getField('addr_state_id');
$stateFld->setFieldTagAttribute('id', 'addr_state_id');

$slotTypeFld = $frm->getField('tslot_availability');
$slotTypeFld->setOptionListTagAttribute('class', 'list-inline');
$slotTypeFld->developerTags['rdLabelAttributes'] = array('class' => 'radio');
$slotTypeFld->developerTags['rdHtmlAfterRadio'] = '';
$slotTypeFld->setFieldTagAttribute('onChange', 'displaySlotTimings(this);');
$slotTypeFld->setFieldTagAttribute('class', 'availabilityTypeJs');

$cancelFld = $frm->getField('btn_cancel');
$cancelFld->setFieldTagAttribute('class', 'btn btn-outline-brand');
$cancelFld->developerTags['col'] = 2;
$cancelFld->developerTags['noCaptionTag'] = true;

$btnSubmit = $frm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
$btnSubmit->developerTags['col'] = 2;
$btnSubmit->developerTags['noCaptionTag'] = true;

$variables = array('language' => $language, 'siteLangId' => $siteLangId, 'shop_id' => $shop_id, 'action' => $action);
$this->includeTemplate('seller/_partial/shop-navigation.php', $variables, false);
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title"><?php echo Labels::getLabel('LBL_Shop_Pickup_Addresses', $siteLangId); ?></h5>
        <div class="btn-group">
            <a href="javascript:void(0)" onClick="pickupAddress()"
               class="btn btn-outline-brand btn-sm"><?php echo Labels::getLabel('LBL_Back', $siteLangId); ?></a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo $frm->getFormTag(); ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('addr_title');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('addr_title'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('addr_name');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                                <span class="spn_must_field">*</span>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('addr_name'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('addr_address1');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                                <span class="spn_must_field">*</span>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('addr_address1'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('addr_address2');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('addr_address2'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('addr_country_id');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                                <span class="spn_must_field">*</span>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('addr_country_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('addr_state_id');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                                <span class="spn_must_field">*</span>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('addr_state_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('addr_city');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                                <span class="spn_must_field">*</span>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('addr_city'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('addr_zip');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                                <span class="spn_must_field">*</span>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('addr_zip'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('addr_phone');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                                <span class="spn_must_field">*</span>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php
                                    echo $frm->getFieldHtml('addr_phone');
                                    echo $frm->getFieldHtml('addr_phone_dcode');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('tslot_availability');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('tslot_availability'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row js-slot-individual">
                    <?php
                    $daysArr = TimeSlot::getDaysArr($siteLangId);
                    $row = 0;
                    for ($i = 0; $i < count($daysArr); $i++) {
                        $dayFld = $frm->getField('tslot_day[' . $i . ']');
                        $dayFld->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
                        $dayFld->developerTags['cbHtmlAfterCheckbox'] = '';
                        $dayFld->setFieldTagAttribute('onChange', 'displayFields( this)');
                        $dayFld->setFieldTagAttribute('class', 'slotDaysJs');
                        if (isset($slotData['tslot_day'][$i])) {
                            $dayFld->setFieldTagAttribute('checked', 'true');
                        }                     
                        ?> 
                        <div class="col-md-6 dayJs-<?php echo $i;?>">
                            <div class="row ">
                                <div class="col-md-12 weekDayParentRowJs">
                                    <div class="field-set weekDayJs">
                                        <div class="caption-wraper">
                                            <label class="field_label">
                                            </label>
                                        </div>
                                        <div class="field-wraper">
                                            <div class="field_cover">
                                                <?php echo $frm->getFieldHtml('tslot_day[' . $i . ']'); ?>
                                                <label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php                                    
                                    $fromTimeWeekDayArr = $slotData['tslot_from_time'][$i] ?? ['']; 
                                    $toTimeWeekDayArr = $slotData['tslot_to_time'][$i] ?? [''];                                    
                                    foreach ($fromTimeWeekDayArr as $key => $time) {

                                        $fromTime = !empty($time) ? date('H:i', strtotime($time)) :'';
                                        $toTime = !empty($toTimeWeekDayArr[$key]) ? date('H:i', strtotime($toTimeWeekDayArr[$key])):'';

                                        $fromFld = $frm->getField('tslot_from_time[' . $i . '][]');
                                        $fromFld->setFieldTagAttribute('class', 'fromTimeJs');
                                        $fromFld->setFieldTagAttribute('data-row', $row);
                                        $fromFld->setFieldTagAttribute('onChange', 'displayAddRowField(this)');
                                        $fromFld->value = $fromTime;

                                        $toFld = $frm->getField('tslot_to_time[' . $i . '][]');
                                        $toFld->setFieldTagAttribute('class', 'toTimeJs');
                                        $toFld->setFieldTagAttribute('data-row', $row);
                                        $toFld->setFieldTagAttribute('onChange', 'displayAddRowField(this)');
                                        $toFld->value = $toTime;
                                        ?>              
                                        <div class="row weekDayRowJs">
                                            <div class="col-md-4">
                                                <div class="field-set">
                                                    <div class="caption-wraper">
                                                        <label class="field_label"><?php $frm->getField('tslot_from_time[' . $i . '][]')->getCaption() ?></label>
                                                    </div>
                                                    <div class="field-wraper">
                                                        <div class="field_cover">
                                                            <?php echo $frm->getFieldHtml('tslot_from_time[' . $i . '][]'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="field-set">
                                                    <div class="caption-wraper">
                                                        <label class="field_label">
                                                            <?php $frm->getField('tslot_to_time[' . $i . '][]')->getCaption() ?>
                                                        </label>
                                                    </div>
                                                    <div class="field-wraper">
                                                        <div class="field_cover">
                                                            <?php echo $frm->getFieldHtml('tslot_to_time[' . $i . '][]'); ?> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="field-set">
                                                    <div class="caption-wraper">
                                                        <label class="field_label">
                                                        </label>
                                                    </div>
                                                    <div class="field-wraper">
                                                        <div class="field_cover btn-group">                                                    
                                                            <button class="btn btn-outline-brand btn-sm removeButtonJs <?php echo $key == 0  ? 'd-none': ''?>" onClick="removeTimeSlotRow(this)"  type="button" >
                                                                <i class="icn"><svg class="svg" width="16px" height="16px">
                                                                    <use xlink:href="/dashboard/images/retina/sprite.svg#minus"></use></svg>
                                                                </i>
                                                            </button>                                                    
                                                            <button class="btn btn-brand btn-sm addButtonJs <?php echo count($fromTimeWeekDayArr) - 1 == $key ? '' : 'd-none' ?>" type="button"
                                                                onClick="addTimeSlotRow(this)" >
                                                                <i class="icn">
                                                                    <svg class="svg" width="16px" height="16px">
                                                                        <use xlink:href="/dashboard/images/retina/sprite.svg#plus">
                                                                        </use>
                                                                    </svg>
                                                                </i>
                                                            </button>                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php
                                    echo $frm->getFieldHtml('addr_id');
                                    echo $frm->getFieldHtml('btn_submit');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <?php echo $frm->getExternalJS(); ?>
            </div>
        </div>
    </div>
</div>

<script language="javascript">
    var DAY_SUNDAY = <?php echo TimeSlot::DAY_SUNDAY; ?>;
    $(document).ready(function () {
        getCountryStates($("#addr_country_id").val(), <?php echo ($stateId) ? $stateId : 0; ?>, '#addr_state_id');

        addTimeSlotRow = function (ele) {
            let mainParent = $(ele).closest(".weekDayParentRowJs");
            var clonedRow = $('.weekDayRowJs:last', mainParent).clone();            
            var toTime = $(ele).closest('.weekDayRowJs').find('.toTimeJs').val();
            $(clonedRow).find('.toTimeJs').val('');
            $(clonedRow).find('.fromTimeJs').val('');            
            $(clonedRow).find('.fromTimeJs option').each(function () {
                var toVal = $(this).val();  
                $(this).removeClass('d-none');                
                if (toVal != '' && toVal <= toTime) {
                    $(this).addClass('d-none');
                }                
            });
            $(clonedRow).find('.removeButtonJs').removeClass('d-none');
            $(clonedRow).find('.addButtonJs').addClass('d-none');
            mainParent.append(clonedRow);            
           
            $(ele).addClass('d-none');
            if(1 > $(mainParent).find('.weekDayRowJs').lenth){
               $(ele).sibling('.removeButtonJs').removeClass('d-none');  
            }            
        }
        
        removeTimeSlotRow = function (ele) {
            let mainParent = $(ele).closest(".weekDayParentRowJs");        
            let row = $(ele).closest(".weekDayRowJs");
           
            
            if($(row).index() <  $(row).siblings().length){        
                let toTimeOfParentSibling =  $('.weekDayRowJs:eq('+($(row).index() - 2)+')',mainParent).find('.toTimeJs').val();        
                /* downSiblingTimeOption show hide*/            
                $('.weekDayRowJs:eq('+($(row).index())+')',mainParent).find('.fromTimeJs option').each(function () {
                    var toVal = $(this).val();  
                    $(this).removeClass('d-none');                
                    if (toVal != '' && toVal <= toTimeOfParentSibling) {
                        $(this).addClass('d-none');
                    }                
                });
            }            
            $(ele).closest('.weekDayRowJs').remove();
            $(mainParent).find('.weekDayRowJs:last .addButtonJs').removeClass('d-none'); 
        }

        displayFields = function (ele) {
            let mainParent = $(ele).closest(".weekDayParentRowJs");
            if ($(ele).prop("checked") == true) {                
               $('.weekDayRowJs:first',mainParent).find('select').removeAttr('disabled');
               $('.weekDayRowJs:first .toTimeJs',mainParent).trigger('change');
            } else {
                $('.weekDayRowJs:first',mainParent).find('select').attr('disabled', 'true');
                $('.weekDayRowJs:not(:first)', mainParent).remove();
                $('.weekDayRowJs .addButtonJs', mainParent).addClass('d-none');
            }
        }
        
        displayAddRowField = function(ele){
            let mainParent = $(ele).closest(".weekDayParentRowJs");
            let row = $(ele).closest('.weekDayRowJs');
            let formEle = $(row).find('.fromTimeJs');
            let toEle = $(row).find('.toTimeJs');
    
            
            var fromTime = $(formEle).val();
            var toTime = $(toEle).val(); 
            if (fromTime == '' && toTime != '') {
                $(toEle).val('');
                $.mbsmessage(langLbl.invalidFromTime, true, 'alert--danger');
                return false;
            }            
            $(toEle).find('option').each(function () {
                var toOptionVal = $(this).val();  
                $(this).removeClass('d-none');                
                if (toOptionVal != '' && toOptionVal <= fromTime) {
                    $(this).addClass('d-none');
                }                
            });            
            if(fromTime!= '' & toTime!=''){
                if(fromTime > toTime){
                    $(toEle).val('');
                }else{
                    if(toTime < $(toEle).find('option:last').val()){ 
                        if($(row).index() >=  $(row).siblings().length){
                           $(row).find('.addButtonJs').removeClass('d-none');  
                        }                                                                    
                    }else{
                        $(row).find('.addButtonJs').addClass('d-none'); 
                    }                        
                }                
            }
            
            
            if($(row).index() <  $(row).siblings().length){              
                     /* downSiblingTimeOption */       
                let downRowSibling  = $('.weekDayRowJs:eq('+($(row).index())+')',mainParent);
                let downFromTimeSibling = $(downRowSibling).find('.fromTimeJs');               
                if($(downFromTimeSibling).val() < toTime){    
                    console.log('vvv');
                    $(row).nextAll().find('.toTimeJs').val('');
                    $(row).nextAll().find('.fromTimeJs').val('');                    
                }
                $(downFromTimeSibling).find('option').each(function () {
                    var toVal = $(this).val();  
                    $(this).removeClass('d-none');
                    if (toVal != '' && toVal <= toTime) {
                        $(this).addClass('d-none');                        
                    }                
                });
            } 
            
            
        }
               
        displaySlotTimings = function (ele) {
            var selectedVal = $(ele).val();
            if (selectedVal == 2) {
                $('.weekDayParentRowJs:not(:first)').addClass('d-none');
                $('.weekDayParentRowJs:first .weekDayJs').addClass('d-none');
                $('.weekDayParentRowJs:first .slotDaysJs').prop("checked",true).trigger('change');                
            } else {
                $('.weekDayParentRowJs').removeClass('d-none');
                $('.weekDayParentRowJs .weekDayJs').removeClass('d-none');
            }
        }
        
        $('.availabilityTypeJs:checked').trigger('change');
        $('.slotDaysJs').trigger('change');
    });

</script>