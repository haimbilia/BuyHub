<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frm->setFormTagAttribute('class', 'form form--horizontal');
    $frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
    $frm->developerTags['fld_default_col'] = 12;
    $frm->setFormTagAttribute('onsubmit', 'setupRequestData(this); return(false);');
    
    $submitFld = $frm->getField('btn_submit');
    $submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-wide');
?>

<div class="modal-header">
	<h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_REQUEST_DATA', $siteLangId); ?>
        <br>
        <small><?php echo Labels::getLabel('LBL_REQUEST_SYSTEM_OWNER_TO_GET_YOUR_ACCOUNT_INFORMATION', $siteLangId); ?></small>
    </h5>
</div>
<div class="modal-body">
    <div class="form__subcontent">
        <?php
        $btnFld = $frm->getField('btn_submit');
        if (!empty($gdprPolicyLinkHref)) {
            $btnFld->htmlBeforeField = str_replace("{clickhere}", '<a class="btn-link" target="_blank" href="' . $gdprPolicyLinkHref . '">' . Labels::getLabel('LBL_Click_Here', $siteLangId) . '</a>', Labels::getLabel('LBL_{CLICKHERE}_TO_READ_THE_POLICIES_OF_GDPR', $siteLangId)) . '<br/><br/>';
        }
        echo $frm->getFormHtml();
        ?>
    </div>
</div>