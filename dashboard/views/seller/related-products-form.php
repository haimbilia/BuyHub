<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "addNew()");
$frm->setFormTagAttribute('onsubmit', 'setUpSellerProductLinks(this); return(false);');

$prodFld = $frm->getField('product_name');
$prodFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product', $siteLangId));

$relProdFld = $frm->getField('products_related');
$relProdFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Add_Related_Products', $siteLangId));
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
    $(document).ready(function() {
        setTimeout(() => {
            $("select[name='product_name']").select2({
                dropdownParent: $("select[name='product_name']").closest('.modal'),
                closeOnSelect: true,
                dir: langLbl.layoutDirection,
                allowClear: true,
                placeholder: $("select[name='product_name']").attr('placeholder'),
                ajax: {
                    url: fcom.makeUrl('Seller', 'autoCompleteProducts'),
                    dataType: 'json',
                    delay: 250,
                    method: 'post',
                    data: function(params) {
                        return {
                            keyword: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.products,
                            pagination: {
                                more: params.page < data.pageCount
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                templateResult: function(result) {
                    return result.name;
                },
                templateSelection: function(result) {
                    return result.name || result.text;
                }
            }).on('select2:selecting', function(e) {
                var parentForm = $(this).closest('form').attr('id');
                var item = e.params.args.data;
                $("#" + parentForm + " input[name='selprod_id']").val(item.id);

                fcom.ajax(fcom.makeUrl('Seller', 'getRelatedProductsList', [item.id]), '', function(t) {
                    var ans = $.parseJSON(t);
                    $('#related-products').empty();
                    for (var key in ans.relatedProducts) {
                        $('#related-products').append(
                            "<li id=productRelated" + ans.relatedProducts[key]['selprod_id'] + "><span>" + ans.relatedProducts[key]['selprod_title'] + " [" + ans.relatedProducts[key]['product_identifier'] + "]<i class=\"remove_related remove_param fas fa-times\"></i><input type=\"hidden\" name=\"selected_products[]\" value=" + ans.relatedProducts[key]['selprod_id'] + " /></span></li>"
                        );
                    }
                });

            }).on('select2:unselecting', function(e) {
                var parentForm = $(this).closest('form').attr('id');
                $("#" + parentForm + " input[name='selprod_id']").val('');
            });

            $("select[name='products_related']").select2({
                dropdownParent: $("select[name='products_related']").closest('.modal'),
                closeOnSelect: true,
                dir: langLbl.layoutDirection,
                allowClear: true,
                placeholder: $("select[name='products_related']").attr('placeholder'),
                ajax: {
                    url: fcom.makeUrl('seller', 'autoCompleteProducts'),
                    dataType: 'json',
                    delay: 250,
                    method: 'post',
                    data: function(params) {
                        var parentForm = $("select[name='products_related']").closest('form').attr('id');
                        return {
                            keyword: params.term, // search term
                            page: params.page,
                            fIsAjax: 1,
                            selProdId: $("#" + parentForm + " input[name='selprod_id']").val(),
                            selected_products: selected_products
                        };
                    },
                    beforeSend: function(xhr, opts) {
                        var parentForm = $("select[name='products_related']").closest('form').attr('id');
                        var selprod_id = $("#" + parentForm + " input[name='selprod_id']").val();
                        if (1 > selprod_id) {
                            xhr.abort();
                        }
                        $('input[name="selected_products[]"]').each(function() {
                            selected_products.push($(this).val());
                        });

                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.products,
                            pagination: {
                                more: params.page < data.pageCount
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                templateResult: function(result) {
                    return (typeof result.product_identifier === 'undefined' || typeof result.name === 'undefined') ? result.text : result.name + '[' + result.product_identifier + ']';
                },
                templateSelection: function(result) {
                    return (typeof result.product_identifier === 'undefined' || typeof result.name === 'undefined') ? result.text : result.name + '[' + result.product_identifier + ']';
                }
            }).on('select2:selecting', function(e) {
                var parentForm = $(this).closest('form').attr('id');
                var item = e.params.args.data;
                $('input[name=\'products_related\']').val('');
                $('#productRelated' + item.id).remove();
                $('#related-products').append('<li id="productRelated' + item.id + '"><span> ' + item.name + '[' + item.product_identifier + ']' + '<i class="remove_related remove_param fas fa-times"></i><input type="hidden" name="selected_products[]" value="' +
                    item.id + '" /></span></li>');
                setTimeout(function() {
                    $("select[name='products_related']").val('').trigger('change');
                }, 200);

            });
        }, 500);
    });
</script>