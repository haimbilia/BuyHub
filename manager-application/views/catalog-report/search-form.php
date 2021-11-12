<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH', $siteLangId));

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
            <div class="col-md-8">
                <?php echo $frmSearch->getFieldHtml('keyword'); ?>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <?php echo $frmSearch->getFieldHtml('btn_submit');
                    if (empty($orderDate)) { ?>
                        <div class="input-group-append">
                            <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-head.php'); ?>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>