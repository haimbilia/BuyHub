<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$frmSearch->setFormTagAttribute('name', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmRecordSearch');
$frmSearch->setFormTagAttribute('class', 'form form-search');

$keyWordFld = $frmSearch->getField('keyword');
$keyWordFld->addFieldtagAttribute('class', 'form-control');
$keyWordFld->addFieldtagAttribute('autocomplete', 'off');
$keyWordFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_CUSTOM_TITLE_OR_BRAND_NAME', $siteLangId));

$shopFld = $frmSearch->getField('shop_id');
$shopFld->addFieldtagAttribute('id', 'shop_id');

$brandFld = $frmSearch->getField('brand_id');
$brandFld->addFieldtagAttribute('id', 'brand_id');
$brandFld->addFieldtagAttribute('class', 'brand_id');

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
            <div class="col-md-12">
                <div class="input-group">
                    <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                    <a class="btn advanced-trigger ms-2 collapsed" data-bs-toggle="collapse" href="#collapseKeyword" aria-expanded="true" aria-controls="collapseKeyword">
                        <svg class="svg" width="22" height="22">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#double-arrow">
                            </use>
                        </svg>
                    </a>
                    <div class="input-group-append">
                        <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-head.php'); ?>
</div>
<div class="advanced-search collapse advancedSearchJs" id="collapseKeyword">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">

                <label class="label"><?php echo Labels::getLabel('FRM_CATEGORY', $siteLangId); ?></label>
                <?php echo $frmSearch->getFieldHtml('category_id'); ?>
            </div>
        </div>
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
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="label"></label>
                <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
            </div>
        </div>
    </div>
    <div class="separator separator-dashed my-2"></div>
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