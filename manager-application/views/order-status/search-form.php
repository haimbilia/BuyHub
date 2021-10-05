<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this, false); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_ORDER_STATUS', $adminLangId));

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

/* Extra Field */
$fld = $frmSearch->getField('orderstatus_type');
$fld->addFieldtagAttribute('class', 'form-control');
/* Extra Field */

echo $frmSearch->getFormTag();
foreach ($frmSearch->getAllFields() as $key => $frmFld) {
    if ('hidden' == $frmFld->fldType) {
        echo $frmSearch->getFieldHtml($frmFld->getName());
    }
}
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="input-group">
                    <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                </div>
            </div>
            <div class="col-md-4">
                <?php echo $frmSearch->getFieldHtml('orderstatus_type'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
            </div>
        </div>
    </div>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>