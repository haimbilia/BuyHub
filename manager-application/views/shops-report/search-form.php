<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH', $siteLangId));

$shopFld = $frmSearch->getField('shop_id');
$shopFld->addFieldtagAttribute('id', 'shop_id');

$shopUserFld = $frmSearch->getField('shop_user_id');
$shopUserFld->addFieldtagAttribute('id', 'shop_user_id');

$dateFrmFld = $frmSearch->getField('date_from');
$dateFrmFld->addFieldtagAttribute('class', 'form-control');
$dateFrmFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_FROM_DATE', $siteLangId));

$dateToFld = $frmSearch->getField('date_to');
$dateToFld->addFieldtagAttribute('class', 'form-control');
$dateToFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_TO_DATE', $siteLangId));

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
                        <label class="label"><?php echo Labels::getLabel('FRM_SHOP', $siteLangId); ?></label>
                        <?php echo $frmSearch->getFieldHtml('shop_id'); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"><?php echo Labels::getLabel('FRM_FROM_DATE', $siteLangId); ?></label>
                        <?php echo $frmSearch->getFieldHtml('date_from'); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"><?php echo Labels::getLabel('FRM_FROM_TO', $siteLangId); ?></label>
                        <?php echo $frmSearch->getFieldHtml('date_to'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"><?php echo Labels::getLabel('FRM_SHOP_OWNER', $siteLangId); ?></label>
                        <?php echo $frmSearch->getFieldHtml('shop_user_id'); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label"></label>
                        <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>

                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php echo $frmSearch->getExternalJS(); ?>
<script type="text/javascript">
    $("document").ready(function() {
        if ($('#shop_id').length) {
            select2('shop_id', fcom.makeUrl('Shops', 'autoComplete'));
        }
        if ($('#shop_user_id').length) {
            select2('shop_user_id', fcom.makeUrl('Users', 'autoComplete'));
        }
    });
</script>