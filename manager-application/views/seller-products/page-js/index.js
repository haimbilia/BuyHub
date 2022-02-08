(function () {
  
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
    getUniqueSlugUrl = function(obj,str,recordId){
        if(str == ''){
            return;
        }
        var data = {url_keyword:str,recordId:recordId}
        fcom.ajax(fcom.makeUrl('SellerProducts', 'isProductRewriteUrlUnique'), data, function(t) { 
            var ans = $.parseJSON(t);
            $(obj).next().html(ans.msg);
            if(ans.status == 0){
                $(obj).next().removeClass('text-muted').addClass('text-danger');
            }else{
                $(obj).next().addClass('text-muted').removeClass('text-danger');
            }
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




