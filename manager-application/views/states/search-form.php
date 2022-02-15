<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form form-search');

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', $keywordPlaceholder);

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
                <?php echo $frmSearch->getFieldHtml('keyword'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $frmSearch->getFieldHtml('country'); ?>
            </div>
            <div class="col-md-3">
                <div class="btn-group">
                    <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                    <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-head.php'); ?>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>