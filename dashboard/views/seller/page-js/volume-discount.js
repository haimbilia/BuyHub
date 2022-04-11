$(document).ready(function () {
    searchRecords(document.frmRecordSearch);
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
            fcom.makeUrl("Seller", "searchVolumeDiscountProducts"),
            data,
            function (res) {
                fcom.removeLoader();
                $("#listing").html(res);
            }
        );
    };
    clearSearch = function (selProd_id) {
        if (0 < selProd_id) {
            location.href = fcom.makeUrl("Seller", "volumeDiscount");
        } else {
            document.frmRecordSearch.reset();
            searchRecords(document.frmRecordSearch);
        }
    };
    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSearchVolumeDiscountPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    reloadList = function () {
        searchRecords(document.frmRecordSearch);
    };

    deleteSellerProductVolumeDiscount = function (voldiscount_id) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(
            fcom.makeUrl("Seller", "deleteSellerProductVolumeDiscount"),
            "voldiscount_id=" + voldiscount_id,
            function (t) {
                $("form#frmVolDiscountListing table tr#row-" + voldiscount_id).remove();
                if (1 > $("form#frmVolDiscountListing table tbody tr").length) {
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
        var data = fcom.frmData(document.getElementById("frmVolDiscountListing"));
        fcom.ajax(
            fcom.makeUrl("Seller", "deleteVolumeDiscountArr"),
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
    updateVolumeDiscountRow = function (frm, selProd_id) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(
            fcom.makeUrl("Seller", "updateVolumeDiscountRow"),
            data,
            function (t) {
                if (t.status == true) {
                    if (0 < selProd_id) {
                        if (1 > selProd_id) {
                            frm.elements["voldiscount_selprod_id"].value = "";
                        }
                        frm.reset();
                    }
                    document.getElementById("frmVolDiscountListing").reset();
                    $("table.volDiscountList-js tbody").prepend(t.data);
                    if (0 < $(".noResult--js").length) {
                        $(".noResult--js").remove();
                    }
                    $(frm).find("select[name='product_name']").trigger("change.select2");
                    searchRecords(document.frmRecordSearch);
                    closeForm();
                }
            }
        );
        return false;
    };

    addNew = function () {
        fcom.ajax(fcom.makeUrl('Seller', "addVolumeDiscountForm"), "", function (t) {
            $.ykmodal(t.html);
            fcom.removeLoader();
        }, { fOutMode: 'json' });
    };

    showOrignal = function (ele) {
        var obj = $(ele);
        var value = obj.attr('data-value');
        obj.text(value);
    }

    updateValues = function (ele) {
        var obj = $(ele);
        var attribute = obj.attr('name');
        var value = ele.textContent;
        var oldValue = obj.attr('data-value');
        var formattedValue = obj.attr('data-formated-value');
        var id = obj.attr('data-id');
        var selProdId = obj.attr('data-selprod-id');
        value = parseFloat(value);
        if (Number.isNaN(value)) {
            obj.text(formattedValue);
            fcom.displayErrorMessage(langLbl.notANumber);
            return;
        }
        oldValue = parseFloat(oldValue);


        if ('' != value && value != oldValue) {
            fcom.displayProcessing();
            var data = 'attribute=' + attribute + "&voldiscount_id=" + id + "&selProdId=" + selProdId + "&value=" + value;
            fcom.updateWithAjax(fcom.makeUrl("Seller", "updateVolumeDiscountColValue"), data, function (ans) { 
                if (ans.status != 1) {
                    value = oldValue;
                    updatedValue = formattedValue;
                } else {
                    updatedValue = ans.data.value;
                }
                obj.attr('data-value', value);
                obj.attr('data-formated-value', updatedValue);
                obj.text(updatedValue);
            });
        } else {
            obj.text(formattedValue);
        }
    };
})();
