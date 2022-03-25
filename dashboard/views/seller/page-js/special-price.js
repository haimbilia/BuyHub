$(document).ready(function () {
    searchRecords(document.frmRecordSearch);
});

$(document).on('click', '.dateJs', function () {
    var ele = $(this);
    ele.hide().bind('active');
    var inputFld = ele.siblings('input[type="text"]');
    inputFld.removeClass('d-none').focus().addClass('d-none');
    if (inputFld.val() != inputFld.attr('data-value')) {
        inputFld.val(inputFld.attr('data-value'));
    }
});

$(document).on('blur', ".inputDateJs", function (e) {
    e.stopPropagation();
    $(this).addClass('d-none').siblings('.dateJs').show();
});

$(document).on('change', ".inputDateJs", function () {
    updateValues($(this));
});

(function () {
    var dv = "#listing";
    searchRecords = function (frm) {
        /*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
        var data = "";
        if (frm) {
            data = fcom.frmData(frm);
        }
        /*]*/
        var dv = $("#listing");
        $(dv).prepend(fcom.getLoader());

        fcom.ajax(
            fcom.makeUrl("Seller", "searchSpecialPriceProducts"),
            data,
            function (res) {
                fcom.removeLoader();
                $("#listing").html(res);
                $(".dateJs").datepicker("option", { minDate: new Date() });
            }
        );
    };
    clearSearch = function (selProd_id) {
        if (0 < selProd_id) {
            location.href = fcom.makeUrl("Seller", "specialPrice");
        } else {
            document.frmRecordSearch.reset();
            searchRecords(document.frmRecordSearch);
        }
    };
    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSearchSpecialPricePaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    reloadList = function () {
        searchRecords(document.frmRecordSearch);
    };

    deleteSellerProductSpecialPrice = function (splPrice_id) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(
            fcom.makeUrl("Seller", "deleteSellerProductSpecialPrice"),
            "splprice_id=" + splPrice_id,
            function (t) {
                $("form#frmSplPriceListing table tr#row-" + splPrice_id).remove();
                if (1 > $("form#frmSplPriceListing table tbody tr").length) {
                    searchRecords(document.frmRecordSearch);
                }
            }
        );
    };

    deleteSelected = function () {
        if (typeof $(".selectItem--js:checked").val() === "undefined") {
            fcom.displayErrorMessage(langLbl.atleastOneRecord);
            return false;
        }
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        var data = fcom.frmData(document.getElementById("frmSplPriceListing"));
        fcom.ajax(
            fcom.makeUrl("Seller", "deleteSpecialPriceRows"),
            data,
            function (t) {
                var ans = $.parseJSON(t);
                if (ans.status == 1) {
                    fcom.displaySuccessMessage(ans.msg);
                    $(".formActionBtn-js").addClass("disabled");
                } else {
                    fcom.displayErrorMessage(ans.msg);
                }
                searchRecords(document.frmRecordSearch);
            }
        );
    };

    updateSpecialPriceRow = function (frm, selProd_id) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(
            fcom.makeUrl("Seller", "updateSpecialPriceRow"),
            data,
            function (t) {
                if (t.status == true) {
                    if (0 < selProd_id) {
                        if (1 > selProd_id) {
                            frm.elements["splprice_selprod_id"].value = "";
                        }
                        frm.reset();
                    }
                    document.getElementById("frmSplPriceListing").reset();
                    $(frm).find("select[name='product_name']").trigger("change.select2");
                    $("table.splPriceList-js tbody").prepend(t.data);
                    $(".dateJs").datepicker("option", { minDate: new Date() });
                    if (0 < $(".noResult--js").length) {
                        $(".noResult--js").remove();
                    }
                    $(".js-discount-percentage").html("");
                    $(".js-prod-price").html("");
                    searchRecords(document.frmRecordSearch);
                    closeForm();
                }
            }
        );
        return false;
    };

    showOrignal = function (ele) {
        var obj = $(ele);
        var value = obj.attr('data-value');
        obj.text(value);
    }

    updateValues = function (ele) {
        var obj = $(ele);
        var attribute = obj.attr('name');
        var percentDiv = obj.siblings('div.percentValJs');
        var value = ('splprice_price' == attribute) ? ele.textContent : obj.val();
        var price = obj.attr('data-price');
        var oldValue = obj.attr('data-value');
        var formattedValue = obj.attr('data-formated-value');
        var id = obj.attr('data-id');
        var selProdId = obj.attr('data-selprod-id');

        var discountPercentage = '';
        if ('splprice_price' == attribute) {
            value = parseFloat(value);
            if (Number.isNaN(value)) {
                obj.text(formattedValue);
                fcom.displayErrorMessage(langLbl.notANumber);
                return;
            }
            oldValue = parseFloat(oldValue);
            var discountPrice = price - value;
            if (0 < discountPrice) {
                var discountPercentage = ((discountPrice / price) * 100).toFixed(2);
                discountPercentage = discountPercentage + "%  " + langLbl.off;
            }
        }


        if ('' != value && value != oldValue) {
            var data = 'attribute=' + attribute + "&splprice_id=" + id + "&selProdId=" + selProdId + "&value=" + value;
            fcom.displayProcessing();
            fcom.updateWithAjax(fcom.makeUrl("Seller", "updateSpecialPriceColValue"), data, function (ans) { 
                if (ans.status != 1) {             
                    value = oldValue;
                    updatedValue = formattedValue;
                } else {
                    updatedValue = ans.data.value;
                    percentDiv.text(discountPercentage);
                }
                obj.attr('data-value', value);
                obj.attr('data-formated-value', updatedValue);
                if ('splprice_price' == attribute) {
                    obj.text(updatedValue);
                } else {
                    obj.addClass('d-none').siblings('.dateJs').text(updatedValue).show();
                }
            });
        } else if ('splprice_price' == attribute) {
            obj.text(formattedValue);
        }
    };

    addNew = function () {
        fcom.ajax(fcom.makeUrl('Seller', "addSpecialPriceForm"), "", function (t) {
            $.ykmodal(t.html);
            fcom.removeLoader();
        }, { fOutMode: 'json' });
    };
})();
