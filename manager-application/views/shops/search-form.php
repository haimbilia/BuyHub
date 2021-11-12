<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

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
                    <div class="input-group-append">
                        <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <a class="btn btn-link collapsed" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Advanced
                    Search</a>
            </div> 
        </div>
        <div class="collapse" id="collapseExample">
            <div class="separator separator-dashed my-4"></div>
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"><?php echo Labels::getLabel('LBL_Featured', $siteLangId); ?></label>
                        <?php echo $frmSearch->getFieldHtml('shop_featured'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"><?php echo Labels::getLabel('LBL_Status', $siteLangId); ?></label>
                        <?php echo $frmSearch->getFieldHtml('shop_active'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">

                        <label class="label"><?php echo Labels::getLabel('LBL_Shop_Status_By_Seller', $siteLangId); ?></label>
                        <?php echo $frmSearch->getFieldHtml('shop_supplier_display_status'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"><?php echo Labels::getLabel('LBL_Date_From', $siteLangId); ?></label>
                        <?php echo $frmSearch->getFieldHtml('date_from'); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"><?php echo Labels::getLabel('LBL_Date_To', $siteLangId); ?></label>
                        <?php echo $frmSearch->getFieldHtml('date_to'); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"></label>
                        <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>