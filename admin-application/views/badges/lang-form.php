<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form form_horizontal layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'setupLang(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$langFld = $frm->getField('badgelang_lang_id');
$langFld->setfieldTagAttribute('onChange', "langForm(" . $badge_id . ", this.value);");
?>
<div class="tabs_panel_wrap tabs_panel--js" style="min-height: inherit;">
    <?php 
        $this->includeTemplate('_partial/autofill-translate-lang-btn.php', ['record_id' => $badge_id, 'recordLang_id' => $langId]); 
    ?>
    <div class="tabs_panel">
        <?php echo $frm->getFormHtml(); ?>
    </div>
</div>