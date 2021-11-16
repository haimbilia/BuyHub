<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

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
<div class="card">
    <div class="card-body">
        <div class="row">  
            <div class="col-md-6"> 
                <?php echo $frmSearch->getFieldHtml('keyword'); ?>  
            </div>  
            <div class="col-md-6">
                <a class="btn advanced-trigger ml-2 collapsed" data-toggle="collapse" href="#collapseKeyword" aria-expanded="true" aria-controls="collapseKeyword">
                    <svg class="svg" width="22" height="22">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#double-arrow">
                    </use>
                    </svg>
                </a>
                <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
            </div>  
        </div>
    </div>
    <div class="advanced-search collapse" id="collapseKeyword">
        <div class="row"> 
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label"><?php echo Labels::getLabel('LBL_Status', $siteLangId); ?></label>
                    <?php echo $frmSearch->getFieldHtml('status'); ?>
                </div>
            </div> 
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label"><?php echo Labels::getLabel('LBL_Date_From', $siteLangId); ?></label>
                    <?php echo $frmSearch->getFieldHtml('date_from'); ?>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label"><?php echo Labels::getLabel('LBL_Date_To', $siteLangId); ?></label>
                    <?php echo $frmSearch->getFieldHtml('date_to'); ?>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label"></label>
                    <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
                </div>
            </div>
        </div>
        <div class="separator separator-dashed my-2"></div>
    </div>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>