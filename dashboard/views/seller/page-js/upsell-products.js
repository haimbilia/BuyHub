var selected_products = [];
$(document).ready(function () {
    searchRecords(document.frmSearch);
    $('#upsell-products').delegate('.remove_upsell', 'click', function () {
        $(this).parent().remove();
    }); 
});
$(document).on('mouseover', "ul.list-tags li span i", function () {
    $(this).parents('li').addClass("hover");
});
$(document).on('mouseout', "ul.list-tags li span i", function () {
    $(this).parents('li').removeClass("hover");
});

(function() {
	var dv = '#listing';
	searchRecords = function(frm){

		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}
		/*]*/
		var dv = $('#listing');
		$(dv).html( fcom.getLoader() );

		fcom.ajax(fcom.makeUrl('Seller','searchUpsellProducts'),data,function(res){           
			$("#listing").html(res);
            fcom.removeLoader();
		});
	};

    clearSearch = function(selProd_id){
        if (0 < selProd_id) {
            location.href = fcom.makeUrl('Seller', 'upsellProducts');
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
        var frm = document.frmUpsellSellerProduct;
        searchRecords(frm);
    }

    deleteSelprodUpsellProduct = function (selProdId, relProdId) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'deleteSelprodUpsellProduct', [selProdId, relProdId]), '', function (t) {
            searchRecords(document.frmUpsellSellerProduct);
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
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setupUpsellProduct'), data, function (t) {
            document.frmUpsellSellerProduct.reset();
            $("input[name='selprod_id']").val('');
            $('#upsell-products').empty();
            $(frm).find("select[name='product_name']").find('option').remove();
            $(frm).find("select[name='product_name']").trigger('change.select2');
            searchRecords(document.frmUpsellSellerProduct);
            $.ykmodal.close();

        });
    };

    addNew = function () {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', "upsellProductsForm"), "", function (t) {
            $.ykmodal(t.html);
            fcom.removeLoader();
        }, { fOutMode: 'json' });
    };
})();

$(document).on('click', ".js-product-edit", function () {
    var selProdId = $(this).attr('row-id');
    var prodHtml = $(this).find('.prodNameJs:last').text();
    var prodName = jQuery.trim(prodHtml) + " " + jQuery.trim($(this).find('.prodOptionsJs').text());
    fcom.ajax(fcom.makeUrl('Seller', 'getUpsellProductsList', [selProdId]), '', function (t) {
        var ans = $.parseJSON(t);
        $("input[name='selprod_id']").val(selProdId);
        $("select[name='product_name']").find('option').remove();
        $("select[name='product_name']").append('<option value="-1">' + prodName + '</option>').val(-1).trigger('change.select2');
        $('#upsell-products').empty();
        for (var key in ans.upsellProducts) {
            $("#upsell-products").append(
                "<li id=productUpsell" + ans.upsellProducts[key]['selprod_id'] + "><span>" + ans.upsellProducts[key]['selprod_title'] + " [" + ans.upsellProducts[key]['product_identifier'] + "]<i class=\"remove_upsell remove_param fas fa-times\"></i><input type=\"hidden\" name=\"selected_products[]\" value=" + ans.upsellProducts[key]['selprod_id'] + " /></span></li>"
            );
        }
    });
});
