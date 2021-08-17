<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onsubmit', 'setCookiesPreferences(this); return(false);');
//$frm->setFormTagAttribute('id', 'bankInfoFrm');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 4;

$fld = $frm->getField('ucp_functional');
$fld->setFieldTagAttribute('disabled', "disabled");

$fld = $frm->getField('btn_submit');
$fld->developerTags['col'] = 12;
$fld->setFieldTagAttribute('class', "btn btn-brand");
?>

<?php echo $frm->getFormTag(); ?>
<ul class="cookie-preferences">
    <li>
        <?php echo $frm->getFieldHtml('ucp_functional'); ?>
        <div class="data">
            <p>
                <?php echo Labels::getLabel('LBL_Functional_Cookies_Information', $siteLangId); ?>
            </p>
        </div>
    </li>
    <li>
        <?php echo $frm->getFieldHtml('ucp_statistical'); ?>
        <div class="data">
            <p>
                <?php echo Labels::getLabel('LBL_Statistical_Analysis_Cookies_Information', $siteLangId); ?>
            </p>
        </div>
    </li>
    <li>
        <?php echo $frm->getFieldHtml('ucp_personalized'); ?>
        <div class="data">
            <p>
                <?php echo Labels::getLabel('LBL_Statistical_Analysis_Cookies_Information', $siteLangId); ?>
            </p>
        </div>
    </li>
</ul>

<?php echo $frm->getFieldHtml('btn_submit'); ?>
</form>
<?php echo $frm->getExternalJs();  ?>