<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', $keywordPlaceholder);

$moduleFld = $frmSearch->getField('select_module');
$moduleFld->addFieldtagAttribute('class', 'form-control');

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

echo $frmSearch->getFormTag();
HtmlHelper::renderHiddenFields($frmSearch);
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <?php echo $frmSearch->getFieldHtml('keyword'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $frmSearch->getFieldHtml('select_module'); ?>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                    <div class="input-group-append">
                        <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>