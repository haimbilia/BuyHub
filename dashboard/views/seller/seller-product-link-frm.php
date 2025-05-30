<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="tabs ">
    <?php require_once('sellerCatalogProductTop.php');?>
</div>
<div class="card">
    <div class="card-body ">
    <?php
        $sellerproductLinkFrm->setFormTagAttribute('onsubmit', 'setUpSellerProductLinks(this); return(false);');
        $sellerproductLinkFrm->setFormTagAttribute('class', 'form form--horizontal');
        $sellerproductLinkFrm->developerTags['colClassPrefix'] = 'col-lg-6 col-md-';
        $sellerproductLinkFrm->developerTags['fld_default_col'] = 6;
        echo $sellerproductLinkFrm->getFormHtml(); ?>
    </div>
</div>
<script type="text/javascript">
    $("document").ready(function() {
        $('input[name=\'products_buy_together\']').autocomplete({
            'classes': {
                "ui-autocomplete": "custom-ui-autocomplete"
            },
            'source': function(request, response) {
                /* fcom.ajax(fcom.makeUrl('brands', 'autoComplete'), {keyword:encodeURIComponent(request)}, function(json) {
                response($.map(json, function(item) {
                return { label: item['name'], value: item['id'] };
                }));
                }); */
                $.ajax({
                    url: fcom.makeUrl('seller', 'autoCompleteProducts'),
                    data: {
                        keyword: request['term'],
                        fIsAjax: 1,
                        selprod_id: selprod_id
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        response($.map(json, function(item) {
                            return {
                            label: item['name'] + '[' + item['product_identifier'] + ']' ,
                            value: item['name'] + '[' + item['product_identifier'] + ']',
                            id: item['id']
                            };
                        }));
                    },
                });
            },
            select: function (event, ui) {
                $('input[name=\'products_buy_together\']').val('');
                $('#productBuyTogether' + ui.item.id).remove();
                $('#buy-together-products').append('<li id="productBuyTogether' + ui.item.id + '"><i class="remove_buyTogether remove_param fa fa-remove"></i> ' + ui.item.label + '<input type="hidden" name="product_upsell[]" value="' + ui.item.id + '" /></li>');
                return false;
            }
        });
        $('#buy-together-products').delegate('.remove_buyTogether', 'click', function() {

            $(this).parent().remove();
        });
        $('input[name=\'products_related\']').autocomplete({
            'classes': {
                "ui-autocomplete": "custom-ui-autocomplete"
            },
            'source': function(request, response) {
                /* fcom.ajax(fcom.makeUrl('brands', 'autoComplete'), {keyword:encodeURIComponent(request)}, function(json) {
                response($.map(json, function(item) {
                return { label: item['name'], value: item['id'] };
                }));
                }); */
                $.ajax({
                    url: fcom.makeUrl('seller', 'autoCompleteProducts'),
                    data: {
                        keyword: request['term'],
                        fIsAjax: 1,
                        selprod_id: selprod_id
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        response($.map(json['results'], function(item) {
                            return {
                                label: item['name'] + '[' + item['product_identifier'] + ']',
                                value: item['name'] + '[' + item['product_identifier'] + ']',
                                id: item['id']
                            };
                        }));
                    },
                });
            },
            select: function (event, ui) {
                $('input[name=\'products_related\']').val('');
                $('#productRelated' + ui.item.id).remove();
                $('#related-products').append('<li id="productRelated' + ui.item.id + '"><i class="remove_related remove_param fa fa-remove"></i> ' + ui.item.label + '<input type="hidden" name="product_related[]" value="' + ui.item.id + '" /></li>');
            }
        });
        $('#related-products').delegate('.remove_related', 'click', function() {

            $(this).parent().remove();
        });
        <?php foreach ($upsellProducts as $key => $val) { ?>
        $('#buy-together-products').append(
            "<li id=\"productBuyTogether<?php echo $val['selprod_id'];?>\"><i class=\"remove_buyTogether remove_param fa fa-remove\"></i><?php echo $val['product_name'];?>[<?php echo $val['product_identifier'];?>]<input type=\"hidden\" name=\"product_upsell[]\" value=\"<?php echo $val['selprod_id'];?>\" /></li>"
            );
        <?php }
        foreach ($relatedProducts as $key => $val) { ?>
        $('#related-products').append(
            "<li id=\"productRelated<?php echo $val['selprod_id'];?>\"><i class=\"remove_related remove_param fa fa-remove\"></i> <?php echo $val['product_name'];?>[<?php echo $val['product_identifier'];?>]<input type=\"hidden\" name=\"product_related[]\" value=\"<?php echo $val['selprod_id'];?>\" /></li>"
            );
        <?php } ?>
    });
</script>
