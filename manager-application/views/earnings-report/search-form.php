<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$dateFrmFld = $frmSearch->getField('date_from');
$dateFrmFld->addFieldtagAttribute('class', 'form-control');
$dateFrmFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_FROM_DATE', $siteLangId));

$dateToFld = $frmSearch->getField('date_to');
$dateToFld->addFieldtagAttribute('class', 'form-control');
$dateToFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_TO_DATE', $siteLangId));

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

echo $frmSearch->getFormTag();
HtmlHelper::renderHiddenFields($frmSearch);
?>
<div class="card-head">
    <div class="card-head-label">
        <div class="row">
            <div class="col-md-4">
                <?php echo $frmSearch->getFieldHtml('date_from'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $frmSearch->getFieldHtml('date_to'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
            </div>

        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-head.php'); ?>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>