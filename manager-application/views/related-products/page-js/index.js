(function () {
    var selected_products = [];
    bindProductNameSelect2 = function () {
        $("select[name='product_name']").select2({
            closeOnSelect: true,
            dir: layoutDirection,
            allowClear: true,
            placeholder: $("select[name='product_name']").attr('placeholder'),
            ajax: {
                url: fcom.makeUrl('RelatedProducts', 'autoCompleteProducts'),
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return {
                        keyword: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
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
            templateResult: function (result) {
                return result.name;
            },
            templateSelection: function (result) {
                return result.name || result.text;
            }
        }).on('select2:selecting', function (e) {
            var parentForm = $(this).closest('form').attr('id');
            $("#" + parentForm + " input[name='selprod_id']").val(e.params.args.data.id);

        }).on('select2:unselecting', function (e) {
            var parentForm = $(this).closest('form').attr('id');
            $("#" + parentForm + " input[name='selprod_id']").val('');
        });
        $("." + $.ykmodal.element).removeAttr('tabindex');
    };

    bindlRelatedProdSelect2 = function () {
        var element = $("select.relatedProductsJs");
        element.select2({
            closeOnSelect: true,
            dir: layoutDirection,
            allowClear: true,
            placeholder: element.attr('placeholder'),
            ajax: {
                url: fcom.makeUrl('SellerProducts', 'autoCompleteProducts'),
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    var parentForm = element.closest('form').attr('id');
                    return {
                        keyword: params.term, // search term
                        page: params.page,
                        fIsAjax: 1,
                        selProdId: $("#" + parentForm + " input[name='selprod_id']").val(),
                        selected_products: selected_products
                    };
                },
                beforeSend:
                    function (xhr, opts) {
                        var parentForm = element.closest('form').attr('id');
                        var selprod_id = $("#" + parentForm + " input[name='selprod_id']").val();
                        if (1 > selprod_id) {
                            xhr.abort();
                        }
                        $('input[name="selected_products[]"]').each(function () {
                            selected_products.push($(this).val());
                        });

                    },
                processResults: function (data, params) {
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
            templateResult: function (result) {
                return (typeof result.product_identifier === 'undefined' || typeof result.name === 'undefined') ? result.text : result.name + '[' + result.product_identifier + ']';
            },
            templateSelection: function (result) {
                return (typeof result.product_identifier === 'undefined' || typeof result.name === 'undefined') ? result.text : result.name + '[' + result.product_identifier + ']';
            }
        });
        setTimeout(() => {
            element.siblings('.select2').find('.select2-search__field').attr('name', element.attr('name') + '_search');
        }, 200);
    };
})();