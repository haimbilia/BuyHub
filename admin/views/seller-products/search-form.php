<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form form-search');

$fld = $frmSearch->getField('keyword');
$fld->addFieldtagAttribute('class', 'form-control');
$fld->setFieldtagAttribute('placeholder', $keywordPlaceholder);

$fld = $frmSearch->getField('user_id');
$fld->addFieldtagAttribute('id', 'user_id');

$fld = $frmSearch->getField('sortBy');
$fld->setFieldTagAttribute('id', 'sortBy');

$fld = $frmSearch->getField('sortOrder');
$fld->setFieldTagAttribute('id', 'sortOrder');

/* Extra Field */
$fld = $frmSearch->getField('user_name');
if (null != $fld) {
    $fld->addFieldtagAttribute('class', 'form-control');
}

$fld = $frmSearch->getField('prodcat_id');
if (null != $fld) {
    $fld->setFieldTagAttribute('id', 'prodcatIdJs');
    $fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_CATEGORY', $siteLangId));
}
require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>

<script type="text/javascript">
    $("document").ready(function() {
        select2('user_id', fcom.makeUrl('Users', 'autoComplete'), {
            user_is_seller: 1,
            credential_active: 1,
            credential_verified: 1
        });

        $("#prodcatIdJs").select2({
            dropdownParent: $("#prodcatIdJs").closest('form'),
            allowClear: true,
            placeholder: $("#prodcatIdJs").attr('placeholder')
        }).on('select2:open', function(e) {             
            $("#prodcatIdJs").data("select2").$dropdown.addClass("custom-select2 custom-select2-single");
        }).data("select2").$container.addClass("custom-select2-width custom-select2 custom-select2-single");

    });
</script>