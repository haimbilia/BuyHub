<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

$userFld = $frmSearch->getField('addr_record_id');
$userFld->addFieldtagAttribute('class', 'form-control');
$userFld->addFieldtagAttribute('id', 'searchFrmUserIdJs');
$userFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_USER_NAME', $siteLangId));

$fld = $frmSearch->getField('addr_title');
$fld->addFieldtagAttribute('class', 'form-control');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_Address_Label', $siteLangId));

echo $frmSearch->getFormTag();
HtmlHelper::renderHiddenFields($frmSearch);
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <?php echo $frmSearch->getFieldHtml('addr_record_id'); ?>
            </div>
            <?php if(null != $fld){ ?>
                <div class="col-md-4">
                    <?php echo $frmSearch->getFieldHtml('addr_title'); ?>
                </div>
            <?php } ?>
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