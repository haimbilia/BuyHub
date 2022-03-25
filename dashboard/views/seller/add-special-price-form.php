<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$selProdId = (!empty($data['splprice_selprod_id']) ? $data['splprice_selprod_id'] : 0);

$frm->setFormTagAttribute('onsubmit', 'updateSpecialPriceRow(this, ' . $selProdId . '); return(false);');
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "addNew()");

$frm->setFormTagAttribute('id', 'frmAddSpecialPrice-' . $selProdId);
$frm->setFormTagAttribute('name', 'frmAddSpecialPrice-' . $selProdId);

$startDate = $frm->getField('splprice_start_date');
$startDate->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Price_Start_Date', $siteLangId));
$startDate->setFieldTagAttribute('class', 'date_js field--calender');
$startDate->setFieldTagAttribute('disabled', 'disabled');

$endDate = $frm->getField('splprice_end_date');
$endDate->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Price_End_Date', $siteLangId));
$endDate->setFieldTagAttribute('class', 'date_js field--calender');
$endDate->setFieldTagAttribute('disabled', 'disabled');

$splPrice = $frm->getField('splprice_price');
$splPrice->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Special_Price', $siteLangId));
$splPrice->setFieldTagAttribute('disabled', 'disabled');
$splPrice->setFieldTagAttribute('class', 'js-special-price');

$startDate = $frm->getField('splprice_start_date');
$startDate->setFieldTagAttribute('id', 'splprice_start_date' . $selProdId);

$endDate = $frm->getField('splprice_end_date');
$endDate->setFieldTagAttribute('id', 'splprice_end_date' . $selProdId);

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
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>
<script>
    $(document).ready(function() {
        var ele = $(".selProd--js");
        ele.select2({
                closeOnSelect: true,
                dropdownParent: ele.closest('form'),
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
                            results: data.results,
                            pagination: {
                                more: params.page < data.pageCount,
                            },
                        };
                    },
                    cache: true,
                },
                minimumInputLength: 0,
               
            })
            .on("select2:selecting", function(e) {
                var parentForm = $(this).closest("form").attr("id");
                var item = e.params.args.data;
                $("#" + parentForm + " input[name='splprice_selprod_id']").val(item.id);
                //currObj.val((ui.item.label).replace(/<[^>]+>/g, ''));
                $("#" + parentForm + " input[name='splprice_start_date']").removeAttr(
                    "disabled"
                );
                $("#" + parentForm + " input[name='splprice_end_date']").removeAttr(
                    "disabled"
                );
                $("#" + parentForm + " input[name='splprice_price']").removeAttr(
                    "disabled"
                );
                var currentPrice = langLbl.currentPrice + ": " + item.price;
                $("#" + parentForm + " .js-prod-price").html(currentPrice);
                $("#" + parentForm + " .js-prod-price").attr("data-price", item.price);
            })
            .on("select2:unselecting", function(e) {
                var parentForm = $(this).closest("form").attr("id");
                $("#" + parentForm + " input[name='splprice_selprod_id']").val("");
                $("#" + parentForm + " input[name='splprice_start_date']")
                    .attr("disabled", "disabled")
                    .val("");
                $("#" + parentForm + " input[name='splprice_end_date']")
                    .attr("disabled", "disabled")
                    .val("");
                $("#" + parentForm + " input[name='splprice_price']")
                    .attr("disabled", "disabled")
                    .val("");
            }).on('select2:open', function(e) {     
                ele.data("select2").$dropdown.addClass("custom-select2 custom-select2-single");               
            })
            .data("select2").$container.addClass("custom-select2-width custom-select2 custom-select2-single");;
    });
</script>