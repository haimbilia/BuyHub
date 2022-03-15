var selected_products = [];
$(document).ready(function () {
    searchRecords(document.frmSearch);
    $('#related-products').delegate('.remove_related', 'click', function () {
        $(this).parents('li').remove();
    });
});
$(document).on('mouseover', "ul.list-tags li span i", function () {
    $(this).parents('li').addClass("hover");
});
$(document).on('mouseout', "ul.list-tags li span i", function () {
    $(this).parents('li').removeClass("hover");
});

(function () {
    var dv = '#listing';
    searchRecords = function (frm) {

        /*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
        var data = '';
        if (frm) {
            data = fcom.frmData(frm);
        }
        /*]*/
        var dv = $('#listing');
        $(dv).prepend(fcom.getLoader());

        fcom.ajax(fcom.makeUrl('Seller', 'searchRelatedProducts'), data, function (res) {
            $("#listing").html(res);
            fcom.removeLoader();
        });
    };
    clearSearch = function (selProd_id) {
        if (0 < selProd_id) {
            location.href = fcom.makeUrl('Seller', 'relatedProducts');
        } else {
            document.frmSearch.reset();
            searchRecords(document.frmSearch);
        }
    };

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSearchVolumeDiscountPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    }

    reloadList = function () {
        var frm = document.frmRelatedSellerProduct;
        searchRecords(frm);
    }

    deleteSelprodRelatedProduct = function (selProdId, relProdId) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'deleteSelprodRelatedProduct', [selProdId, relProdId]), '', function (t) {
            var frm = document.frmSearchVolumeDiscountPaging;
            $(frm.total_record_count).val('');
            searchRecords(document.frmSearchVolumeDiscountPaging);
        });
    }

    showElement = function (currObj, value) {
        var sibling = currObj.siblings('div');
        if ('' != value) {
            sibling.text(value);
        }
        sibling.fadeIn();
        currObj.addClass('hidden');
    };

    setUpSellerProductLinks = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setupRelatedProduct'), data, function (t) {
            document.frmRelatedSellerProduct.reset();
            $("input[name='selprod_id']").val('');
            $('#related-products').empty();
            $(frm).find("select[name='product_name']").trigger('change.select2');
            searchRecords(document.frmRelatedSellerProduct);
            $.ykmodal.close();
        });
    };

    addNew = function () {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', "relatedProductsForm"), "", function (t) {
            $.ykmodal(t.html);
            fcom.removeLoader();
        }, { fOutMode: 'json' });
    };
})();

$(document).on('click', ".js-product-edit", function () {
    var selProdId = $(this).attr('row-id');
    var prodHtml = $(this).find('.prodNameJs:last').text();
    var prodName = jQuery.trim(prodHtml) + " " + jQuery.trim($(this).find('.prodOptionsJs').text());

    fcom.ajax(fcom.makeUrl('Seller', 'getRelatedProductsList', [selProdId]), '', function (t) {

        var ans = $.parseJSON(t);
        $("input[name='selprod_id']").val(selProdId);
        /*$("input[name='product_name']").val(prodName[0]); */
        var newOption = new Option(prodName, selProdId, true, true);
        $("select[name='product_name']").append(newOption).trigger('change');
        $('#related-products').empty();
        for (var key in ans.relatedProducts) {
            $('#related-products').append(
                "<li id=productRelated" + ans.relatedProducts[key]['selprod_id'] + "><span>" + ans.relatedProducts[key]['selprod_title'] + " [" + ans.relatedProducts[key]['product_identifier'] + "]<i class=\"remove_related remove_param fas fa-times\"></i><input type=\"hidden\" name=\"selected_products[]\" value=" + ans.relatedProducts[key]['selprod_id'] + " /></span></li>"
            );
        }
    });
});
