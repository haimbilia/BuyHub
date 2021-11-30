(function () {
    trackInventory = function (el) {
        if ($(el).prop("checked") == false) {
            $("#selprod_threshold_stock_level").val(0).attr("disabled", "disabled");
        } else {
            $("#selprod_threshold_stock_level").removeAttr("disabled");
        }
    };
})();

