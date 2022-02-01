(function () {
    trackInventory = function (el) {
        if ($(el).prop("checked") == false) {
            $("#selprod_threshold_stock_level").val(0).attr("disabled", "disabled");
        } else {
            $("#selprod_threshold_stock_level").removeAttr("disabled");
        }
    };

    sellerProductDownloadFrm = function (selprod_id) {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "sellerProductDownloadFrm", [selprod_id]), '', function (t) {
            $.ykmodal(t.html, false, 'modal-dialog-vertical-md');
            getDigitalDownloads();
            fcom.removeLoader();
        });
    };

    getDigitalDownloads = function () {
        if (false === checkControllerName()) {
            return false;
        }
        var recordId = $('#frmDownload input[name=record_id]').val();
        var downloadType = $("#frmDownload select[name='download_type']").val();
        var langId = $("#frmDownload select[name='lang_id']").val();
        var optionCombi = "";
        if (0 < $("#frmDownload select[name='option_comb_id']").length) {
            optionCombi = $("#frmDownload select[name='option_comb_id']").val();
        }

        if (optionCombi == '') {
            optionCombi = '0';
        }
        var data = { recordId, download_type: downloadType, option_comb: optionCombi, langId: langId };
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'getInventoryDigitalDownloads'), data, function (res) {
            $("#digital_download_list").html(res.html);
        });
    }
})();

$(function () {
    $(document).on('change', "select[name='download_type']", function () {
        getDigitalDownloads();
    });
    $(document).on('change', "select[name='lang_id']", function () {
        getDigitalDownloads();
    });
});




