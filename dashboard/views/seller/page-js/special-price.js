$(document).ready(function () {
    searchRecords(document.frmRecordSearch);
    $(".date_js").datepicker("option", { minDate: new Date() });
});

$(document).on("keyup", ".js-special-price", function () {
    var selProdPrice = $(".js-prod-price").attr("data-price");
    var specialPrice = $(".js-special-price").val();
    if (specialPrice != "") {
        var discountAmt = selProdPrice - specialPrice;
        var percentage = (discountAmt / selProdPrice) * 100;
        if (percentage > 0) {
            percentage = Number(Number(percentage).toFixed(2));
            var discountPercentage =
                langLbl.discountPercentage + ": " + percentage + "%";
            $(".js-discount-percentage").html(discountPercentage);
        } else {
            $(".js-discount-percentage").html("");
        }
    } else {
        $(".js-discount-percentage").html("");
    }
});

$(document).on(
    "click",
    "table.splPriceList-js tr td .js--editCol",
    function () {
        $(this).hide();
        var input = $(this).siblings('input[type="text"]');
        var value = input.attr("value");
        input.removeClass("hidden");
        input.val("").focus().val(value);
    }
);

$(document).on("blur", ".js--splPriceCol.date_js", function () {
    var currObj = $(this);
    var oldValue = currObj.attr("data-oldval");
    showElement(currObj, oldValue);
});
$(document).on("change", ".js--splPriceCol.date_js", function () {
    updateValues($(this));
});

$(document).on("blur", ".js--splPriceCol:not(.date_js)", function () {
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
                $(".date_js").datepicker("option", { minDate: new Date() });
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
                    $(".date_js").datepicker("option", { minDate: new Date() });
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

    updateValues = function (currObj) {
        var value = currObj.val();
        var oldValue = currObj.attr("data-oldval");
        var displayOldValue = currObj.attr("data-displayoldval");
        displayOldValue = typeof displayOldValue == "undefined" ? oldValue : displayOldValue;
        var attribute = currObj.attr("name");
        var price = currObj.attr('data-price');
        var percentDiv = currObj.siblings('div.percentValJs');
        var id = currObj.data("id");
        var selProdId = currObj.data("selprodid");
        if ("splprice_price" == attribute) {
            value = parseFloat(value);
            if (Number.isNaN(value)) {
                currObj.attr("value", oldValue).val(oldValue);
                fcom.displayErrorMessage(langLbl.notANumber);
                return;
            }
            oldValue = parseFloat(oldValue);

            var discountPrice = price - value;
            if (0 < discountPrice) {
                var discountPercentage = ((discountPrice / price) * 100).toFixed(2);
                discountPercentage = discountPercentage + "% " + langLbl.off;
            }
        }
        if ("" != value && value != oldValue) {
            var data = "attribute=" + attribute + "&splprice_id=" + id + "&selProdId=" + selProdId + "&value=" + value;
            fcom.ajax(
                fcom.makeUrl("Seller", "updateSpecialPriceColValue"),
                data,
                function (t) {
                    var ans = $.parseJSON(t);
                    if (ans.status != 1) {
                        fcom.displayErrorMessage(ans.msg);
                        value = oldValue;
                        updatedValue = displayOldValue;
                    } else {
                        updatedValue = ans.data.value;
                        currObj.attr("data-oldval", value);
                        percentDiv.text(discountPercentage);
                    }
                    currObj.attr("value", value);
                    showElement(currObj, updatedValue);
                }
            );
        } else {
            showElement(currObj);
            currObj.val(oldValue);
        }
    };
    showElement = function (currObj, value) {
        var sibling = currObj.siblings("div:first");
        if ("" != value) {
            sibling.text(value);
        }
        sibling.fadeIn();
        currObj.addClass("hidden");
    };

    addNew = function () {
        fcom.ajax(fcom.makeUrl('Seller', "addSpecialPriceForm"), "", function (t) {
            $.ykmodal(t.html);
            fcom.removeLoader();
        }, { fOutMode: 'json' });
    };
})();
