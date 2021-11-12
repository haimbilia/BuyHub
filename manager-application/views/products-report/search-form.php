<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH', $siteLangId));

$priceFrmFld = $frmSearch->getField('price_from');
$priceFrmFld->addFieldtagAttribute('class', 'form-control');
$priceFrmFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_PRICE_FROM', $siteLangId));

$priceToFld = $frmSearch->getField('price_to');
$priceToFld->addFieldtagAttribute('class', 'form-control');
$priceToFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_PRICE_TO', $siteLangId));

$shopFld = $frmSearch->getField('shop_id');
$shopFld->addFieldtagAttribute('id', 'shop_id');

$brandFld = $frmSearch->getField('brand_id');
$brandFld->addFieldtagAttribute('id', 'brand_id');

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
                <div class="input-group">
                    <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                    <div class="input-group-append">
                        <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a class="btn btn-link collapsed" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><?php echo Labels::getLabel('FRM_ADVANCE_SEARCH', $siteLangId); ?></a>
            </div>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-head.php'); ?>
</div>
<div class="advanced-search collapse" id="collapseExample">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="label"><?php echo Labels::getLabel('FRM_PRICE_FROM', $siteLangId); ?></label>
                <?php echo $frmSearch->getFieldHtml('price_from'); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="label"><?php echo Labels::getLabel('FRM_PRICE_TO', $siteLangId); ?></label>
                <?php echo $frmSearch->getFieldHtml('price_to'); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">

                <label class="label"><?php echo Labels::getLabel('FRM_CATEGORY', $siteLangId); ?></label>
                <?php echo $frmSearch->getFieldHtml('category_id'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="label"><?php echo Labels::getLabel('FRM_BRAND', $siteLangId); ?></label>
                <?php echo $frmSearch->getFieldHtml('brand_id'); ?>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="label"><?php echo Labels::getLabel('FRM_SHOP', $siteLangId); ?></label>
                <?php echo $frmSearch->getFieldHtml('shop_id'); ?>

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
</form>
<?php echo $frmSearch->getExternalJS(); ?>
<script type="text/javascript">
    $("document").ready(function() {
        if ($('#shop_id').length) {
            select2('shop_id', fcom.makeUrl('Shops', 'autoComplete'));
        }
        if ($('#brand_id').length) {
            select2('brand_id', fcom.makeUrl('Brands', 'autoComplete'));
        }
    });
</script>