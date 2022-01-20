<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'changeRequestStatus(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'requestStatusForm(' . $recordId . ')');

$fld = $frm->getField('preq_status');
$fld->addFieldTagAttribute('id','preqStatusId');

$fld =  $frm->getField('preq_comment');
$fld->addWrapperAttribute('id','preqCommentWrapperJs');

$formTitle = Labels::getLabel('LBL_UPDATE_STATUS', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');

?>

<script>

$('#preqStatusId').change(function(){
    if($(this).val() == <?php echo ProductRequest::STATUS_CANCELLED; ?>){
            $('#preqCommentWrapperJs').show();
    }else{
        $('#preqCommentWrapperJs').hide();
    } 
});

$('#preqStatusId').trigger('change');

</script>
