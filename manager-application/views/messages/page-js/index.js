$(document).ready(function () {
    bindUserSelect2('searchFrmBuyerIdJs', { user_is_buyer: 1, deletedUser: 1});
    bindUserSelect2('searchFrmSellerIdJs', { user_is_seller: 1, deletedUser: 1});
    $('.listingRecordJs .listItemJs.is-active').trigger('click');
});

(function () {
    var dv = ".listingRecordJs";
    var listingTableJs = ".listingTableJs";
    bindUserSelect2 = function (element, postData) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), postData);
    }

    viewThread = function (obj) {
        var currEle = $(obj);
        var threadId = currEle.data('threadId');
        $('.listItemJs.is-active').removeClass('is-active');
        currEle.addClass('is-active');
        $('.threadJs').prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "viewThread", [threadId]), '', function (t) {
            fcom.closeProcessing();
            $('.userJs').remove();
            $('.threadJs').replaceWith(t.html);
        });
    };

    searchRecords = function (frm) {
        var data = "";
        if (frm) {
            data = fcom.frmData(frm);
        }

        $(listingTableJs).prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "search"), data, function (res) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $(dv).replaceWith(res.listingHtml);
            $('[data-thread-id=' + $('.threadJs').data('threadId') + ']').addClass('is-active');
        });
    };
})();