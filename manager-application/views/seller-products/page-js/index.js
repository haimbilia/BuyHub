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
        $.ykmodal(fcom.getLoader(), false, 'modal-dialog-vertical-md');
    
        fcom.ajax(fcom.makeUrl(controllerName, "sellerProductDownloadFrm",[selprod_id]), '', function (t) {
            $.ykmodal(t, false, 'modal-dialog-vertical-md');
            getDigitalDownloads();
            fcom.removeLoader();
        });
    };  

    getDigitalDownloads = function()
	{
        if (false === checkControllerName()) {
            return false;
        }
		var productId = $('#frmDownload input[name=product_id]').val();
		var selProdId = $('#frmDownload input[name=selprod_id]').val();
		var downloadType = $("#frmDownload select[name='download_type']").val();
		var langId = $("#frmDownload select[name='lang_id']").val();
		var optionCombi = "";
		if (0 < $("#frmDownload select[name='option_comb_id']").length) {
			optionCombi = $("#frmDownload select[name='option_comb_id']").val();
		}

		if (optionCombi == '') {
			optionCombi = '0';
		}
		var data = '&product_id=' + productId + '&selprod_id=' + selProdId + '&download_type=' + downloadType;
		data = data + '&option_comb=' + optionCombi + '&langId=' + langId;		
		fcom.ajax(fcom.makeUrl(controllerName, 'getInventoryDigitalDownloads'), data, function(res) {
			$("#digital_download_list").html(res);
		});
	}
})();

$(function() {
    $(document).on('change',"select[name='download_type']",function() { 
        getDigitalDownloads();
    });   
    $(document).on('change',"select[name='lang_id']",function() { 
        getDigitalDownloads();
    });  
});




