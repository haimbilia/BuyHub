<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$selProdId = (!empty($data['voldiscount_selprod_id']) ? $data['voldiscount_selprod_id'] : 0);

$frm->setFormTagAttribute('id', 'frmAddVolumeDiscount-' . $selProdId);
$frm->setFormTagAttribute('name', 'frmAddVolumeDiscount-' . $selProdId);
$frm->setFormTagAttribute('onsubmit', 'updateVolumeDiscountRow(this, ' . $selProdId . '); return(false);');
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "addNew()");

$minQty = $frm->getField('voldiscount_min_qty');
$minQty->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Add_Minimum_Quantity', $siteLangId));
$minQty->setFieldTagAttribute('disabled', 'disabled');
$minQty->setFieldTagAttribute('class', 'js-voldiscount_min_qty');

$disPerc = $frm->getField('voldiscount_percentage');
$disPerc->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Add_Discount_Percentage', $siteLangId));
$disPerc->setFieldTagAttribute('disabled', 'disabled');

if (!empty($data) && 0 < count($data)) {
    $data['product_name'] = isset($data['product_name']) ? html_entity_decode($data['product_name'], ENT_QUOTES, 'UTF-8') : '';
    $prodName->setFieldTagAttribute('readonly', 'readonly');
    $frm->fill($data);
}
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $formTitle; ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs sectionbody space">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>
<script>
    $(document).ready(function() {
        var ele = $(".selProd--js");
        ele.select2({
                closeOnSelect: true,
                dropdownParent: ele.closest('.modal'),
                dir: langLbl.layoutDirection,
                allowClear: true,
                placeholder: ele.attr("placeholder"),
                ajax: {
                    url: fcom.makeUrl("Seller", "autoCompleteProducts"),
                    dataType: "json",
                    delay: 250,
                    method: "post",
                    data: function(params) {
                        return {
                            keyword: params.term, // search term
                            page: params.page,
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.products,
                            pagination: {
                                more: params.page < data.pageCount,
                            },
                        };
                    },
                    cache: true,
                },
                minimumInputLength: 0,
                templateResult: function(result) {
                    return result.name;
                },
                templateSelection: function(result) {
                    return result.name || result.text;
                },
            })
            .on("select2:selecting", function(e) {
                var parentForm = $(this).closest("form").attr("id");
                var item = e.params.args.data;
                $("#" + parentForm + " input[name='voldiscount_selprod_id']").val(
                    item.id
                );
                $("input[name='voldiscount_min_qty']").removeAttr("disabled");
                $("input[name='voldiscount_percentage']").removeAttr("disabled");
            })
            .on("select2:unselecting", function(e) {
                var parentForm = $(this).closest("form").attr("id");
                $("#" + parentForm + " input[name='voldiscount_selprod_id']").val("");
                $("input[name='voldiscount_min_qty']")
                    .attr("disabled", "disabled")
                    .val("");
                $("input[name='voldiscount_percentage']")
                    .attr("disabled", "disabled")
                    .val("");
            });

        var select2Selector = ele.data("select2");
        select2Selector.$container.addClass("custom-select2");
        if (ele.attr('multiple') == undefined) {
            $('input.select2-search__field').closest('.select2-container').addClass("custom-select2-single");
        } else {
            select2Selector.$container.addClass("custom-select2-multiple");
        }
    });
</script>