<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-body">
    <div class="box__head">
        <h5>
            <?php echo $productDetails['product_name']; ?>
        </h5>
    </div>
    <?php
    $shippingFrm->setFormTagAttribute('class', 'form ');
    $shippingFrm->setFormTagAttribute('onsubmit', 'setupSellerShipping(this); return(false);');
    $countryFld = $shippingFrm->getField('shipping_country');

    $shippingFrm->developerTags['colClassPrefix'] = 'col-lg-';
    $shippingFrm->developerTags['fld_default_col'] = 6;
    $countryFld = $shippingFrm->getField('shipping_country');
    $countryFld->setWrapperAttribute('class', 'col-lg-6');

    $spProfileFld = $shippingFrm->getField('shipping_profile');
    $spProfileFld->developerTags['col'] = 6;

    $spPackageFld = $shippingFrm->getField('product_ship_package');
    if (null != $spPackageFld) {
        $spPackageFld->developerTags['col'] = 4;
    }

    $psFreeFld = $shippingFrm->getField('ps_free');
    if (null != $psFreeFld) {
        $psFreeFld->developerTags['col'] = 4;
    }

    $submitFld = $shippingFrm->getField('btn_submit');
    if (null != $submitFld) {
        $submitFld->developerTags['col'] = 2;
        $submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
    }

    $cancelFld = $shippingFrm->getField('btn_cancel');
    $cancelFld->setFieldTagAttribute('onclick', 'searchCatalogProducts(document.frmSearchCatalogProduct)');
    $cancelFld->developerTags['col'] = 2;
    $cancelFld->setFieldTagAttribute('class', 'btn btn-outline-gray btn-block');
    //$submitFld->attachField($cancelFld);

    echo $shippingFrm->getFormHTML();
    ?>
</div>
<script>
    var productOptions = [];
    var dv = $("#listing");
    $(document).ready(function() {
        /* Shipping Information */
        $('input[name=\'shipping_country\']').autocomplete({
            'classes': {
                "ui-autocomplete": "custom-ui-autocomplete"
            },
            'source': function(request, response) {
                $.ajax({
                    url: fcom.makeUrl('seller', 'countries_autocomplete'),
                    data: {
                        keyword: request['term'],
                        fIsAjax: 1
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        response($.map(json['results'], function(item) {
                            return {
                                label: item['text'],
                                value: item['text'],
                                id: item['id']
                            };
                        }));
                    },
                });
            },
            select: function(event, ui) {
                $('input[name=\'ps_from_country_id\']').val(ui.item.id);
            }
        });

        $('input[name=\'shipping_country\']').keyup(function() {
            $('input[name=\'product_shipping_country\']').val('');
        })


        var productId = <?php echo $product_id; ?>;

        //addShippingTab(productId);

    });
</script>