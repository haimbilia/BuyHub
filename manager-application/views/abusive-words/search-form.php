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

/* Extra Field */
$fld = $frmSearch->getField('lang_id');
$col = 6;
if (null != $fld) {
    $col = 4;
    $fld->addFieldtagAttribute('class', 'form-control');
}

/* Extra Field */
echo $frmSearch->getFormTag();
HtmlHelper::renderHiddenFields($frmSearch);
?>
<div class="card-head">
    <div class="card-head-label">
        <div class="row">
            <div class="col-md-<?php echo $col; ?>">
                <?php echo $frmSearch->getFieldHtml('keyword'); ?>
            </div>
            <?php if (null != $fld) { ?>
                <div class="col-md-<?php echo $col; ?>">
                    <?php echo $frmSearch->getFieldHtml('lang_id'); ?>
                </div>
            <?php } ?>
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