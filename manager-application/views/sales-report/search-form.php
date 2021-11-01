<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

if (!empty($orderDate)) {
    $keyWordFld = $frmSearch->getField('keyword');
    $keyWordFld->addFieldtagAttribute('class', 'form-control');
    $keyWordFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_INVOICE_NUMBER', $siteLangId));
} else {
    $dateFrmFld = $frmSearch->getField('date_from');
    $dateFrmFld->addFieldtagAttribute('class', 'form-control');
    $dateFrmFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_FROM_DATE', $siteLangId));

    $dateToFld = $frmSearch->getField('date_to');
    $dateToFld->addFieldtagAttribute('class', 'form-control');
    $dateToFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_TO_DATE', $siteLangId));
}

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
            <?php
            $buttonCol = 6;
            if (!empty($orderDate)) { ?>
                <div class="col-md-6">
                    <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                </div>
            <?php } else { ?>
                <div class="col-md-4">
                    <?php echo $frmSearch->getFieldHtml('date_from'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $frmSearch->getFieldHtml('date_to'); ?>
                </div>
            <?php $buttonCol = 4;
            } ?>
            <div class="col-md-<?php echo $buttonCol; ?>">
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
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>