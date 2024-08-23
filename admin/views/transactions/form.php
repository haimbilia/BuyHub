<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('data-onclear', 'addNew()');
$fld = $frm->getField('utxn_user_id');
$fld->addFieldTagAttribute('id', 'userIdJs');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_SELECT_USER', $siteLangId));

$fld = $frm->getField('type');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('amount');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>
<?php if ($userId == 0) { ?>
    <script>
        $(document).ready(function() {
            bindUserSelect2('userIdJs', {
                'parents_only': 1
            });
        });
    </script>
<?php } ?>