<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "addNew()");
$frm->setFormTagAttribute('onsubmit', 'setUpSellerProductLinks(this); return(false);');

$prodFld = $frm->getField('selprod_id');
$prodFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_PRODUCT', $siteLangId));
$prodFld->setFieldTagAttribute('id', 'productNameJs');

$relProdFld = $frm->getField('products_related[]');
$relProdFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_PRODUCT', $siteLangId));
$relProdFld->setFieldTagAttribute('id', 'relatedProductsJs');
$relProdFld->setFieldTagAttribute('multiple', 'true');
$relProdFld->setFieldTagAttribute('disabled', 'disabled');
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SETUP_RELATED_PRODUCTS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>
<script>

    bindProductNameSelect2 = function () {
        select2("productNameJs", fcom.makeUrl('Seller', 'autoCompleteProducts'), {}, function (res) {           
            $('#relatedProductsJs').removeAttr('disabled');       
            fcom.ajax(fcom.makeUrl('Seller', 'getRelatedProductsList', [res.params.args.data.id]), '', function(t) {
                    var ans = $.parseJSON(t);
                    $('#relatedProductsJs option').remove();
                    for (var key in ans.relatedProducts) {
                        $('#relatedProductsJs').append(                 
                            '<option selected value=" '+ ans.relatedProducts[key]['selprod_id'] + '">'+ans.relatedProducts[key]['selprod_title'] + " ["+ ans.relatedProducts[key]['product_identifier'] + "]"+'<option>'
                        );                        
                    }
                    $('#relatedProductsJs').trigger('change');
                });
        }, function (res) {
            $('#relatedProductsJs option').remove();
            $('#relatedProductsJs').trigger('change').attr('disabled', 'disabled');
        });
    }

    bindlRelatedProdSelect2 = function () {
        select2('relatedProductsJs', fcom.makeUrl('Seller', 'autoCompleteProducts'), function (obj) {
            let excludeRecords  =  obj.val();
            if(excludeRecords.length){
                excludeRecords.push($('#productNameJs').val());
            }else{
                excludeRecords = [$('#productNameJs').val()];
            }
            return {               
                'excludeRecords' : excludeRecords,
            };
        });
    }

    $(document).ready(function() {
        bindProductNameSelect2();
        bindlRelatedProdSelect2();
    });
</script>