<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "addNew()");
$frm->setFormTagAttribute('onsubmit', 'setUpSellerProductLinks(this); return(false);');

$prodFld = $frm->getField('selprod_id');
$prodFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_PRODUCT', $siteLangId));
$prodFld->setFieldTagAttribute('id', 'productNameJs');

$relProdFld = $frm->getField('products_upsell[]');
$relProdFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_PRODUCT', $siteLangId));
$relProdFld->setFieldTagAttribute('id', 'upsellProductsJs');
$relProdFld->setFieldTagAttribute('multiple', 'true');
$relProdFld->setFieldTagAttribute('disabled', 'disabled');

?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SETUP_BUY_TOGETHER_PRODUCTS', $siteLangId); ?>
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
            $('#upsellProductsJs').removeAttr('disabled');       
            fcom.ajax(fcom.makeUrl('Seller', 'getUpsellProductsList', [res.params.args.data.id]), '', function(t) {
                    var ans = $.parseJSON(t);
                    $('#upsellProductsJs option').remove();
                    for (var key in ans.upsellProducts) {
                        $('#upsellProductsJs').append(                 
                            '<option selected value=" '+ ans.upsellProducts[key]['selprod_id'] + '">'+ans.upsellProducts[key]['selprod_title'] + " ["+ ans.upsellProducts[key]['product_identifier'] + "]"+'<option>'
                        );                       
                    }
                    $('#upsellProductsJs').trigger('change');
                   
                });
        }, function (res) {
            $('#upsellProductsJs option').remove();
            $('#upsellProductsJs').trigger('change').attr('disabled', 'disabled');
        });
    }

    bindlUpsellProdSelect2 = function () {
        select2('upsellProductsJs', fcom.makeUrl('Seller', 'autoCompleteProducts'), function (obj) {
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
        bindlUpsellProdSelect2();
    });
</script>