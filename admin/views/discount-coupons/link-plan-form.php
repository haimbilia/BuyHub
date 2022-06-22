<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('plan_name');
$fld->addFieldTagAttribute('class', 'tagifyJs');
$fld->addFieldTagAttribute('data-record-id', $recordId);

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    $(document).ready(function() {
        bindTagify();
    });
</script>