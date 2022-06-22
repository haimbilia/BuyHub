<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$frmSearch->setFormTagAttribute('class', 'modal-body form ');
$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', $keywordPlaceholder);

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

/* Extra Field */
$userNameFld = $frmSearch->getField('user_name');
if (null != $userNameFld) {
    $userNameFld->addFieldtagAttribute('class', 'form-control');
}
/* Extra Field */

echo $frmSearch->getFormTag();
HtmlHelper::renderHiddenFields($frmSearch);
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="input-group">
                    <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                    <?php if (null == $userNameFld) { ?>
                        <div class="input-group-append">
                            <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if (null != $userNameFld) { ?>
                <div class="col-md-4">
                    <?php echo $frmSearch->getFieldHtml('user_name'); ?>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                        <div class="input-group-append">
                            <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>